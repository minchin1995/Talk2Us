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
	
	echo makePageStart("Talk2Me - Group Support");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">
	<h1>Group Support</h1>
<?php
	if(!isset($_SESSION['userID'])){
?>
	<p>
		Group support allows more privacy than forums that are allowed for public viewing. Login to apply.
	</p>
<?php
	}

	if(isset($_SESSION['userID'])){ //Check if suer is logged in
		if ($accountID == "1") { //if user is an admin
?>
<form method="get" action="searchGSAdmin.php" id="searchGSAdminForm">
	<input type="text" id="searchGSAdmin" name="searchGSAdmin" placeholder="Search Group Support Topics">
	<input type="button" class="buttonS" id="clearSearchGSAdmin" value="Clear">
	<input type="submit" class="buttonS" id="submitSearchGSAdmin" value="Search">
</form>
<?php
			// number of blogs per page
			$results_per_page = 10;
				
			//get total number of group support topics
			$sqlTotalGS = "SELECT *
							FROM supporttopic
							ORDER BY sTopicName";

			//execute sql statement
			$rsTotalGS = mysqli_query($conn,$sqlTotalGS)
			or die(mysqli_error($conn));
				
			// total number of group support topics
			$number_of_results = mysqli_num_rows($rsTotalGS);
				
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
				
			$sqlgetGS = "SELECT *
			FROM supporttopic
			ORDER BY sTopicName
			LIMIT ".$this_page_first_result.",".$results_per_page;

			//query the SQL statement
			$rsgetGS = mysqli_query($conn,$sqlgetGS)
			or die(mysqli_error($conn));
			
			if (mysqli_affected_rows($conn)>0){ 
				while($row = mysqli_fetch_assoc($rsgetGS)){
					$id				= 	$row["sTopicID"];
					$name			= 	$row["sTopicName"];
					
					echo "<div class=\"row itemRow clearLeft clearRight\">";
					echo "<a href=\"gsTopic.php?topicID=$id\"><p class=\"floatLeft\" >$name</p>";
					echo "<i class=\"fa fa-angle-double-right fa-1x floatRight\"></i></a>";
					echo "</div>";
				}
				
				if ($number_of_pages > 1) {//show paging if there is more than 1 page
					echo "<ul class=\"pagination pagination-lg clearLeft clearRight\">";
					for ($page=1;$page<=$number_of_pages;$page++){
						echo "<li><a href=\"groupSupport.php?page=$page\">$page</a></li>";
					}
					echo "</ul>";
				}
			}else{
				echo "<p>No group supports</p>";
			}
		}else{ //if user is a user
			// number of blogs per page
			$results_per_page = 10;
				
			//get total number of group support topics
			$sqlTotalGS = "SELECT *
			FROM supporttopic JOIN supportuser ON (supporttopic.sTopicID=supportuser.sTopicID)
			WHERE supportuser.userID=$userID";

			//execute sql statement
			$rsTotalGS = mysqli_query($conn,$sqlTotalGS)
			or die(mysqli_error($conn));
				
			// total number of group support topics
			$number_of_results = mysqli_num_rows($rsTotalGS);
				
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
		
		
			$sqlgetGS = "SELECT *
			FROM supporttopic JOIN supportuser ON (supporttopic.sTopicID=supportuser.sTopicID)
			WHERE supportuser.userID=$userID
			LIMIT ".$this_page_first_result.",".$results_per_page;

			//query the SQL statement
			$rsgetGS = mysqli_query($conn,$sqlgetGS)
			or die(mysqli_error($conn));
	?>
	<a href="applyGS.php" class="buttonLeft"><p>Apply</p></a>
<form method="get" action="searchGS.php" id="searchGSForm">
	<input type="text" id="searchGS" name="searchGS" placeholder="Search Group Support Topics">
	<input type="reset" class="buttonS" id="clearSearchGS" value="Clear">
	<input type="submit" class="buttonS" id="submitSearchGS" value="Search">
</form>
	<?php
			if (mysqli_affected_rows($conn)>0){ 
				while($row = mysqli_fetch_assoc($rsgetGS)){
					$id				= 	$row["sTopicID"];
					$name			= 	$row["sTopicName"];
					
					echo "<div class=\"row itemRow clearLeft clearRight\">";
					echo "<a href=\"gsTopic.php?topicID=$id\"><p class=\"floatLeft\" >$name</p>";
					echo "<i class=\"fa fa-angle-double-right fa-1x floatRight\"></i></a>";
					echo "</div>";
					
				}
				if ($number_of_pages > 1) {//show paging if there is more than 1 page
					echo "<ul class=\"pagination pagination-lg clearLeft clearRight\">";
					for ($page=1;$page<=$number_of_pages;$page++){
						echo "<li><a href=\"groupSupport.php?page=$page\">$page</a></li>";
					}
					echo "</ul>";
				}
			}else{
				echo "<p>No group supports</p>";
			}
		}
	} else{ //if user is not logged in
?>
<p>Register or login to start</p>
<?php
	}
?>
	</div>
</section>

<?php
	echo makeFooter();
?>