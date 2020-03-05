<?php
ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
session_start();

include "database_conn.php"; //include database

if(isset($_SESSION['userID'])){
	//Provide front end validation if question already exist for adding FAQ
	if(isset($_POST["question"])){ 
		$question		=	filter_has_var(INPUT_POST, 'question') ? $_POST['question']: null;

		//sanitize data
		$question	    = filter_var($question,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$question 	    = filter_var($question,FILTER_SANITIZE_SPECIAL_CHARS);
		
		//remove space both before and after the data
		$question	=	trim($question);
			
		// check if question already exists		
			$sqlCheckQ = "SELECT faqID
							FROM faq
							WHERE faqQuestion='$question'";
									
			// query sql statement
			$rsCheckQ = mysqli_query($conn,$sqlCheckQ)
							or die(mysqli_error($conn));
				
				
			if (mysqli_affected_rows($conn)>0){ 
				echo "{\"statusFAQ\":\"error\",\"message\":[{\"textFAQ\":\"Sorry, the question already exist.\"}]}";
			} else{
				echo "{\"statusFAQ\":\"success\",\"message\":[{\"textFAQ\":\"Success.\"}]}";
			}
	}else {
		echo "{\"statusFAQ\":\"error\",\"message\":[{\"textFAQ\":\"Error.\"}]}";
	}
} else {
	echo nolog();
}
?>