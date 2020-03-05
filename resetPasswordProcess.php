<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();
	
	require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";
	include "cronJobEmail.php";
	
	if(isset($_SESSION['userID'])){
		//get username of user logged in
		$username = $_SESSION['username'];
		//get userID of user logged in
		$userID = $_SESSION['userID'];
		//get role of user when user is logged in
		$accountID = $_SESSION['role'];
	}

	echo makePageStart("Talk2Me - Reset Password");   
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
	
	$email			=	filter_has_var(INPUT_POST, 'email') ? $_POST['email']: null;
	$password		=	filter_has_var(INPUT_POST, 'passwd') ? $_POST['passwd']: null;
	$cpassword		=	filter_has_var(INPUT_POST, 'cpasswd') ? $_POST['cpasswd']: null;

	//sanitize data
	$email	    	= filter_var($email,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$email 	    	= filter_var($email,FILTER_SANITIZE_SPECIAL_CHARS);
	$password	    	= filter_var($password,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$password 	    	= filter_var($password,FILTER_SANITIZE_SPECIAL_CHARS);
	$cpassword	    	= filter_var($cpassword,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$cpassword 	    	= filter_var($cpassword,FILTER_SANITIZE_SPECIAL_CHARS);
	
	//remove space both before and after the data
	$email			=	trim($email);
	$password			=	trim($password);
	$cpassword		=	trim($cpassword);

?>
<section class="box">
	<div class="container top-content">
		<div class="processDiv">
<?php
	if(!isset($_SESSION['userID'])){	
		$errorList = array();
		//check if email exists
		$sqlEmailCheck = "SELECT userID
							  FROM user
							  WHERE email='$email'";
								
		// query sql statement
		$rsEmailCheck = mysqli_query($conn,$sqlEmailCheck)
						or die(mysqli_error($conn));
		//validate email
		if (empty($email)) { 
			$errorList[] = "You have not entered the email.";
		} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
			$errorList[] = "Please enter the correct format for email.";
		} else if (mysqli_affected_rows($conn)===0){ 
			$errorList[] = "Sorry, the email: $email does not exist.";
		} 
		//validate password
		if (empty($password)) { 
			$errorList[] = "You have not entered a password.";
		} else if (strlen($password) > 15) { 
			$errorList[] = "Password should not be more than 15 character.";
		} else if (strlen($password) < 6) { 
			$errorList[] = "Password should not be less than 6 character.";
		} else if ($password != $cpassword) {
			$errorList[] = "Password and confirm password do not match.";
		} 
		
		//display error messages
		if (!empty($errorList)) {
			for ($a=0; $a < count($errorList); $a++) {
				echo "$errorList[$a] <br />\n";
			}
			echo "<p>Please try again.</p>\n";
		}
		else {
			$option = [
				"cost" => 12,
			];	
			
			$passHash = password_hash($password,PASSWORD_DEFAULT,$option);
			
			//update password
			$sqlPassword = "UPDATE user
							  SET passwordHash='$passHash'
							  WHERE email='$email'";
								
			$rsPassword = mysqli_query($conn,$sqlPassword)
						or die(mysqli_error($conn));
						
			if(mysqli_affected_rows($conn)>0){
				echo "<p>Password reset. Please login to use Talk2Us.</p>";
			} else {
				echo "<p style='color:red;'>Unable to reset!</p>";
			}
			
		}
		echo "<a href=\"resetPassword.php\"><p>Return to reset page</p></a>";
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