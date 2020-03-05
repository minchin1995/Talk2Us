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

	echo makePageStart("Forget Password");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
	
	$email			=	filter_has_var(INPUT_POST, 'email') ? $_POST['email']: null;

	//sanitize data
	$email	    	= filter_var($email,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$email 	    	= filter_var($email,FILTER_SANITIZE_SPECIAL_CHARS);
	
	//remove space both before and after the data
	echo $email			=	trim($email);

?>
<section class="box">
	<div class="container top-content">
		<div class="processDiv">
<?php
	if(!isset($_SESSION['userID'])){	
		$errorList = array();
		
		// check if email exists	
		$sqlEmailCheck = "SELECT userID
							  FROM user
							  WHERE email='$email'";
								
		// query sql statement
		$rsEmailCheck = mysqli_query($conn,$sqlEmailCheck)
						or die(mysqli_error($conn));
		
		//validate email
		if (empty($email)) { 
			$error[] = "You have not entered the email.";
		} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
			$errorList[] = "Please enter the correct format for email.";
		} else if (mysqli_affected_rows($conn)===0){ 
			$error[] = "Sorry, the email: $email does not exist.";
		}
		
		//display error messages
		if (!empty($errorList)) {
			echo "<p><em>The following occured when trying to submit an email:</em></p>\n";
			for ($a=0; $a < count($errorList); $a++) {
				echo "$errorList[$a] <br />\n";
			}
			echo "<p>Please try again.</p>\n";
		}
		else {
			echo "<div style=\"visibility:hidden; position:absolute\">";
			emailForget($email); //send email to user
			echo "</div>";
			echo "<p>An email has been sent to you with a link to reset your password.</p>";
			
		}
		echo "<a href=\"forgetPassword.php\"><p>Return to forget password page</p></a>";
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

