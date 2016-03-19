<?php
/**
 * jeFaq pro package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

function com_install()
{

	// Joomla predefiend function to connect db
	$db			= & JFactory::getDBO();

	// Add new field( catid )
	$query 		= "SELECT `catid`, `gid`, `posted_by`, `posted_date`, `posted_email`, `hits`, `remote_ip`, `email_status` FROM #__je_faq";
	$db->setQuery( $query );

	// Check whether this field name is already there.
	if(!$db->query()) {
		$query  = "ALTER TABLE  `#__je_faq` ADD  `catid` int( 11 ) NOT NULL AFTER  `state`, " .
				  " ADD `gid` int( 11 ) NOT NULL AFTER  `catid`, " .
				  " ADD `posted_by` varchar( 200 ) NOT NULL AFTER  `gid`, " .
				  " ADD `posted_date` datetime NOT NULL AFTER  `posted_by`, " .
				  " ADD `posted_email` varchar( 200 ) NOT NULL AFTER  `posted_date`," .
				  " ADD `hits` int( 11 ) NOT NULL AFTER  `posted_email`, " .
				  " ADD `remote_ip` varchar( 200 ) NOT NULL AFTER  `hits`, " .
				  " ADD `email_status` tinyint( 3 ) NOT NULL AFTER  `remote_ip`  " ;
		$db->setQuery( $query );
		$db->query();
	}


	// Add new field( sorting & grouping )
	$query 		= "SELECT `group`, `sorting` FROM #__je_faq_settings";
	$db->setQuery( $query );

	// Check whether this field name is already there.
	if(!$db->query()) {
		$query  = "ALTER TABLE  `#__je_faq_settings` ADD  `group` varchar( 100 ) NOT NULL AFTER  `date_format`, " .
				  " ADD `sorting` varchar( 100 ) NOT NULL AFTER  `group` ";
		$db->setQuery( $query );
		$db->query();
	}

	// Insert default configuration details
	$query 		= "SELECT count(*) FROM #__je_faq_settings";
	$db->setQuery( $query );
	$total_rows = $db->loadResult();

	// Check the whether the data's already there.
	if(!$total_rows) {
		$query  = "INSERT INTO `#__je_faq_settings` " .
				" (`id`, `show_title`, `introtext`, `show_image`, `show_form`, `show_reguser`, `show_author`, `show_date`, `show_captcha`, `show_hits`, `allow_reg`, `show_response`, `footer_text`, `user_email`, `admin_email`, `emailid`, `themes`, `cat_perpage`, `resize`, `image_width`, `image_height`, `date_format`, `group`, `sorting`) " .
				" VALUES " .
				" (1, 1, 1, 1, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, 'admin@email.com', 1, 5, 1, 25, 25, '%A, %d %B %Y', 'ordering', 'desc' )";
		$db->setQuery( $query );
		$db->query();
	} else {
		$query 		= "SELECT `group`, `sorting` FROM #__je_faq_settings";
		$db->setQuery( $query );
		$sort = $db->loadObject();

		if( ( $sort->group == '' && $sort->sorting == '' ) ) {
			$query = "UPDATE `#__je_faq_settings` SET `group`='ordering', `sorting`='desc' WHERE id='1'";
			$db->setQuery( $query );
			$db->query();
		}
	}

	// Insert template styles..
	$query 		= "SELECT count(*) FROM #__je_faq_themes";
	$db->setQuery( $query );
	$total_rows = $db->loadResult();

	if(!$total_rows) {
		$query = "INSERT INTO `#__je_faq_themes` (`id`, `themes`) VALUES
				(1, 'Triangular Light Blue'),
				(2, 'Light White'),
				(3, 'Medium Purple Arrow'),
				(4, 'Cadet Blue  Wheel'),
				(5, 'Parrot Green Circle'),
				(6, 'Light Steel Blue'),
				(7, 'Light Yellow Circle'),
				(8, 'Linen Arrow in Circle'),
				(9, 'Golden Rod Sqare'),
				(10, 'Black Triangle'),
				(11, 'Prosperity'),
				(12, 'Dependability'),
				(13, 'Earthiness'),
				(14, 'Freshness'),
				(15, 'Truthfulness'),
				(16, 'Sunshine'),
				(17, 'Moderation'),
				(18, 'Royalty'),
				(19, 'Strength and Endurance'),
				(20, 'Highly Spiritual'),
				(21, 'Cloudy'),
				(22, 'Multi High Spiritual'),
				(23, 'Multi line Freshness'),
				(24, 'Multi Strength and Endurance')";
		$db->setQuery( $query );
		$db->query();
	} else {
		if ( $total_rows < 22) {
			$query = "INSERT INTO `#__je_faq_themes` (`id`, `themes`) VALUES
					(22, 'Multi High Spiritual'),
					(23, 'Multi line Freshness'),
					(24, 'Multi Strength and Endurance')";
			$db->setQuery( $query );
			$db->query();
		}
	}
	
	//Configured with joomfish component.
	if(JFolder::exists(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_joomfish'.DS.'contentelements')) {
		if (!JFile::exists(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'je_faq.xml')) {
			JFile::move(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_jefaqpro'.DS.'joomfish'.DS.'je_faq.xml',JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'je_faq.xml');
		}

		if (!JFile::exists(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'je_faq_category.xml')) {
			JFile::move(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_jefaqpro'.DS.'joomfish'.DS.'je_faq_category.xml',JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'je_faq_category.xml');
		}

		if ( JFile::exists(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'je_faq.xml') && JFile::exists(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'je_faq_category.xml')) {
			JFolder::delete(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_jefaqpro'.DS.'joomfish');
		}
	}

	//Configured with sh404sef component.
	if(JFolder::exists(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_sh404sef'.DS.'language'.DS.'plugins')) {
		if (!JFile::exists(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_sh404sef'.DS.'language'.DS.'plugins'.DS.'com_jefaqpro.php')) {
			JFile::move(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_jefaqpro'.DS.'sh404sef'.DS.'com_jefaqpro.php',JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_sh404sef'.DS.'language'.DS.'plugins'.DS.'com_jefaqpro.php');
			JFolder::delete(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_jefaqpro'.DS.'sh404sef');
		}
	}

	
	// Code for Install jetestimonial content plugin.
		if (!JFile::exists(JPATH_ROOT.DS.'plugins'.DS.'search'.DS.'jefaqpro.php')) {
			JFile::move(JPATH_ROOT.DS.'components'.DS.'com_jefaqpro'.DS.'plg_jefaqprosearch'.DS.'jefaqpro.php',JPATH_ROOT.DS.'plugins'.DS.'search'.DS.'jefaqpro.php');

			if (!JFile::exists(JPATH_ROOT.DS.'plugins'.DS.'search'.DS.'jetestimonial.xml')) {
				JFile::move(JPATH_ROOT.DS.'components'.DS.'com_jefaqpro'.DS.'plg_jefaqprosearch'.DS.'jefaqpro.xml',JPATH_ROOT.DS.'plugins'.DS.'search'.DS.'jefaqpro.xml');
			}

			if (!JFile::exists(JPATH_ROOT.DS.'administrator'.DS.'language'.DS.'en-GB'.DS.'en-GB.plg_search_jefaqpro.ini')) {
				JFile::move(JPATH_ROOT.DS.'components'.DS.'com_jefaqpro'.DS.'plg_jefaqprosearch'.DS.'en-GB.plg_search_jefaqpro.ini',JPATH_ROOT.DS.'administrator'.DS.'language'.DS.'en-GB'.DS.'en-GB.plg_search_jefaqpro.ini');
			}

			if(JFile::exists(JPATH_ROOT.DS.'plugins'.DS.'search'.DS.'jefaqpro.php') && JFile::exists(JPATH_ROOT.DS.'plugins'.DS.'search'.DS.'jefaqpro.xml') && JFile::exists(JPATH_ROOT.DS.'administrator'.DS.'language'.DS.'en-GB'.DS.'en-GB.plg_search_jefaqpro.ini')) {

				// Insert plugin details.
				$query = "INSERT INTO `#__plugins` (`id`, `name`, `element`, `folder`, `access`, `ordering`, `published`, `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`) VALUES " .
						 "('', 'Search - JE Faqpro', 'jefaqpro', 'search', '0', 0, '1', '0', '0', '0', '0000-00-00 00:00:00', '')";
				$db->setQuery( $query );
				$db->query();

				JFolder::delete(JPATH_ROOT.DS.'components'.DS.'com_jefaqpro'.DS.'plg_jefaqprosearch');
			}
		}
	// Code ended for Install content plugin.
	
	// Message area.
	if (JFolder::exists(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_jefaqpro') && JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_jefaqpro')) {
		echo '<p> <b> <span style="color:#009933"> JE FAQ Pro component & plugin  has been Installed Successfully. </span> </b> </p>';
	}

}
?>

