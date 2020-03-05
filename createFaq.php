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

	echo makePageStart("Talk2Us - Add FAQ");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">

<?php
	// check if user is logged in
	if (isset($_SESSION['userID'])){
		// check if user is an admin
		if ($accountID == "1") { 
?>		
<a href="manageFAQ.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
	<h1><strong>Add FAQ</strong></h1>
	
	<div class="formDiv"> 
		<div class="formInfo">
			<p>* Mandatory fields</p>
		</div>
		
		<form method="post" action="createFaqProcess.php" id="faqForm">
			<div class="space row">
				<div class="col-sm-2">
					<label><span class="red">Q</span>uestion: *</label>
				</div>
				<div class="col-sm-10">
					<textarea name="question" rows="3" cols="50" id="question" placeholder="Question" class="form-control" accesskey="q"></textarea>
					<p class="hint">(Question needs to be less than 200 characters)</p>
					<p id="errorQFAQ" style="color: red;"></p>
				</div>
			</div>	
				
			<div class="space row">
				<div class="col-sm-2">
					<label><span class="red">A</span>nswer: *</label>
				</div>
				<div class="col-sm-10">
					<textarea name="answer" rows="6" id="answer" placeholder="Answer" accesskey="a" class="form-control"></textarea>
					<p class="hint">(Answer needs to be less than 2000 characters)</p>
					<p id="errorAFAQ" style="color: red;"></p>
				</div>
			</div>	
			
			
			<div class="space row">
				<div class="col-sm-2">
					<label><span class="red">T</span>opic: *</label>
				</div>
				<div class="col-sm-10">
				<?php
							//select category name from table
							$sqlTop ="SELECT DISTINCT topicname
									  FROM faqtopic
									  ORDER BY topicname";
							   
							//query sql statement
							$rsTop = mysqli_query($conn, $sqlTop)
							or die("SQL Error: ".mysqli_error($conn));

							//create select item
							echo "<SELECT name =\"topic\" class=\"form-control\" id =\"topic\" accesskey=\"t\">\n";
										
										
							echo "<option value=\"\" selected=\"selected\">Select a Topic</option>\n";
							   
							//iterate category record
							while($row = mysqli_fetch_array($rsTop)){
								//populate select item
								$top = $row[0];
								echo "<option value =\"$top\">$top</option>\n";
							}
							echo "<option value =\"topicOthers\">Others</option>\n";
							echo "</select>";
								  
							//remove result set
							mysqli_free_result($rsTop);
							?>
				<p id="errorTFAQ" style="color: red;"></p>
				</div>
			</div>	

			<div class="space row" id="displayTopic" style="display: none;">
				<div class="col-sm-2">
					<label>T<span class="red">o</span>pic Name: *</label>
				</div>
				<div class="col-sm-10">
					<input type="text" name="topicName" id="topicName" class="form-control textboxWidth" placeholder="Topic Name" accesskey="o">
					<p class="hint">(Topic Name needs to be less than 200 characters)</p>
					<p id="errorTNameFAQ" style="color: red;"></p>
				</div>
			</div>
				
			<div class="space floatRight ">
				<input type="reset"  class="button" id="clearFAQ" value="Clear">
				<input type="submit"  class="button" id="submitFAQ" value="Submit">
			</div>
			<br class="clearRight"/>
		</form> 
	</div>
<?php
		} else {
			echo wronglog("Admins");
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