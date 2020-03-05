<?php
ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
session_start();
	
include "database_conn.php"; //include database

if(isset($_SESSION['userID'])){
	//Provide front end validation if blog name is already posted for posting submitted blog
	if((isset($_POST["title"]))&&(isset($_POST["content"]))){ 
		   //get data from submit blog form
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
			
			//check if blog is posted
			$sqlCheck = "SELECT blogID
						FROM blogpost
						WHERE blogName='$title'";
									
			// query sql statement
			$rsCheck = mysqli_query($conn,$sqlCheck)
						or die(mysqli_error($conn));
				
				
			if (mysqli_affected_rows($conn)>0){ 
				echo "{\"statusSubBlog\":\"error\",\"message\":[{\"textSubBlog\":\"Sorry blog is already posted.\"}]}";
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