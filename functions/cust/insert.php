<?php
include('db.php');
include('function.php');
if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Add")
	{
		
		$statement = $connection->prepare("
			INSERT INTO masterkeys (customer,segment) 
			VALUES (:customer,:segment)
		");
		$result = $statement->execute(
			array(
				':customer'	=>	$_POST["customer"],
				':segment'	=>	$_POST["segment"],
			)
		);
		if(!empty($result))
		{
			echo 'Data Inserted';
		}
	}
	if($_POST["operation"] == "Edit")
	{

		$statement = $connection->prepare(
			"UPDATE masterkeys 
			SET customer = :customer  ,segment=:segment
			WHERE id = :id
			"
		);
		$result = $statement->execute(
			array(
				':customer'	=>	$_POST["customer"],
				':segment'	=>	$_POST["segment"],
				':id'			=>	$_POST["user_id"]
			)
		);
		if(!empty($result))
		{
			echo 'Data Updated';
		}
	}
}

?>