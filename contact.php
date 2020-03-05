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
	
	echo makePageStart("Talk2Me - Contact");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
  
  
<section class="box">
	<div class="container top-content">
		<h1><strong>Contact</strong></h1>

		<div class="formDiv"> 
		
			<div class="formInfo">
			<p>Any problems? Contact the admins.</p>
			<p>* Mandatory fields</p>
			</div>
			
			<form method="post" action="contactProcess.php" id="contactForm">

				<?php
					if (!isset($_SESSION['userID'])) { //check is user is logged in, if user is not logged in user has to enter their email
				?>
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">E</span>mail: *</label>
					</div>
					<div class="col-sm-10">
						<input type="text" name="email" id="emailCon" placeholder="Email" class="form-control textboxWidth" accesskey="e">
						<p class="hint">(Valid email format: user@gmail.com)</p>
						<p id="errorEmailCon" style="color: red;"></p>
					</div>
				</div>
				<?php
					}
				?>
				
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">P</span>roblems: *</label>
					</div>
					<div class="col-sm-10">
						<textarea name="problems" rows="8" id="problems" class="form-control" placeholder="Problems" accesskey="p"></textarea>
						<p class="hint">(Problems needs to be less than 2000 characters)</p>
						<p id="errorProb" style="color: red;"></p>
					</div>
				</div>	
					
				<div class="space floatRight">
				<input type="reset" class="button" id="clearCon" value="Clear">
				<?php
					if (isset($_SESSION['userID'])) { //if logged in
				?>
					<input type="submit" class="button" id="submitConLog" value="Submit">
				<?php
					}else{ //if not logged in
				?>	
					<input type="submit" class="button" id="submitCon" value="Submit">
				<?php
					}
				?>	
				
				</div>
				<br class="clearRight"/>
			</form> 
		
		</div>
	</div>
</section>
 
 
<?php
	echo makeFooter();
  ?>
