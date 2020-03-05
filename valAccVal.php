<?php
	
include "database_conn.php"; //include database

//Provide front end validation for validating account
if(isset($_POST["email"])){ 
	//obtain email from forget password 
	$email = filter_has_var(INPUT_POST, 'email') ? $_POST['email']: null;

	//trim blank space before and after data
	$email = trim($email); 
	
	//check if email exists
	$sqlEmailCheck = "SELECT userID
					 FROM user
					 WHERE email='$email'";
									
	// query sql statement
	$rsEmailCheck = mysqli_query($conn,$sqlEmailCheck)
					or die(mysqli_error($conn));
									
									
	if (mysqli_affected_rows($conn)===0){ //if email exists
		echo "{\"statusFor\":\"error\",\"message\":[{\"textFor\":\"Sorry the email is not registered as an account.\"}]}";
	}else{
		//check if account is already validated
		$sqlEmailValCheck = "SELECT verified
								  FROM user
								  WHERE email='$email'";
									
		// query sql statement
		$rsEmailValCheck = mysqli_query($conn,$sqlEmailValCheck)
									or die(mysqli_error($conn));
				
		$row = mysqli_fetch_row($rsEmailValCheck)
						or die(mysqli_error($conn));
						
		//execute each field
		$verified = $row[0];
				
		if ($verified == "1"){
			echo "{\"statusFor\":\"error\",\"message\":[{\"textFor\":\"Account is already validated.\"}]}";
		}else{
			echo "{\"statusFor\":\"success\",\"message\":[{\"textFor\":\"success.\"}]}";
		}
				
	}

}else {
	echo "{\"statusFor\":\"error\",\"message\":[{\"textFor\":\"Error.\"}]}";
}


?>