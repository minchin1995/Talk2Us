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
	$sqlRep = "SELECT *
	FROM reportreason JOIN report ON (reportreason.reasonID=report.reasonID)
	JOIN reportblog ON (report.reportID=reportblog.reportID)
	ORDER BY report.reportID";

	//query the SQL statement
	$rsRep = mysqli_query($conn,$sqlRep)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Manage Report(Blog)");  
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
<a href="manageReport.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
	<h1><strong>Manage Report (Blog)</strong></h1>
	
	<table id="repBlogtable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Blog Name</th>
				<th>Reason</th>
				<th>Comment</th>
				<th>User</th>
				<th>Edit Blog</th>
				<th>Delete Blog</th>
				<th>Delete Report</th>
			</tr>
		</thead>
		<tbody>
<?php
				while($row = mysqli_fetch_assoc($rsRep)){
					$id				= 	$row["reportID"];
					$reason			=	$row["reasonType"];
					$comment		=	$row["comment"];
					$rUserID		=	$row["userID"];
					$blogID			=	$row["blogID"];
					
					// get username
					$sqlUname = "SELECT username
									 FROM user
									  WHERE userID='$rUserID'";
											
					// query sql statement
					$rsUname = mysqli_query($conn,$sqlUname)
								  or die(mysqli_error($conn));
					
					$row = mysqli_fetch_row($rsUname)
							or die(mysqli_error($conn));
				
					//execute each field
					$getUsername = $row[0];
					
					// get blogname
					$sqlB = "SELECT blogName, blogWritten
								 FROM blogpost
								 WHERE blogID='$blogID'";
											
					// query sql statement
					$rsB = mysqli_query($conn,$sqlB)
								  or die(mysqli_error($conn));
					
					$rowB = mysqli_fetch_row($rsB)
							or die(mysqli_error($conn));
				
					//execute each field
					$getBlog = $rowB[0];
					$getWritten = $rowB[1];
					
					echo "<tr>";
					echo "<td>$id</td>";
					echo "<td>$getBlog</td>";
					echo "<td>$reason</td>";
					echo "<td>$comment</td>";
					echo "<td>$getUsername</td>";
					if ($getWritten != NULL){
						echo "<td></td>";
					}else{
						echo "<td><a href=\"editBlogPost.php?blogid=$blogID\">EDIT</a></td>";
					}
					echo "<td><a onClick=\"javascript: return confirm(' Are you sure you want to delete this blog: $getBlog?');\" href=\"deleteBlog.php?blogid=$blogID\">DELETE</a></td>";
					echo "<td><a onClick=\"javascript: return confirm(' Are you sure you want to delete the report for: $getBlog?');\" href=\"deleteReportBlog.php?reportid=$id\">DELETE</a></td>";		
					echo "</tr>";
				}
				echo"</tbody>";
				echo"</table>";
				
			} else {
				echo noexist("blog reports");
				echo "<a href=\"manageReport.php\"><p>Return to manage reports</p></a>";
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