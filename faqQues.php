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
	
	//check the existence of topicid
	if (isset($_GET["topicid"])) {
		$topicid = $_GET["topicid"];//get topicid
	}
	else {
		header("Location: faq.php"); // redirect back if there is not topicid
	}	
	
	// number of faqs per page
	$results_per_page = 10;
	
	//get total number of faqs
	$sqlTotalFAQ = "SELECT *
					FROM faq
					WHERE faqTopicID='$topicid'
					ORDER BY faqID";

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
	
	//get topic name
	$sqlfaqName = "SELECT topicname
	FROM faqtopic
	WHERE topicID='$topicid'";

	//query the SQL statement
	$rsfaqName = mysqli_query($conn,$sqlfaqName)
	or die(mysqli_error($conn));
	
	$row = mysqli_fetch_row($rsfaqName)
			or die(mysqli_error($conn));
					
	//execute each field
	$topicname = $row[0];
					
	//select all records
	$sqlfaq = "SELECT *
	FROM faq
	WHERE faqTopicID='$topicid'
	ORDER BY faqID
	LIMIT ".$this_page_first_result.",".$results_per_page;

	//query the SQL statement
	$rsfaq = mysqli_query($conn,$sqlfaq)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Me - $topicname");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
  
  
<section class="box">
	<div class="container top-content">
<?php		
	echo "<h1><strong>$topicname</strong></h1>";
?>
<a href="faq.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>				
<?php
	
	if (mysqli_affected_rows($conn)>0) {
		echo "<div id=\"faqAcc\">";
				while($row = mysqli_fetch_assoc($rsfaq)){
					$id				= 	$row["faqID"];
					$question		= 	$row["faqQuestion"];
					$answer			=	$row["faqAnswer"];
					
					echo "<div>";
					echo "<h2>$question</h2>";
					echo "<div><p>$answer</p></div>";
					echo "</div>";
				}
		echo "</div>";	
		
		if ($number_of_pages > 1) {//show paging if there is more than 1 page
			echo "<ul class=\"pagination pagination-lg\">";
			for ($page=1;$page<=$number_of_pages;$page++){
				echo "<li><a href=\"faqQues.php?topicid=$topicid&page=$page\">$page</a></li>";
			}
			echo "</ul>";
		}
		
	} else {
		echo noexist("questions");
		echo "<a href=\"faq.php\"><p>Return to FAQ page</p></a>";
		echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
	}
?>

	</div>
</section>
 
 
<?php
	echo makeFooter();
  ?>
