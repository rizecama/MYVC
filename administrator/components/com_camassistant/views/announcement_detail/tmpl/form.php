<?php
//restricted access
defined('_JEXEC') or die('Restricted access');

// import html tooltips
JHTML::_('behavior.tooltip');

?>
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script language="javascript" type="text/javascript">
G = jQuery.noConflict();
G(document).ready(function(){
G("#usertype").change(function () {
        var value = this.value;
		if(value == 11)
		G('.industryhide').show();
		else
		G('.industryhide').hide();
		  });


		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}
			//var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");
			// do field validation
			else if(pressbutton == 'apply' || pressbutton == 'save')
			 {
				//if (form.announcement.value == "")
				 //{
					//alert( "You must provide a name." );
				 //}
				 //else
				 {
					submitform( pressbutton );
				 }
		     }
		}
		});
	</script>
	
<?php //echo "<pre>"; print_r($this->detail); ?> 


<form action="<?php echo JRoute::_($this->request_url) ?>" enctype="multipart/form-data" method="post" name="adminForm" id="adminForm">
<table class="adminheading">
		<tr>
			<th class="content">
			Announcement: <small><?php echo $this->detail->id ? 'Edit' : 'Add';?></small>
			</th>
		</tr>
		</table>
		<table width="100%">
		<tr>
			<td width="60%" valign="top">
				<table class="adminform">
				
				<tr>
					<td width="270">
				User Type:
					</td>
					<td>	<?php 
		$arr = array(
		  JHTML::_('select.option', '12', JText::_('Manager') ),
		  JHTML::_('select.option', '13', JText::_('Cam Firm Admin') ),
		  JHTML::_('select.option', '11', JText::_('Vendor') ),
		  JHTML::_('select.option', '16', JText::_('Property Owner') )
		);
 
 echo JHTML::_('select.genericlist', $arr, 'usertype', null, 'value', 'text', $this->detail->user_type);
 ?>
		
						
					</td>
				</tr>
				<?php //echo "<pre>"; print_r($this->industry); ?>
				<tr>
					<td width="270" class="industryhide">
				Industry:
					</td>
					<td  class="industryhide">
		<?php echo JHTML::_('select.genericlist', $this->industry, 'industry_name',  'size="1" '.$disabled.' class="inputbox " ', 'value', 'text', $this->detail->industry_name);?>
					</td>
					
				</tr>
				<tr>
					<td width="270">
				State:
					</td>
					<td >
						<?php echo JHTML::_('select.genericlist', $this->states, 'state_name',  'size="1" '.$disabled.' class="inputbox " ', 'value', 'text', $this->detail->state_name);?>
					</td>
					
				</tr>
			
				<tr>
					<td width="270">
				Announcement:
					</td>
					<td >
					<?php
						// parameters : areaname, content, width, height, cols, rows
						$editor=&JFactory::getEditor();
						echo $editor->display( 'announcement',  $this->detail->announcement , '30%', '200', '75', '20','false' ) ;
					?>
					</td>
					
				</tr>
				<tr>
						<td width="120" class="key" title="Click to change the state of the Category">
							<?php echo JText::_( 'Published' ); ?>:
						</td>
						<td>
							<?php echo $this->lists['published']; ?>
						</td>
					</tr>
					
		</table>
</td></tr></table>
<input type="hidden" name="cid[]" value="<?php echo $this->detail->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="announcement_detail" />
</form>


