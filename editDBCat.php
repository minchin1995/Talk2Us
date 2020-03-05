<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";
	
	//check the existence of categoryid
	if (isset($_GET["categoryid"])) {
		$categoryid = $_GET["categoryid"];//get categoryid
	}
	else {
		header("Location: manageDB.php"); // redirect back if there is not categoryid
	}
	
	if(isset($_SESSION['userID'])){
		//get username of user logged in
		$username = $_SESSION['username'];
		//get userID of user logged in
		$userID = $_SESSION['userID'];
		//get role of user when user is logged in
		$accountID = $_SESSION['role'];
	}

	//check if category exists
	$sqlCheck = "SELECT categoryName
	FROM forumcategory
	WHERE categoryID=$categoryid";

	//query the SQL statement
	$rsCheck = mysqli_query($conn,$sqlCheck)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Edit Forum Category");  
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
				$categoryName = $row[0];
?>
<a href="manageDBCat.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
		<h1><strong>Edit Forum Catgeory</strong></h1>
		
		<div class="formDiv"> 
		
			<div class="formInfo">
			<p>* Mandatory fields</p>
			</div>
		
			<form method="post" action="editDBCatProcess.php" id="dbCatEditForm">
			
				<div class="space row" style="visibility:hidden; position:absolute">
					<div class="col-sm-2">
						<label>Category ID:</label>
					</div>
					<div class="col-sm-10">		
						<input type="text" name="catID" id="catID" value="<?=$categoryid?>" readonly>
					</div>
				</div>
				
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">C</span>ategory Name: *</label>
					</div>
					<div class="col-sm-10">		
						<input type="text" name="catName" id="catName" class="form-control textboxWidth" placeholder="Category Name" accesskey="c" value="<?=$categoryName?>">
						<p class="hint">(Category Name needs to be less than 200 characters)</p>
						<p id="errorCatName" style="color: red;"></p>
					</div>
				</div>
					
				<div class="space floatRight">
					<input type="reset" class="button" id="clearDBCat" value="Clear">
					<input type="submit" class="button" id="submitDBCat" value="Submit">
				</div>
				<br class="clearRight"/>
			</form> 
		</div>
<?php
			} else {
				echo noexist("forum category");
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