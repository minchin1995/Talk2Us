<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	
	require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";
	
	//check the existence of blogid
	if (isset($_GET["blogid"])) {
		$blogid = $_GET["blogid"];//get blogid
	}
	else {
		header("Location: manageSubmitted.php"); // redirect back if there is not blogid
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
	$sqlBlog = "SELECT sBlogName, sBlogPost, sUserID
	FROM submitblogpost
	WHERE sBlogID=$blogid";
	
	//query the SQL statement
	$rsBlog = mysqli_query($conn,$sqlBlog)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Post Submitted Blog");  
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
				$row = mysqli_fetch_row($rsBlog)
				or die(mysqli_error($conn));
    
				//execute each field
				$title = $row[0];
				$post = $row[1];
				$blogUserID = $row[2];

?>	
	<a href="manageSubmitted.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
		<h1><strong>Post Submitted Blog</strong></h1>
		
		<div class="formDiv"> 
			<div class="formInfo">
				<p>* Mandatory fields</p>
			</div>
			
			<form method="post" action="postBlogProcess.php" id="blogPostSubForm">
				<div class="space row">
					<div class="col-sm-2">
						<label>Blog Title: </label>
					</div>
					<div class="col-sm-10">		
						<input type="text" name="title" id="title" class="form-control textboxWidth" placeholder="Blog Title" value="<?=$title?>" readonly>
					</div>
				</div>
					
				<div class="space row">
					<div class="col-sm-2">
						<label>Blog Content:</label>
					</div>
					<div class="col-sm-10">		
		<?php
					echo "<textarea name=\"content\" rows=\"15\" class=\"form-control\" id=\"content\" placeholder=\"Blog Content\" style=\"resize: none;\" readonly>$post</textarea>";
		?>
					</div>
				</div>
				
				<div class="space row" style="visibility:hidden; position:absolute">
					<div class="col-sm-2">
						<label>User ID: </label>
					</div>
					<div class="col-sm-10">	
						<input type="text" name="userID" class="form-control textboxWidth" id="userID" value="<?=$blogUserID?>" readonly>
					</div>
				</div>
				
				<div class="space row" style="visibility:hidden; position:absolute">
					<div class="col-sm-2">
						<label>Blog ID: </label>
					</div>
					<div class="col-sm-10">	
						<input type="text" name="blogID" class="form-control textboxWidth" id="blogID" value="<?=$blogid?>" readonly>
					</div>
				</div>
				
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">C</span>ategory: *</label>
					</div>
					<div class="col-sm-10">	
					<?php
								//select category name from table
								$sqlCat ="SELECT DISTINCT blogCatName
										  FROM blogCategory
										  ORDER BY blogCatName";
								   
								//query sql statement
								$rsCat = mysqli_query($conn, $sqlCat)
								or die("SQL Error: ".mysqli_error($conn));

								//create select item
								echo "<SELECT name =\"category\" class=\"form-control\" id =\"categoryPBlogSub\" accesskey=\"c\">\n";
											
											
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
						<p id="blogcatErr" style="color: red;"></p>
					</div>
				</div>	

				<div class="space row" id="displayCat" style="display: none;">
					<div class="col-sm-2">
						<label>C<span class="red">a</span>tegory Name: *</label>
					</div>
					<div class="col-sm-10">		
						<input type="text" name="catName" class="form-control textboxWidth" id="catName" placeholder="Category Name" accesskey="a">
						<p class="hint">(Category Name needs to be less than 200 characters)</p>
						<p id="blogCatNameErr" style="color: red;"></p>
					</div>	
				</div>
				
				<div class="formBottom">
					<p id="blogPostSubErr" style="color: red;"></p>
				</div>
				
				<div class="space floatRight">
					<input type="reset" class="button" id="clearPostSubBlog" value="Clear">
					<input type="submit" class="button" id="postSubBlog" value="Submit">
				</div>
				<br class="clearRight"/>
			</form>  
	
<?php
			} else {
				echo noexist("Submitted Blog");
				echo "<a href=\"manageSubmitted.php\"><p>Return to manage group support</p></a>";
				echo "<a href=\"manageBlog.php\"><p>Return to manage group support</p></a>";
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