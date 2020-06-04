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

    if($con){
		if(isset($_POST['submit'])){
			
			$q = "SELECT CAGE FROM Complete_Child_Info WHERE STU_ID = '".$_POST['STU_ID']."'";
			$query_id = oci_parse($con, $q);
			$r = oci_execute($query_id);			
			$r = oci_fetch_array($query_id,OCI_BOTH);

			$q = "SELECT * FROM Complete_Guard_Info WHERE STU_ID = '".$_POST['STU_ID']."'";
			$query_id = oci_parse($con, $q);
			$r1 = oci_execute($query_id);			
			$r1 = oci_fetch_array($query_id,OCI_BOTH);
			
			if($r1['GID'] == $_POST['GAU_ID'] AND $r1['GGENDER'] == 'F'){
				if($r['CAGE'] <= 5){
					// insert student info
					unset($_POST['submit']);
					$IS_PREG = "";
					$ACCOMPANY_ID = makeCounter('HB_ACCOMPANY_RECORD','A-');
					if ($_POST['pregnant']=='yes'){
						$IS_PREG = 1;
					}
					else {
						$IS_PREG = 0;
					}
					$q = "INSERT INTO HB_ACCOMPANY_RECORD(ACCOMPANY_ID, STUDENT_ID, GUARD_ID, IS_PREG, REASON)
					VALUES('".$ACCOMPANY_ID."', '".$_POST["STU_ID"]."', ".$_POST['GAU_ID'].", ".$IS_PREG.", '".$_POST['description']."')";
					$query_id = oci_parse($con, $q);
					$r = oci_execute($query_id);
					if($r){
						echo "SUCCESSFUL";
					}
				}
				else{
					echo "<br>CHILD OLDER THAN FIVE YEARS DOES NOT NEED ACCOMPANY<br>";
				}
			}
			else{
				echo "<br>GUARDIAN NOT RELATED<br>";
			}
		}
	}
    else {
        die('Could not connect: ');

    }
?>


<html>
	<head>
	<title>Accompany Form</title>
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
                margin-bottom: 50px;
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
            <h1><b>Hamarey Bachchey</b></h1>
            <h1><b>Accompany Form</b></h1>
        </div>

        <form method="post" id="inn">   
        <fieldset style="font-size: x-large;">
            <legend style="color:yellow;">Student Information</legend>
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
                                <input type="text" placeholder="Student ID" required class="form-input" name="STU_ID" value=<?php if ($_POST){ echo $_POST['STU_ID'];} else{ echo "";}?>>
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
                                <input type="text" placeholder="Class ID" required class="form-input" name="STU_CLASS" value=<?php if ($_POST){ echo $_POST['STU_CLASS'];} else{ echo "";}?>>
                        </div>
                        </center>

                </td>
            </tr>
        </table>        
        </fieldset>
        <br><br>
		</center>
		
		<fieldset style="font-size: x-large;">
            <legend style="color:yellow;">Accompanying Gaurdian Information</legend> 
			<br> 
			<center>
			<table>
				<tr>
					<td width=250>
						<center><b> Guardian ID </b></center>
					</td>
					<td width=250>
							<center>
							<div class="form-group" style="font-size:x-large;border:2px grey solid">
									<input type="text" placeholder="Guardian ID" required class="form-input" name="GAU_ID" value=<?php if ($_POST){ echo $_POST['GAU_ID'];} else{ echo "";}?>>
							</div>
							</center>
					</td>
				</tr>
				<tr>
					<td width=250>
						<center><p style="margin-top:1rem"> <b> Pregnant </b> </p></center>
					</td>
					<td width=250>
						<center>
						<div class="form-group" style="border:none;margin-top:1rem">
							<input type="radio" name="pregnant" value="yes" required> Yes
							<input type="radio" name="pregnant" value="no" required> No
						</div>
						</center>
					</td>
				</tr>
				<tr>
					<td width=250>
						<br>
						<center><b> Reason For Parent's Absence </b></center>
					</td>
					<td width=250>
							<center>
							<div class="form-group" style="font-size:x-large;border:2px grey solid">
									<input  class='form-input' placeholder='Reason' name = "description" value=<?php if ($_POST){ echo '"'.$_POST['description'].'"';} else{ echo "";}?>>
							</div>
							</center>
					</td>
				</tr>
			</table>
			</center>
        </fieldset>
		
        <br><br>
        <center>
            <button type="submit" name="submit" value="Submit" class="btn btn-login" style="margin-left: 2rem;">SUBMIT FORM</button>
            <a href="Accompany.php" style="color: white;text-decoration:none"><button type="button" class="btn btn-login" style="margin-left: 2rem;"> RESET FIELDS </button></a>
			<a href="home_page.html" style="color: white;text-decoration:none"><button type="button" class="btn btn-login" style="margin-left: 2rem;">GO BACK </button></a>
        </center>
        </form>
       <br><br><br><br>
    </body>
	
	
</html>

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
			$ID .= $data["COUNT"];
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