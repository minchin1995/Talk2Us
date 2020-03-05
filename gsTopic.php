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
	
	
	//check the existence of topicID
	if (isset($_GET["topicID"])) {
		$topicID = $_GET["topicID"];//get topicid
	}
	else {
		header("Location: groupSupport.php"); // redirect back to forum if there is not topicID
	}
	
	// number of posts per page
	$results_per_page = 10;
	
	//get total number of posts
	$sqlTotalPost = "SELECT * 
					FROM supportpost
					WHERE sTopicID = $topicID
					ORDER BY sDate ASC, sTime ASC";

	//execute sql statement
	$rsTotalPost = mysqli_query($conn,$sqlTotalPost)
	or die(mysqli_error($conn));
	
	// total number of posts for this topic
	$number_of_results = mysqli_num_rows($rsTotalPost);
	
	// total number of pages
	$number_of_pages = ceil($number_of_results/$results_per_page);
	
	if(!isset($_GET['page'])){ 
		//if there is no page set it to page 1
		$page = 1;
	}else {
		$page = $_GET['page'];
	}
	
	// get page of first
	$this_page_first_result = ($page-1)*$results_per_page;
	
	//select category name for the category is being displayed
	$sqlForumTop = "SELECT sTopicName
					FROM supporttopic
					WHERE sTopicID = $topicID";

	//execute sql statement
	$rsForumTop = mysqli_query($conn,$sqlForumTop)
	or die(mysqli_error($conn));
	
	$resultForumTop = mysqli_fetch_array($rsForumTop);

	$topicName 		= $resultForumTop['sTopicName']; //topic name

	echo makePageStart("ImaSuperFan - $topicName");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">
<?php	
if(isset($_SESSION['userID'])){
	
?>
<a href="groupSupport.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>				
<?php
	echo "<h1><strong>$topicName</strong></h1>";
	//check if user is registered for the group
	$sqlCheck = "SELECT * 
					FROM supportuser
					WHERE sTopicID = '$topicID'
					AND userID = '$userID'";

	//execute sql statement
	$rsCheck = mysqli_query($conn,$sqlCheck)
	or die(mysqli_error($conn));
		
	if ((mysqli_affected_rows($conn)>0)||($accountID == "1")){ //display if user is in group
		
		//select all categories of topics for discussion board
		$sqlForumPost = "SELECT * 
						FROM supportpost
						WHERE sTopicID = $topicID
						ORDER BY sDate ASC, sTime ASC
						LIMIT ".$this_page_first_result.",".$results_per_page;

		//execute sql statement
		$rsForumPost = mysqli_query($conn,$sqlForumPost)
		or die(mysqli_error($conn));
		
		if (mysqli_affected_rows($conn)>0){ //check if there are any posts in topic
			if ($accountID == "2"){
				echo "<div class=\"dbButtons\">";
				echo "<a href=\"quitGS.php?topicID=$topicID\" class=\"buttonLeft\"><p>Quit</p></a>";
				echo "</div>";
							
				echo "<br class=\"clearRight\"/>";
			}
			
			//display all the this topic in database
			while($row = mysqli_fetch_assoc($rsForumPost)){
				$id				= 	$row["sPostID"];
				$sUserID		= 	$row["sUserID"];
				$content		= 	html_entity_decode($row["sContent"]);
				$date			= 	$row["sDate"];
				$time			= 	$row["sTime"];
				$editTime		= 	$row["sEditTime"];
				$editDate		= 	$row["sEditDate"];
				$editUserID		= 	$row["sEditUserID"];
				
				$content = nl2br($content);
				
				//select username of post
				$sqlPostUser = "SELECT usernameGen
								FROM user
								WHERE userID = $sUserID";

				//execute sql statement
				$rsPostUser = mysqli_query($conn,$sqlPostUser)
				or die(mysqli_error($conn));
				
				$resultPostUser = mysqli_fetch_array($rsPostUser);

				$username 		= $resultPostUser['usernameGen']; //topic name
				
				echo "<div class=\"dbPost\">";
				echo "<div class=\"dbUsername\">";
				echo "<p class=\"postGSUname $id\">$username</p>";
				echo "</div>";
				
				echo "<p><span class=\"labels\">Posted on:</span> $date, $time</p>";
				
				if($editTime != NULL) { //display edited details if they exist
					//select username of post
					$sqlEditID = "SELECT usernameGen, accountID
									FROM user
									WHERE userID = $editUserID";

					//execute sql statement
					$rsEditID = mysqli_query($conn,$sqlEditID)
					or die(mysqli_error($conn));
					
					$resultEditID = mysqli_fetch_array($rsEditID);

					$editUsername 		= $resultEditID['usernameGen'];
					$editAccID 		= $resultEditID['accountID'];
					if ($editAccID=="2"){
						echo "<p><span class=\"labels\">Edited By</span>: $editUsername</p>";
					}else{
						if($editUserID != $sUserID){
							echo "<p><span class=\"labels\">Edited By</span>: $editUsername (Admin)</p>";
						}else{
							echo "<p><span class=\"labels\">Edited By</span>: $editUsername </p>";
						}
					}
					echo "<p><span class=\"labels\">Edited On</span>: $editTime, $editDate</p>";
				}
				
				echo "<div>";
				echo "<p class=\"gsPostContent $id\">$content</p>";
				echo "</div>";
				
				if (isset($_SESSION['userID'])){
					echo "<div class=\"dbButtons\">";
					if (($sUserID != $userID)&&($accountID == "2")) { //users can report other user's post
						//check if user reported 
						$sqlCheckReport = "SELECT report.reportID
						FROM report JOIN reportsupport ON (report.reportID=reportsupport.reportID)
						WHERE sPostID=$id
						AND userID=$userID";

						//query the SQL statement
						$rsCheckReport = mysqli_query($conn,$sqlCheckReport)
						or die(mysqli_error($conn));
							
						if (mysqli_affected_rows($conn)===0) {
							echo "<a href=\"reportGS.php?postid=$id\" class=\"buttonLeft\"><p>Report</p></a>";
						}else{
							echo "<p class=\"reported\">Reported</p>";
						}
					}
					if (($sUserID == $userID)||($accountID == "1")) { //allow user to edit their own post or admin to edit posts
						echo "<div class=\"editGSPost $id\"><a class=\"buttonLeft\" data-postid=\"$id\" ><p>Edit</p></a></div>";
					}
					if ($accountID == "1") { //only admin can delete posts
						echo "<a onClick=\"javascript: return confirm(' Are you sure you want to delete $content? ');\" href=\"deleteGSPost.php?postid=$id\" class=\"buttonLeft\"><p>Delete</p></a>";
					}
					if ($sUserID != $userID) { //only allow user to reply to otehr suer's post
						echo "<div class=\"replyGSPost $id\"><a class=\"buttonLeft\" data-postid=\"$id\" ><p>Reply</p></a></div>";
					}
					echo "</div>";
					
					echo "<br class=\"clearRight\"/>";
				}
				echo "</div>";
			}
			
			if ($number_of_pages > 1) {//show paging if there is more than 1 page
				echo "<ul class=\"pagination pagination-lg\">";
				for ($page=1;$page<=$number_of_pages;$page++){
					echo "<li><a href=\"forumtopic.php?topicID=$topicID&page=$page\">$page</a></li>";
				}
				echo "</ul>";
			}
		
		
// check if user is logged in
	if (isset($_SESSION['userID'])){
?>
<form method="post">
	<div style="visibility:hidden; position:absolute">
		<label>Topic ID:</label>
		<input type="text" name="topicID" id="topicID" value="<?=$topicID?>" readonly>
	</div>
	
	<div>
		<label>Message:</label>
		<textarea name="message" rows="5"  class="form-control" id="gsMessage" placeholder="Message" style="resize: none;"></textarea>
		<p class="hint">(Post needs to be less than 2000 characters)</p>
		<p class="hint">(Never remove anything when replying to a post)</p>
		<p id="postErr" style="color: red;"></p>
	</div>
	<div class="floatRight">
		<input type="reset" class="button" id="clearPostGS" value="Clear">
		<input  type='button' class="button" name="submit" id="submitPostGS" value="Post"/>
	</div>
	<br class="clearRight"/>
</form>
<?php
	}	
		}else{
			echo noexist("posts");
			echo "<a href=\"groupSupport.php\"><p>Return to group support page</p></a>";
			echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
		}
	} else {
		echo "<p>Sorry, you are not in the group.</p>";
	}
}else{
	nolog ();
}
?>
</div>
</section>

<?php

	echo makeFooter();
  ?>