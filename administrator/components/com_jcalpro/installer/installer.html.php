<?php
/*
 **********************************************
 JCal Pro
 Copyright (c) 2006-2010 Anything-Digital.com
 **********************************************
 JCal Pro is a fork of the existing Extcalendar component for Joomla!
 (com_extcal_0_9_2_RC4.zip from mamboguru.com).
 Extcal (http://sourceforge.net/projects/extcal) was renamed
 and adapted to become a Mambo/Joomla! component by
 Matthew Friedman, and further modified by David McKinnis
 (mamboguru.com) to repair some security holes.

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This header must not be removed. Additional contributions/changes
 may be added to this header as long as no information is deleted.
 **********************************************

 $Id: installer.html.php 706 2011-02-28 16:23:10Z jeffchannell $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

function writableCell( $folder ) {
  echo '<tr>';
  echo '<td class="item">' . $folder . '/</td>';
  echo '<td align="left">';
  echo is_writable(JPATH_ROOT . DS . $folder ) ? '<b><font color="green">Writeable</font></b>' : '<b><font color="red">Unwriteable</font></b>' . '</td>';
  echo '</tr>';
}

/**
 * @package Joomla
 */
class HTML_installer {

  function showInstallForm( $title, $option, $element, $client = "", $p_startdir = "", $backLink="" ) {
    $database = &JFactory::getDBO();

    //$database->setQuery( "SELECT lang FROM #__jcalpro2_langs WHERE published= '1'" );
    //$lang = $database->loadResult();
    ?>
<script language="javascript" type="text/javascript">
		function submitbutton3(pressbutton) {
			var form = document.adminForm_dir;

			// do field validation
			if (form.userfile.value == ""){
				alert( "Please select a directory" );
			} else {
				form.submit();
			}
		}
		</script>
<form enctype="multipart/form-data" action="index.php" method="post"
	name="filename">
<table class="adminheading">
	<tr>
		<th class="install"><?php echo $title;?></th>
		<td align="right" nowrap="true"><?php echo $backLink;?></td>
	</tr>
</table>

<table class="adminform">
	<tr>
		<th><?php echo _EXTCAL_INS_PACKAGE_UPLOAD;?></th>
	</tr>
	<tr>
		<td align="left"><?php echo _EXTCAL_INS_PACKAGE_FILE;?>: <input
			class="text_area" name="userfile" type="file" size="70" /> <input
			class="button" type="submit"
			value="<?php echo _EXTCAL_INS_UPLOAD_BUTTON;?>" /></td>
	</tr>
</table>

<input type="hidden" name="task" value="uploadfile" /> <input
	type="hidden" name="option" value="<?php echo $option;?>" /> <input
	type="hidden" name="element" value="<?php echo $element;?>" /> <input
	type="hidden" name="client" value="<?php echo $client;?>" /></form>
<br />

<form enctype="multipart/form-data" action="index.php" method="post"
	name="adminForm_dir">
<table class="adminform">
	<tr>
		<th><?php echo _EXTCAL_INS_INSTALL;?></th>
	</tr>
	<tr>
		<td align="left"><?php echo _EXTCAL_INS_INSTALL_DIR;?>:&nbsp; <input
			type="text" name="userfile" class="text_area" size="65"
			value="<?php echo $p_startdir; ?>" />&nbsp; <input type="button"
			class="button" value="<?php echo _EXTCAL_INS_INSTALL_BUTTON;?>"
			onclick="submitbutton3()" /></td>
	</tr>
</table>

<input type="hidden" name="task" value="installfromdir" /> <input
	type="hidden" name="option" value="<?php echo $option;?>" /> <input
	type="hidden" name="element" value="<?php echo $element;?>" /> <input
	type="hidden" name="client" value="<?php echo $client;?>" /></form>
    <?php
  }

  /**
   * @param string
   * @param string
   * @param string
   * @param string
   */
  function showInstallMessage( $message, $title, $url ) {
    ?>
<table class="adminheading">
	<tr>
		<th class="install"><?php echo $title; ?></th>
	</tr>
</table>

<table class="adminform">
	<tr>
		<td align="left"><strong><?php echo $message; ?></strong></td>
	</tr>
	<tr>
		<td colspan="2" align="center">[&nbsp;<a href="<?php echo $url;?>"
			style="font-size: 16px; font-weight: bold">Continue ...</a>&nbsp;]</td>
	</tr>
</table>
    <?php
  }
}
