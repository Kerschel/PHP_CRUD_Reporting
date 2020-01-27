<?php
include('db.php');
include('function.php');
if(isset($_POST["user_id"]))
{
	$output = array();
	$statement = $connection->prepare(
		"SELECT * from customers 
			WHERE  master_id = (SELECT master_id from customers WHERE id =  '".$_POST["user_id"]."' )"
	);
	$statement->execute();
	$result = $statement->fetchAll();
	// foreach($result as $row)
	// {
	// 	$output["customer"] = $row["customer_name"];
	// 	$output["segment"] = $row["segment"];
	// }
	echo json_encode($result);
}
?>