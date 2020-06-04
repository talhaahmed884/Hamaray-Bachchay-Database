<html>

    <head>
        <title>Class Assignment Form</title>
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
    

    <body style="color: lightcoral;overflow:auto;background-image: url('./assets/img3.png');background-repeat: no-repeat;background-size: 100% 100%;background-attachment: fixed;">
        <div class = "a">
            <h1><b>Hamarey Bachchay</b></h1>
            <h1><b>Class Assignment Form</b></h1>
        </div>

        <form method="post" id="inn">   
        <fieldset style="font-size: x-large;">
            <legend style="color:yellow;">Student Current Information</legend>
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
                                <input type="text" placeholder="HB-XXXX" required class="form-input" name="student_id" value=<?php if ($_POST){ echo $_POST['student_id'];} else{ echo "";}?>>
                        </div>
                        </center>

                </td>
            </tr>
            <tr>
                <td width=250>
                    <center><b> Current Class </b></center>
                </td>
                <td width=250>
                        <center>
                        <div class="form-group" style="font-size:x-large;border:2px grey solid">
                                <input type="text" placeholder="Class ID" required class="form-input" name="current_class" value=<?php if ($_POST){ echo $_POST['current_class'];} else{ echo "";}?>>
                        </div>
                        </center>

                </td>
            </tr>
            <tr>
                <td width=250>
                    <center><b> Current Section </b></center>
                </td>
                <td width=250>
                        <center>
                        <div class="form-group" style="font-size:x-large;border:2px grey solid">
                                <input type="text" placeholder="Section ID" required class="form-input" name="current_section" value=<?php if ($_POST){ echo $_POST['current_section'];} else{ echo "";}?>>
                        </div>
                        </center>

                </td>
            </tr>
        </table>        
        </fieldset>

        <br><br>
        <fieldset style="font-size: x-large;height:19rem">
            <legend style="color:yellow;">Student Transfer Information</legend> 
        <br> 
        <center>
        <table>
            <tr>
                <td width=250>
                    <center><b> New Class </b></center>
                </td>
                <td width=250>
                        <center>
                        <div class="form-group" style="font-size:x-large;border:2px grey solid">
                                <input type="text" placeholder="New Class ID" required class="form-input" name="new_class" value=<?php if ($_POST){ echo $_POST['new_class'];} else{ echo "";}?>>
                        </div>
                        </center>

                </td>
            </tr>
            <tr>
                <td width=250>
                    <center><b> New Section </b></center>
                </td>
                <td width=250>
                        <center>
                        <div class="form-group" style="font-size:x-large;border:2px grey solid">
                                <input type="text" placeholder="New Section ID" required class="form-input" name="new_section" value=<?php if ($_POST){ echo $_POST['new_section'];} else{ echo "";}?>>
                        </div>
                        </center>

                </td>
            </tr>
            <tr>
                <td width=250>
                    <center><b> Reason For Change </b></center>
                </td>
                <td width=250>
                        <center>
                        <div class="form-group" style="font-size:x-large;border:2px grey solid">
                                <input type="text" placeholder="Max 40 Characters" required class="form-input" name="reason" value=<?php if ($_POST){ echo $_POST['reason'];} else{ echo "";}?>>
                        </div>
                        </center>

                </td>
            </tr>
            <tr>
                <td width=250>
                    <center><b> Approved By </b></center>
                </td>
                <td width=250>
                        <center>
                        <div class="form-group" style="font-size:x-large;border:2px grey solid">
                                <input type="text" placeholder="Employee ID" required class="form-input" name="approved" value=<?php if ($_POST){ echo $_POST['approved'];} else{ echo "";}?>>
                        </div>
                        </center>

                </td>
            </tr>
        </table> 
        </center>       
        </fieldset>
        <br><br>
        <center>
            <button type="submit" name="submit" value="Submit" class="btn btn-login" style="margin-left: 2rem;" onclick="return validate()">CHANGE CLASS</button>
            <a href="New_Class_Assign.php" style="color: white;text-decoration:none"><button type="button" class="btn btn-login" style="margin-left: 2rem;"> RESET FIELDS</button> </a>
			<a href="home_page.html" style="color: white;text-decoration:none"><button type="button" class="btn btn-login" style="margin-left: 2rem;">GO BACK </button></a>        
        </center>
        </form>
       <br><br><br><br>
    </body>

    <?php
        // ESTABLISH CONNECTION
		$db_sid = "(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = Turab-PC)(PORT = 1521)))
		(CONNECT_DATA = (SID = orcl) ) )";
		$db_user = "scott";
		$db_pass = "1234";
		$con = oci_connect($db_user,$db_pass,$db_sid);
        if(isset($_POST["submit"]))
        {
            $student_id = $_POST["student_id"];
            $current_class = $_POST["current_class"];
            $current_section = $_POST["current_section"];
            $new_class = $_POST["new_class"];
            $new_section = $_POST["new_section"];
            $reason = $_POST["reason"];
            $approved = $_POST["approved"];

            if($student_id!=NULL && $current_class!=NULL && $reason!=NULL)
            {
                $query = "select REG_ID REG_ID FROM HB_REGISTERATION where STUDENT_ID = '$student_id'";
                $query_id = oci_parse($con,$query);
                $query_execute = oci_execute($query_id);
                $data = oci_fetch_array($query_id,OCI_BOTH);
                $reg_id = $data["REG_ID"];

                if($reg_id != NULL)
                {
                    $query = "SELECT CLASS_ID CLASS_ID FROM HB_CLASS";
                    $query_id = oci_parse($con,$query);
                    $query_execute = oci_execute($query_id);
                    
                    $check_one = 0;
                    $check_two = 0;
                    while($data = oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS))
                    {
                        if($current_class == $data["CLASS_ID"])
                        {
                            $check_one = 1;
                        }
                        if($new_class == $data["CLASS_ID"])
                        {
                            $check_two = 1;
                        }
                    }

                    $query = "SELECT SECTION_ID SECTION_ID FROM HB_SECTION";
                    $query_id = oci_parse($con,$query);
                    $query_execute = oci_execute($query_id);

                    $check_three = 0;
                    $check_four = 0;
                    while($data = oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS))
                    {
                        if($current_section == $data["SECTION_ID"])
                        {
                            $check_three = 1;
                        }
                        if($new_section == $data["SECTION_ID"])
                        {
                            $check_four = 1;
                        }
                    }

                    if($check_one == 1 && $check_two == 1 && $check_three == 1 && $check_four == 1)
                    {
                        $query = "UPDATE HB_CLASS_ASSIGNMENT SET CLASS_ID = '$new_class', SECTION_ID = '$new_section' WHERE REG_ID = '$reg_id'";
                        $query_id = oci_parse($con,$query);
                        $query_execute = oci_execute($query_id);
        
                        if($query_execute == 1)
                        {
                            $query = "select count(*) COUNT from HB_NEW_CLASS_ASSIGNMENT";
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
            
                            $nca_id = 'NCA-';
                            while($counter>0)
                            {
                                $nca_id .='0';
                                $counter --;
                            }
                            $nca_id .= $data["COUNT"]+1;
            
                            $query = "INSERT INTO HB_NEW_CLASS_ASSIGNMENT(NCA_ID, STUDENT_ID, CLASS_ID, SECTION_ID, NEW_CLASS_ID, NEW_SECTION_ID, REASON, EMP_ID)
                            VALUES ('$nca_id', '$student_id', '$current_class', '$current_section', '$new_class', '$new_section', TO_CHAR('$reason'), '$approved')";
                            $query_id = oci_parse($con,$query);
                            $query_execute = oci_execute($query_id);
    
							if($query_execute){
								$query = "select count(*) COUNT from HB_CLASS_ASSIGNMENT_HIST";
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
				
								$cid_id = 'CID-';
								while($counter>0)
								{
									$cid_id .='0';
									$counter --;
								}
								$cid_id .= $data["COUNT"]+1;
				
								
								
								$query = "INSERT INTO HB_CLASS_ASSIGNMENT_HIST(CLASS_ID_HISTORY, CLASS_ID, SECTION_ID, REG_ID)
								VALUES ('$cid_id', '$new_class', '$new_section', '$reg_id')";
								$query_id = oci_parse($con,$query);
								$query_execute = oci_execute($query_id);
			
								if($query_execute == 1)
								{
									//echo "<b style=color:blue>Insertion Successful!!</b>";
									echo "<script type='text/javascript'>alert('SUBMISSION SUCCESSFUL!');document.getElementById('inn').reset();</script>";
		 
								}
								else
								{
									echo "<b style=color:red>Insertion Unsuccessful!!</b>";
								}
							}
							else{
								$query = "UPDATE HB_CLASS_ASSIGNMENT SET CLASS_ID = '$current_class', SECTION_ID = '$current_section' WHERE REG_ID = '$reg_id'";
								$query_id = oci_parse($con,$query);
								$query_execute = oci_execute($query_id);
							}
                        }
                        else
                        {
                            echo "<b style=color:red>Insertion Unsuccessful!!</b><br>";
                            echo "<b style=color:red>Provided Information is wrong. Kinldy re-enter the data.</b>";
                        }    
                    }
                    else
                    {
                        echo "<b style=color:red>Insertion Unsuccessful!!</b><br>";
                        echo "<b style=color:red>Provided Class or Section is wrong. Kinldy re-enter the data.</b>";
                    }
                }
                else
                {
                    echo "<b style=color:red>Insertion Unsuccessful!!</b><br>";
                    echo "<b style=color:red>Student ID is wrong. Kinldy re-enter the data.</b>";
                }
            }
            else
            {
                echo "<b style=color:red>Insertion Unsuccessful!!</b><br>";
                echo "<b style=color:red>Required enteries are null. Kinldy re-enter the data.</b>";
            }
        }
    ?>

</html>