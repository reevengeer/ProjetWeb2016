<?php

require '../../lib/php/dbConnectProjetLocal.php';
require '../../lib/php/classes/Connexion.class.php';
require '../../lib/php/classes/dvdBD.class.php';

$cnx = Connexion::getInstance($dsn,$user,$password);

$DVD = new dvdBD($cnx);
$liste = $DVD->tousLesDVD();
$nbr=count($liste);

require ('../../lib/php/fpdf/fpdf.php');

$pdf = new FPDF('P','cm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->SetDrawColor(96,123,139);
$pdf->SetFillColor(96,123,139);
$pdf->SetTextColor(255,255,255);
$pdf->SetXY(3, 1);
$pdf->Cell(16,1,'Liste des films disponibles chez nous',1,1,'C',1);

$pdf->SetDrawColor(0, 0 ,0);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',13);
$pdf->SetXY(2.5, 4);
$x = 2.5;$y = 2.5;

    $pdf->SetTextColor(255,99,71);
    $pdf->SetXY($x+0.5,$y);
    $pdf->Cell(16,1,"Titre du film",0,1,'L',1);
    $pdf->SetXY(9,$y);
    $pdf->Cell(16,1,"Realisateur du film",0,1,'L',1);
    $pdf->SetXY(15,$y);
    $pdf->Cell(16,1,"Image du film",0,1,'L',1);
    $y+=1.3;
  
$pdf->SetTextColor(0,0,0);

for($i=0;$i<$nbr;$i++)
{
    $image1 = $liste[$i]['image_dvd'];
    
    $image = "../../images/".$image1;
    
    $pdf->SetXY(3,$y);
    $pdf->Cell(16,2.25,$liste[$i]['titre'],0,1,'L',1);
    $pdf->SetXY(9,$y);
    $pdf->Cell(16,2.25,$liste[$i]['realisateur'],0,1,'L',1);
    $pdf->SetXY(15,$y);
    $pdf->Cell( 16,0, $pdf->Image($image, $pdf->GetX(), $pdf->GetY(),4,2.25), 0, 1, 'L', 1 );
    $y+=3;
}
$pdf->Output();
?>