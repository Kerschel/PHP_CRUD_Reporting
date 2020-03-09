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
				// if($count == 0){
					$masterstuff = 'SELECT mast_cust_id from lookup_table2 where "'.$name.'" like concat("%",mast_cust_name,"%") limit 1';
					$datamaster = mysqli_query($link, $masterstuff);
					
					$customer_master = mysqli_fetch_array($datamaster);
					if($customer_master['mast_cust_id'])
						print_r($customer_master['mast_cust_id']);
							// echo 'INSERT INTO lookup_table1 (system,cust_guid,name,mast_cust_id) VALUES ("'.$system.'","'.$guid.'" ," '.$name.'" ,"'.$datamaster['mast_cust_id'].'" )';
						
							$sql = 'INSERT INTO lookup_table1 (system,cust_guid,name,mast_cust_id) VALUES ("'.$system.'","'.$guid.'" ," '.$name.'" ,"'.$customer_master['mast_cust_id'].'" )';
					if(mysqli_query($link, $sql)){
						// echo "Records inserted successfully.";
					} else{
						echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
					}
				// }

			}
			elseif( $state == "ForwardingAgent"){
				$sqlselect = 'SELECT customer_name, guid FROM customers WHERE guid ="'.$guid.'"';
				$exqry = mysqli_query($link, $sqlselect);
				$count = mysqli_num_rows($exqry);
				// if($count == 0){
					$masterstuff = 'SELECT mast_cust_id from lookup_table2 where "'.$name.'" like concat("%",mast_cust_name,"%") limit 1';
					$datamaster = mysqli_query($link, $masterstuff);
					
					$customer_master = mysqli_fetch_array($datamaster);
					if($customer_master['mast_cust_id'])
						print_r($customer_master['mast_cust_id']);
							// echo 'INSERT INTO lookup_table1 (system,cust_guid,name,mast_cust_id) VALUES ("'.$system.'","'.$guid.'" ," '.$name.'" ,"'.$datamaster['mast_cust_id'].'" )';
						
							$sql = 'INSERT INTO lookup_table1 (system,cust_guid,name,mast_cust_id) VALUES ("'.$system.'","'.$guid.'" ," '.$name.'" ,"'.$customer_master['mast_cust_id'].'" )';
					if(mysqli_query($link, $sql)){
						// echo "Records inserted successfully.";
					} else{
						echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
					}
				// }

			}
		}

    }else{
        print "No valid file uploaded.";
    }
}

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Customer Upload - Ramps Logistics</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!-- Favicon -->
		<link rel="shortcut icon" href="images/favicon.png">
		
		<link rel="stylesheet" href="assets/css/main.css" />
		
		<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css" rel="stylesheet">
		<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
		
		
		<link rel="stylesheet" href="assets/css/new.css" />

	</head>
	<body class="is-preload">
	<?php 

		include ("header.php");

	?>
	
	<img src="images/rig2.jpg" style="width:100%; height: 50%;overflow: hidden; margin-top: -30%;" />
		<!-- Banner 
			<section id="banner">
				<div class="inner">
					<h1>Ramps Logistics</h1>
					<p>Oil and Gas Logistics Across Guyana, Trinidad and Tobago and Suriname</p>
				</div>
				<video autoplay loop muted playsinline src="images/banner.mp4"></video>
			</section>

		<!-- Highlights -->
			<section class="wrapper" id="push">
				<div class="inner">
					<header class="special">
						<h2>Customers</h2>
						<p>Upload an customer list</p>
						<br/>
						
						<form name="xlsForm" method="POST" action="customers.php#push" enctype="multipart/form-data">
						<div style="display:inline-block;margin-right:10px; width: 50%;">
							<label>Select a XML File: </label> <input type="file" name="xls" /></br>
							<label>Select a System</label>
                                <select style="display:inline-block;margin-right:10px; width: 50%;" name='system' id="system">
									<option value='GY'>Guyana</option>
									<option value='BR'>Brokeage</option>
									<option value='FR'>Freight</option>
								</select>

							</div></br>
							<div style="display:inline-block;">
								<input id="xlsBtn" type="submit" name="xlsForm" value="Upload File" />
							</div>
						</form>
						
					</header>
					<div class="highlights">
						<!-- Main Content 
						<div style="width: 100%;">
						<table id="example" class="table table-striped table-bordered">
						  <thead>
							<tr>
							  <th class="th-sm">Some details
								<i class="fa fa-sort float-right" aria-hidden="true"></i>
							  </th>
							</tr>
						  </thead>

								<tbody>
								</tbody>
							</table>
						</div>
						<!-- End Main Content -->
					</div>
				</div>
			</section>

		<!-- Footer -->
			<footer id="footer">
				<div class="inner">
					
					<div class="copyright">
						&copy; Ramps Logistics 2018 | <a href="https://rampslogistics.com">Visit Website</a>.
					</div>
				</div>
			</footer>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
			<!-- JQuery -->
			  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
			  <!-- Bootstrap tooltips -->
			  <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
			  <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
			<script>
			$(document).ready(function() {
				$('#example').DataTable();
			} );
			
			</script>
	</body>
</html>