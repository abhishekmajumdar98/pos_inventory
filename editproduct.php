<?php
    
    include_once 'connectdb.php';
    session_start();
if($_SESSION['useremail']=="" || $_SESSION['role']=='User'){
        header('location:index.php');
    }
    include_once 'header.php';
    $id = $_GET['id'];
$select = $pdo->prepare("select * from tbl_product where pid=".$id);
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);
$id_db = $row->pid;
$pname_db = $row->pname;
$pcat_db = $row->pcategory;
$pprice_db = $row->purchaseprice;
$sprice_db = $row->saleprice;
$pstock_db = $row->pstock;
$pdesc_db = $row->pdescription;
$pimg_db = $row->pimage;

if(isset($_POST['btnupdateproduct'])){
        
        $productname = $_POST['txt_pname'];
        $productcat = $_POST['txt_selectoption'];
        $purchaseprice = $_POST['txt_pprice'];
        $saleprice = $_POST['txt_sprice'];
        $stock = $_POST['txt_stock'];
        $description = $_POST['txt_description'];
        $f_name = $_FILES['myfile']['name'];
        if(!empty($f_name)){
            
            
            $f_tmp = $_FILES['myfile']['tmp_name'];
        $f_size = $_FILES['myfile']['size'];
        $f_extension = explode('.',$f_name);
        $f_extension = strtolower(end($f_extension));
        $f_newfile = uniqid().'.'.$f_extension;
        $store = "productimage/".$f_newfile;
        if($f_extension=='jpg' || $f_extension=='jpeg' || $f_extension=='png' || $f_extension=='gif'){
            if($f_size >= 1000000){
                
                
                $error =  '
                        <script text="text/javascript">

                            jQuery(function validation(){

                                swal({
                                  title: "Error!!!",
                                  text: "Max file should be 1MB",
                                  icon: "error",
                                  button: "Ok",
                                });

                            });

                        </script>
                    ';
                echo $error;
            }
            else{
                if(move_uploaded_file($f_tmp,$store)){
                    
                    $productimg = $f_newfile;
                    
                }
            }
        }
        else{
            $error =  '
                        <script text="text/javascript">

                            jQuery(function validation(){

                                swal({
                                  title: "Error!!!",
                                  text: "Only jpg,jpeg,png or gif file can be uploaded",
                                  icon: "error",
                                  button: "Ok",
                                });

                            });

                        </script>
                    ';
            echo $error;
        }
        if(!isset($error)){
            $update = $pdo->prepare("update tbl_product set pname=:pname,pcategory=:pcat,purchaseprice=:pprice,saleprice=:sprice,pstock=:pstock,pdescription=:pdesc,pimage=:pimg where pid=".$id);
            $update->bindParam(':pname',$productname);
            $update->bindParam(':pcat',$productcat);
            $update->bindParam(':pprice',$purchaseprice);
            $update->bindParam(':sprice',$saleprice);
            $update->bindParam(':pstock',$stock);
            $update->bindParam(':pdesc',$description);
            $update->bindParam(':pimg',$productimg);
            if($update->execute()){
                
                 echo '
                        <script text="text/javascript">

                            jQuery(function validation(){

                                swal({
                                  title: "Product Update",
                                  text: "Product Updated Scuccesfully",
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
                                  title: "Error!!!",
                                  text: "Product Update Fail",
                                  icon: "error",
                                  button: "Ok",
                                });

                            });

                        </script>
                    ';
                
            }
            
        }
            
            
            
        }
        else{
            
            $update = $pdo->prepare("update tbl_product set pname=:pname,pcategory=:pcat,purchaseprice=:pprice,saleprice=:sprice,pstock=:pstock,pdescription=:pdesc,pimage=:pimg where pid=".$id);
            $update->bindParam(':pname',$productname);
            $update->bindParam(':pcat',$productcat);
            $update->bindParam(':pprice',$purchaseprice);
            $update->bindParam(':sprice',$saleprice);
            $update->bindParam(':pstock',$stock);
            $update->bindParam(':pdesc',$description);
            $update->bindParam(':pimg',$pimg_db);
            if($update->execute()){
                
                 echo '
                        <script text="text/javascript">

                            jQuery(function validation(){

                                swal({
                                  title: "Product Update",
                                  text: "Product Updated Scuccesfully",
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
                                  title: "Error!!!",
                                  text: "Product Update Fail",
                                  icon: "error",
                                  button: "Ok",
                                });

                            });

                        </script>
                    ';
                
            }
            
        }
}

?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Product
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
              <h3 class="box-title">Product Update Form</h3>
            </div>
            <div class="box-body">
        
        <form action="" method="post" enctype="multipart/form-data">
            <div class="box-body">
                
                <div class="col-md-6">
                    
                    <div class="form-group">
                  <label>Product Name</label>
                  <input type="text" class="form-control" value="<?php echo $pname_db  ?>" name="txt_pname" required>
                </div>
                    <div class="form-group">
                  <label>Category</label>
                  <select class="form-control" name="txt_selectoption">
                    <option value="" disabled selected>Select Product Category</option>
                    <?php
                        
                      $select = $pdo->prepare("select * from tbl_category");
                      $select->execute();
                      while($row = $select->fetch(PDO::FETCH_OBJ)){
                      
                      ?>
                    <option <?php if($row->category == $pcat_db){ ?> selected="selected"<?php } ?>><?php echo $row->category ?></option>
                      <?php
                          }
                          ?>
                  </select>
                </div>
                    <div class="form-group">
                  <label>Purchase Price</label>
                  <input type="number" min=1 step=1 class="form-control" value="<?php echo $pprice_db  ?>" name="txt_pprice"required>
                </div>
                    <div class="form-group">
                  <label>Sale Price</label>
                  <input type="number" min=1 step=1 class="form-control" value="<?php echo $sprice_db  ?>" name="txt_sprice" required>
                </div>
                </div>
                
                <div class="col-md-6">
                     
                    <div class="form-group">
                  <label>Stock</label>
                  <input type="number" min=1 step=1 class="form-control"  value="<?php echo $pstock_db  ?>" name="txt_stock" required>
                </div>
                    <div class="form-group">
                        <label>Product Description</label>
                        <textarea name="txt_description" class="form-control" rows=4><?php echo $pdesc_db  ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Product Image</label>
                        <img src="productimage/<?php echo $pimg_db ?>" class="img-responsive" width="60px" height="60px">
                        <input type="file" class="input-group" name="myfile">
                    </div>
                
                </div>
            
            </div>
                <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="btnupdateproduct">Update Product</button>
              </div>
                </form>
        </div>
        </div>
        

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
    
    include_once 'footer.php';

?>
