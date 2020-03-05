<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";
	
	//check the existence of catid
	if (isset($_GET["catid"])) {
		$catID = $_GET["catid"];//get catid
	}
	else {
		header("Location: managePosted.php"); // redirect back to forum if there is not catid
	}
	
	if(isset($_SESSION['userID'])){
		//get username of user logged in
		$username = $_SESSION['username'];
		//get userID of user logged in
		$userID = $_SESSION['userID'];
		//get role of user when user is logged in
		$accountID = $_SESSION['role'];
	}

	//check if blog exists
	$sqlCheck = "SELECT blogCatName
	FROM blogcategory
	WHERE blogCatID=$catID";

	//query the SQL statement
	$rsCheck = mysqli_query($conn,$sqlCheck)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Edit Blog Category");  
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
				$catName = $row[0];
?>
<a href="managePosted.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
		<h1><strong>Edit Blog Category</strong></h1>
		<div class="formDiv"> 
		
			<div class="formInfo">
			<p>* Mandatory fields</p>
			</div>
			
			<form method="post" action="editBlogCatProcess.php" id="editBlogCatForm">
				<div class="space row" style="visibility:hidden; position:absolute">
					<div class="col-sm-2">
						<label>Category ID:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" name="catID" id="catID" class="form-control textboxWidth" value="<?=$catID?>" readonly>
					</div>
				</div>
					
				<div class="space row">
					<div class="col-sm-2">
						<label>C<span class="red">a</span>tegory Name: *</label>
					</div>
					<div class="col-sm-10">
						<input type="text" name="catName" id="catName" class="form-control textboxWidth" placeholder="Category Name" accesskey="a" value="<?=$catName?>">
						<p class="hint">(Category Name needs to be less than 200 charcaters)</p>
						<p id="errorBlogCatName" style="color: red;"></p>
					</div>
				</div>
						
				<div class="space floatRight">
					<input type="reset" class="button" id="clearBlogCat" value="Clear">
					<input type="submit" class="button" id="submitBlogCat" value="Submit">
				</div>
				<br class="clearRight"/>	
			</form> 
		</div>

<?php
			} else {
				echo noexist("blog category");
				echo "<a href=\"managePosted.php\"><p>Return to manage posted blogs</p></a>";
				echo "<a href=\"manageBlog.php\"><p>Return to manage blogs</p></a>";
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