<?php
    // ESTABLISH CONNECTION
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
	
	$STU_ID = $_SESSION['B'];
	
	//UPDATE REG_ID
	$REG_ID = makeCounter('HB_REGISTERATION', 'RR-');
	
	//DETERMINE COURSE_ID
	$query = "select COURSE_ID from HB_REGISTERATION";
	$data = parseQuery($query);
	$COURSE_ID = $data['COURSE_ID'];

	//EXTRACT AGE THROUGH COMPLET CHID INFO
	$query = "select CAGE from COMPLETE_CHILD_INFO WHERE STU_ID='".$STU_ID."'";
	$data = parseQuery($query);
	$AGE = $data['CAGE'];
	//DETERMINE CLASS FROM AGE
	$CLASS_ID = $AGE - 2;
	
	//DETERMINE REG_CHALLAN_NUM
	$REG_CHALLAN_NUM = makeCounter('HB_REGISTERATION', 'RC-1');
	
	$SECTION_ID= "";
	$REG_FEE_AMOUNT = "";
	$REG_DISCOUNT = "";
	$REG_FINAL_AMOUNT = "";
	$REG_FEE_PAID = "";
	$REG_DATE = "";
	
?>

<html>

    <head>
        <title>Registeration Form</title>
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
                margin-left: 350px;
                margin-right: 350px;
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
            <h1><b>Registeration Form</b></h1>
        </div>

        <form method="post" id="inn">   
        <fieldset style="font-size: x-large;">
            <legend style="color:yellow;">Registeration Information</legend>
        <br>
        <center>
        <table>
            <tr>
                <td width=250>
                    <center><b> Student ID </b></center>
                </td>
                <td width=250>
                        <center>
                        <div class="form-group" style="font-size:x-large;border:2px grey solid">
                                <input type="text" placeholder="HB-XXXX" required class="form-input" name="student_id" value=<?php echo '"'.$STU_ID.'"';?> READONLY>
                        </div>
                        </center>

                </td>
            </tr>		
            <tr>
                <td width=250>
                    <center><b> Registeration ID </b></center>
                </td>
                <td width=250>
                        <center>
                        <div class="form-group" style="font-size:x-large;border:2px grey solid">
                                <input type="text" placeholder="RR-XXXX" required class="form-input" name="reg_id" value=<?php echo '"'.$REG_ID.'"';?> READONLY>
                        </div>
                        </center>

                </td>
            </tr>
            <tr>
                <td width=250>
                    <center><b> Course ID </b></center>
                </td>
                <td width=250>
                        <center>
                        <div class="form-group" style="font-size:x-large;border:2px grey solid">
                                <input type="text" placeholder="Course ID" required class="form-input" name="course_id" value=<?php echo '"'.$COURSE_ID.'"';?> READONLY>
                        </div>
                        </center>

                </td>
            </tr>
            <tr>
                <td width=250>
                    <center><b> Class ID </b></center>
                </td>
                <td width=250>
                        <center>
                        <div class="form-group" style="font-size:x-large;border:2px grey solid">
                                <input type="text" placeholder="CLASS ID" required class="form-input" name="class_id" value=<?php echo '"'.$CLASS_ID.'"';?> READONLY>
                        </div>
                        </center>

                </td>
            </tr>
            <tr>
                <td width=250>
                    <center><b> Section ID </b></center>
                </td>
                <td width=250>
                        <center>
                        <div class="form-group" style="font-size:x-large;border:2px grey solid">
                                <input type="text" placeholder="SECTION ID" required class="form-input" name="section_id" value=<?php if ($_POST){ echo $_POST['section_id'];} else{ echo "";}?>>
                        </div>
                        </center>

                </td>
            </tr>
            <tr>
                <td width=250>
                    <center><b> Registeration Challan Num </b></center>
                </td>
                <td width=250>
                        <center>
                        <div class="form-group" style="font-size:x-large;border:2px grey solid">
                                <input type="text" placeholder="Registeration Challan Num" required class="form-input" name="reg_challan_num" value=<?php echo '"'.$REG_CHALLAN_NUM.'"';?> READONLY>
                        </div>
                        </center>

                </td>
            </tr>
            <tr>
                <td width=250>
                    <center><b> Registeration Fee Amount </b></center>
                </td>
                <td width=250>
                        <center>
                        <div class="form-group" style="font-size:x-large;border:2px grey solid">
                                <input type="text" placeholder="Registeration Fee Amount" required class="form-input" name="reg_fee_amount" value=<?php if ($_POST){ echo $_POST['reg_fee_amount'];} else{ echo "";}?>>
                        </div>
                        </center>

                </td>
            </tr>
            <tr>
                <td width=250>
                    <center><b> Registeration Discount </b></center>
                </td>
                <td width=250>
                        <center>
                        <div class="form-group" style="font-size:x-large;border:2px grey solid">
                                <input type="text" placeholder="Registeration Discount" required class="form-input" name="reg_discount" value=<?php if ($_POST){ echo $_POST['reg_discount'];} else{ echo "";}?>>
                        </div>
                        </center>

                </td>
            </tr>
            <tr>
                <td width=250>
                    <center><b> Registeration Final Amount </b></center>
                </td>
                <td width=250>
                        <center>
                        <div class="form-group" style="font-size:x-large;border:2px grey solid">
                                <input type="text" placeholder="Registeration Final Amount" required class="form-input" name="reg_final_amount" value=<?php if ($_POST){ echo $_POST['reg_final_amount'];} else{ echo "";}?>>
                        </div>
                        </center>

                </td>
            </tr>
			<tr>
				<td width=250>
					<center><p style="margin-top:1rem"> <b> Fee Fully Paid </b> </p></center>
				</td>
				<td width=250>
					<center>
					<div class="form-group" style="border:none;margin-top:1rem">
						<input type="radio" name="feepaid" value="yes" required> Yes
						<input type="radio" name="feepaid" value="no" required> No
					</div>
					</center>
				</td>
			</tr>
			<tr>
				<td width=250>
					<center><b> Registeration Date </b></center>
				</td>
				<td width=250>
					<center>
					<div class="form-group" style="font-size:x-large;border:2px grey solid">
						<input type="text" placeholder="Reg_Date: MM/DD/YYYY" name="reg_date" required class="form-input" value=<?php if ($_POST) echo $_POST['reg_date']; else{ echo "";}?>>  
					</div>
					</center>
				</td>
			</tr>

        </table>        
        </fieldset>

        <br><br>
        
        </center>       
        </fieldset>
        <br><br>
        <center>
            <button type="submit" name="submit" value="Submit" class="btn btn-login" style="margin-left: 2rem;" onclick="return validate()"> REGISTER </button>
            <button type="button" class="btn btn-login" style="margin-left: 2rem;"> <a href="Registeration.php" style="color: white;text-decoration:none"> RESET FIELDS </a></button>        
        </center>
        </form>
       <br><br><br><br>
    </body>

    <?php
		if($_POST){
			//SAVE DATA IN VARIABLES
			$SECTION_ID = $_POST['section_id'];
			$REG_FEE_AMOUNT = $_POST['reg_fee_amount'];
			$REG_DISCOUNT = $_POST['reg_discount'];
			$REG_FINAL_AMOUNT = $_POST['reg_final_amount'];
			$REG_FEE_PAID = $_POST['feepaid'];
			$REG_DATE = $_POST['reg_date'];
			//UPDATE IS_PAID AS INTEGER
			if($REG_FEE_PAID == 'yes'){
				$REG_FEE_PAID = 1;
			}
			else{
				$REG_FEE_PAID = 0;
			}
			
			//INSERT INTO HB_REGISTERATION
			$query = "INSERT INTO HB_REGISTERATION (REG_ID, COURSE_ID, STUDENT_ID, REG_CHALLAN_NUM, REG_FEE_AMOUNT, REG_DISCOUNT, REG_FINAL_AMOUNT, IS_PAID, REG_DATE)
			VALUES ('".$REG_ID."', '".$COURSE_ID."', '".$STU_ID."', '".$REG_CHALLAN_NUM."', ".$REG_FEE_AMOUNT.", ".$REG_DISCOUNT.", ".$REG_FINAL_AMOUNT.", ".$REG_FEE_PAID.", to_date('".$REG_DATE."','MM/DD/YYYY'))";
			$query_id = oci_parse($con,$query);
			$query_execute = oci_execute($query_id);

			//UPADTE REG_HIST_ID
			$REG_HIST_ID = makeCounter('HB_REGISTERATION_HISTORY', 'RRH-');
			//INSERT INTO HB_REGISTERATION_HISSTORY
			$query = "INSERT INTO HB_REGISTERATION_HISTORY (REG_HIST_ID, REG_ID, COURSE_ID, STUDENT_ID, REG_CHALLAN_NUM, REG_FEE_AMOUNT, REG_DISCOUNT, REG_FINAL_AMOUNT, IS_PAID, REG_DATE)
			VALUES ('".$REG_HIST_ID."', '".$REG_ID."', '".$COURSE_ID."', '".$STU_ID."', '".$REG_CHALLAN_NUM."', ".$REG_FEE_AMOUNT.", ".$REG_DISCOUNT.", ".$REG_FINAL_AMOUNT.", ".$REG_FEE_PAID.", to_date('".$REG_DATE."','MM/DD/YYYY'))";
			$query_id = oci_parse($con,$query);
			$query_execute = oci_execute($query_id);

			//UPADTE CA_ID
			$CA_ID = makeCounter('HB_CLASS_ASSIGNMENT', 'CA-');
			//INSERT INTO HB_CLASS_ASSIGNMENT
			$query = "INSERT INTO HB_CLASS_ASSIGNMENT(CA_ID, CLASS_ID, SECTION_ID, REG_ID) VALUES('".$CA_ID."', ".$CLASS_ID.", '".$SECTION_ID."', '".$REG_ID."')";
			$query_id = oci_parse($con,$query);
			$query_execute = oci_execute($query_id);

			//UPADTE CLASS_ID_HISTORY
			$CLASS_ID_HISTORY = makeCounter('HB_CLASS_ASSIGNMENT_HIST', 'CID-');
			//INSERT INTO HB_CLASS_ASSIGNMENT_HIST
			$query = "INSERT INTO HB_CLASS_ASSIGNMENT_HIST(CLASS_ID_HISTORY, CLASS_ID, SECTION_ID, REG_ID) VALUES('".$CLASS_ID_HISTORY."', ".$CLASS_ID.", '".$SECTION_ID."', '".$REG_ID."')";
			$query_id = oci_parse($con,$query);
			$query_execute = oci_execute($query_id);
		}

    ?>

	<?php
		function makeCounter($TABLENAME, $STYLE){
			$con = makeConnection();
			$query = "select count(*) COUNT from ".$TABLENAME;
			$query_id = oci_parse($con,$query);
			$query_execute = oci_execute($query_id);
			$data = oci_fetch_array($query_id,OCI_BOTH);

			$counter = 0;
			$copy = $data["COUNT"]+1;
			while($copy>=1)
			{
				$counter = $counter+1;
				$copy /= 10;
			}
			$counter = 4-$counter;

			$ID = $STYLE;
			while($counter>0)
			{
				$ID .='0';
				$counter --;
			}
			$ID .= $data["COUNT"]+1;
			return $ID;
		}
		
		function parseQuery($query){
			$con = makeConnection();
			$query_id = oci_parse($con,$query);
			$query_execute = oci_execute($query_id);
			$data = oci_fetch_array($query_id,OCI_BOTH);
			return $data;
		}
	?>

</html>