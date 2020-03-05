<?php
ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
session_start();

include "database_conn.php"; //include database

if(isset($_SESSION['userID'])){
	if(isset($_POST["topicID"])){ 		
		$topicID			=	filter_has_var(INPUT_POST, 'topicID') ? $_POST['topicID']: null;
		
		//sanitize data
		$topicID	    	= filter_var($topicID,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$topicID 	    = filter_var($topicID,FILTER_SANITIZE_SPECIAL_CHARS);
		
		//remove space both before and after the data
		$topicID			=	trim($topicID);
			
			// check if category is the same
			$sqlCatCheck = "SELECT categoryName
							 FROM forumcategory JOIN forumtopic ON (forumcategory.categoryID=forumtopic.categoryID)
							  WHERE forumtopic.topicID='$topicID'";
									
			// query sql statement
			$rsCatCheck = mysqli_query($conn,$sqlCatCheck)
						  or die(mysqli_error($conn));
			
			$row = mysqli_fetch_row($rsCatCheck)
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