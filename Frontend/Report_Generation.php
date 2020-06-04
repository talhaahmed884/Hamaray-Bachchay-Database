<?php
	//ESTABLISH CONNECTION
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
	
	
		/*TODO: FORMAT REPORT AND REMOVE RUNTIME ERRORS*/

?>

<html>

    <head>
        <title>Class Creation Form</title>
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
                padding-bottom: 2rem;
                padding-left: 0.75em;
                height: auto;
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
            <h1><b>Report Generation</b></h1>
        </div>
        <form method="post" id="inn"> 

			<fieldset style="font-size: x-large;">
				<legend style="color:yellow;">Report 2</legend>
			<br>
			<center>
			<?php
				if(isset($_POST['S2'])){
					$q = "SELECT SEC.CLASS_ID CLASS, SEC.SECTION_ID SECTION, SEC.TITLE, C.GENDER, COUNT(C.GENDER) COUNT
					FROM HB_ADMITTED_STUDENT AD, HB_SECTION SEC, HB_REGISTERATION R, HB_CLASS_ASSIGNMENT CA, HB_CHILD C
					WHERE SEC.TITLE LIKE '%".$_POST['R2']."%' AND AD.STUDENT_ID = R.STUDENT_ID AND CA.REG_ID = R.REG_ID AND SEC.CLASS_ID = CA.CLASS_ID AND SEC.SECTION_ID = CA.SECTION_ID AND C.CHILD_ID = AD.CHILD_ID
					GROUP BY SEC.CLASS_ID, SEC.SECTION_ID, C.GENDER, SEC.TITLE
					ORDER BY SEC.CLASS_ID, SEC.SECTION_ID";					
				}
				else{
					$q = "SELECT SEC.CLASS_ID CLASS, SEC.SECTION_ID SECTION, SEC.TITLE, C.GENDER, COUNT(C.GENDER) COUNT
					FROM HB_ADMITTED_STUDENT AD, HB_SECTION SEC, HB_REGISTERATION R, HB_CLASS_ASSIGNMENT CA, HB_CHILD C
					WHERE AD.STUDENT_ID = R.STUDENT_ID AND CA.REG_ID = R.REG_ID AND SEC.CLASS_ID = CA.CLASS_ID AND SEC.SECTION_ID = CA.SECTION_ID AND C.CHILD_ID = AD.CHILD_ID
					GROUP BY SEC.CLASS_ID, SEC.SECTION_ID, C.GENDER, SEC.TITLE
					ORDER BY SEC.CLASS_ID, SEC.SECTION_ID";
				}
				$query_id = oci_parse($con, $q);
				$r = oci_execute($query_id);
				
				echo "
				<div class='form-group'>
					<input type='text' placeholder='Search By Class Title' name='R2' style='border-radius: 10px; background-color: transparent;'>
					<input type='submit' value='Search the Student' name='S2' class='btn' style='width:auto;'>
				</div>
				<table style='width:100%;'>
					<tr>
						<td style='color:white;border-top:1px solid white;colspan:20px'>Class</label></td>
						<td style='color:white;border-top:1px solid white;'>Section</label></td>
						<td style='color:white;border-top:1px solid white;'>Title</td>
						<td style='color:white;border-top:1px solid white;'>Gender</td>
						<td style='color:white;border-top:1px solid white;'>Count</td>
					</tr>
				";
				// get all the rows individually
				while($row = oci_fetch_array($query_id, OCI_BOTH+OCI_RETURN_NULLS)){			
					echo '<tr><td>'.$row['CLASS']."</td><td>".$row['SECTION']."</td><td>".$row['TITLE']."</td><td>".$row['GENDER']."</td><td>".$row['COUNT']."</td></tr>";
				}
				echo '</table>'
			?>
			</center>
			</fieldset>			
			

			<fieldset style="font-size: x-large;">
				<legend style="color:yellow;">Report 3</legend>
			<br>
			<center>
			<?php
				if(isset($_POST['S3'])){
					if($_POST['SR3'] == 'SMONTH'){
						$q = "SELECT AD.STUDENT_ID,SYSDATE, AD.JOIN_DATE
						FROM HB_ADMITTED_STUDENT AD LEFT JOIN HB_REGISTERATION R
						ON (R.STUDENT_ID = AD.STUDENT_ID)
						WHERE R.STUDENT_ID IS NULL AND MONTHS_BETWEEN(SYSDATE, AD.JOIN_DATE) > ".$_POST['R3']."
						ORDER BY AD.STUDENT_ID";
					}
					else{
						$YEAR = $_POST['R3'] * 12;
						$q = "SELECT AD.STUDENT_ID,SYSDATE, AD.JOIN_DATE
						FROM HB_ADMITTED_STUDENT AD LEFT JOIN HB_REGISTERATION R
						ON (R.STUDENT_ID = AD.STUDENT_ID)
						WHERE R.STUDENT_ID IS NULL AND MONTHS_BETWEEN(SYSDATE, AD.JOIN_DATE) >  ".$YEAR."
						ORDER BY AD.STUDENT_ID";
					}
				}
				else{
					$q = "SELECT AD.STUDENT_ID,SYSDATE, AD.JOIN_DATE FROM HB_ADMITTED_STUDENT AD LEFT JOIN HB_REGISTERATION R ON (R.STUDENT_ID = AD.STUDENT_ID)
							WHERE R.STUDENT_ID IS NULL AND MONTHS_BETWEEN(SYSDATE, AD.JOIN_DATE) > 12
							ORDER BY AD.STUDENT_ID";
				}
				$query_id = oci_parse($con, $q);
				$r = oci_execute($query_id);
				echo "
				<div class='form-group'>
					<input type='text' placeholder='Search' name='R3' style='border-radius: 10px; background-color: transparent;'>
					<select name='SR3'>
						<option value='SMONTH'>Month</option>
						<option value='SYEAR'>Year</option>
					</select>							
					<input type='submit' value='Search the Student' name='S3' class='btn' style='width:auto;'>
				</div>
				<table style='width:100%;'>
					<tr>
						<td style='color:white;border-top:1px solid white;colspan:20px'>Student_ID</label></td>
						<td style='color:white;border-top:1px solid white;'>JOIN_DATE</label></td>
					</tr>
				";
				// get all the rows individually
				while($row = oci_fetch_array($query_id, OCI_BOTH+OCI_RETURN_NULLS)){			
					echo '<tr><td>'.$row['STUDENT_ID']."</td><td>".$row['JOIN_DATE']."</td></tr>";
				}
				echo '</table>';
			?>
			</center>
			</fieldset>			


			<fieldset style="font-size: x-large;">
				<legend style="color:yellow;">Report 4</legend>
			<br>
			<center>
			<?php
				if(isset($_POST['S4'])){
					if($_POST['SR4'] == 'SID'){
						$q = "SELECT CI.STU_ID, CI.CHILD, CI.MOMMY, CI.DADDY, CI.GUARDIAN, CAH.CLASS_ID, CAH.SECTION_ID
						FROM CHILD_INFO CI, HB_CLASS_ASSIGNMENT_HIST CAH, HB_REGISTERATION R
						WHERE CI.STU_ID LIKE '".$_POST['R4']."' AND CI.STU_ID = R.STUDENT_ID AND R.REG_ID = CAH.REG_ID AND R.STUDENT_ID = 'HB-0015'
						ORDER BY STU_ID";
					}
					else{
						$q = "SELECT CI.STU_ID, CI.CHILD, CI.MOMMY, CI.DADDY, CI.GUARDIAN, CAH.CLASS_ID, CAH.SECTION_ID
						FROM CHILD_INFO CI, HB_CLASS_ASSIGNMENT_HIST CAH, HB_REGISTERATION R
						WHERE CI.CHILD LIKE '".$_POST['R4']."' AND CI.STU_ID = R.STUDENT_ID AND R.REG_ID = CAH.REG_ID AND R.STUDENT_ID = 'HB-0015'
						ORDER BY STU_ID";
					}
				}
				else{				
					$q = "SELECT CI.STU_ID, CI.CHILD, CI.MOMMY, CI.DADDY, CI.GUARDIAN, CAH.CLASS_ID, CAH.SECTION_ID
					FROM CHILD_INFO CI, HB_CLASS_ASSIGNMENT_HIST CAH, HB_REGISTERATION R
					WHERE CI.STU_ID = R.STUDENT_ID AND R.REG_ID = CAH.REG_ID AND R.STUDENT_ID = 'HB-0015'
					ORDER BY STU_ID";
				}
				$query_id = oci_parse($con, $q);
				$r = oci_execute($query_id);
				echo "
				<div class='form-group'>
					<input type='text' placeholder='Search' name='R4' style='border-radius: 10px; background-color: transparent;'>
					<select name='SR4'>
						<option value='SNAME'>Name</option>
						<option value='SID'>ID</option>
					</select>
					<input type='submit' value='Search the Student' name='S4' class='btn' style='width:auto;'>
				</div>
				<table style='width:100%;'>
					<tr>
						<td style='color:white;border-top:1px solid white;colspan:20px'>Stu_ID</label></td>
						<td style='color:white;border-top:1px solid white;'>Name</label></td>
						<td style='color:white;border-top:1px solid white;'>Mother</label></td>
						<td style='color:white;border-top:1px solid white;'>Father</label></td>
						<td style='color:white;border-top:1px solid white;'>Guardian</label></td>
						<td style='color:white;border-top:1px solid white;'>Class</label></td>
						<td style='color:white;border-top:1px solid white;'>Section</label></td>
					</tr>
				";
				// get all the rows individually
				while($row = oci_fetch_array($query_id, OCI_BOTH+OCI_RETURN_NULLS)){			
					echo '<tr><td>'.$row['STU_ID']."</td><td>".$row['CHILD']."</td><td>".$row['MOMMY']."</td><td>".$row['DADDY']."</td><td>".$row['GUARDIAN']."</td><td>".$row['CLASS_ID']."</td><td>".$row['SECTION_ID']."</td></tr>";
				}
				echo '</table>';
			?>
			</center>
			</fieldset>

			<fieldset style="font-size: x-large;">
				<legend style="color:yellow;">Report 5</legend>
			<br>
			<center>
			<?php
				if(isset($_POST['S5'])){
					if($_POST['SR5'] == 'SID'){
						$q = "SELECT AD.PARENT_ID, AD.STUDENT_ID, C.NAME, P.DADDY, P.MOMMY, SEC.CLASS_ID, SEC.SECTION_ID SECTION
							FROM HB_ADMITTED_STUDENT AD, HB_SECTION SEC, HB_REGISTERATION R, HB_CLASS_ASSIGNMENT CA, HB_CHILD C, PARENTS P
							WHERE AD.PARENT_ID = ".$_POST['R5']." AND AD.STUDENT_ID = R.STUDENT_ID AND CA.REG_ID = R.REG_ID AND SEC.CLASS_ID = CA.CLASS_ID AND SEC.SECTION_ID = CA.SECTION_ID AND C.CHILD_ID = AD.CHILD_ID AND P.PARENT_ID = AD.PARENT_ID
							ORDER BY P.DADDY, P.MOMMY, AD.STUDENT_ID";
					}
					else{
						$q = "SELECT AD.PARENT_ID, AD.STUDENT_ID, C.NAME, P.DADDY, P.MOMMY, SEC.CLASS_ID, SEC.SECTION_ID SECTION
							FROM HB_ADMITTED_STUDENT AD, HB_SECTION SEC, HB_REGISTERATION R, HB_CLASS_ASSIGNMENT CA, HB_CHILD C, PARENTS P
							WHERE (P.MOMMY LIKE '%".$_POST['R5']."%' OR P.DADDY LIKE '%".$_POST['R5']."%') AND AD.STUDENT_ID = R.STUDENT_ID AND CA.REG_ID = R.REG_ID AND SEC.CLASS_ID = CA.CLASS_ID AND SEC.SECTION_ID = CA.SECTION_ID AND C.CHILD_ID = AD.CHILD_ID AND P.PARENT_ID = AD.PARENT_ID
							ORDER BY P.DADDY, P.MOMMY, AD.STUDENT_ID";
					}
				}
				else{				
					$q = "SELECT AD.PARENT_ID, P.DADDY, P.MOMMY, AD.STUDENT_ID, C.NAME, SEC.CLASS_ID, SEC.SECTION_ID SECTION
						FROM HB_ADMITTED_STUDENT AD, HB_SECTION SEC, HB_REGISTERATION R, HB_CLASS_ASSIGNMENT CA, HB_CHILD C, PARENTS P
						WHERE AD.STUDENT_ID = R.STUDENT_ID AND CA.REG_ID = R.REG_ID AND SEC.CLASS_ID = CA.CLASS_ID AND SEC.SECTION_ID = CA.SECTION_ID AND C.CHILD_ID = AD.CHILD_ID AND P.PARENT_ID = AD.PARENT_ID
						ORDER BY P.DADDY, P.MOMMY, AD.STUDENT_ID";
				}
				$query_id = oci_parse($con, $q);
				$r = oci_execute($query_id);
				echo "
				<div class='form-group'>
					<input type='text' placeholder='Search' name='R5' style='border-radius: 10px; background-color: transparent;'>
					<select name='SR5'>
						<option value='SNAME'>Name</option>
						<option value='SID'>ID</option>
					</select>
					<input type='submit' value='Search the Student' name='S5' class='btn' style='width:auto;'>
				</div>				
				<table style='width:100%;'>
					<tr>
						<td style='color:white;border-top:1px solid white;'>Parent ID</label></td>
						<td style='color:white;border-top:1px solid white;'>Father</label></td>
						<td style='color:white;border-top:1px solid white;'>Mother</label></td>
						<td style='color:white;border-top:1px solid white;colspan:20px'>Stu_ID</label></td>
						<td style='color:white;border-top:1px solid white;'>Name</label></td>						
						<td style='color:white;border-top:1px solid white;'>Class</label></td>
						<td style='color:white;border-top:1px solid white;'>Section</label></td>
					</tr>
				";
				// get all the rows individually
				while($row = oci_fetch_array($query_id, OCI_BOTH+OCI_RETURN_NULLS)){
					echo '<tr><td>'.$row['PARENT_ID']."</td><td>".$row['DADDY']."</td><td>".$row['MOMMY']."</td><td>".$row['STUDENT_ID']."</td><td>".$row['NAME']."</td><td>".$row['CLASS_ID']."</td><td>".$row['SECTION']."</td></tr>";
				}
				echo '</table>';
			?>
			</center>
			</fieldset>
			
			<br><br>
			<center>
				<a href="home_page.html" style="color: white;text-decoration:none"><button type="button" class="btn btn-login" style="margin-left: 2rem;"> Go Back </button></a>
			</center>
        </form>
       <br><br><br><br>
    </body>

	
	<?php
		function parseQuery($query){
			$con = makeConnection();
			$query_id = oci_parse($con,$query);
			$query_execute = oci_execute($query_id);
		}		
	?>

</html>