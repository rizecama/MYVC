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
	
	  var show_per_page = 6;  
        //getting the amount of elements inside content div  
        var number_of_items = G('#content').children().size(); 
    //alert(number_of_items); 
        //calculate the number of pages we are going to have  
        var number_of_pages = Math.ceil(number_of_items/show_per_page);  
     
        //set the value of our hidden input fields  
        G('#current_page').val(0);  
        G('#show_per_page').val(show_per_page);  
      
        //now when we got all we need for the navigation let's make it '  
      
        /* 
        what are we going to have in the navigation? 
        
            - link to previous page 
            - links to specific pages 
            - link to next page 
        */  
        var navigation_html = '<a class="previous_link" href="javascript:previous();" style="pointer-events:none;"><img class="preimg" src="templates/camassistant_left/images/left_arrow_trmp.png"></a>';  
        var current_link = 0;  
        while(number_of_pages > current_link){  
            navigation_html += '<a class="page_link" href="javascript:go_to_page(' + current_link +')" longdesc="' + current_link +'">'+ (current_link + 1) +'</a>';  
            current_link++;  
        } 
     
       if( number_of_pages == '1' ){
	   navigation_html += '<img style="margin-right:0px; margin-top:5px;" src="templates/camassistant_left/images/rght_arrow-trmp.png">';  
	   }else{
        navigation_html += '<a class="next_link" href="javascript:next();"><img style="margin-right:0px; margin-top:5px;" src="templates/camassistant_left/images/rght_arrow.png"></a>';  
      }
        G('#page_navigation').html(navigation_html);  
      
        //add active_page class to the first page link  
        G('#page_navigation .page_link:first').addClass('active_page');  
      
        //hide all the elements inside content div  
        G('#content').children().css('display', 'none');  
      
        //and show the first n (show_per_page) elements  
        G('#content').children().slice(0, show_per_page).css('display', 'block');  
      
    });  
      
    function previous(){  
      
        new_page = parseInt(G('#current_page').val()) - 1;  
		G('.next_link').html('<img src="templates/camassistant_left/images/rght_arrow.png" style="margin-right:0px; margin-top:5px;">');
        //if there is an item before the current active link run the function  
        if(G('.active_page').prev('.page_link').length==true){  
            go_to_page(new_page);  
        }  
      
    }  
      
    function next(){  
        new_page = parseInt(G('#current_page').val()) + 1; 
         var show_per_page = 6;  
        //getting the amount of elements inside content div  
        var number_of_items = G('#content').children().size(); 
    //alert(number_of_items); 
        //calculate the number of pages we are going to have  
        var number_of_pages = Math.ceil(number_of_items/show_per_page); 
		
         if(parseInt( number_of_pages - 1 ) ==  new_page || number_of_pages == new_page )
         {
		 G('.previous_link').removeAttr('style');
         G('.next_link').html('<img src="templates/camassistant_left/images/rght_arrow-trmp.png" style="margin-right:0px; margin-top:5px;">');
		 }
		 else{
		 G('.previous_link').removeAttr('style');
		 G('.next_link').html('<img src="templates/camassistant_left/images/rght_arrow.png" style="margin-right:0px; margin-top:5px;">');	
		 }

        //if there is an item after the current active link run the function  
        if(G('.active_page').next('.page_link').length==true){  
            go_to_page(new_page);  
        }  
      
    }  
    function go_to_page(page_num){  
        //get the number of items shown per page  
        var show_per_page = parseInt(G('#show_per_page').val());  
      
        //get the element number where to start the slice from  
        start_from = page_num * show_per_page;  
             if(start_from==0){
		 G('.previous_link').html('<img src="templates/camassistant_left/images/left_arrow_trmp.png" style="margin-right:50px; margin-top:5px;">');		
		 G('.preimg').addClass('add');
	 }else{
	 	G('.previous_link').html('<img src="templates/camassistant_left/images/lft-arrow.png" style="margin-right:50px; margin-top:5px;">');		
		 G( ".preimg" ).removeClass( "add" ).addClass( "remove" );
	 }
	  
        //get the element number where to end the slice  
        end_on = start_from + show_per_page;  
      
        //hide all children elements of content div, get specific items and show them  
        G('#content').children().css('display', 'none').slice(start_from, end_on).css('display', 'block');  
      
        /*get the page link that has longdesc attribute of the current page and add active_page class to it 
        and remove that class from previously active page link*/  
        G('.page_link[longdesc=' + page_num +']').addClass('active_page').siblings('.active_page').removeClass('active_page');  
      
        //update the current page input field  
        G('#current_page').val(page_num);  
    }  
function closepopup(propertid,proposalid,jobtype,rfpid)
{
	window.parent.location = "index.php?option=com_camassistant&controller=proposals&task=vendor_proposal_form&view=proposals&Prp_id="+propertid+"&rfp_id="+rfpid+"&mot_interested=0&type=invitation&id="+proposalid+"&jobtype="+jobtype+"&Itemid=112";
	window.parent.document.getElementById( 'sbox-window' ).close();
}
</script>
<?php
setcookie("invites_cookie", "invites");
setcookie("test_cookie", "test");
setcookie("nonc_cookie", "nonc");

$invitations = $this->Invitations ;

//echo "<pre>"; print_r($invitations); echo "</pre>";exit;
$sum =0;
for($s=0; $s<count($invitations); $s++)
{
	if($invitations[$s]['not_interested'] != '2' && $invitations[$s]['uninvited'] != 'uninvited' && $invitations[$s]['create_rfptype'] != 'open' ) {
		$sum++;
		}
 }

?>	

<input type='hidden' id='current_page' />  
 <input type='hidden' id='show_per_page' /> 
 <div id="content"> 
 <?php
 $deccount_pre = 0;
	for($de=0; $de<count($invitations); $de++) {
		if($invitations[$de]['not_interested'] == '2' ) {
			$deccount_pre ++ ;
			//echo $deccount_pre;exit;
		}
	}
	$uninvite_pre = 0;
	for($ue=0; $ue<count($invitations); $ue++) {
		if($invitations[$ue]['uninvited'] == 'uninvited') {
			$uninvite_pre ++ ;
			
		}
	}
	$open_pre = 0;
	for($op=0; $op<count($invitations); $op++) {
		if($invitations[$op]['create_rfptype'] == 'open') {
			$open_pre ++ ;
			
		}
	}
	$newsum = $uninvite_pre + $deccount_pre + $open_pre;

 $j=0;
for($i=0; $i<count($invitations); $i++)
{
	if($invitations[$i]['not_interested'] != '2' && $invitations[$i]['uninvited'] != 'uninvited' && $invitations[$i]['create_rfptype'] != 'open' ) {
		$j++;
		
	$rfpid=$invitations[$i]['rfp_id'];
	
	$propertyid=$invitations[$i]['property_id'];
	$proposalid=$invitations[$i]['id'];
	$jobtype=$invitations[$i]['jobtype'];
	$property_name=str_replace('_',' ',$invitations[$i]['Propertyname']);
	$db =& JFactory::getDBO();
    $user = JFactory::getUser();
	$proposalinfo = "SELECT A.id, V.jobtype, V.cust_id, V.property_id, V.rfp_type, V.projectName  FROM #__cam_vendor_availablejobs as A, #__cam_rfpinfo as V where V.id=".$rfpid." and A.rfp_id=".$rfpid." and A.user_id=".$user->id." and A.rfp_id=V.id ";
	$db->setQuery($proposalinfo);
	$ancdata = $db->loadObject();
    $custmer_id=$ancdata->cust_id;
	$managerinfo = "SELECT A.name, A.lastname, A.email, A.cellphone, C.comp_name, C.comp_zip, C.comp_city, C.comp_phno, C.comp_extnno, A.showphone, A.showfax, A.showaddress, A.showcompany, A.showemail FROM #__users as A, #__cam_customer_companyinfo as C where C.cust_id=".$custmer_id." and A.id=C.cust_id  order by A.name asc";
	$db->setQuery($managerinfo);
	$mgrinfo = $db->loadObject();
	
	if(!$mgrinfo->name)	
	$invitedname = $user->name.' '.$user->lastname;
	else
	$invitedname = $mgrinfo->name.' '.$mgrinfo->lastname;

?>


<div id="i_bar_terms"  style="margin: 15px; background:#77b800;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">PROJECT INVITATION</font></span>
</div></div>

<p class="reminder_notifications" align="center" > <?php echo 'Congrtatulatons! ' .'<strong>'.$invitedname.'</strong>'.' has invited you to pariticipate in the following request for  ' .$property_name .'<strong>: '.$ancdata->projectName.'</strong>'?>  </p>
<div class="" id="topborder_row_reminder" align="center" ></div>
<p align="center" class="reminder_notifications" >IMPORTANT: Please click VIEW INVITE to accept or decline this invitation so the Manager-user knows your intensions for providing a response to their request; otherwise, you will continue receiving this message upon log-in. </p>
<div class="reminder_notifications" align="center"><a class="accept_invite" onclick="javascript:closepopup('<?PHP echo $propertyid;  ?>','<?PHP echo $proposalid; ?>','<?php echo $jobtype; ?>','<?PHP echo $rfpid; ?>');" href="javascript:void(0);"></a></div>

<div align="center" class="reminder_notifications_number" ><?php echo $j ;?> of <?php echo $sum?></div>

<?php  } 
}?>
</div>
<div id='page_navigation'></div>
<?php

exit;
?>
