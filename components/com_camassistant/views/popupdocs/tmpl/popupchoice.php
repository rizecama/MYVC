<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<?php

/**
 * @version		1.0.0 cam assistant $
 * @package		cam_assistant
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

// Your custom code here
JHTML::_('behavior.modal'); ?>
<?php //echo "<pre>";  print_r($this->pfiles);
session_start();
$_SESSION['taskid']= $_REQUEST['taskid']; ?>
<?php //print_r($_SESSION['taskid']);?>
<div style="padding:5px;">
<div>
<div id="dotshead_line">&nbsp;</div>
<!-- eof dotshead -->
<div id="new_bar">
<div id="new_bar_txt" style="padding:0px;line-height:33px;">
<?php 
$db = JFactory::getDBO();
$user =& JFactory::getUser();
$user_id = $user->get('id');
$pid=$_REQUEST['pid'];	
	
$from = JRequest::getVar('from','');	
$db->setQuery('Select property_name,tax_id FROM #__cam_property where id="'.$pid.'"');
$db->query();
$propert_name = $db->loadObjectList();

if($from == 'master'){
	
		$sql1 = "SELECT firmid from #__cam_masteraccounts where masterid=".$user->id." ";
			$db->Setquery($sql1);
			$subfirms = $db->loadObjectlist();
			//echo "<pre>"; print_r($subfirms); echo "</pre>";
	if($subfirms)
		{
			for( $a=0; $a<count($subfirms); $a++ )
				{
					$firmid1[] = $subfirms[$a]->firmid;
					$sql = "SELECT id from #__cam_camfirminfo where cust_id=".$subfirms[$a]->firmid." ";
					$db->Setquery($sql);
					$companyid[] = $db->loadResult();
											
				}
				//echo "<pre>"; print_r($firmid1); echo "</pre>";	
        }
			
	if($companyid)
		{
         	for( $c=0; $c<count($companyid); $c++ )
				{
					$sql_cid = "SELECT cust_id from #__cam_customer_companyinfo where comp_id=".$companyid[$c]." ";
					$db->Setquery($sql_cid);
					$managerids = $db->loadObjectList();
						if($managerids) {
							foreach( $managerids as $last_mans){
								$total_mangrs[] = $last_mans->cust_id ;
							}
						}
               }
        }
		
	if($firmid1 && $total_mangrs )
		{
            $total_mangrs = array_merge($total_mangrs,$firmid1); 
        }
		
        $userid=array($user->id);
        if($total_mangrs){
        $total_mangrs = array_merge($userid,$total_mangrs); 
		}
		else{
		$total_mangrs[] = $user->id; 
		}
		
		$totalcust_id1_arr = implode($total_mangrs,',');
		
		if(!$cid){
		$condition = " property_manager_id IN (".$totalcust_id1_arr.")";
		}else{
		$condition = " property_manager_id IN (".$cid.")";
		}
		$query = "SELECT id, property_name, tax_id, property_manager_id FROM #__cam_property where ".$condition." ";
	//$db->setQuery('Select property_name,tax_id FROM #__cam_property where id="'.$pid.'"');
		$db->setQuery($query);
		$propert_name = $db->loadObjectList();	
		//echo "<pre>";	 	print_r($propert_name); echo "</pre>";
}
?>
<?php //echo "<pre>"; print_r($_SESSION);echo "<pre>";  print_r($this->pfiles);?>
<?php if($from != 'master'){ ?>
<span><strong><?php echo  str_replace('_',' ',$propert_name[0]->property_name); ?></strong></span>
<?php } else { ?>
<span><strong>List All Properties</strong></span>
<?php } ?>


</div>
<div id="new_icon"></div>
</div>
 <link rel="stylesheet" href="templates/camassistant_inner/css/style.css" type="text/css" />
<!-- sof table pan -->
<div class="table_pannel">
<div class="table_panneldiv">
<?php if($from != 'master'){ ?>
<table width="100%" cellpadding="0" cellspacing="4">
  <tr class="newtable_green_row">
    <td width="62" align="center" valign="top">SELECT</td>
    <td width="426" align="left" valign="top">Name</td>
    <td width="141" align="center" valign="top">options</td>
    </tr>
  
<tr class="table_blue_rowdots2">
    
<td>

<a href="index2.php?option=com_camassistant&controller=popupdocs&task=pfiles&propertyname=<?php echo str_replace('"','',$propert_name[0]->property_name); ?>&taskid=<?php print_r($_SESSION['taskid']); ?>&pid=<?php echo $pid; ?>&mid=<?php echo $user_id; ?>&taxid=<?php echo $propert_name[0]->tax_id; ?>"><img src="images/folder_icon.png"  alt="folder" /></a></td>

<td><a href="index2.php?option=com_camassistant&controller=popupdocs&task=pfiles&propertyname=<?php echo str_replace('"','',$propert_name[0]->property_name); ?>&taskid=<?php print_r($_SESSION['taskid']); ?>&pid=<?php echo $pid; ?>&mid=<?php echo $user_id; ?>&taxid=<?php echo $propert_name[0]->tax_id; ?>"><?php echo $propert_name[0]->property_name; ?></a></td>

<td><a href="index2.php?option=com_camassistant&controller=popupdocs&task=pfiles&propertyname=<?php echo str_replace('"','',$propert_name[0]->property_name); ?>&taskid=<?php print_r($_SESSION['taskid']); ?>&pid=<?php echo $pid; ?>&mid=<?php echo $user_id; ?>&taxid=<?php echo $propert_name[0]->tax_id; ?>">OPEN</a></td>


</tr>
</table>
<?php } else { ?>

<table width="100%" cellpadding="0" cellspacing="4">
  <tr class="newtable_green_row">
    <td width="62" align="center" valign="top">SELECT</td>
    <td width="426" align="left" valign="top">Name</td>
    <td width="141" align="center" valign="top">options</td>
    </tr>
<?php for( $all=0; $all<count($propert_name); $all++ ){ ?>
<tr class="table_blue_rowdots2">
<td align="center">
<a href="index2.php?option=com_camassistant&controller=popupdocs&task=pfiles&propertyname=<?php echo str_replace('"','',$propert_name[$all]->property_name); ?>&taskid=<?php print_r($_SESSION['taskid']); ?>&pid=<?php echo $propert_name[$all]->id; ?>&mid=<?php echo $propert_name[$all]->property_manager_id; ?>&taxid=<?php echo $propert_name[$all]->tax_id; ?>&from=master"><img src="images/folder_icon.png"  alt="folder" /></a></td>
<td align="center">
<a href="index2.php?option=com_camassistant&controller=popupdocs&task=pfiles&propertyname=<?php echo str_replace('"','',$propert_name[$all]->property_name); ?>&taskid=<?php print_r($_SESSION['taskid']); ?>&pid=<?php echo $propert_name[$all]->id; ?>&mid=<?php echo $propert_name[$all]->property_manager_id; ?>&taxid=<?php echo $propert_name[$all]->tax_id; ?>&from=master"><?php echo str_replace('_',' ',$propert_name[$all]->property_name); ?></a>
</td>
<td align="center">
<a href="index2.php?option=com_camassistant&controller=popupdocs&task=pfiles&propertyname=<?php echo str_replace('"','',$propert_name[$all]->property_name); ?>&taskid=<?php print_r($_SESSION['taskid']); ?>&pid=<?php echo $propert_name[$all]->id; ?>&mid=<?php echo $propert_name[$all]->property_manager_id; ?>&taxid=<?php echo $propert_name[$all]->tax_id; ?>&from=master">OPEN</a></td>
</tr>
<?php } ?>
</table>
<?php } ?>

</div></div>
</div><br />
<div id="new_bar">
<div id="new_bar_txt" style="padding:0px;line-height:33px;">
<span><strong><?php echo "Shared Documents"; ?></strong></span>

</div>
</div>
<?php 
if($from == 'master')
$additional = '&from=master' ;
else
$additional = '';
?>

	<div class="table_pannel">
<div class="table_panneldiv">
<table cellspacing="4" cellpadding="0" width="100%">
  <tbody>
<tr class="newtable_green_row">
    <td valign="top" align="center" width="62">SELECT</td>
    <td valign="top" align="left" width="426">Name</td>
    <td valign="top" align="center" width="141">options</td>
    </tr>

<tr class="table_blue_rowdots2">
<!--<td><img src="images/doc.png" /></td>-->
<td><a href="index2.php?option=com_camassistant&controller=popupdocs&task=sdocs&type=shared&smid=<?php echo $user_id; ?>&taskid=<?php print_r($_SESSION['taskid']); ?>&pid=<?php echo $pid; ?><?php echo $additional; ?>"><img src="images/folder_icon.png"  alt="folder" /></a></td>
<td><a href="index2.php?option=com_camassistant&controller=popupdocs&task=sdocs&type=shared&smid=<?php echo $user_id; ?>&taskid=<?php print_r($_SESSION['taskid']); ?>&pid=<?php echo $pid; ?><?php echo $additional; ?>">Shared Files </a></td>
<td><a href="index2.php?option=com_camassistant&controller=popupdocs&task=sdocs&type=shared&smid=<?php echo $user_id; ?>&taskid=<?php print_r($_SESSION['taskid']); ?>&pid=<?php echo $pid; ?><?php echo $additional; ?>">OPEN</a>&nbsp;&nbsp;</td>

</tr>
   <tr class="table_blue_rowdots2">
   <td align="center" valign="bottom">&nbsp;</td>
   <td align="left" valign="top">&nbsp;</td>
   <td align="left" valign="top">&nbsp;</td>
   </tr>
    
    </tbody></table></div></div><div><?php exit; ?>