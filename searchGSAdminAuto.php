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
	
	//Select all support topic name that matches search term for admins
	$sqlGS = "SELECT *
				FROM supporttopic
				WHERE sTopicName LIKE '%$term%'
				ORDER BY sTopicName";

	//execute sql statement
	$rsGS = mysqli_query($conn,$sqlGS)
				or die(mysqli_error($conn));

	$json = array();

	while($row = mysqli_fetch_array ($rsGS))     
	{
		$GS = array(
			'sTopicID' => html_entity_decode($row['sTopicID'], ENT_QUOTES),
			'sTopicName' => html_entity_decode($row['sTopicName'], ENT_QUOTES)
		);
		array_push($json, $GS);
	}
	//return result in json
	$jsonstring = json_encode($json);
	echo $jsonstring;
}
?>