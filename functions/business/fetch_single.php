<?php
include('db.php');
include('function.php');
if(isset($_POST["user_id"]))
{
	$output = array();
	$statement = $connection->prepare(
		"SELECT * FROM business 
		WHERE id = '".$_POST["user_id"]."' 
		LIMIT 1"
	);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output["heading"] = $row["heading"];
		$output["subheading"] = $row["subheading"];
		$output["lob"] = $row["lob"];
	}
	echo json_encode($output);
}
?>