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
		header("Location: managePosted.php");
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
	$sqlCheck = "SELECT blogName,blogPost,blogCatName
	FROM blogpost JOIN blogcategory ON (blogpost.blogCatID=blogcategory.blogCatID)
	WHERE blogID=$blogid
	AND blogWritten IS NULL";

	//query the SQL statement
	$rsCheck = mysqli_query($conn,$sqlCheck)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Edit Blog Post");  
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
				$title = $row[0];
				$post = $row[1];
				$catName = $row[2];
?>
<a onclick="history.go(-1);" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
		<h1><strong>Edit Blog Post</strong></h1>
		
		<div class="formDiv"> 
		
			<div class="formInfo">
			<p>* Mandatory fields</p>
			</div>

			<form method="post" action="editBlogPostProcess.php" id="editBlogPostForm">
				<div class="space row" style="visibility:hidden; position:absolute">
					<div class="col-sm-2">
						<label>Blog ID:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" name="blogID" class="form-control textboxWidth" id="blogID" value="<?=$blogid?>" readonly>
					</div>
				</div>
					
				<div class="space row">
					<div class="col-sm-2">
						<label>Blog <span class="red">T</span>itle: </label>
					</div>
					<div class="col-sm-10">	
						<input type="text" name="title" class="form-control textboxWidth" id="title"  value="<?=$title?>" placeholder="Blog Title" accesskey="t">
						<p id="blogTitleErr" class="red"></p>	
					</div>	
				</div>
						
				<div class="space row">
					<div class="col-sm-2">
						<label>Blog C<span class="red">o</span>ntent:</label>
					</div>
					<div class="col-sm-10">	
		<?php
						echo "<textarea name=\"content\" rows=\"15\" cols=\"50\" id=\"content\"  class=\"form-control\" placeholder=\"Blog Content\" style=\"resize: none;\" accesskey=\"o\">$post</textarea>";
		?>
						<p>(Content must be less than 5000 words)</p>
						<p id="blogContentErr" class="red"></p>
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
									echo "<SELECT name =\"category\" class=\"form-control\" id =\"categoryEBlog\" accesskey=\"c\">\n";
									   
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
						<p id="blogcatErr" style="color: red;"></p>
					</div>
				</div>	

				<div class="space row" id="displayCat" style="display: none;">
					<div class="col-sm-2">
						<label>C<span class="red">a</span>tegory Name: *</label>
					</div>
					<div class="col-sm-10">	
						<input type="text" name="catName"  class="form-control" id="catName" placeholder="Category Name" accesskey="a">
						<p class="hint">(Category Name needs to be less than 200 characters)</p>
						<p id="blogCatNameErr" style="color: red;"></p>
					</div>	
				</div>

				<div class="space floatRight">
					<input type="reset" class="button" id="clearEditBlog" value="Clear">
					<input type="submit" class="button" id="submitEditBlog" value="Submit">
				</div>
				<br class="clearRight"/>
			</form> 
		</div>

<?php
			} else {
				echo noexist("blog");
				echo "<a href=\"managePosted.php\"><p>Return to manage posted blog</p></a>";
				echo "<a href=\"manageBlog.php\"><p>Return to manage blog</p></a>";
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