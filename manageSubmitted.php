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

	//select all records
	$sqlfaq = "SELECT *
	FROM submitblogpost
	ORDER BY sBlogID";

	//query the SQL statement
	$rsfaq = mysqli_query($conn,$sqlfaq)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Manage Submmited Blog");  
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
<a href="manageBlog.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
	<h1><strong>Manage Submitted Blog</strong></h1>	
	<table id="submitblogtable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Blog Title</th>
				<th>Blog Post</th>
				<th>User</th>
				<th>Post</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
<?php
				while($row = mysqli_fetch_assoc($rsfaq)){
					$id				= 	$row["sBlogID"];
					$title			=	$row["sBlogName"];
					$post			=	$row["sBlogPost"];
					$blogUserID		=	$row["sUserID"];
					
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
					
					echo "<tr>";
					echo "<td>$id</td>";
					echo "<td>$title</td>";
					echo "<td>$post</td>";
					echo "<td>$blogUsername</td>";
					echo "<td><a href=\"postBlogSub.php?blogid=$id\">POST</a></td>";
					echo "<td><a onClick=\"javascript: return confirm(' Are you sure you want to delete the submitted blog: $title?');\" href=\"deleteBlogSub.php?blogid=$id\">DELETE</a></td>";					
					echo "</tr>";
				}
				echo"</tbody>";
				echo"</table>";
				
			} else {
				echo noexist("Submitted Blog");
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