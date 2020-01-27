<?php
include('db.php');
include('function.php');
if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Add")
	{
		
		$statement = $connection->prepare("
			INSERT INTO segments (segmentname) 
			VALUES (:segmentname)
		");
		$result = $statement->execute(
			array(
				':segmentname'	=>	$_POST["segment"],
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
			"UPDATE segments 
			SET segmentname = :segment
			WHERE id = :id
			"
		);
		$result = $statement->execute(
			array(
				':segmentname'	=>	$_POST["segment"],
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