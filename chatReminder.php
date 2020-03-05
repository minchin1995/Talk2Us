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
	
	echo makePageStart("Talk2Me - Reminder");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">
<?php
	// check if user is logged in
	if (isset($_SESSION['userID'])){
?>
<a href="chat.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
		<h1><strong>Reminder</strong></h1>
		
		<div class="formDiv"> 
		
			<div class="formInfo">
		<ul>
		<li>
			Please be reminded that users that are venting are in need, so please be kind and polite 
			to others.
		</li>
		<li>
			In any case, please do not share your private information to others.
		</li>
		<li>
			Links to any external personal social medias such as Facebook is not allowed.
		</li>
		<li>
			Activities like trolling and bullying is not tolerated.
		</li>
		<li>
			The chat is unmoderated directly by the admin, admins will only take action towards a user if the user is reported.
		</li>
		<li>
			In any case that a user has been reported, user will be banned from this website so please be careful
		</li>
		<li>
			In any case that any suicidal thoughts is realized, kindly stop provide help to professional website or hotlines.
		</li>
		
		</ul>
		</div>
		
		<form method="post" action="chatPage.php" id="loginForm">
		
			<div class="space formInfo">
				<p class="checkbox"><input type="checkbox" class="checkReminder">Yes I will take note of the reminder when chatting with others<br></p>
			</div>

			<div class="space floatRight">
				<input type="submit" class="button" id="ok" value="OK" disabled>
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