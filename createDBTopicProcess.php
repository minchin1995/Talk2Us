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

	echo makePageStart("Talk2Me - Create Topic");   
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
	
	//get data from create topic form
	$tName		=	filter_has_var(INPUT_POST, 'tName') ? $_POST['tName']: null;
	$category	=	filter_has_var(INPUT_POST, 'category') ? $_POST['category']: null;
	$catName	=	filter_has_var(INPUT_POST, 'catName') ? $_POST['catName']: null;
	$post		=	filter_has_var(INPUT_POST, 'post') ? $_POST['post']: null;

	//sanitize data
	$tName	   	= filter_var($tName,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$tName 	   	= filter_var($tName,FILTER_SANITIZE_SPECIAL_CHARS);
	$category	= filter_var($category,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$category 	= filter_var($category,FILTER_SANITIZE_SPECIAL_CHARS);
	$catName	= filter_var($catName,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$catName 	= filter_var($catName,FILTER_SANITIZE_SPECIAL_CHARS);
	$post	    = filter_var($post,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$post 	    = filter_var($post,FILTER_SANITIZE_SPECIAL_CHARS);
	
	//remove space both before and after the data
	$tName		=	trim($tName);
	$category	=	trim($category);
	$catName	=	trim($catName);
	$post		=	trim($post);

?>
<section class="box">
	<div class="container top-content">
	<div class="processDiv">
<?php
	// check if user is logged in
	if (isset($_SESSION['userID'])){
		$errorList = array();
		
		// check if topic already exists		
		$sqlCheck = "SELECT topicID
						FROM forumtopic
						WHERE topicName='$tName'";
								
		// query sql statement
		$rsCheck = mysqli_query($conn,$sqlCheck)
						or die(mysqli_error($conn));
		
		//validate topic name
		if (empty($tName)) {
			$errorList[] = "You have not entered a topic name.";
		} else if (strlen($tName) > 200) { 
			$errorList[] = "Topic Name should not be more than 200 character.";
		} else if (mysqli_affected_rows($conn)>0){ 
			$errorList[] = "Sorry, the topic already exist.";
		} 
		
		//validate category
		if (empty($category)) { 
			$errorList[] = "You have not selected a category.";
		} else if ($category == "catOthers") { 
			if (empty($catName)) { 
				$errorList[] = "You have not entered a category name.";
			} else if (strlen($catName) > 200) { 
				$errorList[] = "Category name should not be more than 200 character.";
			} 
		} 
		
		//validate post
		if (empty($post)) { 
			$errorList[] = "You have not entered a post.";
		} else if (strlen($post) > 2000) { 
			$errorList[] = "Post should not be more than 2000 character.";
		} 
		
		//display error messages
		if (!empty($errorList)) {
			for ($a=0; $a < count($errorList); $a++) {
				echo "$errorList[$a] <br />\n";
			}
			echo "<p>Please try again.</p>\n";
		}
		else {
			if ($category == "catOthers") { 
				// check if category already exists		
				$sqlCheckC = "SELECT categoryID
								FROM forumcategory
								WHERE categoryName='$catName'";
										
				// query sql statement
				$rsCheckC = mysqli_query($conn,$sqlCheckC)
								or die(mysqli_error($conn));
				
				if (mysqli_affected_rows($conn)===0){		
					//add category if category name does not exist
					$sqlAddCat = "INSERT INTO forumcategory 
									SET categoryName='$catName'";
											
					// query sql statement
					$rsAddCat = mysqli_query($conn,$sqlAddCat)
									or die(mysqli_error($conn));
				} 
				
				//create topic
				$sqlAddTopic = "INSERT INTO forumtopic 
						 SET topicName='$tName',
						 categoryID=(SELECT forumcategory.categoryID
								FROM forumcategory
								WHERE categoryName='$catName')";
											
				// query sql statement
				$rsAddTopic = mysqli_query($conn,$sqlAddTopic)
							or die(mysqli_error($conn));
							
				if(mysqli_affected_rows($conn)>0){
					echo "<p>Topic successfully created.</p>";
				} else {
					echo "<p style='color:red;'>Unable to create topic!</p>";
				}
				
			} else{
				//create topic
				$sqlAddTopic = "INSERT INTO forumtopic 
						 SET topicName='$tName',
						 categoryID=(SELECT forumcategory.categoryID
								FROM forumcategory
								WHERE categoryName='$category')";
											
				// query sql statement
				$rsAddTopic = mysqli_query($conn,$sqlAddTopic)
							or die(mysqli_error($conn));
							
				if(mysqli_affected_rows($conn)>0){
					echo "<p>Topic successfully created.</p>";
				} else {
					echo "<p style='color:red;'>Unable to create topic!</p>";
				}
			}
			
			//set timezone
			date_default_timezone_set("Asia/Kuala_Lumpur");
			// get current time
			$time = date("H:i:s");
			// get current date
			$date = date("Y-m-d");
	
			$sqlAddPost = "INSERT INTO forumpost 
						 SET userID='$userID',
						 content='$post',
						 date='$date',
						 time='$time',
						 topicID=(SELECT forumtopic.topicID
									FROM forumtopic
									WHERE topicName='$tName')";
											
			// query sql statement
			$rsAddPost = mysqli_query($conn,$sqlAddPost)
							or die(mysqli_error($conn));

			if(mysqli_affected_rows($conn)>0){
				echo "<p>Post successfully added.</p>";
				if ($accountID == "2") {
					$sqlGetTopicID = "SELECT topicID  
									 FROM forumtopic 
									 WHERE topicName='$tName'";
											
					// query sql statement
					$rsGetTopicID = mysqli_query($conn,$sqlGetTopicID)
									or die(mysqli_error($conn));
					
					$row = mysqli_fetch_row($rsGetTopicID)
					or die(mysqli_error($conn));
		
					//execute each field
					$topicID = $row[0];
					
					header("Location: forumTopic.php?topicID=$topicID");
				}
			} else {
				echo "<p style='color:red;'>Unable to add post!</p>";
			}
			
			
		}
		if ($accountID == "1") {
			echo "<a href=\"manageDB.php\"><p>Return to manage forums</p></a>";
		}
		echo "<a href=\"forum.php\"><p>Return to forum</p></a>";
		echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
	}
?>

</div>
</div>
</section>

<?php
	echo makeFooter();
?>