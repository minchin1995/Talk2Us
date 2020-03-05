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
	AND banned=0";

	//query the SQL statement
	$rsUser = mysqli_query($conn,$sqlUser)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Ban User");  
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
			echo "<h1><strong>Ban User</strong></h1>";
			
			if (mysqli_affected_rows($conn)>0) {
				
				//get report id of reports if user has any
				$sqlGetRep = "SELECT reportID
				FROM reportchat 
				WHERE userID=$gUserID";

				//query the SQL statement
				$rsGetRep = mysqli_query($conn,$sqlGetRep)
				or die(mysqli_error($conn));
				
				while($row = mysqli_fetch_assoc($rsGetRep)){
					$reportid		= 	$row["reportID"];
					
					//delete chat report
					$sqlDeleteRS = "DELETE FROM reportchat 
								 WHERE userID='$gUserID'
								 AND reportID='$reportid'";

					$rsDeleteRS = mysqli_query($conn,$sqlDeleteRS)
					or die(mysqli_error($conn));
					
					//delete report
					$sqlDeleteR = "DELETE FROM report 
								 WHERE reportID='$reportid'";
									 
					$rsDeleteR = mysqli_query($conn,$sqlDeleteR)
					or die(mysqli_error($conn));
				}
				
				//ban user
				$sqlBanUser = "UPDATE user
								SET banned = '1'
								WHERE userID='$gUserID'";
									 
				//execute sql statement
				$rsBanUser = mysqli_query($conn,$sqlBanUser)
				or die(mysqli_error($conn));
				
				
				if(mysqli_affected_rows($conn)>0){
					echo "<p>User successfully banned</p>";
					header("Location: manageUser.php"); //redirect after banning is successful
				}
				else {
					echo "<p style='color:red;'>Unable to ban user!</p>";
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
</div>
</section>

<?php
	echo makeFooter();
  ?>

