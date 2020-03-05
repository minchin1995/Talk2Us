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
	FROM faqtopic
	ORDER BY topicID";

	//query the SQL statement
	$rsfaq = mysqli_query($conn,$sqlfaq)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Manage FAQ Topics");  
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
<a href="manageFAQ.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
	<h1><strong>Manage FAQ Topics</strong></h1>	
	<table id="faqtable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Topic Name</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
<?php
				while($row = mysqli_fetch_assoc($rsfaq)){
					$id				= 	$row["topicID"];
					$name			=	$row["topicname"];
					
					echo "<tr>";
					echo "<td>$id</td>";
					echo "<td><a href=\"manageFAQQues.php?topicid=$id\">$name</a></td>";
					echo "<td><a href=\"editFaqTopic.php?topicid=$id\">EDIT</a></td>";				
					echo "<td><a onClick=\"javascript: return confirm(' Are you sure you want to delete $name? ');\" href=\"deleteFaqTopic.php?topicid=$id\">DELETE</a></td>";					
					echo "</tr>";
				}
				echo"</tbody>";
				echo"</table>";
				
			} else {
				echo noexist("FAQ topics");
				echo "<a href=\"manageFAQ.php\"><p>Return to manage FAQs</p></a>";
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