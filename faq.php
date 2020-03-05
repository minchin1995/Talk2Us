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
	
	// number of faqs per page
	$results_per_page = 10;
	
	//get total number of faqs
	$sqlTotalFAQ = "SELECT *
					FROM faqtopic
					ORDER BY topicID";

	//execute sql statement
	$rsTotalFAQ = mysqli_query($conn,$sqlTotalFAQ)
	or die(mysqli_error($conn));
	
	// total number of categories for FAQ
	$number_of_results = mysqli_num_rows($rsTotalFAQ);
	
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
	
	//select all records
	$sqlfaq = "SELECT *
	FROM faqtopic
	ORDER BY topicID
	LIMIT ".$this_page_first_result.",".$results_per_page;

	//query the SQL statement
	$rsfaq = mysqli_query($conn,$sqlfaq)
	or die(mysqli_error($conn));
	
	
	echo makePageStart("Talk2Me - FAQ");  
	echo makeNav("");
	echo makeToTop();
?>
  
  
<section class="box">
	<div class="container top-content">
		<h1><strong>FAQ</strong></h1>
		
		<p>Commonly asked questions about Talk2Us</p>
<?php
	if (mysqli_affected_rows($conn)>0) {
		while($row = mysqli_fetch_assoc($rsfaq)){
			$id				= 	$row["topicID"];
			$name			=	$row["topicname"];

			echo "<div class=\"row itemRow clearLeft clearRight\">";
			echo "<a href=\"faqQues.php?topicid=$id\"><p class=\"floatLeft\" >$name</p>";
			echo "<i class=\"fa fa-angle-double-right fa-1x floatRight\"></i></a>";
			echo "</div>";
		}
				
		if ($number_of_pages > 1) {//show paging if there is more than 1 page
			echo "<ul class=\"pagination pagination-lg clearLeft clearRight\">";
			for ($page=1;$page<=$number_of_pages;$page++){
				echo "<li><a href=\"faq.php?page=$page\">$page</a></li>";
			}
			echo "</ul>";
		}
	} else {
		echo noexist("FAQ categories");
	}
?>

	</div>
</section>
 
 
<?php
	echo makeFooter();
  ?>
