<?php
    
    include_once 'connectdb.php';
    session_start();
    if($_SESSION['useremail']==""){
        header('location:index.php');
    }
    if($_SESSION['role'] == 'Admin'){
        include_once 'header.php';
    }
    else{
        include_once 'headeruser.php';
    }
    if(isset($_POST['btnupdate'])){
        
        $oldpwd = $_POST['txtoldpass'];
        $newpwd = $_POST['txtnewpass'];
        $confpwd = $_POST['txtconfpass'];
        $email = $_SESSION['useremail'];
        $select = $pdo->prepare("select * from tbl_user where useremail='$email'");
        $select->execute();
        $row = $select->fetch(PDO::FETCH_ASSOC);
        $current = $row['password'] ?? null;
        
        if($oldpwd == $current){
            //echo ".............................................................................................................................".$oldpwd." - ".$current;
            if($newpwd == $confpwd){
                //echo ".............................................................................................................................".$newpwd." - ".$confpwd;
                $update = $pdo->prepare("update tbl_user set password=:pwd where useremail=:email");
                $update->bindParam(':pwd',$confpwd);
                $update->bindParam(':email',$email);
                if($update->execute()){
                    echo '
                        <script text="text/javascript">

                            jQuery(function validation(){

                                swal({
                                  title: "Password Update Successful",
                                  text: "Your Password Updated",
                                  icon: "success",
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
                                  title: "New and Confirm Password Not Matched",
                                  text: "Please Enter Same Password",
                                  icon: "warning",
                                  button: "Ok",
                                });

                            });

                        </script>
                    ';
            }
        }
        else{
            //echo ".............................................................................................................................".$oldpwd." - ".$current;
            echo '
                        <script text="text/javascript">

                            jQuery(function validation(){

                                swal({
                                  title: "Old Password Not Matched",
                                  text: "Please Enter Your Valid Password",
                                  icon: "warning",
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
        Change Password
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
              <h3 class="box-title">Change Password</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputPassword1">Old Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtoldpass" required>
                </div>
                  <div class="form-group">
                  <label for="exampleInputPassword1">New Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtnewpass" required>
                </div>
                  <div class="form-group">
                  <label for="exampleInputPassword1">Confirm Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtconfpass" required>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="btnupdate">Update</button>
              </div>
            </form>
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
    
    include_once 'footer.php';

?>
