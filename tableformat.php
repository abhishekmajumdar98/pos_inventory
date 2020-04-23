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
        Sales Report/Tabular Format
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
            
            <form name="" action="" method="post">
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
        
        </div>
            <br>
            <br>
    <!-- Info boxes -->
                <?php
                                $select = $pdo->prepare("select count(invoice_id) as invoice,sum(subtotal) as subtot,sum(total) as nettot,sum(tax) as tax from tbl_invoice where order_date between :from AND :to");
                            //$select->debugDumpParams();
                            $select->bindParam(':from',$date1);
                            $select->bindParam(':to',$date2);
                                $select->execute();
                                $row = $select->fetch(PDO::FETCH_OBJ);
                ?>
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-files-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Invoice</span>
              <span class="info-box-number"><?php echo number_format($row->invoice); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->


        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-inr"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Sub Total</span>
              <span class="info-box-number"><?php echo number_format($row->subtot); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-inr"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Net Amount</span>
              <span class="info-box-number"><?php echo number_format($row->nettot); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-inr"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Tax Collect</span>
              <span class="info-box-number"><?php echo number_format($row->tax); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
            
            <div class="table-responsive">
                <table id="tbltabular" class="table table-bordered">
                        <thead>
                            <tr>
                               <th>#</th>
                                <th>Customer Name</th>
                                <th>Order Date</th>
                                <th>Sub Total</th>
                                <th>Total</th>
                                <th>Tax</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Payment Type</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php
                                $select = $pdo->prepare("select * from tbl_invoice where order_date between :from AND :to");
                            //$select->debugDumpParams();
                            $select->bindParam(':from',$date1);
                            $select->bindParam(':to',$date2);
                                $select->execute();
                                while($row = $select->fetch(PDO::FETCH_OBJ)){
                                    echo '<tr>
                                        <td>'.$row->invoice_id.'</td>
                                        <td>'.$row->customer_name.'</td>
                                        <td>'.$row->order_date.'</td>
                                        <td>'.$row->subtotal.'</td>
                                        <td>'.$row->total.'</td>
                                        <td>'.$row->tax.'</td>
                                        <td>'.$row->paid.'</td>
                                        <td>'.$row->due.'</td>
                                        <td>'.$row->payment_type.'</td>
                                    </tr>';
                                }
                            ?>
                        </tbody>
                    </table> 
                    </div>
            
            </form>  
            
        </div>
        

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

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
<!-- Call this single function  (Data Table)-->
    <script>
        $(document).ready( function () {
        $('#tbltabular').DataTable({
            "order":[[0,"desc"]]
        });
    } );
        
    </script>
<?php
    
    include_once 'footer.php';

?>
