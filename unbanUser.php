<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";
	
	//check the existence of userID
	if (isset($_GET["userID"])) {
		$gUserID = $_GET["userID"];//get userID
	}
	else {
		header("Location: manageUser.php"); // redirect back if there is not userID
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

	//check if contact exists
	$sqlUser = "SELECT userID
	FROM user
	WHERE userID=$gUserID
	AND banned=1";

	//query the SQL statement
	$rsUser = mysqli_query($conn,$sqlUser)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Unban User");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
	
?>
<section class="box">
	<div class="container top-content">
	<h1><strong>Unban User</strong></h1>
<?php
	// check if user is logged in
	if (isset($_SESSION['userID'])){
		// check if user is an admin
		if ($accountID == "1") {
			if (mysqli_affected_rows($conn)>0) {
				//unban user
				$sqlUnbanUser = "UPDATE user
								SET banned = '0'
								WHERE userID='$gUserID'";
									 
				//execute sql statement
				$rsUnbanUser = mysqli_query($conn,$sqlUnbanUser)
				or die(mysqli_error($conn));
				
				
				if(mysqli_affected_rows($conn)>0){
					echo "<p>User successfully unbanned</p>";
					header("Location: manageUser.php");
				}
				else {
					echo "<p style='color:red;'>Unable to unban user!</p>";
				}
			} else {
				echo noexist("User");
				echo "<a href=\"manageUser.php\"><p>Return to manage user</p></a>";
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

