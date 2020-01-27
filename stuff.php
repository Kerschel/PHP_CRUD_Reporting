<?php



?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Ramps Logistics Report</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!-- Favicon -->
		<link rel="shortcut icon" href="images/favicon.png">
		
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" href="assets/css/reporting.css" />
		
		<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css" rel="stylesheet">
		<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
		
		
		<link rel="stylesheet" href="assets/css/new.css" />

	</head>
	<body class="is-preload">
	<?php 

		include ("header.php");

	?>
	
	<img src="images/rig2.jpg" style="width:100%; height: 50%;overflow: hidden; margin-top: -30%;" />
			<section class="wrapper" id="push">
				<div class="inner">
                <input id="myInput" type="text" placeholder="Search..">
                <table id="example">
                    <thead>
                        <tr>
                            <th>Segment</th>
                            <th>Q1 2010</th>
                            <th>Q2 2010</th>
                            <th>Q3 2010</th>
                            <th>Q4 2010</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody class="labels">
                            <tr>
                            <td colspan="5">
                                    <label for="accounting">Accounting</label>
                                    <input type="checkbox" name="accounting" id="accounting" data-toggle="toggle">
                                </td>
                            </tr>
                        </tbody>
                        <tbody class="hide" id="myTable">
                            <tr>
                                <td>Australia</td>
                                <td>$7,685.00</td>
                                <td>$3,544.00</td>
                                <td>$5,834.00</td>
                                <td>$10,583.00</td>
                            </tr>
                            <tr>
                                <td>Central America</td>
                                <td>$7,685.00</td>
                                <td>$3,544.00</td>
                                <td>$5,834.00</td>
                                <td>$10,583.00</td>
                            </tr>
                            <tr>
                                <td>Europe</td>
                                <td>$7,685.00</td>
                                <td>$3,544.00</td>
                                <td>$5,834.00</td>
                                <td>$10,583.00</td>
                            </tr>
                            <tr>
                                <td>Middle East</td>
                                <td>$7,685.00</td>
                                <td>$3,544.00</td>
                                <td>$5,834.00</td>
                                <td>$10,583.00</td>
                            </tr>
                        </tbody>		
                    </tbody>
                        <tbody class="labels">
                            <tr>
                                <td colspan="5">
                                    <label for="management">Management</label>
                                    <input type="checkbox" name="management" id="management" data-toggle="toggle">
                                </td>
                            </tr>
                        </tbody>
                        <tbody class="hide" id="myTable">
                            <tr>
                                <td>Australia</td>
                                <td>$7,685.00</td>
                                <td>$3,544.00</td>
                                <td>$5,834.00</td>
                                <td>$10,583.00</td>
                            </tr>
                            <tr>
                                <td>Central America</td>
                                <td>$7,685.00</td>
                                <td>$3,544.00</td>
                                <td>$5,834.00</td>
                                <td>$10,583.00</td>
                            </tr>
                            <tr>
                                <td>Europe</td>
                                <td>$7,685.00</td>
                                <td>$3,544.00</td>
                                <td>$5,834.00</td>
                                <td>$10,583.00</td>
                            </tr>
                            <tr>
                                <td>Middle East</td>
                                <td>$7,685.00</td>
                                <td>$3,544.00</td>
                                <td>$5,834.00</td>
                                <td>$10,583.00</td>
                            </tr>
                        </tbody>		
                    </tbody>
                    </table>
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
            <script src="assets/js/report.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.5/jspdf.plugin.autotable.min.js"></script>
            
			<!-- JQuery -->
			  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
			  <!-- Bootstrap tooltips -->
			  <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
              <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
            <script src="assets/js/tableHTMLExport.js"></script>
            <script src="assets/js/jquery.table2excel.js"></script>

              
			<script>
			$(document).ready(function() {
                $('[data-toggle="toggle"]').change(function(){
                    $(this).parents().next('.hide').toggle();
                });
            });

            $(document).ready(function(){
                alert("hello");

                $("#myInput").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });

                $("#example").table2excel({
                    exclude: ".noExl",
                    name: "Worksheet Name",
                    filename: "SomeFile",
                    fileext: ".xls",
                    preserveColors: true
                }); 
                
            });
			</script>
	</body>
</html>