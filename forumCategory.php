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
	
	//check the existence of categoryID
	if (isset($_GET["categoryID"])) {
		$catID = $_GET["categoryID"];//get category id
	}
	else {
		header("Location: forum.php"); // redirect back to forum if ther eis not categoryID
	}
	
	// number of topics per page
	$results_per_page = 10;
	
	//get total number of topics
	$sqlTotalTop = "SELECT * 
					FROM forumTopic
					WHERE categoryID = $catID";

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
	
	//select category name for the category is being displayed
	$sqlForumCat = "SELECT categoryName
					FROM forumCategory
					WHERE categoryID = $catID";

	//execute sql statement
	$rsForumCat = mysqli_query($conn,$sqlForumCat)
	or die(mysqli_error($conn));
	
	$resultForumCat = mysqli_fetch_array($rsForumCat);

	$categoryName 		= $resultForumCat['categoryName']; //category name
	
	//select all topics of category
	$sqlForumTopic = "SELECT * 
					FROM forumTopic
					WHERE categoryID = $catID
					ORDER BY topicName
					LIMIT ".$this_page_first_result.",".$results_per_page;

	//execute sql statement
	$rsForumTopic = mysqli_query($conn,$sqlForumTopic)
	or die(mysqli_error($conn));

	echo makePageStart("ImaSuperFan - $categoryName");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">
<a href="forum.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>				
<?php	
	echo "<h1><strong>$categoryName</strong></h1>";
	
	if (mysqli_affected_rows($conn)>0) {
		//display all the categories in database
		while($row = mysqli_fetch_assoc($rsForumTopic)){
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
				echo "<li><a href=\"forumcategory.php?categoryID=$catID&page=$page\">$page</a></li>";
			}
			echo "</ul>";
		}
	} else {
		echo noexist("Topic");
		echo "<a href=\"forum.php\"><p>Return to forum</p></a>";
		echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
	}

?>
</div>
</section>

<?php
	echo makeFooter();
  ?>
