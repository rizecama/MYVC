<?php
/**
 * jeFAQ Pro package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

$path	  = JURI::root();
$model    = & $this->getModel();
$ordering = ( $this->lists['order'] == 's.ordering' || $this->lists['order'] == 'c.category' );
?>
<form action="index.php" method="post" name="adminForm">
	<table>
	<tr>
		<td align="left" width="100%">
			<?php echo JText::_( 'JE_FILTER' ); ?>:
			<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
			<button onclick="this.form.submit();"><?php echo JText::_( 'JE_FAQGO' ); ?></button>
			<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='';this.form.submit();"><?php echo JText::_( 'JE_FILTERRESET' ); ?></button>
		</td>
		<td nowrap="nowrap">
			<?php
			echo $this->lists['state'];
			?>
		</td>
		<td nowrap="nowrap">
			<?php
			echo $this->lists['catid'];
			?>
		</td>
	</tr>
	</table>

	<table class="adminlist">
		<thead>
			<tr>
				<th width="3%">
					<?php echo JText::_( 'JE_SER_NO' ); ?>
				</th>
				<th width="3%">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
				</th>
				<th  width="28%">
					<?php echo JHTML::_('grid.sort',  JText::_( 'JE_FAQ_QUESTIONS' ), 's.questions', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th  width="15%">
					<?php echo JHTML::_('grid.sort',  JText::_( 'JE_FAQ_CATEGORY' ), 'c.category', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th  width="10%">
					<?php echo JHTML::_('grid.sort',  JText::_( 'JE_FAQ_POSTEDBY' ), 's.posted_by', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th  width="10%">
					<?php echo JHTML::_('grid.sort',  JText::_( 'JE_FAQ_REMOTEIP' ), 's.remote_ip', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="5%">
					<?php echo JHTML::_('grid.sort',   JText::_( 'JE_FAQ_LIKE' ), 's.id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="5%">
					<?php echo JHTML::_('grid.sort',   JText::_( 'JE_FAQ_DISLIKE' ), 's.id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="5%">
					<?php echo JHTML::_('grid.sort',   JText::_( 'JE_FAQ_HITS' ), 's.hits', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="10%">
						<?php echo JHTML::_('grid.sort',  JText::_( 'ORDER' ), 's.ordering',$this->lists['order_Dir'], $this->lists['order']); ?>
						<?php if ($ordering) echo JHTML::_('grid.order',  $this->items ); ?>
				</th>
				<th width="5%">
					<?php echo JHTML::_('grid.sort',   JText::_( 'JE_FAQ_PUBLISHED' ), 's.state', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="3%" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   'JE_FAQ_ID', 's.id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="12">
					<?php echo $this->pageNav->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<?php
		$k = 0;
		$numFaq = count($this->items);

		for ($i=0, $n=count( $this->items ); $i < $n; $i++)	{

			$row 		= &$this->items[$i];
			$res 		= $model->getResponsecount( $row->id,$row->catid );
			if ( $res->response_yes == '' )
				$res->response_yes = 0;
			if ( $res->response_no == '' )
				$res->response_no = 0;

			$checked 	= JHTML::_('grid.id',   $i, $row->id );
			$link 		= JRoute::_( 'index.php?option=com_jefaqpro&controller=faq&task=edit&cid[]='. $row->id );

			$row->published = $row->state;
			$published		= JHTML::_('grid.published', $row, $i );

			if( $row->answers == '' && $row->gid < 25 ) {
				$new	 	= " <img src=\"$path"."administrator/components/com_jefaqpro/assets/images/new.gif\" />";
			} else {
			    $new		= '';
			}

			?>
			<tr class="<?php echo "row$k"; ?>">
				<td align="center">
					<?php echo $i+1; ?>
				</td>
				<td align="center">
					<?php echo $checked; ?>
				</td>
				<td align="left">
					<a href="<?php echo $link; ?>"><?php echo $row->questions; ?></a> <?php echo $new;  ?>
				</td>
				<td align="left">
					<?php
							if ( $row->catid == '0' ) {
								echo JText::_( 'JE_UNCATEGORISED' );
							} else {
								echo $row->category;
							}
					?>
				</td>
				<td align="left">
					<?php echo $row->posted_by; ?>
				</td>
				<td align="left">
					<?php echo $row->remote_ip; ?>
				</td>
				<td align="center">
					<?php echo $res->response_yes	; ?>
				</td>
				<td align="center">
					<?php echo $res->response_no	; ?>
				</td>
				<td align="center">
					<?php echo $row->hits	; ?>
				</td>
				<td class="order">
					<!-- Oreder Up -->
					<span>
						<?php echo $this->pageNav->orderUpIcon($i, ($row->catid == @$this->items[$i-1]->catid), 'orderup', 'Move Up', $ordering ); ?>
					</span>
					<!-- Oreder Up -->

					<!-- Oreder Down -->
					<span>
						<?php
						echo $row->catid == @$this->items[$i+1]->catid."<br/>";
						echo $this->pageNav->orderDownIcon($i, $numFaq, ($row->catid == @$this->items[$i+1]->catid), 'orderdown', 'Move Down', $ordering ); ?>
					</span>
					<!-- Oreder Up -->
					<?php $disabled = $ordering ?  '' : 'disabled="disabled"';
					?>
					<!-- order text boxes -->
					<input type="text" name="order[]" size="4" value="<?php echo $row->ordering;?>"	class="text_area" style="text-align: center" <?php echo $disabled; ?> />
				</td>
			    <td align="center">
					<?php echo $published	; ?>
				</td>
				<td align="center">
					<?php echo $row->id; ?>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
	</table>

	<input type="hidden" name="option" value="com_jefaqpro" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="controller" value="faq" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>

<?
	$com_name = urlencode("JE FAQ Pro") ;
	$dom =  urlencode($_SERVER['HTTP_HOST']) ;
	$querystr = "http://www.jextn.com/latestversion.php?name=$com_name&dom=$dom";

	if(function_exists('file_get_contents')) {
		$data = @file_get_contents($querystr);
	} else {
		$ch = @curl_init($querystr);
		@curl_setopt($ch, CURLOPT_HEADER, 0);
		@curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = @curl_exec($ch);
		@curl_close($ch);
	}
?>

<p class="copyright" align="center">
	<?php require_once( JPATH_COMPONENT . DS . 'copyright' . DS . 'copyright.php' ); ?>
</p>