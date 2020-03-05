<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	echo makePageStart("Talk2Me - Log In");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
  
  
<section class="box">
	<div class="container top-content">

<?php
	if(!isset($_SESSION['userID'])){ //if user is not logged in
?>
	<a href="index.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>				

	<h1><strong>Log In</strong></h1>
		<div class="formDiv"> 
		
			<div class="formInfo">
			<p>Enter username and password to login:</p>
			</div>
		
			<form method="post" action="login_process.php" id="loginForm">
			
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">U</span>ser name: </label>
					</div>
					<div class="col-sm-10">
						<input type="text" id="userName" name="userName" class="form-control textboxWidth" placeholder="Username" accesskey="u">
						<p id="errorUName" style="color: red;"></p>
					</div>
				</div>
				
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">P</span>assword: </label>
					</div>
					<div class="col-sm-10">	
						<input type="password" id="passwd" name="passwd" class="form-control textboxWidth" placeholder="Password" accesskey="p">
						<p id="errorPasswd" style="color: red;"></p>
					</div>
				</div>
				
				<div class="formBottom">
					<p id="matchErr" style="color: red;"></p>
				</div>
				
				<div class="space floatRight ">
					<input type="reset"  class="button" id="clearLog" value="Clear">
					<input type="submit"  class="button" id="login" value="Log In">
				</div>
				<br class="clearRight"/>
			</form> 
			
			<div class="formBottom">
				<a href="forgetPassword.php"><p>Forgotten you password?</p></a>
			</div>
			
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
