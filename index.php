
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<!-- Sweet Alert -->
<script src="bower_components/sweetalert/sweetalert.js"></script>

<?php
    include_once 'connectdb.php';
    session_start();
    //error_reporting(0);
    if(isset($_POST['btnlogin'])){
        
        $user_email = $_POST['txtemail'];
        $user_password = $_POST['txtpwd'];
        $select = $pdo->prepare("select * from tbl_user where useremail='$user_email' AND password='$user_password'");
        $select->execute();
        $row = $select->fetch(PDO::FETCH_ASSOC);
        $u_email = $row['useremail'] ?? null;
        $u_password = $row['password'] ?? null;
        $u_role = $row['role'] ?? null;
        
        if($u_email==$user_email && $u_password==$user_password && $u_role=='Admin'){
            
            
            $_SESSION['userid']=$row['userid'];
            $_SESSION['username']=$row['username'];
            $_SESSION['useremail']=$row['useremail'];
            $_SESSION['role']=$row['role'];
            
            echo '
                
                <script text="text/javascript">
                    
                    jQuery(function validation(){
                    
                        swal({
                          title: "Successfully Login",
                          text: "Your Details Are Matched",
                          icon: "success",
                          button: "Log in.....",
                        });

                    });
                    
                </script>
            ';
            header('refresh:1;dashboard.php');
            
        }
        else if($u_email==$user_email && $u_password==$user_password && $u_role=='User'){
            
            $_SESSION['userid']=$row['userid'];
            $_SESSION['username']=$row['username'];
            $_SESSION['useremail']=$row['useremail'];
            $_SESSION['role']=$row['role'];
            
             echo '
                
                <script text="text/javascript">
                    
                    jQuery(function validation(){
                    
                        swal({
                          title: "Successfully Login",
                          text: "Your Details Are Matched",
                          icon: "success",
                          button: "Log in.....",
                        });

                    });
                    
                </script>
            ';
            header('refresh:1;user.php');
        }
        else{
            
            echo '
                
                <script text="text/javascript">
                    
                    jQuery(function validation(){
                    
                        swal({
                          title: "Access Denied",
                          text: "Your Email Or Password Are Not Matched",
                          icon: "error",
                          button: "Ok",
                        });

                    });
                    
                </script>
            ';
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>POS | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>POS</b>INVENTORY</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="txtemail" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="txtpwd" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
               <a href="#" onclick="swal('To Recover Your Password','Please Contact With Your Admin','warning')">I forgot my password</a><br> 
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" name="btnlogin">Log In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <!-- /.social-auth-links -->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
