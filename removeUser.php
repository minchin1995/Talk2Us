<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";
	
	//check the existence of topicid and userid
	if ((isset($_GET["topicID"]))&&(isset($_GET["userID"]))) {
		$topicID = $_GET["topicID"];
		$gUserID = $_GET["userID"];
	}
	else {
		header("Location: manageGSMembers.php"); // redirect back if there is not topicid and userid
	}
	
	if(isset($_SESSION['userID'])){
		//get username of user logged in
		$username = $_SESSION['username'];
		//get userID of user logged in
		$userID = $_SESSION['userID'];
		//get role of user when user is logged in
		$accountID = $_SESSION['role'];
	}

	//check if application exists
	$sqlCheck = "SELECT *
	FROM supportuser
	WHERE sTopicID=$topicID
	AND userID=$gUserID";

	//query the SQL statement
	$rsCheck = mysqli_query($conn,$sqlCheck)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Remove User");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
	
?>
<section class="box">
	<div class="container top-content">
	
<?php
	// check if user is logged in
	if (isset($_SESSION['userID'])){
		// check if user is an admin
		if ($accountID == "1") {
			if (mysqli_affected_rows($conn)>0) {
				echo "<h1><strong>Remove User</strong></h1>";
				
				//remove user from support group
				$sqlDeleteUser = "DELETE FROM supportuser 
								 WHERE sTopicID=$topicID
								 AND userID=$gUserID";
									 
				//execute sql statement
				$rsDeleteUser = mysqli_query($conn,$sqlDeleteUser)
				or die(mysqli_error($conn));
				
				
				if(mysqli_affected_rows($conn)>0){
					echo "<p>User successfully removed</p>";
					header("Location: manageGSMembers.php");
				}
				else {
					echo "<p style='color:red;'>Unable to remove user!</p>";
				}
			} else {
				echo noexist("users");
				echo "<a href=\"manageGroups.php\"><p>Return to manage groups</p></a>";
				echo "<a href=\"manageGS.php\"><p>Return to manage group supports</p></a>";
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
</section>

<?php
	echo makeFooter();
  ?>