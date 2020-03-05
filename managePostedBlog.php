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
	}
	
	//check the existence of catid
	if (isset($_GET["catid"])) {
		$catid = $_GET["catid"];//get catid
	}
	else {
		header("Location: manageBlog.php"); // redirect back to forum if there is not catid
	}
	
	//select all records
	$sqlBlog = "SELECT *
	FROM blogpost
	WHERE blogCatID='$catid'
	ORDER BY blogID";

	//query the SQL statement
	$rsBlog = mysqli_query($conn,$sqlBlog)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Manage Posted Blog");  
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
?>		
<a href="managePosted.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
	<h1><strong>Manage Posted Blog</strong></h1>
	<table id="postblogtable" class="table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Blog Title</th>
				<th>Blog Post</th>
				<th>Posted</th>
				<th>Written</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
<?php
				while($row = mysqli_fetch_assoc($rsBlog)){
					$id				= 	$row["blogID"];
					$title			=	$row["blogName"];
					$post			=	$row["blogPost"];
					$blogUserID		=	$row["blogUserID"];
					$blogWritten	=	$row["blogWritten"];
					
					//select all records
					$sqlUsername = "SELECT username
					FROM user
					WHERE userID='$blogUserID'";

					//query the SQL statement
					$rsUsername = mysqli_query($conn,$sqlUsername)
					or die(mysqli_error($conn));
					
					$row = mysqli_fetch_row($rsUsername)
					or die(mysqli_error($conn));
					
					//execute each field
					$blogUsername = $row[0];
					
					$sqlWritten = "SELECT username
									FROM user
									WHERE userID='$blogWritten'";

					//execute sql statement
					$rsWritten = mysqli_query($conn,$sqlWritten)
					or die(mysqli_error($conn));
					
					$resultWritten = mysqli_fetch_array($rsWritten);

					$usernameWritten 		= $resultWritten['username'];
					
					echo "<tr>";
					echo "<td>$id</td>";
					echo "<td>$title</td>";
					echo "<td>$post</td>";
					echo "<td>$blogUsername</td>";
					echo "<td>$usernameWritten</td>";
					if ($usernameWritten != NULL){
						echo "<td></td>";
					}else{
						echo "<td><a href=\"editBlogPost.php?blogid=$id\">EDIT</a></td>";
					}
					echo "<td><a onClick=\"javascript: return confirm(' Are you sure you want to delete: $title? ');\" href=\"deleteBlogPost.php?blogid=$id\">DELETE</a></td>";					
					echo "</tr>";
				}
				echo"</tbody>";
				echo"</table>";
				
			} else {
				echo noexist("blogs");
				echo "<a href=\"managePosted.php\"><p>Return to manage blog categories</p></a>";
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
</section>

<?php
	echo makeFooter();
  ?>