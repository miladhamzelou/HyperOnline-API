<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

require_once(dirname(__FILE__).'tcpdf/tcpdf.php');
//require(app_path() . '\Common\tcpdf\tcpdf.php');

class MYPDF extends TCPDF
{

    // Load table data from file
    public function LoadData($file)
    {
        // Read file lines
        $lines = file($file);
        $data = array();
        foreach ($lines as $line) {
            $data[] = explode('-', chop($line));
        }
        return $data;
    }

    // Colored table
    public function ColoredTable($header, $data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_language'] = 'fa';
        $lg['a_meta_dir'] = 'rtl';
        $lg['w_page'] = 'page';
        $this->setLanguageArray($lg);
        $this->SetFont('sans', 'B');
        // Header
        $w = array(40, 35, 40, 45);
        $num_headers = count($header);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('sans');
        // Data
        $fill = 0;
        $total = 0;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'C', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'C', $fill);
            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'C', $fill);
            $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'C', $fill);
            $this->Ln();
            $fill = !$fill;
            $total += intval($row[3]);
        }
        $this->Cell(array_sum($w), 0, '', 'T');
        $this->Ln();
        $htmlpersian = 'مجموع خرید شما ' . number_format($total) . ' تومان می باشد.';
        $this->writeHTML($htmlpersian, true, 0, true, 0);
    }
}