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

    <!--[if lt IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
</head>

<body>
    <!-- header -->
    <header role="banner">
        <div class="wrapper">
            <div class="logos"> 
                <div class="top-logo"><img src="templates/camassistant_left/piechart_images/my-vc-logo.png" alt="MyVenderCenter" /></div>
                <div class="bottom-logo"><img src="templates/camassistant_left/piechart_images/profacts-logo.svg" alt="Profacts" /></div>
                <div class="logo-slogan">Your exclusive Vendor Compliance Report</div>
            </div>
            <div class="misc-logo-container">
                <div class="misc-logo">
                    <p>Customized for</p>
                    <img src="templates/camassistant_left/piechart_images/amg-logo.png" alt="American Management Group" />
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
if($items[$pv]->final_status == 'fail')
 $noncomp++;
if($items[$pv]->final_status == 'success')
 $comp++;
}


?>
  
    <!-- .compliance-report-summary -->
    <div class="compliance-report-summary">
        <div class="wrapper">
            <div class="disclaimer">
                <p>Please find the list of your Vendors below and their compliance status as of <strong id="current-time"><?php echo date("h:i A", strtotime($today_explode[1])); ?></strong> on <strong id="current-date"><?php echo $today_explode[0];?></strong>.</p>
                <p>Note: this list is determined by the Vendors that you have manually added to be included on your "My Vendors" list ("Corporate Preferred Vendors" list for Master Account holder). You can view this list by logging into your MyVendorCenter account and clicking on "Vendor Lists" ("Preferred Vendors" for Master Account holder)</p>
            </div>
            <div class="compliance-overview">
                <div class="stats">
                    <!-- Do NOT modify this code unless you know what you're doing! -->
                    <div id="pieChart" class="chart"></div>
                    <!-- The code above is generating the pie chart. Modify the values in the script block at the bototm of this file. -->
                    <div class="number-of-vendors-in-compliance">
                        <h3>Vendor Compliance Overview</h3>
                        <div class="number-compliants"><span></span> Compliant: <strong id="num-comp"><?php echo $noncomp;?></strong></div>
                        <div class="number-non-compliants"><span></span> Non-Compliant: <strong id="num-non-comp"><?php echo $comp;?></strong></div>
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
	foreach($vendor_data as $key=>$value){
	
	?>
        <h2 class="vender-category-title"><?php echo $key;?></h2>
       <?php 
	    $count = count($value) ;
			for($last=0; $last<count($value); $last++){
				$exp = explode('MYVC',$value[$last]);
				//echo '<pre>';print_r($exp);exit;
				if($value[$last]){
	      ?>
        <!-- Company Information & Compliance Status -->
        <div class="company">
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
                        <li class="company-compliance-status">
                            <span class="company-name"><?php echo $exp[2];?></span>
                            <span class="<?php echo $vendortype ;?>"><?php echo $exp[1];?></span>
                            <span class="not-in-compliance">Non Compliant</span>
                        </li>
                        <li class="company-address">
                            <span class="address1"><?php echo $exp[13];?></span><br>
                            <span class="address2"></span><br>
                            <span class="city"><?php echo $exp[14];?></span>, <span class="state"><?php echo $exp[16];?></span>, <span class="zipcode"><?php echo $exp[15];?></span>
                        </li>
                        <li class="company-contact">
                            <p><strong>Contact</strong></p>
                            <span class="contact"><?php echo $exp[17];?></span>, <span class="contact-title"></span><br>
                            <span class="contact-phone"><?php echo $exp[12];?></span>
                        </li>
                    </ul>
                </div>
                <!-- /.company-information -->

                <!-- .company-compliances -->
                <div class="company-compliances">

                    <!-- .compliance category column -->
                    
					 <?php 
					 
					if( $exp[4] < date ('m/d/Y'))
					$autotype = 'failed';
					else if( $exp[4] == 'None')
					$autotype = 'unknown';
					else
					$autotype = 'passed';
					
					?>
					<ul class="compliance-category-column">
                        <li data-category="comp-stat" data-compliance="non-compliant" class="compliance">
                            <div class="icon">Non-Compliant</div>
                            <div class="compliance-category">
                                <span class="compliance-category-title">Compliance Status</span>
                                <span class="compliance-date"><?php echo $exp[0];?></span>
                            </div>
                        </li>
                        <li data-category="auto" class="compliance <?php echo $autotype;?>">
                            <div class="icon">Compliant</div>
                            <div class="compliance-category">
                                <span class="compliance-category-title">Auto</span>
                                <span class="compliance-date"><?php echo $exp[4];?></span>
                            </div>
                        </li>
						 <?php 
					 
					if( $exp[7] < date ('m/d/Y'))
					$eiotype = 'failed';
					else if( $exp[7] == 'None')
					$eiotype = 'unknown';
					else
					$eiotype = 'passed';
					
					?>
                        <li data-category="e-o" class="compliance <?php echo $eiotype;?>">
                            <div class="icon">Unknown</div>
                            <div class="compliance-category">
                                <span class="compliance-category-title">E &amp; O</span>
                                <span class="compliance-date"><?php echo $exp[7];?></span>
                            </div>
                        </li>
                    </ul>
                    <!-- /.compliance category column -->

                    <!-- .compliance category column -->
                    <?php if ( $exp[11] == "Provided" )
					$type = 'passed';
					else
					$type = 'unknown';
					
					?>
					<ul class="compliance-category-column">
					
                        <li data-category="w9" class="compliance <?php echo $type;?>">
                            <div class="icon">Compliant</div>
                            <div class="compliance-category">
                                <span class="compliance-category-title">W9</span>
                                <span class="compliance-date"><?php echo $exp[11];?></span>
                            </div>
                        </li>
						
					<?php 
					if( $exp[5] < date ('m/d/Y'))
					$worktype = 'failed';
					else if( $exp[5] == 'None')
					$worktype = 'unknown';
					else
					$worktype = 'passed';
					?>
                        <li data-category="work-comp" class="compliance <?php echo $worktype; ?>">
                            <div class="icon">Compliant</div>
                            <div class="compliance-category">
                                <span class="compliance-category-title">Worker's Comp</span>
                                <span class="compliance-date"><?php echo $exp[5];?></span>
                            </div>
                        </li>
                        <li data-category="prof-lic" class="compliance unknown">
                            <div class="icon">Compliant</div>
                            <div class="compliance-category">
                                <span class="compliance-category-title">Professional License</span>
                                <span class="compliance-date"><?php echo $exp[9]; ?></span>
                            </div>
                        </li>
                    </ul>
                    <!-- /.compliance category column -->

                    <!-- .compliance category column -->
                     
					 
					 <?php 
					if( $exp[3] < date ('m/d/Y'))
					$glitype = 'failed';
					else if( $exp[3] == 'None')
					$glitype = 'unknown';
					else
					$glitype = 'passed';
					?>
					
					<ul class="compliance-category-column">
                        <li data-category="gen-liab" class="compliance <?php echo $glitype;?>">
                            <div class="icon">Compliant</div>
                            <div class="compliance-category">
                                <span class="compliance-category-title">General Liability</span>
                                <span class="compliance-date"><?php echo $exp[3];?></span>
                            </div>
                        </li>
						
					<?php 
					if( $exp[6] < date ('m/d/Y'))
					$umbtype = 'failed';
					else if( $exp[6] == 'None')
					$umbtype = 'unknown';
					else
					$umbtype = 'passed';
					?>
                        <li data-category="umbrella" class="compliance <?php echo $umbtype;?>">
                            <div class="icon">Compliant</div>
                            <div class="compliance-category">
                                <span class="compliance-category-title">Umbrella</span>
                                <span class="compliance-date"><?php echo $exp[6];?></span>
                            </div>
                        </li>
						<?php 
					if( $exp[8] < date ('m/d/Y'))
					$ocltype = 'failed';
					else if( $exp[8] == 'None')
					$ocltype = 'unknown';
					else
					$ocltype = 'passed';
					?>
						
                        <li data-category="occ-lic" class="compliance <?php echo $ocltype;?>">
                            <div class="icon">Compliant</div>
                            <div class="compliance-category">
                                <span class="compliance-category-title">Occ. License</span>
                                <span class="compliance-date"><?php echo $exp[8];?></span>
                            </div>
                        </li>
                    </ul>
                    <!-- /.compliance category column -->

                </div>
                <!-- /.company-compliances -->

            </div>
        </div>
      
<?php } 
}
}
?>
    </div>
    <!-- /#main -->

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