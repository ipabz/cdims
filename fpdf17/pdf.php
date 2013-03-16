<?php
class PDF extends FPDF
{

	var $title;

	// Page header
	function Header()
	{
	
		// Arial bold 15
		$this->SetFont('Arial','B',18);
		// Move to the right
		$this->Cell(80);
		// Title
		$this->Cell(30,10,$this->title,0,0,'C');
		// Line break
		$this->Ln(6);
		$this->Cell(82);
		$this->SetFont('Arial','',14);
		$this->Cell(30,10,'Inventory Report',0,0,'C');
		
		$this->Ln(5);
		$this->Cell(82);
		$this->SetFont('Arial','',10);
		$this->Cell(30,10, date('F d, Y'),0,0,'C');
		
		$this->Ln(20);
	}

	// Load data
	function LoadData($file)
	{
		// Read file lines
		$lines = file($file);
		$data = array();
		foreach($lines as $line)
			$data[] = explode(';',trim($line));
		return $data;
	}
	
	// Simple table
	function BasicTable($header, $data)
	{
		// Header
		foreach($header as $col)
			$this->Cell(40,7,$col,1);
		$this->Ln();
		// Data
		foreach($data as $row)
		{
			foreach($row as $col)
				$this->Cell(40,6,$col,1);
			$this->Ln();
		}
	}
	
	// Better table
	function ImprovedTableHeader($header, $data)
	{
		
		// Colors, line width and bold font
		//$this->SetFillColor(255,223,0);
		//$this->SetTextColor(255);
		//$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.1);
		
		$this->SetFont('Arial','B',11);
		$this->SetFillColor(239,239,239);
		// Column widths
		$w = array(8, 35, 50, 35, 35, 30);
		// Header
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],7,$header[$i],1,0,'C', TRUE);
		$this->Ln();
		
		$this->SetFillColor(248,248,248);
		$this->SetTextColor(0);
		$this->SetFont('Arial','',9);
		// Data
		$fill = false;
		foreach($data as $row)
		{
			$this->Cell($w[0],6,$row[0],1,0,'L',$fill);
			$this->Cell($w[1],6,$row[1],1,0,'L',$fill);
			$this->Cell($w[2],6,$row[2],1,0,'L',$fill);
			$this->Cell($w[3],6,$row[3],1,0,'L',$fill);
			$this->Cell($w[4],6,$row[4],1,0,'L',$fill);
			$this->Cell($w[5],6,$row[5],1,0,'L',$fill);
			$this->Ln();
			$fill = !$fill;
		}
		// Closing line
		$this->Cell(array_sum($w),0,'','T');
	}
	
	// Better table
	function ImprovedTable($header, $data)
	{
	
		$this->SetFont('Times','',10);
		
		/*
		// Column widths
		$w = array(5, 35, 50, 35, 35, 30);
		// Header
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],7,$header[$i],1,0,'C');
		$this->Ln();
		*/
		// Data
		foreach($data as $row)
		{
			$this->Cell($w[0],6,$row[0],1);
			$this->Cell($w[1],6,$row[1],1);
			$this->Cell($w[2],6,$row[2],1);
			$this->Cell($w[3],6,$row[3],1);
			$this->Cell($w[4],6,$row[4],1);
			$this->Cell($w[5],6,$row[5],1);
			$this->Ln();
		}
		// Closing line
		$this->Cell(array_sum($w),0,'','T');
	}
	
	// Colored table
	function FancyTable($header, $data)
	{
		// Colors, line width and bold font
		$this->SetFillColor(255,0,0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('','B');
		// Header
		$w = array(40, 35, 40, 45);
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Data
		$fill = false;
		foreach($data as $row)
		{
			$this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
			$this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
			$this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
			$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
			$this->Ln();
			$fill = !$fill;
		}
		// Closing line
		$this->Cell(array_sum($w),0,'','T');
	}
}
?>