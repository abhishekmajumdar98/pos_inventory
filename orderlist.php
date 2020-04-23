<?php
    
include_once 'connectdb.php';
session_start();    
if($_SESSION['useremail']==""){
        header('location:index.php');
    }
if($_SESSION['role']=='Admin'){
    include_once 'header.php';
}
else{
    include_once 'headeruser.php';
}

?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Order List
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
            <div class="box-header with-border">
              <h3 class="box-title">Order list Table</h3>
            </div>
            <div class="box-body">
        
        <div class="table-responsive">
                <table id="tblorderlist" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Invoice Id</th>
                                <th>Customer Name</th>
                                <th>Order Date</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Payment Type</th>
                                <th>Print</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $select = $pdo->prepare("select * from tbl_invoice ORDER BY invoice_id DESC");
                                $select->execute();
                                while($row = $select->fetch(PDO::FETCH_OBJ)){
                                    echo '<tr>
                                        <td>'.$row->invoice_id.'</td>
                                        <td>'.$row->customer_name.'</td>
                                        <td>'.$row->order_date.'</td>
                                        <td>'.$row->total.'</td>
                                        <td>'.$row->paid.'</td>
                                        <td>'.$row->due.'</td>
                                        <td>'.$row->payment_type.'</td>
                                        <td><a href="invoice.php?id='.$row->invoice_id.'" class="btn btn-info" role="button" target="_blank"><span class="glyphicon glyphicon-print" data-toggle="tooltip" title="Print Invoice"></span></a></td>
                                        <td><a href="editorder.php?id='.$row->invoice_id.'" class="btn btn-success" role="button"><span class="glyphicon glyphicon-edit" data-toggle="tooltip" title="Edit Order"></span></a></td>
                                        <td><button id='.$row->invoice_id.' class="btn btn-danger btndelete" role="button"><span class="glyphicon glyphicon-trash" data-toggle="tooltip" title="Delete Order"></span></button></td>
                                    </tr>';
                                }
                            ?>
                        </tbody>
                    </table> 
                    </div>
        </div>
        </div>
        

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <!-- Call this single function  (Data Table)-->
    <script>
        $(document).ready( function () {
        $('#tblorderlist').DataTable({
            "order":[[0,"desc"]]
        });
    } );
        
    </script>
    <script>
        
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
        
    </script>

   <script>
        
        $(document).ready(function(){
           
            $('.btndelete').click(function(){
                //alert('hi');
                var tdh = $(this);
                var id = $(this).attr("id");
                swal({
                  title: "Are you sure?",
                  text: "Deleted Order Can not Recover",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                })
                .then((willDelete) => {
                  if (willDelete) {
                    swal("Order Has Been Deleted", {
                      icon: "success",
                    });
                      $.ajax({
                    
                    url:'orderdelete.php',
                    type:'post',
                    data:{
                        pid: id
                    },
                    success:function(data){
                        tdh.parents('tr').hide();
                    }
                });
                  } else {
                    swal("Order Not Deleted");
                  }
                });
            });
            
        });
        
    </script>
<?php
    
    include_once 'footer.php';

?>
