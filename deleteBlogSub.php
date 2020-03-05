<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";
	
	//check the existence of blogid
	if (isset($_GET["blogid"])) {
		$blogid = $_GET["blogid"];//get blogid
	}
	else {
		header("Location: manageSubmitted.php"); // redirect back if there is not blogid
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

	//check if blog exists
	$sqlBlog = "SELECT sBlogID
	FROM submitblogpost
	WHERE sBlogID=$blogid";

	//query the SQL statement
	$rsBlog = mysqli_query($conn,$sqlBlog)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Delete Submitted Blog");  
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
			echo "<h1><strong>Delete Submitted Blog</strong></h1>";
			if (mysqli_affected_rows($conn)>0) {
				//delete blog
				$sqlDeleteBlog = "DELETE FROM submitblogpost 
									  WHERE sBlogID=".$blogid;
									 
				//execute sql statement
				$rsDeleteBlog = mysqli_query($conn,$sqlDeleteBlog)
				or die(mysqli_error($conn));
				
				
				if(mysqli_affected_rows($conn)>0){
					echo "<p>Blog successfully deleted</p>";
					header("Location: manageSubmitted.php");
				}
				else {
					echo "<p style='color:red;'>Unable to delete blog!</p>";
				}
				echo "<a href=\"manageSubmitted.php\"><p>Return to manage submitted blogs</p></a>";
				echo "<a href=\"manageBlog.php\"><p>Return to manage blogs</p></a>";
				echo "<a href=\"admin.php\"><p>Return to admin page</p></a>";
			} else {
				echo noexist("Blog");
				echo "<a href=\"manageSubmitted.php\"><p>Return to manage submitted blogs</p></a>";
				echo "<a href=\"manageBlog.php\"><p>Return to manage blogs</p></a>";
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

