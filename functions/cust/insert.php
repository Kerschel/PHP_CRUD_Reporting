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
			"UPDATE py_sales 
			SET CUST_GUID = :guid  ,MAST_CUST_ID=:master, MAST_CUST_NAME = (select MAST_CUST_NAME from lookup_table2 where MAST_CUST_ID=:master)
			WHERE NAME = :name
			"
		);
		$result = $statement->execute(
			array(
				':master'	=>	$_POST["master"],
				':name'	=>	$_POST["name"],
				':guid'			=>	$_POST["guid"]
			)
		);
		if(!empty($result))
		{
			echo 'Data Updated';
		}

		$statement = $connection->prepare(
			"UPDATE lookup_table1 
			SET MAST_CUST_ID=:master
			WHERE CUST_GUID = :guid
			"
		);
		$result = $statement->execute(
			array(
				':master'	=>	$_POST["master"],
				':guid'			=>	$_POST["guid"]
			)
		);
		if(!empty($result))
		{
			echo 'Data Updated';
		}


		// $statement = $connection->prepare(
		// 	'UPDATE py_sales SET MAST_CUST_ID=:master,
		// 	CUST_GUID = :guid 
		// 	WHERE NAME =:name and SYSTEM =:system'
		// );
		// $result = $statement->execute(
		// 	array(
		// 		':master'	=>	$_POST["master"],
		// 		':guid'			=>	$_POST["guid"]
		// 		':system'			=>	$_POST["system"]
		// 		':name'	=>	$_POST["name"],

		// 	)
		if(!empty($result))
		{
			echo 'Data Updated';
		}



	}
}

?>