<?php
	function makeConnection(){
		$db_sid = "(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = Turab-PC)(PORT = 1521)))
		(CONNECT_DATA = (SID = orcl) ) )";
		$db_user = "scott";
		$db_pass = "1234";
		$con = oci_connect($db_user,$db_pass,$db_sid);
		if($con){
		//		echo "connection sussessful"."<br>";
		}
		else{
		//		echo ('Could not complete connection');
		}
		return $con;
	}
	session_start();
	$con = makeConnection();
    
    
	$CHILD_ID = "";
	$NAME = "";
	$AGE = "";
	$GENDER = "";
	$COUNTER = 0;
	
	$EDIT_ARRAY[0] = 0;
	$DELETE_ARRAY[0] = 0;
	$STU_ID_ARRAY[0] = 0;
?>

<!DOCTYPE html>
    <head>
	    <!-- Add icon library -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
        <title>Students List</title>
        <style>
			div.a
			{
				text-align: center;
			}
			textarea
			{
				resize: none;
			}
			fieldset {
				display:flex;
				margin-left: 50px;
				margin-right: 50px;
				padding-top: 0em;
				padding-bottom: 0em;
				padding-left: 0.75em;
				height: auto;
				padding-bottom:2rem;
				padding-right: 0.75em;
				border: 1px solid green;
				background-color: rgba(0, 0, 0, .8);
				text-shadow: 2px 2px black;
			}
			input {
				color: whitesmoke;
			}
		</style>
		<link rel="stylesheet" href="./Form_Style.css">
    </head>

<body style="color: lightcoral;overflow:auto;background-image: url('./assets/img3.png');background-repeat: no-repeat;background-size: 100% 100%;background-attachment: fixed;">
        <div class = "a">
            <h1><b>Hamarey Bachchay</b></h1>
            <h1><b>Students List Per Class</b></h1>
        </div>

        <form action="" method="POST" id="INN">

			<fieldset style="font-size: x-large;">
				<legend style="color:yellow;">Students List</legend>
				<center>
				<br>
				<table>
					<tr>
						<td style="border-bottom: 0px">
							<div class="form-group">
								<input type="text" placeholder="Search" name="SEARCH_FEILD" style='border-radius: 10px; background-color: transparent;'>
								<input type="submit" name="SEARCH" value="Search the Student" class='btn' style='width:auto;'>
								
							</div>
						</td>
						<td style="border-bottom: 0px;">
							<select name="Stype" id="INN">
								<option value="Sname">Name</option>
								<option value="Sid">ID</option>
							</select>
						</td>
						<td style="border-bottom: 0px"><a href="Student_List.php" style="color: white;text-decoration:none"><button type="button" class="btn btn-login">CLEAR_SEARCH</button></a><br></td>
						<td style="border-bottom: 0px"><a href="Unregistered_Student.php" style="color: white;text-decoration:none"><button type="button" class="btn btn-login">REGISTER A STUDENT</button></a><br></td>
					</tr>
					<?php
						// query to get children w.r.t.sections and all their desired info
						$q='';
						if(isset($_POST['SEARCH'])){
							if($_POST['Stype']=='Sname'){
								$q = "
									SELECT SEC.CLASS_ID CLASS, SEC.SECTION_ID SECTION, SEC.TITLE TITLE, AD.STUDENT_ID STUDENT_ID, C.NAME NAME, C.AGE AGE, C.GENDER GENDER
									FROM HB_ADMITTED_STUDENT AD, HB_SECTION SEC, HB_REGISTERATION R, HB_CLASS_ASSIGNMENT CA, HB_CHILD C
									WHERE NAME LIKE '%".$_POST['SEARCH_FEILD']."%' AND AD.STUDENT_ID = R.STUDENT_ID AND CA.REG_ID = R.REG_ID AND SEC.CLASS_ID = CA.CLASS_ID AND SEC.SECTION_ID = CA.SECTION_ID AND C.CHILD_ID = AD.CHILD_ID
									ORDER BY SEC.CLASS_ID, SEC.SECTION_ID";
							}else{
								$q = "
									SELECT SEC.CLASS_ID CLASS, SEC.SECTION_ID SECTION, SEC.TITLE TITLE, AD.STUDENT_ID STUDENT_ID, C.NAME NAME, C.AGE AGE, C.GENDER GENDER
									FROM HB_ADMITTED_STUDENT AD, HB_SECTION SEC, HB_REGISTERATION R, HB_CLASS_ASSIGNMENT CA, HB_CHILD C
									WHERE AD.STUDENT_ID = '".$_POST['SEARCH_FEILD']."' AND AD.STUDENT_ID = R.STUDENT_ID AND CA.REG_ID = R.REG_ID AND SEC.CLASS_ID = CA.CLASS_ID AND SEC.SECTION_ID = CA.SECTION_ID AND C.CHILD_ID = AD.CHILD_ID
									ORDER BY SEC.CLASS_ID, SEC.SECTION_ID";
							}
						}
						else{
							$q = "
								SELECT SEC.CLASS_ID CLASS, SEC.SECTION_ID SECTION, SEC.TITLE TITLE, AD.STUDENT_ID STUDENT_ID, C.NAME NAME, C.AGE AGE, C.GENDER GENDER
								FROM HB_ADMITTED_STUDENT AD, HB_SECTION SEC, HB_REGISTERATION R, HB_CLASS_ASSIGNMENT CA, HB_CHILD C
								WHERE AD.STUDENT_ID = R.STUDENT_ID AND CA.REG_ID = R.REG_ID AND SEC.CLASS_ID = CA.CLASS_ID AND SEC.SECTION_ID = CA.SECTION_ID AND C.CHILD_ID = AD.CHILD_ID
								ORDER BY SEC.CLASS_ID, SEC.SECTION_ID, AD.STUDENT_ID";
						}
						$query_id = oci_parse($con, $q);
						$r = oci_execute($query_id);

						$PREVCLASS = '';
						$PREVSEC = '';
						
						// get all the rows individually
						while($row = oci_fetch_array($query_id, OCI_BOTH+OCI_RETURN_NULLS)){
							$CLASS = $row['CLASS'];
							$SECTION = $row['SECTION'];
							$TITLE = $row['TITLE'];
							$STUDENT_ID = $row['STUDENT_ID'];
							$NAME = $row['NAME'];
							$AGE = $row['AGE'];
							$GENDER = $row['GENDER'];

							$STU_ID_ARRAY[$COUNTER] = $STUDENT_ID;
							$DELETE_ARRAY[$COUNTER] = $COUNTER;
							$EDIT_ARRAY[$COUNTER] = $COUNTER;

							// only print class row in html when new class/section encountered
							if($CLASS!=$PREVCLASS || $SECTION!=$PREVSEC){
								
								// query to get children count in sections
								$qClassTotal = "SELECT * FROM CLASS_STUDENTS WHERE CLASS_ID=".$CLASS." AND SECTION='".$SECTION."'";
								$query_id2 = oci_parse($con, $qClassTotal);
								$r2 = oci_execute($query_id2);									
								
								// get the count of children in current class
								if($rowTemp = oci_fetch_array($query_id2, OCI_BOTH+OCI_RETURN_NULLS)){
									$countPerSection = $rowTemp['COUNT'];						
								}
								
								echo "
									<tr>
										<td style='color:white;border-top:1px solid white;'>Class: ".$CLASS."".$SECTION."</label></td>
										<td style='color:white;border-top:1px solid white;'>Title: ".$TITLE."</label></td>
										<td style='color:white;border-top:1px solid white;'> (".$countPerSection." total):</td>
										<td style='color:white;border-top:1px solid white;'></td>
									</tr>
								";
							}
							
						   
							// print indivduial students
							echo "
								<tr>
									<td style='border-radius: 10px;'><label for='id'>ID: </label><input id='id' style='border-radius: 10px; background-color: transparent;' type='text' placeholder=' ID' name='id' value=' ".$STUDENT_ID."' READONLY></td>
									<td style='border-radius: 10px;'><label for='name'>NAME: </label><input id='name' style='border-radius: 10px; background-color: transparent;' placeholder=' NAME' name='name' value=' ".$NAME."'></td>
									<td style='border-radius: 10px;'><label for='age'>AGE: </label><input id='age' style='border-radius: 10px; background-color: transparent;' type='text' placeholder=' AGE' name='age' value=' ".$AGE."'></td>
									<td style='border-radius: 10px;'><label for='gender'>GENDER: </label><input id='gender' style='border-radius: 10px; background-color: transparent;' type='text' placeholder=' GENDER' name='gender' value=' ".$GENDER."'></td>
									<td><button type='submit' class='btn btn-login' name='".$COUNTER."'><i class='fa fa-pencil-square-o'></i></button></td>
									<td><button type='submit' class='btn btn-login' name='-".$COUNTER."'><i class='fa fa-trash'></i></button></td>
								</tr>
							";
							$COUNTER++;
							// update previous class and sections
							$PREVCLASS = $CLASS;
							$PREVSEC = $SECTION;
							
						}
						/*SELECT SEC.CLASS_ID CLASS, SEC.SECTION_ID SECTION, C.GENDER, COUNT(C.GENDER) COUNT
							FROM HB_ADMITTED_STUDENT AD, HB_SECTION SEC, HB_REGISTERATION R, HB_CLASS_ASSIGNMENT CA, HB_CHILD C
							WHERE AD.STUDENT_ID = R.STUDENT_ID AND CA.REG_ID = R.REG_ID AND SEC.CLASS_ID = CA.CLASS_ID AND SEC.SECTION_ID = CA.SECTION_ID AND C.CHILD_ID = AD.CHILD_ID
							GROUP BY SEC.CLASS_ID, SEC.SECTION_ID, C.GENDER
							ORDER BY SEC.CLASS_ID, SEC.SECTION_ID;*/
					?>
				</table>			
			</fieldset>
			<br><br>
			</center>     
			<br><br>
			<center>
				<a href="Admission.php" style="color: white;text-decoration:none"><button type="button" class="btn btn-login" style="margin-left: 2rem;"> Admit A New Student </button></a>
				<a href="home_page.html" style="color: white;text-decoration:none"><button type="button" class="btn btn-login" style="margin-left: 2rem;">GO BACK </button></a>        
			</center>
        </form>
       <br><br><br><br>
    </body>


</html>
<?php
	$i=0;
	while($COUNTER>$i){
		$x='-'.$i;
		if(isset($_POST[$x])){
			$q = "SELECT REG_ID FROM HB_REGISTERATION WHERE STUDENT_ID='".$STU_ID_ARRAY[$i]."'";
			$query_id = oci_parse($con, $q); 
			$r = oci_execute($query_id);
			if(!$r){
				echo "Couldn't delete";
			}
			else{
				$r = oci_fetch_array($query_id, OCI_BOTH);
			}
			
			$q = "SELECT CHILD_ID FROM HB_ADMITTED_STUDENT WHERE STUDENT_ID='".$STU_ID_ARRAY[$i]."'";
			$query_id = oci_parse($con, $q); 
			$r1 = oci_execute($query_id);
			if(!$r1){
				echo "Couldn't delete";
			}
			else{
				$r1 = oci_fetch_array($query_id, OCI_BOTH);
			}
			
			deleteRow('HB_CLASS_ASSIGNMENT', 'REG_ID', $r['REG_ID'], 1);
			deleteRow('HB_REGISTERATION', 'REG_ID', $r['REG_ID'], 1);
			deleteRow('HB_ACCOMPAY_RECORD', 'STUDENT_ID', $STU_ID_ARRAY[$i], 1);
			deleteRow('HB_NEW_CLASS_ASSIGNMENT', 'STUDENT_ID', $STU_ID_ARRAY[$i], 1);
			deleteRow('HB_ADMITTED_STUDENT', 'STUDENT_ID', $STU_ID_ARRAY[$i], 1);
            deleteRow('HB_CHILD', 'CHILD_ID', $r1['CHILD_ID'], 0);
            echo "<meta http-equiv ='refresh' content='0; url=Student_List.php'/>";
			
		}
		else if(isset($_POST[$i])){
            $_SESSION['A'] = $STU_ID_ARRAY[$i];
			echo "<meta http-equiv ='refresh' content='0; url=Update_Child.php'/>";
		}
		$i++;
	}
	
	
	
	function deleteRow($TABLE_NAME, $COLUMN_NAME, $VALUE, $FLAG){
		$con = makeConnection();
		$q='';
		if($FLAG==0){
			$q = "DELETE FROM ".$TABLE_NAME." WHERE ".$COLUMN_NAME."=".$VALUE;
		}
		else{
			$q = "DELETE FROM ".$TABLE_NAME." WHERE ".$COLUMN_NAME."='".$VALUE."'";
		}
        $query_id = oci_parse($con, $q);
        $r = oci_execute($query_id);
		if(!$r){
			echo "Couldn't delete";
        }
    }
?>

