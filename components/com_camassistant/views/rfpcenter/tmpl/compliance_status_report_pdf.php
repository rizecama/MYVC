<?php

/**
 * @version		1.0.0 camassistant $
 * @package		camassistant
 * @copyright	Copyright © 2010 - All rights reserved.
 * @license		GNU/GPL
 * @author
 * @author mail	nobody@nobody.com
 *
 *
 * @MVC architecture generated by MVC generator tool at http://www.alphaplug.com
 */
// no direct access
	defined('_JEXEC') or die('Restricted access');
	require_once('libraries/tcpdf/config/lang/eng.php');
	require_once('libraries/tcpdf/tcpdf.php');
	ini_set('zlib.output_compression','Off');
	$COM =  $this->message;
	//print_r($COM); exit;


	class MYPDF extends TCPDF {

	// Page footer
	public function Footer() {
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Page number
		$this->SetFontSize(8);
			if($this->pageno){
		//$page=(int)$this->getAliasNumPage();
		//$this->Cell(208, 0, 'Vendor Compliance Status ', 0, 2, 'C');
}$this->pageno=$this->pageno+1;
		$this->SetFontSize(7);
		$this->Cell(0, 5, 'Copyright 2014-2015 HOA Assistant, LLC', 0, 0, 'C');
	}

	public function Header() {
		// Position at 1.5 cm from top
		$this->SetY(-15);
	}
}
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator(PDF_CREATOR);
	// set default header data
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	//set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	//set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	//$pdf->SetDrawColor(204, 204, 204);
	//set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	//set some language-dependent strings
	$pdf->setLanguageArray($l);

	//$pdf->SetFont('dejavusans', '', 10);// set font
	//$pdf->AddPage(); // add a page
	// Your custom code here
	JHTML::_('behavior.modal');
	// create new PDF document
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	// set font
	//$pdf->SetFont('dejavusans', '', 12);
	//Image Quality
	$pdf->setJPEGQuality(200);
	// add a page
	//echo $this->count_enable; exit;
	if( $this->count_enable <= '4' )
	$pdf->AddPage();
	else
	$pdf->AddPage('L');
	
	$today = date('m-d-Y H:i:s');
	$today_explode = explode(' ',$today);
				
	$htmlcontent = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td>';
  //$pdf->Image('/var/www/vhosts/myvendorcenter.com/httpdocs/templates/camassistant_left/images/myvc_status.png', 0, 2, 250, 30, "", "", "", true, 550,'', false, false, 0, false, false, false);
  if( $this->message ) {
  $htmlcontent .= '</td></tr>
    </table><span style="font-size:28px;">Please find the list of your Vendors below and their compliance status as of <strong>'.date("h:i A", strtotime($today_explode[1])).'</strong> on <strong>'.$today_explode[0].'</strong>. Note: this list is determined by the Vendors that you have manually added to be included on your "My Vendors" list ("Corporate Preferred Vendors" list for Master Account holder). You can view this list by logging into your MyVendorCenter account and clicking on "Vendor Lists" ("Preferred Vendors" for Master Account holder)</span><br /><br />';
		}
		else{
		$htmlcontent .= '</td></tr>
    </table><br /><br /><br /><br />You have not added any Vendors to your <strong>"Corporate Preferred"</strong> or <strong>"My Vendors"</strong> list.<br /><br />';
		}
		
	$htmlcontent .= $this->message;
		
	$style7 = array('width' => 0.1, 'color' => array(220, 220, 220));
	$pdf->SetLineStyle($style7);
			
	$pdf->writeHTML($htmlcontent, true, 0, true, 0);
	

	$pdf->lastPage();
	$title= 'compliancereports.pdf'; //set title
	$pdf->SetTitle($title);//set title

	ob_end_clean();
	$upl_file_name=$pdf->Output($title, 'FI');
	//$upl_file_name=$pdf->Output($title, 'D');
?>