<?php
/*
Author: Zhuocheng Shang, Marlon Djouba
Description: This file if set to inserting a new tournament to database.
             And this tounrament should be set as "not approved".
*/

if(!isset($message)){
        //start session to get the ID & email of tournament creator
    session_start();

        //connect DB
    require_once("DBController.php");
    $db_handle = new DBController();

        //get email of the creator
    $email = $_SESSION["email"];

        //get tournament information
    $tmname = $_POST["tmname"]; //tournament name
    $sdate = $_POST["StartDate"]; //start date
    $edate = $_POST["EndDate"]; //end date

        //translate the string type of date to the actual date type
        //which can be understed by PHP and database
    $startDate = date("Y-m-d H:i:s", strtotime($sdate));
    $endDate = date("Y-m-d H:i:s", strtotime($edate));

        //team information in a Tournament 
    $teamSize =  $_POST["teamSize"];
    $teamNum =  $_POST["teamNumber"];

        //check if this Tournament is team based or not
    $type = $_POST["gType"];
    if ($type == 'Team') { 
        $type = 1; //if this tournament is team based, set value to '1'

    } else if($type == 'Individual')  {
            //if it is an individual one, set all value to '0'
        $type = 0; 
        $teamNum = 0;
        $teamSize = 0;
    }

        //get the description about this tournament
    $des = $_POST['description'];

        //set up Sql query and insert tournament into database
        //approved should set as '0' beacuse this tounament is not approved yet
    $query = "insert into Tournament (Name, Descripton,StartDate,EndDate,Approved,isTeamBased,Creator)
                values ('$tmname', '$des','$startDate', '$endDate',0,'$type','$email')";
        //get current tournament id
    $current_id = $db_handle->insertQuery($query); 

        //get number of team 
        //if it is an individual one, the value should be '0'
    for($x =1;$x<=$teamNum;$x++) {

            //generate Team Name
       $teamName = "Team ".$x;

            //insert into team table
       $add_token_query = "INSERT INTO Team (TeamName, TeamLimit,TournamentID) VALUES(\"$teamName\",\"$teamSize\",\"$current_id\")";
       $tokenresult = $db_handle->addTokenQuery($add_token_query);
     }

   
    if(!empty($message)) {
        if(isset($message)) echo $message;
    }

    if(!empty($error_message)) {
        if(isset($error_message)) echo $error_message;
    }

    if(isset($_POST['done']))
    {

	    $file = rand(1000,100000)."-".$_FILES['file']['name'];
        $file_loc = $_FILES['file']['tmp_name'];
	    $file_size = $_FILES['file']['size'];
	    $file_type = $_FILES['file']['type'];
	    $folder="../uploads/";


	        // new file size in KB
	    $new_size = $file_size/1024;
	       
	        // make file name in lower case
	    $new_file_name = strtolower($file);
	
	    $final_file=str_replace(' ','-',$new_file_name);

	    if(move_uploaded_file($file_loc,$folder.$final_file))
	    {
		    $sql="INSERT INTO tbl_uploads(file,type,size) VALUES('$final_file','$file_type','$new_size')";
		    $query= $db_handle->insertQuery($sql);
		    $message = "successfuly upload";
	    }
	    else
	    {

	        $message = "error while uploading file";
	    }
    }

        //if the tounament sucessfullt insert into database
    if (!empty($current_id)) {
            //pop up an alert window and relink to index.php page
        echo "<script> alert('Your tournament is sent. pending');
                window.location.href='../php/index.php'; </script>";
        unset($_POST);
    } else 
    {
      $message = "Problem in registration. Try Again!";
     }


}

?>
