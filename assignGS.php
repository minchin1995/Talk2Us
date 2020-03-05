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

	//check the existence of supportid
	if (isset($_GET["supportid"])) {
		$supportID = $_GET["supportid"];//get supportid
	}
	else {
		header("Location: manageApply.php"); // redirect back if there is not supportid
	}
	
	//select details 
	$sqlApply = "SELECT sSupportReason, username, sSupportUserID, sSupportID
	FROM submitsupport JOIN user ON (submitsupport.sSupportUserID=user.userID)
	WHERE sSupportID=$supportID";

	//query the SQL statement
	$rsApply = mysqli_query($conn,$sqlApply)
	or die(mysqli_error($conn));
					
	$row = mysqli_fetch_row($rsApply)
			or die(mysqli_error($conn));
				
	//execute each field
	$getReason 		= $row[0];
	$getUsername	= $row[1];
	$getUserID 		= $row[2];
	$getSID 		= $row[3];

	echo makePageStart("Talk2Us - Assign Group Support");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">
				
<?php
	
	if (isset($_SESSION['userID'])){// check if user is logged in
		if ($accountID == "1") { //check is user is admin
?>
<a href="manageApply.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
<?php		
			
			echo "<h1><strong>Assign group for $getUsername</strong></h1>";
?>
		<div class="formDiv"> 
			<div class="formInfo">
<?php	
			echo "<p>Reason: $getReason</p>";
?>		
				<p>* Mandatory fields</p>
			</div>
			
			<form method="post" action="assignGSProcess.php" id="assignGSForm">
				<div class="space row" style="visibility:hidden; position:absolute">
					<div class="col-sm-2">
						<label>User ID:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" name="userID" id="userID" class="form-control textboxWidth" value="<?=$getUserID?>" readonly>
					</div>
				</div>
				
				<div class="space row" style="visibility:hidden; position:absolute">
					<div class="col-sm-2">
						<label>Support ID:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" name="supportID" id="supportID" class="form-control textboxWidth" value="<?=$getSID?>" readonly>
					</div>
				</div>
				
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">T</span>opic: *</label>
					</div>
					<div class="col-sm-10">
					<?php
								//select topic name from table
								$sqlTop ="SELECT DISTINCT sTopicName
										  FROM supporttopic
										  ORDER BY sTopicName";
								   
								//query sql statement
								$rsTop = mysqli_query($conn, $sqlTop)
								or die("SQL Error: ".mysqli_error($conn));

								//create select item
								echo "<SELECT name =\"topic\"  class=\"form-control\" id =\"topic\" accesskey=\"t\">\n";
											
											
								echo "<option value=\"\" selected=\"selected\">Select a Topic</option>\n";
								   
								//iterate category record
								while($row1 = mysqli_fetch_array($rsTop)){
									//populate select item
									$top = $row1[0];
									echo "<option value =\"$top\">$top</option>\n";
								}
								echo "<option value =\"topOthers\">Others</option>\n";
								echo "</select>";
									  
								//remove result set
								mysqli_free_result($rsTop);
								?>
						<p id="errorTop" style="color: red;"></p>
					</div>
				</div>			
				
				<div class="space row" id="displayTop" style="display: none;">
					<div class="col-sm-2">
						<label><span class="red">T</span>opic Name: *</label>
					</div>
					<div class="col-sm-10">
						<textarea name="tName" rows="3" cols="50" id="tName" class="form-control textboxWidth" placeholder="Topic Name" accesskey="t" style="resize: none;"></textarea>
						<p class="hint">(Topic Name needs to be less than 200 characters)</p>
						<p id="errorTopicName" style="color: red;"></p>
					</div>
				</div>	
					
				<div class="space row" id="displayPost" style="display: none;">
					<div class="col-sm-2">
						<label><span class="red">P</span>ost: *</label>
					</div>
					<div class="col-sm-10">
						<textarea name="post" rows="6" cols="50" id="post" class="form-control" placeholder="Post" accesskey="p" style="resize: none;"></textarea>
						<p class="hint">(Post needs to be less than 2000 characters)</p>
						<p id="errorPost" style="color: red;"></p>
					</div>	
				</div>	
				
				<div class="space floatRight">
					<input type="reset" class="button" id="clearAssGS" value="Clear">
					<input type="submit" class="button" id="submitAssGS" value="Submit">
				</div>
				<br class="clearRight"/>
			</form> 
		</div>
<?php
		} else {
			echo wronglog("admins");
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