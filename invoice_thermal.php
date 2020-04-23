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
$pdf = new FPDF('P','mm',array(80,200));

//Add Page
$pdf->AddPage();

$pdf->SetFont('Courier','B',16);
$pdf->Cell(60,8,'Rishikesh Tech.',1,1,'C');

/*$pdf->SetFont('Arial','B',8);*/
/*$pdf->Cell(60,5,'INVOICE',0,1,'C');*/

$pdf->SetFont('Courier','B',8);
$pdf->Cell(60,5,'Nuruddin Road Bye Lane, Asansol - 03',0,1,'C');
$pdf->Cell(60,5,'Contact Number - 7001916946',0,1,'C');
$pdf->Cell(60,5,'Email - abhishek@rishikeshtechnologies.com',0,1,'C');
$pdf->Cell(60,5,'Website - www.rishikeshtechnologies.com',0,1,'C');

$pdf->Line(7,38,72,38);

$pdf->Ln(1);//For Break The Line

$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,4,'Bill To - ',0,0,'');
$pdf->Cell(40,4,$row->customer_name,0,1,'');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,4,'Invoice No - ',0,0,'');
$pdf->Cell(40,4,$row->invoice_id,0,1,'');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,4,'Date - ',0,0,'');
$pdf->Cell(40,4,$row->order_date,0,1,'');


$pdf->SetFillColor(208,208,208);
$pdf->SetX(7);
$pdf->SetFont('Courier','B',8);
$pdf->Cell(34,5,'PRODUCT',1,0,'C',true);
$pdf->Cell(8,5,'QTY',1,0,'C',true);
$pdf->Cell(11,5,'PRICE',1,0,'C',true);
$pdf->Cell(12,5,'TOTAL',1,1,'C',true);

$select = $pdo->prepare('select * from tbl_invoice_details where invoice_id='.$id);
$select->execute();
while($item = $select->fetch(PDO::FETCH_OBJ)){
    $pdf->SetX(7);
    $pdf->SetFont('Courier','',8);
    $pdf->Cell(34,5,$item->product_name,1,0,'C');
    $pdf->Cell(8,5,$item->qty,1,0,'C');
    $pdf->Cell(11,5,$item->price,1,0,'C');
    $pdf->Cell(12,5,$item->qty*$item->price,1,1,'C');
    
}





$pdf->SetX(7);
$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,5,'',0,0,'L');
/*$pdf->Cell(20,5,'',0,0,'C');*/
$pdf->Cell(25,5,'Sub Total',1,0,'C',true);
$pdf->Cell(20,5,$row->subtotal,1,1,'C');

$pdf->SetX(7);
$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,5,'',0,0,'L');
/*$pdf->Cell(20,5,'',0,0,'C');*/
$pdf->Cell(25,5,'Tax(5%)',1,0,'C',true);
$pdf->Cell(20,5,$row->tax,1,1,'C');

$pdf->SetX(7);
$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,5,'',0,0,'L');
/*$pdf->Cell(20,5,'',0,0,'C');*/
$pdf->Cell(25,5,'Discount',1,0,'C',true);
$pdf->Cell(20,5,$row->discount,1,1,'C');

$pdf->SetX(7);
$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,5,'',0,0,'L');
/*$pdf->Cell(20,5,'',0,0,'C');*/
$pdf->Cell(25,5,'Grand Total',1,0,'C',true);
$pdf->Cell(20,5,$row->total,1,1,'C');

$pdf->SetX(7);
$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,5,'',0,0,'L');
/*$pdf->Cell(20,5,'',0,0,'C');*/
$pdf->Cell(25,5,'Paid Amt',1,0,'C',true);
$pdf->Cell(20,5,$row->paid,1,1,'C');

$pdf->SetX(7);
$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,5,'',0,0,'L');
/*$pdf->Cell(20,5,'',0,0,'C');*/
$pdf->Cell(25,5,'Due Amt',1,0,'C',true);
$pdf->Cell(20,5,$row->due,1,1,'C');

$pdf->SetX(7);
$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,5,'',0,0,'L');
/*$pdf->Cell(20,5,'',0,0,'C');*/
$pdf->Cell(25,5,'Payment Type',1,0,'C',true);
$pdf->Cell(20,5,$row->payment_type,1,1,'C');


$pdf->Output();
?>