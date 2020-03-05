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
	
	$question		=	filter_has_var(INPUT_POST, 'question') ? $_POST['question']: null;
	$answer			=	filter_has_var(INPUT_POST, 'answer') ? $_POST['answer']: null;
	$topic			=	filter_has_var(INPUT_POST, 'topic') ? $_POST['topic']: null;
	$topicName		=	filter_has_var(INPUT_POST, 'topicName') ? $_POST['topicName']: null;
	$faqID			=	filter_has_var(INPUT_POST, 'faqID') ? $_POST['faqID']: null;

	//sanitize data
	$question	   	= filter_var($question,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$question 	   	= filter_var($question,FILTER_SANITIZE_SPECIAL_CHARS);
	$answer	    	= filter_var($answer,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$answer 	   	= filter_var($answer,FILTER_SANITIZE_SPECIAL_CHARS);
	$topic	    	= filter_var($topic,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$topic 	    	= filter_var($topic,FILTER_SANITIZE_SPECIAL_CHARS);
	$topicName	    = filter_var($topicName,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$topicName 	    = filter_var($topicName,FILTER_SANITIZE_SPECIAL_CHARS);
	$faqID	    	= filter_var($faqID,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$faqID 	    	= filter_var($faqID,FILTER_SANITIZE_SPECIAL_CHARS);
	
	//remove space both before and after the data
	$question		=	trim($question);
	$answer			=	trim($answer);
	$topic			=	trim($topic);
	$topicName		=	trim($topicName);
	$faqID			=	trim($faqID);

?>
<section class="box">
	<div class="container top-content">
		<div class="processDiv">
<?php
// check if user is logged in
	if (isset($_SESSION['userID'])){
		// check if user is an admin
		if ($accountID == "1") {
			$errorList = array();

			//validate question
			if (empty($question)) {
				$errorList[] = "You have not entered a question.";
			} else if (strlen($question) > 200) { 
				$errorList[] = "Question should not be more than 200 character.";
			} 
			
			//validate answer
			if (empty($answer)) { 
				$errorList[] = "You have not entered a answer.";
			} else if (strlen($answer) > 2000) { 
				$errorList[] = "Answer should not be more than 2000 character.";
			} 
			//validate topic
			if (empty($topic)) { 
				$errorList[] = "You have not selected a topic.";
			} else if ($topic == "topicOthers") { 
				if (empty($topicName)) { 
					$errorList[] = "You have not entered a topic name.";
				} else if (strlen($topicName) > 200) { 
					$errorList[] = "Topic name should not be more than 200 character.";
				} 
			} 
			
			//display error messages
			if (!empty($errorList)) {
				for ($a=0; $a < count($errorList); $a++) {
					echo "$errorList[$a] <br />\n";
				}
				echo "<p>Please try again.</p>\n";
			}
			else {
				if ($topic == "topicOthers") { 
					// check if topic already exists		
					$sqlCheckT = "SELECT topicID
									FROM faqtopic
									WHERE topicname='$topicName'";
											
					// query sql statement
					$rsCheckT = mysqli_query($conn,$sqlCheckT)
									or die(mysqli_error($conn));
					
					if (mysqli_affected_rows($conn)===0){
						//add faq topic if it doesnt exist
						$sqlAddTopic = "INSERT INTO faqtopic 
										SET topicname='$topicName'";
												
						// query sql statement
						$rsAddTopic = mysqli_query($conn,$sqlAddTopic)
										or die(mysqli_error($conn));
					} 
					//Add FAQ
					$sqlAddFAQ = "UPDATE faq 
							 SET faqQuestion='$question',
							 faqAnswer='$answer',
							 faqTopicID=(SELECT faqtopic.topicID
										FROM faqtopic
										WHERE topicname='$topicName')
							WHERE faqID='$faqID'";
												
					// query sql statement
					$rsAddFAQ = mysqli_query($conn,$sqlAddFAQ)
								or die(mysqli_error($conn));
								
					if(mysqli_affected_rows($conn)>0){
						echo "<p>FAQ successfully added.</p>";
					} else {
						echo "<p style='color:red;'>Unable to add FAQ!</p>";
					}
					
				} else{
					//add faq
					$sqlAddFAQ = "UPDATE faq 
							 SET faqQuestion='$question',
							 faqAnswer='$answer',
							 faqTopicID=(SELECT faqtopic.topicID
										FROM faqtopic
										WHERE topicname='$topic')
							 WHERE faqID='$faqID'";
												
					// query sql statement
					$rsAddFAQ = mysqli_query($conn,$sqlAddFAQ)
								or die(mysqli_error($conn));

					if(mysqli_affected_rows($conn)>0){
						echo "<p>FAQ successfully added.</p>";
					} else {
						echo "<p style='color:red;'>Unable to add FAQ!</p>";
					}
				}
				echo "<a href=\"manageFAQTopics.php\"><p>Return to manage FAQ topics</p></a>";
				echo "<a href=\"manageFAQ.php\"><p>Return to manage FAQ</p></a>";
				echo "<a href=\"admin.php\"><p>Return to admin page</p></a>";
			}
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