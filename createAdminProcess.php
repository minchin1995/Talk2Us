<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";
	
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
	
	echo makePageStart("Talk2Me - Add Admin");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
  
  
<section class="box">
	<div class="container top-content">
		<div class="processDiv">
		<?php
	// check if user is logged in
	if (isset($_SESSION['userID'])){
		// check if user is an admin
		if ($accountID == "1") {
			echo "<h2><strong>Add Admin</strong></h2>";
			
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
		
		//underage year
		$notYear = $year-18;
		
		//underage date
		$notDate = $notYear."-12-31";	
		
		//array for errors
		$errorList = array();
		
		// check if email exists		
		$sqlEmailCheck = "SELECT *
							  FROM user
							  WHERE email='$email'";
								
		// query sql statement
		$rsEmailCheck = mysqli_query($conn,$sqlEmailCheck)
						or die(mysqli_error($conn));
		
		//email validation
		if (empty($email)) {
			$errorList[] = "<p>You have not entered the email.</p>";
		} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errorList[] = "<p>Please enter a valid email.</p>";
		} else if (mysqli_affected_rows($conn)>0){ 
			$errorList[] = "<p>Sorry email is already registered as an account.</p>";
		}
		
		//check if username is already used
		$sqlUCheck = "SELECT userID
							  FROM user
							  WHERE username='$userName'";
								
		// query sql statement
		$rsUCheck = mysqli_query($conn,$sqlUCheck)
						or die(mysqli_error($conn));
						
		//username validation
		if (empty($userName)) {
			$errorList[] = "<p>You have not entered the username.</p>";
		}else if (strlen($userName) > 15) { 
			$errorList[] = "<p>Username should not be more than 15 character.</p>";
		} else if (strlen($userName) < 6) { 
			$errorList[] = "<p>Username should not be less than 6 character.</p>";
		} else if(preg_match($userNameFormat, $userName) == '0'){ 
			$errorList[] = "<p>Username format is wrong.</p>";
		} else if (mysqli_affected_rows($conn)>0){ 
			$errorList[] = "<p>Sorry username is already used.</p>";
		}
		
		//dob validation
		if (empty($dob)) {
			$errorList[] = "<p>You have not entered the date of birth.</p>";
		}else if(preg_match($dateFormat, $dob) == '0'){
			$errorList[] = "<p>Date format is wrong.</p>";
		}else if($dob > $notDate){
			$errorList[] = "<p>You have to be older than 18 years old.</p>";
		}
		
		//password validation
		if (empty($passWord)) { 
			$errorList[] = "<p>You have not entered a password.</p>";
		} else if (strlen($passWord) > 15) { 
			$errorList[] = "<p>Password should not be more than 15 character.</p>";
		} else if (strlen($passWord) < 6) { 
			$errorList[] = "<p>Password should not be less than 6 character.</p>";
		} else if ($passWord != $cpassWord) {
			$errorList[] = "<p>Password and confirm password do not match.</p>";
		} 
		
	    //display errors from array 
	    if (!empty($errorList)) {
			for ($a=0; $a < count($errorList); $a++) {
				echo "$errorList[$a]";
			}
		}
		else { 
			$option = [
				"cost" => 12,
			];	
			
			//hash password
			$passHash = password_hash($passWord,PASSWORD_DEFAULT,$option);
			
			//generate a random username
			$randomString = bin2hex(openssl_random_pseudo_bytes(5));
			
			// Add user
			$sqlAddUser = "INSERT INTO user (username, usernameGen,email,passwordHash,dob,accountID,banned,verified)
							VALUES ('$userName','$randomString','$email','$passHash','$dob',1,0,1)";
												  
			//query sql statement	
			mysqli_query($conn, $sqlAddUser)
			or die(mysqli_error($conn));
					
			if(mysqli_affected_rows($conn)>0){
				//send email to validate
				echo "<p>Admin successfully added.</p>";
				
			}
			else {
				echo "<p style=\"color: red\">Unable to add admin!</p>";
			}
		}
		echo "<a href=\"manageAdmin.php\"><p>Return to manage admin page</p></a>";
		echo "<a href=\"index.php\"><p>Return to homepage</p></a>";	
		} else {
			echo wronglog("Admins");
		}
	} else {
		echo nolog();
	}

?>

	</div>
	</div>
</section>
 
 
<?php
	echo makeFooter();
  ?>
