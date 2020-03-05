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
	
	echo makePageStart("Talk2Me - Admin");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">
<?php
	if(isset($_SESSION['userID'])){ //check if user id logged in
		if ($accountID == "1") { //check if user is an admin
?>	
	<h1><strong>Admin</strong></h1>
	
	<div class="row">
		<div class="col-md-4">
            <div class="services">
              <div class="icons">
                <i class="fa fa-user fa-3x"></i>
              </div>
			  <a href="manageAdmin.php"/><h4>Manage Admins</h4></a>
            </div>
        </div>
		
		<div class="col-md-4">
            <div class="services">
              <div class="icons">
                <i class="fa fa-users fa-3x"></i>
              </div>
              <a href="manageUser.php"/><h4>Manage Users</h4></a>
            </div>
        </div>
		
		<div class="col-md-4">
            <div class="services">
              <div class="icons">
                <i class="fa fa-book fa-3x"></i>
              </div>
              <a href="manageBlog.php"/><h4>Manage Blog</h4></a>
            </div>
        </div>
	</div>
	
	<div class="row">
		<div class="col-md-4">
            <div class="services">
              <div class="icons">
                <i class="fa fa-pencil-square-o fa-3x"></i>
              </div>
              <a href="manageDB.php"/><h4>Manage Forum</h4></a>
            </div>
        </div>
		
		<div class="col-md-4">
            <div class="services">
               <div class="icons">
                <i class="fa fa-users fa-3x"></i>
              </div>
              <a href="manageGS.php"/><h4>Manage Group Support</h4></a>
            </div>
        </div>
		
		<div class="col-md-4">
            <div class="services">
              <div class="icons">
                <i class="fa fa-question-circle fa-3x"></i>
              </div>
              <a href="manageFAQ.php"/><h4>Manage FAQ</h4></a>
            </div>
        </div>
	</div>
	
	<div class="row">
		<div class="col-md-4">
        </div>
		
		<div class="col-md-4">
            <div class="services">
              <div class="icons">
                <i class="fa fa-exclamation-circle fa-3x"></i>
              </div>
              <a href="manageReport.php"/><h4>Manage Reports</h4></a>
            </div>
        </div>
		
		<div class="col-md-4">
        </div>
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

