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
	$sqlApply = "SELECT *
	FROM supporttopic
	ORDER BY sTopicID";

	//query the SQL statement
	$rsApply = mysqli_query($conn,$sqlApply)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Manage Groups");  
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
<a href="manageGS.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>	
	<h1><strong>Manage Group Support</strong></h1>	
	
	<table id="grouptable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Group Name</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
<?php
				while($row = mysqli_fetch_assoc($rsApply)){
					$id				= 	$row["sTopicID"];
					$name			=	$row["sTopicName"];
					
					echo "<tr>";
					echo "<td>$id</td>";
					echo "<td><a href=\"manageGSMembers.php?topicID=$id\">$name</a></td>";
					echo "<td><a href=\"editGS.php?topicid=$id\">EDIT</a></td>";
					echo "<td><a onClick=\"javascript: return confirm(' Are you sure you want to delete $name? ');\" href=\"deleteGS.php?topicid=$id\">DELETE</a></td>";				
					echo "</tr>";
				}
				echo"</tbody>";
				echo"</table>";
				
			} else {
				echo noexist("group support topics");
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