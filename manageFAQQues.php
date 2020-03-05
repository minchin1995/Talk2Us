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

	//check the existence of topicid
	if (isset($_GET["topicid"])) {
		$topicid = $_GET["topicid"];//get topicid
	}
	else {
		header("Location: manageFAQ.php"); // redirect back if there is not topicid
	}
	
	//check if there any faq topics
	$sqlfaq = "SELECT *
	FROM faq
	WHERE faqTopicID='$topicid'
	ORDER BY faqID";

	//query the SQL statement
	$rsfaq = mysqli_query($conn,$sqlfaq)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Manage FAQ");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
	
?>
<section class="box">
	<div class="container top-content">
<a href="manageFAQTopic.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
<?php
	// check if user is logged in
	if (isset($_SESSION['userID'])){
		// check if user is an admin
		if ($accountID == "1") {
			if (mysqli_affected_rows($conn)>0) {	
			
			//select all records
			$sqlTName = "SELECT topicname
			FROM faqtopic
			WHERE topicID='$topicid'";

			//query the SQL statement
			$rsTName = mysqli_query($conn,$sqlTName)
			or die(mysqli_error($conn));
	
			$row = mysqli_fetch_row($rsTName)
				or die(mysqli_error($conn));
    
			//execute each field
			$topicName = $row[0];
			
			echo "<h1><strong>$topicName</strong></h1>";
?>			

	<table id="faqquestable">
		<thead>
		<tr>
			<th>ID</th>
			<th>Question</th>
			<th>Answer</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
		</thead>
		<tbody>
<?php
				while($row = mysqli_fetch_assoc($rsfaq)){
					$id				= 	$row["faqID"];
					$question		= 	$row["faqQuestion"];
					$answer			=	$row["faqAnswer"];
					
					echo "<tr>";
					echo "<td>$id</td>";
					echo "<td>$question</td>";
					echo "<td>$answer</td>";
					echo "<td><a href=\"editFaq.php?faqid=$id\">EDIT</a></td>";					
					echo "<td><a onClick=\"javascript: return confirm(' Are you sure you want to delete $question? ');\" href=\"deleteFaq.php?faqid=$id\">DELETE</a></td>";					
					echo "</tr>";
				}
				echo"</tbody>";
				echo"</table>";
				
			} else {
				echo noexist("FAQ");
				echo "<a href=\"manageFAQTopic.php\"><p>Return to manage FAQ topics</p></a>";
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