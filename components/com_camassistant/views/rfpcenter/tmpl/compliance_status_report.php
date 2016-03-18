<?php
$vendor_data = $this->message;
$docs_permission= $this->docs_permission;
define( '_JEXEC', 1 );
define( 'DS', DIRECTORY_SEPARATOR );
require_once ( JPATH_BASE .DS.'Classes'.DS.'PHPExcel.php' );
require_once ( JPATH_BASE .DS.'Classes'.DS.'PHPExcel'.DS.'IOFactory.php' );
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
		 $i = 1;
		 $j = 2;
			
		foreach($vendor_data as $key=>$value){
		   
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $key);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$j, 'Company');
			
			$char = '66'; //(Ascii value of B)
			
			if( $docs_permission->phone_number == '1' ) {
    				$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$j, 'Phone');
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

            $count = count($value);
			$i = $i + $count + 2;
			$k = $j+1;
			for($last=0; $last<count($value); $last++){
				$exp = explode('MYVC',$value[$last]);
				if($value[$last]){
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
						$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$k, $exp[11]);
						$char++;
					}
					if( $docs_permission->gli == '1' || $docs_permission->how_docs == 'all') {
						if (strpos($exp[3], 'red') !== FALSE)
					   	{
							$exp[3] = str_replace('red','',$exp[3]);  
							$objPHPExcel->getActiveSheet()->getStyle(chr($char).$k)->applyFromArray($redStyleArray);							
					   	}
			    			$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$k, $exp[3]);					
						$char++;
					}
		
					if( $docs_permission->api == '1' || $docs_permission->how_docs == 'all') {
						if (strpos($exp[4], 'red') !== FALSE)
					   	{
							$exp[4] = str_replace('red','',$exp[4]);  
							$objPHPExcel->getActiveSheet()->getStyle(chr($char).$k)->applyFromArray($redStyleArray);
					   	}
			    			$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$k, $exp[4]);
						$char++;
					}

					if( $docs_permission->wc == '1' || $docs_permission->how_docs == 'all') {
						if (strpos($exp[5], 'red') !== FALSE)
					   	{
							$exp[5] = str_replace('red','',$exp[5]);  
							$objPHPExcel->getActiveSheet()->getStyle(chr($char).$k)->applyFromArray($redStyleArray);
					   	}
			    			$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$k, $exp[5]);
						$char++;
					}

					if( $docs_permission->umb == '1' || $docs_permission->how_docs == 'all') {
						if (strpos($exp[6], 'red') !== FALSE)
					   	{
							$exp[6] = str_replace('red','',$exp[6]);  
							$objPHPExcel->getActiveSheet()->getStyle(chr($char).$k)->applyFromArray($redStyleArray);
					   	}
		    				$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$k, $exp[6]);
						$char++;
					}

					if( $docs_permission->omi == '1' || $docs_permission->how_docs == 'all') {
						if (strpos($exp[7], 'red') !== FALSE)
					   	{
							$exp[7] = str_replace('red','',$exp[7]);  
							$objPHPExcel->getActiveSheet()->getStyle(chr($char).$k)->applyFromArray($redStyleArray);
					   	}
			    			$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$k, $exp[7]);
						$char++;				
					}

					if( $docs_permission->pln == '1' || $docs_permission->how_docs == 'all') {
						if (strpos($exp[9], 'red') !== FALSE)
					   	{
							$exp[9] = str_replace('red','',$exp[9]);  
							$objPHPExcel->getActiveSheet()->getStyle(chr($char).$k)->applyFromArray($redStyleArray);
					   	}
			    			$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$k, $exp[9]);
						$char++;
					}

					if( $docs_permission->oln == '1' || $docs_permission->how_docs == 'all') {
						if (strpos($exp[8], 'red') !== FALSE)
					   	{
							$exp[8] = str_replace('red','',$exp[8]);  
							$objPHPExcel->getActiveSheet()->getStyle(chr($char).$k)->applyFromArray($redStyleArray);
					   	}
			    			$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$k, $exp[8]);
						$char++;
					}
					if (strpos($exp[0], 'red') !== FALSE)
				   	{
						$exp[0] = str_replace('red','',$exp[0]);  
						$objPHPExcel->getActiveSheet()->getStyle(chr($char).$k)->applyFromArray($redStyleArray);
				   	} else if (strpos($exp[0], 'green') !== FALSE) {
						$exp[0] = str_replace('green','',$exp[0]);  
						$objPHPExcel->getActiveSheet()->getStyle(chr($char).$k)->applyFromArray($greenStyleArray);
					   	
					}
					$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$k, $exp[0]);
					$char++;
					if (strpos($exp[1], 'red') !== FALSE)
				   	{
						$exp[1] = str_replace('red','',$exp[1]);  
						$objPHPExcel->getActiveSheet()->getStyle(chr($char).$k)->applyFromArray($redStyleArray);
				   	} else if (strpos($exp[1], 'green') !== FALSE) {
						$exp[1] = str_replace('green','',$exp[1]);  
						$objPHPExcel->getActiveSheet()->getStyle(chr($char).$k)->applyFromArray($greenStyleArray);
					   	
					}
			   		$objPHPExcel->getActiveSheet()->setCellValue(chr($char).$k, $exp[1]);

			   		$k++;			
					}				
				}
				$i++;
			$j = $i+1;
		}

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$title = 'compliancereports.xlsx'; //set title
		$objWriter->save(str_replace(__FILE__, '/var/www/vhosts/myvendorcenter.com/httpdocs/components/com_camassistant/assets/compliance_reports/'.$title ,__FILE__));
		header('Location: http://myvendorcenter.com/components/com_camassistant/assets/compliance_reports/compliancereports.xlsx');
	
?>
