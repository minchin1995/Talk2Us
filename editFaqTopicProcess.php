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
	}

	echo makePageStart("Talk2Me - Add FAQ");   
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();

	$topicName		=	filter_has_var(INPUT_POST, 'topicName') ? $_POST['topicName']: null;
	$topicID		=	filter_has_var(INPUT_POST, 'topicID') ? $_POST['topicID']: null;

	//sanitize data
	$topicName	    = filter_var($topicName,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$topicName 	    = filter_var($topicName,FILTER_SANITIZE_SPECIAL_CHARS);
	$topicID	    = filter_var($topicID,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$topicID 	    = filter_var($topicID,FILTER_SANITIZE_SPECIAL_CHARS);
	
	//remove space both before and after the data
	$topicName		=	trim($topicName);
	$topicID		=	trim($topicID);

?>
<section class="box">
	<div class="container top-content">
		<div class="processDiv">
<?php
		$errorList = array();
		
		// check if topic already exists		
		$sqlCheck = "SELECT topicID
						FROM faqtopic
						WHERE topicname='$topicName'";
								
		// query sql statement
		$rsCheck = mysqli_query($conn,$sqlCheck)
						or die(mysqli_error($conn));
		
		//validate topic name
		if (empty($topicName)) { 
			$errorList[] = "You have not entered a topic name.";
		} else if (strlen($topicName) > 200) { 
			$errorList[] = "Topic name should not be more than 200 character.";
		} else if (mysqli_affected_rows($conn)>0){ 
			$errorList[] = "Sorry, the topic already exist.";
		} 
		
		//display error messages
		if (!empty($errorList)) {
			for ($a=0; $a < count($errorList); $a++) {
				echo "$errorList[$a] <br />\n";
			}
			echo "<p>Please try again.</p>\n";
		}
		else {
			//edit FAQ Topic
			$sqlEditFAQ = "UPDATE faqtopic
							SET topicname='$topicName'
							WHERE topicID='$topicID'";
											
			// query sql statement
			$rsEditFAQ = mysqli_query($conn,$sqlEditFAQ)
							or die(mysqli_error($conn));

			if(mysqli_affected_rows($conn)>0){
				echo "<p>FAQ Topic successfully edited.</p>";
			} else {
				echo "<p style='color:red;'>Unable to edit FAQ Topic!</p>";
			}
			echo "<a href=\"manageFAQTopics.php\"><p>Return to manage FAQ topics</p></a>";
			echo "<a href=\"manageFAQ.php\"><p>Return to manage FAQ</p></a>";
			echo "<a href=\"admin.php\"><p>Return to admin page</p></a>";
		}
?>

</div>
</div>
</section>

<?php
	echo makeFooter();
  ?>