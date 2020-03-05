<?php
ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
session_start();

include "database_conn.php"; //include database

if(isset($_SESSION['userID'])){
	//Provide front end validation if category already exist for editing blog category
	if(isset($_POST["catName"])){ 
		$catName		=	filter_has_var(INPUT_POST, 'catName') ? $_POST['catName']: null;

		//sanitize data
		$catName	    = filter_var($catName,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$catName 	    = filter_var($catName,FILTER_SANITIZE_SPECIAL_CHARS);
		
		//remove space both before and after the data
		$catName	=	trim($catName);
			
		// check if category already exists		
		$sqlCheck = "SELECT blogCatID
					FROM blogcategory
					WHERE blogCatName='$catName'";
									
		// query sql statement
		$rsCheck = mysqli_query($conn,$sqlCheck)
						or die(mysqli_error($conn));
				
				
			if (mysqli_affected_rows($conn)>0){ 
				echo "{\"statusSubBlog\":\"error\",\"message\":[{\"textSubBlog\":\"Sorry category already exists.\"}]}";
			} else{
				echo "{\"statusSubBlog\":\"success\",\"message\":[{\"textSubBlog\":\"Success.\"}]}";
			}
	}else {
		echo "{\"statusSubBlog\":\"error\",\"message\":[{\"textSubBlog\":\"Error.\"}]}";
	}
} else {
	echo nolog();
}
?>