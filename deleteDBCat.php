<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";
	
	//check the existence of categoryid
	if (isset($_GET["categoryid"])) {
		$categoryid = $_GET["categoryid"];//get categoryid
	}
	else {
		header("Location: manageDB.php"); // redirect back if there is not categoryid
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

	//check if category exists
	$sqlCon = "SELECT categoryName
	FROM forumcategory
	WHERE categoryID=$categoryid";

	//query the SQL statement
	$rsCon = mysqli_query($conn,$sqlCon)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Delete DB Category");  
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
			echo "<h1><strong>Delete Admin</strong></h1>";
			if (mysqli_affected_rows($conn)>0) {
				
				//get post ids of groups in group
				$sqlGetTopicID = "SELECT topicID
				FROM forumtopic
				WHERE categoryID=$categoryid";

				//query the SQL statement
				$rsGetTopicID = mysqli_query($conn,$sqlGetTopicID)
				or die(mysqli_error($conn));
				
				while($row = mysqli_fetch_assoc($rsGetTopicID)){
					$topicID			= 	$row["topicID"];
					
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
				}
				
				//delete category
				$sqlDeleteCat = "DELETE FROM forumcategory 
									 WHERE categoryID='$categoryid'";
										 
				//execute sql statement
				$rsDeleteTopic = mysqli_query($conn,$sqlDeleteCat)
				or die(mysqli_error($conn));
				
				if(mysqli_affected_rows($conn)>0){
					echo "<p>Forum category successfully deleted</p>";
					header("Location: manageDBCat.php");
				}
				else {
					echo "<p style='color:red;'>Unable to delete forum category!</p>";
				}
				echo "<a href=\"manageDbCat.php\"><p>Return to manage forum categories</p></a>";
				echo "<a href=\"manageDB.php\"><p>Return to manage forums</p></a>";
				echo "<a href=\"admin.php\"><p>Return to admin page</p></a>";
			} else {
				echo noexist("forum topic");
				echo "<a href=\"manageDbCat.php\"><p>Return to manage forum categories</p></a>";
				echo "<a href=\"manageDB.php\"><p>Return to manage forums</p></a>";
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