<?php

$time = date("d-m-Y H.i.s");
$errorCounter = 0;
$message = "";
$xmlFile = "";
$link = mysqli_connect("localhost", "root", "", "reporting");
$connect = mysqli_connect("localhost",'root',"","reporting");
$select = mysqli_query($connect,"(SELECT customers.customer_name as name ,lookup.master_id as id FROM customers,lookup where customers.customer_name like CONCAT('%',lookup.name,'%') group by customers.customer_name ) ");
// $cust =mysqli_query($connect,"SELECT  id,customer,action FROM masterkeys");
while ($data = mysqli_fetch_array($select)){
	$data['name'] = str_replace("'","\\'",$data['name']);
	mysqli_query($connect,"Update customers set master_id = ".$data['id']." where customers.customer_name like '%".$data['name']."%'");
}
// 	$customer['customer'] = substr($customer['customer'], 0, 5);
// 	// print($customer['customer']);
// 	$test = mysqli_query($connect,"Update masterkeys SET master_id  = ( SELECT guid from customers where customer_name like '%".$customer['customer']."%' ) where  id = ".$customer['id']." ");
// 	// print_r("Update masterkeys SET master_id  = ( SELECT guid from customers where customer_name like '%".$customer['customer']."%' ) where  id = ".$customer['id']." ");
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
				$sqlselect = 'SELECT guid FROM customers WHERE guid ="'.$guid.'"';
				$exqry = mysqli_query($link, $sqlselect);
				$count = mysqli_num_rows($exqry);
				// if($count == 0){
					$sql = 'INSERT INTO customers (guid,customer_name,source_id) VALUES ("'.$guid.'" ," '.$name.'" ," '.$system.'" )';
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
									<option value='1'>Guyana</option>
									<option value='2'>Brokeage</option>
									<option value='3'>Freight</option>
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