<?php
ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
session_start();
	
include "database_conn.php"; //include database

if(isset($_SESSION['userID'])){
	//Provide front end validation if blog already exist for submititng blog
	if((isset($_POST["title"]))&&(isset($_POST["content"]))){ 
			$title			=	filter_has_var(INPUT_POST, 'title') ? $_POST['title']: null;
			$content		=	filter_has_var(INPUT_POST, 'content') ? $_POST['content']: null;
			
			//sanitize data
			$title	    	= filter_var($title,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			$title 	    	= filter_var($title,FILTER_SANITIZE_SPECIAL_CHARS);
			$content		= filter_var($content,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			$content 		= filter_var($content,FILTER_SANITIZE_SPECIAL_CHARS);
			
			//remove space both before and after the data
			$title			=	trim($title);
			$content       =	trim($content);
			
			//check if blog is submitted
			$sqlCheck = "SELECT sBlogID
						FROM submitblogpost
						WHERE sBlogName='$title'";
									
				// query sql statement
			$rsCheck = mysqli_query($conn,$sqlCheck)
						or die(mysqli_error($conn));
				
				
			if (mysqli_affected_rows($conn)>0){ 
				echo "{\"statusSubBlog\":\"error\",\"message\":[{\"textSubBlog\":\"Sorry blog is already submitted.\"}]}";
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