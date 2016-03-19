<?php defined('_JEXEC') or die('Restricted access');?>

<form action="index.php" method="post" name="adminForm">
<table class="adminform">
	<tr>
		<td width="55%" valign="top">
			<div id="phocamenu-cpanel">
			<div id="cpanel">
	<?php
	$component = 'com_phocapdf';
	
	$link = 'index.php?option='.$component.'&view=phocaplugins';
	echo PhocaPDFControlPanel::quickIconButton( $component, $link, 'icon-48-pdf.png', JText::_( 'Plugins' ) );
	
	$link = 'index.php?option='.$component.'&view=phocafonts';
	echo PhocaPDFControlPanel::quickIconButton( $component, $link, 'icon-48-font.png', JText::_( 'Fonts' ) );
	
	$link = 'index.php?option='.$component.'&view=phocainfo';
	echo PhocaPDFControlPanel::quickIconButton( $component, $link, 'icon-48-info.png', JText::_( 'Info' ) );
	?>
			
			<div style="clear:both">&nbsp;</div>
			<p>&nbsp;</p>
			<div style="text-align:center;padding:0;margin:0;border:0">
			<iframe style="padding:0;margin:0;border:0" src="http://www.phoca.cz/adv/phocapdf" noresize="noresize" frameborder="0" border="0" cellspacing="0" scrolling="no" width="500" marginwidth="0" marginheight="0" height="125">
				<a href="http://www.phoca.cz/adv/phocapdf" target="_blank">Phoca PDF</a>
				</iframe>
			</div>
			
			
			</div>
			</div>
		</td>
		
		<td width="45%" valign="top">
			<div style="300px;border:1px solid #ccc;background:#fff;margin:15px;padding:15px">
			<div style="float:right;margin:10px;">
				<?php
					echo JHTML::_('image.site',  'logo-phoca.png', '/components/com_phocapdf/assets/images/', NULL, NULL, 'Phoca.cz' )
				?>
			</div>
			<div id="phocamenu-info">
			<h3><?php echo JText::_('Version');?></h3>
			<p><?php echo $this->version ;?></p>

			<h3><?php echo JText::_('Copyright');?></h3>
			<p>© 2007 - <?php echo date("Y"); ?> Jan Pavelka</p>
			<p><a href="http://www.phoca.cz/" target="_blank">www.phoca.cz</a></p>

			<h3><?php echo JText::_('License');?></h3>
			<p><a href="http://www.gnu.org/licenses/gpl-2.0.html" target="_blank">GPLv2</a></p>
			<p>&nbsp;</p>
			</div>
			
			<div id="pg-update"><a href="http://www.phoca.cz/version/index.php?phocapdf=<?php echo $this->version ;?>" target="_blank"><?php echo JText::_('Check for update'); ?></a></div>
			<div id="pg-update"><a href="http://www.phoca.cz/phocapdf-plugins" target="_blank"><?php echo JText::_('Check for available plugins'); ?></a></div>
			<div id="pg-update"><a href="http://www.phoca.cz/phocapdf-fonts" target="_blank"><?php echo JText::_('Check for available fonts'); ?></a></div>
			
			
			</div>
		</td>
	</tr>
</table>

<input type="hidden" name="option" value="com_phocapdf" />
<input type="hidden" name="view" value="phocapdfcp" />
<input type="hidden" name="<?php echo JUtility::getToken(); ?>" value="1" />
</form>