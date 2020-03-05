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
	}

	echo makePageStart("Talk2Me - Edit Reported Forum Post");   
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
	
	//set timezone
	date_default_timezone_set("Asia/Kuala_Lumpur");
	// get current time
	$time = date("H:i:s");
	// get current date
	$date = date("Y-m-d");

	$post		=	filter_has_var(INPUT_POST, 'post') ? $_POST['post']: null;
	$postid		=	filter_has_var(INPUT_POST, 'postid') ? $_POST['postid']: null;

	//sanitize data
	$post	    = filter_var($post,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$post 	    = filter_var($post,FILTER_SANITIZE_SPECIAL_CHARS);
	$postid	    = filter_var($postid,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$postid 	= filter_var($postid,FILTER_SANITIZE_SPECIAL_CHARS);
	
	//remove space both before and after the data
	$post		=	trim($post);
	$postid		=	trim($postid);

?>
<section class="box">
	<div class="container top-content">
		<div class="processDiv">
<?php
	if(isset($_SESSION['userID'])){
		if ($accountID == "1") {
			$errorList = array();
			
			//validate post
			if (empty($post)) { 
				$errorList[] = "You have not entered a post.";
			} else if (strlen($post) > 2000) { 
				$errorList[] = "Post should not be more than 2000 character.";
			} 
			
			//display error messages
			if (!empty($errorList)) {
				for ($a=0; $a < count($errorList); $a++) {
					echo "$errorList[$a] <br />\n";
				}
				echo "<p>Please try again.</p>\n";
			}
			else {
				//edit forum post
				$sqlEditPost = "UPDATE forumpost 
						 SET content='$post',
						 editDate='$date',
						 editTime='$time',
						 editUserID='$userID'
						 WHERE postID='$postid'";
											
				// query sql statement
				$rsEditPost = mysqli_query($conn,$sqlEditPost)
						or die(mysqli_error($conn));
						
				if(mysqli_affected_rows($conn)>0){
					echo "<p>Post successfully Edited.</p>";
				}
				else {
					echo "<p style=\"color: red\">Unable to edit post!</p>";
				}
				
				//get report id posts
				$sqlGetRep = "SELECT reportID
				FROM reportpost 
				WHERE postID='$postid'";

				//query the SQL statement
				$rsGetRep = mysqli_query($conn,$sqlGetRep)
				or die(mysqli_error($conn));
				
				while($row = mysqli_fetch_assoc($rsGetRep)){
					$reportid		= 	$row["reportID"];
					//delete report
					$sqlDeleteRS = "DELETE FROM reportpost 
								 WHERE postID='$postid'
								 AND reportID='$reportid'";

					$rsDeleteRS = mysqli_query($conn,$sqlDeleteRS)
					or die(mysqli_error($conn));

					$sqlDeleteR = "DELETE FROM report 
								 WHERE reportID='$reportid'";
									 
					$rsDeleteR = mysqli_query($conn,$sqlDeleteR)
					or die(mysqli_error($conn));
				}
				
			}
			echo "<a href=\"manageReportDB.php\"><p>Return to manage forum post reports</p></a>";
			echo "<a href=\"manageReport.php\"><p>Return to manage reports</p></a>";
			echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
		}else{
			echo wronglog ("admins");
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