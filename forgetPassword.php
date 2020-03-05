<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();
	
	require_once("function.php"); // Include header to the page
	echo makePageStart("Talk2Me - Forget Password");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
  
  
<section class="box">
	<div class="container top-content">
<?php
	if(!isset($_SESSION['userID'])){ //if suer is not logged in
?>	
<a href="login.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>							
		<h1><strong>Forget Password</strong></h1>

		<div class="formDiv"> 
		
		<div class="formInfo">
		<p>Enter email to reset password:</p>
		<p>* Mandatory fields</p>
		</div>
		
		<form method="post" action="forgetPasswordProcess.php" id="forgetPasswordForm">
		
			<div class="space row">
				<div class="col-sm-2">
					<label><span class="red">E</span>mail: *</label>
				</div>
				<div class="col-sm-10">
					<input type="text" name="email" id="emailForget" class="form-control textboxWidth" accesskey="e" placeholder="Email">
					<p class="hint">(Valid email format: user@gmail.com)</p>
					<p id="errorEmailForget" style="color: red;"></p>
				</div>
			</div>
			
			<div class="formBottom">
				<p id="errorEmailExists" style="color: red;"></p>
			</div>
			
			<div class="space floatRight">
				<input type="reset"  class="button" id="clearForget" value="Clear">
				<input type="submit"  class="button" id="submitForget" value="Submit">
			</div>
			<br class="clearRight"/>
		</form> 
<?php
	}else{
		echo logged();
	}

?>
	</div>
	</div>
</section>
 
 
<?php
	echo makeFooter();
  ?>
