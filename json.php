<?php
function checknewsearch()
	{
	$db =& JFactory::getDBO();
	$user	= JFactory::getUser();
	$state = JRequest::getVar( 'state','');
	$county = JRequest::getVar( 'county','');
	$industrytype = JRequest::getVar( 'ind','');
	
	$query  = "SELECT u.company_name, u.company_address, u.company_phone, u.phone_ext, u.company_web_url, v.name, v.lastname, v.email, v.id, u.city, u.state, u.status, v.block, v.subscribe, v.subscribe_type, v.subscribe_sort FROM  #__cam_vendor_company as u, #__users as v where u.user_id=v.id and v.block=0 and v.search='' " ; 
	
	$sort = JRequest::getVar('sort','');
		if( $sort == '' ){
			$sorting = " order by v.subscribe_type='', v.subscribe_type='free', v.subscribe_type='public', v.subscribe_type='all'  ";
		}
		else if( $sort == 'asc' ){
			$sorting = ' order by u.company_name ASC ';
		}
		else{
			$sorting = ' order by u.company_name DESC ';
		}
		
	$db->setQuery($query);
	$totalprefers = $db->loadObjectList();  
	//echo "<pre>"; print_r($totalprefers); echo "</pre>";
	if($industrytype){
			$checkvendors = "SELECT distinct(user_id) FROM #__cam_vendor_industries where industry_id=".$industrytype." ";
			$db->setQuery($checkvendors);
			$accpetvendor = $db->loadObjectList();
			
			if($totalprefers){
				foreach($totalprefers as $vid){
				$existing[] = $vid->id;
				}
			}	
			if($accpetvendor){
				foreach($accpetvendor as $inids){
				$indusids[] = $inids->user_id;
				}
			}
			if($indusids != '' && $existing!= ''){
			$common = array_intersect($indusids, $existing) ;
			}
			if($common){
			$indus_condition = implode(',',$common) ;
			}
			if($indus_condition)
			$query = $query . "AND v.id IN ("  . $indus_condition . ")" ;
			else
			$query = $query . "AND v.id IN ('')" ;
			}	
			
			// Search with County
			if($county){
			$checkvendors1 = "SELECT distinct(user_id) FROM #__vendor_state_counties where county_id=".$county." ";
			$db->setQuery($checkvendors1);
			$accpetvendor1 = $db->loadObjectList();
			
			if($totalprefers){
				foreach($totalprefers as $vid){
				$existing[] = $vid->v_id;
				}
			}	
			if($accpetvendor1){
				foreach($accpetvendor1 as $county){
				$countys[] = $county->user_id;
				}
			}
			
			
			if($countys && $existing){
			$common = array_intersect($countys, $existing) ;
			
				if($common){
				$county_condition = implode(',',$common) ;
				}
					if($county_condition)	{
					$query = $query . " AND v.id IN ("  . $county_condition . ")" ;
					}
					else {
					$query = $query . " AND v.id IN ('')" ;
					}
			}	
				else {
				$query = $query . " AND v.id IN ('')" ;
				}
			}
			
			//Completed
			
			$query = $query . ' '.$sorting.'  ' ;
			$db->setQuery($query);
			$totalcompanies = $db->loadObjectList();
			
			$model = $this->getModel('vendorscenter');
			for( $p=0; $p<count($totalcompanies); $p++ ){
			$c_status =	$model->checkcompliancestatus($totalcompanies[$p]->id);
			$totalcompanies[$p]->cstatus = $c_status ;
			}
		
		for( $s=0; $s<count($totalcompanies); $s++ ){
		$only_state = $totalcompanies[$s]->cstatus ;
					if($only_state){
						foreach($only_state as $statues){
							$final_state[] = $statues->status;
							$med_fina_state = '';
							$med_fina_state = array_unique($final_state);
							
								if( count($med_fina_state) == 2 ) {
									$totalcompanies[$s]->final_status = 'medium' ;
								}
								if( count($med_fina_state) == 1 &&  $med_fina_state[0] == 'fail') {
									$totalcompanies[$s]->final_status = 'fail' ;
								}
								if( count($med_fina_state) == 1 &&  $med_fina_state[0] == 'success' ){
									$totalcompanies[$s]->final_status = 'success' ;
									
										$masteraccount = $model->getmasterfirmaccount($user->id);
										$sql_terms = "SELECT termsconditions FROM #__cam_vendor_aboutus WHERE vendorid=".$masteraccount." "; 
										$db->setQuery($sql_terms);
										$terms_exist = $db->loadResult();
										if($terms_exist == '1'){
										$sql = "SELECT accepted FROM #__cam_vendor_terms WHERE vendorid=".$totalcompanies[$s]->id." and masterid=".$masteraccount." "; 
										$db->setQuery($sql);
										$terms = $db->loadResult();
											if($terms == '1'){
											$totalcompanies[$s]->final_status = 'success' ;
											}
											else{
											$totalcompanies[$s]->final_status = 'fail' ;
											}
										}
									
								}
						} 
						$final_state = '';
						$med_fina_state = '';
					}
// Adding block unverified vendor rule
	$user =& JFactory::getUser();
	$masterid = $model->getmasterfirmaccount($user->id);
	$block_per = "SELECT id FROM #__cam_master_block_users where masterid ='".$masterid."' ";
	$db->setQuery($block_per);
	$blockid = $db->loadResult();
	if( $blockid )
		$totalcompanies[$s]->unverified = 'hide' ;
	else	
		$totalcompanies[$s]->unverified = 'show' ;
//Completed	
			
		}
		
		
			?>
<?php 
// To get all corporate vendors
		$model = $this->getModel('vendorscenter');
		$corporate_vendors = $model->corporatevendors();
		$star_vendors = $corporate_vendors ;
		if($star_vendors){
			foreach($star_vendors as $star){
				$stars[] = $star->v_id;
			}
		}
	
	//Completed
?>			
	<?php 
	$sort = JRequest::getVar('sort','');
	if( $sort == '' ) {
	$anvhor_tag = '<a id="compliant_nosort" class="sortelementnewsearch" data="asc" href="javascript:void(0);">COMPANY</a>';
	}
	else if( $sort == 'asc' ){
	$anvhor_tag = '<a id="compliant_desc" class="sortelementnewsearch" data="desc" href="javascript:void(0);">COMPANY</a>';
	}
	else{
	$anvhor_tag = '<a id="compliant_asc" class="sortelementnewsearch" data="asc" href="javascript:void(0);">COMPANY</a>';
	}
	?>
	
<div id="heading_vendors_search">
<div class="checkbox_vendor_search"><input type="checkbox" value="" name="selectall" id="selectall_preferredvendors" />ADD</div> 
<div class="company_vendor_search"><?php echo $anvhor_tag; ?></div>
<div class="apple_vendor_search">APPLE RATING</div>
<div class="compliant_vendor_search">COMPLIANCE STATUS</div>
</div>
<div class="totalvendorspre">
			<?php
			if($totalcompanies){
			
	for($t=0; $t<count($totalcompanies); $t++){
	
	if($totalcompanies[$t]->subscribe == 'yes' && $totalcompanies[$t]->subscribe_type == 'all')
	$background = '#EBF5DA';
	else
	$background = '';
	
?>
	<div id="preferredvendorsinvitations" class="search-panel<?php echo $totalcompanies[$t]->id; ?>" style="background:<?php echo $background; ?>">
	<div class="search-panel-middlepre checkbox_vendor_search">
	<?php 
	if( $totalcompanies[$t]->status == 'rejected' ) 
		{ 
		echo "<strong><font color='red'>REJECTED</font></strong>";
		}  
	 elseif( $totalcompanies[$t]->block == '1' ){
	 	echo "<strong><p style='color:red;'>REJECTED</p></strong>";
	 }
	 else {  
	 $user =& JFactory::getUser();
	 	$model = $this->getModel('vendorscenter');
		$masterid = $model->getmasterfirmaccount($user->id);
	 	$vendor_id = "SELECT exclude, search FROM #__vendor_inviteinfo where v_id ='".$totalcompanies[$t]->id."' and userid=".$masterid." ";
		$db->setQuery($vendor_id);
		$v_id_exist = $db->loadObject();
	 	if($v_id_exist->exclude == 'yes' || $v_id_exist->search == 'yes'){
			
		 ?>
		 <a href="javascript:senderrormsg();"><img src="templates/camassistant_left/images/Block2.png" /></a>
		<?php } 
		else if( $totalcompanies[$t]->subscribe_type == 'free' && $totalcompanies[$t]->unverified == 'hide' ){ ?>
			<a href="javascript:void(0);" onclick="unverified(<?php echo $totalcompanies[$t]->id; ?>,'un');"><img src="templates/camassistant_left/images/Block2.png" /></a>
		<?php }
		else { ?>
	 <input type="checkbox" class="coworkers" name="coworkers" value="<?php echo $totalcompanies[$t]->id; ?>-<?php echo $totalcompanies[$t]->id; ?>">
	 <?php } ?>
	<?php } ?>
	<br />
	<span id="companyid<?php echo $totalcompanies[$t]->id; ?>" style="color:green; font-weight:bold; display:block; padding-top:6px; margin-right:2px;"></span>
    </div>
	<div class="search-panel-left_rfp company_vendor_search">
	<ul>
	<li><strong>
		<?php 
		if($stars) {
		if (in_array($totalcompanies[$t]->id, $stars)){ ?>
		<img src="templates/camassistant_left/images/star-icon.png" title="Corporate Preferred Vendor" />
		<?php }
		else{
		}
		}
		?>
		
		
	<?php /*if( $totalcompanies[$t]->status == 'rejected' ||  $totalcompanies[$t]->block == '1' || $totalcompanies[$t]->subscribe == '' || $totalcompanies[$t]->subscribe == 'no' )  { 
	echo "<a href='javascript:unsubscribevendor();'>".stripslashes($totalcompanies[$t]->company_name)."</a>"; 
	 } else { */?>
	<a href="index.php?option=com_camassistant&controller=vendors&task=vendordetailslayout&id=<?php echo $totalcompanies[$t]->id; ?>" target="_blank"><?php echo stripslashes($totalcompanies[$t]->company_name); ?></a>
	<?php //} ?>
	</strong></li><?php //if( $totalcompanies[$t]->subscribe == 'yes'){ ?>
	<li><?php echo $totalcompanies[$t]->name.' '.$totalcompanies[$t]->lastname; ?> <?php echo $totalcompanies[$t]->company_phone; ?> <?php if($totalcompanies[$t]->phone_ext){ echo "&nbsp;Ext.&nbsp;".$totalcompanies[$t]->phone_ext; } else{ echo ""; } ?></li>
	<?php
	$statecode  = "SELECT code from #__cam_vendor_states where id=".$totalcompanies[$t]->state." " ; 
	$db->setQuery($statecode);
	$statea = $db->loadResult(); 
	?>
	<li><?php echo $totalcompanies[$t]->city; ?>,&nbsp;<?php echo strtoupper($statea); ?></li>
	<li><a style="font-weight:normal; color:gray;" href="mailto:<?php echo $totalcompanies[$t]->email; ?>"><?php echo $totalcompanies[$t]->email; ?></a></li><?php 
	/*}  else { ?>
	<li>This Vendor's contact information is unavailable due to an expired account. <strong><a href="javascript:sendupdateemail('<?php  echo $totalcompanies[$t]->email; ?>','<?php echo $totalcompanies[$t]->company_name; ?>','<?php echo $totalcompanies[$t]->id; ?>')" class='notsubscribedvebndors'>CLICK HERE</a></strong> to request an update.</li>
	<?php }*/ ?>
	</ul>
	</div>
	<div class="search-panel-right_rfp apple_vendor_search">
	<?php
	$ratecount = "SELECT V.apple FROM `#__cam_vendor_proposals` as U, `#__cam_rfpinfo` as V where U.proposedvendorid=".$totalcompanies[$t]->id." and V.apple!=0 and V.apple_publish=0 and U.proposaltype='Awarded' and U.rfpno = V.id ";
	$db->setQuery($ratecount);
	$count_vs=$db->loadObjectList();
	
	$camratingf = "SELECT camrating FROM `#__users` where id=".$totalcompanies[$t]->id."  ";
		$db->setQuery($camratingf);
		$cam_ratingf = $db->loadResult();
		
	if($count_vs){
		for($c=0; $c<count($count_vs); $c++){
		$total = $total + $count_vs[$c]->apple ;
		}
		$camrating = "SELECT camrating FROM `#__users` where id=".$totalcompanies[$t]->id."  ";
		$db->setQuery($camrating);
		$cam_rating = $db->loadResult();
		
		if($cam_rating) {
		$total = $total + $cam_rating ;
		$count = count($count_vs) + 1;
		$avgrating = $total  / $count;	
		$rating =  round($avgrating, 1); 
		}
		else {
		$avgrating = $total  / count($count_vs);	
		$rating =  round($avgrating, 1); 
		}
	}
	else if($cam_ratingf){
	$rating = round($cam_ratingf, 1); 
	}
	else{
	$rating = 4 ;
	} 

	if ($rating > 0 && $rating <= 0.50)
			{ $rate_image = $rateimage.'5.png';  $rating='0.5'; }
			elseif ($rating > 0.50 && $rating <= 1.00)
			{ $rate_image = $rateimage.'10.png'; $rating='1'; }
			elseif ($rating > 1.00 && $rating <= 1.50)
			{ $rate_image = $rateimage.'15.png'; $rating='1.5';}
			elseif ($rating > 1.50 && $rating <= 2.00)
			{ $rate_image = $rateimage.'20.png'; $rating='2';}
			elseif ($rating > 2.00 && $rating <= 2.50)
			{ $rate_image = $rateimage.'25.png'; $rating='2.5';}
			elseif ($rating > 2.50 && $rating <= 3.00)
			{ $rate_image = $rateimage.'30.png'; $rating='3';}
			elseif ($rating > 3.00 && $rating <= 3.50)
			{ $rate_image = $rateimage.'35.png'; $rating='3.5';}
			elseif ($rating > 3.50 && $rating <= 4.00)
			{ $rate_image = $rateimage.'40.png'; $rating='4';}
			elseif ($rating > 4.00 && $rating <= 4.50)
			{ $rate_image = $rateimage.'45.png'; $rating='4.5';}
			elseif ($rating > 4.50 && $rating <= 5.00)
			{ $rate_image = $rateimage.'50.png'; $rating='5';}
			else
			{ $rate_image = $rateimage.'40.png'; $rating='4';}
			$total = 0;
			
	 ?>
	 		
			<img width="130" src="templates/camassistant_left/images/vendorrating/<?php echo $rate_image; ?>" />
			
	</div>
	
	<?php
				$master = $model->getmasterfirmaccount($user->id);
				$permission = $model->getpermission($master);
				$set_globals = $model->getmasterglobals($master);
				if($permission == 'yes' || $set_globals == 'fail'){
					$text = "N/A";
					$id = 'nostandards';
				}
				else{
					if($totalcompanies[$t]->final_status == 'fail') {
					//$text = "NON-COMPLIANT";
					$id = 'noncompliant';
					$title = 'Non-Compliant';
					}
					else if($totalcompanies[$t]->final_status == 'success'){
					//$text = "COMPLIANT";
					$id = 'compliant';
					$title = 'Compliant';
					}
					else if($totalcompanies[$t]->final_status == 'medium'){
					//$text = "COMPLIANT & NON-COMPLIANT";
					$id = 'mediumcompliant';
					$title = 'Compliant & Non-Compliant';
					}
				}				
			?>
			
	<div class="search-panel-image_rfp compliant_vendor_search" style="width:157px;">
	  	  <p align="center" style="color:; display:block; margin-bottom:7px; font-weight:bold;">  
		 <?php  if($globe != 'fail'){ ?>
			<a onclick="javascript:getcompstatus(<?php echo $totalcompanies[$t]->id; ?>);" href="javascript:void(0);" id="<?php echo $id; ?>" title="<?php echo $title; ?>"><?php echo $text; ?></a>
			<?php } else {
			echo "N/A";
			}?>			
			 </p>

<?php
if( $totalcompanies[$t]->subscribe_type == 'free' || $totalcompanies[$t]->subscribe_type == '' ) { ?>
<div class="unverifiedvendor"><a href="javascript:void(0);" onclick="unverified(<?php echo $totalcompanies[$t]->id; ?>,'unverified');" title="Click for more info">UNVERIFIED</a></div>
<?php } else {  ?>
<div class="verifiedvendor"><a href="javascript:void(0);" onclick="unverified(<?php echo $totalcompanies[$t]->id; ?>,'verified');" title="Click for more info">VERIFIED</a></div>
<?php } ?>
			 
	  </div>
	  
	  <div class="clear"></div>
	  
	</div>
<?php } 

			}
	else{ 
$user =& JFactory::getUser(); 
if($user->user_type == '13'){
$item = '216';
}
else {
$item = '217';
}
?>
<p style='font-weight:bold; padding-top:20px;'>Your search has produced no matches.  <a href="index.php?option=com_camassistant&controller=vinvitations&Itemid=<?php echo $item; ?>" class="invitevendor" style="color:#6DAA00">CLICK HERE</a> to invite a Vendor</p>
<br /><br />
<?php }
?>
</div>
<?php 
	if($user->user_type == '13' && $user->accounttype == 'master') 
	$textshows_co =  "Add to Corporate Preferred Vendors";
	else
	$textshows_co =  "Add to My Preferred Vendors";

$listbasicjobs = $model->getallbasicjobs();
if( count($listbasicjobs) > '0' )
	$basics = 'yes';
	else
	$basics = 'no';
	
if($totalcompanies){ ?>
	<div align="center" style="margin-top:17px;">
	<a title="<?php echo $textshows_co; ?>" class="addicon" href="javascript:sendinvitationcorporate('add');"></a>
	<a href="javascript:vendor_mails();" class="vendor_mails" title="Email Vendor(s)"></a>
	<a title="Create a new Basic Request" class="basicrequest" href="javascript:basicrequest('pre');"></a>
	<a title="Invite Vendor(s) to existing Basic Request" class="basicrequest_invite" href="javascript:inviteto_basicrequest('pre','<?php echo $basics; ?>');"></a>
	<a title="Recommend to Co-Workers" class="vendor_recommend" href="javascript:vendor_recommend();"></a>
	<?php 
	$user =& JFactory::getUser();
	if($user->accounttype  == 'master'){ ?>
	<a title="Block this Vendor from participating in your Managers' projects" class="exclude" href="javascript:sendinvitationcorporate('exclude');"></a>
	<?php } ?>
	
	</div>
<?php 	} ?>
	<?php 
	exit;
	}