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

	echo makePageStart("Talk2Me - Validate Account");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
	
	//get data from create topic form
	$email			=	filter_has_var(INPUT_POST, 'email') ? $_POST['email']: null;

	//sanitize data
	$email	    	= filter_var($email,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$email 	    	= filter_var($email,FILTER_SANITIZE_SPECIAL_CHARS);
	
	//remove space both before and after the data
	$email			=	trim($email);

?>
<section class="box">
	<div class="container top-content">
	<div class="processDiv">
<?php
	if(!isset($_SESSION['userID'])){	
		$errorList = array();
		
		//get account of status
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

		// check if email exists		
		$sqlEmailCheck = "SELECT *
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
			$errorList[] = "Sorry, email does not exist.";
		} else if ($verified == "1"){
			$errorList[] = "Account is already validated";
		}
		
		//display error messages
		if (!empty($errorList)) {
			echo "<p><em>The following occured when trying to submit an email:</em></p>\n";
			for ($a=0; $a < count($errorList); $a++) {
				echo "$errorList[$a]";
			}
			echo "<p>Please try again.</p>\n";
		}
		else {	
			//update account verified status
			$sqlAccVer = "UPDATE user
							  SET verified='1'
							  WHERE email='$email'";
								
			$rsAccVer = mysqli_query($conn,$sqlAccVer)
						or die(mysqli_error($conn));
						
			if(mysqli_affected_rows($conn)>0){
				echo "<p>Account valdidated. Please login to use Talk2Us.</p>";
			} else {
				echo "<p style='color:red;'>Unable to validate account!</p>";
			}
			echo "<a href=\"login.php\"><p>Go to login page</p></a>";
		}
		echo "<a href=\"contact.php\"><p>Return to contact page</p></a>";
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