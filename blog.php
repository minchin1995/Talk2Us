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

	echo makePageStart("ImaSuperFan - Blog");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">
	<h1><strong>Blog</strong></h1>

<?php
	if(isset($_SESSION['userID'])){
		if ($accountID == "2") {
?>
		<a href="submitBlog.php" class="buttonLeft"><p>Submit</p></a>
<?php
		}else{
?>
		<a href="postBlog.php" class="buttonLeft"><p>Post</p></a>
<?php			
		}
	}else {
?>
		<p>Login to submit a blog</p>
<?php
	}
	
	// number of blogs per page
	$results_per_page = 10;
	
	//get total number of blogs
	$sqlTotalBlog = "SELECT * 
					FROM blogpost
					ORDER BY blogDate DESC, blogTime DESC";

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
	
	//select all categories of topics for discussion board
	$sqlBlog = "SELECT * 
					FROM blogpost
					ORDER BY blogDate ASC, blogTime ASC
					LIMIT ".$this_page_first_result.",".$results_per_page;

	//execute sql statement
	$rsBlog = mysqli_query($conn,$sqlBlog)
	or die(mysqli_error($conn));
?>
<form method="get" action="searchBlog.php" id="searchBlogForm">
	<input type="text" id="searchBlog" name="searchBlog" placeholder="Search Blog">
	<input type="reset" class="buttonS" id="clearSearchBlog" value="Clear">
	<input type="submit" class="buttonS" id="submitSearchBlog" value="Search">
</form>
<?php
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
					echo "<li><a href=\"blog.php?page=$page\">$page</a></li>";
				}
				echo "</ul>";
		}
	} else {
		echo noexist("blog posts");
	}



?>

</div>
</section>

<?php
	echo makeFooter();
  ?>