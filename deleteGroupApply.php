<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";
	
	//check the existence of supportid
	if (isset($_GET["supportid"])) {
		$supportid = $_GET["supportid"];//get supportid
	}
	else {
		header("Location: manageApply.php"); // redirect back if there is not blogid
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

	//check if application exists
	$sqlCheck = "SELECT sSupportID
	FROM submitsupport
	WHERE sSupportID=$supportid";

	//query the SQL statement
	$rsCheck = mysqli_query($conn,$sqlCheck)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Delete Group Support Application");  
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
			if (mysqli_affected_rows($conn)>0) {
				echo "<h1><strong>Delete Group Support Application</strong></h1>";
				
				//delete application
				$sqlDeleteApp = "DELETE FROM submitsupport 
								 WHERE sSupportID=".$supportid;
									 
				//execute sql statement
				$rsDeleteApp = mysqli_query($conn,$sqlDeleteApp)
				or die(mysqli_error($conn));
				
				
				if(mysqli_affected_rows($conn)>0){
					echo "<p>Application successfully deleted</p>";
					header("Location: manageApply.php");
				}
				else {
					echo "<p style='color:red;'>Unable to delete application!</p>";
				}
				echo "<a href=\"manageApply.php\"><p>Return to manage group support applications</p></a>";
				echo "<a href=\"manageGS.php\"><p>Return to manage group supports</p></a>";
				echo "<a href=\"admin.php\"><p>Return to admin page</p></a>";
			} else {
				echo noexist("application");
				echo "<a href=\"manageApply.php\"><p>Return to manage group support applications</p></a>";
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
</div>
</section>

<?php
	echo makeFooter();
  ?>