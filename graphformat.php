<?php
    
include_once 'connectdb.php';
error_reporting(0);
session_start();    
if($_SESSION['useremail']=="" || $_SESSION['role']=='User'){
        header('location:index.php');
    }
include_once 'header.php';
if(isset($_POST['btnfilter'])){
    $date1 = $_POST['dp1'];
    $date2 = $_POST['dp2'];
    
}

?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sales Report/Graph Format
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
        
        
        <div class="box box-primary">
            <form  name="" action="" method="post">
            <div class="box-header with-border">
              <h3 class="box-title"><b>From - </b><?php echo $date1?> <b>To - </b><?php echo $date2  ?></h3>
            </div>
            <div class="box-body">
                
                            <div class="row">
                <!---->
                
                <div class="col-md-5">
                
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker1" name="dp1"  data-date-format="yyyy-mm-dd">
                </div>
                
                </div>
                
                <div class="col-md-5">
                
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker2" name="dp2"  data-date-format="yyyy-mm-dd">
                </div>
                
                </div>
                
                <div class="col-md-2">
                
                <div align="left"><button type="submit" class="btn btn-primary" name="btnfilter">Filter</button></div>
                
                </div>
                </div>
                <br>
                <br>
                
                
                <?php
                                $select = $pdo->prepare("select order_date,sum(total) as tot from tbl_invoice where order_date between :from AND :to group by order_date");
                            //$select->debugDumpParams();
                            $select->bindParam(':from',$date1);
                            $select->bindParam(':to',$date2);
                                $select->execute();
                                $total=[];
                                $date=[];
                                while($row = $select->fetch(PDO::FETCH_OBJ)){
                                    //extract($row);
                                    $total[] = $row->tot;
                                    $date[] = $row->order_date;
                                    
                                }
                  //echo json_encode($total);
                ?>
                <div class="col-md-6">
                <canvas id="myChart">
                
                    
                
                </canvas>
                </div>
                <?php
                                $select = $pdo->prepare("select product_name,sum(qty) as qt from tbl_invoice_details where order_date between :from AND :to group by product_id");
                            //$select->debugDumpParams();
                            $select->bindParam(':from',$date1);
                            $select->bindParam(':to',$date2);
                                $select->execute();
                                $pname=[];
                                $qty=[];
                                while($row = $select->fetch(PDO::FETCH_OBJ)){
                                    //extract($row);
                                    $pname[] = $row->product_name;
                                    $qty[] = $row->qt;
                                    
                                }
                  //echo json_encode($total);
                ?>
                <div class="col-md-6">
                <canvas id="myChart1">
                
                    
                
                </canvas>
                </div>
                
        
        </div>
                </form>
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
<script>

var ctx = document.getElementById('myChart1').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        labels: <?php echo json_encode($pname) ?>,
        datasets: [{
            label: 'Product Sale',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: <?php echo json_encode($qty) ?>
        }]
    },

    // Configuration options go here
    options: {}
});


</script>
<script>

    //Date picker
    $('#datepicker1').datepicker({
      autoclose: true
    })
    //Date picker
    $('#datepicker2').datepicker({
      autoclose: true
    })
</script>
<?php
    
    include_once 'footer.php';

?>
