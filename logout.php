<?php
	ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

    require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";

	echo makePageStart("Talk2Me - Log Out");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">
<?php
if(isset($_SESSION['userID'])){ //if user is logged in
	//logout user
	session_start();
	$_SESSION["logged-in"] = false;
	unset($_SESSION["username"]);
	unset($_SESSION["userID"]);
	unset($_SESSION["role"]);
	header("location: index.php");
} else {
	echo nolog();
}
?>
	</div>
</section>

<?php
	echo makeFooter();
?>