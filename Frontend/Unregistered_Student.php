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
	
	$con = makeConnection();

	session_start();

	$STUDENT_ID = "";
	$MOMMY = "";
	$DADDY = "";
	$GUARDIAN = "";
	$CHILD = "";
	$JOIN_DATE = "";
	$COUNTER = 0;
	$STU_ID_ARRAY[0] = 0;
	$ADD_ARRAY[0] = 0;	
	
	
?>

<html>

    <head>
	    <!-- Add icon library -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
        <title>Unregistered Students</title>
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
            <h1><b>Unregistered Students</b></h1>
        </div>

        <form method="post" id="inn">   
        <fieldset style="font-size: x-large;">
            <legend style="color:yellow;">Students List</legend>
        <br>
        <center>
        
		
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
				<td style="border-bottom: 0px"><a href="Unregistered_Student.php" style="color: white;text-decoration:none"><button type="button" class="btn btn-login">CLEAR SEARCH</button><br></td>
			</tr>
			<?php
				// query to get children w.r.t.sections and all their desired info
				$q='';
				if(isset($_POST['SEARCH'])){
					if($_POST['Stype']=='Sname'){
						$q = "SELECT AD.STUDENT_ID, C.CHILD, C.MOMMY, C.DADDY, C.GUARDIAN, AD.JOIN_DATE FROM CHILD_INFO C,hb_admitted_student AD 
						LEFT OUTER JOIN HB_REGISTERATION R ON (AD.STUDENT_ID = R.STUDENT_ID)
						WHERE R.STUDENT_ID IS NULL AND AD.STUDENT_ID = C.stu_id AND C.CHILD LIKE '%".$_POST['SEARCH_FEILD']."%'";
					}else{
						$q = "SELECT AD.STUDENT_ID, C.CHILD, C.MOMMY, C.DADDY, C.GUARDIAN, AD.JOIN_DATE FROM CHILD_INFO C,hb_admitted_student AD 
						LEFT OUTER JOIN HB_REGISTERATION R ON (AD.STUDENT_ID = R.STUDENT_ID)
						WHERE R.STUDENT_ID IS NULL AND AD.STUDENT_ID = C.stu_id AND AD.STUDENT_ID LIKE '%".$_POST['SEARCH_FEILD']."%'";
					}
				}
				else{
					$q = "SELECT AD.STUDENT_ID, C.CHILD, C.MOMMY, C.DADDY, C.GUARDIAN, AD.JOIN_DATE FROM CHILD_INFO C,hb_admitted_student AD LEFT OUTER JOIN HB_REGISTERATION R ON (AD.STUDENT_ID = R.STUDENT_ID) WHERE R.STUDENT_ID IS NULL AND AD.STUDENT_ID = C.stu_id";
				}
				$query_id = oci_parse($con, $q);
				$r = oci_execute($query_id);
				
				// get all the rows individually
				while($row = oci_fetch_array($query_id, OCI_BOTH+OCI_RETURN_NULLS)){
					$STUDENT_ID = $row['STUDENT_ID'];
					$MOMMY = $row['MOMMY'];
					$DADDY = $row['DADDY'];
					$GUARDIAN = $row['GUARDIAN'];
					$CHILD = $row['CHILD'];
					$JOIN_DATE = $row['JOIN_DATE'];

					$STU_ID_ARRAY[$COUNTER] = $STUDENT_ID;
					$ADD_ARRAY[$COUNTER] = $COUNTER;
				   
					// print indivduial students
					echo "
						<tr>
							<td style='border-radius: 10px;'><label for='id'>ID: </label><input id='id' style='border-radius: 10px; background-color: transparent;' type='text' placeholder=' ID' name='id' value=' ".$STUDENT_ID."' READONLY></td>
							<td style='border-radius: 10px;'><label for='child'>CHILD: </label><input id='child' style='border-radius: 10px; background-color: transparent;' placeholder=' CHILD' name='child' value=' ".$CHILD."'></td>
							<td style='border-radius: 10px;'><label for='mother'>MOTHER: </label><input id='mother' style='border-radius: 10px; background-color: transparent;' placeholder=' MOTHER' name='mother' value=' ".$MOMMY."'></td>
							<td style='border-radius: 10px;'><label for='father'>FATHER: </label><input id='father' style='border-radius: 10px; background-color: transparent;' type='text' placeholder=' FATHER' name='father' value=' ".$DADDY."'></td>
							<td style='border-radius: 10px;'><label for='join_date'>Join Date: </label><input id='join_date' style='border-radius: 10px; background-color: transparent;' type='text' placeholder=' Join Date' name='join_date' value=' ".$JOIN_DATE."'></td>
							<td><button type='submit' class='btn btn-login' name='".$COUNTER."'><i class='fa fa-pencil-square-o'></i></button></td>
							<td><button type='submit' class='btn btn-login' name='-".$COUNTER."'><i class='fa fa-plus'></i></button></td>
						</tr>
					";
					$COUNTER++;
				}
			?>
		</table>
        </fieldset>

        <br><br>
        
        </center>       
        </fieldset>
        <br><br>
        <center>
            <a href="Admission.php" style="color: white;text-decoration:none"><button type="button" class="btn btn-login" style="margin-left: 2rem;"> Admit A New Student </button></a>
            <a href="Student_List.php" style="color: white;text-decoration:none"><button type="button" class="btn btn-login" style="margin-left: 2rem;"> Go Back </button></a>
        </center>
        </form>
       <br><br><br><br>
    </body>

	<?php
		$i=0;
		while($COUNTER>$i){
			$x='-'.$i;
			if(isset($_POST[$x])){
				$_SESSION['B'] = $STU_ID_ARRAY[$i];
				echo "<meta http-equiv ='refresh' content='0; url=Registeration.php'/>";
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

</html>