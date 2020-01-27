<?php
include('db.php');
include('function.php');
if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Add")
	{
		
		$statement = $connection->prepare("
			INSERT INTO business (heading,subheading,lob) 
			VALUES (:heading,:subheading,:lob)
		");
		$result = $statement->execute(
			array(
				':heading'	=>	$_POST["heading_val"],
				':subheading'	=>	$_POST["subheading"],
				':lob'	=>	$_POST["lob"]
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
			"UPDATE business 
			SET heading = :heading , subheading = :subheading ,lob = :lob 
			WHERE id = :id
			"
		);
		$result = $statement->execute(
			array(
				':heading'	=>	$_POST["heading_val"],
				':subheading'	=>	$_POST["subheading"],
				':lob'	=>	$_POST["lob"],
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