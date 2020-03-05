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
		header("Location: blog.php");
	}
	
	if(isset($_SESSION['userID'])){
		//get username of user logged in
		$username = $_SESSION['username'];
		//get userID of user logged in
		$userID = $_SESSION['userID'];
		//get role of user when user is logged in
		$accountID = $_SESSION['role'];
	}

	//check if category exists
	$sqlCheck = "SELECT blogName, blogPost
	FROM blogpost
	WHERE blogID=$postid";

	//query the SQL statement
	$rsCheck = mysqli_query($conn,$sqlCheck)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Report Post");  
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
				//check if user has reported blog
				$sqlCheckReport = "SELECT report.reportID
								FROM report JOIN reportblog ON (report.reportID=reportblog.reportID) 
								WHERE blogID = '$postid'
								AND userID = '$userID'";

				//execute sql statement
				$rsCheckReport = mysqli_query($conn,$sqlCheckReport)
				or die(mysqli_error($conn));
				
				if (mysqli_affected_rows($conn)==0){
					$row = mysqli_fetch_row($rsCheck)
					or die(mysqli_error($conn));
		
					//execute each field
					$name = $row[0];
					$post = $row[1];
?>
		<h1><strong>Report Post (Blog)</strong></h1>
		
		<div class="formDiv"> 
		
			<div class="formInfo">
			<p>* Mandatory fields</p>
<?php
				echo "<p>$name</p>";
				echo "<p>$post</p>";
?>
			</div>
			
			<form method="post" action="reportBlogProcess.php" id="reportBlogForm">
			
				<div class="space row" style="visibility:hidden; position:absolute">
					<div class="col-sm-2">
						<label>Post ID:</label>
					</div>
					<div class="col-sm-10">	
						<input type="text" name="postid" id="postid" class="form-control textboxWidth" value="<?=$postid?>" readonly>
					</div>
				</div>

				<div class="space row">
					<div class="col-sm-2">
						<label>Reason: *</label>
					</div>
					<div class="col-sm-10">	
					<div id="blogReason">
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
								<input type='radio' class=\"blogReason\" name='reportType' value='$reason'/>$reason
								</p>";
							}
							  
							//remove result set
							mysqli_free_result($rsReason);
						?>
						</div>
						<p id="errorBlogReason" style="color: red;"></p>
					</div>
				</div>	

				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">C</span>omment:</label>
					</div>
					<div class="col-sm-10">	
						<textarea name="comment" rows="5" id="blogComment" class="form-control textboxWidth" placeholder="Comment" accesskey="c" style="resize: none;"></textarea>
						<p class="hint">(Comment needs to be less than 200 characters)</p>
						<p id="errorBlogComment" style="color: red;"></p>
					</div>
				</div>
				
				<div class="space floatRight">
					<input type="reset" class="button" id="clearBlogRep" value="Clear">
					<input type="submit" class="button" id="submitBlogRep" value="Submit">
				</div>
				<br class="clearRight"/>
			</form> 

<?php			
				}else{
					echo alreadyReport("Blog");
					echo "<a href=\"blog.php\"><p>Return to blog</p></a>";
					echo "<a href=\"index.php\"><p>Return to home</p></a>";
				}
			} else {
				echo noexist("Post");
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