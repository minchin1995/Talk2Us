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

	echo makePageStart("Talk2Me - Create Topic");   
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
	
	$tName		=	filter_has_var(INPUT_POST, 'tName') ? $_POST['tName']: null;
	$category	=	filter_has_var(INPUT_POST, 'category') ? $_POST['category']: null;
	$catName	=	filter_has_var(INPUT_POST, 'catName') ? $_POST['catName']: null;
	$topicID	=	filter_has_var(INPUT_POST, 'topicid') ? $_POST['topicid']: null;

	//sanitize data
	$tName	   	= filter_var($tName,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$tName 	   	= filter_var($tName,FILTER_SANITIZE_SPECIAL_CHARS);
	$category	= filter_var($category,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$category 	= filter_var($category,FILTER_SANITIZE_SPECIAL_CHARS);
	$catName	= filter_var($catName,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$catName 	= filter_var($catName,FILTER_SANITIZE_SPECIAL_CHARS);
	$topicID	= filter_var($topicID,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$topicID 	= filter_var($topicID,FILTER_SANITIZE_SPECIAL_CHARS);
	
	//remove space both before and after the data
	$tName		=	trim($tName);
	$category	=	trim($category);
	$catName	=	trim($catName);
	$topicID	=	trim($topicID);

?>
<section class="box">
	<div class="container top-content">
		<div class="processDiv">
<?php
	if(isset($_SESSION['userID'])){
		if ($accountID == "1") {
			$errorList = array();
			
			// check if category is the same
			$sqlTopicCheck = "SELECT categoryName
							 FROM forumtopic JOIN forumcategory ON (forumtopic.categoryID=forumcategory.categoryID)
							  WHERE topicID='$topicID'";
									
			// query sql statement
			$rsTopicCheck = mysqli_query($conn,$sqlTopicCheck)
						  or die(mysqli_error($conn));
			
			$row = mysqli_fetch_row($rsTopicCheck)
					or die(mysqli_error($conn));
		
			//execute each field
			$checkCat = $row[0];
			
			//validate topic name
			if (empty($tName)) {
				$errorList[] = "You have not entered a topic name.";
			} else if (strlen($tName) > 200) { 
				$errorList[] = "Topic Name should not be more than 200 character.";
			} else if(($checkCat == $category)||($catName == $checkCat)){
				// check if topic already exists		
				$sqlCheck = "SELECT topicID
								FROM forumtopic
								WHERE topicName='$tName'";
										
				// query sql statement
				$rsCheck = mysqli_query($conn,$sqlCheck)
								or die(mysqli_error($conn));
								
				if (mysqli_affected_rows($conn)>0){ 
					$errorList[] = "Sorry, the topic already exist.";
				}
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
						//add category if it doesn't exist
						$sqlAddCat = "INSERT INTO forumcategory 
										SET categoryName='$catName'";
												
						// query sql statement
						$rsAddCat = mysqli_query($conn,$sqlAddCat)
										or die(mysqli_error($conn));
					} 
					
					//update forum topic
					$sqlUpdateTopic = "UPDATE forumtopic 
							 SET topicName='$tName',
							 categoryID=(SELECT forumcategory.categoryID
									FROM forumcategory
									WHERE categoryName='$catName')
							 WHERE topicID='$topicID'";
												
					// query sql statement
					$rsUpdateTopic = mysqli_query($conn,$sqlUpdateTopic)
								or die(mysqli_error($conn));
								
					if(mysqli_affected_rows($conn)>0){
						echo "<p>Topic successfully updated.</p>";
					} else {
						echo "<p style='color:red;'>Unable to update topic!</p>";
					}
					
				} else{
					//update forum topic
					$sqlUpdateTopic = "UPDATE forumtopic 
							 SET topicName='$tName',
							 categoryID=(SELECT forumcategory.categoryID
									FROM forumcategory
									WHERE categoryName='$category')
							 WHERE topicID='$topicID'";
												
					// query sql statement
					$rsUpdateTopic = mysqli_query($conn,$sqlUpdateTopic)
								or die(mysqli_error($conn));
								
					if(mysqli_affected_rows($conn)>0){
						echo "<p>Topic successfully updated.</p>";
					} else {
						echo "<p style='color:red;'>Unable to update topic!</p>";
					}
				}
			}
			echo "<a href=\"manageDBCat.php\"><p>Return to manage forum categories</p></a>";
			echo "<a href=\"manageDB.php\"><p>Return to manage forum</p></a>";
			echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
		}else{
			echo wronglog ("admins");
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