<?php
    session_start();
    $Stu_ID = $_SESSION['A'];

    //echo $Stu_ID;
    $posted = false;
    $ChildOK = 0;
    $MomOK = 0; 
    $DadOK = 0;
    $GuardOK = 0;

	$Cid = "";
	$Cname = "";
	$CAge = "";
	$CDoB = "";
	$Cgender ="";
	$CBform = "";

	$Mid = "";
	$Mname = "";
	$Mcnic = "";
	$Maddress = "";
	$Memail = "";
	$Mcontact = "";

	$Fid = "";
	$Fname = "";
	$Fcnic = "";
	$Faddress = "";
	$Femail = "";
	$Fcontact = "";

	$Gid = "";
	$Gname = "";
	$Gcnic = "";
	$Gaddress = "";
	$Gemail = "";
	$Ggender = "";
	$Gcontact = "";
	$Grelation = "";

	$fee = "";
	$discount = "";
	$fullamt = "";
	$feepaid = "";
	$challan = "";	
    $date = "";


    $con = Establish_Connection();
    if ($con){

        $qFind_Child = "SELECT * FROM COMPLETE_CHILD_INFO WHERE STU_ID = '".$Stu_ID."'";
        $qFind_MOM = "SELECT * FROM COMPLETE_MOMDAD_INFO WHERE GENDER = 'F' AND STU_ID = '".$Stu_ID."'";
        $qFind_DAD = "SELECT * FROM COMPLETE_MOMDAD_INFO WHERE GENDER = 'M' AND STU_ID = '".$Stu_ID."'";
        $qFind_G = "SELECT * FROM COMPLETE_GUARD_INFO WHERE STU_ID = '".$Stu_ID."'";
        $qFind_Fee = "SELECT * FROM HB_ADMITTED_STUDENT WHERE STUDENT_ID = '".$Stu_ID."'";

        $Find_Child = oci_parse($con,$qFind_Child);
        $rC = oci_execute($Find_Child);
        if (!$rC){
            echo "<br> CHILD NOT FOUND <br>";
        }
        else {
            $rC = oci_fetch_array($Find_Child,OCI_BOTH);
        }

        $Find_MOM = oci_parse($con,$qFind_MOM);
        $rM = oci_execute($Find_MOM);
        if (!$rM){
            echo "<br> MOM NOT FOUND <br>";
        }
        else {
            $rM = oci_fetch_array($Find_MOM,OCI_BOTH);
        }

        $Find_DAD = oci_parse($con,$qFind_DAD);
        $rD = oci_execute($Find_DAD);
        if (!$rD){
            echo "<br> DAD NOT FOUND <br>";
        }
        else {
            $rD = oci_fetch_array($Find_DAD,OCI_BOTH);
        }

        $Find_G = oci_parse($con,$qFind_G);
        $rG = oci_execute($Find_G);
        if (!$rG){
            echo "<br> GUARD NOT FOUND <br>";
        }
        else {
            $rG = oci_fetch_array($Find_G,OCI_BOTH);
        }

        $Find_Fee = oci_parse($con,$qFind_Fee);
        $rF = oci_execute($Find_Fee);
        if (!$rF){
            echo "<br> FEE NOT FOUND <br>";
        }
        else {
            $rF = oci_fetch_array($Find_Fee,OCI_BOTH);
        }
        
        $Cid = $rC['CID'];
        $Cname = $rC['CNAME'];
        $CAge = $rC['CAGE'];
        $CDoB = $rC['CDOB'];
        $Cgender =$rC['GENDER'];
        $CBform = $rC['CBFORM'];

        $Mid = $rM['MID'];
        $Mname = $rM['MNAME'];
        $Mcnic = $rM['MCNIC'];
        $Maddress = $rM['MADDRESS'];
        $Memail = $rM['MEMAIL'];
        $Mcontact = $rM['MCONTACT'];

        $Fid = $rD['MID'];
        $Fname = $rD['MNAME'];
        $Fcnic = $rD['MCNIC'];
        $Faddress = $rD['MADDRESS'];
        $Femail = $rD['MEMAIL'];
        $Fcontact = $rD['MCONTACT'];

        $Gid = $rG['GID'];
        $Gname = $rG['GNAME'];
        $Gcnic = $rG['GCNIC'];
        $Ggender = $rG['GGENDER'];
        $Gcontact = $rG['GCONTACT'];
        $Grelation = $rG['GRELATION'];

        $fee = $rF['FEE_AMOUNT'];
        $discount = $rF['DISCOUNT'];
        $fullamt = $rF['FINAL_AMOUNT'];
        $challan = $rF['CHALLAN_NUM'];
        $feepaid = $rF['IS_PAID'];
        $date = $rF['JOIN_DATE'];

        
        // echo "<br><br><br>";
        // echo $Cid." ".$Cname." ".$CAge." ".$Cgender." ".$CDoB." ".$CBform."<br>";
        // echo $Mid." ".$Mname." ".$Mcnic." ".$Maddress." ".$Memail." ".$Mcontact."<br>";
        // echo $Fid." ".$Fname." ".$Fcnic." ".$Faddress." ".$Femail." ".$Fcontact."<br>";
        // echo $Gid." ".$Gname." ".$Gcnic." ".$Ggender." ".$Gcontact." ".$Grelation."<br>";
        // echo $fee." ".$discount." ".$fullamt." ".$feepaid." ".$challan."<br><br><br>";

    }
    
?>

<html>
    <head>
		<title>Update Child Info</title>
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

<?php
    if( $posted ) {
      if( $result ){ 
        echo "<script type='text/javascript'>alert('SUBMISSION SUCCESSFUL!');document.getElementById('inn').reset();</script>";
      }
      else
        echo "<script type='text/javascript'>alert('FAILED!');document.getElementById('inn').reset();</script>";
    }
?>

<h1><center>Update Form For <?php echo $Stu_ID?></center></h1>
<form action="" method="post" id="inn" >
    <fieldset style="height: 26rem;">
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
                            <input READONLY type="text" placeholder="Child ID" required class="form-input" name="cID" value=<?php echo $Cid; ?>>
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
                        <input type="text" placeholder="Name" required class="form-input" name="name" value=<?php echo '"'.$Cname.'"';?>>
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
                    <input type="text" placeholder="DOB: MM/DD/YYYY" name="dob" required class="form-input" value=<?php echo $CDoB; ?>>  
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
                <input type="text" placeholder="ChildGender" name="gender" required class="form-input" value=<?php echo $Cgender; ?>>
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
                    <input type="number" placeholder="Age" name="age" required class="form-input" value=<?php echo $CAge; ?>>  
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
                    <input READONLY type="text" placeholder="12345-1234567-1" name="bform" required class="form-input" value=<?php echo $CBform; ?>>  
                </div>
                </center>
            </td>
        </tr>
    </table>
    </center>
    </fieldset>

    <br><br><br>

    
    <!-- FIELD FOR MOTHER's INFO -->
    <fieldset style="height: 27rem;">
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
                            <input READONLY type="text" placeholder="Mother's ID" required class="form-input" name="IDmom" value=<?php echo $Mid; ?>>
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
                            <input type="text" placeholder="Name" required class="form-input" name="namemom" value=<?php echo '"'.$Mname.'"'; ?>>
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
                    <input type="text" placeholder="3001234567" name="contactmom" required class="form-input" value=<?php echo $Mcontact; ?>>  
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
                    <input READONLY type="text" placeholder="12345-1234567-1" name="cnicmom" required class="form-input" value=<?php echo $Mcnic; ?>>  
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
                    <input type="text" placeholder="Address" name="addressmom" required class="form-input" value=<?php echo $Maddress; ?>>  
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
                    <input type="text" placeholder="Email" name="emailmom" required class="form-input" value=<?php echo $Memail; ?>>  
                </div>
                </center>
            </td>
        </tr>
    </table>
    </center>
    </fieldset>

    <br><br><br>

    
    <!-- FIELD FOR FATHER's INFO -->
    <fieldset style="height: 27rem;">
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
                            <input READONLY type="text" placeholder="Father's ID" required class="form-input" name="IDdad" value=<?php echo $Fid; ?>>
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
                            <input type="text" placeholder="Name" required class="form-input" name="namedad" value=<?php echo '"'.$Fname.'"'; ?>>
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
                    <input type="text" placeholder="3001234567" name="contactdad" required class="form-input" value=<?php echo $Fcontact; ?>>  
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
                    <input READONLY type="text" placeholder="12345-1234567-1" name="cnicdad" required class="form-input" value=<?php echo $Fcnic; ?>>  
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
                    <input type="text" placeholder="Address" name="addressdad" required class="form-input" value=<?php echo $Faddress; ?>>  
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
                    <input type="text" placeholder="Email" name="emaildad" required class="form-input" value=<?php echo $Femail; ?>>  
                </div>
                </center>
            </td>
        </tr>
    </table>
    </center>
    </fieldset>

    <!-- FIELD FOR GUARDIAN INFO -->
    <br><br><br>
    <fieldset style="height: 27rem;">
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
                            <input READONLY type="text" placeholder="Guardian's ID" required class="form-input" name="IDG" value=<?php echo $Gid; ?>>
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
                            <input type="text" placeholder="Name" required class="form-input" name="nameG" value=<?php echo '"'.$Gname.'"'; ?>>
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
                    <input type="text" placeholder="3001234567" name="contactG" required class="form-input" value=<?php echo $Gcontact; ?>>  
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
                    <input READONLY type="text" placeholder="12345-1234567-1" name="cnicG" required class="form-input" value=<?php echo $Gcnic; ?>>  
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
                <input type="text" placeholder="Gender" name="genderG" required class="form-input" value=<?php echo $Ggender; ?>>
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
                    <input type="text" placeholder="e.g NANNY" name="relationG" required class="form-input" value=<?php echo $Grelation; ?>>  
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
    <fieldset style="height:25rem;">
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
                            <input type="number" placeholder="Amount in Rupees" required class="form-input" name="fee" value=<?php echo $fee; ?>>
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
                    <input type="number" placeholder="Discount in Rupees" name="discount" required class="form-input" value=<?php echo $discount; ?>>  
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
                    <input type="number" placeholder="Final Amount in Rupees" name="finalamount" required class="form-input" value=<?php echo $fullamt; ?>>  
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
                    <input type="text" placeholder="Is the Fee fully Paid?" name="feepaid" required class="form-input" value=<?php echo $feepaid; ?>>  
                </div>
                </center>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td width=250>
                <center><p style="margin-top:1rem"> <b> Join Date </b> </p></center>
            </td>
            <td width=250>
                <center>
                <div class="form-group">
                    <input type="text" placeholder="MM/DD/YYYY" name="date" required class="form-input" value=<?php echo $date;?>>  
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
                    <input READONLY type="text" placeholder="Format:   C-1XXX" name="challan" required class="form-input" value=<?php echo $challan;?>>  
                </div>
                </center>
            </td>
        </tr>
    </table>
    </center>
    
    </fieldset>
    <br><br><br>
    
    <center>
        <button type="submit" class="btn btn-login" style="margin-left: 2rem;" onclick="return validate()">UPDATE INFO</button>
        <a href="Student_List.php" style="color: white;text-decoration:none"><button type="button" class="btn btn-login" style="margin-left: 2rem;"> GO BACK </button></a>
    </center>
    </form>
    <br><br>
</body>
</html>

<?php
    if ($_POST){
        $changes="";
        $Cid = $_POST['cID'];
        if ($Cname != $_POST['name']){
            $changes .= "CHILD_NAME FROM ".$Cname." TO ".$_POST['name']."; ";
            $Cname = $_POST['name'];     
        }
        if ($CAge != $_POST['age']){
            $changes .= "CHILD_AGE FROM ".$CAge." TO ".$_POST['age']."; ";
            $CAge = $_POST['age'];    
        }
        if ($Cgender != $_POST['gender']){
            $changes .= "CHILD_GENDER FROM ".$Cgender." TO ".$_POST['gender']."; ";
            $Cgender = $_POST['gender'];    
        }
        if ($CDoB != $_POST['dob']){
            $changes .= "CHILD_DOB FROM ".$CDoB." TO ".$_POST['dob']."; ";
            $CDob = $_POST['dob'];    
        }
        if ($CBform != $_POST['bform']){
            $changes .= "CHILD_BFORM FROM ".$CBform." TO ".$_POST['bform']."; ";
            $CBform = $_POST['bform'];    
        }

        $Mid = $_POST['IDmom'];
           
        if ($Mname != $_POST['namemom']){
            $changes .= "MOM_NAME FROM ".$Mname." TO ".$_POST['namemom']."; ";
            $Mname = $_POST['namemom'];    
        }
        
        if ($Mcnic != $_POST['cnicmom']){
            $changes .= "MOM_CNIC FROM ".$Mcnic." TO ".$_POST['cnicmom']."; ";
            $Mcnic = $_POST['cnicmom']; 
        }
        
        if ($Maddress != $_POST['addressmom']){
            $changes .= "MOM_ADDRESS FROM ".$Maddress." TO ".$_POST['addressmom']."; ";
            $Maddress = $_POST['addressmom']; 
        }
        if ($Memail != $_POST['emailmom']){
            $changes .= "MOM_EMAIL FROM ".$Memail." TO ".$_POST['emailmom']."; ";
            $Memail = $_POST['emailmom']; 
        }
        
        if ($Mcontact != $_POST['contactmom']){
            $changes .= "MOM_CONTACT FROM ".$Fcontact." TO ".$_POST['contactmom']."; ";
            $Mcontact = $_POST['contactmom']; 
        }

        if ($Fname != $_POST['namedad']){
            $changes .= "DAD_NAME FROM ".$Fname." TO ".$_POST['namedad']."; ";
            $Fname = $_POST['namedad'];    
        }
        
        if ($Fcnic != $_POST['cnicdad']){
            $changes .= "DAD_CNIC FROM ".$Fcnic." TO ".$_POST['cnicdad']."; ";
            $Fcnic = $_POST['cnicdad']; 
        }
        
        if ($Faddress != $_POST['addressdad']){
            $changes .= "DAD_ADDRESS FROM ".$Faddress." TO ".$_POST['addressdad']."; ";
            $Faddress = $_POST['addressdad']; 
        }
        if ($Femail != $_POST['emaildad']){
            $changes .= "DAD_EMAIL FROM ".$Femail." TO ".$_POST['emaildad']."; ";
            $Femail = $_POST['emaildad']; 
        }
        
        if ($Fcontact != $_POST['contactdad']){
            $changes .= "DAD_CONTACT FROM ".$Fcontact." TO ".$_POST['contactdad']."; ";
            $Fcontact = $_POST['contactdad']; 
        }

        $Fid = $_POST['IDdad'];
        // $Fname = $_POST['namedad'];
        // $Fcnic = $_POST['cnicdad'];
        // $Faddress = $_POST['addressdad'];
        // $Femail = $_POST['emaildad'];
        // $Fcontact = $_POST['contactdad'];
        
        if ($Gname != $_POST['nameG']){
            $changes .= "GUARD_NAME FROM ".$Gname." TO ".$_POST['nameG']."; ";
            $Fname = $_POST['namedad'];    
        }
        
        if ($Gcnic != $_POST['cnicG']){
            $changes .= "GUARD_CNIC FROM ".$Gcnic." TO ".$_POST['cnicG']."; ";
            $Gcnic = $_POST['cnicG']; 
        }
        if ($Ggender != $_POST['genderG']){
            $changes .= "GUARD_GENDER FROM ".$Ggender." TO ".$_POST['genderG']."; ";
            $Ggender = $_POST['genderG']; 
        }
        if ($Gcontact != $_POST['contactG']){
            $changes .= "GUARD_CONTACT FROM ".$Gcontact." TO ".$_POST['contactG']."; ";
            $Gcontact = $_POST['contactG']; 
        }
        if ($Grelation != $_POST['relationG']){
            $changes .= "GUARD_RELATION FROM ".$Grelation." TO ".$_POST['relationG']."; ";
            $Grelation = $_POST['relationG']; 
        }

        $Gid = $_POST['IDG'];
        // $Gname = $_POST['nameG'];
        // $Gcnic = $_POST['cnicG'];
        // $Ggender = $_POST['genderG'];
        // $Gcontact = $_POST['contactG'];
        // $Grelation = $_POST['relationG'];
        if ($fee != $_POST['fee']){
            $changes .= "ADMISSION_FEE FROM ".$fee." TO ".$_POST['fee']."; ";
            $fee = $_POST['fee']; 
        }
        if ($discount != $_POST['discount']){
            $changes .= "ADMISSION_DISCOUNT FROM ".$discount." TO ".$_POST['discount']."; ";
            $discount = $_POST['discount']; 
        }
        if ($fullamt != $_POST['finalamount']){
            $changes .= "ADMISSION_FINAL_AMOUNT FROM ".$fullamt." TO ".$_POST['finalamount']."; ";
            $fullamt = $_POST['finalamount']; 
        }
        if ($feepaid != $_POST['feepaid']){
            $changes .= "ADMISSION_FEE_PAID FROM ".$feepaid." TO ".$_POST['feepaid']."; ";
            $feepaid = $_POST['feepaid']; 
        }
        if ($date != $_POST['date']){
            $changes .= "ADMISSION_DATE FROM ".$date." TO ".$_POST['date']."; ";
            $date = $_POST['date']; 
        }
        // $fee = $_POST['fee'];
        // $discount = $_POST['discount'];
        // $fullamt = $_POST['finalamount'];
        // $feepaid = $_POST['feepaid'];
        // $date = $_POST['date'];


        $con = Establish_Connection();
        $query = "select count(*) COUNT from HB_STUDENT_HISTORY";
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

        $shID = 'SH-';
        while($counter>0)
        {
            $shID .='0';
            $counter --;
        }
        $shID .= $data["COUNT"]+1;
        echo $changes;

        /* INSERT IN HB_STUDENT_HISTORY */
        $QstuHist = "INSERT INTO HB_STUDENT_HISTORY(SH_ID, STUDENT_ID, CHANGES) VALUES('".$shID."', '".$Stu_ID."', '".$changes."')";
        echo $QstuHist;
        $qid = oci_parse($con,$QstuHist);
        $qexec = oci_execute($qid);

        $upChildQ = "UPDATE HB_CHILD SET NAME = '".$Cname."', DOB = '".$CDoB."', GENDER = '".$Cgender."', AGE = '".$CAge."', B_FORM = '".$CBform."'
        WHERE CHILD_ID = ".$Cid; 
        $qid = oci_parse($con,$upChildQ);
        $qexec = oci_execute($qid);
        if ($qexec){
            echo "CHILD UPDATED<br>";
        }

        $upMomQ = "UPDATE HB_ADULT SET NAME = '".$Mname."', CONTACT = '".$Mcontact."', CNIC = '".$Mcnic."', ADDRESS = '".$Maddress."', EMAIL = '".$Memail."' 
        WHERE PERSON_ID = ".$Mid; 
        $qid = oci_parse($con,$upMomQ);
        $qexec = oci_execute($qid);
        if ($qexec){
            echo "MOM UPDATED<br>";
        }

        $upDadQ = "UPDATE HB_ADULT SET NAME = '".$Fname."', CONTACT = '".$Fcontact."', CNIC = '".$Fcnic."', ADDRESS = '".$Faddress."', EMAIL = '".$Femail."' 
        WHERE PERSON_ID = ".$Fid; 
        $qid = oci_parse($con,$upDadQ);
        $qexec = oci_execute($qid);
        if ($qexec){
            echo "DAD UPDATED<br>";
        }

        $upGuardQ = "UPDATE HB_ADULT SET NAME = '".$Gname."', CONTACT = '".$Gcontact."', CNIC = '".$Gcnic."', GENDER = '".$Ggender."'
        WHERE PERSON_ID = ".$Gid; 
        $qid = oci_parse($con,$upGuardQ);
        $qexec = oci_execute($qid);
        if ($qexec){
            echo "GUARDIAN UPDATED<br>";
        }

        $upGuardRQ = "UPDATE HB_GUARDIAN SET RELATION = '".$Grelation."' WHERE PERSON_ID = ".$Gid; 
        $qid = oci_parse($con,$upGuardRQ);
        $qexec = oci_execute($qid);
        if ($qexec){
            echo "GUARDIAN RELATION UPDATED<br>";
        }

        $upfeeQ = "UPDATE HB_ADMITTED_STUDENT SET FEE_AMOUNT = ".$fee.", DISCOUNT = ".$discount.", FINAL_AMOUNT = ".$fullamt.", IS_PAID = ".$feepaid.", JOIN_DATE = to_date('".$date."','DD-MON-YY')
         WHERE STUDENT_ID = '".$Stu_ID."'"; 
        $qid = oci_parse($con,$upfeeQ);
        $qexec = oci_execute($qid);
        if ($qexec){
            echo "ADMITTED STUDENT UPDATED<br>";
        }
    }
?>


<?php

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