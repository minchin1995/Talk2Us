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
	
	echo makePageStart("Talk2Me - Add Admin");  
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
<a href="manageAdmin.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
	<h1><strong>Add Admin</strong></h1>
	<div class="formDiv">
		<div class="formInfo">
			<p>Enter username and password to add admin:</p>
			<p>* Mandatory fields</p>
		</div>

		<form method="post" action="createAdminprocess.php" id="createAdminForm">
		
			<div class="space row">
				<div class="col-sm-2">
					<label><span class="red">E</span>mail: *</label>
				</div>
				<div class="col-sm-10">	
					<input type="text" name="email" id="email" class="form-control textboxWidth" accesskey="e">
					<p class="hint">(Valid email format: user@gmail.com)</p>
					<p id="errorEmailA" style="color: red;"></p>
				</div>
			</div>
			
			<div class="space row">
				<div class="col-sm-2">
					<label><span class="red">U</span>ser name: *</label>
				</div>
				<div class="col-sm-10">	
					<input type="text" name="userName" id="userName" class="form-control textboxWidth" accesskey="u">
					<p class="hint">(Username is between 6 and 15 characters)</p>
					<p id="errorUNameA" style="color: red;"></p>
				</div>
			</div>
			
			<div class="space row">
				<div class="col-sm-2">
					<label><span class="red">D</span>ate of Birth: *</label>
				</div>
				<div class="col-sm-10">	
					<input type="text" name="dob" id="dob" class="form-control textboxWidth" accesskey="d">
					<p class="hint">(You need to be above 18 to use this site)</p>
					<p class="hint">(Format of date: YYYY-MM-DD (Eg: 1999-03-12))</p>
					<p id="errorDobA" style="color: red;"></p>
				</div>
			</div>
			
			<div class="space row">
				<div class="col-sm-2">
					<label><span class="red">P</span>assword: *</label>
				</div>
				<div class="col-sm-10">	
					<input type="password" name="passwd" id="passwd" class="form-control textboxWidth" accesskey="p">
					<p class="hint">(Password is between 6 and 15 characters)</p>
					<p id="errorPwordA" style="color: red;"></p>
				</div>
			</div>
			
			<div class="space row">
				<div class="col-sm-2">
					<label><span class="red">C</span>onfirm Password: *</label>
				</div>
				<div class="col-sm-10">	
					<input type="password" name="cpasswd" id="cpasswd" class="form-control textboxWidth" accesskey="c">
					<p class="hint">(Repeat password entered)</p>
					<p id="errorCPWordA" style="color: red;"></p>
				</div>
			</div>
				
			<div class="space floatRight">
				<input type="reset" class="button" id="clearAdmin" value="Clear">
				<input type="submit" class="button" id="addAdmin" value="Add Admin">
			</div>
			<br class="clearRight"/>
		</form> 
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
