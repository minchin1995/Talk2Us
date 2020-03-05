<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

    require_once("function.php"); // Include header to the page
	
	if(isset($_SESSION['userID'])){
		//get username of user logged in
		$username = $_SESSION['username'];
		//get userID of user logged in
		$userID = $_SESSION['userID'];
		//get role of user when user is logged in
		$accountID = $_SESSION['role'];
	}
	
	//connect to database
	include "database_conn.php";

	echo makePageStart("ImaSuperFan - Post Blog");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">
<?php
	if(isset($_SESSION['userID'])){ //if user is logged in
		if ($accountID == "1") {	//if user is admin
?>
<a href="manageBlog.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
		<h1><strong>Post Blog</strong></h1>
		<div class="formDiv"> 
			<div class="formInfo">
				<p>* Mandatory fields</p>
			</div>
			
			<form method="post" action="postBlogProcess.php" id="blogPostForm">
				<div class="space row">
					<div class="col-sm-2">
						<label>Blog <span class="red">T</span>itle: </label>
					</div>
					<div class="col-sm-10">		
						<input type="text" name="title" id="title" class="form-control textboxWidth" placeholder="Blog Title" accesskey="t">
						<p id="blogTitleErr" class="red"></p>	
					</div>
				</div>
					
				<div class="space row">
					<div class="col-sm-2">
						<label>Blog C<span class="red">o</span>ntent:</label>
					</div>
					<div class="col-sm-10">		
						<textarea name="content" class="form-control textboxWidth" rows="15" id="content" placeholder="Blog Content" style="resize: none;" accesskey="o"></textarea>
						<p>(Content must be less than 5000 words)</p>
						<p id="blogContentErr" class="red"></p>
					</div>
				</div>
				
				<div class="space">
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
								echo "<SELECT name =\"category\" class=\"form-control\" id =\"categoryPBlog\" accesskey=\"c\">\n";
											
											
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
					<p id="blogPostErr" style="color: red;"></p>
				</div>
				<div class="space floatRight">
					<input type="reset" class="button" id="clearPostBlog" value="Clear">
					<input type="submit" class="button" id="postBlog" value="Submit">
				</div>
				<br class="clearRight"/>
			</form>  
		</div>
<?php
			}else{
			echo wronglog ("admins");
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