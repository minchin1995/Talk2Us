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

	echo makePageStart("Talk2Me - Edit Blog Category");   
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
	
	$catName		=	filter_has_var(INPUT_POST, 'catName') ? $_POST['catName']: null;
	$catID		=	filter_has_var(INPUT_POST, 'catID') ? $_POST['catID']: null;

	//sanitize data
	$catName	    = filter_var($catName,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$catName 	    = filter_var($catName,FILTER_SANITIZE_SPECIAL_CHARS);
	$catID	    = filter_var($catID,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$catID 	    = filter_var($catID,FILTER_SANITIZE_SPECIAL_CHARS);
	
	//remove space both before and after the data
	$catName	=	trim($catName);
	$catID		=	trim($catID);

?>
<section class="box">
	<div class="container top-content">
		<div class="processDiv">
<?php
	if(isset($_SESSION['userID'])){
		if ($accountID == "1") {
			$errorList = array();
			
			// check if topic already exists		
			$sqlCheck = "SELECT blogCatID
							FROM blogcategory
							WHERE blogCatName='$catName'";
									
			// query sql statement
			$rsCheck = mysqli_query($conn,$sqlCheck)
							or die(mysqli_error($conn));
			//validate category
			if (empty($catName)) { 
				$errorList[] = "You have not entered a category name.";
			} else if (strlen($catName) > 200) { 
				$errorList[] = "Category name should not be more than 200 character.";
			} else if (mysqli_affected_rows($conn)>0){ 
				$errorList[] = "Sorry, the category already exist.";
			} 
			
			//display error messages
			if (!empty($errorList)) {
				for ($a=0; $a < count($errorList); $a++) {
					echo "$errorList[$a] <br />\n";
				}
				echo "<p>Please try again.</p>\n";
			}
			else {
				//update blog category
				$sqlEditBlogCat = "UPDATE blogcategory
								SET blogCatName='$catName'
								WHERE blogCatID='$catID'";
												
				// query sql statement
				$rsEditBlogCat = mysqli_query($conn,$sqlEditBlogCat)
								or die(mysqli_error($conn));

				if(mysqli_affected_rows($conn)>0){
					echo "<p>Blog category successfully edited.</p>";
				} else {
					echo "<p style='color:red;'>Unable to edit blog category!</p>";
				}
				
			}
			echo "<a href=\"managePosted.php\"><p>Return to manage posted blogs</p></a>";
			echo "<a href=\"manageBlog.php\"><p>Return to manage blogs</p></a>";
			echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
		}else{
			echo wronglog ("admins");
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