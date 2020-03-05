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
		//get the generated username of user
		$usernameGen = $_SESSION['usernameGen'];
	}

	echo makePageStart("Talk2Us - Create Topic");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">

<?php
	// check if user is logged in
	if (isset($_SESSION['userID'])){
?>		
<a href="forum.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
<?php
	if ($accountID == "1") {
?>
<a href="manageDB.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back to manage forum</p></a>
<?php
	}
?>
		<h1><strong>Create Forum Topic</strong></h1>
		
		<div class="formDiv"> 
		
			<div class="formInfo">
			<p>* Mandatory fields</p>
			</div>
			
			<form method="post" action="createDBTopicProcess.php" id="createTopicForm">
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">T</span>opic Name: *</label>
					</div>
					<div class="col-sm-10">
						<textarea name="tName" rows="3" cols="50" id="tName" class="form-control textboxWidth" placeholder="Topic Name" accesskey="t" style="resize: none;"></textarea>
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
											
											
								echo "<option value=\"\" selected=\"selected\">Select a Topic</option>\n";
								   
								//iterate category record
								while($row = mysqli_fetch_array($rsCat)){
									//populate select item
									$cat = $row[0];
									echo "<option value =\"$cat\">$cat</option>\n";
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
						<input type="text" name="catName" id="catName"  class="form-control textboxWidth" placeholder="Category Name" accesskey="a">
						<p class="hint">(Category Name needs to be less than 200 characters)</p>
						<p id="errorCatName" style="color: red;"></p>
					</div>
				</div>
				
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">P</span>ost: *</label>
					</div>
					<div class="col-sm-10">
						<textarea name="post" rows="6" cols="50" id="post" class="form-control" placeholder="Post" accesskey="p" style="resize: none;"></textarea>
						<p class="hint">(Post needs to be less than 2000 characters)</p>
						<p id="errorPost" style="color: red;"></p>
					</div>	
				</div>	
				
					
				<div class="space floatRight">
					<input type="reset" class="button" id="clearDBTopic" value="Clear">
					<input type="submit" class="button" id="submitDBTopic" value="Submit">
				</div>
				<br class="clearRight"/>
			</form> 
		</div>
	
<?php
	} else {
		echo nolog();
	}
?>

</div>
</section>

<?php
	echo makeFooter();
  ?>