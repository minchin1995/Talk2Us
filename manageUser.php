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
	$sqlUser = "SELECT username, usernameGen, userID, email, banned, verified
	FROM user
	WHERE accountID=2
	ORDER BY userID";

	//query the SQL statement
	$rsUser = mysqli_query($conn,$sqlUser)
	or die(mysqli_error($conn));

	echo makePageStart("Talk2Us - Manage User");  
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
	<h1><strong>Manage User</strong></h1>
<a href="admin.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>
<?php
			if (mysqli_affected_rows($conn)>0) {
		
?>			
	<table id="userTable">
		<thead>
			<tr>
				<th>ID</th>
				<th>UserName</th>
				<th>Generated username</th>
				<th>Email</th>
				<th>Verfied</th>
				<th>Status</th>
				<th>Ban/Unban</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
<?php
				while($row = mysqli_fetch_assoc($rsUser)){
					$id				= 	$row["userID"];
					$username		=	$row["username"];
					$usernameGen	=	$row["usernameGen"];
					$email        	=	$row["email"];
					$banned        	=	$row["banned"];
					$verified       =	$row["verified"];
					
					echo "<tr>";
					echo "<td>$id</td>";
					echo "<td>$username</td>";
					echo "<td>$usernameGen</td>";
					echo "<td>$email</td>";
					if ($verified == "1"){
						echo "<td>Verified</td>";
					}else{
						echo "<td>Unverified</td>";
					}
					if ($verified == "1"){
						if ($banned == "0"){
							echo "<td>ACTIVE</td>";
						}else{
							echo "<td>BANNED</td>";
						}
						if($banned == "0"){
							echo "<td><a onClick=\"javascript: return confirm(' Are you sure you want to BAN $username? ');\" href=\"banUser.php?userID=$id\">BAN</a></td>";
						}else{
							echo "<td><a onClick=\"javascript: return confirm(' Are you sure you want to UNBAN $username? ');\" href=\"unbanUser.php?userID=$id\">UNBAN</a></td>";
						}	
					} else{
						echo "<td></td>";
						echo "<td></td>";
					}
					echo "<td><a onClick=\"javascript: return confirm(' Are you sure you want to dlete $username? ');\" href=\"deleteUser.php?userID=$id\">DELETE</td>";
					echo "</tr>";
				}
				echo"</tbody>";
				echo"</table>";
				
			} else {
				echo noexist("users");
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

