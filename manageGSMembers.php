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

	//check the existence of topicID
	if (isset($_GET["topicID"])) {
		$topicID = $_GET["topicID"];//get topicID
	}
	else {
		header("Location: manageGroups.php"); // redirect back if there is not topicID
	}
	
	//select all records
	$sqlApply = "SELECT *
	FROM supportuser
	WHERE sTopicID=$topicID
	ORDER BY userID";

	//query the SQL statement
	$rsApply = mysqli_query($conn,$sqlApply)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Manage Members");  
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
<a href="manageGroups.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
	<h1><strong>Manage Group Support Members</strong></h1>	
	
	<table id="groupmemtable">
		<thead>
			<tr>
				<th>User</th>
				<th>Remove</th>
			</tr>
		</thead>
		<tbody>
<?php
				while($row = mysqli_fetch_assoc($rsApply)){
					$sUserID			=	$row["userID"];
					$id				=	$row["sTopicID"];
					
					// get username
					$sqlUname = "SELECT username
									 FROM user
									  WHERE userID='$sUserID'";
											
					// query sql statement
					$rsUname = mysqli_query($conn,$sqlUname)
								  or die(mysqli_error($conn));
					
					$row = mysqli_fetch_row($rsUname)
							or die(mysqli_error($conn));
				
					//execute each field
					$getUsername = $row[0];
					
					echo "<tr>";
					echo "<td>$getUsername</td>";
					echo "<td><a onClick=\"javascript: return confirm(' Are you sure you want to remove $getUsername? ');\" href=\"removeUser.php?topicID=$id&userID=$sUserID\">REMOVE</a></td>";				
					echo "</tr>";
				}
				echo"</tbody>";
				echo"</table>";
				
			} else {
				echo noexist("users");
				echo "<a href=\"manageGroups.php\"><p>Return to manage groups</p></a>";
				echo "<a href=\"manageGS.php\"><p>Return to manage group supports</p></a>";
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