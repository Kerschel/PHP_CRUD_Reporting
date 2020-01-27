<?php

$time = date("d-m-Y H.i.s");
$errorCounter = 0;
$message = "";
$xmlFile = "";


?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>All Segments - Ramps Logistics</title>
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
				<div align="right">
					<button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-info btn-lg">Add</button>
				</div>
				<br /><br />
				<table id="user_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="35%">Segment</th>
							<th width="10%">Edit</th>
							<th width="10%">Delete</th>
						</tr>
					</thead>
				</table>
				
			</div>
					
				</div>
            </section>
            
                        
            <div id="userModal" class="modal fade">
                <div class="modal-dialog">
                    <form method="post" id="user_form" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add Segment</h4>
                            </div>
                            <div class="modal-body">
                                <label>Enter Segment Name</label>
                                <input type="text" name="segment" id="segment" class="form-control" />
                                <br />
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="user_id" id="user_id" />
                                <input type="hidden" name="operation" id="operation" />
                                <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

		<!-- Footer -->
			<footer id="footer">
				<div class="inner">
					
					<div class="copyright">
						&copy; Ramps Logistics 2018 | <a href="https://rampslogistics.com">Visit Website</a>.
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
                
                var dataTable = $('#user_data').DataTable({
                    "processing":true,
                    "serverSide":true,
                    "order":[],
                    "ajax":{
                        url:"functions/segments/fetch.php",
                        type:"POST"
                    },
                });

                $(document).on('submit', '#user_form', function(event){
                    event.preventDefault();
                    var segment = $('#segment').val();
                    
                    if(segment != '')
                    {
                        $.ajax({
                            url:"functions/segments/insert.php",
                            method:'POST',
                            data:new FormData(this),
                            contentType:false,
                            processData:false,
                            success:function(data)
                            {
                                alert(data);
                                $('#user_form')[0].reset();
                                $('#userModal').modal('hide');
                                dataTable.ajax.reload();
                            }
                        });
                    }
                    else
                    {
                        alert("Field is Required");
                    }
                });
                
                $(document).on('click', '.update', function(){
                    var user_id = $(this).attr("id");
                    $.ajax({
                        url:"functions/segments/fetch_single.php",
                        method:"POST",
                        data:{user_id:user_id},
                        dataType:"json",
                        success:function(data)
                        {
                            $('#userModal').modal('show');
                            $('#segment').val(data.segmentname);
                            $('.modal-title').text("Edit User");
                            $('#user_id').val(user_id);
                            $('#action').val("Edit");
                            $('#operation').val("Edit");
                        }
                    })
                });
                
                $(document).on('click', '.delete', function(){
                    var user_id = $(this).attr("id");
                    if(confirm("Are you sure you want to delete this?"))
                    {
                        $.ajax({
                            url:"functions/segments/delete.php",
                            method:"POST",
                            data:{user_id:user_id},
                            success:function(data)
                            {
                                alert(data);
                                dataTable.ajax.reload();
                            }
                        });
                    }
                    else
                    {
                        return false;	
                    }
                });
                
                
            });
			</script>
	</body>
</html>