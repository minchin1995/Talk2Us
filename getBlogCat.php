<?php
ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
session_start();

include "database_conn.php"; //include database

if(isset($_SESSION['userID'])){
	if(isset($_POST["blogID"])){ 		
		$blogID			=	filter_has_var(INPUT_POST, 'blogID') ? $_POST['blogID']: null;
		
		//sanitize data
		$blogID	    	= filter_var($blogID,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$blogID 	    = filter_var($blogID,FILTER_SANITIZE_SPECIAL_CHARS);
		
		//remove space both before and after the data
		$blogID			=	trim($blogID);
			
			// check if category is the same
			$sqlTopicCheck = "SELECT blogCatName
							 FROM blogpost JOIN blogcategory ON (blogpost.blogCatID=blogcategory.blogCatID)
							  WHERE blogID='$blogID'";
									
			// query sql statement
			$rsTopicCheck = mysqli_query($conn,$sqlTopicCheck)
						  or die(mysqli_error($conn));
			
			$row = mysqli_fetch_row($rsTopicCheck)
					or die(mysqli_error($conn));
		
			//execute each field
			$checkCat = $row[0];
				
				
			if (mysqli_affected_rows($conn)>0){ 
				echo "{\"result\":\"$checkCat\"}";
			} else{
				echo "{\"result\":\"error\"}";
			}
	}else {
		echo "{\"result\":\"error\"}";
	}
} else {
	echo nolog();
}
?>