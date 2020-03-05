<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";
	
	//check the existence of reportid
	if (isset($_GET["reportid"])) {
		$reportid = $_GET["reportid"];//get reportid
	}
	else {
		header("Location: manageReportGS.php"); // redirect back if there is not reportid
	}
	
	if(isset($_SESSION['userID'])){
		//get username of user logged in
		$username = $_SESSION['username'];
		//get userID of user logged in
		$userID = $_SESSION['userID'];
		//get role of user when user is logged in
		$accountID = $_SESSION['role'];
	}

	//check if report exists
	$sqlRep = "SELECT *
	FROM report JOIN reportsupport ON (report.reportID=reportsupport.reportID)
	WHERE report.reportID=$reportid";

	//query the SQL statement
	$rsRep = mysqli_query($conn,$sqlRep)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Delete Group Support Post Report");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
	
?>
<section class="box">
	<div class="container top-content">
	<div class="container top-content">
	
<?php
	// check if user is logged in
	if (isset($_SESSION['userID'])){
		// check if user is an admin
		if ($accountID == "1") {
			echo "<h1><strong>Delete Group Support Post Report</strong></h1>";
			
			if (mysqli_affected_rows($conn)>0) {
				//delete report
				$sqlReportGS = "DELETE FROM reportsupport 
									  WHERE reportID=".$reportid;
									 
				//execute sql statement
				$rsReportGS = mysqli_query($conn,$sqlReportGS)
				or die(mysqli_error($conn));
				
				$sqlReport = "DELETE FROM report 
									  WHERE reportID=".$reportid;
									 
				//execute sql statement
				$rsReport = mysqli_query($conn,$sqlReport)
				or die(mysqli_error($conn));
				
				
				if(mysqli_affected_rows($conn)>0){
					echo "<p>Report successfully deleted</p>";
					header("Location: manageReportGS.php");
				}
				else {
					echo "<p style='color:red;'>Unable to delete report!</p>";
				}
				echo "<a href=\"manageReportGS.php\"><p>Return to manage group support reports</p></a>";
				echo "<a href=\"manageReport.php\"><p>Return to manage reports</p></a>";
				echo "<a href=\"admin.php\"><p>Return to admin page</p></a>";
			} else {
				echo noexist("group support post report");
				echo "<a href=\"manageReportGS.php\"><p>Return to manage group support reports</p></a>";
				echo "<a href=\"manageReport.php\"><p>Return to manage reports</p></a>";
				echo "<a href=\"admin.php\"><p>Return to admin page</p></a>";
			}
		} else {
			echo wronglog("Admins");
		}
	} else {
		echo nolog();
	}
	

?>

</div>
</div>
</section>

<?php
	echo makeFooter();
  ?>