<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";
	
	//check the existence of topicID
	if (isset($_GET["topicID"])) {
		$topicID = $_GET["topicID"];//get topicid
	}
	else {
		header("Location: groupSupport.php"); // redirect back to forum if there is not topicID
	}
	
	if(isset($_SESSION['userID'])){
		//get username of user logged in
		$username = $_SESSION['username'];
		//get userID of user logged in
		$userID = $_SESSION['userID'];
		//get role of user when user is logged in
		$accountID = $_SESSION['role'];
	}

	//check if contact exists and user is registered
	$sqlCheck = "SELECT sTopicID
	FROM supportuser
	WHERE sTopicID=$topicID
	AND userID=$userID";

	//query the SQL statement
	$rsCheck = mysqli_query($conn,$sqlCheck)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Quit group");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
	
?>
<section class="box">
	<div class="container top-content">
	<h1><strong>Quit group</strong></h1>
<?php
	// check if user is logged in
	if (isset($_SESSION['userID'])){
		// check if user is an user
		if ($accountID == "2") {
			if (mysqli_affected_rows($conn)>0) {
				//remove user from group support topic
				$sqlQuit = "DELETE FROM supportuser 
									  WHERE userID=$userID
									  AND sTopicID=$topicID";
									 
				//execute sql statement
				$rsQuit = mysqli_query($conn,$sqlQuit)
				or die(mysqli_error($conn));
				
				
				if(mysqli_affected_rows($conn)>0){
					echo "<p>You successfully quitted</p>";
					header("Location: groupSupport.php");
				}
				else {
					echo "<p style='color:red;'>Unable to quit group!</p>";
				}
			} else {
				echo noexist("group support");
				echo "<a href=\"groupSupport.php\"><p>Return to group support</p></a>";
				echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
			}
		} else {
			echo wronglog("user");
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