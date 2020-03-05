<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	include "database_conn.php"; //connect to database
	
	if(isset($_SESSION['userID'])){
		//get username of user logged in
		$username = $_SESSION['username'];
		//get userID of user logged in
		$userID = $_SESSION['userID'];
		//get role of user when user is logged in
		$accountID = $_SESSION['role'];
	}
	
	echo makePageStart("Talk2Me - Post Blog");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
	
	//set timezone
	date_default_timezone_set("Asia/Kuala_Lumpur");
	// get current time
	$time = date("H:i:s");
	// get current date
	$date = date("Y-m-d");
					
	$blogID			=	filter_has_var(INPUT_POST, 'blogID') ? $_POST['blogID']: null;
	$title			=	filter_has_var(INPUT_POST, 'title') ? $_POST['title']: null;
	$content		=	filter_has_var(INPUT_POST, 'content') ? $_POST['content']: null;
	$category		=	filter_has_var(INPUT_POST, 'category') ? $_POST['category']: null;
	$catName		=	filter_has_var(INPUT_POST, 'catName') ? $_POST['catName']: null;
	
	//sanitize data
	$blogID	    	= filter_var($blogID,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$blogID 	    = filter_var($blogID,FILTER_SANITIZE_SPECIAL_CHARS);
	$title	    	= filter_var($title,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$title 	    	= filter_var($title,FILTER_SANITIZE_SPECIAL_CHARS);
	$content		= filter_var($content,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$content 		= filter_var($content,FILTER_SANITIZE_SPECIAL_CHARS);
	$category		= filter_var($category,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$category 		= filter_var($category,FILTER_SANITIZE_SPECIAL_CHARS);
	$catName		= filter_var($catName,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$catName 		= filter_var($catName,FILTER_SANITIZE_SPECIAL_CHARS);
	
	//remove space both before and after the data
	$blogID			=	trim($blogID);
	$title			=	trim($title);
	$content       	=	trim($content);
	$category		=	trim($category);
	$catName		=	trim($catName);
?>
  
  
<section class="box">
	<div class="container top-content">
		<div class="processDiv">
  <?php
  if(isset($_SESSION['userID'])){
		if ($accountID == "1") {	
			//array for errors
			$errorList = array();
			
			//validate title
			if (empty($title)) {
				$errorList[] = "<p>You have not entered the title.</p>";
			}else if (strlen($title) > 200) { 
				$errorList[] = "<p>Title should not be more than 200 character.</p>";
			}
			
			//validate content
			if (empty($content)) {
				$errorList[] = "<p>You have not entered the content.</p>";
			}else if (strlen($content) > 5000) { 
				$errorList[] = "<p>Content should not be more than 5000 character.</p>";
			} 
			//validate category
			if (empty($category)) { 
				$errorList[] = "You have not selected a category.";
			} else if ($category == "catOthers") { 
				if (empty($catName)) { 
					$errorList[] = "You have not entered a category name.";
				} else if (strlen($catName) > 200) { 
					$errorList[] = "Category name should not be more than 200 character.";
				} 
			} 
			
			//display errors from array 
			if (!empty($errorList)) {
				for ($a=0; $a < count($errorList); $a++) {
					echo "$errorList[$a]";
				}
			}
			else { 
				if ($category == "catOthers") { 
					// check if category already exists		
					$sqlCheckC = "SELECT blogCatID
									FROM blogcategory
									WHERE blogCatName='$catName'";
											
					// query sql statement
					$rsCheckC = mysqli_query($conn,$sqlCheckC)
									or die(mysqli_error($conn));
					
					if (mysqli_affected_rows($conn)===0){	
						//add category if it doesn't exist
						$sqlAddCat = "INSERT INTO blogcategory 
										SET blogCatName='$catName'";
												
						// query sql statement
						$rsAddCat = mysqli_query($conn,$sqlAddCat)
										or die(mysqli_error($conn));
					} 
					//udpate blog
					$sqlCreateBlog = "UPDATE blogpost 
									SET blogName='$title',
									blogPost='$content',
									editUserID='$userID',
									editBlogDate='$date',
									editBlogTime='$time',
									blogCatID=(SELECT blogCatID
											FROM blogcategory
											WHERE blogCatName='$catName')
									WHERE blogID='$blogID'";
				
					//query sql statement	
					mysqli_query($conn, $sqlCreateBlog)
					or die(mysqli_error($conn));

							
					if(mysqli_affected_rows($conn)>0){
						echo "<p>Blog successfully submitted.</p>";
					}
					else {
						echo "<p style=\"color: red\">Unable to submit blog!</p>";
					}
				}else {
					//update blog
					$sqlCreateBlog = "UPDATE blogpost 
									SET blogName='$title',
									blogPost='$content',
									editUserID='$userID',
									editBlogDate='$date',
									editBlogTime='$time',
									blogCatID=(SELECT blogCatID
											FROM blogcategory
											WHERE blogCatName='$category')
									WHERE blogID='$blogID'";
	
					//query sql statement	
					mysqli_query($conn, $sqlCreateBlog)
					or die(mysqli_error($conn));

							
					if(mysqli_affected_rows($conn)>0){
						echo "<p>Blog successfully submitted.</p>";
					}
					else {
						echo "<p style=\"color: red\">Unable to submit blog!</p>";
					}
				}
				
				//get report id of reports if blog has any
				$sqlGetRep = "SELECT reportID
				FROM reportblog 
				WHERE blogID=$blogID";

				//query the SQL statement
				$rsGetRep = mysqli_query($conn,$sqlGetRep)
				or die(mysqli_error($conn));
				
				while($row = mysqli_fetch_assoc($rsGetRep)){
					$reportid		= 	$row["reportID"];
					
					$sqlDeleteRS = "DELETE FROM reportblog 
								 WHERE blogID='$blogID'
								 AND reportID='$reportid'";

					$rsDeleteRS = mysqli_query($conn,$sqlDeleteRS)
					or die(mysqli_error($conn));

					$sqlDeleteR = "DELETE FROM report 
								 WHERE reportID='$reportid'";
									 
					$rsDeleteR = mysqli_query($conn,$sqlDeleteR)
					or die(mysqli_error($conn));
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