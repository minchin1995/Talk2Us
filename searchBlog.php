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
	$term			=	filter_has_var(INPUT_GET, 'searchBlog') ? $_GET['searchBlog']: null;
			
	//sanitize data
	$term	    = filter_var($term,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$term 	    = filter_var($term,FILTER_SANITIZE_SPECIAL_CHARS);
	        
	//remove space both before and after the data			
	$term = trim($term); 
	
	echo makePageStart("ImaSuperFan - Search Blog");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">
	<a href="blog.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>	
	<h1><strong>Search Blog Results</strong></h1>
<form method="get" action="searchBlog.php" id="searchBlogForm">
	<input type="text" id="searchBlog" name="searchBlog" placeholder="Search Blog">
	<input type="reset" class="buttonS" id="clearSearchBlog" value="Clear">
	<input type="submit" class="buttonS" id="submitSearchBlog" value="Search">
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
		echo "<a href=\"blog.php\"><p>Return to blog</p></a>";
		echo "<a href=\"index.php\"><p>Return to home</p></a>";
	}
	else { 
		// number of blogs per page
		$results_per_page = 10;
		
		//get total number of blogs
		$sqlTotalBlog = "SELECT *
						FROM blogpost
						WHERE blogName LIKE '%$term%'
						ORDER BY blogDate ASC, blogTime ASC";

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
		
		//select all blog that matches search term
		$sqlBlog = "SELECT * 
					FROM blogpost
					WHERE blogName LIKE '%$term%'
					ORDER BY blogDate ASC, blogTime ASC
					LIMIT ".$this_page_first_result.",".$results_per_page;

		//execute sql statement
		$rsBlog = mysqli_query($conn,$sqlBlog)
		or die(mysqli_error($conn));

		if (mysqli_affected_rows($conn)>0) {
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
						echo "<li><a href=\"searchBlog.php?searchBlog=$term&page=$page\">$page</a></li>";
					}
					echo "</ul>";
			}
		} else {
			echo noexist("blog posts");
			echo "<a href=\"blog.php\"><p>Return to blog</p></a>";
			echo "<a href=\"index.php\"><p>Return to home</p></a>";
		}
	}


?>
</div>
</section>

<?php
	echo makeFooter();
  ?>