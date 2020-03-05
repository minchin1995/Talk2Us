<?php
ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
session_start();

include "database_conn.php"; //include database

if(isset($_SESSION['userID'])){
	//Provide front end validation if topic name already exist for editing group support topic
	if(isset($_POST["topicName"])){ 
			$topicName			=	filter_has_var(INPUT_POST, 'topicName') ? $_POST['topicName']: null;
			
			//sanitize data
			$topicName	    	= filter_var($topicName,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			$topicName 	    	= filter_var($topicName,FILTER_SANITIZE_SPECIAL_CHARS);
			
			//remove space both before and after the data
			$topicName			=	trim($topicName);
			
			// check if topic already exists		
			$sqlCheck = "SELECT sTopicID
							FROM supporttopic
							WHERE sTopicName='$topicName'";
									
			// query sql statement
			$rsCheck = mysqli_query($conn,$sqlCheck)
							or die(mysqli_error($conn));
				
			if (mysqli_affected_rows($conn)>0){ 
				echo "{\"statusGS\":\"error\",\"message\":[{\"textGS\":\"Sorry, the topic already exist.\"}]}";
			} else{
				echo "{\"statusGS\":\"success\",\"message\":[{\"textGS\":\"Success.\"}]}";
			}
	}else {
		echo "{\"statusGS\":\"error\",\"message\":[{\"textGS\":\"Error.\"}]}";
	}
} else {
	echo nolog();
}
?>