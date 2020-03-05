<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();
	
	require_once("function.php"); // Include header to the page
	echo makePageStart("Talk2Me - Validate Account");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
  
  
<section class="box">
	<div class="container top-content">
<?php
	if(!isset($_SESSION['userID'])){ //if user is not logegd in
?>	
<a href="index.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back to home</p></a>	
		<h1><strong>Validate Account</strong></h1>
		
		
		<div class="formDiv"> 
		<div class="formInfo">
		<p>Enter email to validate Account:</p>
		</div>
			<form method="post" action="validateAccProcess.php" id="validateAccForm">
			
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">E</span>mail: </label>
					</div>
					<div class="col-sm-10">
						<input type="text" name="email" id="emailVal" class="form-control textboxWidth" accesskey="e" placeholder="Email">
						<p class="hint">(Valid email format: user@gmail.com)</p>
						<p id="errorEmailVal" style="color: red;"></p>
					</div>
				</div>
				
				<div class="space floatRight ">
					<input type="reset" id="clearVal"  class="button" value="Clear">
					<input type="submit" id="submitVal"  class="button" value="Submit">
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
