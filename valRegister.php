<?php
include "database_conn.php"; //include database

//Provide front end validation if email and username already exist for register
if((isset($_POST["email"]))&&(isset($_POST["userName"]))){ 
        $email = filter_has_var(INPUT_POST, 'email') ? $_POST['email']: null;
        $username = filter_has_var(INPUT_POST, 'userName') ? $_POST['userName']: null;

        //trim blank space before and after data
        $email = trim($email); 
        $username = trim($username); 
		
		//check if email already registered
		$sqlEmailCheck = "SELECT userID
							  FROM user
							  WHERE email='$email'";
								
		// query sql statement
		$rsEmailCheck = mysqli_query($conn,$sqlEmailCheck)
								or die(mysqli_error($conn));
								
								
		if (mysqli_affected_rows($conn)>0){ //if email exists
			echo "{\"statusReg\":\"errorEmail\",\"message\":[{\"textReg\":\"Sorry email is already registered as an account.\"}]}";
		}else{
			//check if username is already used
			$sqlUCheck = "SELECT userID
							  FROM user
							  WHERE username='$username'";
								
			// query sql statement
			$rsUCheck = mysqli_query($conn,$sqlUCheck)
						or die(mysqli_error($conn));
			
			if (mysqli_affected_rows($conn)>0){
				echo "{\"statusReg\":\"errorUname\",\"message\":[{\"textReg\":\"Sorry username is already used.\"}]}";
			}else{
				echo "{\"statusReg\":\"success\",\"message\":[{\"textReg\":\"success.\"}]}";
			}
			
		}

}else {
	echo "{\"statusReg\":\"error\",\"message\":[{\"textReg\":\"Error.\"}]}";
}
?>