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
		header("Location: manageAdmin.php"); // redirect back if there is not userID
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
	$sqlCon = "SELECT userID
	FROM user
	WHERE userID=$userID
	AND accountID='1'";

	//query the SQL statement
	$rsCon = mysqli_query($conn,$sqlCon)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Delete Admin");  
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
				if ($gUserID != $userID){
				//get blogid of user
				$sqlGetBlog = "SELECT blogID
				FROM blogpost  
				WHERE blogUserID='$gUserID'";

				//query the SQL statement
				$rsGetBlog = mysqli_query($conn,$sqlGetBlog)
				or die(mysqli_error($conn));
				
				while($row = mysqli_fetch_assoc($rsGetBlog)){
					$blogID			= 	$row["blogID"];
					
					//get report id posts for post that are being reported
					$sqlGetRepBlog = "SELECT report.reportID
					FROM reportblog JOIN report ON (reportblog.reportID=report.reportID) 
					WHERE blogID='$blogID'";

					//query the SQL statement
					$rsGetRepBlog = mysqli_query($conn,$sqlGetRepBlog)
					or die(mysqli_error($conn));

					while($row = mysqli_fetch_assoc($rsGetRepBlog)){
						$reportid		= 	$row["reportID"];
						
						//delete report
						$sqlDeleteRBlog = "DELETE FROM reportblog 
									 WHERE blogID='$blogID'
									 AND reportID='$reportid'";

						$rsDeleteRBlog = mysqli_query($conn,$sqlDeleteRBlog)
						or die(mysqli_error($conn));

						$sqlDeleteR = "DELETE FROM report 
									 WHERE reportID='$reportid'";
										 
						$rsDeleteR = mysqli_query($conn,$sqlDeleteR)
						or die(mysqli_error($conn));
					}
				}

				//delete from blog
				$sqlDeleteBlog= "DELETE FROM blogpost
								 WHERE blogUserID=".$gUserID;
									 
				//execute sql statement
				$rsDeleteBlog = mysqli_query($conn,$sqlDeleteBlog)
				or die(mysqli_error($conn));
				
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
				
				//delete from db
				$sqlDeleteDB= "DELETE FROM forumpost 
								 WHERE userID=".$gUserID;
									 
				//execute sql statement
				$rsDeleteDB = mysqli_query($conn,$sqlDeleteDB)
				or die(mysqli_error($conn));

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

				//delete from gs
				$sqlDeleteGS= "DELETE FROM supportpost 
								 WHERE sUserID=".$gUserID;
									 
				//execute sql statement
				$rsDeleteGS = mysqli_query($conn,$sqlDeleteGS)
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
				$sqlDeleteAdmin = "DELETE FROM user 
									  WHERE userID=".$gUserID;
									 
				//execute sql statement
				$rsDeleteAdmin = mysqli_query($conn,$sqlDeleteAdmin)
				or die(mysqli_error($conn));
				
				if(mysqli_affected_rows($conn)>0){
					echo "<p>Admin successfully deleted</p>";
					header("Location: manageAdminList.php");
				}
				else {
					echo "<p style='color:red;'>Unable to delete admin!</p>";
				}
				echo "<a href=\"manageAdmin.php\"><p>Return to manage admins</p></a>";
				echo "<a href=\"admin.php\"><p>Return to admin page</p></a>";
				}else{
					echo "<p>You cannot delete yourself</p>";
					echo "<a href=\"manageAdmin.php\"><p>Return to manage admins</p></a>";
					echo "<a href=\"admin.php\"><p>Return to admin page</p></a>";
				}
			} else {
				echo noexist("Admin");
				echo "<a href=\"manageAdmin.php\"><p>Return to manage admins</p></a>";
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

