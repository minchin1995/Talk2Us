<?php
ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
session_start();

include "database_conn.php"; //include database

if(isset($_SESSION['userID'])){
	if(isset($_POST["genUname"])){ 		
		$genUname			=	filter_has_var(INPUT_POST, 'genUname') ? $_POST['genUname']: null;
		
		//sanitize data
		$genUname	    	= filter_var($genUname,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$genUname 	    = filter_var($genUname,FILTER_SANITIZE_SPECIAL_CHARS);
		
		//remove space both before and after the data
		$genUname			=	trim($genUname);
			
		// check if user name or email is the same
		$sqlUserCheck = "SELECT username, email
							 FROM user
							  WHERE usernameGen='$genUname'";
									
		// query sql statement
		$rsUserCheck = mysqli_query($conn,$sqlUserCheck)
						  or die(mysqli_error($conn));
			
		$row = mysqli_fetch_row($rsUserCheck)
				or die(mysqli_error($conn));
		
		//execute each field
		$username = $row[0];
		$email = $row[1];

		if (mysqli_affected_rows($conn)>0){ 
			echo "{\"result\":\"$username\", \"result2\":\"$email\"}";
		} else{
			echo "{\"result\":\"error\", \"result2\":\"error\"}";
		}
	}else {
		echo "{\"result\":\"error\", \"result2\":\"error\"}";
	}
} else {
	echo nolog();
}
?>