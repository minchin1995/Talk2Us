<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	include "database_conn.php"; //connect to database
	include "cronJobEmail.php";
	
	echo makePageStart("Talk2Me - Register");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
  
  
<section class="box">
	<div class="container top-content">
		<div class="processDiv">
  <?php
	if(!isset($_SESSION['userID'])){
	    //obtainvalues of field from register form
		$email  	= filter_has_var(INPUT_POST, 'email') ? $_POST['email']: null;
        $userName	= filter_has_var(INPUT_POST, 'userName') ? $_POST['userName']: null;
        $dob  		= filter_has_var(INPUT_POST, 'dob') ? $_POST['dob']: null;
        $passWord  	= filter_has_var(INPUT_POST, 'passwd') ? $_POST['passwd']: null;
        $cpassWord  = filter_has_var(INPUT_POST, 'cpasswd') ? $_POST['cpasswd']: null;
        $terms  	= filter_has_var(INPUT_POST, 'termsChkbx') ? $_POST['termsChkbx']: null;

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
		if (empty($passWord)) { //if password is empty
			$errorList[] = "<p>You have not entered a password.</p>";
		} else if (strlen($passWord) > 15) { 
			$errorList[] = "<p>Password should not be more than 15 character.</p>";
		} else if (strlen($passWord) < 6) { 
			$errorList[] = "<p>Password should not be less than 6 character.</p>";
		} else if ($passWord != $cpassWord) {
			$errorList[] = "<p>Password and confirm password do not match.</p>";
		} 
		
		if (empty($terms)) { 
			$errorList[] = "<p>You have not checked the terms and conditions box.</p>";
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
			$sqlAddUser = "INSERT INTO user (username,usernameGen, email,passwordHash,dob,accountID,banned,verified)
							VALUES ('$userName','$randomString','$email','$passHash','$dob',2,0,0)";
												  
			//query sql statement	
			mysqli_query($conn, $sqlAddUser)
			or die(mysqli_error($conn));
					
			if(mysqli_affected_rows($conn)>0){
				//send email to validate
				echo "<div style=\"visibility:hidden; position:absolute\">";
				emailValidate($email);
				echo "</div>";
				echo "<p>Succesfully registered. Please validate your account by using the email sent through your account.</p>";
			}
			else {
				echo "<p style=\"color: red\">Unable to register!</p>";
			}
			
		}
		echo "<a href=\"register.php\"><p>Return to register page</p></a>";
		echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
    }else{
		echo logged();
	}
	?>
		</div>
	</div>
</section>
 
 
<?php
	echo makeFooter();
  ?>