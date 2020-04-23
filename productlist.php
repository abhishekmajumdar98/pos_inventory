<?php
    
    include_once 'connectdb.php';
    session_start();
if($_SESSION['useremail']=="" || $_SESSION['role']=='User'){
        header('location:index.php');
    }
    include_once 'header.php';

?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Product List
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
              <h3 class="box-title">Product List</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                <table id="tblproduct" class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Purchase Price</th>
                                <th>Sale Price</th>
                                <th>Stock</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>View</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $select = $pdo->prepare("select * from tbl_product ORDER BY pid DESC");
                                $select->execute();
                                while($row = $select->fetch(PDO::FETCH_OBJ)){
                                    echo '<tr>
                                        <td>'.$row->pid.'</td>
                                        <td>'.$row->pname.'</td>
                                        <td>'.$row->pcategory.'</td>
                                        <td>'.$row->purchaseprice.'</td>
                                        <td>'.$row->saleprice.'</td>
                                        <td>'.$row->pstock.'</td>
                                        <td>'.$row->pdescription.'</td>
                                        <td><img src="productimage/'.$row->pimage.'" class="img-rounded" width=40px height=40px></td>
                                        <td><a href="viewproduct.php?id='.$row->pid.'" class="btn btn-info" role="button"><span class="glyphicon glyphicon-eye-open" data-toggle="tooltip" title="View Product"></span></a></td>
                                        <td><a href="editproduct.php?id='.$row->pid.'" class="btn btn-success" role="button"><span class="glyphicon glyphicon-edit" data-toggle="tooltip" title="Edit Product"></span></a></td>
                                        <td><button id='.$row->pid.' class="btn btn-danger btndelete" role="button"><span class="glyphicon glyphicon-trash" data-toggle="tooltip" title="Delete Product"></span></button></td>
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
        $('#tblproduct').DataTable({
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
                  text: "Deleted Product Can not Recover",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                })
                .then((willDelete) => {
                  if (willDelete) {
                    swal("Product Has Been Deleted", {
                      icon: "success",
                    });
                      $.ajax({
                    
                    url:'productdelete.php',
                    type:'post',
                    data:{
                        pid: id
                    },
                    success:function(data){
                        tdh.parents('tr').hide();
                    }
                });
                  } else {
                    swal("Product Not Deleted");
                  }
                });
            });
            
        });
        
    </script>
<?php
    
    include_once 'footer.php';

?>
