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
	
	//Select all blog that matches search term
	$sqlBlog = "SELECT *
				FROM blogpost
				WHERE blogName LIKE '%$term%'
				ORDER BY blogName";

	//execute sql statement
	$rsBlog = mysqli_query($conn,$sqlBlog)
				or die(mysqli_error($conn));

	$json = array();

	while($row = mysqli_fetch_array ($rsBlog))     
	{
		$blog = array(
			'blogID' => html_entity_decode($row['blogID'], ENT_QUOTES),
			'blogName' => html_entity_decode($row['blogName'], ENT_QUOTES)
		);
		array_push($json, $blog);
	}
	//return results in json
	$jsonstring = json_encode($json);
	echo $jsonstring;
}
?>