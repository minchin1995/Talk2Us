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
		header("Location: manageDB.php"); // redirect back if there is not topicid
	}
	
	if(isset($_SESSION['userID'])){
		//get username of user logged in
		$username = $_SESSION['username'];
		//get userID of user logged in
		$userID = $_SESSION['userID'];
		//get role of user when user is logged in
		$accountID = $_SESSION['role'];
	}

	//check if topic exists
	$sqlCheck = "SELECT topicName, categoryName
	FROM forumtopic JOIN forumcategory ON (forumtopic.categoryID=forumcategory.categoryID)
	WHERE topicID=$topicid";

	//query the SQL statement
	$rsCheck = mysqli_query($conn,$sqlCheck)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Edit Forum Topic");  
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
				$topName = $row[0];
				$catName = $row[1];
?>
<a onclick="history.go(-1);" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
		<h1><strong>Edit Forum Topic</strong></h1>
		<div class="formDiv"> 
		
			<div class="formInfo">
			<p>* Mandatory fields</p>
			</div>
			
			<form method="post" action="editDBTopicProcess.php" id="dbTopicEditForm">
			
				<div class="space row" style="visibility:hidden; position:absolute">
					<div class="col-sm-2">
						<label>Topic ID:</label>
					</div>
					<div class="col-sm-10">	
						<input type="text" name="topicid" class="form-control textboxWidth" id="topicid" value="<?=$topicid?>" readonly>
					</div>
				</div>
				
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">T</span>opic Name: *</label>
					</div>
					<div class="col-sm-10">
	<?php
					echo "<textarea name=\"tName\" rows=\"3\" cols=\"50\" id=\"tName\" placeholder=\"Topic Name\" class=\"form-control\" accesskey=\"t\" style=\"resize: none;\" >$topName</textarea>";
	?>
						<p class="hint">(Topic Name needs to be less than 200 characters)</p>
						<p id="errorTopicName" style="color: red;"></p>
					</div>
				</div>	

				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">C</span>ategory: *</label>
					</div>
					<div class="col-sm-10">
					<?php
								//select category name from table
								$sqlCat ="SELECT DISTINCT categoryName
										  FROM forumcategory
										  ORDER BY categoryName";
								   
								//query sql statement
								$rsCat = mysqli_query($conn, $sqlCat)
								or die("SQL Error: ".mysqli_error($conn));

								//create select item
								echo "<SELECT name =\"category\"  class=\"form-control\" id =\"category\" accesskey=\"c\">\n";
								   
								//iterate category record
								while($row = mysqli_fetch_array($rsCat)){
									//populate select item
									$cat = $row[0];
									if ($cat == $catName) {
										echo "<option value =\"$cat\" selected>$cat</option>\n";
									}else{
										echo "<option value =\"$cat\">$cat</option>\n";
									}
									
								}
								echo "<option value =\"catOthers\">Others</option>\n";
								echo "</select>";
									  
								//remove result set
								mysqli_free_result($rsCat);
								?>
						<p id="errorCat" style="color: red;"></p>
					</div>
				</div>	

				<div class="space row" id="displayCat" style="display: none;">
					<div class="col-sm-2">
						<label>C<span class="red">a</span>tegory Name: *</label>
					</div>
					<div class="col-sm-10">	
						<input type="text" name="catName" id="catName" class="form-control textboxWidth" placeholder="Category Name" accesskey="a">
						<p class="hint">(Category Name needs to be less than 200 characters)</p>
						<p id="errorCatName" style="color: red;"></p>
					</div>
				</div>
					
				<div class="space floatRight">
					<input type="reset" class="button" id="clearDBTop" value="Clear">
					<input type="submit" class="button" id="submitDBTop" value="Submit">
				</div>
				<br class="clearRight"/>
			</form> 
		</div>
<?php
			} else {
				echo noexist("forum topic");
				echo "<a href=\"manageDBCat.php\"><p>Return to manage forum categories</p></a>";
				echo "<a href=\"manageDB.php\"><p>Return to manage forum</p></a>";
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