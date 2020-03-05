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
	JOIN reportpost ON (report.reportID=reportpost.reportID)
	ORDER BY report.reportID";

	//query the SQL statement
	$rsRep = mysqli_query($conn,$sqlRep)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Manage Report(Forum)");  
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
	<h1><strong>Manage Report (Forum)</strong></h1>
	
	<table id="repDBtable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Post</th>
				<th>Reason</th>
				<th>Comment</th>
				<th>User</th>
				<th>Edit Post</th>
				<th>Delete Post</th>
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
					$postID			=	$row["postID"];
					
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
					
					// get post
					$sqlB = "SELECT content, topicID
								 FROM forumpost
								 WHERE postID='$postID'";
											
					// query sql statement
					$rsB = mysqli_query($conn,$sqlB)
								  or die(mysqli_error($conn));
					
					$rowB = mysqli_fetch_row($rsB)
							or die(mysqli_error($conn));
				
					//execute each field
					$getPost = $rowB[0];
					$getTopicID = $rowB[1];
					
					echo "<tr>";
					echo "<td>$id</td>";
					echo "<td>$getPost</td>";
					echo "<td>$reason</td>";
					echo "<td>$comment</td>";
					echo "<td>$getUsername</td>";
					echo "<td><a href=\"editRepDB.php?postid=$postID\">EDIT</a></td>";
					echo "<td><a onClick=\"javascript: return confirm(' Are you sure you want to delete this post: $getPost?');\" href=\"deleteDBPost.php?postid=$postID\">DELETE</a></td>";
					echo "<td><a onClick=\"javascript: return confirm(' Are you sure you want to delete the report for?: $getPost');\" href=\"deleteReportDB.php?reportid=$id\">DELETE</a></td>";		
					echo "</tr>";
				}
				echo"</tbody>";
				echo"</table>";
				
			} else {
				echo noexist("forum post reports");
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