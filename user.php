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
		
		//get details of user who is logged in
		$sqlUser = "SELECT email
					 FROM user
					 WHERE username='$username'";
						 
		$rsUser = mysqli_query($conn,$sqlUser)
		or die(mysqli_error($conn));
		
		$row = mysqli_fetch_row($rsUser)
				or die(mysqli_error($conn));
    
		//execute each field
		$email = $row[0];
	}
	
	echo makePageStart("Talk2Me - User");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
  
  
<section class="box">
	<div class="container top-content">
	
		<h1><strong>User</strong></h1>
		<?php
	// check if user is logged in
	if (isset($_SESSION['userID'])){
?>
		<div class="formDiv"> 
			<div class="formInfo">
<?php
		echo "<p>Welcome: $username</p>";
?>
				<p>Enter any details as desired and click edit to edit</p>
			</div>
			
			<form method="post" action="userProcess.php" id="editUserForm">
				
				<div class="space row">
					<div class="col-sm-2">
						<label>Generated Username: </label>
					</div>
					<div class="col-sm-10">
						<input type="text" name="genUname" id="genUname" class="form-control textboxWidth" accesskey="e" value="<?=$usernameGen?>" readonly>
					</div>
				</div>
				
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">E</span>mail: </label>
					</div>
					<div class="col-sm-10">
						<input type="text" name="email" id="email" class="form-control textboxWidth" accesskey="e" value="<?=$email?>">
						<p class="hint">(Valid email format: user@gmail.com)</p>
						<p id="errorEmailU" style="color: red;"></p>
					</div>
				</div>
				
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">U</span>ser name: </label>
					</div>
					<div class="col-sm-10">
						<input type="text" name="userName" id="userName" class="form-control textboxWidth" accesskey="u" value="<?=$username?>">
						<p class="hint">(Username is between 6 and 15 characters)</p>
						<p id="errorUNameU" style="color: red;"></p>
					</div>
				</div>
				
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">D</span>ate of Birth:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" name="dob" id="dob" class="form-control textboxWidth" accesskey="d">
						<p class="hint">(You need to be above 18 to use this site)</p>
						<p class="hint">(Format of date: YYYY-MM-DD (Eg: 1999-03-12))</p>
						<p id="errorDobU" style="color: red;"></p>
					</div>
				</div>
				
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">P</span>assword: </label>
					</div>
					<div class="col-sm-10">
						<input type="password" id="passwd" class="form-control textboxWidth" name="passwd" accesskey="p">
						<p class="hint">(Password is between 6 and 15 characters)</p>
						<p id="errorPwordU" style="color: red;"></p>
					</div>
				</div>
				
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">C</span>onfirm Password: </label>
					</div>
					<div class="col-sm-10">
						<input type="password" id="cpasswd" class="form-control textboxWidth" name="cpasswd" accesskey="c">
						<p class="hint">(Repeat password entered)</p>
						<p id="errorCPWordU" style="color: red;"></p>
					</div>
				</div>
				
				<div class="formBottom">
					<p id="errorNone" style="color: red;"></p>
				</div>
				
				<div class="space floatRight ">
					<input type="reset"  class="button" id="clearUser" value="Clear">
					<input type="submit"  class="button" id="updateUser" value="Edit">
				</div>
				<br class="clearRight"/>
			</form> 
		</div>
<?php
	} else {
		echo nolog();
	}

?>
	</div>
</section>
 
 
<?php
	echo makeFooter();
  ?>
