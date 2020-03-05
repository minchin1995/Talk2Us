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
	
	// number of forum category per page
	$results_per_page = 10;
	
	//get total number of forum category
	$sqlTotalCat = "SELECT * 
					FROM forumcategory
					ORDER BY categoryName";

	//execute sql statement
	$rsTotalCat = mysqli_query($conn,$sqlTotalCat)
	or die(mysqli_error($conn));
	
	// total number of forum category
	$number_of_results = mysqli_num_rows($rsTotalCat);
	
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
	
	//select all categories of topics for discussion board
	$sqlForumCat = "SELECT * 
					FROM forumcategory
					ORDER BY categoryName
					LIMIT ".$this_page_first_result.",".$results_per_page;
	
	//execute sql statement
	$rsForumCat = mysqli_query($conn,$sqlForumCat)
	or die(mysqli_error($conn));

	echo makePageStart("ImaSuperFan - Forum");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">
	<h1><strong>Forum</strong></h1>
<?php
	if(isset($_SESSION['userID'])){ //if user is logged in
?>	
	<a href="createDBTopic.php" class="buttonLeft"><p>Create Topic</p></a>
<?php
	}
?>
<form method="get" action="searchForum.php" id="searchForumForm">
	<input type="text" id="searchDB" name="searchDB" placeholder="Search Forum Topics">
	<input type="reset" class="buttonS" id="clearSearchDB" value="Clear">
	<input type="submit" class="buttonS" id="submitSearchDB" value="Search">
</form>
<?php
	if (mysqli_affected_rows($conn)>0) {
	//display all the categories in database
		while($row = mysqli_fetch_assoc($rsForumCat)){
			$id				= 	$row["categoryID"];
			$name           =   $row["categoryName"];
			
			echo "<div class=\"row itemRow clearLeft clearRight\">";
			echo "<a href=\"forumCategory.php?categoryID=$id\"><p class=\"floatLeft\" >$name</p>";
			echo "<i class=\"fa fa-angle-double-right fa-1x floatRight\"></i></a>";
			
			echo "</div>";
		}
		
		if ($number_of_pages > 1) {//show paging if there is more than 1 page
				echo "<ul class=\"pagination pagination-lg clearLeft clearRight\">";
				for ($page=1;$page<=$number_of_pages;$page++){
					echo "<li><a href=\"forum.php?page=$page\">$page</a></li>";
				}
				echo "</ul>";
		}
	} else {
		echo noexist("Category");
	}

?>
</div>
</section>

<?php
	echo makeFooter();
  ?>

