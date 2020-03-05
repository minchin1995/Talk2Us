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

	//select all records
	$sqlAdmin = "SELECT username, userID, email 
	FROM user
	WHERE accountID=1
	ORDER BY userID";

	//query the SQL statement
	$rsAdmin = mysqli_query($conn,$sqlAdmin)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Manage All Admins");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
	
?>
<section class="box">
	<div class="container top-content">
	
<?php
	// check if user is logged in
	if (isset($_SESSION['userID'])){
		// check if user is an admin
		if ($accountID == "1") {
?>
<a href="manageAdmin.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>	
	<h1><strong>Manage All Admins</strong></h1>
<?php
			if (mysqli_affected_rows($conn)>0) { //if there are any admins
		
?>			
	<table id="adminTable">
		<thead>
			<tr>
				<th>ID</th>
				<th>UserName</th>
				<th>Email</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
<?php
				while($row = mysqli_fetch_assoc($rsAdmin)){
					$id				= 	$row["userID"];
					$username		=	$row["username"];
					$email        	=	$row["email"];
					
					echo "<tr>";
					echo "<td>$id</td>";
					echo "<td>$username</td>";
					echo "<td>$email</td>";
					if ($id != $userID){
						echo "<td><a onClick=\"javascript: return confirm(' Are you sure you want to delete $username? ');\" href=\"deleteAdmin.php?userID=$id\">DELETE</a></td>";
					}else{
						echo "<td></td>";
					}
										
					echo "</tr>";
				}
				echo"</tbody>";
				echo"</table>";
			} else {
				echo noexist("Admins");
				echo "<a href=\"manageAdmin.php\"><p>Return to manage admins</p></a>";
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
</section>

<?php
	echo makeFooter();
  ?>