<?php
    
include_once 'connectdb.php';
session_start();    
if($_SESSION['useremail']==""){
        header('location:index.php');
    }
function fill_product($pdo,$id){
    $output = '';
    $select = $pdo->prepare("select * from tbl_product");
    $select->execute();
    $result = $select->fetchAll();
    foreach($result as $row){
        $output.='<option value="'.$row["pid"].'"';
        if($id==$row['pid']){
            $output.='selected';
        }
        $output.='>'.$row['pname'].'</option>';
    }
    return $output;
}

$id = $_GET['id'];
$select = $pdo->prepare("select * from tbl_invoice where invoice_id=".$id);
$select->execute();
$row = $select->fetch(PDO::FETCH_ASSOC);

    $customername = $row['customer_name'];
    $date = date('Y-m-d',strtotime($row['order_date']));
    $subtotal = $row['subtotal'];
    $tax = $row['tax'];
    $discount = $row['discount'];
    $total = $row['total'];
    $paid = $row['paid'];
    $due = $row['due'];
    $payment_type = $row['payment_type'];

$select = $pdo->prepare("select * from tbl_invoice_details where invoice_id=".$id);
$select->execute();
$row_inv_det = $select->fetchAll(PDO::FETCH_ASSOC);


if(isset($_POST['btnupdateorder'])){
    
    $txt_customername = $_POST['txt_cname'];
    $txt_date = date('Y-m-d',strtotime($_POST['orderdate']));
    $txt_subtotal = $_POST['txt_subtotal'];
    $txt_tax = $_POST['txt_tax'];
    $txt_discount = $_POST['txt_discount'];
    $txt_total = $_POST['txt_total'];
    $txt_paid = $_POST['txt_paid'];
    $txt_due = $_POST['txt_due'];
    $txt_payment_type = $_POST['rb'];
    
    $arr_pname = $_POST['productname'];
    $arr_pid = $_POST['productid'];
    $arr_stock = $_POST['stock'];
    $arr_price = $_POST['price'];
    $arr_qty = $_POST['qty'];
    $arr_tot = $_POST['total'];
    
    foreach($row_inv_det as $item_inv_det){
        
        $update_tbl_product = $pdo->prepare("update tbl_product set pstock=pstock+".$item_inv_det['qty']." where pid='".$item_inv_det['product_id']."'");
        $update_tbl_product->debugDumpParams();
        $update_tbl_product->execute();
        echo "<pre>";
        print_r($item_inv_det);
        
    }
    
    $delete_inv_det = $pdo->prepare("delete from tbl_invoice_details where invoice_id=".$id);
    $delete_inv_det->execute();
    
    
     $update_tbl_inv = $pdo->prepare("update tbl_invoice set customer_name=:cname,order_date=:odate,subtotal=:stotal,tax=:tax,discount=:disc,total=:tot,paid=:paid,due=:due,payment_type=:ptype where invoice_id=".$id);
     $update_tbl_inv->bindParam(':cname',$txt_customername);
     $update_tbl_inv->bindParam(':odate',$txt_date);
     $update_tbl_inv->bindParam(':stotal',$txt_subtotal);
     $update_tbl_inv->bindParam(':tax',$txt_tax);
     $update_tbl_inv->bindParam(':disc',$txt_discount);
     $update_tbl_inv->bindParam(':tot',$txt_total);
     $update_tbl_inv->bindParam(':paid',$txt_paid);
     $update_tbl_inv->bindParam(':due',$txt_due);
     $update_tbl_inv->bindParam(':ptype',$txt_payment_type);
     $update_tbl_inv->execute();
    
    $invoice_id = $pdo->lastInsertId();
    if(!empty(13)){
        
        for($i = 0; $i<count($arr_pname); $i++){
            
            $select_product = $pdo->prepare("select * from tbl_product where pid='".$arr_pid[$i]."'");
            $select_product->execute();
            while($rowpdt = $select_product->fetch(PDO::FETCH_OBJ)){
                $db_stock = $rowpdt->pstock;
                $rem_stock = $db_stock-$arr_qty[$i];
            if($rem_stock<0){
                echo 'Order Is Not Complete';
            }
            
            else{
                
                $update = $pdo->prepare("update tbl_product set pstock='$rem_stock' where pid='$arr_pid[$i]'");
                /*echo "<pre>";
                $update->debugDumpParams();*/
                $update->execute();
            }
                
                
            }
            
            
            $insert = $pdo->prepare("insert into tbl_invoice_details(invoice_id,product_id,product_name,qty,price,order_date)values(:inv_id,:pid,:pname,:qty,:pprice,:odate)");
            $insert->bindParam(':inv_id',$id);
            $insert->bindParam(':pid',$arr_pid[$i]);
            $insert->bindParam(':pname',$arr_pname[$i]);
            $insert->bindParam(':qty',$arr_qty[$i]);
            $insert->bindParam(':pprice',$arr_price[$i]);
            $insert->bindParam(':odate',$txt_date);
            /*echo "<pre>";
            $insert->debugDumpParams();*/
            $insert->execute();
        }
        
        header('location:orderlist.php');        
    }
    
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
        Edit Order
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
            <form action="" method="post">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Order</h3>
            </div>
            <div class="box-body"> <!-- This is for customer and date -->
                <div class="col-md-6">
                    <div class="form-group">
                  <label>Customer Name</label>
                    <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </div>
                  <input type="text" class="form-control"  value="<?php echo $customername ?>" name="txt_cname" required>
                        </div>
                </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                <label>Date:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker" name="orderdate" value="<?php echo $date ?>" data-date-format="yyyy-mm-dd">
                </div>
                <!-- /.input group -->
              </div>
                </div>
            </div>
            <div class="box-body"> <!-- This is for table -->
            
                <div class="col-md-12">
                    <div class="table-responsive">
                    <table id="tblproduct" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Search Product</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th>Enter Quantity</th>
                                <th>Total</th>
                                <th>
                                    <center><button type="button" name="add" class="btn btn-primary btn-sm btnadd"><span class="glyphicon glyphicon-plus"></span></button></center>
                                </th>
                            </tr>
                        </thead>
                        
                        <?php
                                            
                        foreach($row_inv_det as $item_inv_det){
                            $select = $pdo->prepare("select * from tbl_product where pid=".$item_inv_det['product_id']);
                            $select->execute();
                            $row_product = $select->fetch(PDO::FETCH_ASSOC);
    
                        ?>
                        <tr>
                        
                            <?php
                            
                                echo '<td><input type="hidden" class="form-control pname" name="productname[]" value="'.$row_product['pname'].'"readonly></td>';
                                echo '<td><select class="form-control productedit" name="productid[]" style="width:250px;" required><option value="">Select Product</option>'.fill_product($pdo,$item_inv_det['product_id']).'</select></td>';
                                echo '<td><input type="text" class="form-control stock" name="stock[]" value="'.$row_product['pstock'].'" readonly></td>';
                                echo '<td><input type="text" class="form-control price" name="price[]" value="'.$row_product['saleprice'].'" readonly></td>';
                                echo '<td><input type="number" min=1 class="form-control  qty" name="qty[]" value="'.$item_inv_det['qty'].'" required></td>';
                                echo '<td><input type="text" class="form-control total" name="total[]" value="'.$row_product['saleprice']*$item_inv_det['qty'].'" readonly></td>';
                               echo '<td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove"><span class="glyphicon glyphicon-remove"></span></button></center></td>';
                            
                            ?>
                        
                        </tr>
                        <?php } ?>
                    </table>
                    </div>
                </div>
        
            </div>
            <div class="box-body"> <!-- This is for tax,discount etc. -->
            
                <div class="col-md-6">
                    <div class="form-group">
                  <label>Sub Total</label>
                        <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-inr"></i>
                  </div>
                  <input type="text" class="form-control" name="txt_subtotal" value="<?php echo $subtotal ?>" id="txt_subtotal" required readonly>
                        </div>
                    </div>
                    <div class="form-group">
                  <label>Tax (5%)</label>
                       <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-inr"></i>
                  </div> 
                  <input type="text" class="form-control" name="txt_tax" id="txt_tax" value="<?php echo $tax ?>" required readonly>
                </div>
                    </div>
                    <div class="form-group">
                  <label>Discount</label>
                        <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-inr"></i>
                  </div>
                  <input type="text" class="form-control" name="txt_discount" value="<?php echo $discount ?>" id="txt_discount" required>
                </div>
                    </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                  <label>Total</label>
                    <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-inr"></i>
                  </div>
                  <input type="text" class="form-control" name="txt_total" value="<?php echo $total ?>" id="txt_total" required readonly>
                </div>
                    </div>
                    <div class="form-group">
                  <label>Paid</label>
                        <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-inr"></i>
                  </div>
                  <input type="text" class="form-control" name="txt_paid" value="<?php echo $paid ?>" id="txt_paid" required>
                </div>
                    </div>
                    <div class="form-group">
                  <label>Due</label>
                        <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-inr"></i>
                  </div>
                  <input type="text" class="form-control" name="txt_due" value="<?php echo $due ?>" id="txt_due" required readonly>
                </div>
                    </div>
                     <label>Payment Method</label>
                    <div class="form-group">
                <label>
                  <input type="radio" name="rb" class="minimal" checked value="Cash"<?php echo ($payment_type=='Cash')?'checked':'' ?>>
                    Cash
                </label>
                <label>
                  <input type="radio" name="rb" class="minimal" value="Debit Card" <?php echo ($payment_type=='Debit Card')?'checked':'' ?>>
                    Debit Card
                </label>
                <label>
                  <input type="radio" name="rb" class="minimal" value="Credit Card" <?php echo ($payment_type=='Credit Card')?'checked':'' ?>>
                  Credit Card
                </label>
                <label>
                  <input type="radio" name="rb" class="minimal" value="Cheque" <?php echo ($payment_type=='Cheque')?'checked':'' ?>>
                  Cheque
                </label>
              </div>
                </div>
                
            </div>
                <div class="box-footer">
                <center><button type="submit" class="btn btn-warning" name="btnupdateorder">Update Order</button></center>
              </div>
        </form>
        </div>
        

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
     //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
</script>
<script>

    
    
    /* This Code For Add Table After Clicking Add Button */   
    
    
    $(document).ready(function(){
        
            //Initialize Select2 Elements Plugin Inbuid In AdminLte
    $('.productedit').select2()
            
            
            
    /* This Code For Fill Details Asper Selector */   
            
            
            $('.productedit').on('change',function(e){
                var productid = this.value;
                var tr=$(this).parent().parent();
                $.ajax({
                    url:'getproduct.php',
                    method:'get',
                    data:{
                        id:productid
                    },
                    success:function(data){
                        //console.log(data);
                        tr.find(".pname").val(data["pname"]);
                        tr.find(".stock").val(data["pstock"]);
                        tr.find(".price").val(data["saleprice"]);
                        tr.find(".qty").val(1);
                        tr.find(".total").val(tr.find(".qty").val() * tr.find(".price").val());
                        
                        calculate(0,0);
                        $("#txt_paid").val("");// **********************Change**********************
                    }
                })
            })
        
        $(document).on('click','.btnadd',function(){
            var html = '';
            html+= '<tr>';
            html+= '<td><input type="hidden" class="form-control pname" name="productname[]" readonly></td>';
            html+= '<td><select class="form-control productid" name="productid[]" style="width:250px;" required><option value="">Select Product</option><?php echo fill_product($pdo,''); ?></select></td>';
            html+= '<td><input type="text" class="form-control stock" name="stock[]" readonly></td>';
            html+= '<td><input type="text" class="form-control price" name="price[]" readonly></td>';
            html+= '<td><input type="number" min=1 class="form-control  qty" name="qty[]" required></td>';
            html+= '<td><input type="text" class="form-control total" name="total[]" readonly></td>';
            html+= '<td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove"><span class="glyphicon glyphicon-remove"></span></button></center></td>';
            $('#tblproduct').append(html);
            
            
            
    /* End Of This Code */        
            
            
            
    //Initialize Select2 Elements Plugin Inbuid In AdminLte
    $('.productid').select2()
            
            
            
    /* This Code For Fill Details Asper Selector */   
            
            
            $('.productid').on('change',function(e){
                var productid = this.value;
                var tr=$(this).parent().parent();
                $.ajax({
                    url:'getproduct.php',
                    method:'get',
                    data:{
                        id:productid
                    },
                    success:function(data){
                        //console.log(data);
                        tr.find(".pname").val(data["pname"]);
                        tr.find(".stock").val(data["pstock"]);
                        tr.find(".price").val(data["saleprice"]);
                        tr.find(".qty").val(1);
                        tr.find(".total").val(tr.find(".qty").val() * tr.find(".price").val());
                        //
                        calculate(0,0);
                        $("#txt_paid").val("");// **********************Change**********************
                    }
                })
            })
            
        })
        
        
        /* End Of This Code */
        
        
        
        /* This Code For Button Remove */
        
        $(document).on('click','.btnremove',function(){
            $(this).closest('tr').remove();
            calculate(0,0);
            $("#txt_paid").val("");// **********************Change**********************
        })
        
        /* End Of This Code */
        
        
        
        
        /* This Code For Calculate Total As Per Quantiity Change  */
        
        $('#tblproduct').delegate(".qty","keyup change",function(){
            
            var quantity = $(this);
            var tr=$(this).parent().parent();
            $("#txt_paid").val("");// **********************Change**********************
            if((quantity.val()-0)>(tr.find(".stock").val()-0)){
               swal("Warning!!!","Sorry This Much Of Stock Unavailable","warning");
                quantity.val(1);
                tr.find(".total").val(quantity.val() * tr.find(".price").val());
                calculate(0,0);
            }
            else{
               tr.find(".total").val(quantity.val() * tr.find(".price").val());
                 calculate(0,0);
            }
            
        })
        /* End Of This Code */
        
        /* Function For Showing Value In Text Boxes like Subtotal, Tax, Discount, Total, Paid, Due */
        
        function calculate(dis,paid){
            
            var subtotal = 0;
            var tax = 0;
            var discount = dis;
            var net_total = 0;
            var paid_amt = paid;
            var due = 0;
            $(".total").each(function(){
                subtotal = subtotal+($(this).val()*1)
            })
            
            tax = 0.05*subtotal;
            net_total = subtotal+tax;
            net_total = net_total-discount;
            due = net_total-paid_amt;
            
            $("#txt_subtotal").val(subtotal.toFixed(2));
            $("#txt_tax").val(tax.toFixed(2));
            $("#txt_total").val(net_total.toFixed(2));
            $("#txt_discount").val(discount);
            $("#txt_due").val(due.toFixed(2));
            
            $("#txt_discount").keyup(function(){
                var discount = $(this).val();
                calculate(discount,0);
            })
            
            $("#txt_paid").keyup(function(){
                var paid = $(this).val();
                var discount = $("#txt_discount").val();
                calculate(discount,paid);
            })
        }
        
        /* End Of This Function */
        
    });

</script>
<?php
    
    include_once 'footer.php';

?>
