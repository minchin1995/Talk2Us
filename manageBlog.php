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
	}
	
	echo makePageStart("Talk2Us - Manage Blog");  
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
?>		
<a href="admin.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
	<h1><strong>Manage Blog</strong></h1>
	<div class="row">
		<div class="col-md-4">
            <div class="services">
              <div class="icons">
                <i class="fa fa-pencil-square-o fa-3x"></i>
              </div>
			  <a href="postBlog.php"/><h4>Post Blog</h4></a>
            </div>
        </div>
		
		<div class="col-md-4">
            <div class="services">
              <div class="icons">
                <i class="fa fa-envelope fa-3x"></i>
              </div>
			  <a href="manageSubmitted.php"/><h4>Manage Submitted Blog</h4></a>
            </div>
        </div>
		
		<div class="col-md-4">
            <div class="services">
              <div class="icons">
                <i class="fa fa-book fa-3x"></i>
              </div>
              <a href="managePosted.php"/><h4>Manage Posted Blog</h4></a>
            </div>
        </div>
	</div>

<?php
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