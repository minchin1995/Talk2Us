<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";
	
	//check the existence of topicID
	if (isset($_GET["topicid"])) {
		$topicID = $_GET["topicid"];//get topic id
	}
	else {
		header("Location: forum.php"); // redirect back if there is not topicID
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

	//check if topic exists
	$sqlCheck = "SELECT categoryID
	FROM forumtopic
	WHERE topicID=$topicID";

	//query the SQL statement
	$rsCheck = mysqli_query($conn,$sqlCheck)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Delete Forum Topic");  
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
			echo "<h1><strong>Delete Forum Topic</strong></h1>";
			if (mysqli_affected_rows($conn)>0) {
				$row = mysqli_fetch_row($rsCheck)
				or die(mysqli_error($conn));
			
				//execute each field
				$categoryID = $row[0];
				
				//get post ids of groups in group
				$sqlGetPostID = "SELECT forumpost.postID AS postID, reportID
				FROM forumpost JOIN reportpost ON (forumpost.postID=reportpost.postID)
				WHERE topicID=$topicID";

				//query the SQL statement
				$rsGetPostID = mysqli_query($conn,$sqlGetPostID)
				or die(mysqli_error($conn));
				
				while($row = mysqli_fetch_assoc($rsGetPostID)){
					$id				= 	$row["postID"];
					$reportid		= 	$row["reportID"];
					//delete report
					$sqlDeleteRS = "DELETE FROM reportpost 
								 WHERE reportID='$reportid'
								 AND postID='$id'";
									 
					$rsDeleteRS = mysqli_query($conn,$sqlDeleteRS)
					or die(mysqli_error($conn));
					
					$sqlDeleteR = "DELETE FROM report 
								 WHERE reportID='$reportid'";
									 
					$rsDeleteR = mysqli_query($conn,$sqlDeleteR)
					or die(mysqli_error($conn));
				}

				//delete post
				$sqlDeletePost = "DELETE FROM forumpost 
								 WHERE topicID='$topicID'";
									 
				//execute sql statement
				$rsDeletePost = mysqli_query($conn,$sqlDeletePost)
				or die(mysqli_error($conn));
				
				//delete topic
				$sqlDeleteTopic = "DELETE FROM forumtopic 
								 WHERE topicID='$topicID'";
									 
				//execute sql statement
				$rsDeleteTopic = mysqli_query($conn,$sqlDeleteTopic)
				or die(mysqli_error($conn));
				
				
				if(mysqli_affected_rows($conn)>0){
					echo "<p>Forum topic successfully deleted</p>";
					header("Location: manageDBTopic.php?categoryid=$categoryID");
				}
				else {
					echo "<p style='color:red;'>Unable to delete forum topic!</p>";
				}
				echo "<a href=\"manageDBTopic.php?categoryid=$categoryID\"><p>Return to manage forum topic</p></a>";
				echo "<a href=\"manageDB.php\"><p>Return to manage forums</p></a>";
				echo "<a href=\"admin.php\"><p>Return to admin page</p></a>";
			} else {
				echo noexist("forum topic");
				echo "<a href=\"manageDbCat.php\"><p>Return to manage forum categories</p></a>";
				echo "<a href=\"manageDB.php\"><p>Return to manage forums</p></a>";
				echo "<a href=\"admin.php\"><p>Return to admin page</p></a>";
			}
		} else {
			echo wronglog("admins");
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