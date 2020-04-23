<?php
    
    include_once 'connectdb.php';
    session_start();
    if($_SESSION['useremail']=="" || $_SESSION['role']=='User'){
        header('location:index.php');
    }
    
    include_once 'header.php';


$select = $pdo->prepare("select count(invoice_id) as inv,sum(total) as tot from tbl_invoice");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Admin Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
    
        
        
              <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo number_format($row->inv) ?></h3>

              <p>Total Invoice</p>
            </div>
            <div class="icon">
              <i class="ion ion-document"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>&#x20b9;<?php echo number_format($row->tot) ?></h3>

              <p>Total</p>
            </div>
            <div class="icon">
              <i class="ion ion-cash"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      <?php
    
              $select = $pdo->prepare("select count(pname) as pname from tbl_product");
             $select->execute();
            $row = $select->fetch(PDO::FETCH_OBJ);
    
    ?>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo number_format($row->pname) ?></h3>

              <p>Total Product</p>
            </div>
            <div class="icon">
              <i class="ion ion-pricetags"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
           <?php
    
              $select = $pdo->prepare("select count(category) as cat from tbl_category");
             $select->execute();
            $row = $select->fetch(PDO::FETCH_OBJ);
    
    ?>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo number_format($row->cat) ?></h3>

              <p>Total Category</p>
            </div>
            <div class="icon">
              <i class="ion ion-pricetag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
        
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Date Wise Earning</h3>
            </div>
            <?php
    $select = $pdo->prepare("select order_date,total from tbl_invoice");
                            
                                $select->execute();
                                $total=[];
                                $date=[];
                                while($row = $select->fetch(PDO::FETCH_OBJ)){
                                    //extract($row);
                                    $total[] = $row->total;
                                    $date[] = $row->order_date;
                                    
                                }
                  //echo json_encode($total);
            ?>
            <div class="box-body">
            <div class="chart">
                <canvas id="myChart" style="height:250px">
                
                    
                
                </canvas>
            
            </div>
                </div>
       
        </div>
        <div class="row">
        
        <div class="col-md-6">
            <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Best Selling Order</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                <table id="tblbestselling" class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $select = $pdo->prepare("select product_id,product_name,price,sum(qty) as qt,sum(qty*price) as tot from tbl_invoice_details group by product_id ORDER BY sum(qty) DESC LIMIT 5");
                                $select->execute();
                                while($row = $select->fetch(PDO::FETCH_OBJ)){
                                    echo '<tr>
                                        <td>'.$row->product_id.'</td>
                                        <td>'.$row->product_name.'</td>
                                        <td>'.$row->qt.'</td>
                                        <td>'.$row->price.'</td>
                                        <td>'.$row->tot.'</td>
                                    </tr>';
                                }
                            ?>
                        </tbody>
                    </table> 
                    </div>
            </div>
       
        </div>
            
        </div>
        <div class="col-md-6">
            
            <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Recent Orders</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                <table id="tblorderlist" class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th>Order Date</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Due</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $select = $pdo->prepare("select * from tbl_invoice ORDER BY invoice_id DESC LIMIT 5");
                                $select->execute();
                                while($row = $select->fetch(PDO::FETCH_OBJ)){
                                    echo '<tr>
                                        <td><a href="editorder.php?id='.$row->invoice_id.'">'.$row->invoice_id.'</a></td>
                                        <td>'.$row->customer_name.'</td>
                                        <td>'.$row->order_date.'</td>
                                        <td>'.$row->total.'</td>
                                        <td>'.$row->paid.'</td>
                                        <td>'.$row->due.'</td>
                                    </tr>';
                                }
                            ?>
                        </tbody>
                    </table> 
                    </div>
            </div>
       
        </div>
        
        </div>
        
        
        </div>
    </section>
    <!-- /.content -->
  </div>

  <!-- /.content-wrapper -->


<script>

var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        labels: <?php echo json_encode($date) ?>,
        datasets: [{
            label: 'Total Earning',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: <?php echo json_encode($total) ?>
        }]
    },

    // Configuration options go here
    options: {}
});

    

</script>
<!-- Call this single function  (Data Table)-->
    <script>
        $(document).ready( function () {
        $('#tblbestselling').DataTable({
            "order":[[2,"desc"]],
            "bPaginate": false
        });
    } );
        
    </script>


<script>
        $(document).ready( function () {
        $('#tblorderlist').DataTable({
            "order":[[0,"desc"]],
            "bPaginate": false
        });
    } );
        
    </script>
<?php
    
    include_once 'footer.php';

?>