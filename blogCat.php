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

	//check the existence of catid
	if (isset($_GET["catid"])) {
		$catid = $_GET["catid"];//get catid
	}
	else {
		header("Location: blog.php");
	}
	
	// number of blogs per page
	$results_per_page = 10;
	
	//get total number of blogs
	$sqlTotalBlog = "SELECT * 
				FROM blogpost JOIN blogcategory ON (blogpost.blogCatID=blogcategory.blogCatID)
				WHERE blogpost.blogCatID = $catid";

	//execute sql statement
	$rsTotalBlog = mysqli_query($conn,$sqlTotalBlog)
	or die(mysqli_error($conn));
	
	// total number of topics for this category
	$number_of_results = mysqli_num_rows($rsTotalBlog);
	
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

	$sqlBlog = "SELECT * 
				FROM blogpost JOIN blogcategory ON (blogpost.blogCatID=blogcategory.blogCatID)
				WHERE blogpost.blogCatID = $catid
				ORDER BY blogDate DESC, blogTime DESC
				LIMIT ".$this_page_first_result.",".$results_per_page;

	//execute sql statement
	$rsBlog = mysqli_query($conn,$sqlBlog)
	or die(mysqli_error($conn));
	
	echo makePageStart("ImaSuperFan - Blog category");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">
<a onclick="history.go(-1);" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>	
<?php	
	if (mysqli_affected_rows($conn)>0){ 
		//get category name
		$sqlCat = "SELECT blogCatName 
				FROM blogpost JOIN blogcategory ON (blogpost.blogCatID=blogcategory.blogCatID)
				WHERE blogpost.blogCatID = $catid";

		//execute sql statement
		$rsCat = mysqli_query($conn,$sqlCat)
		or die(mysqli_error($conn));

		$rows = mysqli_fetch_row($rsCat)
				or die(mysqli_error($conn));
    
		//execute each field
		$categoryName = $rows[0];
	
		echo "<p>Category: $categoryName</p>";
			
		//display all the this topic in database
		while($row = mysqli_fetch_assoc($rsBlog)){
			$id				= 	$row["blogID"];
			$name           =   $row["blogName"];
			$blogCatID      =   $row["blogCatID"];

			echo "<div class=\"row itemRow clearLeft clearRight\">";
			echo "<a href=\"blogPost.php?blogid=$id\"><p class=\"floatLeft\" >$name</p>";
			echo "<i class=\"fa fa-angle-double-right fa-1x floatRight\"></i></a>";
			echo "</div>";
		}
		
		if ($number_of_pages > 1) {//show paging if there is more than 1 page
			echo "<ul class=\"pagination pagination-lg clearLeft clearRight\">";
			for ($page=1;$page<=$number_of_pages;$page++){
				echo "<li><a href=\"blogCat.php?catid=$catid&page=$page\">$page</a></li>";
			}
			echo "</ul>";
		}
	} else {
		echo noexist("blog category");
		echo "<a href=\"blog.php\"><p>Return to blog page</p></a>";
		echo "<a href=\"index.php\"><p>Return to home page</p></a>";
	}
?>
</div>
</section>

<?php

	echo makeFooter();
  ?>