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
	
	echo makePageStart("Talk2Me - Chat");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">
	<h1><strong>Chat</strong></h1>
	<p>
		Talk2Us allows user to chat with other users. Users can choose to be a listener where on listen to another user's problem or a 
		venter where on talks about their problems. 
		If there us any problems with users you are chatting with please report to us immediately.
		Please be noted that users are not professionals so if you do have any suicidal thoughts please do visit the hotline for suicide
	</p>
<?php
	if(isset($_SESSION['userID'])){ //check if user is logged in
?>
<a href="chatReminder.php" class="buttonLeft"><p> Start</p></a>
<?php
	} else{
?>
<p>Register or login to start</p>
<?php
	}
?>
	</div>
</section>

<?php
	echo makeFooter();
?>