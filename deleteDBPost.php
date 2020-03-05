<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";
	
	//check the existence of postID
	if (isset($_GET["postid"])) {
		$postID = $_GET["postid"];//get postid
	}
	else {
		header("Location: forum.php"); // redirect back if there is not postid
	}
	
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

	//check if post exists
	$sqlCheck = "SELECT postID
	FROM forumpost
	WHERE postID=$postID";

	//query the SQL statement
	$rsCheck = mysqli_query($conn,$sqlCheck)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Delete Forum Post");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
	
?>
<section class="box">
	<div class="container top-content">
	<div class="processDiv">
<?php
	// check if user is logged in
	if (isset($_SESSION['userID'])){
		// check if user is an admin
		if ($accountID == "1") {
			echo "<h1><strong>Delete Forum Post</strong></h1>";
			if (mysqli_affected_rows($conn)>0) {
				$sqlGetTopicID = "SELECT topicID  
								 FROM forumpost 
								 WHERE postID='$postID'";
											
				// query sql statement
				$rsGetTopicID = mysqli_query($conn,$sqlGetTopicID)
									or die(mysqli_error($conn));
					
				$row = mysqli_fetch_row($rsGetTopicID)
				or die(mysqli_error($conn));
		
				//execute each field
				$topicID = $row[0];

				//get post ids of groups in group
				$sqlGetPostID = "SELECT reportID
				FROM forumpost JOIN reportpost ON (forumpost.postID=reportpost.postID)
				WHERE forumpost.postID=$postID";

				//query the SQL statement
				$rsGetPostID = mysqli_query($conn,$sqlGetPostID)
				or die(mysqli_error($conn));
				
				while($row = mysqli_fetch_assoc($rsGetPostID)){
					$reportid		= 	$row["reportID"];
					//delete report
					$sqlDeleteRS = "DELETE FROM reportpost 
								 WHERE reportID='$reportid'
								 AND postID='$postID'";
									 
					$rsDeleteRS = mysqli_query($conn,$sqlDeleteRS)
					or die(mysqli_error($conn));
					
					$sqlDeleteR = "DELETE FROM report 
								 WHERE reportID='$reportid'";
									 
					$rsDeleteR = mysqli_query($conn,$sqlDeleteR)
					or die(mysqli_error($conn));
				}

				//delete post
				$sqlDeletePost = "DELETE FROM forumpost 
								 WHERE postID='$postID'";
									 
				//execute sql statement
				$rsDeletePost = mysqli_query($conn,$sqlDeletePost)
				or die(mysqli_error($conn));

				if(mysqli_affected_rows($conn)>0){
					echo "<p>Post successfully deleted</p>";
					header("Location: forumtopic.php?topicID=$topicID");
				}
				else {
					echo "<p style='color:red;'>Unable to delete Post!</p>";
				}
				echo "<a href=\"forumtopic.php?topicID=$topicID\"><p>Return to forum topic</p></a>";
				echo "<a href=\"forum.php\"><p>Return to forum</p></a>";
				echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
			} else {
				echo noexist("Forum Post");
				echo "<a href=\"forum.php\"><p>Return to forum</p></a>";
				echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
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