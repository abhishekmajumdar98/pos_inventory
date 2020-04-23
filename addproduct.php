<?php
    
    include_once 'connectdb.php';
    session_start();
if($_SESSION['useremail']=="" || $_SESSION['role']=='User'){
        header('location:index.php');
    }
    include_once 'header.php';
    if(isset($_POST['btnaddproduct'])){
        
        $productname = $_POST['txt_pname'];
        $productcat = $_POST['txt_selectoption'];
        $purchaseprice = $_POST['txt_pprice'];
        $saleprice = $_POST['txt_sprice'];
        $stock = $_POST['txt_stock'];
        $description = $_POST['txt_description'];
        $f_name = $_FILES['myfile']['name'];
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
            
            $insert = $pdo->prepare("insert into tbl_product(pname,pcategory,purchaseprice,saleprice,pstock,pdescription,pimage) values(:pname,:cat,:pprice,:sprice,:stock,:desc,:pimg)");
            $insert->bindParam(':pname',$productname);
            $insert->bindParam(':cat',$productcat);
            $insert->bindParam(':pprice',$purchaseprice);
            $insert->bindParam(':sprice',$saleprice);
            $insert->bindParam(':stock',$stock);
            $insert->bindParam(':desc',$description);
            $insert->bindParam(':pimg',$productimg);
            if($insert->execute()){
                
                echo '
                        <script text="text/javascript">

                            jQuery(function validation(){

                                swal({
                                  title: "Product Added",
                                  text: "Product Added Scuccesfully",
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
                                  text: "Product Not Added",
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
        Add Product
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
              <h3 class="box-title"><a href="productlist.php" class="btn btn-info" role="button">Back To Product List</a></h3>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
            <div class="box-body">
                
                <div class="col-md-6">
                    
                    <div class="form-group">
                  <label>Product Name</label>
                  <input type="text" class="form-control"  placeholder="Enter Product Name" name="txt_pname" required>
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
                    <option><?php echo $row->category ?></option>
                      <?php
                          }
                          ?>
                  </select>
                </div>
                    <div class="form-group">
                  <label>Purchase Price</label>
                  <input type="number" min=1 step=1 class="form-control"  placeholder="Enter Purchase Price" name="txt_pprice" required>
                </div>
                    <div class="form-group">
                  <label>Sale Price</label>
                  <input type="number" min=1 step=1 class="form-control"  placeholder="Enter Sale Price" name="txt_sprice" required>
                </div>
                </div>
                
                <div class="col-md-6">
                     
                    <div class="form-group">
                  <label>Stock</label>
                  <input type="number" min=1 step=1 class="form-control"  placeholder="Enter Total Stock" name="txt_stock" required>
                </div>
                    <div class="form-group">
                        <label>Product Description</label>
                        <textarea name="txt_description" class="form-control" placeholder="Enter Product Description" rows=4></textarea>
                    </div>
                    <div class="form-group">
                        <label>Product Image</label>
                        <input type="file" class="input-group" name="myfile" required>
                    </div>
                
                </div>
            
            </div>
                <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="btnaddproduct">Add Product</button>
              </div>
                </form>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
    
    include_once 'footer.php';

?>
