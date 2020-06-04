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
            <h1><b>Class Creation Form</b></h1>
        </div>

        <form method="post" id="inn">   
        <fieldset style="font-size: x-large;">
            <legend style="color:yellow;">Class Information</legend>
        <br>
        <center>
        <table>
            <tr>
                <td width=250>
                    <center><b> Class ID </b></center>
                </td>
                <td width=250>
                        <center>
                        <div class="form-group" style="font-size:x-large;border:2px grey solid">
                                <input type="text" placeholder="Class ID" required class="form-input" name="class_id" value=<?php if ($_POST){ echo $_POST['class_id'];} else{ echo "";}?>>
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
                                <input type="text" placeholder="Section ID" required class="form-input" name="section_id" value=<?php if ($_POST){ echo $_POST['section_id'];} else{ echo "";}?>>
                        </div>
                        </center>

                </td>
            </tr>
            <tr>
                <td width=250>
                    <center><b> Title Section </b></center>
                </td>
                <td width=250>
                        <center>
                        <div class="form-group" style="font-size:x-large;border:2px grey solid">
                                <input type="text" placeholder="Title" required class="form-input" name="title" value=<?php if ($_POST){ echo $_POST['title'];} else{ echo "";}?>>
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
            <button type="submit" name="submit" value="Submit" class="btn btn-login" style="margin-left: 2rem;" onclick="return validate()">Create Class</button>
            <a href="Class_Creation.php" style="color: white;text-decoration:none"><button type="button" class="btn btn-login" style="margin-left: 2rem;"> RESET FIELDS </button></a>
        <a href="home_page.html" style="color: white;text-decoration:none"><button type="button" class="btn btn-login" style="margin-left: 2rem;">GO BACK </button></a>
        </center>
        </form>
       <br><br><br><br>
    </body>

    <?php
		$con = makeConnection();
        if(isset($_POST["submit"]))
        {
            $CLASS_ID = $_POST['class_id'];
            $SECTION_ID = $_POST["section_id"];
            $TITLE = $_POST["title"];

            $CLASS_EXISTS = 0;
            $SECTION_EXISTS = 0;
        
            //CREATE NEW CLASS IN CLASS TABLE
            $query = "SELECT * FROM HB_SECTION";
            $query_id = oci_parse($con,$query);
            $query_execute = oci_execute($query_id);
            while($row = oci_fetch_array($query_id, OCI_BOTH+OCI_RETURN_NULLS)){
                if ($row['CLASS_ID']==$CLASS_ID){
                    
                    $CLASS_EXISTS = 1;
                    if ($row['SECTION_ID']==$SECTION_ID){
                        $SECTION_EXISTS = 1;
                    }
                    
                }
            }

            if (!$CLASS_EXISTS){
                $query = "INSERT INTO HB_CLASS(CLASS_ID) VALUES(".$CLASS_ID.")";
                parseQuery($query);
                echo "<br>NEW CLASS INSERTED!<br>";
                $query = "INSERT INTO HB_SECTION(CLASS_ID, SECTION_ID, TITLE) VALUES(".$CLASS_ID.", '".$SECTION_ID."', '".$TITLE."')";
                parseQuery($query);
                echo "<br>NEW SECTION INSERTED!<br>";
            }
            else if ($CLASS_EXISTS == 1 && !$SECTION_EXISTS){
                $query = "INSERT INTO HB_SECTION(CLASS_ID, SECTION_ID, TITLE) VALUES(".$CLASS_ID.", '".$SECTION_ID."', '".$TITLE."')";
                parseQuery($query);
                echo "<br>NEW SECTION INSERTED!<br>";
            }
            else {
                echo "<br>SORRY!<br>CLASS AND SECTION ALREADY EXIST<br><br>";
            }

        }
    ?>
	
	<?php
		function parseQuery($query){
			$con = makeConnection();
			$query_id = oci_parse($con,$query);
			$query_execute = oci_execute($query_id);
		}		
	?>

</html>