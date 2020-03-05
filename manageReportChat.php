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
	$sqlRep = "SELECT report.reportID,reasonType,comment,reportchat.userID AS reported, report.userID AS reporting
	FROM reportreason JOIN report ON (reportreason.reasonID=report.reasonID)
	JOIN reportchat ON (report.reportID=reportchat.reportID)
	ORDER BY report.reportID";

	//query the SQL statement
	$rsRep = mysqli_query($conn,$sqlRep)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Manage Report(Chat)");  
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
	<h1><strong>Manage Report (Chat)</strong></h1>
	
	<table id="repChattable">
		<thead>
			<tr>
				<th>ID</th>
				<th>User Reported</th>
				<th>Reason</th>
				<th>Comment</th>
				<th>User</th>
				<th>Ban User</th>
				<th>Delete Report</th>
			</tr>
		</thead>
		<tbody>
<?php
				while($row = mysqli_fetch_assoc($rsRep)){
					$id				= 	$row["reportID"];
					$reason			=	$row["reasonType"];
					$comment		=	$row["comment"];
					$rUserID		=	$row["reporting"];
					$reportedUserID	=	$row["reported"];
					
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
					$sqlU = "SELECT username
									 FROM user
									  WHERE userID='$reportedUserID'";
											
					// query sql statement
					$rsU = mysqli_query($conn,$sqlU)
								  or die(mysqli_error($conn));
					
					$rowU = mysqli_fetch_row($rsU)
							or die(mysqli_error($conn));
				
					//execute each field
					$getUserReported = $rowU[0];
					
					echo "<tr>";
					echo "<td>$id</td>";
					echo "<td>$getUserReported</td>";
					echo "<td>$reason</td>";
					echo "<td>$comment</td>";
					echo "<td>$getUsername</td>";
					echo "<td><a onClick=\"javascript: return confirm(' Are you sure you want to ban: $getUserReported?');\" href=\"banUser.php?userID=$reportedUserID\">BAN</a></td>";
					echo "<td><a onClick=\"javascript: return confirm(' Are you sure you want to delete the report for: $getUserReported?');\" href=\"deleteReportChat.php?reportid=$id\">DELETE</a></td>";		
					echo "</tr>";
				}
				echo"</tbody>";
				echo"</table>";
				
			} else {
				echo noexist("chat users reports");
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