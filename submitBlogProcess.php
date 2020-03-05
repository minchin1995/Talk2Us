<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	include "database_conn.php"; //connect to database
	
	if(isset($_SESSION['userID'])){
		//get username of user logged in
		$username = $_SESSION['username'];
		//get userID of user logged in
		$userID = $_SESSION['userID'];
		//get role of user when user is logged in
		$accountID = $_SESSION['role'];
	}
	
	echo makePageStart("Talk2Me - Submit Blog");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
  
  
<section class="box">
	<div class="container top-content">
		<div class="processDiv">
  <?php
  if(isset($_SESSION['userID'])){
		if ($accountID == "2") {	
			//get data from submit blog form
			$title			=	filter_has_var(INPUT_POST, 'title') ? $_POST['title']: null;
			$content		=	filter_has_var(INPUT_POST, 'content') ? $_POST['content']: null;
			
			//sanitize data
			$title	    	= filter_var($title,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			$title 	    	= filter_var($title,FILTER_SANITIZE_SPECIAL_CHARS);
			$content		= filter_var($content,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			$content 		= filter_var($content,FILTER_SANITIZE_SPECIAL_CHARS);
			
			//remove space both before and after the data
			$title			=	trim($title);
			$content       =	trim($content);
			
			//array for errors
			$errorList = array();
			
			//check if blog is submitted
			$sqlCheck = "SELECT sBlogID
						FROM submitblogpost
						WHERE sBlogName='$title'";
								
			// query sql statement
			$rsCheck = mysqli_query($conn,$sqlCheck)
						or die(mysqli_error($conn));
			
			//validate title
			if (empty($title)) {
				$errorList[] = "<p>You have not entered the title.</p>";
			}else if (strlen($title) > 200) { 
				$errorList[] = "<p>Title should not be more than 200 character.</p>";
			}else if (mysqli_affected_rows($conn)>0){ 
				$errorList[] = "<p>Sorry blog is already submitted.</p>";
			}
			//validate content
			if (empty($content)) {
				$errorList[] = "<p>You have not entered the content.</p>";
			}else if (strlen($content) > 5000) { 
				$errorList[] = "<p>Content should not be more than 5000 character.</p>";
			} 
			
			//display errors from array 
			if (!empty($errorList)) {
				for ($a=0; $a < count($errorList); $a++) {
					echo "$errorList[$a]";
				}
			}
			else { 
				$arrayBanned = file('censor/censored.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
			
				$matchedWords = array();
				$foundMatch = preg_match_all("/(" . implode($arrayBanned,"|") . ")/i", $content, $matchedWords);

				if ($foundMatch) {
					$foundWords = array_unique($matchedWords[0]);
					$newContent = str_replace($foundWords, "*", $content); //censor any social media link
			
					// Add blog to database
					$sqlSubBlog = "INSERT INTO submitblogPost (sBlogName,sBlogPost,sUserID)
									VALUES ('$title','$newContent','$userID')";
														  
					//query sql statement	
					mysqli_query($conn, $sqlSubBlog)
					or die(mysqli_error($conn));

							
					if(mysqli_affected_rows($conn)>0){
						echo "<p>Blog successfully submitted.</p>";
					}
					else {
						echo "<p style=\"color: red\">Unable to submit blog!</p>";
					}
				}else{
					// Add blog to database
					$sqlSubBlog = "INSERT INTO submitblogPost (sBlogName,sBlogPost,sUserID)
									VALUES ('$title','$content','$userID')";
														  
					//query sql statement	
					mysqli_query($conn, $sqlSubBlog)
					or die(mysqli_error($conn));

							
					if(mysqli_affected_rows($conn)>0){
						echo "<p>Blog successfully submitted.</p>";
					}
					else {
						echo "<p style=\"color: red\">Unable to submit blog!</p>";
					}
				}
			}
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