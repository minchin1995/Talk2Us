<?php
include "database_conn.php"; //include database

//Provide front end validation if email exist for forgetting password
if(isset($_POST["email"])){ 
	    //obtain email from forget password 
        $email = filter_has_var(INPUT_POST, 'email') ? $_POST['email']: null;

        //trim blank space before and after data
        $email = trim($email); 
		
		$sqlEmailCheck = "SELECT userID
							  FROM user
							  WHERE email='$email'";
								
		// query sql statement
		$rsEmailCheck = mysqli_query($conn,$sqlEmailCheck)
								or die(mysqli_error($conn));
								
								
		if (mysqli_affected_rows($conn)===0){ //if email exists
			echo "{\"statusFor\":\"error\",\"message\":[{\"textFor\":\"Sorry the email is not registered as an account.\"}]}";
		}else{
			echo "{\"statusFor\":\"success\",\"message\":[{\"textFor\":\"success.\"}]}";
		}

}else {
	echo "{\"statusFor\":\"error\",\"message\":[{\"textFor\":\"Error.\"}]}";
}
?>