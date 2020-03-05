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
	//Provide front end validation if username already exist for updating user details
	if(isset($_POST["username"])){ 
		$username		=	filter_has_var(INPUT_POST, 'username') ? $_POST['username']: null;

		//sanitize data
		$username	    = filter_var($username,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$username 	    = filter_var($username,FILTER_SANITIZE_SPECIAL_CHARS);
		
		//remove space both before and after the data
		$username	=	trim($username);
			
		// check if username already exists		
		$sqlCheck = "SELECT username
						FROM user
						WHERE username='$username'";
								
		// query sql statement
		$rsCheck = mysqli_query($conn,$sqlCheck)
						or die(mysqli_error($conn));
				
				
		if (mysqli_affected_rows($conn)>0){ 
			echo "{\"statusU\":\"error\",\"message\":[{\"textU\":\"Sorry username already exists.\"}]}";
		} else{
			echo "{\"statusU\":\"success\",\"message\":[{\"textU\":\"Success.\"}]}";
		}
	}else {
		echo "{\"statusU\":\"error\",\"message\":[{\"textU\":\"Error.\"}]}";
	}
} else {
	echo nolog();
}
?>