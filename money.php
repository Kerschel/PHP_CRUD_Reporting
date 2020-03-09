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
        
        
        <link rel="stylesheet" href="assets/css/new.css" />

    </head>
    <body class="is-preload">
    <?php 
        set_time_limit(50000); // 


        include ("header.php");

    ?>
    
    <img src="images/rig2.jpg" style="width:100%; height: 50%;overflow: hidden; margin-top: -30%;" />
            <section class="wrapper" id="push">
                <div class="inner">
                <?php 
                if(isset($_POST["xlsForm"])){
                    $from = $_POST['fromDate'];
                    $to = $_POST['toDate'];
                    echo "<h2 style='text-align:center;'>".$from." - " .$to."</h2>";

                }
                ?>
                <form name="xlsForm" method="POST" action="money.php#push" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="example-datetime-local-input" class="col-2 col-form-label">From Date</label>
                        <div class="col-3">
                            <input class="form-control" type="date" value="2020-01-01" name= "fromDate" id="fromDate">
                        </div>
                        <label for="example-datetime-local-input" class="col-1 col-form-label">To Date</label>

                        <div class="col-3">
                            <input class="form-control" value="2020-01-01"  type="date" name="toDate"  id="toDate">
                        </div>
                        
                    <div class="col-2">
                    <input id="xlsBtn" type="submit" name="xlsForm" class="btn btn-warning" value="Submit" />
                    </div>
                </form>
                </div>

             
                        <?php 
                        
                            if (isset($_POST["xlsForm"])){
                           
                                echo '   <input id="myInput" type="text" placeholder="Search..">
                                <table id="example">
                                    <thead>
                                        <tr>
                                            <th>Customer</th>
                                            <th>Actual Income</th>
                                            <th>Estimated Income</th>
                                            <th>Variance</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                $from= "'".$from. "'";
                                $to = "'".$to."'";
                                $connect = mysqli_connect("localhost",'root',"","reporting");
                                $customer =mysqli_query($connect,"SELECT * FROM customers group by master_id limit 10");
                                while ($sale = mysqli_fetch_array($customer)){
                                    if($sale['master_id']){
                                    
                                    $actual =mysqli_query($connect,"SELECT SUM(amount) as total FROM invoices WHERE customer_id = ".$sale['master_id']." 
                                     and  date BETWEEN ".date($from)." AND ".date($to)." " );

                                    $actual = mysqli_fetch_array($actual)['total'];
                                    if ($actual) {
                                    $result =mysqli_query($connect,"SELECT *  FROM invoices WHERE customer_id = ".$sale['master_id']."   and  date BETWEEN ".date($from)." AND ".date($to)." ");
                                    echo '<tbody class="labels">
                                    <tr>
                                        <td >
                                            <label for="'.$sale['master_id'].'">'.$sale['customer_name'].'</label>
                                            <input type="checkbox" id="'.$sale['master_id'].'" data-toggle="toggle">
                                        </td>
                                        <td>$'.$actual.'</td>
                                        <td>$</td>
                                        <td>$</td>
                                        <td><button type="button" class="btn btn-info">View</button></td>
                                    </tr>
                                    </tbody>
                                    <tbody class="hide"  id="myTable" >
                                    
                                    ';
                                    $magaya=[];
                                        $magaya[1] = "Guyana";
                                        $magaya[2] = "Brokeage";
                                        $magaya[3] = "Freight";
                                    while ($row = mysqli_fetch_array($result)){
                                        echo '
                                                <tr>
                                                    <td>'.$row['customer'].'</td>
                                                    <td>$'.$row['amount'].'</td>
                                                    <td>'.$row['invoice_no'].'</td>
                                                    <td style="text-align:center;" >'.$row['date'].'</td>
                                                    <td style="text-align:center;" >'.$magaya[$row['source']].'</td>

                                                </tr>
                                        
                                        ';
                                    }
                                    echo '   </tbody>       
                                    </tbody>';
                                // Segments
                                    }
                                }
                            }
                            }
                        ?>
                        
                    </table>
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
            <script src="assets/js/report.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.5/jspdf.plugin.autotable.min.js"></script>
            
            <!-- JQuery -->
              <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
              <!-- Bootstrap tooltips -->
            <script src="assets/js/tableHTMLExport.js"></script>
            <script src="assets/js/jquery.table2excel.js"></script>

              
            <script>
            $(document).ready(function() {
                $('[data-toggle="toggle"]').change(function(){
                    $(this).parents().next('.hide').toggle();
                });
            });

            $(document).ready(function(){
                $("#myInput").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });

                // $("#example").table2excel({
                //     exclude: ".noExl",
                //     name: "Worksheet Name",
                //     filename: "Report",
                //     fileext: ".xls",
                //     preserveColors: true
                // }); 

                
            });
            </script>
    </body>
</html>
 