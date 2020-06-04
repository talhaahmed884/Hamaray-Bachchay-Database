<?php
    $posted = false;
    $ChildOK = 0;
    $MomOK = 0; 
    $DadOK = 0;
    $GuardOK = 0;
  if( $_POST ) {
    $posted = true;

    // Database stuff here...
    // $result = mysql_query( ... )
    $result = $_POST['name'] == "Ali"; // Dummy result
    $con = Establish_Connection();
    if ($con){
        $Cid = $_POST['cID'];
        $Cname = $_POST['name'];
        $CAge = $_POST['age'];
        $CDoB = $_POST['dob'];
        $Cgender = $_POST['gender'];
        $CBform = $_POST['bform'];

        $Mid = $_POST['IDmom'];
        $Mname = $_POST['namemom'];
        $Mcnic = $_POST['cnicmom'];
        $Maddress = $_POST['addressmom'];
        $Memail = $_POST['emailmom'];
        $Mcontact = $_POST['contactmom'];

        $Fid = $_POST['IDdad'];
        $Fname = $_POST['namedad'];
        $Fcnic = $_POST['cnicdad'];
        $Faddress = $_POST['addressdad'];
        $Femail = $_POST['emaildad'];
        $Fcontact = $_POST['contactdad'];
    
        $Gid = $_POST['IDG'];
        $Gname = $_POST['nameG'];
        $Gcnic = $_POST['cnicG'];
        $Gaddress = "";
        $Gemail = "";
        $Ggender = $_POST['genderG'];
        $Gcontact = $_POST['contactG'];
        $Grelation = $_POST['relationG'];

        $fee = $_POST['fee'];
        $discount = $_POST['discount'];
        $fullamt = $_POST['finalamount'];
        $feepaid = $_POST['feepaid'];
        $challan = $_POST['challan'];

        echo "<br><br><br>";
        echo $Cid." ".$Cname." ".$CAge." ".$Cgender." ".$CDoB." ".$CBform."<br>";
        echo $Mid." ".$Mname." ".$Mcnic." ".$Maddress." ".$Memail." ".$Mcontact."<br>";
        echo $Fid." ".$Fname." ".$Fcnic." ".$Faddress." ".$Femail." ".$Fcontact."<br>";
        echo $Gid." ".$Gname." ".$Gcnic." ".$Ggender." ".$Gcontact." ".$Grelation."<br>";
        echo $fee." ".$discount." ".$fullamt." ".$feepaid." ".$challan."<br><br><br>";

        $already_exists= "SELECT * FROM HB_ADULT WHERE PERSON_ID = ".$Mid;
        $xID = oci_parse($con,$already_exists);
        $already_exists=0;
        if (oci_execute($xID)){
            while ($row = oci_fetch_array($xID, OCI_BOTH+OCI_RETURN_NULLS)){
                $already_exists++;
            }
        }


        // FOR CHILD
        $qChild = "INSERT INTO HB_CHILD(CHILD_ID, NAME, DOB, GENDER, AGE, B_FORM, PHOTO) VALUES (".$Cid.",'".$Cname."', TO_DATE('".$CDoB."', 'MM/DD/YYYY') ,'".$Cgender."', ".$CAge.", '".$CBform."', '')";
        $dateQ = "SELECT EXTRACT (YEAR FROM SYSDATE) E FROM TAB";
        $q_id = oci_parse($con,$dateQ);
        $q_exec = oci_execute($q_id);
        $q_exec = oci_fetch_array($q_id,OCI_BOTH);
        $date = "01-JAN-".$q_exec['E'];
        if (!$already_exists){
            // FOR MOTHER
            $qmom="INSERT INTO HB_ADULT(PERSON_ID, NAME, EMAIL, CONTACT, CNIC, ADDRESS, GENDER) VALUES(".$Mid.",'".$Mname."', '".$Memail."' , '".$Mcontact."', '".$Mcnic."', '".$Maddress."', 'F')";
            
            // FOR FATHER
            $qdad="INSERT INTO HB_ADULT(PERSON_ID, NAME, EMAIL, CONTACT, CNIC, ADDRESS, GENDER) VALUES(".$Fid.",'".$Fname."', '".$Femail."' , '".$Fcontact."', '".$Fcnic."', '".$Faddress."', 'M')";
            
            // FOR GUARDIAN
            $qG="INSERT INTO HB_ADULT(PERSON_ID, NAME, EMAIL, CONTACT, CNIC, ADDRESS, GENDER) VALUES(".$Gid.",'".$Gname."', '".$Gemail."' , '".$Gcontact."', '".$Gcnic."', '".$Faddress."', '".$Ggender."' )";
            
        
            
            if (oci_execute(oci_parse($con,$qChild))){
                $ChildOK = 1;
                if (oci_execute(oci_parse($con,$qmom))){
                    echo "MOM PASSED<br>";
                    $MomOK = 1;
                }
                if (oci_execute(oci_parse($con,$qdad))){
                    echo "DAD PASSED<br>";
                    $DadOK = 1;
                }
                if (oci_execute(oci_parse($con,$qG))){
                    echo "GUARD PASSED<br>";
                    $GuardOK = 1;
                }
                if (!$MomOK){
                    if ($DadOK){    // DELETE DAD INSERTION
                        $DelDad = "DELETE FROM HB_ADULT WHERE PERSON_ID = ".$Fid;
                        oci_execute(oci_parse($con,$DelDad));
                    }
                    if ($GuardOK){  // DELETE GUARD INSERTION
                        $DelGuard = "DELETE FROM HB_ADULT WHERE PERSON_ID =".$Gid;
                        oci_execute(oci_parse($con,$DelGuard));
                    }
                    $DelChild = "DELETE FROM HB_CHILD WHERE CHILD_ID = ".$Cid;
                    oci_execute(oci_parse($con,$DelChild));
                    
                }
                if (!$DadOK){
                    if ($MomOK){    // DELETE MOM INSERTION
                        $DelMom = "DELETE FROM HB_ADULT WHERE PERSON_ID = ".$Mid;
                        oci_execute(oci_parse($con,$DelMom));
                    }
                    if ($GuardOK){  // DELETE GUARD INSERTION
                        $DelGuard = "DELETE FROM HB_ADULT WHERE PERSON_ID =".$Gid;
                        oci_execute(oci_parse($con,$DelGuard));
                    }
                    $DelChild = "DELETE FROM HB_CHILD WHERE CHILD_ID = ".$Cid;
                    oci_execute(oci_parse($con,$DelChild));
                }
                if (!$GuardOK){
                    if ($DadOK){    // DELETE DAD INSERTION
                        $DelDad = "DELETE FROM HB_ADULT WHERE PERSON_ID = ".$Fid;
                        oci_execute(oci_parse($con,$DelDad));
                    }
                    if ($MomOK){  // DELETE MOM INSERTION
                        $DelGuard = "DELETE FROM HB_ADULT WHERE PERSON_ID =".$Mid;
                        oci_execute(oci_parse($con,$DelMom));
                    }
                    $DelChild = "DELETE FROM HB_CHILD WHERE CHILD_ID = ".$Cid;
                    oci_execute(oci_parse($con,$DelChild));
                }
            }

            if ($ChildOK && $MomOK && $DadOK && $GuardOK){  // ADMISSION TIME
                $query = "select count(*) COUNT from HB_PARENT";
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
                $counter = 3-$counter;

                $parent_id = '2';
                while($counter>0)
                {
                    $parent_id .='0';
                    $counter --;
                }
                $parent_id .= $data["COUNT"];

                /* INSERT IN HB_PARENT */
                $insert = "INSERT INTO HB_PARENT VALUES(".$parent_id.")";
                $q_id = oci_parse($con,$insert);
                $q_exec = oci_execute($q_id);

                /* INSERT IN HB_PARENT_INFO A NEW MOM ID */
                $insert = "INSERT INTO HB_PARENT_INFO(PARENT_ID,PERSON_ID) VALUES(".$parent_id.", ".$Mid.")";
                $q_id = oci_parse($con,$insert);
                $q_exec = oci_execute($q_id);

                /* INSERT IN HB_PARENT_INFO A NEW FATHER ID */
                $insert = "INSERT INTO HB_PARENT_INFO(PARENT_ID,PERSON_ID) VALUES(".$parent_id.", ".$Fid.")";
                $q_id = oci_parse($con,$insert);
                $q_exec = oci_execute($q_id);

            

                $query = "select count(*) COUNT from HB_GUARDIAN";
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
                $counter = 3-$counter;

                $G_id = '3';
                while($counter>0)
                {
                    $G_id .='0';
                    $counter --;
                }
                $G_id .= $data["COUNT"];

                /* INSERT IN HB_GUARDIAN */
                $insert = "INSERT INTO HB_GUARDIAN(GUARD_ID,PERSON_ID,RELATION) VALUES(".$G_id.", ".$Gid.", '".$Grelation."')";
                $q_id = oci_parse($con,$insert);
                $q_exec = oci_execute($q_id);
                

                $query = "select count(*) COUNT from HB_ADMITTED_STUDENT";
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

                $Stu_id = 'HB-';
                while($counter>0)
                {
                    $Stu_id .='0';
                    $counter --;
                }
                $Stu_id .= $data["COUNT"]+1;
                if ($feepaid="yes"){
                    $feepaid=1;
                }
                else {
                    $feepaid=0;
                }
                $insert = "INSERT INTO HB_ADMITTED_STUDENT(STUDENT_ID, CHILD_ID, PARENT_ID, GUARD_ID, CHALLAN_NUM, FEE_AMOUNT, DISCOUNT, FINAL_AMOUNT, IS_PAID, JOIN_DATE) VALUES('".$Stu_id."', ".$Cid.", ".$parent_id.", ".$G_id.", '".$challan."', ".$fee.", ".$discount.", ".$fullamt.", ".$feepaid.", TO_DATE('".$date."', 'DD-MON-YYYY'))";
                $q_id = oci_parse($con,$insert);
                $q_exec = oci_execute($q_id);
                if (!$q_exec){
                    $del[0] = "DELETE FROM HB_CHILD WHERE CHILD_ID =".$Cid;
                    $del[1] = "DELETE FROM HB_PARENT_INFO WHERE PARENT_ID = ".$parent_id;
                    $del[2] = "DELETE FROM HB_PARENT WHERE PARENT_ID = ".$parent_id;
                    $del[3] = "DELETE FROM HB_GUARDIAN WHERE GUARD_ID = ".$G_id;
                    $del[4] = "DELETE FROM HB_ADULT WHERE PERSON_ID = ".$Mid;
                    $del[5] = "DELETE FROM HB_ADULT WHERE PERSON_ID = ".$Fid;
                    $del[6] = "DELETE FROM HB_ADULT WHERE PERSON_ID = ".$Gid;
                    $i=0;
                    while($i<7){
                        $q_id = oci_parse($con,$del[$i]);
                        $q_exec = oci_execute($q_id);
                        $i++;
                    }
					echo "<script type='text/javascript'>alert('FAILED!');document.getElementById('inn').reset();</script>";
                }
				else{
					echo "<script type='text/javascript'>alert('SUBMISSION OF NEW CHILD AND NEW PARENT SUCCESSFUL!');document.getElementById('inn').reset();</script>";
				}
            }
        }
        else {  // IF STUDENT NEW BUT PARENTS OLD
            oci_execute(oci_parse($con,$qChild));
            if ($feepaid="yes"){
                $feepaid=1;
            }
            else {
                $feepaid=0;
            }
            $query = "select count(*) COUNT from HB_ADMITTED_STUDENT";
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

            $Stu_id = 'HB-';
            while($counter>0)
            {
                $Stu_id .='0';
                $counter --;
            }
            $Stu_id .= $data["COUNT"]+1;
                
            $findP = "SELECT PARENT_ID FROM HB_PARENT_INFO WHERE PERSON_ID =".$Mid;
            $findG = "SELECT GUARD_ID FROM HB_GUARDIAN WHERE PERSON_ID =".$Gid;
            $findPx = oci_parse($con,$findP);
            $findGx = oci_parse($con,$findG);
            oci_execute($findPx);
            oci_execute($findGx);
            $rowP = oci_fetch_array($findPx,OCI_BOTH);
            $rowG = oci_fetch_array($findGx,OCI_BOTH);
            $parent_id = $rowP['PARENT_ID'];
            $G_id = $rowG['GUARD_ID'];

           

            $insert = "INSERT INTO HB_ADMITTED_STUDENT(STUDENT_ID, CHILD_ID, PARENT_ID, GUARD_ID, CHALLAN_NUM, FEE_AMOUNT, DISCOUNT, FINAL_AMOUNT, IS_PAID, JOIN_DATE) VALUES('".$Stu_id."', ".$Cid.", ".$parent_id.", ".$G_id.", '".$challan."', ".$fee.", ".$discount.", ".$fullamt.", ".$feepaid.", TO_DATE('".$date."', 'DD-MON-YYYY'))";
            echo "<br>".$insert;
            $q_id = oci_parse($con,$insert);
            $q_exec = oci_execute($q_id);

            if (!$q_exec){
                $del = "DELETE FROM HB_CHILD WHERE CHILD_ID =".$Cid;
                $q_id = oci_parse($con,$del);
                $q_exec = oci_execute($q_id);
				echo "<script type='text/javascript'>alert('FAILED!');document.getElementById('inn').reset();</script>";
            }
            else {
                $GuardOK = 1;
                $MomOK = 1;
                $DadOK = 1;
                $ChildOK = 1;
				echo "<script type='text/javascript'>alert('SUBMISSION OF NEW STUDENT SUCCESSFUL!');document.getElementById('inn').reset();</script>";
            }
        }
        
    }
  }
?>

<html>
    <head>  
		<title>Admission Form</title>
        <style>
            fieldset {
                display:flex;
                margin-left: 400px;
                margin-right: 400px;
                padding-top: 0em;
                padding-bottom: 0em;
                padding-left: 0.75em;
                height: 16rem;
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
    
<body style="color: lightcoral;overflow:auto;background-image: url('./assets/img2.jpg');background-repeat: no-repeat;background-size: 100% 100%;background-attachment: fixed;">

<h1><center>Admission Form</center></h1>
<form action="" method="post" id="inn" >
    <fieldset style="border: 3px solid <?php if ($_POST && $ChildOK==0){ echo "red";} else { echo "green";} ?>;height: 26rem;">
        <legend style="color:yellow"><b> Students Information <b> </legend>

    <br><br>
    <center>
    <table>
        <tr>
            <td width=250>
                <center><b> Child ID </b></center>
            </td>
            <td width=250>
                    <center>
                    <div class="form-group">
                            <input type="text" placeholder="Child ID" required class="form-input" name="cID" value=<?php if ($_POST){ echo $_POST['cID'];} else{ echo "";}?>>
                    </div>
                    </center>

            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><b> Name </b></center>
            </td>
            <td width=250>
                    <center>
                    <div class="form-group">
                            <input type="text" placeholder="Name" required class="form-input" name="name" value=<?php if ($_POST){ echo $_POST['name'];} else{ echo "";}?>>
                    </div>
                    </center>

            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><b> Date Of Birth </b></center>
            </td>
            <td width=250>
                <center>
                <div class="form-group">
                    <input type="text" placeholder="DOB: MM/DD/YYYY" name="dob" required class="form-input" value=<?php if ($_POST) echo $_POST['dob']; else{ echo "";}?>>  
                </div>
                </center>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><p style="margin-top:1rem"> <b> Gender </b> </p></center>
            </td>
            <td width=250>
                <center>
                <div class="form-group" style="border:none;margin-top:1rem">
                    <input type="radio" name="gender" value="M" required> Male
                    <input type="radio" name="gender" value="F" required> Female
                </div>
                </center>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><p style="margin-top:1rem"> <b> Age </b> </p></center>
            </td>
            <td width=250>
                <center>
                <div class="form-group">
                    <input type="number" placeholder="Age" name="age" required class="form-input" value=<?php if ($_POST) echo $_POST['age']; else{ echo "";}?>>  
                </div>
                </center>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><p style="margin-top:1rem"> <b> B-Form </b> </p></center>
            </td>
            <td width=250>
                <center>
                <div class="form-group">
                    <input type="text" placeholder="12345-1234567-1" name="bform" required class="form-input" value=<?php if ($_POST) echo $_POST['bform']; else{ echo "";}?>>  
                </div>
                </center>
            </td>
        </tr>
    </table>
    </center>
    </fieldset>

    <br><br><br>

    
    <!-- FIELD FOR MOTHER's INFO -->
    <fieldset style="border: 3px solid <?php if ($_POST && $MomOK==0){ echo "red";} else { echo "green";} ?>;height: 27rem;">
        <legend style="color:yellow;"><b> Mother's Information <b> </legend>

        <br><br>
    <center>
    <table>
        <tr>
            <td width=250>
                <center><b> Person ID </b></center>
            </td>
            <td width=250>
                    <center>
                    <div class="form-group">
                            <input type="text" placeholder="Mother's ID" required class="form-input" name="IDmom" value=<?php if ($_POST){ echo $_POST['IDmom'];} else{ echo "";}?>>
                    </div>
                    </center>

            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><b> Name </b></center>
            </td>
            <td width=250>
                    <center>
                    <div class="form-group">
                            <input type="text" placeholder="Name" required class="form-input" name="namemom" value=<?php if ($_POST) echo $_POST['namemom']; else{ echo "";}?>>
                    </div>
                    </center>

            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><b> Contact </b></center>
            </td>
            <td width=250>
                <center>
                <div class="form-group">
                    <input type="text" placeholder="3001234567" name="contactmom" required class="form-input" value=<?php if ($_POST) echo $_POST['contactmom']; else{ echo "";}?>>  
                </div>
                </center>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><p style="margin-top:1rem"> <b> CNIC </b> </p></center>
            </td>
            <td width=250>
                <center>
                <div class="form-group">
                    <input type="text" placeholder="12345-1234567-1" name="cnicmom" required class="form-input" value=<?php if ($_POST) echo $_POST['cnicmom']; else{ echo "";}?>>  
                </div>
                </center>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><p style="margin-top:1rem"> <b> Address </b> </p></center>
            </td>
            <td width=250>
                <center>
                <div class="form-group">
                    <input type="text" placeholder="Address" name="addressmom" required class="form-input" value=<?php if ($_POST) echo $_POST['addressmom']; else{ echo "";}?>>  
                </div>
                </center>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><b> Email </b></center>
            </td>
            <td width=250>
                <center>
                <div class="form-group">
                    <input type="text" placeholder="Email" name="emailmom" required class="form-input" value=<?php if ($_POST) echo $_POST['emailmom']; else{ echo "";}?>>  
                </div>
                </center>
            </td>
        </tr>
    </table>
    </center>
    </fieldset>

    <br><br><br>

    
    <!-- FIELD FOR FATHER's INFO -->
    <fieldset style="border: 3px solid <?php if ($_POST && $DadOK==0){ echo "red";} else { echo "green";} ?>;height: 27rem;">
        <legend style="color:yellow;"><b> Father's Information <b> </legend>

        <br><br>
    <center>
    <table>
        <tr>
            <td width=250>
                <center><b> Person ID </b></center>
            </td>
            <td width=250>
                    <center>
                    <div class="form-group">
                            <input type="text" placeholder="Father's ID" required class="form-input" name="IDdad" value=<?php if ($_POST){ echo $_POST['IDdad'];} else{ echo "";}?>>
                    </div>
                    </center>

            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><b> Name </b></center>
            </td>
            <td width=250>
                    <center>
                    <div class="form-group">
                            <input type="text" placeholder="Name" required class="form-input" name="namedad" value=<?php if ($_POST) echo $_POST['namedad']; else{ echo "";}?>>
                    </div>
                    </center>

            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><b> Contact </b></center>
            </td>
            <td width=250>
                <center>
                <div class="form-group">
                    <input type="text" placeholder="3001234567" name="contactdad" required class="form-input" value=<?php if ($_POST) echo $_POST['contactdad']; else{ echo "";}?>>  
                </div>
                </center>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><p style="margin-top:1rem"> <b> CNIC </b> </p></center>
            </td>
            <td width=250>
                <center>
                <div class="form-group">
                    <input type="text" placeholder="12345-1234567-1" name="cnicdad" required class="form-input" value=<?php if ($_POST) echo $_POST['cnicdad']; else{ echo "";}?>>  
                </div>
                </center>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><p style="margin-top:1rem"> <b> Address </b> </p></center>
            </td>
            <td width=250>
                <center>
                <div class="form-group">
                    <input type="text" placeholder="Address" name="addressdad" required class="form-input" value=<?php if ($_POST) echo $_POST['addressdad']; else{ echo "";}?>>  
                </div>
                </center>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><b> Email </b></center>
            </td>
            <td width=250>
                <center>
                <div class="form-group">
                    <input type="text" placeholder="Email" name="emaildad" required class="form-input" value=<?php if ($_POST) echo $_POST['emaildad']; else{ echo "";}?>>  
                </div>
                </center>
            </td>
        </tr>
    </table>
    </center>
    </fieldset>

    <!-- FIELD FOR GUARDIAN INFO -->
    <br><br><br>
    <fieldset style="border: 3px solid <?php if ($_POST && $GuardOK==0){ echo "red";} else { echo "green";} ?>;height: 27rem;">
        <legend style="color:yellow;"><b> Guardian's Information <b> </legend>

        <br><br>
    <center>
    <table>
        <tr>
            <td width=250>
                <center><b> Person ID </b></center>
            </td>
            <td width=250>
                    <center>
                    <div class="form-group">
                            <input type="text" placeholder="Guardian's ID" required class="form-input" name="IDG" value=<?php if ($_POST){ echo $_POST['IDG'];} else{ echo "";}?>>
                    </div>
                    </center>

            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><b> Name </b></center>
            </td>
            <td width=250>
                    <center>
                    <div class="form-group">
                            <input type="text" placeholder="Name" required class="form-input" name="nameG" value=<?php if ($_POST) echo $_POST['nameG']; else{ echo "";}?>>
                    </div>
                    </center>

            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><b> Contact </b></center>
            </td>
            <td width=250>
                <center>
                <div class="form-group">
                    <input type="text" placeholder="3001234567" name="contactG" required class="form-input" value=<?php if ($_POST) echo $_POST['contactG']; else{ echo "";}?>>  
                </div>
                </center>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><p style="margin-top:1rem"> <b> CNIC </b> </p></center>
            </td>
            <td width=250>
                <center>
                <div class="form-group">
                    <input type="text" placeholder="12345-1234567-1" name="cnicG" required class="form-input" value=<?php if ($_POST) echo $_POST['cnicG']; else{ echo "";}?>>  
                </div>
                </center>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><p style="margin-top:1rem"> <b> Gender </b> </p></center>
            </td>
            <td width=250>
                <center>
                <div class="form-group" style="border:none;margin-top:1rem">
                    <input type="radio" name="genderG" value="M" required> Male
                    <input type="radio" name="genderG" value="F" required> Female
                </div>
                </center>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><p style="margin-top:1rem"> <b> Relation </b> </p></center>
            </td>
            <td width=250>
                <center>
                <div class="form-group">
                    <input type="text" placeholder="e.g NANNY" name="relationG" required class="form-input" value=<?php if ($_POST) echo $_POST['relationG']; else{ echo "";}?>>  
                </div>
                </center>
            </td>
        </tr>
    </table>
    </center>
    </form>
    </fieldset>

<!-- FIELD FOR STAFF ONLY -->

    <br><br><br>
    <fieldset style="border: 3px solid green;height:22rem;">
        <legend style="color:yellow;"><b> FEE INFO <b> </legend>

        <br><br>
    <center>
    <table>
        <tr>
            <td width=250>
                <center><b> Fee Amount </b></center>
            </td>
            <td width=250>
                    <center>
                    <div class="form-group">
                            <input type="number" placeholder="Amount in Rupees" required class="form-input" name="fee" value=<?php if ($_POST) echo $_POST['fee']; else{ echo "";}?>>
                    </div>
                    </center>

            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><b> Discount </b></center>
            </td>
            <td width=250>
                <center>
                <div class="form-group">
                    <input type="number" placeholder="Discount in Rupees" name="discount" required class="form-input" value=<?php if ($_POST) echo $_POST['discount']; else{ echo "";}?>>  
                </div>
                </center>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><p style="margin-top:1rem"> <b> Final Amount </b> </p></center>
            </td>
            <td width=250>
                <center>
                <div class="form-group">
                    <input type="number" placeholder="Final Amount in Rupees" name="finalamount" required class="form-input" value=<?php if ($_POST) echo $_POST['finalamount']; else{ echo "";}?>>  
                </div>
                </center>
            </td>
        </tr>
    </table>
    <table>
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
    </table>
    <table>
        <tr>
            <td width=250>
                <center><p style="margin-top:1rem"> <b> Challan # </b> </p></center>
            </td>
            <td width=250>
                <center>
                <div class="form-group">
                    <input type="text" placeholder="Format:   C-1XXX" name="challan" required class="form-input" value=<?php if ($_POST) echo $_POST['challan']; else{ echo "";}?>>  
                </div>
                </center>
            </td>
        </tr>
    </table>
    </center>
    
    </fieldset>
    <br><br><br>
    
    <center>
        <button type="submit" class="btn btn-login" style="margin-left: 2rem;" onclick="return validate()">SUBMIT INFO</button>
        <a href="Admission.php" style="color: white;text-decoration:none"><button type="button" class="btn btn-login" style="margin-left: 2rem;">RESET FIELDS </button></a>
        <a href="home_page.html" style="color: white;text-decoration:none"><button type="button" class="btn btn-login" style="margin-left: 2rem;">GO BACK </button></a>
    </center>
    </form>
    <br><br>
</body>
</html>


<?php
if ($_POST){
    
}
function Establish_Connection(){
		$db_sid = "(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = Turab-PC)(PORT = 1521)))
		(CONNECT_DATA = (SID = orcl) ) )";
		$db_user = "scott";
		$db_pass = "1234";
		$con = oci_connect($db_user,$db_pass,$db_sid);

	    if ($con){

	    	//echo "<br>SUCCESSFUL CONNECTION<br><br>";
		}
		else {
			die("NOT SUCCESSFUL");
		}
		return $con;
	}
?>