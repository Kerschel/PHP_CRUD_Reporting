<?php

$time = date("d-m-Y H.i.s");
$errorCounter = 0;
$message = "";
$xmlFile = "";
set_time_limit(50000); // 

$connect = mysqli_connect("localhost",'root',"","reporting");
// $select = mysqli_query($connect,"SELECT mast_cust_id as master, mast_cust_name as name,segment,sub_segment  from master_customer_segment ");


$select = mysqli_query($connect,"SELECT * FROM py_sales where MAST_CUST_NAME ='' or MAST_CUST_ID ='' or MAST_CUST_ID is null or MAST_CUST_ID =0 group by name");
while($stuff = mysqli_fetch_array($select)){
    $sqlselect = mysqli_fetch_assoc(mysqli_query($connect,'SELECT * FROM lookup_table1 WHERE name like concat("","'.substr($stuff['NAME'],0,10).'","%") or name like concat("_","'.substr($stuff['NAME'],0,10).'","%") and system = "'.$stuff['SYSTEM'].'" LIMIT 1'));
    $id = $sqlselect['id'];
    $table2 = mysqli_fetch_assoc(mysqli_query($connect,'SELECT * FROM lookup_table2 WHERE mast_cust_name like concat("","'.substr($stuff['NAME'],0,10).'","%") or mast_cust_name like concat("_","'.substr($stuff['NAME'],0,10).'","%") LIMIT 1'));
    $master = $table2['MAST_CUST_ID'] ;

    mysqli_query($connect,'UPDATE lookup_table1 SET MAST_CUST_ID = "'.$master.'" where id = "'.$id.'"' );
    mysqli_query($connect,'UPDATE py_sales SET MAST_CUST_ID = "'.$master.'" ,MAST_CUST_NAME = "'.$table2['MAST_CUST_NAME'].'", CUST_GUID="'.$sqlselect['CUST_GUID'].'" WHERE NAME = "'.$stuff['NAME'].'" and SYSTEM = "'.$stuff['SYSTEM'].'"' );
// echo 'UPDATE py_sales SET MAST_CUST_ID = "'.$master.'" ,MAST_CUST_NAME = "'.$table2['MAST_CUST_NAME'].'", CUST_GUID="'.$sqlselect['CUST_GUID'].'" WHERE NAME = "'.$stuff['NAME'].'" and SYSTEM = "'.$stuff['SYSTEM'].'"' ;
}
?>