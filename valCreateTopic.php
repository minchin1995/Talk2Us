<?php
ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
session_start();

include "database_conn.php"; //include database

if(isset($_SESSION['userID'])){
	//Provide front end validation if topic name already exist for create forum topic
	if(isset($_POST["topicName"])){ 
		$topicName		=	filter_has_var(INPUT_POST, 'topicName') ? $_POST['topicName']: null;

		//sanitize data
		$topicName	    = filter_var($topicName,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$topicName 	    = filter_var($topicName,FILTER_SANITIZE_SPECIAL_CHARS);
		
		//remove space both before and after the data
		$topicName	=	trim($topicName);
			
			// check if topic already exists		
		$sqlCheck = "SELECT topicID
						FROM forumtopic
						WHERE topicName='$topicName'";
								
		// query sql statement
		$rsCheck = mysqli_query($conn,$sqlCheck)
						or die(mysqli_error($conn));
				
				
			if (mysqli_affected_rows($conn)>0){ 
				echo "{\"statusDB\":\"error\",\"message\":[{\"textDB\":\"Sorry topic already exists.\"}]}";
			} else{
				echo "{\"statusDB\":\"success\",\"message\":[{\"textDB\":\"Success.\"}]}";
			}
	}else {
		echo "{\"statusDB\":\"error\",\"message\":[{\"textDB\":\"Error.\"}]}";
	}
} else {
	echo nolog();
}
?>