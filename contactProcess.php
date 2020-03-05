<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";
	//connect to email
	include "cronJobEmail.php";
	
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
	
	echo makePageStart("Talk2Me - Contact");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
	
	//get data from contact form
	if (!isset($_SESSION['userID'])){
		$email			    =	filter_has_var(INPUT_POST, 'email') ? $_POST['email']: null;
	}
	$problems			=	filter_has_var(INPUT_POST, 'problems') ? $_POST['problems']: null;
    
	//sanitize data
	if (!isset($_SESSION['userID'])){
		$email	    = filter_var($email,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$email 	    = filter_var($email,FILTER_SANITIZE_SPECIAL_CHARS);
	}
	$problems 	    = filter_var($problems ,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$problems 	    = filter_var($problems ,FILTER_SANITIZE_SPECIAL_CHARS);

	
	//remove space both before and after the data
	if (!isset($_SESSION['userID'])){
		$email			=	trim($email);
	}
	$problems           =	trim($problems);
?>
  
  
<section class="box">
	<div class="container top-content">
	<div class="processDiv">
  <?php
		//array for errors
		$errorList = array();
  
		// check if user is logged in
		if (!isset($_SESSION['userID'])){
				if (empty($email)) { //if email is empty
					$errorList[] = "<p>You have not entered an email.</p>\n";
				} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //if email format is wrong
					$errorList[] = "<p>Please enter a valid email.</p>\n";
				}
		}
		
		if (empty ($problems)) { //check if problems is empty
			$errorList[] = "<p>You have not entered any problems you which to address.</p>\n";
		} else if (strlen($problems) > 2000){ //if problems is more than 2000 characters
			$error[] = "<p>Problems should not be more than 2000 character.</p>";
		}
		
	    //display errors from array 
	    if (!empty($errorList)) {
			for ($a=0; $a < count($errorList); $a++) {
				echo "$errorList[$a]";
			}
			echo "<p>Please try again.</p>";
		}
		else{	
			// check if user is logged in
			if (isset($_SESSION['userID'])) {
				//get email from db is user is logged in
				$sqlContact = "SELECT email
								FROM user
								WHERE userID=$userID";

				//execute sql statement
				$rsContact = mysqli_query($conn,$sqlContact)
				or die(mysqli_error($conn));
				
				$resultContact = mysqli_fetch_array($rsContact);
				
				
				$email 		= $resultContact['email']; //email of user
							
			}
			echo "<div style=\"visibility:hidden; position:absolute\">";
			emailContact($email, $problems); //send email
			echo "</div>";
			echo "<p>We have recieved your email. We will respond to you as soon as possible.</p>";
			
		}
		echo "<a href=\"contact.php\"><p>Return to contact page</p></a>";
		echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
	?>
	</div>
	</div>
</section>
 
 
<?php
	echo makeFooter();
  ?>