<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";
	
	//check the existence of postid
	if (isset($_GET["postid"])) {
		$postid = $_GET["postid"];//get postid
	}
	else {
		header("Location: forum.php"); // redirect back if there is not postid
	}
	
	if(isset($_SESSION['userID'])){
		//get username of user logged in
		$username = $_SESSION['username'];
		//get userID of user logged in
		$userID = $_SESSION['userID'];
		//get role of user when user is logged in
		$accountID = $_SESSION['role'];
	}

	//check if post exists
	$sqlCheck = "SELECT sContent, username
	FROM supportpost JOIN user ON (supportpost.sUserID=user.userID)
	WHERE sPostID=$postid";

	//query the SQL statement
	$rsCheck = mysqli_query($conn,$sqlCheck)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Report Post (Group Support)");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
	
?>
<section class="box">
	<div class="container top-content">
	
<?php
	// check if user is logged in
	if (isset($_SESSION['userID'])){
		if ($accountID == "2") {
			if (mysqli_affected_rows($conn)>0) {
				
?>
<a onclick="history.go(-1);" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
<?php
				//get topic id of post
				$sqlGetTopic = "SELECT sTopicID
				FROM supportpost 
				WHERE sPostID=$postid";

				//query the SQL statement
				$rsGetTopic = mysqli_query($conn,$sqlGetTopic)
				or die(mysqli_error($conn));
				
				$rowT = mysqli_fetch_row($rsGetTopic)
						or die(mysqli_error($conn));
				
				//execute each field
				$getTopicID = $rowT[0];
				
				//check is user is in group
				$sqlCheckGroup = "SELECT userID
				FROM supportuser
				WHERE sTopicID=$getTopicID";

				//query the SQL statement
				$rsCheckGroup = mysqli_query($conn,$sqlCheckGroup)
				or die(mysqli_error($conn));
					
				if (mysqli_affected_rows($conn)>0) {
					//check is post belongs to user
					$sqlCheckUser = "SELECT sPostID
					FROM supportpost 
					WHERE sUserID=$userID
					AND sPostID=$postid";

					//query the SQL statement
					$rsCheckUser = mysqli_query($conn,$sqlCheckUser)
					or die(mysqli_error($conn));
						
					if (mysqli_affected_rows($conn)===0) {
						//check if user reported 
						$sqlCheckReport = "SELECT report.reportID
						FROM report JOIN reportsupport ON (report.reportID=reportsupport.reportID)
						WHERE sPostID=$postid
						AND userID=$userID";

						//query the SQL statement
						$rsCheckReport = mysqli_query($conn,$sqlCheckReport)
						or die(mysqli_error($conn));
							
						if (mysqli_affected_rows($conn)===0) {
							$row = mysqli_fetch_row($rsCheck)
							or die(mysqli_error($conn));
					
							//execute each field
							$content = $row[0];
							$postUName = $row[1];
	?>
		<h1><strong>Report Post (Group Support)</strong></h1>
		<div class="formDiv"> 
		
			<div class="formInfo">
			<p>* Mandatory fields</p>
<?php
				echo "<p>$content</p>";
				echo "<p>$postUName</p>";
?>
			</div>


		<form method="post" action="reportGSProcess.php" id="reportGSForm">
			<div class="space row" style="visibility:hidden; position:absolute">
				<div class="col-sm-2">
					<label>Post ID:</label>
				</div>
				<div class="col-sm-10">	
					<input type="text" name="postid" id="postid" class="form-control textboxWidth" value="<?=$postid?>" readonly>
				</div>
			</div>

			<div class="space">
				<div class="col-sm-2">
					<label>Reason: *</label>
				</div>
				<div class="col-sm-10">	
				<div id="gsReason">
				<?php
						//select reason from table
						$sqlReason ="SELECT DISTINCT reasonType
										 FROM reportreason
										 ORDER BY reasonType";
					   
						//query sql statement
						$rsReason = mysqli_query($conn, $sqlReason)
						or die("SQL Error: ".mysqli_error($conn));
					   
						//iterate reason record
						while($row = mysqli_fetch_array($rsReason)){
							$reason				= 	$row["reasonType"];
									
							echo "<p class=\"form-control\">
							<input type='radio' class=\"gsReason\" name='reportType' value='$reason'/>$reason
							</p>";
						}
						  
						//remove result set
						mysqli_free_result($rsReason);
					?>
				</div>
				<p id="errorGSReason" style="color: red;"></p>
				</div>
			</div>	

			<div class="space row">
				<div class="col-sm-2">
					<label><span class="red">C</span>omment: </label>
				</div>
				<div class="col-sm-10">	
					<textarea name="comment" rows="5" cols="50" id="gsComment" placeholder="Comment" class="form-control" accesskey="c" style="resize: none;"></textarea>
					<p class="hint">(Comment needs to be less than 200 characters)</p>
					<p id="errorGSComment" style="color: red;"></p>
				</div>
			</div>
			
			<div class="space floatRight">
				<input type="reset" class="button" id="clearGSRep" value="Clear">
				<input type="submit" class="button" id="submitGSRep" value="Submit">
			</div>
			<br class="clearRight"/>
		</form> 

<?php
						}else{
							echo "<p>Sorry you have already reported this post</p>";
						}
					}else{
						echo "<p>Sorry you cannot report your own post</p>";
					}
				}else{
					echo "<p>Sorry you need to be in the group to report this post</p>";
				}
			} else {
				echo noexist("Post");
				echo "<a href=\"forum.php\"><p>Return to forum</p></a>";
				echo "<a href=\"index.php\"><p>Return to home</p></a>";
			}
		} else {
			echo wronglog("users");
		}
	} else {
		echo nolog();
	}
	

?>

</div>
</section>

<?php
	echo makeFooter();
?>