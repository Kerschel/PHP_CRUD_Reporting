<?php

$time = date("d-m-Y H.i.s");
$errorCounter = 0;
$message = "";
$xmlFile = "";

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
		$link = mysqli_connect("localhost", "root", "", "reporting");
		// Check connection
		if($link === false){
			die("ERROR: Could not connect. " . mysqli_connect_error());
		}
		
		
		$xml=simplexml_load_file($inputFileName);
		foreach ($xml as $customer){
			$guid = $customer['GUID'];
			$name = $customer[0]->Name;
			$sqlselect = 'SELECT customer FROM masterkeys WHERE customer ="'.$name.'"';
			$exqry = mysqli_query($link, $sqlselect);
			$count = mysqli_num_rows($exqry);
			if($count == 0){
				$sql = 'INSERT INTO masterkeys (customer) VALUES ("'.$name.'")';
				if(mysqli_query($link, $sql)){
					echo "Records inserted successfully.";
				} else{
					echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
				}
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
		<title>All Invoices - Ramps Logistics</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!-- Favicon -->
		<link rel="shortcut icon" href="images/favicon.png">
		
		<link rel="stylesheet" href="assets/css/main.css" />
		
		<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css" rel="stylesheet"> -->
		<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		
		
        <link rel="stylesheet" href="assets/css/new.css" />
        <style>
        
        </style>

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
                <div class="table-responsive">
				<br />
			
				<br /><br />
				<table id="user_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th >Customer</th>
							<th >Invoice Number</th>
							<th >Date</th>
							<th >Amount</th>
							<th >Heading</th>
							<th >Subheading</th>
						</tr>
                    </thead>
                    <tbody>
                        <?php 
                        $connect = mysqli_connect("localhost",'root',"","reporting");
                        $result =mysqli_query($connect,"SELECT * FROM invoices");
                        while ($row = mysqli_fetch_array($result)){
                            echo '
                            <tr>
                                <td>'.$row['customer'].'</td>
                                <td>'.$row['invoice_no'].'</td>
                                <td>'.$row['date'].'</td>
                                <td>'.$row['amount'].'</td>
                                <td>'.$row['heading'].'</td>
                                <td>'.$row['subheading'].'</td>
                            </tr>
                            ';
                        }
                        ?>
                    </tbody>
				</table>
				
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>		
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
			<!-- <script src="assets/js/jquery.min.js"></script> -->
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
			<!-- JQuery -->
			  <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> -->
			  <!-- Bootstrap tooltips -->
			  <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
			  <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
			<script>
            $(document).ready(function(){
                $('#add_button').click(function(){
                    $('#user_form')[0].reset();
                    $('.modal-title').text("Add User");
                    $('#action').val("Add");
                    $('#operation').val("Add");
                    $('#user_uploaded_image').html('');
                });
                
                var dataTable = $('#user_data').DataTable();
            });
			</script>
	</body>
</html>