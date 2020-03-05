<?php
ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
session_start();

include "database_conn.php"; //include database

if(isset($_SESSION['userID'])){
	//get username of user logged in
	$username = $_SESSION['username'];
	//get userID of user logged in
	$userID = $_SESSION['userID'];
	//get role of user when user is logged in
	$accountID = $_SESSION['role'];
	//get the generated username of user
	$usernameGen = $_SESSION['usernameGen'];
}

if(isset($_SESSION['userID'])){
	/**
	* Add post to a topic
	*/
	if((isset($_POST["topicID"]))&&(isset($_POST["message"]))){ 
			$topicID = filter_has_var(INPUT_POST, 'topicID') ? $_POST['topicID']: null;
			$message = filter_has_var(INPUT_POST, 'message') ? $_POST['message']: null;
			
			//sanitiza data
			$message	   	= filter_var($message,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			$message 	   	= filter_var($message,FILTER_SANITIZE_SPECIAL_CHARS);

			//trim blank space before and after data
			$topicID = trim($topicID); 
			$message = trim($message); 
			
			//set timezone
			date_default_timezone_set("Asia/Kuala_Lumpur");
			// get current time
			$time = date("H:i:s");
			// get current date
			$date = date("Y-m-d");
			
			$arrayBanned = file('censor/censored.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
				
			$matchedWords = array();
			$foundMatch = preg_match_all("/(" . implode($arrayBanned,"|") . ")/i", $message, $matchedWords);

			if ($foundMatch) {
				$foundWords = array_unique($matchedWords[0]);
				$newMessage = str_replace($foundWords, "*", $message); //censor off social mdeia link
				
				//Add post to topic
				$sqlAddPost = "INSERT INTO forumpost 
							 SET userID='$userID',
							 content='$newMessage',
							 date='$date',
							 time='$time',
							 topicID='$topicID'";
												
				// query sql statement
				$rsAddPost = mysqli_query($conn,$sqlAddPost)
							or die(mysqli_error($conn));
									
									
				if (mysqli_affected_rows($conn)>0){
					echo "{\"statusPost\":\"success\",\"message\":[{\"textPost\":\"Post successfully added.\"}]}";
				}else{
					echo "{\"statusPost\":\"error\",\"message\":[{\"textPost\":\"Unable to add post!\"}]}";
				}
			}else{
				//Add post to topic
				$sqlAddPost = "INSERT INTO forumpost 
							 SET userID='$userID',
							 content='$message',
							 date='$date',
							 time='$time',
							 topicID='$topicID'";
												
				// query sql statement
				$rsAddPost = mysqli_query($conn,$sqlAddPost)
							or die(mysqli_error($conn));
									
									
				if (mysqli_affected_rows($conn)>0){
					echo "{\"statusPost\":\"success\",\"message\":[{\"textPost\":\"Post successfully added.\"}]}";
				}else{
					echo "{\"statusPost\":\"error\",\"message\":[{\"textPost\":\"Unable to add post!\"}]}";
				}
			}

	}else {
		echo "{\"statusPost\":\"error\",\"message\":[{\"textPost\":\"Error.\"}]}";
	}
} else {
	echo nolog();
}
?>