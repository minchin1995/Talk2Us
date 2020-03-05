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
	$sqlCheck = "SELECT userID
	FROM user
	WHERE userID=$gUserID
	AND accountID='2'";

	//query the SQL statement
	$rsCheck = mysqli_query($conn,$sqlCheck)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Delete User");  
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
			echo "<h1><strong>Delete User</strong></h1>";
			if (mysqli_affected_rows($conn)>0) {
				
				/*
				* BLOGS
				*/
				//get report id posts for blog
				$sqlGetRepB  = "SELECT report.reportID, blogID
				FROM reportblog JOIN report ON (reportblog.reportID=report.reportID) 
				WHERE userID='$gUserID'";

				//query the SQL statement
				$rsGetRepB = mysqli_query($conn,$sqlGetRepB)
				or die(mysqli_error($conn));
				
				while($row = mysqli_fetch_assoc($rsGetRepB)){
					$reportid		= 	$row["reportID"];
					$blogID			= 	$row["blogID"];
					
					//delete report
					$sqlDeleteRS = "DELETE FROM reportblog 
								 WHERE blogID='$blogID'
								 AND reportID='$reportid'";

					$rsDeleteRS = mysqli_query($conn,$sqlDeleteRS)
					or die(mysqli_error($conn));

					$sqlDeleteR = "DELETE FROM report 
								 WHERE reportID='$reportid'";
									 
					$rsDeleteR = mysqli_query($conn,$sqlDeleteR)
					or die(mysqli_error($conn));
				}
				
				//delete submitted blog
				$sqlDeleteSubBlog = "DELETE FROM submitblogpost
								 WHERE sUserID='$gUserID'";

				$rsDeleteSubBlog = mysqli_query($conn,$sqlDeleteSubBlog)
							  or die(mysqli_error($conn));
				
				/*
				* FORUM
				*/
				//get report id posts for forum
				$sqlGetRepDB = "SELECT report.reportID, postID
				FROM reportpost JOIN report ON (reportpost.reportID=report.reportID) 
				WHERE userID='$gUserID'";

				//query the SQL statement
				$rsGetRepDB = mysqli_query($conn,$sqlGetRepDB)
				or die(mysqli_error($conn));
				
				while($row = mysqli_fetch_assoc($rsGetRepDB)){
					$reportid		= 	$row["reportID"];
					$postID			= 	$row["postID"];
					
					//delete report
					$sqlDeleteRDB = "DELETE FROM reportpost 
								 WHERE postID='$postID'
								 AND reportID='$reportid'";

					$rsDeleteRDB = mysqli_query($conn,$sqlDeleteRDB)
					or die(mysqli_error($conn));

					$sqlDeleteR = "DELETE FROM report 
								 WHERE reportID='$reportid'";
									 
					$rsDeleteR = mysqli_query($conn,$sqlDeleteR)
					or die(mysqli_error($conn));
				}
				
				//get postID of user
				$sqlGetDB = "SELECT postID
				FROM forumpost  
				WHERE userID='$gUserID'";

				//query the SQL statement
				$rsGetDB = mysqli_query($conn,$sqlGetDB)
				or die(mysqli_error($conn));
				
				while($row = mysqli_fetch_assoc($rsGetDB)){
					$postID			= 	$row["postID"];
					
					//get report id posts for post that are being reported
					$sqlGetRepDB2 = "SELECT report.reportID
					FROM reportpost JOIN report ON (reportpost.reportID=report.reportID) 
					WHERE postID='$postID'";

					//query the SQL statement
					$rsGetRepDB2 = mysqli_query($conn,$sqlGetRepDB2)
					or die(mysqli_error($conn));

					while($row = mysqli_fetch_assoc($rsGetRepDB2)){
						$reportid		= 	$row["reportID"];
						
						//delete report
						$sqlDeleteRDB2 = "DELETE FROM reportpost 
									 WHERE postID='$postID'
									 AND reportID='$reportid'";

						$rsDeleteRDB2 = mysqli_query($conn,$sqlDeleteRDB2)
						or die(mysqli_error($conn));

						$sqlDeleteR2 = "DELETE FROM report 
									 WHERE reportID='$reportid'";
										 
						$rsDeleteR2 = mysqli_query($conn,$sqlDeleteR2)
						or die(mysqli_error($conn));
					}
				}
				
				//delete forum post
				$sqlDeletePost = "DELETE FROM forumpost 
								 WHERE userID='$gUserID'";

				$rsDeletePost = mysqli_query($conn,$sqlDeletePost)
				or die(mysqli_error($conn));
				
				/*
				* GROUP SUPPORT
				*/
				//get report id posts for group support
				$sqlGetRepGS = "SELECT report.reportID, sPostID
				FROM reportsupport JOIN report ON (reportsupport.reportID=report.reportID) 
				WHERE userID='$gUserID'";

				//query the SQL statement
				$rsGetRepGS = mysqli_query($conn,$sqlGetRepGS)
				or die(mysqli_error($conn));
				
				while($row = mysqli_fetch_assoc($rsGetRepGS)){
					$reportid		= 	$row["reportID"];
					$sPostID			= 	$row["sPostID"];
					
					//delete report
					$sqlDeleteRGS = "DELETE FROM reportsupport 
								 WHERE sPostID='$postID'
								 AND reportID='$reportid'";

					$rsDeleteRGS = mysqli_query($conn,$sqlDeleteRGS)
					or die(mysqli_error($conn));

					$sqlDeleteR = "DELETE FROM report 
								 WHERE reportID='$reportid'";
									 
					$rsDeleteR = mysqli_query($conn,$sqlDeleteR)
					or die(mysqli_error($conn));
				}
				
				//get postID of user
				$sqlGetGS = "SELECT sPostID
				FROM supportpost  
				WHERE sUserID='$gUserID'";

				//query the SQL statement
				$rsGetGS = mysqli_query($conn,$sqlGetGS)
				or die(mysqli_error($conn));
				
				while($row = mysqli_fetch_assoc($rsGetGS)){
					$sPostID			= 	$row["sPostID"];
					
					//get report id posts for post that are being reported
					$sqlGetRepGS2 = "SELECT report.reportID
					FROM reportsupport JOIN report ON (reportsupport.reportID=report.reportID) 
					WHERE sPostID='$sPostID'";

					//query the SQL statement
					$rsGetRepGS2 = mysqli_query($conn,$sqlGetRepGS2)
					or die(mysqli_error($conn));

					while($row = mysqli_fetch_assoc($rsGetRepGS2)){
						$reportid		= 	$row["reportID"];
						//delete report
						$sqlDeleteRGS2 = "DELETE FROM reportsupport 
									 WHERE sPostID='$sPostID'
									 AND reportID='$reportid'";

						$rsDeleteRGS2 = mysqli_query($conn,$sqlDeleteRGS2)
						or die(mysqli_error($conn));

						$sqlDeleteR2 = "DELETE FROM report 
									 WHERE reportID='$reportid'";
										 
						$rsDeleteR2 = mysqli_query($conn,$sqlDeleteR2)
						or die(mysqli_error($conn));
					}
				}
				
				//remove user from group
				$sqlDeleteGSUser = "DELETE FROM supportuser 
								 WHERE userID='$gUserID'";

				$rsDeleteGSUser = mysqli_query($conn,$sqlDeleteGSUser)
				or die(mysqli_error($conn));
				
				//delete group support post
				$sqlDeleteGSPost = "DELETE FROM supportpost 
								 WHERE sUserID='$gUserID'";

				$rsDeleteGSPost = mysqli_query($conn,$sqlDeleteGSPost)
				or die(mysqli_error($conn));
				
				//delete group support application
				$sqlDeleteSubGS = "DELETE FROM submitsupport
								 WHERE sSupportUserID='$gUserID'";

				$rsDeleteSubGS = mysqli_query($conn,$sqlDeleteSubGS)
							  or die(mysqli_error($conn));
				
				//get report id of reports if user has any
				$sqlGetRepC = "SELECT reportID
				FROM reportchat 
				WHERE userID=$gUserID";

				//query the SQL statement
				$rsGetRepC = mysqli_query($conn,$sqlGetRepC)
				or die(mysqli_error($conn));
				
				while($row = mysqli_fetch_assoc($rsGetRepC)){
					$reportid		= 	$row["reportID"];
					
					//delete report
					$sqlDeleteRC = "DELETE FROM reportchat 
								 WHERE userID='$gUserID'
								 AND reportID='$reportid'";

					$rsDeleteRC = mysqli_query($conn,$sqlDeleteRC)
					or die(mysqli_error($conn));

					$sqlDeleteR = "DELETE FROM report 
								 WHERE reportID='$reportid'";
									 
					$rsDeleteR = mysqli_query($conn,$sqlDeleteR)
					or die(mysqli_error($conn));
				}
				
				//delete user
				$sqlDeleteUser = "DELETE FROM user 
									  WHERE userID=".$gUserID;
									 
				//execute sql statement
				$rsDeleteUser = mysqli_query($conn,$sqlDeleteUser)
				or die(mysqli_error($conn));
				
				if(mysqli_affected_rows($conn)>0){
					echo "<p>User successfully deleted</p>";
					header("Location: manageUser.php");
				}
				else {
					echo "<p style='color:red;'>Unable to delete user!</p>";
				}
				echo "<a href=\"manageUser.php\"><p>Return to manage users</p></a>";
				echo "<a href=\"admin.php\"><p>Return to admin page</p></a>";
			} else {
				echo noexist("User");
				echo "<a href=\"manageUser.php\"><p>Return to manage users</p></a>";
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