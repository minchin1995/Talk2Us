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

	//obtain data entered by users
	$term			=	filter_has_var(INPUT_GET, 'searchGS') ? $_GET['searchGS']: null;
			
	//sanitize data
	$term	    = filter_var($term,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$term 	    = filter_var($term,FILTER_SANITIZE_SPECIAL_CHARS);
	        
	//remove space both before and after the data			
	$term = trim($term); 
	
	echo makePageStart("ImaSuperFan - Search Group Support");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">
	<a href="groupSupport.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>	
	<h1><strong>Search Group Support Results</strong></h1>

<?php
	// check if user is logged in
	if (isset($_SESSION['userID'])){
		if ($accountID == "2") {
?>
<form method="get" action="searchGS.php" id="searchGSForm">
	<input type="text" id="searchGS" name="searchGS" placeholder="Search Group Support Topics">
	<input type="reset" class="buttonS" id="clearSearchGS" value="Clear">
	<input type="submit" class="buttonS" id="submitSearchGS" value="Search">
</form>
<?php
			echo "<h2>Results for: $term</h2>";

			//array for errors
			$errorList = array();

			if (empty($term)) {
				$errorList[] = "<p>You have not entered any term.</p>";
			}
			
			//display errors from array 
			if (!empty($errorList)) {
				for ($a=0; $a < count($errorList); $a++) {
					echo "$errorList[$a]";
				}
				echo "<a href=\"groupSupport.php\"><p>Return to group support</p></a>";
				echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
			}
			else { 
				// number of blogs per page
				$results_per_page = 10;
				
				//get total number of group support topics
				$sqlTotalGS = "SELECT *
								FROM supporttopic JOIN supportuser ON (supporttopic.sTopicID=supportuser.sTopicID)
								WHERE sTopicName LIKE '%$term%'
								AND userID = '$userID'
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
				
				//select all topic name that matches search term
				$sqlGS = "SELECT * 
							FROM supporttopic JOIN supportuser ON (supporttopic.sTopicID=supportuser.sTopicID)
							WHERE sTopicName LIKE '%$term%'
							AND userID = '$userID'
							ORDER BY sTopicName
							LIMIT ".$this_page_first_result.",".$results_per_page;

				//execute sql statement
				$rsGS = mysqli_query($conn,$sqlGS)
				or die(mysqli_error($conn));

				if (mysqli_affected_rows($conn)>0) {
					while($row = mysqli_fetch_assoc($rsGS)){
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
								echo "<li><a href=\"searchGS.php?searchGS=$term&page=$page\">$page</a></li>";
							}
							echo "</ul>";
					}
				} else {
					echo noexist("group support topics");
					echo "<a href=\"groupSupport.php\"><p>Return to group support</p></a>";
					echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
				}
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