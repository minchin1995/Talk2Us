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

	echo makePageStart("Talk2Us - Apply Group Support");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">

<?php
	
	if (isset($_SESSION['userID'])){ // check if user is logged in
		if ($accountID == "2") { //check if user is user
?>		
<a href="groupSupport.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
		<h1><strong>Apply for Group Support</strong></h1>
		
		<div class="formDiv"> 
		
			<div class="formInfo">
				<p>Please tell us the reason for wanting to apply for us to ensure that we assign you to the correct group.</p>
				<p>* Mandatory fields</p>
			</div>
			
			<form method="post" action="applyGSProcess.php" id="applyGSForm">
			
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">R</span>eason: *</label>
					</div>
					<div class="col-sm-10">	
						<textarea name="reason" rows="6" id="reason" class="form-control" placeholder="Post" accesskey="r"></textarea>
						<p class="hint">(Reason needs to be less than 200 characters)</p>
						<p id="errorReaGS" style="color: red;"></p>
					</div>
				</div>	
				
					
				<div class="space floatRight">
					<input type="reset" class="button" id="clearAppGS" value="Clear">
					<input type="submit" class="button" id="submitAppGS" value="Submit">
				</div>
				<br class="clearRight"/>
			</form> 
		</div>
<?php
		} else {
			echo wronglog("users");
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