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
	$term			=	filter_has_var(INPUT_GET, 'searchDB') ? $_GET['searchDB']: null;
			
	//sanitize data
	$term	    = filter_var($term,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$term 	    = filter_var($term,FILTER_SANITIZE_SPECIAL_CHARS);
	        
	//remove space both before and after the data			
	$term = trim($term); 
	
	echo makePageStart("ImaSuperFan - Search Forum");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">
<a href="forum.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>	
	<h1><strong>Search Forum Results</strong></h1>
<form method="get" action="searchForum.php" id="searchForumForm">
	<input type="text" id="searchDB" name="searchDB" placeholder="Search Forum Topics">
	<input type="reset" class="buttonS" id="clearSearchDB" value="Clear">
	<input type="submit" class="buttonS" id="submitSearchDB" value="Search">
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
	}
	else { 
		// number of topics per page
		$results_per_page = 10;
		
		//get total number of topics
		$sqlTotalTop = "SELECT * 
					FROM forumTopic
					WHERE topicName LIKE '%$term%'";

		//execute sql statement
		$rsTotalTop = mysqli_query($conn,$sqlTotalTop)
		or die(mysqli_error($conn));
		
		// total number of topics for this category
		$number_of_results = mysqli_num_rows($rsTotalTop);
		
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
		
		//select all forum topic that matches search term
		$sqlForum = "SELECT * 
					FROM forumTopic
					WHERE topicName LIKE '%$term%'
					ORDER BY topicName
					LIMIT ".$this_page_first_result.",".$results_per_page;

		//execute sql statement
		$rsForum = mysqli_query($conn,$sqlForum)
		or die(mysqli_error($conn));

		if (mysqli_affected_rows($conn)>0) {
			while($row = mysqli_fetch_assoc($rsForum)){
				$id				= 	$row["topicID"];
				$name           =   $row["topicName"];
			
				echo "<div class=\"row itemRow clearLeft clearRight\">";
				echo "<a href=\"forumTopic.php?topicID=$id\"><p class=\"floatLeft\" >$name</p>";
				echo "<i class=\"fa fa-angle-double-right fa-1x floatRight\"></i></a>";
			
				echo "</div>";
				
			}
			
			if ($number_of_pages > 1) {//show paging if there is more than 1 page
					echo "<ul class=\"pagination pagination-lg clearLeft clearRight\">";
					for ($page=1;$page<=$number_of_pages;$page++){
						echo "<li><a href=\"searchForum.php?searchDB=$term&page=$page\">$page</a></li>";
					}
					echo "</ul>";
			}
		} else {
			echo noexist("forum topics");
			echo "<a href=\"forum.php\"><p>Return to forum</p></a>";
			echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
		}
	}


?>
</div>
</section>

<?php
	echo makeFooter();
  ?>