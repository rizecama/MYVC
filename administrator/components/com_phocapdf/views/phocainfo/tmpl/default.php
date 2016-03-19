<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>

<form action="index.php" method="post" name="adminForm">
<div style="float:right;margin:10px;">
	<?php
	echo JHTML::_('image.site',  'logo-phoca.png', '/components/com_phocapdf/assets/images/', NULL, NULL, 'Phoca.cz' )
	?>
</div>

<?php echo  JHTML::_('image.site', 'logo-product.png', 'components/com_phocapdf/assets/images/', NULL, NULL, 'Phoca.cz');?>

<h3><?php echo JText::_('Help');?></h3>

<div id="phocamenu-info">
<p>
<a href="http://www.phoca.cz/phocapdf/" target="_blank">Phoca PDF Main Site</a><br />
<a href="http://www.phoca.cz/documentation/" target="_blank">Phoca PDF User Manual</a><br />
<a href="http://www.phoca.cz/forum/" target="_blank">Phoca PDF Forum</a><br />
</p>

<h3><?php echo JText::_('Version');?></h3>
<p><?php echo $this->version ;?></p>

<h3><?php echo JText::_('Copyright');?></h3>
<p>© 2007 - <?php echo date("Y"); ?> Jan Pavelka</p>

<h3><?php echo JText::_('License');?></h3>
<p><a href="http://www.gnu.org/licenses/gpl-2.0.html" target="_blank">GPLv2</a></p>


<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_phocapdf" />
<input type="hidden" name="controller" value="phocainfo" />
</form>
<p>&nbsp;</p>
</div>

<div style="border-top:1px solid #c2c2c2"></div>
<div id="pg-update" ><a href="http://www.phoca.cz/version/index.php?phocapdf=<?php echo $this->version ;?>" target="_blank"><?php echo JText::_('Check for update'); ?></a></div>