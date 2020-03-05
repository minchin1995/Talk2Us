<?php
include "database_conn.php"; //include database

//Provide front end validation for login
if((isset($_POST["userName"]))&&(isset($_POST["passwd"]))){ 
        $userName = filter_has_var(INPUT_POST, 'userName') ? $_POST['userName']: null;
        $passWord  = filter_has_var(INPUT_POST, 'passwd') ? $_POST['passwd']: null;

        //trim blank space before and after data
        $userName = trim($userName); 
        $passWord = trim($passWord);

        //Obtain hashed password from database
        $sql = "SELECT passwordHash, userID, verified, banned
				FROM user
				WHERE userName = ?";
           
		// prepare sql statement
        $stmt = mysqli_prepare($conn, $sql);	
  
        //Bind the $username entered
        mysqli_stmt_bind_param($stmt, "s", $userName);     
		   
		// execute query
        mysqli_stmt_execute($stmt);

        // store password hash obtained in the variable indicated 
		mysqli_stmt_bind_result($stmt, $passWDHash, $userID, $verified, $banned);

		if (mysqli_stmt_fetch($stmt)) { 
			if (password_verify($passWord, $passWDHash)) {
				if ($verified ==1){
					if ($banned ==0) {
						echo "{\"statusLog\":\"success\",\"message\":[{\"textLog\":\"Success\"}]}";	
					}
					else {
						echo "{\"statusLog\":\"error\",\"message\":[{\"textLog\":\"Sorry you are banned. Any problems please visit the contact page to contact the admin.\"}]}";	
					}
				} else {
					echo "{\"statusLog\":\"error\",\"message\":[{\"textLog\":\"Please verify your account before proceeding.\"}]}";	
				}
				
			}
			else {
				//error if password is incorrect
				echo "{\"statusLog\":\"error\",\"message\":[{\"textLog\":\"Password is incorrect. Please try again.\"}]}";	
			}
		}
		else {
			//error message if username doesn't exist
			echo "{\"statusLog\":\"error\",\"message\":[{\"textLog\":\"Sorry we don't seem to have that username.\"}]}";	
		}

		mysqli_stmt_close($stmt); 
		mysqli_close($conn);
}else {
	echo "{\"statusLog\":\"error\",\"message\":[{\"textLog\":\"Error.\"}]}";
}
?>