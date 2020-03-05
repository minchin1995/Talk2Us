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

	echo makePageStart("Talk2Me - Apply Group Support");   
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
	
	//get data from apply group support form
	$reason		=	filter_has_var(INPUT_POST, 'reason') ? $_POST['reason']: null;

	//sanitize data
	$reason	    = filter_var($reason,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$reason 	= filter_var($reason,FILTER_SANITIZE_SPECIAL_CHARS);
	
	//remove space both before and after the data
	$reason		=	trim($reason);

?>
<section class="box">
	<div class="container top-content">
	<div class="processDiv">
<?php
	
	if (isset($_SESSION['userID'])){ // check if user is logged in
		if ($accountID == "2") { //check if user is a user
		$errorList = array();
		
		if (empty($reason)) { //display error if reason is empty
			$errorList[] = "You have not entered a reason.";
		} else if (strlen($reason) > 200) { //display error if reason is more than 200 characters
			$errorList[] = "Reason should not be more than 200 character.";
		} 
		
		//display error messages
		if (!empty($errorList)) {
			for ($a=0; $a < count($errorList); $a++) {
				echo "$errorList[$a] <br />\n";
			}
			echo "<p>Please try again.</p>\n";
		}
		else {
			//Add application into database
			$sqlApplyGS = "INSERT INTO submitsupport 
						 SET sSupportUserID='$userID',
						 sSupportReason='$reason'";
											
			// query sql statement
			$rsApplyGS = mysqli_query($conn,$sqlApplyGS)
							or die(mysqli_error($conn));

			if(mysqli_affected_rows($conn)>0){ 
				// show success message if application added to database
				echo "<p>Group Support successfully applied.</p>";
			} else {
				//show error message if addition to database failed
				echo "<p style='color:red;'>Unable to apply group support!</p>";
			}
		}
		echo "<a href=\"groupSupport.php\"><p>Return to group supports</p></a>";
		echo "<a href=\"index.php\"><p>Return to home page</p></a>";
		} else {
			echo wronglog("users");
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