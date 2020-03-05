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

	echo makePageStart("ImaSuperFan - Submit Blog");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">
<?php
	if(isset($_SESSION['userID'])){ //check if user is logged in
		if ($accountID == "2") {	//check if user is user
?>
<a href="blog.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>	
		<h1><strong>Submit Blog</strong></h1>
		
		<div class="formDiv"> 
			<div class="formInfo">
				<p>
					Please be noted that the admin will decide if the blog will be posted. 
				</p>
				<p>* Mandatory fields</p>
			</div>

			<form method="post" action="submitBlogProcess.php" id="blogSubmitForm">
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">B</span>log Title: *</label>
					</div>
					<div class="col-sm-10">		
						<input type="text" accesskey="b" name="title" id="title" class="form-control textboxWidth" placeholder="Blog Title">
						<p>(Title must be less than 200 words)</p>
						<p id="blogTitleErr" class="red"></p>	
					</div>
				</div>
					
				<div class="space row">
					<div class="col-sm-2">
						<label>Blog <span class="red">C</span>ontent: *</label>
					</div>
					<div class="col-sm-10">	
						<textarea name="content" rows="15" accesskey="c" class="form-control textboxWidth" id="content" placeholder="Blog Content" style="resize: none;"></textarea>
						<p>(Content must be less than 5000 words)</p>
						<p id="blogContentErr" class="red"></p>
					</div>
				</div>
				
				<div class="formBottom">
					<p id="blogSubErr" style="color: red;"></p>
				</div>
				
				<div class="space floatRight">
					<input type="reset" class="button" id="clearSubBlog" value="Clear">
					<input type="submit" class="button" id="submitBlog" value="Submit">
				</div>
				<br class="clearRight"/>
			</form>  
		</div>
<?php
			}else{
			echo wronglog ("users");
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