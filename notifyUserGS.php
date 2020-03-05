<?php
ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
session_start();

include "database_conn.php"; //include database
include "cronJobEmail.php";

if(isset($_SESSION['userID'])){
	//get username of user logged in
	$username = $_SESSION['username'];
	//get userID of user logged in
	$userID = $_SESSION['userID'];
	//get role of user when user is logged in
	$accountID = $_SESSION['role'];
}

if(isset($_SESSION['userID'])){
// Notify user in any reply of group support posts
if((isset($_POST["username"]))&&(isset($_POST["topicID"]))){ 
        $username = filter_has_var(INPUT_POST, 'username') ? $_POST['username']: null;
        $topicID = filter_has_var(INPUT_POST, 'topicID') ? $_POST['topicID']: null;
        
		$username	   	= filter_var($username,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$username 	   	= filter_var($username,FILTER_SANITIZE_SPECIAL_CHARS);
		$topicID	   	= filter_var($topicID,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$topicID 	   	= filter_var($topicID,FILTER_SANITIZE_SPECIAL_CHARS);

        //trim blank space before and after data
        $username = trim($username); 
        $topicID = trim($topicID); 
		
		//get email of user
		$sqlCheck = "SELECT email, username
						   FROM user 
						   WHERE usernameGen = '$username'";

		//execute sql statement
		$rsCheck = mysqli_query($conn,$sqlCheck)
						or die(mysqli_error($conn));
				
		if (mysqli_affected_rows($conn)>0){
			$row = mysqli_fetch_row($rsCheck)
					or die(mysqli_error($conn));
		
			//execute each field
			$email = $row[0];
			$realUsername = $row[1];

			emailGS($email, $realUsername, $topicID);
		}else{
			echo "{\"statusPost\":\"error\",\"message\":[{\"textPost\":\"Username does not exist.\"}]}";
		}
		

}else {
	echo "{\"statusPost\":\"error\",\"message\":[{\"textPost\":\"Error.\"}]}";
}
} else {
	echo nolog();
}