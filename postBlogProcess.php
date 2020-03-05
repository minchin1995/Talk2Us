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
					
	$title			=	filter_has_var(INPUT_POST, 'title') ? $_POST['title']: null;
	$content		=	filter_has_var(INPUT_POST, 'content') ? $_POST['content']: null;
	$category	=	filter_has_var(INPUT_POST, 'category') ? $_POST['category']: null;
	$catName	=	filter_has_var(INPUT_POST, 'catName') ? $_POST['catName']: null;
	
	//sanitize data
	$title	    	= filter_var($title,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$title 	    	= filter_var($title,FILTER_SANITIZE_SPECIAL_CHARS);
	$content		= filter_var($content,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$content 		= filter_var($content,FILTER_SANITIZE_SPECIAL_CHARS);
	$category	= filter_var($category,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$category 	= filter_var($category,FILTER_SANITIZE_SPECIAL_CHARS);
	$catName	= filter_var($catName,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$catName 	= filter_var($catName,FILTER_SANITIZE_SPECIAL_CHARS);
	
	//remove space both before and after the data
	$title			=	trim($title);
	$content       =	trim($content);
	$category	=	trim($category);
	$catName	=	trim($catName);
?>
  
  
<section class="box">
	<div class="container top-content">
		<div class="processDiv">
  <?php
  if(isset($_SESSION['userID'])){
		if ($accountID == "1") {	

			//array for errors
			$errorList = array();
			
			//check if blog is submitted
			$sqlCheck = "SELECT blogID
						FROM blogpost
						WHERE blogName='$title'";
								
			// query sql statement
			$rsCheck = mysqli_query($conn,$sqlCheck)
						or die(mysqli_error($conn));
			
			//validate title
			if (empty($title)) {
				$errorList[] = "<p>You have not entered the title.</p>";
			}else if (strlen($title) > 200) { 
				$errorList[] = "<p>Title should not be more than 200 character.</p>";
			}else if (mysqli_affected_rows($conn)>0){ 
				$errorList[] = "<p>Sorry blog is already submitted.</p>";
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
						$sqlAddCat = "INSERT INTO blogcategory 
										SET blogCatName='$catName'";
												
						// query sql statement
						$rsAddCat = mysqli_query($conn,$sqlAddCat)
										or die(mysqli_error($conn));
					} 

					$sqlCreateBlog = "INSERT INTO blogpost 
						 SET blogName='$title',
						 blogPost='$content',
						 blogUserID='$userID',
						 blogDate='$date',
						 blogTime='$time',
						 blogCatID=(SELECT blogCatID
								FROM blogcategory
								WHERE blogCatName='$catName')";
	
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
					$sqlCreateBlog = "INSERT INTO blogpost 
						 SET blogName='$title',
						 blogPost='$content',
						 blogUserID='$userID',
						 blogDate='$date',
						 blogTime='$time',
						 blogCatID=(SELECT blogCatID
								FROM blogcategory
								WHERE blogCatName='$category')";
	
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
				
				echo "<a href=\"manageBlog.php\"><p>Return to manage blogs</p></a>";
				echo "<a href=\"admin.php\"><p>Return to admin page</p></a>";
			}
        }else{
			echo wronglog ("users");
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