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

$pathToXML_File = JPATH_COMPONENT . DS . 'jefaqpro.xml';
$xml	 		= & JFactory::getXMLParser('Simple');
$xml->loadFile($pathToXML_File);
$document 		= & $xml->document;

$name 			= $document->name;
$version 		= $document->version;
$author 		= $document->author;
$authorurl 		= $document->authorUrl;

echo $name['0']->_data."&nbsp;".$version['0']->_data."&nbsp;-&nbsp;"; ?> <a href="http://www.jextn.com/" title="<?php echo JText::_('JE_DEVELPOED'); ?>" target="_blank"> <?php echo JText::_('JE_DEVELPOED'); ?> </a>
<!-- <br/>
<?php echo JText::_( 'JE_COMMENTS' ); ?> <a href="http://extensions.joomla.org/extensions/directory-a-documentation/faq/12645" title="<?php echo JText::_('JE_RATINGS'); ?>" target="_blank"><?php echo JText::_( 'JE_HERE' ); ?></a> -->