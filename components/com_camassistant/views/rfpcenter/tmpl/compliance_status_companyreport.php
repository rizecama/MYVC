<?php
$vendor_data = $this->message;
//echo '<pre>';print_r($vendor_data);exit;
$docs_permission= $this->docs_permission;
define( '_JEXEC', 1 );
define( 'DS', DIRECTORY_SEPARATOR );
require_once ( JPATH_BASE .DS.'Classes'.DS.'PHPExcel.php' );
require_once ( JPATH_BASE .DS.'Classes'.DS.'PHPExcel'.DS.'IOFactory.php' );
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);		
			
	foreach($vendor_data as $key=>$value){
		for($cn=0; $cn<count($value); $cn++){
			$cname = explode('MYVC',$value[$cn]);
			$vendor_companies[] = substr($cname[2],0,1);
			
		}
	}
	$vcompanynames[] = array_unique($vendor_companies);
	foreach( $vcompanynames as $vdd ) { 
		foreach( $vdd as $vddele ) { 
			$newvcompanynames[] = $vddele;
		}
	}
		
 	$i = 1;
	$j = 2;
	foreach( $newvcompanynames as $vdds ) {	   

		$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $vdds);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$j, 'Company');
		
		$char = '66'; //(Ascii value of B)
		
		if( $docs_permission->phone_number == '1' ) {
			$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$j, 'Phone');
			$char++;
		}
		if( $docs_permission->w9 == '1' || $docs_permission->how_docs == 'all') {
			$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$j, 'W9');
			$char++;
		}
		if( $docs_permission->gli == '1' || $docs_permission->how_docs == 'all') {
			$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$j, 'GL');
			$char++;
		}
	
		if( $docs_permission->api == '1' || $docs_permission->how_docs == 'all') {
			$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$j, 'Auto');
			$char++;
		}

		if( $docs_permission->wc == '1' || $docs_permission->how_docs == 'all') {
			$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$j, 'WC');
			$char++;
		}

		if( $docs_permission->umb == '1' || $docs_permission->how_docs == 'all') {
			$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$j, 'Umbrella');
			$char++;
		}

		if( $docs_permission->omi == '1' || $docs_permission->how_docs == 'all') {
			$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$j, 'E & O');
			$char++;				
		}

		if( $docs_permission->pln == '1' || $docs_permission->how_docs == 'all') {
			$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$j, 'Prof. Lic');
			$char++;
		}

		if( $docs_permission->oln == '1' || $docs_permission->how_docs == 'all') {
			$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$j, 'Occ Lic');
			$char++;
		}

		$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$j, 'Comp Status');
		$char++;
   		$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$j, 'Acc Type');
    
	  	foreach($vendor_data as $key=>$value){          
		
			for($last=0; $last<=0; $last++){
		    
		    	

				$exp = explode('MYVC',$value[$last]);

				if ($value[$last]) {

					if ( $vdds == 	substr($exp[2],0,1) ) {
						$k = $j+1;
						$redStyleArray = array(
						    'font'  => array(
							'color' => array('rgb' => 'FF0022'),
					    	));
						$greenStyleArray = array(
						    'font'  => array(
							'color' => array('rgb' => '00FF52'),
					    	));
					
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$k, $exp[2]);
				
						$char = '66'; //(Ascii value of B)
				
						if( $docs_permission->phone_number == '1' ) {
							$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$k, $exp[12]);
							$char++;
						}
						if( $docs_permission->w9 == '1' || $docs_permission->how_docs == 'all') {
							
			    			$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$k, $exp[11]);				
							$char++;
						}
						if( $docs_permission->gli == '1' || $docs_permission->how_docs == 'all') {
							if (strpos($exp[3], 'red') !== FALSE) {
								$exp[3] = str_replace('red','',$exp[3]);  
								$objPHPExcel->getActiveSheet()->getStyle(chr($char).$k)->applyFromArray($redStyleArray);							
						   	}
			    			$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$k, $exp[3]);
							$char++;
						}			
						if( $docs_permission->api == '1' || $docs_permission->how_docs == 'all') {
							if (strpos($exp[4], 'red') !== FALSE) {
								$exp[4] = str_replace('red','',$exp[4]);  
								$objPHPExcel->getActiveSheet()->getStyle(chr($char).$k)->applyFromArray($redStyleArray);
						   	}
			    			$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$k, $exp[4]);
							$char++;
						}

						if( $docs_permission->wc == '1' || $docs_permission->how_docs == 'all') {
							if (strpos($exp[5], 'red') !== FALSE) {
								$exp[5] = str_replace('red','',$exp[5]);  
								$objPHPExcel->getActiveSheet()->getStyle(chr($char).$k)->applyFromArray($redStyleArray);
						   	}
			    			$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$k, $exp[5]);
							$char++;
						}

						if( $docs_permission->umb == '1' || $docs_permission->how_docs == 'all') {
							if (strpos($exp[6], 'red') !== FALSE) {
								$exp[6] = str_replace('red','',$exp[6]);  
								$objPHPExcel->getActiveSheet()->getStyle(chr($char).$k)->applyFromArray($redStyleArray);
						   	}
		    				$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$k, $exp[6]);
							$char++;
						}

						if( $docs_permission->omi == '1' || $docs_permission->how_docs == 'all') {
							if (strpos($exp[7], 'red') !== FALSE) {
								$exp[7] = str_replace('red','',$exp[7]);  
								$objPHPExcel->getActiveSheet()->getStyle(chr($char).$k)->applyFromArray($redStyleArray);
						   	}
			    			$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$k, $exp[7]);
							$char++;				
						}

						if( $docs_permission->pln == '1' || $docs_permission->how_docs == 'all') {
							if (strpos($exp[9], 'red') !== FALSE) {
								$exp[9] = str_replace('red','',$exp[9]);  
								$objPHPExcel->getActiveSheet()->getStyle(chr($char).$k)->applyFromArray($redStyleArray);
						   	}
				    			$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$k, $exp[9]);
							$char++;
						}

						if( $docs_permission->oln == '1' || $docs_permission->how_docs == 'all') {
							if (strpos($exp[8], 'red') !== FALSE) {
								$exp[8] = str_replace('red','',$exp[8]);  
								$objPHPExcel->getActiveSheet()->getStyle(chr($char).$k)->applyFromArray($redStyleArray);
						   	}
				    			$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$k, $exp[8]);
							$char++;
						}
						if (strpos($exp[0], 'red') !== FALSE) {
							$exp[0] = str_replace('red','',$exp[0]);  
							$objPHPExcel->getActiveSheet()->getStyle(chr($char).$k)->applyFromArray($redStyleArray);
					   	} else if (strpos($exp[0], 'green') !== FALSE) {
							$exp[0] = str_replace('green','',$exp[0]);  
							$objPHPExcel->getActiveSheet()->getStyle(chr($char).$k)->applyFromArray($greenStyleArray);
						   	
						}
						$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$k, $exp[0]);
						$char++;
						if (strpos($exp[1], 'red') !== FALSE) {
							$exp[1] = str_replace('red','',$exp[1]);  
							$objPHPExcel->getActiveSheet()->getStyle(chr($char).$k)->applyFromArray($redStyleArray);
					   	} else if (strpos($exp[1], 'green') !== FALSE) {
							$exp[1] = str_replace('green','',$exp[1]);  
							$objPHPExcel->getActiveSheet()->getStyle(chr($char).$k)->applyFromArray($greenStyleArray);
						   	
						}
				   		$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$k, $exp[1]);
		   				$k++;
		   				$i = $k;
		  			    $j = $i+1;			
					}
					
				}				
		 
			}
		
		}
		//$i++;
		//$j = $i+1;
	}
    $sendmail = JRequest::getVar('send');
	$today = date('m-d-Y H:i:s');
	$today_explode = explode(' ',$today);
	$path =   $_SERVER['DOCUMENT_ROOT'].'/creports';
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save(str_replace(__FILE__,$path.'/compliancereports.xls',__FILE__));
	if( $sendmail == 'mail' ){
		$user	= JFactory::getUser();
		$body =  $this->reportmessage;
		$body = str_replace('[USER FULL NAME]',$user->name.'&nbsp;'.$user->lastname,$body);
		$body = str_replace('[TIME]',date("h:i A", strtotime($today_explode[1])),$body);
		$body = str_replace('[DATE]',$today_explode[0],$body);
		$mailfrom = 'support@myvendorcenter.com';
		$from = 'MyVendorCenter';
		$to = $user->email;
		//$to = "rize.cama@gmail.com";
		$subject = 'Compliance Report Status';
		//$body = 'Please find the attachment for compliance status report.';
		$attachment = "/var/www/vhosts/myvendorcenter.com/httpdocs/creports/compliancereports.xlsx";
		JUtility::sendMail($mailfrom, $from, $to, $subject, $body, $mode=1, $cc=null, $bcc=null, $attachment, $replyto=null, $replytoname=null);
		header('Location: index.php?option=com_camassistant&controller=rfpcenter&task=compliance_status_report_webpage');
		}
	else
	{
	
	header('Location: /creports/compliancereports.xls');
	}
?>
