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

	echo makePageStart("Talk2Me - Report Blog");   
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
	
	$postid		=	filter_has_var(INPUT_POST, 'postid') ? $_POST['postid']: null;
	$reportType	=	filter_has_var(INPUT_POST, 'reportType') ? $_POST['reportType']: null;
	$comment	=	filter_has_var(INPUT_POST, 'comment') ? $_POST['comment']: null;

	//sanitize data
	$postid	   	= filter_var($postid,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$postid 	   	= filter_var($postid,FILTER_SANITIZE_SPECIAL_CHARS);
	$reportType	= filter_var($reportType,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$reportType 	= filter_var($reportType,FILTER_SANITIZE_SPECIAL_CHARS);
	$comment	= filter_var($comment,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$comment	= filter_var($comment,FILTER_SANITIZE_SPECIAL_CHARS);
	
	//remove space both before and after the data
	$postid		=	trim($postid);
	$reportType	=	trim($reportType);
	$comment	=	trim($comment);

?>
<section class="box">
	<div class="container top-content">
		<div class="processDiv">
<?php
	if(isset($_SESSION['userID'])){
		if ($accountID == "2") {
			
			$errorList = array();
			
			//validate reporttype
			if (empty($reportType)) {
				$errorList[] = "You have not selected a reason to report blog.";
			} 
			
			//valdiate comment
			if (!empty($comment)) { 
				if (strlen($comment) > 200) { 
					$errorList[] = "Comment should not be more than 200 character.";
				} 
			} 
			
			//display error messages
			if (!empty($errorList)) {
				for ($a=0; $a < count($errorList); $a++) {
					echo "$errorList[$a] <br />\n";
				}
				echo "<p>Please try again.</p>\n";
			}
			else {
				//add report
				$sqlAddReport = "INSERT INTO report 
							 SET userID='$userID',
							 comment='$comment',
							 reasonID=(SELECT reasonID
										FROM reportreason
										WHERE reasonType='$reportType')";
												
				// query sql statement
				$rsAddReport = mysqli_query($conn,$sqlAddReport)
								or die(mysqli_error($conn));
								
								
				$sqlAddReportPost = "INSERT INTO reportblog 
							 SET reportID=(
										SELECT reportID
										FROM report
										WHERE userID='$userID'
										AND comment='$comment'
										AND reasonID=(SELECT reasonID
														FROM reportreason
														WHERE reasonType='$reportType')
										 ORDER BY reportID DESC 
										 LIMIT 1
										),
							 blogID='$postid'";
												
				// query sql statement
				$rsAddReportPost = mysqli_query($conn,$sqlAddReportPost)
								or die(mysqli_error($conn));

				if(mysqli_affected_rows($conn)>0){
					echo "<p>Report successfully added.</p>";
					header("Location: blogPost.php?blogid=$postid");
					
				} else {
					echo "<p style='color:red;'>Unable to add report!</p>";
				}
			}
			echo "<a href=\"blogPost.php?blogid=$postid\"><p>Return to blog</p></a>";
			echo "<a href=\"blog.php\"><p>Return to blog</p></a>";
			echo "<a href=\"index.php\"><p>Return to home</p></a>";
		}else{
			echo wronglog ("users");
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