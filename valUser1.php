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
	//Provide front end validation if email and username already exust for updating user details
	if((isset($_POST["username"]))&&(isset($_POST["email"]))){ 
		$username		=	filter_has_var(INPUT_POST, 'username') ? $_POST['username']: null;
		$email		=	filter_has_var(INPUT_POST, 'email') ? $_POST['email']: null;

		//sanitize data
		$username	    = filter_var($username,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$username 	    = filter_var($username,FILTER_SANITIZE_SPECIAL_CHARS);
		$email	    = filter_var($email,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$email 	    = filter_var($email,FILTER_SANITIZE_SPECIAL_CHARS);
		
		//remove space both before and after the data
		$username	=	trim($username);
		$email	=	trim($email);
			
		// check if username already exists		
		$sqlCheck = "SELECT username
						FROM user
						WHERE username='$username'";
								
		// query sql statement
		$rsCheck = mysqli_query($conn,$sqlCheck)
						or die(mysqli_error($conn));
				
				
		if (mysqli_affected_rows($conn)>0){ 
			echo "{\"statusU\":\"errorU\",\"message\":[{\"textU\":\"Sorry username already exists.\"}]}";
		} else{
			// check if email already exists		
			$sqlCheck = "SELECT email
							FROM user
							WHERE email='$email'";
									
			// query sql statement
			$rsCheck = mysqli_query($conn,$sqlCheck)
							or die(mysqli_error($conn));
				
				
			if (mysqli_affected_rows($conn)>0){ 
				echo "{\"statusU\":\"errorM\",\"message\":[{\"textU\":\"Sorry email already exists.\"}]}";
			}else{
				echo "{\"statusU\":\"success\",\"message\":[{\"textU\":\"Success.\"}]}";
			}
		}
	}else {
		echo "{\"statusU\":\"error\",\"message\":[{\"textU\":\"Error.\"}]}";
	}
} else {
	echo nolog();
}
?>