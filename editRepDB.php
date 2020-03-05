<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";
	
	//check the existence of postid
	if (isset($_GET["postid"])) {
		$postid = $_GET["postid"];//get postid
	}
	else {
		header("Location: manageReportDB.php"); // redirect back if there is not postid
	}
	
	if(isset($_SESSION['userID'])){
		//get username of user logged in
		$username = $_SESSION['username'];
		//get userID of user logged in
		$userID = $_SESSION['userID'];
		//get role of user when user is logged in
		$accountID = $_SESSION['role'];
	}

	//check if reported forum post exists
	$sqlCheck = "SELECT content
	FROM reportpost JOIN forumpost ON (reportpost.postID=forumpost.postID)
	WHERE reportpost.postID='$postid'";

	//query the SQL statement
	$rsCheck = mysqli_query($conn,$sqlCheck)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Edit Reported Forum Post");  
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
				$content = $row[0];
?>
<a href="manageReportDB.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
		<h1><strong>Edit Reported Forum Post</strong></h1>
		<div class="formDiv"> 
		
			<div class="formInfo">
			<p>* Mandatory fields</p>
			</div>
			
			<form method="post" action="editRepDBProcess.php" id="editRepDBForm">
			
				<div class="space row" style="visibility:hidden; position:absolute">
					<div class="col-sm-2">
						<label>Post ID:</label>
					</div>
					<div class="col-sm-10">	
						<input type="text" name="postid" class="form-control textboxWidth" id="postid" value="<?=$postid?>" readonly>
					</div>
				</div>
				
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">P</span>ost: *</label>
					</div>
					<div class="col-sm-10">
	<?php
					echo "<textarea name=\"post\" rows=\"5\" id=\"post\" placeholder=\"Post\" class=\"form-control\" accesskey=\"p\" style=\"resize: none;\">$content</textarea>";
	?>
						<p class="hint">(Post needs to be less than 2000 characters)</p>
						<p id="errorPost" style="color: red;"></p>
					</div>
				</div>	

					
				<div class="space floatRight">
					<input type="reset" class="button" id="clearDBRep" value="Clear">
					<input type="submit" class="button" id="submitDBRep" value="Submit">
				</div>
				<br class="clearRight"/>
			</form> 
		</div>
<?php
			} else {
				echo noexist("report forum post");
				echo "<a href=\"manageReportDB.php\"><p>Return to manage forum post reports</p></a>";
				echo "<a href=\"manageReport.php\"><p>Return to manage reports</p></a>";
				echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
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