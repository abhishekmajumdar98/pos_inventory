<?php
    
include_once 'connectdb.php';
session_start();   
$id = 10;
$select = $pdo->prepare("select * from tbl_invoice_details where invoice_id=".$id);
$select->execute();
$row_inv_det = $select->fetchAll(PDO::FETCH_ASSOC);
echo '<pre>';
print_r($row_inv_det);
?>