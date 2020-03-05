<?php
	ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";
	
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

	//check the existence of blogid
	if (isset($_GET["blogid"])) {
		$blogid = $_GET["blogid"];//get blogid

	}
	else {
		header("Location: blog.php"); // redirect back to forum if there is not blogid
	}

	$sqlBlog = "SELECT * 
				FROM blogpost JOIN blogcategory ON (blogpost.blogCatID=blogcategory.blogCatID)
				WHERE blogID = $blogid";

	//execute sql statement
	$rsBlog = mysqli_query($conn,$sqlBlog)
	or die(mysqli_error($conn));
	
	
	
	echo makePageStart("ImaSuperFan - View Blog");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">
	
<?php	

	
	if (mysqli_affected_rows($conn)>0){ //check if there are any posts in topic
?>
<a href="blog.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
<?php
		//display all the this topic in database
		while($row = mysqli_fetch_assoc($rsBlog)){
			$id				= 	$row["blogID"];
			$name           =   $row["blogName"];
			$post           =   html_entity_decode($row["blogPost"]);
			$date           =   $row["blogDate"];
			$time           =   $row["blogTime"];
			$blogUserID     =   $row["blogUserID"];
			$blogCatID      =   $row["blogCatID"];
			$blogCatName    =   $row["blogCatName"];
			$blogWritten    =   $row["blogWritten"];
			$editBlogTime   =   $row["editBlogTime"];
			$editBlogDate   =   $row["editBlogDate"];
			$editUserID    	=   $row["editUserID"];
			
			$post = nl2br($post);
			
			echo "<h1><strong>$name</strong></h1>";
			
			
			echo "<div class=\"blogPost\">";
			//select username of post
			$sqlUname = "SELECT usernameGen
							FROM user
							WHERE userID = $blogUserID";

			//execute sql statement
			$rsUname = mysqli_query($conn,$sqlUname)
			or die(mysqli_error($conn));
			
			$resultUname = mysqli_fetch_array($rsUname);

			$usernameBlog 	= $resultUname['usernameGen']; 
			
			echo "<p><span class=\"labels\">Posted By</span>: $usernameBlog</p>";
			
			if($blogWritten != NULL) {
				//select username of post
				$sqlWritten = "SELECT usernameGen
								FROM user
								WHERE userID = $blogWritten";

				//execute sql statement
				$rsWritten = mysqli_query($conn,$sqlWritten)
				or die(mysqli_error($conn));
				
				$resultWritten = mysqli_fetch_array($rsWritten);

				$usernameWritten 		= $resultWritten['usernameGen'];
				
				if($usernameWritten != NULL) {
					echo "<p><span class=\"labels\">Submitted By</span>: $usernameWritten</p>";
				}else{
					echo "<p><span class=\"labels\">Submitted By</span>: Deleted User</p>";
				}
			}
			
			echo "<p><span class=\"labels\">Posted on</span>: $date, $time</p>";
			
			if($editBlogTime != NULL) {
				//select username of post
				$sqlEditUname = "SELECT username
								FROM user
								WHERE userID = $editUserID";

				//execute sql statement
				$rsEditUname = mysqli_query($conn,$sqlEditUname)
				or die(mysqli_error($conn));
				
				$resultEditUname = mysqli_fetch_array($rsEditUname);

				$editUname		= $resultEditUname['username'];

				echo "<p><span class=\"labels\">Edited By</span>: $editUname</p>";
				echo "<p><span class=\"labels\">Edited At</span>: $editBlogDate, $editBlogTime</p>";
			}
			
			echo "<p><span class=\"labels\">Category</span>: <a href=\"blogCat.php?catid=$blogCatID\">$blogCatName</a></p>";
			
			echo "<p>$post</p>";
			
			echo "<div class=\"dbButtons\">";
			// check if user is logged in
			if (isset($_SESSION['userID'])){
				//select username of post
				$sqlCheckReport = "SELECT report.reportID
								FROM report JOIN reportblog ON (report.reportID=reportblog.reportID) 
								WHERE blogID = '$id'
								AND userID = '$userID'";

				//execute sql statement
				$rsCheckReport = mysqli_query($conn,$sqlCheckReport)
				or die(mysqli_error($conn));
				
				if (mysqli_affected_rows($conn)>0){
					echo "<p class=\"reported\">Reported</p>";
				} else{
					echo "<a href=\"reportBlog.php?postid=$id\" class=\"buttonLeft\"><p>Report</p></a>";
				}
				
				// check if user is an admin
				if ($accountID == "1") {
					echo "<a href=\"deleteBlog.php?postid=$id\" class=\"buttonLeft\"><p>Delete</p></a>";
					echo "<a href=\"editBlog.php?postid=$id\" class=\"buttonLeft\"><p>Edit</p></a>";
				}
			}
			echo "</div>";
				
			echo "<br class=\"clearRight\"/>";
			echo "</div>";
				
		}
	} else {
		echo noexist("blog");
		echo "<a href=\"blog.php\"><p>Return to blog page</p></a>";
		echo "<a href=\"index.php\"><p>Return to home page</p></a>";
	}
?>
</div>
</section>

<?php

	echo makeFooter();
  ?>