<?php

//Add Fpdf library
require("fpdf/fpdf.php");

include_once 'connectdb.php';

$id = $_GET['id'];
$select = $pdo->prepare('select * from tbl_invoice where invoice_id='.$id);
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

/*create an object named $pdf and we can pass 3 parameters that are

    String orientation like P or L (Portrait and Landscape)
    String Unit like mm,pt etc
    Paper Format like A4,A3 etc

*/
$pdf = new FPDF('P','mm','A4');

//Add Page
$pdf->AddPage();


$pdf->SetFont('Arial','B',16);
$pdf->Cell(80,10,'Rishikesh Technologies',0,0,'');

$pdf->SetFont('Arial','B',13);
$pdf->Cell(112,10,'INVOICE',0,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,'Address - Nuruddin Road Bye Lane, Asansol - 03',0,0,'');

$pdf->SetFont('Arial','',10);
$pdf->Cell(112,5,'Invoice - '.$row->invoice_id,0,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,'Contact Number - 7001916946',0,0,'');

$pdf->SetFont('Arial','',10);
$pdf->Cell(112,5,'Date - '.$row->order_date,0,1,'C');



$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,'Email - abhishek@rishikeshtechnologies.com',0,1,'');
$pdf->Cell(80,5,'Website - www.rishikeshtechnologies.com',0,1,'');

$pdf->Line(5,45,205,45);

$pdf->Ln(10);//For Break The Line

$pdf->SetFont('Courier','B',12);
$pdf->Cell(20,10,'Bill To: ',0,0,'');

$pdf->SetFont('Courier','',13);
$pdf->Cell(50,10,$row->customer_name,0,1,'');
$pdf->Cell(50,5,' ',0,1,'');

$pdf->SetFont('Courier','B',12);
$pdf->SetFillColor(208,208,208);
$pdf->Cell(100,10,'PRODUCT',1,0,'C',true);
$pdf->Cell(20,10,'QTY',1,0,'C',true);
$pdf->Cell(30,10,'PRICE',1,0,'C',true);
$pdf->Cell(40,10,'TOTAL',1,1,'C',true);

$select = $pdo->prepare('select * from tbl_invoice_details where invoice_id='.$id);
$select->execute();
while($item = $select->fetch(PDO::FETCH_OBJ)){
    $pdf->SetFont('Courier','',12);
    $pdf->Cell(100,10,$item->product_name,1,0,'C');
    $pdf->Cell(20,10,$item->qty,1,0,'C');
    $pdf->Cell(30,10,$item->price,1,0,'C');
    $pdf->Cell(40,10,$item->qty*$item->price,1,1,'C');
    
}




$pdf->SetFont('Courier','',10);
$pdf->Cell(100,10,'',0,0,'C');
$pdf->Cell(20,10,'',0,0,'C');
$pdf->Cell(30,10,'Sub Total',1,0,'C',true);
$pdf->Cell(40,10,$row->subtotal,1,1,'C');

$pdf->SetFont('Courier','',10);
$pdf->Cell(100,10,'',0,0,'C');
$pdf->Cell(20,10,'',0,0,'C');
$pdf->Cell(30,10,'Tax(5%)',1,0,'C',true);
$pdf->Cell(40,10,$row->tax,1,1,'C');

$pdf->SetFont('Courier','',10);
$pdf->Cell(100,10,'',0,0,'C');
$pdf->Cell(20,10,'',0,0,'C');
$pdf->Cell(30,10,'Discount',1,0,'C',true);
$pdf->Cell(40,10,$row->discount,1,1,'C');

$pdf->SetFont('Courier','',10);
$pdf->Cell(100,10,'',0,0,'C');
$pdf->Cell(20,10,'',0,0,'C');
$pdf->Cell(30,10,'Grand Total',1,0,'C',true);
$pdf->Cell(40,10,$row->total,1,1,'C');

$pdf->SetFont('Courier','',10);
$pdf->Cell(100,10,'',0,0,'C');
$pdf->Cell(20,10,'',0,0,'C');
$pdf->Cell(30,10,'Paid Amt',1,0,'C',true);
$pdf->Cell(40,10,$row->paid,1,1,'C');

$pdf->SetFont('Courier','',10);
$pdf->Cell(100,10,'',0,0,'C');
$pdf->Cell(20,10,'',0,0,'C');
$pdf->Cell(30,10,'Due Amt',1,0,'C',true);
$pdf->Cell(40,10,$row->due,1,1,'C');

$pdf->SetFont('Courier','',10);
$pdf->Cell(100,10,'',0,0,'C');
$pdf->Cell(20,10,'',0,0,'C');
$pdf->Cell(30,10,'Payment Type',1,0,'C',true);
$pdf->Cell(40,10,$row->payment_type,1,1,'C');
//Output
$pdf->Output();

?>