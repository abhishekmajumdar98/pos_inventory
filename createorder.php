<?php
    
include_once 'connectdb.php';
session_start();    
if($_SESSION['useremail']==""){
        header('location:index.php');
    }
function fill_product($pdo){
    $output = '';
    $select = $pdo->prepare("select * from tbl_product");
    $select->execute();
    $result = $select->fetchAll();
    foreach($result as $row){
        $output.='<option value="'.$row["pid"].'">'.$row["pname"].'</option>';
    }
    return $output;
}

if(isset($_POST['btnsaveorder'])){
    
    $customername = $_POST['txt_cname'];
    $date = date('Y-m-d',strtotime($_POST['orderdate']));
    $subtotal = $_POST['txt_subtotal'];
    $tax = $_POST['txt_tax'];
    $discount = $_POST['txt_discount'];
    $total = $_POST['txt_total'];
    $paid = $_POST['txt_paid'];
    $due = $_POST['txt_due'];
    $payment_type = $_POST['rb'];
    
    $arr_pname = $_POST['productname'];
    $arr_pid = $_POST['productid'];
    $arr_stock = $_POST['stock'];
    $arr_price = $_POST['price'];
    $arr_qty = $_POST['qty'];
    $arr_tot = $_POST['total'];
    
    $insert = $pdo->prepare("insert into tbl_invoice(customer_name,order_date,subtotal,tax,discount,total,paid,due,payment_type)values(:cname,:odate,:stotal,:tax,:disc,:tot,:paid,:due,:ptype)");
    $insert->bindParam(':cname',$customername);
    $insert->bindParam(':odate',$date);
    $insert->bindParam(':stotal',$subtotal);
    $insert->bindParam(':tax',$tax);
    $insert->bindParam(':disc',$discount);
    $insert->bindParam(':tot',$total);
    $insert->bindParam(':paid',$paid);
    $insert->bindParam(':due',$due);
    $insert->bindParam(':ptype',$payment_type);
    $insert->execute();
    
    $invoice_id = $pdo->lastInsertId();
    if(!empty($invoice_id)){
        
        for($i = 0; $i<count($arr_pname); $i++){
            
            $rem_stock = $arr_stock[$i]-$arr_qty[$i];
            if($rem_stock<0){
                echo 'Order Is Not Complete';
            }
            else{
                
                $update = $pdo->prepare("update tbl_product set pstock='$rem_stock' where pid='$arr_pid[$i]'");
                $update->execute();
            }
            
            $insert = $pdo->prepare("insert into tbl_invoice_details(invoice_id,product_id,product_name,qty,price,order_date)values(:inv_id,:pid,:pname,:qty,:pprice,:odate)");
            $insert->bindParam(':inv_id',$invoice_id);
            $insert->bindParam(':pid',$arr_pid[$i]);
            $insert->bindParam(':pname',$arr_pname[$i]);
            $insert->bindParam(':qty',$arr_qty[$i]);
            $insert->bindParam(':pprice',$arr_price[$i]);
            $insert->bindParam(':odate',$date);
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
        Create Order
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
              <h3 class="box-title">New Order Form</h3>
            </div>
            <div class="box-body"> <!-- This is for customer and date -->
                <div class="col-md-6">
                    <div class="form-group">
                  <label>Customer Name</label>
                    <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </div>
                  <input type="text" class="form-control"  placeholder="Enter Customer Name" name="txt_cname" required>
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
                  <input type="text" class="form-control pull-right" id="datepicker" name="orderdate" value="<?php echo date('Y-m-d') ?>" data-date-format="yyyy-mm-dd">
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
                                    <center><button type="button" name="add" class="btn btn-success btn-sm btnadd"><span class="glyphicon glyphicon-plus"></span></button></center>
                                </th>
                            </tr>
                        </thead>
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
                  <input type="text" class="form-control" name="txt_subtotal" id="txt_subtotal" required readonly>
                        </div>
                    </div>
                    <div class="form-group">
                  <label>Tax (5%)</label>
                       <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-inr"></i>
                  </div> 
                  <input type="text" class="form-control" name="txt_tax" id="txt_tax" required readonly>
                </div>
                    </div>
                    <div class="form-group">
                  <label>Discount</label>
                        <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-inr"></i>
                  </div>
                  <input type="text" class="form-control" name="txt_discount" id="txt_discount" required>
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
                  <input type="text" class="form-control" name="txt_total" id="txt_total" required readonly>
                </div>
                    </div>
                    <div class="form-group">
                  <label>Paid</label>
                        <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-inr"></i>
                  </div>
                  <input type="text" class="form-control" name="txt_paid" id="txt_paid" required>
                </div>
                    </div>
                    <div class="form-group">
                  <label>Due</label>
                        <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-inr"></i>
                  </div>
                  <input type="text" class="form-control" name="txt_due" id="txt_due" required readonly>
                </div>
                    </div>
                     <label>Payment Method</label>
                    <div class="form-group">
                <label>
                  <input type="radio" name="rb" class="minimal" checked value="Cash">
                    Cash
                </label>
                <label>
                  <input type="radio" name="rb" class="minimal" value="Debit Card">
                    Debit Card
                </label>
                <label>
                  <input type="radio" name="rb" class="minimal" value="Credit Card">
                  Credit Card
                </label>
                <label>
                  <input type="radio" name="rb" class="minimal" value="Cheque">
                  Cheque
                </label>
              </div>
                </div>
                
            </div>
                <div class="box-footer">
                <center><button type="submit" class="btn btn-info" name="btnsaveorder">Save Order</button></center>
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
        $(document).on('click','.btnadd',function(){
            var html = '';
            html+= '<tr>';
            html+= '<td><input type="hidden" class="form-control pname" name="productname[]" readonly></td>';
            html+= '<td><select class="form-control productid" name="productid[]" style="width:250px;" required><option value="">Select Product</option><?php echo fill_product($pdo); ?></select></td>';
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
                        calculate(0,0);
                    }
                })
            })
            
        })
        
        
        /* End Of This Code */
        
        
        
        /* This Code For Button Remove */
        
        $(document).on('click','.btnremove',function(){
            $(this).closest('tr').remove();
            calculate(0,0);
            $("#txt_paid").val(0);
        })
        
        /* End Of This Code */
        
        
        
        
        /* This Code For Calculate Total As Per Quantiity Change  */
        
        $('#tblproduct').delegate(".qty","keyup change",function(){
            
            var quantity = $(this);
            var tr=$(this).parent().parent();
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
