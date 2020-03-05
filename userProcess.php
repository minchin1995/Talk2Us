<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	include "database_conn.php"; //connect to database
	
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

	echo makePageStart("Talk2Me - User");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
  
  
<section class="box">
	<div class="container top-content">
		<div class="processDiv">
  <?php
	    //obtain values of field from register form
		$email  	= filter_has_var(INPUT_POST, 'email') ? $_POST['email']: null;
        $userName	= filter_has_var(INPUT_POST, 'userName') ? $_POST['userName']: null;
        $dob  		= filter_has_var(INPUT_POST, 'dob') ? $_POST['dob']: null;
        $passWord  	= filter_has_var(INPUT_POST, 'passwd') ? $_POST['passwd']: null;
        $cpassWord  = filter_has_var(INPUT_POST, 'cpasswd') ? $_POST['cpasswd']: null;

        //trim blank space before and after data
        $email 		= trim($email); 
        $userName 	= trim($userName);
        $dob 		= trim($dob);
        $passWord 	= trim($passWord);
        $cpassWord 	= trim($cpassWord);
		
		//format of username
		$userNameFormat = '/^[a-zA-Z0-9_.-]*$/';
		
		//format of date
		$dateFormat = '/^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/';
		
		//Current date
		$year = date("Y");
		
		$monthDay = date("m-d");
		
		//underage year
		$notYear = $year-18;
		
		//underage date
		$notDate = $notYear."-".$monthDay;	

		//email validation
		if (!empty($email)) {
			$sqlGetEmail = "SELECT email
						 FROM user
						 WHERE userID='$userID'";
							 
			$rsGetEmail = mysqli_query($conn,$sqlGetEmail)
			or die(mysqli_error($conn));
			
			$row = mysqli_fetch_row($rsGetEmail)
					or die(mysqli_error($conn));
		
			//execute each field
			$getEmail = $row[0];
			
			 if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$errorList[] = "<p>Please enter a valid email.</p>";
			} else if ($email!=$getEmail){ 
				// check if email exists		
				$sqlEmailCheck = "SELECT userID
								  FROM user
								  WHERE email='$email'";
									
				// query sql statement
				$rsEmailCheck = mysqli_query($conn,$sqlEmailCheck)
								or die(mysqli_error($conn));
				
				if (mysqli_affected_rows($conn)>0){ 
					$errorList[] = "<p>Sorry email is already registered as an account.</p>";
				}
			} 
		} 
		
		//username validation
		if (!empty($userName)) {
			$sqlGetUname = "SELECT username
						 FROM user
						 WHERE userID='$userID'";
							 
			$rsGetUname = mysqli_query($conn,$sqlGetUname)
			or die(mysqli_error($conn));
			
			$row = mysqli_fetch_row($rsGetUname)
					or die(mysqli_error($conn));
		
			//execute each field
			$getUname = $row[0];

			 if (strlen($userName) > 15) { 
				$errorList[] = "<p>Username should not be more than 15 character.</p>";
			} else if (strlen($userName) < 6) { 
				$errorList[] = "<p>Username should not be less than 6 character.</p>";
			} else if(preg_match($userNameFormat, $userName) == '0'){ 
				$errorList[] = "<p>Username format is wrong.</p>";
			} else if ($userName!=$getUname){ 
				//check if username is already used
				$sqlUCheck = "SELECT userID
									  FROM user
									  WHERE username='$userName'";
										
				// query sql statement
				$rsUCheck = mysqli_query($conn,$sqlUCheck)
								or die(mysqli_error($conn));
								
				if (mysqli_affected_rows($conn)>0){ 
					$errorList[] = "<p>Sorry username is already used.</p>";
				}
			}
		}
		
		//dob validation
		if (!empty($dob)) {
			if(preg_match($dateFormat, $dob) == '0'){
				$errorList[] = "<p>Date format is wrong.</p>";
			}else if($dob > $notDate){
				$errorList[] = "<p>You have to be older than 18 years old.</p>";
			}
		}
		
		//password validation
		if (!empty($passWord)) { 
			if (strlen($passWord) > 15) { 
				$errorList[] = "<p>Password should not be more than 15 character.</p>";
			} else if (strlen($passWord) < 6) { 
				$errorList[] = "<p>Password should not be less than 6 character.</p>";
			} else if ($passWord != $cpassWord) {
				$errorList[] = "<p>Password and confirm password do not match.</p>";
			} 
		}
		
		if (($email==$getEmail)&&($userName==$getUname)&&(empty($dob))&&(empty($passWord))){
			$errorList[] = "<p>There is nothing to edit.</p>";
		}
		
	    //display errors from array 
	    if (!empty($errorList)) {
			for ($a=0; $a < count($errorList); $a++) {
				echo "$errorList[$a]";
			}
		}
		else { 
			//update email
			if (!empty($email)) {
				if ($email!=$getEmail){ 
					$sqlAddEmail = "UPDATE user
									SET email = '$email'
									WHERE userID='$userID'";
						  
					//query sql statement	
					mysqli_query($conn, $sqlAddEmail)
					or die(mysqli_error($conn));

					if(mysqli_affected_rows($conn)>0){
						echo "<p>Email successfully edited.</p>";
					}
					else {
						echo "<p style=\"color: red\">Unable to edit email!</p>";
					}
				}
			} 
			//update username
			if (!empty($userName)) {
				if ($userName!=$getUname){ 
					$sqlAddName = "UPDATE user
									SET username = '$userName'
									WHERE userID='$userID'";
						  
					//query sql statement	
					mysqli_query($conn, $sqlAddName)
					or die(mysqli_error($conn));
					
					if(mysqli_affected_rows($conn)>0){
						echo "<p>Username successfully edited.</p>";
					}
					else {
						echo "<p style=\"color: red\">Unable to edit username!</p>";
					}
				}
			}
			//update dob
			if (!empty($dob)) {
				$sqlAddDOB = "UPDATE user
								SET dob = '$dob'
								WHERE userID='$userID'";
					  
				//query sql statement	
				mysqli_query($conn, $sqlAddDOB)
				or die(mysqli_error($conn));
				
				
				if(mysqli_affected_rows($conn)>0){
					echo "<p>Date of birth successfully edited.</p>";
				}
				else {
					echo "<p style=\"color: red\">Unable to edit date of birth!</p>";
				}
			}
			//update password
			if (!empty($passWord)) { 
				$option = [
					"cost" => 12,
				];	
				
				$passHash = password_hash($passWord,PASSWORD_DEFAULT,$option);
				
				$sqlAddPWord = "UPDATE user
								SET passwordHash = '$passHash'
								WHERE userID='$userID'";
					  
				//query sql statement	
				mysqli_query($conn, $sqlAddPWord)
				or die(mysqli_error($conn));
						
				if(mysqli_affected_rows($conn)>0){
					echo "<p>Password successfully edited.</p>";
				}
				else {
					echo "<p style=\"color: red\">Unable to edit password!</p>";
				}
			}
		}
        echo "<a href=\"user.php\"><p>Return to user page</p></a>";
		echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
	?>
		</div>
	</div>
</section>
 
 
<?php
	echo makeFooter();
  ?>