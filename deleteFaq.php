<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";
	
	//check the existence of faqid
	if (isset($_GET["faqid"])) {
		$faqid = $_GET["faqid"];//get faqid
	}
	else {
		header("Location: manageFAQ.php"); // redirect back if there is not blogid
	}
	
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

	//check if FAQ exists
	$sqlCheck = "SELECT faqID
	FROM faq
	WHERE faqID=$faqid";

	//query the SQL statement
	$rsCheck = mysqli_query($conn,$sqlCheck)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Delete FAQ");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
	
?>
<section class="box">
	<div class="container top-content">
	<div class="processDiv">
<?php
	// check if user is logged in
	if (isset($_SESSION['userID'])){
		// check if user is an admin
		if ($accountID == "1") {
			if (mysqli_affected_rows($conn)>0) {
				echo "<h1><strong>Delete FAQ</strong></h1>";
				
				//delete FAQ
				$sqlDeleteFAQ = "DELETE FROM faq 
								 WHERE faqID=".$faqid;
									 
				//execute sql statement
				$rsDeleteFAQ = mysqli_query($conn,$sqlDeleteFAQ)
				or die(mysqli_error($conn));
				
				
				if(mysqli_affected_rows($conn)>0){
					echo "<p>FAQ successfully deleted</p>";
					header("Location: manageFAQ.php");
				}
				else {
					echo "<p style='color:red;'>Unable to delete FAQ!</p>";
				}
				echo "<a href=\"manageFAQTopics.php\"><p>Return to manage FAQ topics</p></a>";
				echo "<a href=\"manageFAQ.php\"><p>Return to manage FAQ</p></a>";
				echo "<a href=\"admin.php\"><p>Return to admin page</p></a>";
			} else {
				echo noexist("FAQ");
				echo "<a href=\"manageFAQTopics.php\"><p>Return to manage FAQ topics</p></a>";
				echo "<a href=\"manageFAQ.php\"><p>Return to manage FAQ</p></a>";
				echo "<a href=\"admin.php\"><p>Return to admin page</p></a>";
			}
		} else {
			echo wronglog("Admins");
		}
	} else {
		echo nolog();
	}
	

?>

</div>
</div>
</section>

<?php
	echo makeFooter();
  ?>