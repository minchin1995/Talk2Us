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

	//check the existence of categoryid
	if (isset($_GET["categoryid"])) {
		$categoryid = $_GET["categoryid"];//get categoryid
	}
	else {
		header("Location: manageDB.php"); // redirect back if there is not categoryid
	}
	
	//check if there any records of forum topics
	$sqlfaq = "SELECT *
	FROM forumtopic
	WHERE categoryID='$categoryid'
	ORDER BY topicID";

	//query the SQL statement
	$rsfaq = mysqli_query($conn,$sqlfaq)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Manage Forum Topic");  
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
			
			//select all records
			$sqlTName = "SELECT categoryName
			FROM forumcategory
			WHERE categoryID='$categoryid'";

			//query the SQL statement
			$rsTName = mysqli_query($conn,$sqlTName)
			or die(mysqli_error($conn));
	
			$row = mysqli_fetch_row($rsTName)
				or die(mysqli_error($conn));
    
			//execute each field
			$catName = $row[0];
?>
<a href="manageDBCat.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
<?php	
			echo "<h1><strong>$catName</strong></h1>";
?>			
	<table id="dbtopictable">
		<thead>
		<tr>
			<th>ID</th>
			<th>Topic</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
		</thead>
		<tbody>
<?php
				while($row = mysqli_fetch_assoc($rsfaq)){
					$id			= 	$row["topicID"];
					$name		= 	$row["topicName"];
					
					echo "<tr>";
					echo "<td>$id</td>";
					echo "<td>$name</td>";
					echo "<td><a href=\"editDBTopic.php?topicid=$id\">EDIT</a></td>";
					echo "<td><a onClick=\"javascript: return confirm(' Are you sure you want to delete $name? ');\" href=\"deleteDBTopic.php?topicid=$id\">DELETE</a></td>";
					echo "</tr>";
				}
				echo"</tbody>";
				echo"</table>";
				
			} else {
				echo noexist("Forum Topics");
				echo "<a href=\"manageDBCat.php\"><p>Return to manage forum categories</p></a>";
				echo "<a href=\"manageDB.php\"><p>Return to manage forums</p></a>";
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