<?php
require('pdf/fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('../images/BusForAll-logo.jpg',5,0,50);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(50);
    // Title
    $this->Cell(50,10,'',0,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(45,10,'Passenger Name  ','0','L',false);
	$pdf->Cell(5,10,':','0','L',false);
	$pdf->SetFont('courier','',12);
	$pdf->Cell(0,10,$_POST['passname'],0,1);
	$pdf->LN(1);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(45,10,'Passenger IC  ','0','L',false);
	$pdf->Cell(5,10,':','0','L',false);
	$pdf->SetFont('courier','',12);
	$pdf->Cell(0,10,$_POST['passic'],0,1);
	$pdf->LN(1);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(45,10,'Passenger Phone  ','0','L',false);
	$pdf->Cell(5,10,':','0','L',false);
	$pdf->SetFont('courier','',12);
	$pdf->Cell(0,10,$_POST['passphone'],0,1);
	$pdf->LN(1);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(45,10,'Passenger Email  ','0','L',false);
	$pdf->Cell(5,10,':','0','L',false);
	$pdf->SetFont('courier','',12);
	$pdf->Cell(0,10,$_POST['passemail'],'0',1);
	$pdf->LN(10);
	$pdf->SetTextColor(128);
	$pdf->SetFillColor(200,220,255);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(45,10,'Company  ','LT','L',false);
	$pdf->Cell(5,10,':','T','L',false);
	$pdf->SetFont('courier','',12);
	$pdf->Cell(0,10,$_POST['passcomp'],'TR',1);
	$pdf->LN(0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(45,10,'Transaction ID  ','L','L',false);
	$pdf->Cell(5,10,':','0','L',false);
	$pdf->SetFont('courier','',12);
	$pdf->Cell(0,10,$_POST['passtrans'],'R',1);
	$pdf->LN(0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(45,10,'Route  ','L','L',false);
	$pdf->Cell(5,10,':','0','L',false);
	$pdf->SetFont('courier','',12);
	$pdf->Cell(0,10,$_POST['passrou'],'R',1);
	$pdf->LN(0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(45,10,'Depart Date/Time  ','L','L',false);
	$pdf->Cell(5,10,':','0','L',false);
	$pdf->SetFont('courier','',12);
	$pdf->Cell(0,10,$_POST['passdepart'],'R',1);
	$pdf->LN(0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(45,10,'Seat No.  ','L','L',false);
	$pdf->Cell(5,10,':','0','L',false);
	$pdf->SetFont('courier','',12);
	$pdf->Cell(0,10,$_POST['passseat'],'R',1);
	$pdf->LN(0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(45,10,'Platform  ','L','L',false);
	$pdf->Cell(5,10,':','0','L',false);
	$pdf->SetFont('courier','',12);
	$pdf->Cell(0,10,$_POST['passplatform'],'R',1);
	$pdf->LN(0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(45,10,'Ticket Price  ','LB','L',false);
	$pdf->Cell(5,10,':','B','L',false);
	$pdf->SetFont('courier','',12);
	$pdf->Cell(0,10,$_POST['passprice'],'BR',1);
	$pdf->LN(0);
$pdf->Output();
?>

?>