<?php
ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
session_start();

include "database_conn.php"; //include database

if(isset($_SESSION['userID'])){
	//Provide front end validation if user is already assigned to the group selected for assigning group support
	if((isset($_POST["userID"]))&&(isset($_POST["topic"]))){
		$userID		=	filter_has_var(INPUT_POST, 'userID') ? $_POST['userID']: null;
		$topic		=	filter_has_var(INPUT_POST, 'topic') ? $_POST['topic']: null;

		//sanitize data
		$userID	    = filter_var($userID,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$userID 	    = filter_var($userID,FILTER_SANITIZE_SPECIAL_CHARS);
		$topic	    = filter_var($topic,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$topic 	    = filter_var($topic,FILTER_SANITIZE_SPECIAL_CHARS);
		
		//remove space both before and after the data
		$userID		=	trim($userID);
		$topic		=	trim($topic);

		// check if user is already assigned to the topic chosen		
		$sqlCheck = "SELECT supportuser.sTopicID
					FROM supportuser JOIN supporttopic ON (supportuser.sTopicID=supporttopic.sTopicID)
					WHERE userID='$userID'
					AND sTopicName='$topic'";
									
			// query sql statement
		$rsCheck = mysqli_query($conn,$sqlCheck)
					or die(mysqli_error($conn));

		if (mysqli_affected_rows($conn)>0){ 
			echo "{\"statusGS\":\"error\",\"message\":[{\"textGS\":\"User is already assigned to this topic.\"}]}";
		} else{
			echo "{\"statusGS\":\"success\",\"message\":[{\"textGS\":\"Success.\"}]}";
		}
	}else {
		echo "{\"statusGS\":\"error\",\"message\":[{\"textGS\":\"Error.\"}]}";
	}
} else {
	echo nolog();
}