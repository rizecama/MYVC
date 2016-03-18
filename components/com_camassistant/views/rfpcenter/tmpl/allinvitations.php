<link rel="stylesheet" href="<?PHP echo juri::base(); ?>templates/camassistant_left/css/style.css" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript">
  //Functio to verify taxid by sateesh on 03-08-11
G = jQuery.noConflict();
var site='<?php echo JURI::root();?>';
var path='<?php echo addslashes(JPATH_SITE);?>';
var countyCount = 0;
G(document).ready( function(){ 
	
	  var show_per_page1 = 9;  
        //getting the amount of elements inside content div  
        var number_of_items1 = G('#content1').children().size(); 
    //alert(number_of_items); 
        //calculate the number of pages we are going to have  
        var number_of_pages1 = Math.ceil(number_of_items1/show_per_page1);  
     
        //set the value of our hidden input fields  
        G('#current_page1').val(0);  
        G('#show_per_page1').val(show_per_page1);  
      
        //now when we got all we need for the navigation let's make it '  
      
        /* 
        what are we going to have in the navigation? 
        
            - link to previous page 
            - links to specific pages 
            - link to next page 
        */  
        var navigation_html1 = '<a class="previous_link1" href="javascript:previous1();" style="pointer-events:none;"><img class="preimg1" src="templates/camassistant_left/images/left_arrow_trmp.png"></a>';  
        var current_link1 = 0;  
        while(number_of_pages1 > current_link1){  
            navigation_html1 += '<a class="page_link1" href="javascript:go_to_page1(' + current_link1 +')" longdesc="' + current_link1 +'">'+ (current_link1 + 1) +'</a>';  
            current_link1++;  
        } 
     
       if( number_of_pages1 == '1' ){
	   navigation_html1 += '<img style="margin-right:0px; margin-top:5px;" src="templates/camassistant_left/images/rght_arrow-trmp.png">';  
	   }else{
        navigation_html1 += '<a class="next_link1" href="javascript:next1();"><img style="margin-right:0px; margin-top:5px;" src="templates/camassistant_left/images/rght_arrow.png"></a>';  
      }
        G('#page_navigation').html(navigation_html1);  
      
        //add active_page class to the first page link  
        G('#page_navigation .page_link1:first').addClass('active_page1');  
      
        //hide all the elements inside content div  
        G('#content1').children().css('display', 'none');  
      
        //and show the first n (show_per_page) elements  
        G('#content1').children().slice(0, show_per_page1).css('display', 'block');  
      
    });  
      
    function previous1(){  
      
        new_page1 = parseInt(G('#current_page1').val()) - 1;  
		G('.next_link1').html('<img src="templates/camassistant_left/images/rght_arrow.png" style="margin-right:0px; margin-top:5px;">');
        //if there is an item before the current active link run the function  
        if(G('.active_page1').prev('.page_link1').length==true){  
            go_to_page1(new_page1);  
        }  
      
    }  
      
    function next1(){  
	alert("can");
	
		G("iframe").parent().find('#sbox-btn-close').addClass('myClass')

	//G("#sbox-btn-close").addClass("newclasssate");
        new_page1 = parseInt(G('#current_page1').val()) + 1; 
         var show_per_page1 = 9;  
        //getting the amount of elements inside content div  
        var number_of_items1 = G('#content1').children().size(); 
    //alert(number_of_items); 
        //calculate the number of pages we are going to have  
        var number_of_pages1 = Math.ceil(number_of_items1/show_per_page1); 
	
         if(parseInt( number_of_pages1 - 1 ) ==  new_page1 || number_of_pages1 == new_page1 )
         {
		 G('.previous_link1').removeAttr('style');
         G('.next_link1').html('<img src="templates/camassistant_left/images/rght_arrow-trmp.png" style="margin-right:0px; margin-top:5px;">');
		 }
		 else{
		 G('.previous_link1').removeAttr('style');
		 G('.next_link1').html('<img src="templates/camassistant_left/images/rght_arrow.png" style="margin-right:0px; margin-top:5px;">');	
		 }

        //if there is an item after the current active link run the function  
        if(G('.active_page1').next('.page_link1').length==true){  
            go_to_page1(new_page1);  
        }  
      
    }  
    function go_to_page1(page_num1){
	  
        //get the number of items shown per page  
        var show_per_page1 = parseInt(G('#show_per_page1').val());  
   
        //get the element number where to start the slice from  
        start_from1 = page_num1 * show_per_page1;  
             if(start_from1==0){
		 G('.previous_link1').html('<img src="templates/camassistant_left/images/left_arrow_trmp.png" style="margin-right:50px; margin-top:5px;">');		
		 G('.preimg1').addClass('add');
	 }else{
	 	G('.previous_link1').html('<img src="templates/camassistant_left/images/lft-arrow.png" style="margin-right:50px; margin-top:5px;">');		
		 G( ".preimg1" ).removeClass( "add" ).addClass( "remove" );
	 }
	  
        //get the element number where to end the slice  
        end_on1 = start_from1 + show_per_page1;  
     
        //hide all children elements of content div, get specific items and show them  
        G('#content1').children().css('display', 'none').slice(start_from1, end_on1).css('display', 'block');  
      
        /*get the page link that has longdesc attribute of the current page and add active_page class to it 
        and remove that class from previously active page link*/  
        G('.page_link1[longdesc=' + page_num1 +']').addClass('active_page1').siblings('.active_page1').removeClass('active_page1');  
      
        //update the current page input field  
        G('#current_page1').val(page_num1);  
    }  
function acceptpopup(proid,managerid,invitationid,boardmem_id)
{
	window.parent.location = "index.php?option=com_camassistant&controller=rfpcenter&task=acceptinvitation&property_id="+proid+"&manager_id="+managerid+"&invitationid="+invitationid+"&boardmem_id="+boardmem_id+"&Itemid=128";
	window.parent.document.getElementById( 'sbox-window' ).close();
}

function closepopup(proid,managerid,invitationid,boardmem_id)
{
	window.parent.location = "index.php?option=com_camassistant&controller=rfpcenter&task=declineinvitation&property_id="+proid+"&manager_id="+managerid+"&invitationid="+invitationid+"&boardmem_id="+boardmem_id+"&Itemid=128";
	window.parent.document.getElementById( 'sbox-window' ).close();
}

function sendmailtoawardedvendors(rfpid)
{
window.parent.location ="index.php?option=com_camassistant&controller=rfpcenter&task=sendmailtoawardedvendors&rid="+rfpid+"&Itemid=125";
window.parent.document.getElementById( 'sbox-window' ).close();
}

function declineawardedvendors(rfpid)
{
window.parent.location ="index.php?option=com_camassistant&controller=rfpcenter&task=declineawardedvendors&rid="+rfpid+"&Itemid=125";
window.parent.document.getElementById( 'sbox-window' ).close();
}

function acceptrfpapproval(rfpid,type)
{
if ( type == 1 )
window.location="index.php?option=com_camassistant&controller=rfpcenter&task=sendmailtoapprovalvendors&rid="+rfpid+"&Itemid=125";
else
window.location="index.php?option=com_camassistant&controller=rfp&task=presonalmailtovendors&rid="+rfpid+"&Itemid=125";
window.parent.document.getElementById( 'sbox-window' ).close();
}

function declinerfpapproval(rfpid)
{
	window.location="index.php?option=com_camassistant&controller=rfpcenter&task=declinerfpaproval&rid="+rfpid+"&Itemid=125";
	window.parent.document.getElementById( 'sbox-window' ).close();
}
</script>
 <input type='hidden' id='current_page1' />  
 <input type='hidden' id='show_per_page1' /> 


 <div id="content1"> 

<?php
setcookie("pinvites_cookie", "pinvites");
$invitations = $this->invitations;
$request = $this->get_rfprequestper;
$approval = $this->get_rfpapprovalper;
$totalinv = array_merge($invitations,$request,$approval);
//echo '<pre>';print_r($totalinv );exit;
$sum = count( $invitations ) + count( $request ) + count( $approval );

$j=0;
for($i = 0; $i<count($totalinv); $i++)
{
$j++;
    $invtype = $totalinv[$i]->invitationtype;
	if( $invtype == 'inv' )
	{
    $manager_id = $totalinv[$i]->user_id;
	$property_id = $totalinv[$i]->id;
	
	$propertyowner_id = $totalinv[$i]->propertyowner_id;
	$invitationid = $totalinv[$i]->invitationid;
	$property_name = $totalinv[$i]->property_name;
	$boardmem_id = $invitations[$i]->boardmem_id;
	$property_name = str_replace('_',' ', $property_name);
	$db =& JFactory::getDBO();
    $user = JFactory::getUser();
	$query = "SELECT name,lastname FROM #__users where id =".$manager_id.""; 
	$db->setQuery($query);
	$name = $db->loadObject();
	$manager_name =  $name->name.' '.$name->lastname;	
		
?>

<div id="i_bar_terms"  style="margin: 19px 15px 15px; background:#77b800;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">LINK WITH PROPERTY MANAGER</font></span>
</div></div>

<p class="reminder_notifications" align="center" style="display: block; text-align: left; padding-left: 53px; margin-bottom:-4px; padding-top:15px; font-size:15px;">  The Property Manager, <strong><?php echo $manager_name;?></strong>, has requested to link the following Property to your MyVendorCenter account: <strong><?php echo $property_name;?></strong> </p>
<p></p>
<p></p>
<p></p>
<div class="" id="topborder_row_reminder" align="center" ></div>
<p align="center" class="reminder_notifications" style="display: block; text-align: center; padding-left: 29px; padding-right: 29px;">IMPORTANT: If you ACCEPT the LINK, the linked Property will be automatically added to your "MY PROPERTIES" page.  If you DECLINE the LINK, no changes will be made to your account and you will not be able to collaborate with <?php echo $manager_name; ?> on this Property. </p>
<div class = "proprty_invitation" style="margin-top:40px; margin-bottom:28px" >
<div class="reminder_notifications" align="center"><a class="decline_propertyinvite" onclick="javascript:closepopup(<?PHP echo $property_id;  ?>,<?PHP echo $manager_id; ?>,<?PHP echo $invitationid;  ?>,<?PHP echo $boardmem_id;  ?>);" href="javascript:void(0);"></a></div>
<div class="reminder_notificationss" align="center"><a class="accept_propertyinvite" onclick="javascript:acceptpopup(<?PHP echo $property_id;  ?>,<?PHP echo $manager_id; ?>,<?PHP echo $invitationid;  ?>,<?PHP echo $boardmem_id;  ?>);" href="javascript:void(0);"></a></div>
</div>
<?php } 
 if( $invtype == 'req' ){ 
$manager = $totalinv[$i]->cust_id;
$jobtype = $totalinv[$i]->jobtype;
if($jobtype == 'yes')
$type = 1;
else
$type = 0;

$propertyname = str_replace('_',' ',$totalinv[$i]->property_name);
$db =& JFactory::getDBO();
$user = JFactory::getUser();
$query = "SELECT name,lastname FROM #__users where id =".$manager." "; 
$db->setQuery($query);
$name = $db->loadObject();
$manager_name =  $name->name.' '.$name->lastname;	
  
 
 ?>
<div id="i_bar_terms"  style="margin: 18px 15px 27px; background:#787878; ">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">REQUEST APPROVAL FOR SUBMISSIONS</font></span>
</div></div>

<p class="reminder_notificationsnewone" align="center" > <strong> <?php echo $manager_name?></strong> needs your approval to submit the following request for <strong><?php echo $propertyname;?></strong>: <strong><?php echo $totalinv[$i]->projectName;?></strong>  </p>
<p></p>
<p></p>
<p></p>
<div class="" id="topborder_row_reminder" align="center" ></div>
<p align="center" class="reminder_notifications" >IMPORTANT: If you deny this request, please contact your Manager regarding any necessary changes so they can resubmit for approval.  If you approve this request, a personal invite will be automatically sent to any pre-selected Vendors.  If your Manager chose "Open Invitation", this request will be visible to any Vendors that provide the product/service needed in the service area of your property. Your Manager can also revise an approved request at any time if your needs change. </p>
<div class = "proprty_invitation" style=" margin-left:27px;">
<div class="reminder_notificationsbuttons" align="center"><a class="decline_rfpapproval" onclick="javascript:declinerfpapproval(<?PHP echo $totalinv[$i]->id; ?>);" href="javascript:void(0);"></a></div>
<div class="reminder_notificationsbuttons" align="center"><a class="accept_rfpapproval" onclick="javascript:acceptrfpapproval(<?PHP echo $totalinv[$i]->id; ?>,<?php echo $type;?>);" href="javascript:void(0);"></a></div>
</div>
<?php } 
 if( $invtype == 'app' ){ 
$managerid = $totalinv[$i]->cust_id;
$db =& JFactory::getDBO();
 $user = JFactory::getUser();
$query ="SELECT proposal_total_price FROM #__cam_vendor_proposals WHERE rfpno=".$totalinv[$i]->id." and proposaltype='Awarded'";
$db->setQuery( $query );
if($row->id == '550494'){
$cost = $db->loadObjectList();
}
else{
$data4 = $db->loadResult();
}

$query_a ="SELECT proposedvendorid FROM #__cam_vendor_proposals WHERE rfpno=".$totalinv[$i]->id." and proposaltype='Awarded'";
$db->setQuery( $query_a );
$vid = $db->loadResult();
$query_c ="SELECT company_name FROM #__cam_vendor_company WHERE user_id=".$vid."";
$db->setQuery( $query_c );
$vcname = $db->loadResult();
$query_o ="SELECT awarded_vendor FROM #__cam_outsidevendor WHERE rfpid =".$row->id."";
$db->setQuery( $query_o );
$outname = $db->loadResult();

		 if($row->id == '550494'){ 
			$price = "$".$cost[0]->proposal_total_price .', $'.$cost[1]->proposal_total_price; 
			} 
			else {
              if($data4==''){
			$decimal = explode('.', $row->amount);
			if($decimal[1] == ''){
			$decimal = '.00';
			}
			else{
			$decimal = '';
			}
			$price =  "$".number_format($row->amount,2).$decimal;
			 }
			else {
			$decimal4 = explode('.', $data4);
			if($decimal4[1] == ''){
			$decimal = '.00';
			}
			else{
			$decimal = '';
			}
			$price =  "$".number_format($data4,2).$decimal;
			 }

	 } 


$propertyname = str_replace('_',' ',$totalinv[$i]->property_name);
$query = "SELECT name,lastname FROM #__users where id =".$managerid.""; 
$db->setQuery($query);
$name = $db->loadObject();
$manager_name =  $name->name.' '.$name->lastname;	


?>

<div id="i_bar_terms"  style="margin: 18px 15px 27px; background:#787878; ">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">REQUEST APPROVAL FOR AWARDING</font></span>
</div></div>

<p class="requriedmanager" align="center" > <strong> <?php echo $manager_name?></strong> needs your approval to award the following request for <strong><?php echo $propertyname;?></strong>:</p>
<p class="text-center rr-name font-15"><strong><?php echo $totalinv[$i]->projectName?></strong></p>
<p class="text-center font-15">Awarded Vendor:<strong> <?php echo $vcname;?></strong></p>
<p class="text-center font-15" style="padding-right:167px;">Awarded Amount:<strong> <?php echo $price;?></strong></p>
<div class="" id="topborder_row_remindernew" align="center" ></div>
<p align="center" class="reminder_notificationsnew" ><strong>IMPORTANT</strong>: If you deny the awarding of this request, please contact your Manager regarding any necessary changes so they can resubmit for approval.  If you approve the awarding of this request, an award email will be automatically sent to the awarded Vendor with a request to supply your Manager with a contract.  Once your Manager awards a request to a specific Vendor, they will then have the ability to RATE that Vendor, based on the service/product provided, at any time. </p>
<div class = "proprty_invitation" style=" margin-left:27px;">
<div class="reminder_notificationsbuttons" align="center"><a class="decline_rfpaward" onclick="javascript:declineawardedvendors(<?PHP echo $totalinv[$i]->id; ?>);" href="javascript:void(0);"></a></div>
<div class="reminder_notificationsbuttons" align="center"><a class="accept_rfpaward" onclick="javascript:sendmailtoawardedvendors(<?PHP echo $totalinv[$i]->id; ?>);" href="javascript:void(0);"></a></div>
</div>

<?php } 
?>
<div align="center" class="reminder_notifications_number" ><?php echo $j ;?> of <?php echo $sum; ?></div>
		
<?php } ?>	
</div>
<div id='page_navigation'></div>

<?php 
exit;
?>

