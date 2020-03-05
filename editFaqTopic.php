<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";
	
	//check the existence of topicid
	if (isset($_GET["topicid"])) {
		$topicid = $_GET["topicid"];//get topicid
	}
	else {
		header("Location: manageFAQ.php"); // redirect back if there is not blogid
	}
	
	if(isset($_SESSION['userID'])){
		//get username of user logged in
		$username = $_SESSION['username'];
		//get userID of user logged in
		$userID = $_SESSION['userID'];
		//get role of user when user is logged in
		$accountID = $_SESSION['role'];
	}

	//check if faq topic exists
	$sqlCheck = "SELECT topicname
	FROM faqtopic
	WHERE topicid=$topicid";

	//query the SQL statement
	$rsCheck = mysqli_query($conn,$sqlCheck)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Edit FAQ Topic");  
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
				$row = mysqli_fetch_row($rsCheck)
				or die(mysqli_error($conn));
    
				//execute each field
				$topicName = $row[0];
?>
<a href="manageFAQTopic.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
		<h1><strong>Edit FAQ topic</strong></h1>
		<div class="formDiv"> 
		
			<div class="formInfo">
			<p>* Mandatory fields</p>
			</div>
			
			<form method="post" action="editFaqTopicProcess.php" id="faqTopicForm">
			
				<div class="space row" style="visibility:hidden; position:absolute">
					<div class="col-sm-2">
						<label>Topic ID:</label>
					</div>
					<div class="col-sm-10">	
						<input type="text" name="topicID" id="topicID" class="form-control textboxWidth" value="<?=$topicid?>" readonly>
					</div>
				</div>
				
				<div class="space row">
					<div class="col-sm-2">
						<label>T<span class="red">o</span>pic Name: *</label>
					</div>
					<div class="col-sm-10">	
						<input type="text" name="topicName" id="topicName"class="form-control textboxWidth" placeholder="Topic Name" accesskey="o" value="<?=$topicName?>">
						<p class="hint">(Topic Name needs to be less than 200 charcaters)</p>
						<p id="errorTNameFAQ" style="color: red;"></p>
					</div>
				</div>
					
				<div class="space floatRight">
					<input type="reset" class="button" id="clearFAQTopic" value="Clear">
					<input type="submit" class="button" id="submitFAQTopic" value="Submit">
				</div>
				<br class="clearRight"/>
			</form> 

<?php
			} else {
				echo noexist("FAQ");
				echo "<a href=\"manageFAQTopics.php\"><p>Return to manage FAQ topics</p></a>";
				echo "<a href=\"manageFAQ.php\"><p>Return to manage FAQ</p></a>";
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