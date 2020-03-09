<?php
include('db.php');
include('function.php');
if(isset($_POST["user_id"]))
{
	$output = array();
	$statement = $connection->prepare(
		"SELECT * FROM py_sales 
		WHERE id = '".$_POST["user_id"]."' 
		LIMIT 1"
	);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output["name"] = $row["NAME"];
		$output["guid"] = $row["CUST_GUID"];
		$output["master"] = $row["MAST_CUST_ID"];
		$output["system"] = $row["SYSTEM"];
	}
	echo json_encode($output);
}
?>