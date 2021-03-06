<?php
ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
session_start();

include "database_conn.php"; //include database

if(isset($_SESSION['userID'])){
	//Provide front end validation if blog name already exist for editing blog
	if(isset($_POST["title"])){ 
			$title			=	filter_has_var(INPUT_POST, 'title') ? $_POST['title']: null;
			
			//sanitize data
			$title	    	= filter_var($title,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			$title 	    	= filter_var($title,FILTER_SANITIZE_SPECIAL_CHARS);
			
			//remove space both before and after the data
			$title			=	trim($title);

			//check if blog is posted
			$sqlCheck = "SELECT blogID
						FROM blogpost
						WHERE blogName='$title'";
									
				// query sql statement
			$rsCheck = mysqli_query($conn,$sqlCheck)
						or die(mysqli_error($conn));
				
				
			if (mysqli_affected_rows($conn)>0){ 
				echo "{\"statusBlog\":\"error\",\"message\":[{\"textBlog\":\"Sorry blog is already posted.\"}]}";
			} else{
				echo "{\"statusBlog\":\"success\",\"message\":[{\"textBlog\":\"Success.\"}]}";
			}
	}else {
		echo "{\"statusBlog\":\"error\",\"message\":[{\"textBlog\":\"Error.\"}]}";
	}
} else {
	echo nolog();
}
?>