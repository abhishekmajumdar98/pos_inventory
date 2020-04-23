<?php
    
    include_once 'connectdb.php';
    
    
    $user_email = 'webdevabhi4@gmail.co';
    $user_password = 'Abhishek@2020';
    $select = $pdo->prepare("select * from tbl_user where useremail='$user_email' AND password='$user_password'");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC);
    $role = $row['role'];
    if($role == 'Admin'){
        echo 'Hi Admin';
    }
    else{
        echo 'You r a fraud';
    }
    
    
    
    
    
    
    

?>