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

	echo makePageStart("Talk2Me - Assign Group");   
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
	
	//get data from assign group support form
	$tName		=	filter_has_var(INPUT_POST, 'tName') ? $_POST['tName']: null;
	$topic		=	filter_has_var(INPUT_POST, 'topic') ? $_POST['topic']: null;
	$post		=	filter_has_var(INPUT_POST, 'post') ? $_POST['post']: null;
	$sUserID	=	filter_has_var(INPUT_POST, 'userID') ? $_POST['userID']: null;
	$supportID	=	filter_has_var(INPUT_POST, 'supportID') ? $_POST['supportID']: null;

	//sanitize data
	$tName	   	= filter_var($tName,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$tName 	   	= filter_var($tName,FILTER_SANITIZE_SPECIAL_CHARS);
	$topic		= filter_var($topic,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$topic 		= filter_var($topic,FILTER_SANITIZE_SPECIAL_CHARS);
	$post	    = filter_var($post,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$post 	    = filter_var($post,FILTER_SANITIZE_SPECIAL_CHARS);
	$sUserID	= filter_var($sUserID,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$sUserID 	= filter_var($sUserID,FILTER_SANITIZE_SPECIAL_CHARS);
	$supportID	= filter_var($supportID,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$supportID 	= filter_var($supportID,FILTER_SANITIZE_SPECIAL_CHARS);
	
	//remove space both before and after the data
	$tName		=	trim($tName);
	$topic		=	trim($topic);
	$post		=	trim($post);
	$sUserID	=	trim($sUserID);
	$supportID	=	trim($supportID);

?>
<section class="box">
	<div class="container top-content">
	<div class="processDiv">
<?php
	// check if user is logged in
	if (isset($_SESSION['userID'])){
		//array for error messages
		$errorList = array();

		if (empty($topic)) { 
			$errorList[] = "You have not selected a topic.";
		} else if ($topic == "topOthers") { 
			// check if user is already assigned to the topic chosen		
			$sqlCheck = "SELECT supportuser.sTopicID
						FROM supportuser JOIN supporttopic ON (supportuser.sTopicID=supporttopic.sTopicID)
						WHERE userID='$sUserID'
						AND sTopicName='$tName'";
									
			// query sql statement
			$rsCheck = mysqli_query($conn,$sqlCheck)
							or die(mysqli_error($conn));
	
			if (empty($tName)) { //if topic name not entered
				$errorList[] = "You have not entered a topic name.";
			} else if (strlen($tName) > 200) { //if topic name is more than 200 characters
				$errorList[] = "Topic Name should not be more than 200 character.";
			} if (mysqli_affected_rows($conn)>0){ //if user is already assigned to topic
				$errorList[] = "User is already assigned to this topic.";
			}

			if (empty($post)) { //if post is empty
				$errorList[] = "You have not entered a post.";
			} else if (strlen($post) > 2000) { //if post is more than 2000 characters
				$errorList[] = "Post should not be more than 2000 character.";
			} 
		} else if ($topic != "topOthers") {
			// check if user is already assigned to the topic chosen		
			$sqlCheck = "SELECT supportuser.sTopicID
						FROM supportuser JOIN supporttopic ON (supportuser.sTopicID=supporttopic.sTopicID)
						WHERE userID='$sUserID'
						AND sTopicName='$topic'";
									
			// query sql statement
			$rsCheck = mysqli_query($conn,$sqlCheck)
							or die(mysqli_error($conn));
							
			if (mysqli_affected_rows($conn)>0){ //if user is already assigned to topic
				$errorList[] = "User is already assigned to this topic.";
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
			if ($topic == "topOthers") { 
				// check if topic already exists		
				$sqlCheckT = "SELECT sTopicID
								FROM supporttopic
								WHERE sTopicName='$tName'";
										
				// query sql statement
				$rsCheckT = mysqli_query($conn,$sqlCheckT)
								or die(mysqli_error($conn));
				
				if (mysqli_affected_rows($conn)===0){	
					//Add new topic to database
					$sqlAddTop = "INSERT INTO supporttopic 
						 SET sTopicName='$tName'";
											
					// query sql statement
					$rsAddTop = mysqli_query($conn,$sqlAddTop)
									or die(mysqli_error($conn));
									
					//set timezone
					date_default_timezone_set("Asia/Kuala_Lumpur");
					// get current time
					$time = date("H:i:s");
					// get current date
					$date = date("Y-m-d");
				
					//Add Post to database
					$sqlAddPost = "INSERT INTO supportpost 
								 SET sUserID='$userID',
								 sContent='$post',
								 sDate='$date',
								 sTime='$time',
								 sTopicID=(SELECT sTopicID
											FROM supporttopic
											WHERE sTopicName='$tName')";
													
					// query sql statement
					$rsAddPost = mysqli_query($conn,$sqlAddPost)
									or die(mysqli_error($conn));

					if(mysqli_affected_rows($conn)>0){
						echo "<p>Post successfully added.</p>";
					} else {
						echo "<p style='color:red;'>Unable to add post!</p>";
					}
				} 
				
				//Assign user to topic
				$sqlAssign = "INSERT INTO supportuser
							  SET sTopicID=(SELECT sTopicID
										FROM supporttopic
										WHERE sTopicName='$tName'),
							  userID=$sUserID";
											
				// query sql statement
				$rsAssign = mysqli_query($conn,$sqlAssign)
							or die(mysqli_error($conn));
				
				//delete application
				$sqlDelete = "DELETE FROM submitsupport
								WHERE sSupportID='$supportID'";
											
				// query sql statement
				$rsDelete = mysqli_query($conn,$sqlDelete)
							or die(mysqli_error($conn));
							
				if(mysqli_affected_rows($conn)>0){
					echo "<p>User successfully assigned.</p>";
				} else {
					echo "<p style='color:red;'>Unable to assign user!</p>";
				}
				
			} else{
				//Assign user to topic
				$sqlAssign = "INSERT INTO supportuser
							  SET sTopicID=(SELECT sTopicID
										FROM supporttopic
										WHERE sTopicName='$topic'),
							  userID=$sUserID";
											
				// query sql statement
				$rsAssign = mysqli_query($conn,$sqlAssign)
							or die(mysqli_error($conn));
				
				//delete application
				$sqlDelete = "DELETE FROM submitsupport
								WHERE sSupportID='$supportID'";
											
				// query sql statement
				$rsDelete = mysqli_query($conn,$sqlDelete)
							or die(mysqli_error($conn));
							
				if(mysqli_affected_rows($conn)>0){
					echo "<p>User successfully assigned.</p>";
				} else {
					echo "<p style='color:red;'>Unable to assign user!</p>";
				}
			}

		}
		echo "<a href=\"manageGS.php\"><p>Return to manage group support</p></a>";
		echo "<a href=\"manageApply.php\"><p>Return to manage group support applications</p></a>";
		echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
	}
?>

</div>
</div>
</section>

<?php
	echo makeFooter();
?>