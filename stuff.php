<?php

$time = date("d-m-Y H.i.s");
$errorCounter = 0;
$message = "";
$xmlFile = "";
set_time_limit(50000000); // 
// $connect = mysqli_connect("localhost",'root',"","reporting");
// $select = mysqli_query($connect,"SELECT source,customer_name as name  from active_customers ");
// // print_r($select);
// // $cust =mysqli_query($connect,"SELECT  id,customer,action FROM masterkeys");
// while ($data = mysqli_fetch_array($select)){
if (isset($_POST["xlsForm"])){
			
	if (isset($_FILES['xls']) && ($_FILES['xls']['error'] == UPLOAD_ERR_OK)) {

		
		//Store in uploads folder
		move_uploaded_file($_FILES['xls']['tmp_name'], __DIR__.'/uploads/'. $_FILES["xls"]['name']. $time. '.xls');
		
		//Select the uploaded file (Require PHP EXCEL library to run functions)
		// require_once dirname(__FILE__) . '/PHPExcel/IOFactory.php';
		
		//Initialize variables for company name and total usd
		$companyName = "";
		$usdTotal = 0;
        $ttdTotal = 0;
        
		//  Include PHPExcel_IOFactory
		include 'PHPExcel/IOFactory.php';
		$inputFileName = 'uploads/'. $_FILES["xls"]['name']. $time. '.xls';

		// $inputFileName = './sampleData/example1.xls';

		//  Read your Excel workbook
		try {
			$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($inputFileName);
			// $objPHPExcel = $objPHPExcel->setActiveSheetIndex(0);
		} catch(Exception $e) {
			die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
		}

		//  Get worksheet dimensions
		$sheet = $objPHPExcel->getSheet(0); 
		$highestRow = $sheet->getHighestRow(); 
		$highestColumn = $sheet->getHighestColumn();

		//  Loop through each row of the worksheet in turn
		for ($row = 2; $row <= $highestRow; $row++){ 
			//  Read a row of data into an array
			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
											NULL,
											TRUE,
											FALSE);
			$data[$row] = $rowData[0];
			// print("\n");
			//  Insert row data array into your database of choice here
		}
$link = mysqli_connect("localhost",'root',"","reporting");

		// $link = mysqli_connect("rampslogistics-mysqldbserver.mysql.database.azure.com", "mysqladmin@rampslogistics-mysqldbserver", "Ramps101*", "reporting");
		// Check connection
		if($link === false){
			die("ERROR: Could not connect. " . mysqli_connect_error());
		}

		$months['Jan'] = 1;
		$months['Feb'] = 2;
		$months['Mar'] = 3;
		$months['Apr'] = 4;
		$months['May'] = 5;
		$months['Jun'] = 6;
		$months['Jul'] = 7;
		$months['Aug'] = 8;
		$months['Sep'] = 9;
		$months['Oct'] = 10;
		$months['Nov'] = 11;
		$months['Dec'] = 12;

		foreach ($data as $key => $val) {
				// $sqlselect = mysqli_fetch_assoc(mysqli_query($link,'SELECT master_id FROM customers WHERE customer_name like concat("%","'.$val[6].'","%") LIMIT 1'));
				// $sqlselect = mysqli_fetch_assoc(mysqli_query($link,'SELECT customer_name,master_id,guid FROM active_customers WHERE customer_name like concat("%","'.$val[6].'","%") LIMIT 1'));
				$sqlselect = mysqli_fetch_assoc(mysqli_query($link,'SELECT * FROM lookup_table1 WHERE name like concat("","'.substr($val[6],0,10).'","%") or name like concat("_","'.substr($val[6],0,10).'","%") and system = "'.$val[12].'" LIMIT 1'));
				$id = $sqlselect['MAST_CUST_ID'];
				$cust = mysqli_fetch_assoc(mysqli_query($link,'SELECT * FROM lookup_table2 WHERE MAST_CUST_ID = '.$id.''));
				$master_name = $cust['MAST_CUST_NAME'];
				$guid = $sqlselect['CUST_GUID'];
				$dateFormat = explode("/",$val[3]);
				$dateFormat[0] = $months[$dateFormat[0]] ;
				$month = explode("/",$val[3])[0];
				$dateFormat = implode("-",$dateFormat);
				$customer = rtrim(ltrim($val[6]));
				$type = rtrim(ltrim($val[2]));
				$date = DateTime::createFromFormat('m-d-Y',$dateFormat);
				// echo $date->format('Y-m-d');
				// echo date('d-m-Y',strtotime($dateFormat));
			
				$sql= mysqli_query($link,'INSERT INTO py_sales
				(
				SYSTEM,
				COUNTRY,
				HEAD,
				SUBHEAD,
				TYPE,
				RDATE,
				DATE,
				SER_NO,
				NAME,
				MEMO,
				QTY,
				SALES_PRICE,
				AMOUNT,
				CURRENCY,
				MNTH,
				CUST_GUID,
				BASE_AMOUNT,
				MAST_CUST_ID,
				MAST_CUST_NAME)
				VALUES
				("'.$val[12].'",
				"'.$val[13].'",
				"'.$val[0].'",
				"'.$val[1].'",
				"'.$type.'",
				"'.$date->format('M/d/y').'",
				"'.$date->format('Y-m-d').'",
				"'.$val[5].'",
				"'.$customer.'",
				"'.$val[7].'",
				"'.$val[8].'",
				"'.$val[9].'",
				"'.$val[10].'",
				"TTD",
				"'.$month.'",
				"'.$guid.'",
				"'.$val[10].'",
				"'.$id.'",
				"'.$master_name.'")
				 ');
				//  echo 'INSERT INTO py_sales
				//  (
				//  SYSTEM,
				//  COUNTRY,
				//  HEAD,
				//  SUBHEAD,
				//  TYPE,
				//  RDATE,
				//  DATE,
				//  SER_NO,
				//  NAME,
				//  MEMO,
				//  QTY,
				//  SALES_PRICE,
				//  AMOUNT,
				//  CURRENCY,
				//  MNTH,
				//  CUST_GUID,
				//  BASE_AMOUNT,
				//  MAST_CUST_ID,
				//  MAST_CUST_NAME)
				//  VALUES
				//  ("'.$val[12].'",
				//  "'.$val[13].'",
				//  "'.$val[0].'",
				//  "'.$val[1].'",
				//  "'.$type.'",
				//  "'.$date->format('M/d/y').'",
				//  "'.$date->format('Y-m-d').'",
				//  "'.$val[5].'",
				//  "'.$customer.'",
				//  "'.$val[7].'",
				//  "'.$val[8].'",
				//  "'.$val[9].'",
				//  "'.$val[10].'",
				//  "TTD",
				//  "'.$month.'",
				//  "'.$guid.'",
				//  "'.$val[10].'",
				//  "'.$id.'",
				//  "'.$master_name.'")
				//   ';
				// $sql = 'INSERT INTO invoices (source,customer_id,customer,invoice_no,date,amount,sales_price,type,heading,subheading,memo) VALUES (1,"'.$id.'","'.$customer.'","'.$val[5].'","'.$date->format('Y-m-d').'","'.$val[10].'","'.$val[9].'","'.$type.'","'.$val[0].'","'.$val[1].'","'.$val[7].'")';
				
				
				if(mysqli_query($link, $sql)){
					continue;
				} else{
					echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
				}
		}
		echo "Records inserted successfully.";



		

    }else{
        print "No valid file uploaded.";
    }
}

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>All Invoices - Ramps Logistics</title>
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
						<h2>ALL Invoices</h2>
						<p>Upload an invoice to continue</p>
						<br/>
						
						<form name="xlsForm" method="POST" action="index.php#push" enctype="multipart/form-data">
						<div style="display:inline-block;margin-right:10px; width: 75%;">
							<label>Select an invoice Excel File: </label> <input type="file" name="xls" />
							
							</div>
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
						&copy; Ramps Logistics 2020 | <a href="https://rampslogistics.com">Visit Website</a>.
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