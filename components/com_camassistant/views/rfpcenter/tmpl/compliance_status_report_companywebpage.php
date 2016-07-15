<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Profacts Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="components/com_camassistant/assets/piechart_html/piechart.css">
    <link rel="stylesheet" href="templates/camassistant_left/css/style_piechart.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
    <!--[if lt IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

<?php
$count_enable = $this->count_enable; 
//echo '<pre>'; print_r($count_enable); echo '</pre>';exit;
if( $count_enable->documenttype  == '0'){ ?>
<form name="documenttype" id="documenttype" method="post">
<input type="hidden" value="com_camassistant" name="option" />
<input type="hidden" value="rfpcenter" name="controller" />
<?php
?>
<input type="hidden" value="compliance_status_companyreport_pdf" name="task" />
<?php
$link = '1';
$download_email = 'index.php?option=com_camassistant&controller=rfpcenter&task=compliance_status_companyreport_pdf&send=mail';
}
else{
$download = 'index.php?option=com_camassistant&controller=rfpcenter&task=compliance_status_companyreport';
$link = '0';
$download_email = 'index.php?option=com_camassistant&controller=rfpcenter&task=compliance_status_companyreport&send=mail';
}
?>
<script type="text/javascript">
P = jQuery.noConflict();
function refersh()
	{
	location.reload();
	}
function downloadpdf()
	{
	type = '<?php echo $download;?>';
	
	linkstatus = '<?php echo $link;?>';
	if(linkstatus == '1')
	 { 
	P('#documenttype').submit(); 
	P(document).ready(function (){
	P("#loading-div-background").show();
      });
	  }
	else
	window.location  = type;
	
	}
function sendemail()
	{
	type = '<?php echo $download_email;?>';
	window.location  = type;
	}


function PrintDiv() {
//var divToPrint = document.getElementById('vender_right2');
window.print();
//setTimeout(function () { window.close(); }, 100);
				
}
</script>

</head>
<?php
$db = Jfactory::getDBO();
$user = Jfactory::getUser();
$manager_logo = "SELECT comp_logopath FROM #__cam_customer_companyinfo where cust_id ='".$user->id."'";
$db->Setquery($manager_logo);
$manager_logo = $db->loadResult();
?>
<body>
    <!-- header -->
    <header role="banner">
	<div class="socialicons"><ul><a href="javascript:void(0)"; title="Download"; onclick="downloadpdf()";><li><i class="material-icons">file_download</i></li></a><a href="javascript:void(0)"; title="E-mail"onclick="sendemail()";><li><i class="material-icons">email</i></li></a><a title="Print" href="javascript:PrintDiv();"><li><i class="material-icons">print</i></li></a><a  title="Refersh" href="javascript:refersh()";><li><i class="material-icons">refresh</i></li></a></ul></div>
        <div id="vender_right2">   
		<div class="wrapper">
            <div class="logos">
                <div class="top-logo"><img src="templates/camassistant_left/piechart_images/my-vc-logo.png" alt="MyVenderCenter" /></div>
                <div class="bottom-logo"><img src="templates/camassistant_left/piechart_images/profacts-logo.svg" alt="Profacts" /></div>
                <div class="logo-slogan">Your exclusive Vendor Compliance Report</div>
				
            </div>
            <div class="misc-logo-container">
                <div class="misc-logo">
               	<img width="170" height="172" src="components/com_camassistant/assets/images/properymanager/<?php echo $manager_logo;?>">
				 </div>
            </div>
        </div>
		 
    </header>
    <!-- /header -->
 
<?php

$today = date('m-d-Y H:i:s');
$today_explode = explode(' ',$today);
$items = $this->items;
$vendor_data =  $this->message;

$totalvendors = count($items);	
$noncomp = 0;
$comp = 0;
for( $pv=0; $pv<count($items); $pv++ )
{
if( $items[$pv]->final_status == 'fail' || $items[$pv]->final_status == 'medium' )
 $noncomp++;
if($items[$pv]->final_status == 'success')
 $comp++;
}


?>
  
    <!-- .compliance-report-summary -->
    <div class="compliance-report-summary">
        <div class="wrapper">
            <div class="disclaimer">
                <p>Please find the list of your Vendors below and their compliance status as of <strong id="current-time"><?php echo date("h:i A", strtotime($today_explode[1])); ?></strong> on <strong id="current-date"><?php echo $today_explode[0];?></strong>.</p></br>
                <p>Note: this list is determined by the Vendors that you have manually added to be included on your "My Vendors" list ("Corporate Preferred Vendors" list for Master Account holder). You can view this list by logging into your MyVendorCenter account and clicking on "Vendor Lists" ("Preferred Vendors" for Master Account holder)</p>
            </div>
            <div class="compliance-overview">
                <div class="stats">
                    <!-- Do NOT modify this code unless you know what you're doing! -->
                    <div id="pieChart" class="chart"></div>
                    <!-- The code above is generating the pie chart. Modify the values in the script block at the bototm of this file. -->
                    <div class="number-of-vendors-in-compliance">
                        <h3>Vendor Compliance Overview</h3>
                        <div class="number-compliants"><span></span> Compliant: <strong id="num-comp"><?php echo $comp;?></strong></div>
                        <div class="number-non-compliants"><span></span> Non-Compliant: <strong id="num-non-comp"><?php echo $noncomp;?></strong></div>
                        <div class="numer-total-vendors">Total Vendors: <strong id="total-vendors"><?php echo $totalvendors;?></strong></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.compliance-report-summary -->
    
    <!-- #main -->
    <div id="main">
	<?php
	//echo '<pre>';print_r($vendor_data);exit;
	foreach($vendor_data as $key=>$value){
		for($cn=0; $cn<count($value); $cn++){
			$cname = explode('MYVC',$value[$cn]);
			$vendor_companies[] = substr($cname[2],0,1);
			
		}
	}
	$vcompanynames[] = array_unique($vendor_companies);
//	echo "<pre>"; print_r($vcompanynames);exit;
	
  foreach( $vcompanynames as $vdd ) { 
	 foreach( $vdd as $vddele ) { 
	 	$newvcompanynames[] = $vddele;
	 }
  }
  
// echo "<pre>"; print_r($newvcompanynames);exit;
	 
 foreach( $newvcompanynames as $vdds ) { 
	
	?>
	
	<h2 class="vender-category-title"><span class="category-key"><?php echo $vdds; ?></span></h2>
	<?php
	foreach($vendor_data as $key=>$value){
	?>
       <?php 
	    $count = count($value) ;
			for($last=0; $last<=0; $last++){
				$exp = explode('MYVC',$value[$last]);
				//echo '<pre>';print_r($exp);exit;
				if($value[$last]){
				
		if ( $vdds == 	substr($exp[2],0,1) )
		{	
	      ?>
        <!-- Company Information & Compliance Status -->
		<?php 
		if( $count_enable->how_docs == 'all' || ($count_enable->w9 == 1 || $count_enable->gli == 1 || $count_enable->api == 1 || $count_enable->umb == 1 || $count_enable->wc == 1 || $count_enable->omi == 1 || $count_enable->pln == 1 || $count_enable->oln == 1 )){
			$add_class = '';
			$vertical_middle = '';
			}
		else{
		$add_class = 'noinfo';	
		$vertical_middle = 'vertical_middle';
		}
		?>
					
        <div class="company <?php echo $add_class; ?>">
            <div class="wrapper">

                <!-- .company-information -->
                <div class="company-information">
                    <ul>
					<?php
					if( $exp[1] == 'Verified')
					$vendortype = 'in-compliance current';
					else
					$vendortype = 'compliance noncurrent';
					?>
					
					  <?php 
					  if ( $exp[0] == 'Non-Compliant')
					          $vendortype_c = 'compliance noncurrent';
					  else
							$vendortype_c = 'in-compliance current';
					    ?>
						
					<?php 
					if( $count_enable->how_docs == 'all' || ($count_enable->w9 == 1 || $count_enable->gli == 1 || $count_enable->api == 1 || $count_enable->umb == 1 || $count_enable->wc == 1 || $count_enable->omi == 1 || $count_enable->pln == 1 || $count_enable->oln == 1 ))
						$display_ind = '';
					else
						$display_ind = 'none';	
					?>
					<?php if( $count_enable->phone_number == '1' )
							$display_phone = '';
							else
							$display_phone = 'none';
							?>
                       <li class="company-address <?php echo $vertical_middle; ?>">
                        <span class="company-name"><?php echo $exp[2];?></span><br>
                        <div style="display:<?php echo $display_phone; ?>">
						<span class="address1"><?php echo $exp[13];?></span><br>
                            <span class="city"><?php echo $exp[14];?></span>, <span class="state"><?php echo $exp[16];?></span>, <span class="zipcode"><?php echo $exp[15];?></span></div>    
                        </li>
						
                          <li class="company-contact" style="display:<?php echo $display_phone; ?>">
                            <p><strong>Contact:</strong></p>
                            <span class="contact"><?php echo $exp[17];?></span><br>
                          <span class="contact-phone" ><?php echo $exp[12];?></span>
                        </li>
						<?php  $display_phone = ""; ?>
                        <li class="company-compliance-status <?php echo $vertical_middle; ?>" style="display:<?php echo $display_ind; ?>">
                           <div class="<?php echo $vendortype_c ;?>"><span class="nondoctype"><?php echo $exp[0];?></span></div>
                            <span class="not-in-compliance">Non Compliant</span>
							
                            <div class="<?php echo $vendortype ;?>"><span class="doctype"><?php echo $exp[1];?>&nbsp;Documents</span></div>
                            <span class="not-in-compliance">Non Compliant</span>
                           </li>
                    </ul>
                </div>
                <!-- /.company-information -->

                <!-- .company-compliances -->
                <div class="company-compliances">

                    <!-- .compliance category column -->
                 	 <?php 
					 if ( $exp[11] == "Provided" )
				 	       $type = 'passed';
					else
				 	   $type = 'unknown';
				    ?>
					<?php 
					if( $count_enable->how_docs == 'all' )
						$display_w9 = '';
					else if( $count_enable->include_docs == '1' && $count_enable->w9 == '1' )
						$display_w9 = '';
					else
						$display_w9 = 'none';	
					?>
					
					<?php 
					if( $count_enable->how_docs == 'all' || ($count_enable->w9 == 1 || $count_enable->gli == 1 || $count_enable->api == 1 || $count_enable->umb == 1 || $count_enable->wc == 1 || $count_enable->omi == 1 || $count_enable->pln == 1 || $count_enable->oln == 1 ))
						$display_cont = 'none';
					
					else
						$display_cont = '';	
					?>
					 <?php 
					  if ( $exp[0] == 'Non-Compliant')
					          $vendortype_c = 'compliance noncurrent';
					  else
							$vendortype_c = 'in-compliance current';
					    ?>
			   <ul class="compliance-category-column">
                        <li data-category="w9" class="compliance <?php echo $type;?>" style="display:<?php echo $display_w9; ?>">
                           <div class="icon">Compliant</div>
                            <div class="compliance-category">
                                <span class="compliance-category-title">W9</span>
                                <span class="compliance-date"><?php echo $exp[11];?></span>
                            </div>
                        </li>
						 <li class="company-compliance-status <?php echo $vertical_middle; ?>" style="display:<?php echo $display_cont; ?>">
                           <div class="<?php echo $vendortype_c ;?>"><span class="nondoctype"><?php echo $exp[0];?></span></div>
                           </li>
						   
						   <?php $display_cont = ""; 
						   $display_w9 = '';
						   $vendortype_c ='';
						   ?>
                  
				<?php 
					$exp_w = explode('/',$exp[5]);
					$exp_w = $exp_w[2].'/'.$exp_w[0].'/'.$exp_w[1];
					if( $exp[5] == 'None' )
						$worktype = 'unknown';
					else if( $exp[5] == 'Does Not Expire' )
						$worktype = 'passed';
					else if( $exp_w < date ('Y/m/d')) 
				     	$worktype = 'failed';
					else
						$worktype = 'passed';
				   ?>
					
					<?php 
					if( $count_enable->how_docs == 'all' )
						$display_wc = '';
					else if( $count_enable->include_docs == '1' && $count_enable->wc == '1' )
						$display_wc = '';
					else
						$display_wc = 'none';	
					?>
                        <li data-category="work-comp" class="compliance  <?php echo $worktype; ?>" style="display:<?php echo $display_wc; ?>">
                           <div class="icon">Compliant</div>
                            <div class="compliance-category">
                                <span class="compliance-category-title">Worker's Comp</span>
                                <span class="compliance-date"><?php echo $exp[5];?></span>
                            </div>
                        </li>
						<?php $display_wc = ""; ?>
					
						
					<?php 
					$exp_p = explode('/',$exp[9]);
					$exp_p = $exp_p[2].'/'.$exp_p[0].'/'.$exp_p[1];
					if( $exp[9] == 'None' )
						$plnype = 'unknown';
					else if( $exp_p < date ('Y/m/d')) 
						$plnype = 'failed';
					else
					   $plnype = 'passed';
					?>
					
					<?php 
					if( $count_enable->how_docs == 'all' )
						$display_pln = '';
					else if( $count_enable->include_docs == '1' && $count_enable->pln == '1' )
						$display_pln = '';
					else
						$display_pln = 'none';	
					?>
						<li data-category="prof-lic" class="compliance <?php echo $plnype; ?>" style="display:<?php echo $display_pln; ?>">
                              <div class="icon">Compliant</div>
                            <div class="compliance-category">
                                <span class="compliance-category-title">Professional License</span>
                                <span class="compliance-date"><?php echo $exp[9]; ?></span>
                            </div>
                        </li>
						<?php $display_pln = "" ;?>
					
                    </ul>
                    <!-- /.compliance category column -->

                    <!-- .compliance category column -->
                  
					<ul class="compliance-category-column">
					
				<?php 
					$exp_g = explode('/',$exp[3]);
					$exp_g = $exp_g[2].'/'.$exp_g[0].'/'.$exp_g[1];
					if( $exp[3] == 'None' )
					   $glitype = 'unknown';
					else if( $exp_g < date ('Y/m/d')) 
				    	$glitype = 'failed';
					else
					     $glitype = 'passed';
					
					?>
					<?php 
					if( $count_enable->how_docs == 'all' )
						$display_gli = '';
					else if( $count_enable->include_docs == '1' && $count_enable->gli == '1' )
						$display_gli = '';
					else
						$display_gli = 'none';	
					?>
					<?php 
					if( $count_enable->how_docs == 'all' || ($count_enable->w9 == 1 || $count_enable->gli == 1 || $count_enable->api == 1 || $count_enable->umb == 1 || $count_enable->wc == 1 || $count_enable->omi == 1 || $count_enable->pln == 1 || $count_enable->oln == 1 ))
						$display_cont = 'none';
					
					else
						$display_cont = '';	
					?>
					
					<?php
					if( $exp[1] == 'Verified')
					$vendortype = 'in-compliance current';
					else
					$vendortype = 'compliance noncurrent';
					?>
                        <li data-category="gen-liab" class="compliance <?php echo $glitype;?>" style="display:<?php echo $display_gli; ?>">
                              <div class="icon">Compliant</div>
                            <div class="compliance-category">
                                <span class="compliance-category-title">General Liability</span>
                                <span class="compliance-date"><?php echo $exp[3];?></span>
                            </div>
                        </li>
						 <li class="company-compliance-status <?php echo $vertical_middle; ?>" style="display:<?php echo $display_cont; ?>">
                          <div class="<?php echo $vendortype ;?>"><span class="doctype"><?php echo $exp[1];?>&nbsp;Documents</span></div>
                           
                           </li>
					<?php $display_gli = ''; ?>
					
				    <?php 
					$exp_u = explode('/',$exp[6]);
					$exp_u = $exp_u[2].'/'.$exp_u[0].'/'.$exp_u[1];
					if( $exp[6] == 'None' )
						$umbtype = 'unknown';
					else if( $exp_u < date ('Y/m/d')) 
				     	$umbtype = 'failed';
					else
						$umbtype = 'passed';
					?>
                  <?php 
					if( $count_enable->how_docs == 'all' )
						$display_umb = '';
					else if( $count_enable->include_docs == '1' && $count_enable->umb == '1' )
						$display_umb = '';
					else
						$display_umb = 'none';	
					?>
						<li data-category="umbrella" class="compliance <?php echo $umbtype;?>" style="display:<?php echo $display_umb; ?>">
                             <div class="icon">Compliant</div>
                            <div class="compliance-category">
                                <span class="compliance-category-title" >Umbrella</span>
                                <span class="compliance-date"><?php echo $exp[6];?></span>
                            </div>
                        </li>
						<?php $display_umb = ''; ?>
					<?php 
					$exp_oc = explode('/',$exp[8]);
					$exp_oc = $exp_oc[2].'/'.$exp_oc[0].'/'.$exp_oc[1];
					if( $exp[8] == 'None' )
						$ocltype = 'unknown';
					else if( $exp[8] == 'Does Not Expire' )
						$ocltype = 'passed';	
					else if( $exp_oc < date ('Y/m/d')) 
				     	$ocltype = 'failed';
					else
						$ocltype = 'passed';
					?>
					<?php 
					if( $count_enable->how_docs == 'all' )
						$display_oln = '';
					else if( $count_enable->include_docs == '1' && $count_enable->oln == '1' )
						$display_oln = '';
					else
						$display_oln = 'none';	
					?>
                        <li data-category="occ-lic" class="compliance  <?php echo $ocltype;?>" style="display:<?php echo $display_oln; ?>">
                             <div class="icon">Compliant</div>
                            <div class="compliance-category">
                                <span class="compliance-category-title">Occ. License</span>
                                <span class="compliance-date"><?php echo $exp[8];?></span>
                            </div>
                        </li>
						<?php $display_oln = ''; ?>
				   </ul>
                	<ul class="compliance-category-column">
				    <?php 
					$exp_a = explode('/',$exp[4]);
					$exp_a = $exp_a[2].'/'.$exp_a[0].'/'.$exp_a[1];
					if( $exp[4] == 'None' )
						$autotype = 'unknown';
					else if( $exp_a < date ('Y/m/d')) 
				    	$autotype = 'failed';
					else
						$autotype = 'passed';
					?>
					<?php 
					if( $count_enable->how_docs == 'all' )
						$display_api = '';
					else if( $count_enable->include_docs == '1' && $count_enable->api == '1' )
						$display_api = '';
					else
						$display_api = 'none';	
					?>
                        <li data-category="auto" class="compliance  <?php echo $autotype;?>" style="display:<?php echo $display_api; ?>">
                               <div class="icon">Compliant</div>
                            <div class="compliance-category">
                                <span class="compliance-category-title">Auto</span>
                                <span class="compliance-date"><?php echo $exp[4];?></span>
                            </div>
                        </li>
						<?php  $display_api = ""; ?>
                    
					<?php 
					$exp_e = explode('/',$exp[7]);
					$exp_e = $exp_e[2].'/'.$exp_e[0].'/'.$exp_e[1];
					if( $exp[7] == 'None' )
						$eiotype = 'unknown';
					else if( $exp_e < date ('Y/m/d')) 
				    	$eiotype = 'failed';
					else
						$eiotype = 'passed';
					?>
					<?php 
					if( $count_enable->how_docs == 'all' )
						$display_omi = '';
					else if( $count_enable->include_docs == '1' && $count_enable->omi == '1' )
						$display_omi = '';
					else
						$display_omi = 'none';	
					?>
                        <li data-category="e-o" class="compliance  <?php echo $eiotype;?>" style="display:<?php echo $display_omi; ?>">
                            <div class="icon">Unknown</div>
                            <div class="compliance-category">
                                <span class="compliance-category-title">E &amp; O</span>
                                <span class="compliance-date"><?php echo $exp[7];?></span>
                            </div>
                        </li>
						<?php $display_omi = ""; ?>
					
                    </ul>
                    <!-- /.compliance category column -->

                </div>
                <!-- /.company-compliances -->

            </div>
        </div>
      
<?php }}

}
}
}
?>
    </div>
	</div>
	
    <!-- /#main -->
<div id="loading-div-background">
  <div id="loading-div" class="ui-corner-all">
    <img style="height:32px;width:32px;margin:30px;" src="templates/camassistant_left/images/loading_icon.gif" alt="Loading.."/><br>Please wait while your Compliance  report is generated.
  </div>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="components/com_camassistant/assets/piechart_html/piechart.js"></script>
    <script src="script.js"></script>
    <script>
        $(function(){
	
            $("#pieChart").drawPieChart([
                { title: "Compliant",       value: <?php echo $comp;?>, color: "#6bbe2a" },
                { title: "Non-Compliant",   value: <?php echo $noncomp;?>, color: "#e60e18" }
            ]);
        });
    </script>
</body>

</html>

<?php exit; ?>