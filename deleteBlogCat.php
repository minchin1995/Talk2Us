<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";
	
	//check the existence of catid
	if (isset($_GET["catid"])) {
		$catid = $_GET["catid"];//get catid
	}
	else {
		header("Location: manageSubmitted.php"); // redirect back if there is not catid
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
	$sqlCon = "SELECT blogCatID
	FROM blogcategory
	WHERE blogCatID=$catid";

	//query the SQL statement
	$rsCon = mysqli_query($conn,$sqlCon)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Delete Blog Category");  
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
			echo "<h1><strong>Delete Blog Category</strong></h1>";
			if (mysqli_affected_rows($conn)>0) {
				//delete blog
				$sqlDeleteBlog = "DELETE FROM blogpost 
									  WHERE blogCatID=".$catID;
									 
				//execute sql statement
				$rsDeleteBlog = mysqli_query($conn,$sqlDeleteBlog)
				or die(mysqli_error($conn));
				
				//delete cat
				$sqlDeleteCat = "DELETE FROM blogcategory 
									  WHERE blogCatID=".$catID;
									 
				//execute sql statement
				$rsDeleteBlog = mysqli_query($conn,$sqlDeleteCat)
				or die(mysqli_error($conn));
				
				
				if(mysqli_affected_rows($conn)>0){
					echo "<p>Category successfully deleted</p>";
					header("Location: managePosted.php");
				}
				else {
					echo "<p style='color:red;'>Unable to delete category!</p>";
				}
				echo "<a href=\"managePosted.php\"><p>Return to manage posted blogs</p></a>";
				echo "<a href=\"manageBlog.php\"><p>Return to manage blogs</p></a>";
				echo "<a href=\"admin.php\"><p>Return to admin page</p></a>";
			} else {
				echo noexist("blog category");
				echo "<a href=\"managePosted.php\"><p>Return to manage posted blogs</p></a>";
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