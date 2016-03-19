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

 $Id$

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

class mosCommonHTMLLegacy {

  // This class defines functions for things which are not included in Mambo versions prior to 4.5.2
  // so they can be called and used. It was inspired by "thede" on the Mambo forums, and much of the
  // code was taken directly from code he suggested. Thank you thede!

  function loadOverlib() {
    if (is_callable(array('mosCommonHTML', 'loadOverlib'))) {
      mosCommonHTML::loadOverlib();
    } else {
      ?>
<script
  language="Javascript"
  src="<?php echo JURI::base();;?>/includes/js/overlib_mini.js"></script>
<div
  id="overDiv"
  style="position: absolute; visibility: hidden; z-index: 10000;"></div>
      <?php
    }
  }

  function checkedOut( &$row, $overlib=1 ) {
    if (is_callable(array('mosCommonHTML', 'checkedOut'))) {
      return mosCommonHTML::checkedOut($row, $overlib);
    } else {
      $hover = '';
      if ( $overlib ) {
        $date                 = mosFormatDate( $row->checked_out_time, '%A, %d %B %Y' );
        $time                = mosFormatDate( $row->checked_out_time, '%H:%M' );
        $checked_out_text     = '<table>';
        $checked_out_text     .= '<tr><td>'. $row->editor .'</td></tr>';
        $checked_out_text     .= '<tr><td>'. $date .'</td></tr>';
        $checked_out_text     .= '<tr><td>'. $time .'</td></tr>';
        $checked_out_text     .= '</table>';
        $hover = 'onmouseover="return overlib(\''. $checked_out_text .'\', CAPTION, \'Checked Out\', BELOW, RIGHT);" onmouseout="return nd();"';
      }
      $checked             = '<img src="images/disabled.png" '. $hover .'/>';

      return $checked;
    }
  }

  function CheckedOutProcessing( &$row, $i) {
    global $my;
    if (is_callable(array('mosCommonHTML', 'CheckedOutProcessing'))) {
      return mosCommonHTML::CheckedOutProcessing($row, $i);
    } else {
      if ( $row->checked_out ) {
        $checked = mosCommonHTMLLegacy::checkedOut( $row );
      } else {
        //$checked = mosHTML::idBox( $i, $row->id, ($row->checked_out && $row->checked_out != $my->id ) );
        $checked = JHTML::_('grid.id', $i, $row->id, ($row->checked_out && $row->checked_out != $my->id ) );
      }
      return $checked;
    }
  }

  function PublishedProcessing( &$row, $i) {
    global $my;
    $img  = $row->published ? 'tick.png' : 'publish_x.png';
    $task   = $row->published ? 'unpublish' : 'publish';
    $alt  = $row->published ? 'Published' : 'Unpublished';
    $action = $row->published ? 'Unpublish Item' : 'Publish item';

    $href = '
      <a href="javascript: void(0);" onclick="return listItemTask(\'cb'. $i .'\',\''. $task .'\')" title="'. $action .'">
      <img src="images/'. $img .'" border="0" alt="'. $alt .'" />
      </a>'
      ;

      return $href;

  }
}

/**
 * @package Mambo
 * @subpackage Banners
 */
class HTML_extcalendar {

  function showAdmin()
  {
    global $mainframe;
    $registry =& JFactory::getConfig();
    $mosConfig_live_site = JURI::base();
    ?>
<center>
<table class="adminheading">
  <tr>
    <td id="yg" style="width: auto" valign="top">
    <div id="cpanel">
    <div style="float: left;">
    <div class="icon"><a
      href="index.php?option=com_jcalpro&task=editSettings">
    <div class="iconimage"><img
      src="<?php echo $mosConfig_live_site;?>images/config.png"
      alt="Categories" align="middle" name="image" border="0" /></div>
    JCal Pro Settings</a></div>
    </div>

    <div style="float: left;">
    <div class="icon"><a
      href="index.php?option=com_jcalpro&task=showCalendars">
    <div class="iconimage"><img
      src="<?php echo $mosConfig_live_site;?>../components/com_jcalpro/images/icon_48x48.png"
      alt="Settings" align="middle" name="image" border="0" /></div>
    Calendar Manager</a></div>
    </div>

    <div style="float: left;">
    <div class="icon"><a
      href="index.php?option=com_jcalpro&task=showCategories">
    <div class="iconimage"><img
      src="<?php echo $mosConfig_live_site;?>images/categories.png"
      alt="Settings" align="middle" name="image" border="0" /></div>
    Category Manager</a></div>
    </div>

    <div style="float: left;">
    <div class="icon"><a
      href="index.php?option=com_jcalpro&section=events">
    <div class="iconimage"><img
      src="<?php echo $mosConfig_live_site;?>images/addedit.png"
      alt="Events" align="middle" name="image" border="0" /></div>
    Events Manager</a></div>
    </div>

    <div style="float: left;">
    <div class="icon"><a
      href="index.php?option=com_jcalpro&task=showthemes">
    <div class="iconimage"><img
      src="<?php echo $mosConfig_live_site;?>images/templatemanager.png"
      alt="Show Themes" align="middle" name="image" border="0" /></div>
    Show Themes </a></div>
    </div>


    <div style="float: left;">
    <div class="icon"><a
      href="index.php?option=com_jcalpro&task=install&element=themes">
    <div class="iconimage"><img
      src="<?php echo $mosConfig_live_site;?>images/install.png"
      alt="Install Themes" align="middle" name="image" border="0" /></div>
    Install Themes</a></div>
    </div>

    <div style="float: left;">
    <div class="icon"><a
      href="index.php?option=com_jcalpro&task=manageImports">
    <div class="iconimage"><img
      src="<?php echo $mosConfig_live_site;?>images/dbrestore.png"
      alt="Import" align="middle" name="image" border="0" /></div>
    Import events</a></div>
    </div>

    <div style="float: left;">
    <div class="icon"><a href="index.php?option=com_jcalpro&task=about">
    <div class="iconimage"><img
      src="<?php echo $mosConfig_live_site;?>../components/com_jcalpro/images/icon_48x48.png"
      alt="About" align="middle" name="image" border="0" /></div>
    About</a></div>
    </div>

    <div style="float: left;">
    <div class="icon"><a
      href="index.php?option=com_jcalpro&task=documentation">
    <div class="iconimage"><img
      src="<?php echo $mosConfig_live_site;?>images/support.png"
      alt="Documentation" align="middle" name="image" border="0" /></div>
    Documentation</a></div>
    </div>

    <?php
    /*<div style="float:left;">
     <div class="icon">
     <a href="index.php?option=com_jce&task=lang&hidemainmenu=1">
     <div class="iconimage">
     <img src="<?php echo $mosConfig_live_site;?>images/langmanager.png" alt="Language Manager" align="middle" name="image" border="0" />       </div>
     Language Manager</a>
     </div>
     </div>*/
    ?></div>
    </td>
  </tr>
</table>
</center>
    <?php
  }


  function showSettings( &$rows, $option ) {
    global $mainframe;
    $my = &JFactory::getUser();

    //mosCommonHTMLLegacy::loadOverlib();
    JHTML::_('behavior.tooltip');
    ?>

<form action="index.php" method="post" name="adminForm"><input
  type="hidden" name="option" value="com_jcalpro"> <input type="hidden"
  name="task" value="{TASK}">

<table border="0" cellspacing="3" cellpadding="3">
  <tbody>
    <tr>
      <td valign="top">
      <h3>About JCal Pro<br />
      </h3>
      <blockquote>
      <p>JCal Pro version <?php echo CALENDAR_VERSION; ?></p>
      <p>The JCal Pro extension for Joomla is a fork of the ExtCalendar
      component for Mambo along with the Latest Events and Mini-calendar
      modules. <a
        href="http://forum.joomla.org/viewtopic.php?f=296&t=75390"
        target="_blank" title="ExtCalendar Vulnerability">Security
      vulnerabilities</a> identified in Extcalendar v0.9.1 were patched by
      David McKinnis (with help from Martin Brampton and Lynne Pope) at <a
        href="http://mamboguru.com/" target="_blank" title="Mambo Guru">mamboguru.com</a>
      and released as <a
        href="http://mamboguru.com/downloads/ExtCalendar/com_extcalendar_0_9_2_RC4.zip"
        target="_blank" title="v0.9.2 RC4">v0.9.2 release candidate 4</a>.
      v0.9.2 RC4 was used as the source code for the JCal Pro fork. See the
      <a href="http://dev.anything-digital.com/JCal-Client/Features.html"
        title="JCal Pro">JCal Pro homepage</a> for more information on new
      features.</p>
      <p>&nbsp;</p>
      <p>Both JCal Pro and ExtCalendar are based on the version 2, Beta 1
      release (and CVS files as of Feb. 23, 2005) of the <a
        href="http://extcal.sourceforge.net/" target="_blank"
        title="ExtCalendar 2">ExtCalendar 2 application</a> by Mohamed
      Moujami. The project was ported to the Mambo component by Matthew
      Friedman based on a stock installation of the calendar, with obvious
      modifications to elements like login, session management and database
      calls in order to use Mambo&#39;s existing infrastructure.&nbsp;<br />
      </p>
      <p>&nbsp;</p>
      <p>The fork of the Latest Events module is based upon <a
        href="http://mamboxchange.com/projects/extcalendar/" target="_blank"
        title="v0.7.2">v0.7.2 from mamboexchange.com</a>.<br />
      </p>
      <p>&nbsp;</p>
      <p>The fork of the Mini-calendar module upon <a
        href="http://mamboguru.com/downloads/ExtCalendar/mod_extcalendar_minical_0_8_3_RC2.zip"
        target="_blank" title="v0.8.3 RC2">v0.8.3 RC2 from mamboguru.com</a>.
      </p>
      </blockquote>
      </td>
    </tr>
    <tr>
      <td>
      <h3>License</h3>
      <blockquote>
      <p>JCal Pro is a calendar and events management extension for the <a
        href="http://www.joomla.org" target="_blank" title="Joomla!">Joomla!
      1.5.x application framework</a> and consists of the core component
      and 2 modules: (i) Latest Events and (ii) Mini-calendar. It is based
      on <a href="http://sourceforge.net/projects/extcal"
        title="Extcalendar 2">ExtCalendar 2</a>. &copy; <a
        href="http://www.anything-digital.com/" target="blank">Anything-Digital.com</a>
      2005 - 2006</p>
      <p>&nbsp;</p>
      <p>JCal Pro is free software; you can redistribute it and/or modify
      it under the terms of the <a
        href="http://www.gnu.org/licenses/old-licenses/gpl-2.0.html"
        target="_blank" title="GNU GPL">GNU General Public License</a> as
      published by the Free Software Foundation; either version 2 of the
      License, or (at your option) any later version. All existing
      copyrights (above) must be prominently visible on all modified
      versions of this software.</p>
      <p>&nbsp;</p>
      <p>This program is distributed in the hope that it will be useful,
      but WITHOUT ANY WARRANTY; without even the implied warranty of
      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the <a
        href="http://www.gnu.org/licenses/gpl.html" target="_blank"
        title="GNU GPL">GNU General Public License</a> for more details.</p>
      </blockquote>
      </td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>

</form>
    <?php
  }

  function documentation ( )
  {
    ?>
<form action="index.php" method="post" name="adminForm"><input
  type="hidden" name="option" value="com_jcalpro"> <input type="hidden"
  name="task" value="{TASK}">

<table border="0" cellspacing="3" cellpadding="3" align="left">
  <tbody>
    <tr>
      <td valign="top">
      <h3>JCal Pro Quick-Start Guide<br />
      </h3>
      <ol>
        <li>Download the <a
          href="http://dev.anything-digital.com/jcal-pro-downloads.html"
          title="JCal Pro packages" target="_blank">latest packages</a></li>

        <li>Install com_jcalpro_x.x.zip using the Joomla! component
        installer</li>
        <li>Configure the component in Joomla!'s administrative backend
        using the 'Components &gt; JCal Pro' menu item</li>
        <li>(Optional) Import any existing Extcal events using the
        'Components &gt; JCal Pro &gt; Import' menu item</li>
        <li>Make a new component menu item pointing to the JCal Pro
        component</li>

        <li>Install mod_jcalpro_latest_events_x.x.zip and
        mod_jcalpro_minical_x.x.zip using the Joomla! module installer</li>
        <li>Publish and configure the modules in Joomla!'s administrative
        backend using the 'Modules &gt; Site Modules' menu item</li>
        <li>(Optional) Unpublish any Extcal modules and menu items.&nbsp;</li>
      </ol>

      For complete documentation, visit <a
        href="http://dev.anything-digital.com/JCal-Pro-User-Manual.html"
        target="_blank">our documentation page</a></td>
    </tr>
  </tbody>
</table>
</form>
    <?php
  }

  function editSettings( $option ) {
    ?>
<script language="javascript">
    <!--
    function submitbutton(pressbutton) {
    document.adminForm.task.value = pressbutton;
      var form = document.adminForm;
      if (pressbutton == 'cancelEditSettings') {
        submitform( pressbutton );
        return;
      }
      // do field validation
      if (0 == 1) {
        alert( "Do form validation here." );
        return;
      } else {
        submitform( pressbutton );
      }
    }
    //-->
    </script>
    <?php
  }

  function showCategories( &$rows, &$pageNav, $option ) {

    $my = &JFactory::getUser();
    $database =& JFactory::getDBO();

    JHTML::_('behavior.tooltip');
    ?>
<form action="index.php" method="post" name="adminForm">
<table class="adminheading">
  <tr>
    <th>Category Manager</th>
  </tr>
</table>

<table class="adminlist">
  <tr>
    <th width="20">#</th>
    <th width="20"><input type="checkbox" name="toggle" value=""
      onClick="checkAll(<?php echo count( $rows ); ?>);" /></th>
    <th align="left" nowrap='nowrap'>Category Name</th>
    <th align="center" width="10%" nowrap='nowrap'>Published</th>
    <th align="center" width="11%" nowrap='nowrap'>Category Color</th>
    <th align="center" width="11%" nowrap='nowrap'>Permission</th>
    <th align="center" width="11%" nowrap='nowrap'>Category ID</th>
    <th align="center" width="16%">Events</th>
  </tr>
  <?php
  $k = 0;
  for ($i=0, $n=count( $rows ); $i < $n; $i++) {
      $row = &$rows[$i];

      $row->id  = $row->cat_id;
      $link     = 'index.php?option=com_jcalpro&task=editCategory&hidemainmenu=1&cat_id='. $row->cat_id;

      $eventsQuery = "SELECT * FROM #__jcalpro2_events WHERE cat = '{$row->cat_id}'";
      $database->setQuery( $eventsQuery );
      $number_query = $database->query();
      $number_of_events = $database->getNumRows( $number_query );

      $task   = $row->published ? 'unpublish' : 'publish';
      $img  = $row->published ? 'tick.png' : 'publish_x.png';
      $alt  = $row->published ? 'Published' : 'Unpublished';

      $checked  = mosCommonHTMLLegacy::CheckedOutProcessing( $row, $i );
      $published  = mosCommonHTMLLegacy::PublishedProcessing( $row, $i );
      ?>
  <tr class="<?php echo "row$k"; ?>">
    <td align="center"><?php //echo $pageNav->rowNumber( $i );
      echo $pageNav->getRowOffset( $i ); ?></td>
    <td align="center"><?php echo $checked; ?></td>
    <td align="left"><?php
    if ( $row->checked_out && ( $row->checked_out != $my->id ) ) {
      echo $row->name;
    } else {
      ?> <a href="<?php echo $link; ?>" title="Edit Category"> <?php echo $row->cat_name; ?>
    </a> <?php
    }
    ?></td>
    <td align="center"><?php echo $published;?></td>
    <td align="center">
    <table bgcolor="<?php echo $row->color;?>"
      style="border: 1px solid black">
      <tr>
        <td style="border: none; padding: 0px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>
    </table>
    </td>
    <td align="center"><?php echo $row->level;?></td>
    <td align="center"><?php echo $row->id ?></td>
    <td align="center"><?php echo $number_of_events;?></td>
  </tr>
  <?php
  $k = 1 - $k;
  }
  ?>
</table>
  <?php echo $pageNav->getListFooter(); ?> <input type="hidden"
  name="option" value="<?php echo $option; ?>"> <input type="hidden"
  name="task" value="showCategories"> <input type="hidden"
  name="taskSave" value="showCategories"> <input type="hidden"
  name="boxchecked" value="0"> <input type="hidden" name="hidemainmenu"
  value="0"></form>
  <?php
  }

  function editCategory( $option ) {
    ?>
<script language="javascript">
    <!--
    function submitbutton(pressbutton) {
    document.adminForm.task.value = pressbutton;
      var form = document.adminForm;
      if (pressbutton == 'cancelEditCategory') {
        submitform( pressbutton );
        return;
      }
      // do field validation
      if (form.cat_name.value == "") {
        alert( "You must specify a category name." );
        return;
      } else if (form.color.value == "") {
        alert( "You must specify a category color." );
        return;
      } else {
        submitform( pressbutton );
      }
    }
    //-->
    </script>
    <?php
  }

  function showCalendars( &$rows, &$pageNav, $option ) {

    $my = &JFactory::getUser();
    $database =& JFactory::getDBO();

    JHTML::_('behavior.tooltip');
    ?>
<form action="index.php" method="post" name="adminForm">
<table class="adminheading">
  <tr>
    <th>Calendar Manager</th>
  </tr>
</table>

<table class="adminlist">
  <tr>
    <th width="20">#</th>
    <th width="20"><input type="checkbox" name="toggle" value=""
      onClick="checkAll(<?php echo count( $rows ); ?>);" /></th>
    <th align="left" nowrap='nowrap'>Calendar Name</th>
    <th align="center" width="10%" nowrap='nowrap'>Published</th>
    <th align="center" width="11%" nowrap='nowrap'>Permission</th>
    <th align="center" width="11%" nowrap='nowrap'>Calendar ID</th>
    <th align="center" width="16%">Events</th>
  </tr>
  <?php
  $k = 0;
  for ($i=0, $n=count( $rows ); $i < $n; $i++) {
      $row = &$rows[$i];

      $row->id  = $row->cal_id;
      $link     = 'index.php?option=com_jcalpro&task=editCalendar&hidemainmenu=1&cal_id='. $row->cal_id;

      $eventsQuery = "SELECT * FROM #__jcalpro2_events WHERE cal_id = '{$row->cal_id}'";
      $database->setQuery( $eventsQuery );
      $number_query = $database->query();
      $number_of_events = $database->getNumRows( $number_query );

      $task   = $row->published ? 'unpublish' : 'publish';
      $img  = $row->published ? 'tick.png' : 'publish_x.png';
      $alt  = $row->published ? 'Published' : 'Unpublished';

      $checked  = mosCommonHTMLLegacy::CheckedOutProcessing( $row, $i );
      $published  = mosCommonHTMLLegacy::PublishedProcessing( $row, $i);
      ?>
  <tr class="<?php echo "row$k"; ?>">
    <td align="center"><?php
    echo $pageNav->getRowOffset( $i ); ?></td>
    <td align="center"><?php echo $checked; ?></td>
    <td align="left"><?php
    if ( $row->checked_out && ( $row->checked_out != $my->id ) ) {
      echo $row->name;
    } else {
      ?> <a href="<?php echo $link; ?>" title="Edit Calendar"> <?php echo $row->cal_name; ?>
    </a> <?php
    }
    ?></td>
    <td align="center"><?php echo $published;?></td>

    <td align="center"><?php echo $row->level;?></td>
    <td align="center"><?php echo $row->cal_id ?></td>
    <td align="center"><?php echo $number_of_events;?></td>
  </tr>
  <?php
  $k = 1 - $k;
  }
  ?>
</table>
  <?php echo $pageNav->getListFooter(); ?> <input type="hidden"
  name="option" value="<?php echo $option; ?>"> <input type="hidden"
  name="task" value="showCalendars"> <input type="hidden" name="taskSave"
  value="showCalendars"> <input type="hidden" name="boxchecked" value="0">
<input type="hidden" name="hidemainmenu" value="0"></form>
  <?php
  }

  function editCalendar( $option ) {
    ?>
<script language="javascript">
    <!--
    function submitbutton(pressbutton) {
    document.adminForm.task.value = pressbutton;
      var form = document.adminForm;
      if (pressbutton == 'cancelEditCalendar') {
        submitform( pressbutton );
        return;
      }
      // do field validation
      if (form.cal_name.value == "") {
        alert( "You must specify a calendar name." );
        return;
      } else {
        submitform( pressbutton );
      }
    }
    //-->
    </script>
    <?php
  }

  function import ( $cals )
  {
    ?>
<form action="index.php" method="post" name="adminForm"><input
  type="hidden" name="option" value="com_jcalpro"> <input type="hidden"
  name="task" value="{TASK}">

<table class="adminheading">
  <tr>
    <th class="dbrestore">Import</th>
  </tr>
</table>

<table class="adminlist">
  <tr>
    <th width="20%" align="left">Other installed calendars</th>
    <th width="80%" align="left">Import</th>
  </tr>

  <?php

  if ( count ( $cals ) > 0 )
  {
    foreach ( $cals as $calsKey => $calsValue )
    {
      echo '
              <tr>
                <td>
                ' . $calsValue['name'] . '
                </td>
                <td>
                  <a href="?option=com_jcalpro&task=importCalendar&id=' . $calsValue['id'] . '"><img src="images/restore_f2.png" border="0"></a>
                </td>
              </tr>
            ';
    }
  }
  else
  {
    echo '
              <tr>
                <td colspan="2">
                  JCal Pro can automatically detect and import events from JCal pro 1.5.x. However, no previous installations were found. If you would like to import events from other calendars, please request one on the JCal Pro Feature <a href="http://dev.anything-digital.com/index.php?option=com_smf&Itemid=40&board=3.0" target="_blank">Request board</a> or contact our <a href="http://dev.anything-digital.com/index.php?option=com_contact&task=view&contact_id=1&Itemid=43" target="_blank">sales department</a>.
                </td>
              </tr>
            ';
  }
  ?>

</table>
</form>
  <?php
  }

  /**
   * Display a form allowing to select
   * which kind of import can be performed
   *
   * @param $lists array of pre-calculated html elements
   * @return unknown_type
   */
  function manageImports ( $lists)
  {

    JToolBarHelper::title( 'Import events', 'generic.png' );

    ?>
<script type="text/javascript">
      /* <![CDATA[ */
      function submitbuttoniCal(pressbutton) {
        var form = document.adminFormiCal;
         form.task.value = pressbutton;

         // do field validation
         if (pressbutton == 'iCalImportFromFile' && form.userfile.value == ""){
            alert('Please select a file first');
            return false;
         }
         if (pressbutton == 'iCalImportFromURL' && form.remoteUrl.value == ""){
           alert('Please type a valid URL');
           return false;
         }
         if (typeof form.onsubmit == "function") {
		      form.onsubmit();
	       }
	       form.submit();

         return;
      }
      /* ]]> */
    </script>
<table class="adminheading">
  <tr>
    <th>
    <h2>Import from JCal pro previous version in database</h2>
    </th>
  </tr>
</table>

<form action="index.php" method="post" name="adminForm"><input
  type="hidden" name="option" value="com_jcalpro"> <input type="hidden"
  name="task" value="{TASK}">

<table class="adminlist">
  <tr>
    <th width="20%" align="left">Other installed calendars</th>
    <th width="80%" align="left">Import</th>
  </tr>

  <?php

  if ( count ( $lists['previousJCalCalendars'] ) > 0 )
  {
    foreach ( $lists['previousJCalCalendars'] as $calsKey => $calsValue )
    {
      echo '
              <tr>
                <td>
                ' . $calsValue['name'] . '
                </td>
                <td>
                  <a href="?option=com_jcalpro&task=importCalendar&id=' . $calsValue['id'] . '"><img src="images/restore_f2.png" border="0"></a>
                </td>
              </tr>
            ';
    }
  }
  else
  {
    echo '
              <tr>
                <td colspan="2">
                  JCal Pro can automatically detect and import events from JCal pro 1.5.x. However, no previous installations were found. If you would like to import events from other calendars, please request one on the JCal Pro Feature <a href="http://dev.anything-digital.com/index.php?option=com_smf&Itemid=40&board=3.0" target="_blank">Request board</a> or contact our <a href="http://dev.anything-digital.com/index.php?option=com_contact&task=view&contact_id=1&Itemid=43" target="_blank">sales department</a>.
                </td>
              </tr>
            ';
  }
  ?>

</table>
</form>

<table class="adminheading">
  <tr>
    <th>
    <h2>Import from an iCal source (local file or remote url)</h2>
    </th>
  </tr>
</table>

<form method="post" action="index.php" enctype="multipart/form-data" name="adminFormiCal" >
<table class="adminlist">

  <tr>
    <td width="20%">Select target calendar and category :</td>
    <td valign="middle">
    <?php
      echo $lists['calendars'];
      echo '&nbsp;';
      echo $lists['categories'];
      echo '&nbsp;';
      echo $lists['guesscategories'];
    ?>
    </td>
  </tr>

  <tr>
    <td width="20%">Import events from a local iCal (*.ics) file :</td>
    <td>
      <input type="file" name="userfile" size="80" />
      <input type="button" class="button" value="Import from local ics file"
      onclick="submitbuttoniCal('iCalImportFromFile')" />
    </td>
  </tr>
  <tr>
    <td>Import events from a remote iCal file :</td>
    <td>
      <input type="text" name="remoteUrl" size="80" />
      <input type="button" class="button" value="Import from a remote URL"
      onclick="submitbuttoniCal('iCalImportFromURL')" />
    </td>
  </tr>

</table>

<input type="hidden" name="option" value="com_jcalpro">
<input type="hidden" name="task" value="">
<?php echo JHtml::_('form.token'); ?>
</form>
    <?php
  }

}
