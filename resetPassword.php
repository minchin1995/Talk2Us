<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();
	
	require_once("function.php"); // Include header to the page
	echo makePageStart("Talk2Me - Reset Password");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
  
  
<section class="box">
	<div class="container top-content">
<?php
	if(!isset($_SESSION['userID'])){
?>
<a href="index.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back to Home</p></a>	
		<h1><strong>Reset Password</strong></h1>
		
		<div class="formDiv"> 
		
			<div class="formInfo">
			<p>Enter email to reset password:</p>
			<p>* Mandatory fields</p>
			</div>
			
			<form method="post" action="resetPasswordProcess.php" id="resetPasswordForm">
			
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">E</span>mail: </label>
					</div>
					<div class="col-sm-10">	
						<input type="text" name="email" id="emailReset" class="form-control textboxWidth" accesskey="e" placeholder="Email">
						<p class="hint">(Valid email format: user@gmail.com)</p>
						<p id="errorEmailReset" style="color: red;"></p>
					</div>
				</div>
				
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">P</span>assword: </label>
					</div>
					<div class="col-sm-10">	
						<input type="password" name="passwd" id="passwdReset" class="form-control textboxWidth" accesskey="p" placeholder="Password">
						<p class="hint">(Password is between 6 and 15 characters)</p>
						<p id="errorPassReset" style="color: red;"></p>
					</div>
				</div>
				
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">C</span>onfirm Password: </label>
					</div>
					<div class="col-sm-10">	
						<input type="password" name="cpasswd" id="cpasswdReset" class="form-control textboxWidth" accesskey="c" placeholder="Confirm Password">
						<p class="hint">(Repeat password entered)</p>
						<p id="errorCPassReset" style="color: red;"></p>
					</div>
				</div>
				
				<div class="formBottom">
					<p id="errorEmailExistsRes" style="color: red;"></p>
				</div>
				
				<div class="space floatRight">
					<input type="button" class="button" id="clearReset" value="Clear">
					<input type="submit" class="button" id="submitReset" value="Submit">
				</div>
				<br class="clearRight"/>
			</form> 
		</div>
<?php
	}else{
		echo logged();
	}

?>
	</div>
</section>
 
 
<?php
	echo makeFooter();
  ?>
