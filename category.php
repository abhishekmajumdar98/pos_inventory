<?php
    
     include_once 'connectdb.php';
    session_start();
    if($_SESSION['useremail']=="" || $_SESSION['role']=='User'){
        header('location:index.php');
    }
    include_once 'header.php';
    if(isset($_POST['btnsave'])){
        
        $cat_name = $_POST['txt_category'];
        if(!empty($cat_name)){
            
            $insert = $pdo->prepare("insert into tbl_category(category) values(:catname)");
        $insert->bindParam(':catname',$cat_name);
        if($insert->execute()){
             echo '
                        <script text="text/javascript">

                            jQuery(function validation(){

                                swal({
                                  title: "Insertion Successful",
                                  text: "Category Inserted Succesfully",
                                  icon: "success",
                                  button: "Ok",
                                });

                            });

                        </script>
                    ';
        }
        else{
              echo '
                        <script text="text/javascript">

                            jQuery(function validation(){

                                swal({
                                  title: "Insertion Unsuccessful",
                                  text: "Category Not Inserted Succesfully",
                                  icon: "error",
                                  button: "Ok",
                                });

                            });

                        </script>
                    ';
        }
        }
        else{
             echo '
                        <script text="text/javascript">

                            jQuery(function validation(){

                                swal({
                                  title: "Field Can Not Be Empty",
                                  text: "Please Fill The Field",
                                  icon: "error",
                                  button: "Ok",
                                });

                            });

                        </script>
                    ';
        }
        
    }//btnsave code end here

    if(isset($_POST['btnupdate'])){
        
        $cat_id = $_POST['txt_id'];
        $cat_name = $_POST['txt_category'];
        if(!empty($cat_name)){
            
        $update = $pdo->prepare("update tbl_category set category=:catname where catid=:catid");
        $update->bindParam(':catname',$cat_name);
        $update->bindParam(':catid',$cat_id);
        if($update->execute()){
            
            echo '
                        <script text="text/javascript">

                            jQuery(function validation(){

                                swal({
                                  title: "Update Successful",
                                  text: "Category Updated Succesfully",
                                  icon: "success",
                                  button: "Ok",
                                });

                            });

                        </script>
                    ';
            
        }
        else{
            
            echo '
                        <script text="text/javascript">

                            jQuery(function validation(){

                                swal({
                                  title: "Update Unsuccessful",
                                  text: "Category Not Updated",
                                  icon: "error",
                                  button: "Ok",
                                });

                            });

                        </script>
                    ';
            
            
        }
            
            
        }
        else{
            
            echo '
                        <script text="text/javascript">

                            jQuery(function validation(){

                                swal({
                                  title: "Field Can Not Be Empty",
                                  text: "Please Fill The Field",
                                  icon: "error",
                                  button: "Ok",
                                });

                            });

                        </script>
                    ';
            
        }
        
    }//btnupdate code end here


    if(isset($_POST['btndelete'])){
        
        $delete = $pdo->prepare("delete from tbl_category where catid=".$_POST['btndelete']);
        if($delete->execute()){
            
            echo '
                        <script text="text/javascript">

                            jQuery(function validation(){

                                swal({
                                  title: "Delete Successful",
                                  text: "Category Deleted Succesfully",
                                  icon: "success",
                                  button: "Ok",
                                });

                            });

                        </script>
                    ';
            
        }
        else{
            
            echo '
                        <script text="text/javascript">

                            jQuery(function validation(){

                                swal({
                                  title: "Delete Unsuccessful",
                                  text: "Category Not Deleted Succesfully",
                                  icon: "error",
                                  button: "Ok",
                                });

                            });

                        </script>
                    ';
        }
    }

?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Category
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
              <h3 class="box-title">Registration Form</h3>
            </div>
            
            <div class="box-body">
                <form role="form" action="" method="post">
                    <?php
                    
                        if(isset($_POST['btnedit'])){
                            
                            $select = $pdo->prepare("select * from tbl_category where catid=".$_POST['btnedit']);
                            if($select->execute()){
                                $row = $select->fetch(PDO::FETCH_OBJ);
                                echo ' <div class="col-md-4">
                                <div class="form-group">
                              <label>Category</label>
                              <input type="hidden" class="form-control" value="'.$row->catid.'"name="txt_id">
                              <input type="text" class="form-control" value="'.$row->category.'"name="txt_category">
                            </div>
                                <!--<div class="box-footer">-->
                            <button type="submit" class="btn btn-info" name="btnupdate">Update</button>
                          <!--</div>-->
                            </div>';
                                
                            }
                        }
                    else{
                        
                        echo ' <div class="col-md-4">
                    <div class="form-group">
                  <label>Category</label>
                  <input type="text" class="form-control"  placeholder="Enter Category Name" name="txt_category">
                </div>
                    <!--<div class="box-footer">-->
                <button type="submit" class="btn btn-primary" name="btnsave">Save</button>
              <!--</div>-->
                </div>';
                        
                    }
                        
                    ?>
                    
               
                <div class="col-md-8">
                    
                    <table class="table table-striped" id="tblcategory">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Name</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                
                                    $select = $pdo->prepare("select * from tbl_category ORDER BY catid DESC");
                                    $select->execute();
                                    while($row = $select->fetch(PDO::FETCH_OBJ)){
                                        
                                        echo '<tr>
                                            <td>'.$row->catid.'</td>
                                             <td>'.$row->category.'</td>
                                             <td><button type="submit" value="'.$row->catid.'" class="btn btn-success" name="btnedit">Edit</button></td>
                                             <td><button type="submit" value="'.$row->catid.'" class="btn btn-danger" name="btndelete">Delete</button></td>
                                    </tr>';
                                        
                                    }
                                
                            ?>
                        </tbody>
                    </table>
                        
                </div>
                 </form>   
            </div>
            
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

    <!-- Call this single function  (Data Table)-->
    <script>
        $(document).ready( function () {
        $('#tblcategory').DataTable();
    } );
        
    </script>

<?php
    
    include_once 'footer.php';

?>
