<?php
ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
session_start();

include "database_conn.php"; //include database

if(isset($_SESSION['userID'])){
	if(isset($_POST["faqID"])){ 		
		$faqID			=	filter_has_var(INPUT_POST, 'faqID') ? $_POST['faqID']: null;
		
		//sanitize data
		$faqID	    	= filter_var($faqID,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$faqID 	    = filter_var($faqID,FILTER_SANITIZE_SPECIAL_CHARS);
		
		//remove space both before and after the data
		$faqID			=	trim($faqID);
			
			// check if topic is the same
			$sqlTopicCheck = "SELECT topicname
							 FROM faq JOIN faqtopic ON (faqTopicID=topicID)
							  WHERE faqID='$faqID'";
									
			// query sql statement
			$rsTopicCheck = mysqli_query($conn,$sqlTopicCheck)
						  or die(mysqli_error($conn));
			
			$row = mysqli_fetch_row($rsTopicCheck)
					or die(mysqli_error($conn));
		
			//execute each field
			$checkTopic = $row[0];

			if (mysqli_affected_rows($conn)>0){ 
				echo "{\"result\":\"$checkTopic\"}";
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