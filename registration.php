<?php
    
    include_once 'connectdb.php';
    session_start();
    if($_SESSION['useremail']=="" || $_SESSION['role']=='User'){
        header('location:index.php');
    }
    
    include_once 'header.php';
    error_reporting(0);
    $id = $_GET['id'];
    $delete = $pdo->prepare("delete from tbl_user where userid=".$id);
    if($delete->execute()){
         echo '
                        <script text="text/javascript">

                            jQuery(function validation(){

                                swal({
                                  title: "Delete Successful",
                                  text: "User Deleted Successfully",
                                  icon: "success",
                                  button: "Ok",
                                });

                            });

                        </script>
                    ';
    }
    
    if(isset($_POST['btnsave'])){
        $username = $_POST['txt_name'];
        $useremail = $_POST['txt_email'];
        $userpwd = $_POST['txt_password'];
        $userrole = $_POST['txt_selectoption'];
        //echo ' ...................................................................................................................... '.$username." - ".$useremail." - ".$userpwd." - ".$userrole;
        $select = $pdo->prepare("select * from tbl_user where useremail='$useremail'");
        $select->execute();
        if($select->rowCount()>0){
            echo '
                        <script text="text/javascript">

                            jQuery(function validation(){

                                swal({
                                  title: "Eamil Already Exist",
                                  text: "Your Email Id Already Present In Database",
                                  icon: "warning",
                                  button: "Ok",
                                });

                            });

                        </script>
                    ';
        }
        else{
            
            $insert = $pdo->prepare("insert into tbl_user(username,useremail,password,role) values(:uname,:uemail,:upwd,:urole)");
            $insert->bindParam(':uname',$username);
            $insert->bindParam(':uemail',$useremail);
            $insert->bindParam(':upwd',$userpwd);
            $insert->bindParam(':urole',$userrole);
            if($insert->execute()){
                echo '
                            <script text="text/javascript">

                                jQuery(function validation(){

                                    swal({
                                      title: "Save!!!",
                                      text: "Registration Successful",
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
                                      text: "Registration Unsuccessful",
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
        Registration
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
            <form role="form" action="" method="post">
            <div class="box-body">
                <div class="col-md-4">
                    <div class="form-group">
                  <label>User Name</label>
                  <input type="text" class="form-control"  placeholder="Enter User Name" name="txt_name" required>
                </div>
                <div class="form-group">
                  <label>User Email</label>
                  <input type="email" class="form-control"  placeholder="Enter User Email" name="txt_email" required>
                </div>
                    <div class="form-group">
                  <label>User Password</label>
                  <input type="password" class="form-control" placeholder="Enter Password" name="txt_password" required>
                </div>
                    <div class="form-group">
                  <label>Role</label>
                  <select class="form-control" name="txt_selectoption">
                    <option value="" disabled selected>Select User Role</option>
                    <option>User</option>
                    <option>Admin</option>
                  </select>
                </div>
                    <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="btnsave">Save</button>
              </div>
                </div>
                <div class="col-md-8">
                    <div style="overflow-x:auto">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>Password</th>
                                <th>Email Id</th>
                                <th>Role</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $select = $pdo->prepare("select * from tbl_user ORDER BY userid DESC");
                                $select->execute();
                                while($row = $select->fetch(PDO::FETCH_OBJ)){
                                    echo '<tr>
                                        <td>'.$row->userid.'</td>
                                        <td>'.$row->username.'</td>
                                        <td>'.$row->password.'</td>
                                        <td>'.$row->useremail.'</td>
                                        <td>'.$row->role.'</td>
                                        <td><a href="registration.php?id='.$row->userid.'" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-trash" title="delete"></span></a></td>
                                    </tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                        </div>
                </div>
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
