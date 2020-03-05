<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";
	
	//check the existence of faqid
	if (isset($_GET["faqid"])) {
		$faqid = $_GET["faqid"];//get faqid
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

	//check if faq exists
	$sqlCheck = "SELECT faqQuestion, faqAnswer, topicname
	FROM faq JOIN faqtopic ON (faq.faqTopicID=faqtopic.topicID)
	WHERE faqID=$faqid";

	//query the SQL statement
	$rsCheck = mysqli_query($conn,$sqlCheck)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Edit FAQ");  
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
				$question = $row[0];
				$answer = $row[1];
				$topicname = $row[2];
?>
		<a onclick="history.go(-1);" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
		<h1><strong>Edit FAQ</strong></h1>
		<div class="formDiv"> 
		
			<div class="formInfo">
			<p>* Mandatory fields</p>
			</div>
			
			<form method="post" action="EditFaqProcess.php" id="faqEditForm">
				<div class="space row" style="visibility:hidden; position:absolute">
					<div class="col-sm-2">
						<label>FAQ ID:</label>
					</div>
					<div class="col-sm-10">	
						<input type="text" name="faqID" class="form-control textboxWidth" id="faqID" value="<?=$faqid?>" readonly>
					</div>
				</div>
				
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">Q</span>uestion: *</label>
					</div>
					<div class="col-sm-10">	
						<?php 
						echo "<textarea name=\"question\" rows=\"3\" id=\"question\" class=\"form-control\" placeholder=\"Question\" accesskey=\"q\" style=\"resize: none;\">$question</textarea>";
						?>
						<p class="hint">(Question needs to be less than 200 characters)</p>
						<p id="errorQFAQ" style="color: red;"></p>
					</div>
				</div>	
					
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">A</span>nswer: *</label>
					</div>
					<div class="col-sm-10">	
						<?php 
						echo "<textarea name=\"answer\" rows=\"6\" class=\"form-control\" id=\"answer\" placeholder=\"Answer\" accesskey=\"a\" style=\"resize: none;\">$answer </textarea>";
						?>
						<p class="hint">(Answer needs to be less than 2000 characters)</p>
						<p id="errorAFAQ" style="color: red;"></p>
					</div>
				</div>	

				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">T</span>opic: *</label>
					</div>
					<div class="col-sm-10">	
					<?php
								//select category name from table
								$sqlTop ="SELECT DISTINCT topicname
										  FROM faqtopic
										  ORDER BY topicname";
								   
								//query sql statement
								$rsTop = mysqli_query($conn, $sqlTop)
								or die("SQL Error: ".mysqli_error($conn));

								//create select item
								echo "<SELECT name =\"topic\" class=\"form-control\" id =\"topic\" accesskey=\"t\">\n";

								//iterate category record
								while($row = mysqli_fetch_array($rsTop)){
									//populate select item
									$top = $row[0];
									if ($top == $topicname) {
										echo "<option value =\"$top\" selected>$top</option>\n";
									}
									else {
										echo "<option value =\"$top\">$top</option>\n";
									}
								}
								echo "<option value =\"topicOthers\">Others</option>\n";
								echo "</select>";
									  
								//remove result set
								mysqli_free_result($rsTop);
								?>
						<p id="errorTFAQ" style="color: red;"></p>
					</div>
				</div>	

				<div class="space row" id="displayTopic" style="display: none;">
					<div class="col-sm-2">
						<label>T<span class="red">o</span>pic Name: *</label>
					</div>
					<div class="col-sm-10">	
						<input type="text" name="topicName" id="topicName" class="form-control textboxWidth" placeholder="Topic Name" accesskey="o">
						<p class="hint">(Topic Name needs to be less than 200 characters)</p>
						<p id="errorTNameFAQ" style="color: red;"></p>
					</div>
				</div>
					
				<div class="space floatRight">
					<input type="reset" class="button" id="clearEditFAQ" value="Clear">
					<input type="submit" class="button" id="submitEditFAQ" value="Submit">
				</div>
				<br class="clearRight"/>
			</form> 
		</div>
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