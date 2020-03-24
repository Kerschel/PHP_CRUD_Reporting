<?php

$time = date("d-m-Y H.i.s");
$errorCounter = 0;
$message = "";
$xmlFile = "";
set_time_limit(50000); // 

$connect = mysqli_connect("localhost",'root',"","reporting");
// $select = mysqli_query($connect,"SELECT mast_cust_id as master, mast_cust_name as name,segment,sub_segment  from master_customer_segment ");


// $select = mysqli_query($connect,"SELECT * FROM py_sales where MAST_CUST_NAME ='' or MAST_CUST_ID ='' or MAST_CUST_ID is null or MAST_CUST_ID =0 group by name");
// while($stuff = mysqli_fetch_array($select)){
//     $sqlselect = mysqli_fetch_assoc(mysqli_query($connect,'SELECT * FROM lookup_table1 WHERE name like concat("","'.substr($stuff['NAME'],0,10).'","%") or name like concat("_","'.substr($stuff['NAME'],0,10).'","%") and system = "'.$stuff['SYSTEM'].'" LIMIT 1'));
//     $id = $sqlselect['id'];
//     $table2 = mysqli_fetch_assoc(mysqli_query($connect,'SELECT * FROM lookup_table2 WHERE mast_cust_name like concat("","'.substr($stuff['NAME'],0,10).'","%") or mast_cust_name like concat("_","'.substr($stuff['NAME'],0,10).'","%") LIMIT 1'));
//     $master = $table2['MAST_CUST_ID'] ;

//     mysqli_query($connect,'UPDATE lookup_table1 SET MAST_CUST_ID = "'.$master.'" where id = "'.$id.'"' );
//     mysqli_query($connect,'UPDATE py_sales SET MAST_CUST_ID = "'.$master.'" ,MAST_CUST_NAME = "'.$table2['MAST_CUST_NAME'].'", CUST_GUID="'.$sqlselect['CUST_GUID'].'" WHERE NAME = "'.$stuff['NAME'].'" and SYSTEM = "'.$stuff['SYSTEM'].'"' );
// // echo 'UPDATE py_sales SET MAST_CUST_ID = "'.$master.'" ,MAST_CUST_NAME = "'.$table2['MAST_CUST_NAME'].'", CUST_GUID="'.$sqlselect['CUST_GUID'].'" WHERE NAME = "'.$stuff['NAME'].'" and SYSTEM = "'.$stuff['SYSTEM'].'"' ;
// }


// populate misssing cust_guid if missing cust_guid
// $select = mysqli_query($connect,'SELECT * FROM reporting.py_sales where (CUST_GUID ="" or cust_guid is null) and mast_cust_id !=""  group by name');
// while($stuff = mysqli_fetch_array($select)){
//     $sqlselect = mysqli_fetch_assoc(mysqli_query($connect,'SELECT * FROM lookup_table1 WHERE name like concat("","'.substr($stuff['MAST_CUST_NAME'],0,4).'","%") or name like concat("_","'.substr($stuff['MAST_CUST_NAME'],0,4).'","%") and system = "'.$stuff['SYSTEM'].'" LIMIT 1'));
//     mysqli_query($connect,'UPDATE py_sales SET CUST_GUID = "'.$sqlselect['CUST_GUID'].'" WHERE NAME = "'.$stuff['NAME'].'" and SYSTEM = "'.$stuff['SYSTEM'].'"' );
// // echo 'UPDATE py_sales SET MAST_CUST_ID = "'.$master.'" ,MAST_CUST_NAME = "'.$table2['MAST_CUST_NAME'].'", CUST_GUID="'.$sqlselect['CUST_GUID'].'" WHERE NAME = "'.$stuff['NAME'].'" and SYSTEM = "'.$stuff['SYSTEM'].'"' ;
// }


// populate misssing cust_guid if missing cust_guid
// $select = mysqli_query($connect,"SELECT * FROM py_sales where MAST_CUST_NAME ='' or MAST_CUST_ID ='' or MAST_CUST_ID is null or MAST_CUST_ID =0 group by name");
// while($stuff = mysqli_fetch_array($select)){
//     $sqlselect = mysqli_fetch_assoc(mysqli_query($connect,'SELECT * FROM lookup_table2 WHERE MAST_CUST_NAME like "'.$stuff['NAME'].'"  LIMIT 1') );
//     // echo 'SELECT * FROM lookup_table2 WHERE MAST_CUST_NAME like concat("","'.substr($stuff['NAME'],0,4).'","%") or MAST_CUST_NAME like concat("_","'.substr($stuff['NAME'],0,4).'","%")  LIMIT 1';
//     mysqli_query($connect,'UPDATE py_sales SET MAST_CUST_ID = "'.$sqlselect['MAST_CUST_ID'].'" , MAST_CUST_NAME = "'.$sqlselect['MAST_CUST_NAME'].'" WHERE NAME = "'.$stuff['NAME'].'"' );
// // echo 'UPDATE py_sales SET MAST_CUST_ID = "'.$master.'" ,MAST_CUST_NAME = "'.$table2['MAST_CUST_NAME'].'", CUST_GUID="'.$sqlselect['CUST_GUID'].'" WHERE NAME = "'.$stuff['NAME'].'" and SYSTEM = "'.$stuff['SYSTEM'].'"' ;
// }

// echo $contents;
function base64ToImage( $output_file) {
    $url = "https://eldoradooffshore-edorecruitment-back-949423.dev.odoo.com/recruited";
    $base64_string = file_get_contents($url);
    $file = fopen($output_file, "wb");

//     $data = explode(',', $base64_string);
    echo   ($base64_string);
    fwrite($file, base64_decode($base64_string));
    fclose($file);
    return $output_file;
}

base64ToImage("test.pdf")

?>