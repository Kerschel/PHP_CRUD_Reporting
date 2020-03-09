<?php

set_time_limit(20000000);
$time = date("d-m-Y H.i.s");
$errorCounter = 0;
$message = "";
$xmlFile = "";
$link = mysqli_connect("localhost", "root", "", "reporting");
$connect = mysqli_connect("localhost",'root',"","reporting");
// $select = mysqli_query($connect,"SELECT source,customer_name as name  from active_customers ");
// // print_r($select);
// // $cust =mysqli_query($connect,"SELECT  id,customer,action FROM masterkeys");
// while ($data = mysqli_fetch_array($select)){
// // 	// $data['name'] = strtoupper($data['name']);
// 	$data['name'] = str_replace("'","\\'",$data['name']);
// 	mysqli_query($connect,"Update active_customers,customers set active_customers.guid = customers.guid where (customers.customer_name like ' ".substr($data['name'],0,25)."%' or  customers.customer_name like '".substr($data['name'],0,25)."%') and active_customers.customer_name like '".$data['name']."' and customers.source_id =".$data['source']." ");
// 	// echo "Update active_customers,customers set active_customers.guid = customers.guid where (customers.customer_name like ' ".$data['name']."'or  customers.customer_name like '".$data['name']."') and active_customers.customer_name like '".$data['name']."' and customers.source_id =".$data['source']." ";
// // break;
// }
// 	$customer['customer'] = substr($customer['customer'], 0, 5);
// 	// print($customer['customer']);
// 	$test = mysqli_query($connect,"Update masterkeys SET master_id  = ( SELECT guid from customers where customer_name like '%".$customer['customer']."%' ) where  id = ".$customer['id']." ");
// 	// print_r("Update masterkeys SET master_id  = ( SELECT guid from customers where customer_name like '%".$customer['customer']."%' ) where  id = ".$customer['id']." ");
// }

// $select = mysqli_query($connect,"SELECT * FROM reporting.customers group by  concat('%',substring(customer_name,1,6),'%')");
// $count = 0;
// $select = mysqli_query($connect,"SELECT id,substring(customer_name,1,7) as customer_name FROM krish group by  concat('%',substring(customer_name,1,7),'%')");
// while ($data = mysqli_fetch_array($select)){
// 	// if($data['customer_name'] == " Wicke"){
// 		// print_r($data['customer_name']);
// 	$data['customer_name'] = str_replace("'","\\'",$data['customer_name']);
// 	// $data['customer_name'] = substr($data['customer_name'],0,6);
// 	// print_r($data['customer_name']);
// 	mysqli_query($connect,"Update krish set master_id = ".$data['id']." where customer_name like ' ".$data['customer_name']."%' or customer_name like '".$data['customer_name']."%'");
// }
// echo "Update krish set master_id = ".$data['id']." where customer_name like '%".$data['customer_name']."%' or customer_name like '".$data['customer_name']."%'";
// $count = $count+1;
// }

if (isset($_POST["xlsForm"])){
			
	if (isset($_FILES['xls']) && ($_FILES['xls']['error'] == UPLOAD_ERR_OK)) {

		//Store in uploads folder
		move_uploaded_file($_FILES['xls']['tmp_name'], __DIR__.'/uploads/'. $_FILES["xls"]['name']. $time. '.xml');
		
		//Select the uploaded file (Require PHP EXCEL library to run functions)
		// require_once dirname(__FILE__) . '/PHPExcel/IOFactory.php';
		
		//Initialize variables for company name and total usd
		$companyName = "";
		$usdTotal = 0;
        $ttdTotal = 0;
        
		//  Include PHPExcel_IOFactory
		$inputFileName = 'uploads/'. $_FILES["xls"]['name']. $time. '.xml';
		// Check connection
		if($link === false){
			die("ERROR: Could not connect. " . mysqli_connect_error());
		}
		
		
		$xml=simplexml_load_file($inputFileName);
		foreach ($xml as $customer){
			$guid = $customer['GUID'];
			$system = $_POST['system'];
			$name = $customer[0]->Name;
			$state = $customer[0]->Type;
			if( $state == "Client"){
				$sqlselect = 'SELECT customer_name, guid FROM customers WHERE guid ="'.$guid.'"';
				$exqry = mysqli_query($link, $sqlselect);
				$count = mysqli_num_rows($exqry);
				try{
				// if($count == 0){
					$masterstuff = 'SELECT mast_cust_id from lookup_table2 where "'.$name.'" like concat("%",mast_cust_name,"%") limit 1';
					$datamaster = mysqli_query($link, $masterstuff);
					
					if(mysqli_num_rows($datamaster) == 0){
						$stuff = null;
					}
					else{
					$customer_master = mysqli_fetch_array($datamaster);
					$stuff = $customer_master['mast_cust_id'];
					}
					
					// if($customer_master['mast_cust_id'] != null)
					// 	print_r($customer_master['mast_cust_id']);
							// echo 'INSERT INTO lookup_table1 (system,cust_guid,name,mast_cust_id) VALUES ("'.$system.'","'.$guid.'" ," '.$name.'" ,"'.$datamaster['mast_cust_id'].'" )';
						echo 'INSERT INTO lookup_table1 (system,cust_guid,name,mast_cust_id) VALUES ("'.$system.'","'.$guid.'" ," '.$name.'" ,"'.$stuff.'" )';
							// $sql = 'INSERT INTO lookup_table1 (system,cust_guid,name,mast_cust_id) VALUES ("'.$system.'","'.$guid.'" ," '.$name.'" ,"'.$customer_master['mast_cust_id'].'" )';
					// if(mysqli_query($link, $sql)){
					// 	// echo "Records inserted successfully.";
					// } else{
					// 	echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
					// }
				// }
				}
				catch(Exception $e) {
					continue;
				}

			}
		}

    }else{
        print "No valid file uploaded.";
    }
}

?>