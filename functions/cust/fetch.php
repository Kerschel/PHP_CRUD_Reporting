<?php
include('db.php');
include('function.php');
$query = '';
$output = array();
$query .= "SELECT * FROM py_sales where MAST_CUST_NAME ='' or MAST_CUST_ID ='' or MAST_CUST_ID is null or MAST_CUST_ID =0 group by name";
if(isset($_POST["search"]["value"]))
{
	$query = 'SELECT * FROM py_sales  WHERE  MAST_CUST_NAME ="" or MAST_CUST_ID ="" or MAST_CUST_ID =0  and  NAME LIKE "%'.$_POST["search"]["value"].'%" group by name';
}
// if(isset($_POST["order"]))
// {
// 	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
// }
// else
// {
// 	$query .= 'ORDER BY id DESC ';
// }
if($_POST["length"] != -1)
{
	$query .= ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach($result as $row)
{
	// print_r($result);
	$sub_array = array();
	$sub_array[] = $row["NAME"];
	$sub_array[] = $row["CUST_GUID"];
	$sub_array[] = $row["MAST_CUST_NAME"];
	$sub_array[] = $row["SYSTEM"];
	$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Delete</button>';
	$data[] = $sub_array;
}
$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_all_records(),
	"data"				=>	$data
);
echo json_encode($output);
?>