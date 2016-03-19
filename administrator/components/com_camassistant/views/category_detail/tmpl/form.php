<?php
//restricted access
defined('_JEXEC') or die('Restricted access');

// import html tooltips
JHTML::_('behavior.tooltip');

?>

	<script language="javascript" type="text/javascript">
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
				if (trim(form.industry_name.value) == "")
				 {
					alert( "You must provide a name." );
				 }
				 else
				 {
					submitform( pressbutton );
				 }
		     }
		}
		
	</script>

<form action="<?php echo JRoute::_($this->request_url) ?>" method="post" name="adminForm" id="adminForm">
		<table class="adminheading">
		<tr>
			<th class="content">
			Industry: <small><?php echo $this->detail->id ? 'Edit' : 'Add';?></small>
			</th>
		</tr>
		</table>

		<table width="100%">
		<tr>
			<td width="60%" valign="top">
				<table class="adminform">
				<tr>
					<th colspan="2">
					Industry Details
					</th>
				</tr>
				<tr>
					<td width="130" title="This is the name of the Category as it will appear to users">
					Name:
					</td>
					<td title="This is the name of the Category as it will appear to users">
					<input type="text" name="industry_name" class="inputbox" size="40" value="<?php echo $this->detail->industry_name; ?>" maxlength="50" />(*)
					</td>
				</tr>

					
				
				<tr>
					<td title="This is a general description of the Category">
					Description:
					</td>
					<td title="This is a general description of the Category">
					<?php
						// parameters : areaname, content, width, height, cols, rows
						$editor=&JFactory::getEditor();
						echo $editor->display( 'industry_desc',  $this->detail->industry_desc , '100%', '250', '75', '20' ) ;
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
			</td>
			
		</tr>
		</table>

<input type="hidden" name="cid[]" value="<?php echo $this->detail->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="category_detail" />
</form>


