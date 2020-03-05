<?php
// include the file for the database connection
include("database_conn.php");

if(isset($_POST["term"])){ 
	$term			=	filter_has_var(INPUT_POST, 'term') ? $_POST['term']: null;
	
	//sanitize data
	$term	    = filter_var($term,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$term 	    = filter_var($term,FILTER_SANITIZE_SPECIAL_CHARS);
	        
	//remove space both before and after the data			
	$term = trim($term); 
	
	//Select all forum topic that matches search term
	$sqlDB = "SELECT *
				FROM forumtopic
				WHERE topicName LIKE '%$term%'
				ORDER BY topicName";

	//execute sql statement
	$rsDB = mysqli_query($conn,$sqlDB)
				or die(mysqli_error($conn));

	$json = array();

	while($row = mysqli_fetch_array ($rsDB))     
	{
		$DB = array(
			'topicID' => html_entity_decode($row['topicID'], ENT_QUOTES),
			'topicName' => html_entity_decode($row['topicName'], ENT_QUOTES)
		);
		array_push($json, $DB);
	}
	//return results in JSON
	$jsonstring = json_encode($json);
	echo $jsonstring;
}
?>