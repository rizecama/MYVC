<?php
/**
 * SEF module for Joomla!
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007-2010
 * @package     sh404SEF-15
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: html.php 2151 2011-11-17 20:46:48Z silianacom-svn $
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefHelperHtml {


  /**
   * Method to create a select list of the installed components
   *
   * @access  public
   * @param int ID of current item
   * @param string name of select list
   * @param boolean if true, changing selected item will submit the form (assume is an "adminForm")
   * @param boolean, if true, a line 'Select all' is inserted at the start of the list
   * @param string the "Select all" to be displayed, if $addSelectAll is true
   * @return  string HTML output
   */
  public function buildComponentsSelectList( $current, $name, $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '', $customSubmit = '') {

    // load components from DB
    $components = Sh404sefHelperGeneral::getComponentsList();

    // adjust to require format
    $data = array();
    if (!empty( $components)) {
      foreach( $components as $component) {
        $data[] = array( 'id' => $component->option, 'title' => $component->name);
      }
    }

    // use helper to build html
    $list = self::buildSelectList( $data, $current, $name, $autoSubmit, $addSelectAll, $selectAllTitle, $customSubmit);

    // return list
    return $list;

  }

  /**
   * Builds a select list with all possible user levels
   *
   * Adapted from JCal pro
   *
   * @param $current
   * @param $name
   * @param $autoSubmit
   * @param $addSelectAll
   * @param $selectAllTitle
   */
  public function buildUserLevelsList( $current, $name, $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '', $customSubmit = '') {

    // get a list of available user groups
    $groups = Sh404sefHelperGeneral::getUserGroups();

    // build html options
    $data = array();
    foreach( $groups as $id => $group) {
      $data[] = array( 'id' => $group, 'title' => $group);
    }

    // use helper to build html
    $list = self::buildSelectList( $data, $current, $name, $autoSubmit, $addSelectAll, $selectAllTitle, $customSubmit);

    // return list
    return $list;

  }

  /**
   * Method to create a select list of the installed components
   *
   * @access  public
   * @param int ID of current item
   * @param string name of select list
   * @param boolean if true, changing selected item will submit the form (assume is an "adminForm")
   * @param boolean, if true, a line 'Select all' is inserted at the start of the list
   * @param string the "Select all" to be displayed, if $addSelectAll is true
   * @return  string HTML output
   */
  function buildLanguagesSelectList( $current, $name, $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '', $customSubmit = '') {

    // load languages from DB
    $languages = Sh404sefHelperGeneral::getInstalledLanguagesList();

    // adjust to require format
    $data = array();
    if (!empty( $languages)) {
      foreach( $languages as $languages) {
        $data[] = array( 'id' => $languages->shortcode, 'title' => $languages->name);
      }
    }

    // use helper to build html
    $list = self::buildSelectList( $data, $current, $name, $autoSubmit, $addSelectAll, $selectAllTitle, $customSubmit);

    // return list
    return $list;

  }

  /**
   * Method to create a select list of possible date ranges of the analytics dashboard
   *
   * @access  public
   * @param int ID of current item
   * @param string name of select list
   * @param boolean if true, changing selected item will submit the form (assume is an "adminForm")
   * @param boolean, if true, a line 'Select all' is inserted at the start of the list
   * @param string the "Select all" to be displayed, if $addSelectAll is true
   * @return  string HTML output
   */
  function buildDashboardDateRangeList( $current, $name, $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '', $customSubmit = '') {

    // build up list from scratch
    $data = array();
    $data[] = array( 'id' => 'week', 'title' => Jtext16::_('COM_SH404SEF_WEEK'));
    $data[] = array( 'id' => 'month', 'title' => Jtext16::_('COM_SH404SEF_MONTH'));
    $data[] = array( 'id' => 'year', 'title' => Jtext16::_('COM_SH404SEF_YEAR'));

    // use helper to build html
    $list = self::buildSelectList( $data, $current, $name, $autoSubmit, $addSelectAll, $selectAllTitle, $customSubmit);

    // return list
    return $list;

  }

  /**
   * Method to create a select list of possible data types of the analytics dashboard
   *
   * @access  public
   * @param int ID of current item
   * @param string name of select list
   * @param boolean if true, changing selected item will submit the form (assume is an "adminForm")
   * @param boolean, if true, a line 'Select all' is inserted at the start of the list
   * @param string the "Select all" to be displayed, if $addSelectAll is true
   * @return  string HTML output
   */
  function buildDashboardDataTypeList( $current, $name, $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '', $customSubmit = '') {

    // build up list from scratch
    $data = array();
    $data[] = array( 'id' => 'ga:pageviews', 'title' => Jtext16::_('COM_SH404SEF_ANALYTICS_DATA_PAGEVIEWS'));
    $data[] = array( 'id' => 'ga:visits', 'title' => Jtext16::_('COM_SH404SEF_ANALYTICS_DATA_VISITS'));
    $data[] = array( 'id' => 'ga:visitors', 'title' => Jtext16::_('COM_SH404SEF_ANALYTICS_DATA_VISITORS'));

    // use helper to build html
    $list = self::buildSelectList( $data, $current, $name, $autoSubmit, $addSelectAll, $selectAllTitle, $customSubmit);

    // return list
    return $list;

  }

  /**
   * Method to create a select list of possible Open Graph object types
   *
   * @access  public
   * @param int ID of current item
   * @param string name of select list
   * @param boolean if true, changing selected item will submit the form (assume is an "adminForm")
   * @param boolean, if true, a line 'Select all' is inserted at the start of the list
   * @param string the "Select all" to be displayed, if $addSelectAll is true
   * @return  string HTML output
   */
  public static function buildOpenGraphTypesList( $current, $name, $autoSubmit = false, $addSelectDefault = false, $selectDefaultTitle = '', $customSubmit = '') {

    // build up list from scratch
    $data = array(

    array(
    'text' => JText16::_('COM_SH404SEF_OG_TYPES_GROUP_ACTIVITIES'),
    'items' => array(
    array( 'id' => 'activity', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_ACTIVITY'))
    , array( 'id' => 'sport', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_SPORT'))
    )),

    array(
    'text' => JText16::_('COM_SH404SEF_OG_TYPES_GROUP_BUSINESSES'),
    'items' => array(
    array( 'id' => 'bar', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_BAR'))
    , array( 'id' => 'company', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_COMPANY'))
    , array( 'id' => 'cafe', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_CAFE'))
    , array( 'id' => 'hotel', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_HOTEL'))
    , array( 'id' => 'restaurant', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_RESTAURANT'))
    )),

    array(
    'text' => JText16::_('COM_SH404SEF_OG_TYPES_GROUP_GROUPS'),
    'items' => array(
    array( 'id' => 'cause', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_CAUSE'))
    , array( 'id' => 'sports_league', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_SPORTS_LEAGUE'))
    , array( 'id' => 'sports_team', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_SPORTS_TEAM'))
    )),

    array(
    'text' => JText16::_('COM_SH404SEF_OG_TYPES_GROUP_ORGANIZATIONS'),
    'items' => array(
    array( 'id' => 'band', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_BAND'))
    , array( 'id' => 'government', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_GOVERNMENT'))
    , array( 'id' => 'non_profit', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_NON_PROFIT'))
    , array( 'id' => 'school', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_SCHOOL'))
    , array( 'id' => 'university', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_UNIVERSITY'))
    )),

    array(
    'text' => JText16::_('COM_SH404SEF_OG_TYPES_GROUP_PEOPLE'),
    'items' => array(
    array( 'id' => 'actor', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_ACTOR'))
    , array( 'id' => 'athlete', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_ATHLETE'))
    , array( 'id' => 'author', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_AUTHOR'))
    , array( 'id' => 'director', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_DIRECTOR'))
    , array( 'id' => 'musician', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_MUSICIAN'))
    , array( 'id' => 'politician', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_POLITICIAN'))
    , array( 'id' => 'public_figure', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_PUBLIC_FIGURE'))
    )),

    array(
    'text' => JText16::_('COM_SH404SEF_OG_TYPES_GROUP_PLACES'),
    'items' => array(
    array( 'id' => 'city', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_CITY'))
    , array( 'id' => 'country', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_COUNTRY'))
    , array( 'id' => 'landmark', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_LANDMARK'))
    , array( 'id' => 'state_province', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_STATE_PROVINCE'))
    )),

    array(
    'text' => JText16::_('COM_SH404SEF_OG_TYPES_GROUP_PROD_AND_ENTERTAINMENT'),
    'items' => array(
    array( 'id' => 'album', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_ALBUM'))
    , array( 'id' => 'book', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_BOOK'))
    , array( 'id' => 'drink', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_DRINK'))
    , array( 'id' => 'food', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_FOOD'))
    , array( 'id' => 'game', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_GAME'))
    , array( 'id' => 'product', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_PRODUCT'))
    , array( 'id' => 'song', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_SONG'))
    , array( 'id' => 'movie', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_MOVIE'))
    , array( 'id' => 'tv_show', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_TV_SHOW'))
    )),

    array(
    'text' => JText16::_('COM_SH404SEF_OG_TYPES_GROUP_WEBSITES'),
    'items' => array(
    array( 'id' => 'blog', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_BLOG'))
    , array( 'id' => 'website', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_WEBSITE'))
    , array( 'id' => 'article', 'title' => JText16::_('COM_SH404SEF_OG_TYPES_ARTICLE'))

    ))
    );

    // add select all option
    if ($addSelectDefault) {
      $selectDefault = array(
    'text' => '',
    'items' => array(
      array( 'id' => SH404SEF_OPTION_VALUE_USE_DEFAULT, 'title' => $selectDefaultTitle)

      ));
      array_unshift( $data, $selectDefault);
    }

    // use helper to build html
    $list = self::buildGroupedSelectList( $data, $current, $name, $autoSubmit, $addSelectAll = false, $selectAllTitle = '', $customSubmit);

    // return list
    return $list;

  }

  /**
   * Method to create a select list
   *
   * @access  public
   * @param array $data elements of the select list. An array of (id, title) arrays
   * @param int ID of current item
   * @param string name of select list
   * @param boolean if true, changing selected item will submit the form (assume is an "adminForm")
   * @param boolean, if true, a line 'Select all' is inserted at the start of the list
   * @param string the "Select all" to be displayed, if $addSelectAll is true
   * @return  string HTML output
   */
  function buildSelectList( $data, $current, $name, $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '', $customSubmit = '' ) {

    // should we autosubmit ?
    $customSubmit = empty( $customSubmit) ? ' onchange="document.adminForm.limitstart.value=0;document.adminForm.submit();"' : $customSubmit;
    $extra = $autoSubmit ?  $customSubmit : '';

    // add select all option
    if ($addSelectAll) {
      array_unshift( $data, JHTML::_('select.option', 0, $selectAllTitle, 'id', 'title' ));
    }
    // use joomla lib to build the list
    return JHTML::_('select.genericlist', $data, $name, $extra, 'id', 'title', $current );

  }

  /**
   * Method to create a select list
   *
   * @access  public
   * @param array $data elements of the select list. An array of (id, title) arrays
   * @param int ID of current item
   * @param string name of select list
   * @param boolean if true, changing selected item will submit the form (assume is an "adminForm")
   * @param boolean, if true, a line 'Select all' is inserted at the start of the list
   * @param string the "Select all" to be displayed, if $addSelectAll is true
   * @return  string HTML output
   */
  public static function buildGroupedSelectList( $data, $current, $name, $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '', $customSubmit = '' ) {

    // should we autosubmit ?
    $customSubmit = empty( $customSubmit) ? ' onchange="document.adminForm.limitstart.value=0;document.adminForm.submit();"' : $customSubmit;
    $extra = $autoSubmit ?  $customSubmit : '';

    // add select all option
    if ($addSelectAll) {
      array_unshift( $data, JHTML::_('select.option', 0, $selectAllTitle));
    }
    // use joomla lib to build the list
    return self::_groupedlist( $data, $name, array('option.key' => 'id', 'option.text' => 'title', 'list.select' => $current) );

  }


  /**
   * Method to create a select list
   *
   * @access  public
   * @param int ID of current item
   * @param string name of select list
   * @return  string HTML output
   */
  public static function buildBooleanAndDefaultSelectList($selected, $name) {

    $arr = array(
    JHtml::_('select.option', SH404SEF_OPTION_VALUE_NO, COM_SH404SEF_NO),
    JHtml::_('select.option', SH404SEF_OPTION_VALUE_YES, COM_SH404SEF_YES),
    JHtml::_('select.option', SH404SEF_OPTION_VALUE_USE_DEFAULT, COM_SH404SEF_DEFAULT)
    );
    return JHTML::_('select.genericlist', $arr, $name, '', 'value', 'text', (int) $selected);

  }

  /**
   * Backport of Joomla! 1.7 select grouped list
   *
   * @package     Joomla.Platform
   * @subpackage  HTML
   *
   * @copyright   Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
   * @license     GNU General Public License version 2 or later; see LICENSE
   * @param unknown_type $data
   * @param unknown_type $name
   * @param unknown_type $options
   * @throws JException
   */
  static $formatOptions = array(
		'format.depth' => 0,
		'format.eol' => "\n",
		'format.indent' => "\t"
		);

		static protected $_optionDefaults = array(
		'option' => array(
			'option.attr' => null,
			'option.disable' => 'disable',
			'option.id' => null,
			'option.key' => 'value',
			'option.key.toHtml' => true,
			'option.label' => null,
			'option.label.toHtml' => true,
			'option.text' => 'text',
			'option.text.toHtml' => true,
		),
		);
		private static function _groupedlist($data, $name, $options = array())
		{
		  // Set default options and overwrite with anything passed in
		  $options = array_merge(
		  self::$formatOptions,
		  array(
				'format.depth' => 0,
				'group.items' => 'items',
				'group.label' => 'text',
				'group.label.toHtml' => true,
				'id' => false,
		  ),
		  $options
		  );
		  // Apply option rules
		  if ($options['group.items'] === null)
		  {
		    $options['group.label'] = null;
		  }
		  $attribs = '';
		  if (isset($options['list.attr']))
		  {
		    if (is_array($options['list.attr']))
		    {
		      $attribs = JArrayHelper::toString($options['list.attr']);
		    }
		    else
		    {
		      $attribs = $options['list.attr'];
		    }
		    if ($attribs != '')
		    {
		      $attribs = ' ' . $attribs;
		    }
		  }

		  $id = $options['id'] !== false ? $options['id'] : $name;
		  $id = str_replace(array('[', ']'), '', $id);

		  // Disable groups in the options.
		  $options['groups'] = false;

		  $baseIndent = str_repeat($options['format.indent'], $options['format.depth']++);
		  $html = $baseIndent . '<select' . ($id !== '' ? ' id="' . $id . '"' : '')
		  . ' name="' . $name . '"'
		  . $attribs . '>'
		  . $options['format.eol']
		  ;
		  $groupIndent = str_repeat($options['format.indent'], $options['format.depth']++);
		  foreach($data as $dataKey => $group)
		  {
		    $label = $dataKey;
		    $id = '';
		    $noGroup = is_int($dataKey);
		    if ($options['group.items'] == null)
		    {
		      // Sub-list is an associative array
		      $subList = $group;
		    }
		    elseif (is_array($group))
		    {
		      // Sub-list is in an element of an array.
		      $subList = $group[$options['group.items']];
		      if (isset($group[$options['group.label']]))
		      {
		        $label = $group[$options['group.label']];
		        $noGroup = false;
		      }
		      if (isset($options['group.id']) && isset($group[$options['group.id']]))
		      {
		        $id = $group[$options['group.id']];
		        $noGroup = false;
		      }
		    }
		    elseif (is_object($group))
		    {
		      // Sub-list is in a property of an object
		      $subList = $group->$options['group.items'];
		      if (isset($group->$options['group.label']))
		      {
		        $label = $group->$options['group.label'];
		        $noGroup = false;
		      }
		      if (isset($options['group.id']) && isset($group->$options['group.id']))
		      {
		        $id = $group->$options['group.id'];
		        $noGroup = false;
		      }
		    }
		    else
		    {
		      throw new JException('Invalid group contents.', 1, E_WARNING);
		    }
		    if($noGroup)
		    {
		      $html.=self::_options($subList, $options);
		    }
		    else
		    {
		      $html .= $groupIndent
		      . '<optgroup' . (empty($id) ? '' : ' id="' . $id . '"')
		      . ' label="'
		      . ($options['group.label.toHtml'] ? htmlspecialchars($label, ENT_COMPAT, 'UTF-8') : $label)
		      . '">'
		      . $options['format.eol']
		      . self::_options($subList, $options)
		      . $groupIndent . '</optgroup>'
		      . $options['format.eol']
		      ;
		    }
		  }
		  $html .= $baseIndent . '</select>' . $options['format.eol'];

		  return $html;
		}

		/**
		 * Create an object that represents an option in an option list.
		 *
		 * @param    string        The value of the option
		 * @param    string        The text for the option
		 * @param    mixed         If a string, the returned object property name for
		 *                         the value. If an array, options. Valid options are:
		 *                         attr: String|array. Additional attributes for this option.
		 *                         Defaults to none.
		 *                         disable: Boolean. If set, this option is disabled.
		 *                         label: String. The value for the option label.
		 *                         option.attr: The property in each option array to use for
		 *                         additional selection attributes. Defaults to none.
		 *                         option.disable: The property that will hold the disabled state.
		 *                         Defaults to "disable".
		 *                         option.key: The property that will hold the selection value.
		 *                         Defaults to "value".
		 *                         option.label: The property in each option array to use as the
		 *                         selection label attribute. If a "label" option is provided, defaults to
		 *                         "label", if no label is given, defaults to null (none).
		 *                         option.text: The property that will hold the the displayed text.
		 *                         Defaults to "text". If set to null, the option array is assumed to be a
		 *                         list of displayable scalars.
		 * @param    string        The property that will hold the the displayed text. This
		 *                         parameter is ignored if an options array is passed.
		 *
		 * @return  object
		 *
		 * @since   11.1
		 */
		private static function _option(
		$value, $text = '', $optKey = 'value', $optText = 'text', $disable = false
		) {
		  $options = array(
			'attr' => null,
			'disable' => false,
			'option.attr' => null,
			'option.disable' => 'disable',
			'option.key' => 'value',
			'option.label' => null,
			'option.text' => 'text',
		  );
		  if (is_array($optKey)) {
		    // Merge in caller's options
		    $options = array_merge($options, $optKey);
		  } else {
		    // Get options from the parameters
		    $options['option.key'] = $optKey;
		    $options['option.text'] = $optText;
		    $options['disable'] = $disable;
		  }
		  $obj = new JObject;
		  $obj->$options['option.key'] = $value;
		  $obj->$options['option.text'] = trim($text) ? $text : $value;

		  /*
		   * If a label is provided, save it. If no label is provided and there is
		   * a label name, initialise to an empty string.
		   */
		  $hasProperty = $options['option.label'] !== null;
		  if (isset($options['label'])) {
		    $labelProperty = $hasProperty ? $options['option.label'] : 'label';
		    $obj->$labelProperty = $options['label'];
		  } elseif ($hasProperty) {
		    $obj->$options['option.label'] = '';
		  }

		  // Set attributes only if there is a property and a value
		  if ($options['attr'] !== null) {
		    $obj->$options['option.attr'] = $options['attr'];
		  }

		  // Set disable only if it has a property and a value
		  if ($options['disable'] !== null) {
		    $obj->$options['option.disable'] = $options['disable'];
		  }
		  return $obj;
		}

		/**
		 * Generates the option tags for an HTML select list (with no select tag
		 * surrounding the options).
		 *
		 * @param    array   An array of objects, arrays, or values.
		 * @param    mixed   If a string, this is the name of the object variable for
		 *                   the option value. If null, the index of the array of objects is used. If
		 *                   an array, this is a set of options, as key/value pairs. Valid options
		 *                   are:
		 *                   -Format options, {@see JHtml::$formatOptions}.
		 *                   -groups: Boolean. If set, looks for keys with the value
		 *                    "&lt;optgroup>" and synthesizes groups from them. Deprecated. Defaults
		 *                    true for backwards compatibility.
		 *                   -list.select: either the value of one selected option or an array
		 *                    of selected options. Default: none.
		 *                   -list.translate: Boolean. If set, text and labels are translated via
		 *                    JText16::_(). Default is false.
		 *                   -option.id: The property in each option array to use as the
		 *                    selection id attribute. Defaults to none.
		 *                   -option.key: The property in each option array to use as the
		 *                    selection value. Defaults to "value". If set to null, the index of the
		 *                    option array is used.
		 *                   -option.label: The property in each option array to use as the
		 *                    selection label attribute. Defaults to null (none).
		 *                   -option.text: The property in each option array to use as the
		 *                   displayed text. Defaults to "text". If set to null, the option array is
		 *                   assumed to be a list of displayable scalars.
		 *                   -option.attr: The property in each option array to use for
		 *                    additional selection attributes. Defaults to none.
		 *                   -option.disable: The property that will hold the disabled state.
		 *                    Defaults to "disable".
		 *                   -option.key: The property that will hold the selection value.
		 *                    Defaults to "value".
		 *                   -option.text: The property that will hold the the displayed text.
		 *                    Defaults to "text". If set to null, the option array is assumed to be a
		 *                    list of displayable scalars.
		 * @param    string  The name of the object variable for the option text.
		 * @param    mixed   The key that is selected (accepts an array or a string)
		 *
		 * @return   string  HTML for the select list
		 *
		 * @since   11.1
		 */
		private static function _options(
		$arr, $optKey = 'value', $optText = 'text', $selected = null, $translate = false
		) {
		  $options = array_merge(
		  self::$formatOptions,
		  self::$_optionDefaults['option'],
		  array(
				'format.depth' => 0,
				'groups' => true,
				'list.select' => null,
				'list.translate' => false,
		  )
		  );
		  if (is_array($optKey)) {
		    // Set default options and overwrite with anything passed in
		    $options = array_merge($options, $optKey);
		  } else {
		    // Get options from the parameters
		    $options['option.key'] = $optKey;
		    $options['option.text'] = $optText;
		    $options['list.select'] = $selected;
		    $options['list.translate'] = $translate;
		  }

		  $html = '';
		  $baseIndent = str_repeat($options['format.indent'], $options['format.depth']);

		  foreach ($arr as $elementKey => &$element)
		  {
		    $attr = '';
		    $extra = '';
		    $label = '';
		    $id = '';
		    if (is_array($element))
		    {
		      $key = $options['option.key'] === null
		      ? $elementKey : $element[$options['option.key']];
		      $text = $element[$options['option.text']];
		      if (isset($element[$options['option.attr']])) {
		        $attr = $element[$options['option.attr']];
		      }
		      if (isset($element[$options['option.id']])) {
		        $id = $element[$options['option.id']];
		      }
		      if (isset($element[$options['option.label']])) {
		        $label = $element[$options['option.label']];
		      }
		      if (isset($element[$options['option.disable']]) && $element[$options['option.disable']]) {
		        $extra .= ' disabled="disabled"';
		      }
		    } elseif (is_object($element)) {
		      $key = $options['option.key'] === null
		      ? $elementKey : $element->$options['option.key'];
		      $text = $element->$options['option.text'];
		      if (isset($element->$options['option.attr'])) {
		        $attr = $element->$options['option.attr'];
		      }
		      if (isset($element->$options['option.id'])) {
		        $id = $element->$options['option.id'];
		      }
		      if (isset($element->$options['option.label'])) {
		        $label = $element->$options['option.label'];
		      }
		      if (isset($element->$options['option.disable']) && $element->$options['option.disable']) {
		        $extra .= ' disabled="disabled"';
		      }
		    } else {
		      // This is a simple associative array
		      $key = $elementKey;
		      $text = $element;
		    }

		    // The use of options that contain optgroup HTML elements was
		    // somewhat hacked for J1.5. J1.6 introduces the grouplist() method
		    // to handle this better. The old solution is retained through the
		    // "groups" option, which defaults true in J1.6, but should be
		    // deprecated at some point in the future.

		    $key = (string) $key;
		    if ($options['groups'] && $key == '<OPTGROUP>') {
		      $html .= $baseIndent . '<optgroup label="'
		      . ($options['list.translate'] ? JText16::_($text) : $text)
		      . '">' . $options['format.eol'];
		      $baseIndent = str_repeat($options['format.indent'], ++$options['format.depth']);
		    } elseif ($options['groups'] && $key == '</OPTGROUP>') {
		      $baseIndent = str_repeat($options['format.indent'], --$options['format.depth']);
		      $html .= $baseIndent . '</optgroup>' . $options['format.eol'];
		    } else {
		      // if no string after hypen - take hypen out
		      $splitText = explode(' - ', $text, 2);
		      $text = $splitText[0];
		      if (isset($splitText[1])) {
		        $text .= ' - ' . $splitText[1];
		      }

		      if ($options['list.translate'] && !empty($label)) {
		        $label = JText16::_($label);
		      }
		      if ($options['option.label.toHtml']) {
		        $label = htmlentities($label);
		      }
		      if (is_array($attr)) {
		        $attr = JArrayHelper::toString($attr);
		      } else {
		        $attr = trim($attr);
		      }
		      $extra = ($id ? ' id="' . $id . '"' : '')
		      . ($label ? ' label="' . $label . '"' : '')
		      . ($attr ? ' ' . $attr : '')
		      . $extra
		      ;
		      if (is_array($options['list.select']))
		      {
		        foreach ($options['list.select'] as $val)
		        {
		          $key2 = is_object($val) ? $val->$options['option.key'] : $val;
		          if ($key == $key2) {
		            $extra .= ' selected="selected"';
		            break;
		          }
		        }
		      } elseif ((string)$key == (string)$options['list.select']) {
		        $extra .= ' selected="selected"';
		      }

		      if ($options['list.translate']) {
		        $text = JText16::_($text);
		      }

		      // Generate the option, encoding as required
		      $html .= $baseIndent . '<option value="'
		      . ($options['option.key.toHtml'] ? htmlspecialchars($key, ENT_COMPAT, 'UTF-8') : $key) . '"'
		      . $extra . '>'
		      . ($options['option.text.toHtml'] ? htmlentities(html_entity_decode($text,ENT_COMPAT, 'UTF-8'),ENT_COMPAT, 'UTF-8') : $text)
		      . '</option>'
		      . $options['format.eol']
		      ;
		    }
		  }

		  return $html;
		}

		/**
		 * Wraps a text into a div to display a title visible by hovering
		 * over text
		 *
		 * @param string $text text to be displayed
		 * @param string $title title if any
		 */
		public static function wrapTitle( $text, $title = '') {

		  $html = empty( $title) ? $text : '<div title="' . $title . '">' . $text . '</div>';
		  return $html;
		}

		/**
		 * Wraps a text into a span to display a tooltip visible by hovering
		 * over text
		 *
		 * @param string $text text to be displayed
		 * @param string $title title if any
		 * @param string $tip tip, if any
		 */
		public static function wrapTip( $text, $title = '', $tip = '', $class = 'hasTip') {

		  $html = empty( $title) ? $text : '<div ' . ( empty( $tip) ? '' : ' class="'.$class.'"') . ' title="' . $title . ( empty($tip) ? '' : '::' . $tip) . '">' . $text . '</div>';
		  return $html;
		}

		/**
		 * A copy of Joomla own modal helper function,
		 * giving access to more params
		 *
		 * @param $selector selector class to stitch modal javascript on
		 * @param $params an array of key/values pairs to be passed as options to SqueezeBox
		 */
		function modal( $selector='a.modal', $params = array()) {

		  static $modals;
		  static $included;

		  $document =& JFactory::getDocument();

		  // Load the necessary files if they haven't yet been loaded
		  if (!isset($included)) {

		    // Load the javascript and css
		    JHTML::script('modal.js');
		    JHTML::stylesheet('modal.css');

		    // our flag to block opening several Squeezboxes
		    $document = & JFactory::getDocument();
		    $document->addScriptDeclaration( 'var shAlreadySqueezed = false;');
		    $document->addScriptDeclaration( 'var shReloadModal = true;');

		    $included = true;
		  }

		  if (!isset($modals)) {
		    $modals = array();
		  }

		  $sig = md5(serialize(array($selector,$params)));
		  if (isset($modals[$sig]) && ($modals[$sig])) {
		    return;
		  }

		  // Setup options object
		  $options = Sh404sefHelperHtml::makeSqueezeboxOptions( $params);

		  // Attach modal behavior to document
		  $document->addScriptDeclaration("
    window.addEvent('domready', function() {

      SqueezeBox.initialize({".$options."});

      $$('".$selector."').each(function(el) {
        el.addEvent('click', function(e) {
          new Event(e).stop();
          if (!shAlreadySqueezed) {
            shAlreadySqueezed = true;
            SqueezeBox.fromElement(el);
          }
        });
      });
    });");

		  // Set static array
		  $modals[$sig] = true;
		  return;
		}

		public function makeSqueezeboxOptions( $params = array()) {

		  // Setup options object
		  $opt = array();

		  $opt['ajaxOptions'] = (isset($params['ajaxOptions']) && (is_array($params['ajaxOptions']))) ? $params['ajaxOptions'] : null;
		  $opt['size']    = (isset($params['size']) && (is_array($params['size']))) ? $params['size'] : null;
		  $opt['sizeLoading']    = (isset($params['sizeLoading']) && (is_array($params['sizeLoading']))) ? $params['sizeLoading'] : null;
		  $opt['marginInner']    = (isset($params['marginInner']) && (is_array($params['marginInner']))) ? $params['marginInner'] : null;
		  $opt['marginImage']    = (isset($params['marginImage']) && (is_array($params['marginImage']))) ? $params['marginImage'] : null;

		  $opt['overlayOpacity']    = (isset($params['overlayOpacity'])) ? $params['overlayOpacity'] : null;
		  $opt['classWindow']    = (isset($params['classWindow'])) ? $params['classWindow'] : null;
		  $opt['classOverlay']    = (isset($params['classOverlay'])) ? $params['classOverlay'] : null;
		  $opt['disableFx']    = (isset($params['disableFx'])) ? $params['disableFx'] : null;

		  $opt['onOpen']    = (isset($params['onOpen'])) ? $params['onOpen'] : null;
		  $opt['onClose']   = (isset($params['onClose'])) ? $params['onClose'] : null;
		  $opt['onUpdate']  = (isset($params['onUpdate'])) ? $params['onUpdate'] : null;
		  $opt['onResize']  = (isset($params['onResize'])) ? $params['onResize'] : null;
		  $opt['onMove']    = (isset($params['onMove'])) ? $params['onMove'] : null;
		  $opt['onShow']    = (isset($params['onShow'])) ? $params['onShow'] : null;
		  $opt['onHide']    = (isset($params['onHide'])) ? $params['onHide']  : null;

		  $opt['fxOverlayDuration']    = (isset($params['fxOverlayDuration'])) ? $params['fxOverlayDuration'] : null;
		  $opt['fxResizeDuration']    = (isset($params['fxResizeDuration'])) ? $params['fxResizeDuration'] : null;
		  $opt['fxContentDuration']    = (isset($params['fxContentDuration'])) ? $params['fxContentDuration'] : null;

		  $options = self::JGetJSObject($opt);

		  $options = substr($options, 0, 1) == '{' ? substr( $options, 1) : $options;
		  $options = substr($options, -1) == '}' ? substr( $options, 0, -1) : $options;

		  return $options;
		}

		/**
		 * Internal method to get a JavaScript object notation string from an array
		 * Copied over from Joomla lib, for access reasons
		 *
		 * @param array $array  The array to convert to JavaScript object notation
		 * @return  string  JavaScript object notation representation of the array
		 * @since 1.5
		 */
		public function JGetJSObject($array=array())
		{
		  // Initialize variables
		  $object = '{';

		  // Iterate over array to build objects
		  foreach ((array)$array as $k => $v)
		  {
		    if (is_null($v)) {
		      continue;
		    }
		    if (!is_array($v) && !is_object($v)) {
		      $object .= ' '.$k.': ';
		      $object .= (is_numeric($v) || strpos($v, '\\') === 0) ? (is_numeric($v)) ? $v : substr($v, 1) : "'".$v."'";
		      $object .= ',';
		    } else {
		      $object .= ' '.$k.': '.self::JGetJSObject($v).',';
		    }
		  }
		  if (substr($object, -1) == ',') {
		    $object = substr($object, 0, -1);
		  }
		  $object .= '}';

		  return $object;
		}

		/**
		 * Builds up an html link using the various parts supplied
		 *
		 * @param $view a JView object, to be able to escape output text
		 * @param $linkData an array of key/value pairs to build up the target links
		 * @param $elementData an array holding element data : title, class, rel
		 * @param $modal boolean, if true, required stuff to make the link open in modal box is added
		 * @param $hasTip boolean, if true, required stuff to turn elementData['title'] into a tooltip is added
		 * @param $extra an array holding key/value pairs, will be added as raw attributes to the link
		 */
		public function makeLink( $view, $linkData, $elementData, $modal = false, $modalOptions = array(), $hasTip = false, $extra = array()) {

		  // calculate target link
		  if ($modal) {
		    $linkData['tmpl'] = 'component';
		  }
		  $url = Sh404sefHelperGeneral::buildUrl( $linkData);
		  $url = JRoute::_( $url);

		  // calculate title
		  $title = empty( $elementData['title']) ? '' : $elementData['title'];
		  $title = is_null( $view) ? $title : $view->escape( $title);

		  $attribs = array();

		  // calculate class
		  $class = empty( $elementData['class']) ? '' : $elementData['class'];
		  if ($hasTip) {
		    $class .= ' ' . $hasTip;
		  }

		  // store title in attributes array
		  if (!empty( $title)) {
		    $attribs['title'] = $title;
		  }


		  // store in attributes array
		  if (!empty( $class)) {
		    $attribs['class'] = $class;
		  }

		  // calculate modal information
		  $rel = empty( $elementData['rel']) || is_null($view) ? '' : $view->escape($elementData['rel']);
		  if ($modal) {
		    $modalOptionsString = Sh404sefHelperHtml::makeSqueezeboxOptions( $modalOptions);
		    $rel .= ' {handler: \'iframe\'' . (empty($modalOptionsString) ? '' : ', ' . $modalOptionsString) . '}';
		  }

		  // store in attributes array
		  if (!empty( $rel)) {
		    $attribs['rel'] = $rel;
		  }

		  // any custom attibutes ?
		  if (!empty($extra)) {
		    foreach($extra as $key => $value) {
		      $attribs[$key] = $value;
		    }
		  }

		  // finish link
		  $anchor = empty( $elementData['anchor']) ? $title : $elementData['anchor'];

		  return JHTML::link( $url, $anchor, $attribs);

		}

		public function gridMainUrl(&$url, $i) {

		  $isMain = $url->rank == 0;

		  $imgPrefix = $isMain ? '' : '-non';
		  $img = 'components/com_sh404sef/assets/images/icon-16' . $imgPrefix . '-default.png';

		  if ($isMain){
		    $alt = JText16::_('COM_SH404SEF_DUPLICATE_IS_MAIN');
		    $href = '<img src="' . $img .'" border="0" alt="'. $alt .'" title="' . $alt . '" />';
		  } else {
		    $alt  = JText16::sprintf('COM_SH404SEF_DUPLICATE_MAKE_MAIN', $url->oldurl);
		    $href = '
    <a href="javascript:void(0);" onclick="return listItemTask(\'cb'. $i .'\',\'makemainurl\')" title="'. $alt .'">
    <img src="' . $img .'" border="0" alt="'. $alt .'" /></a>'
    ;
		  }
		  return $href;
		}

		/**
		 * Returns html to display a main control panel icon
		 *
		 * @param string $function name of function performed by icon
		 */
		public function getCPImage( $function) {

		  switch ($function) {
		    case 'config_base':
		      $img =  ' <img src=\'components/com_sh404sef/assets/images/icon-48-cpanel.png\'/>';
		      $linkData = array( 'c' => 'config', 'tmpl' => 'component');
		      $urlData = array( 'title' => JText16::_('COM_SH404SEF_CONFIG_DESC'), 'class' => 'modalediturl','anchor' => $img . '<span>' . JText16::_( 'COM_SH404SEF_CONFIG') . '</span>');
		      $modalOptions = array( 'size' => array('x' => '\\window.getSize().scrollSize.x*.9', 'y' => '\\window.getSize().size.y*.9'));
		      $link =  Sh404sefHelperHtml::makeLink( null, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
		      break;
		    case 'config_ext':
		      $img =  ' <img src=\'components/com_sh404sef/assets/images/icon-48-ext.png\'/>';
		      $linkData = array( 'c' => 'config', 'layout' => 'ext', 'tmpl' => 'component');
		      $urlData = array( 'title' => JText16::_('COM_SH404SEF_CONFIG_EXT_DESC'), 'class' => 'modalediturl', 'anchor' => $img . '<span>' . JText16::_( 'COM_SH404SEF_CONFIG_EXT') . '</span>');
		      $modalOptions = array( 'size' => array('x' => '\\window.getSize().scrollSize.x*.9', 'y' => '\\window.getSize().size.y*.9'));
		      $link =  Sh404sefHelperHtml::makeLink( null, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
		      break;
		    case 'config_error_page':
		      $img =  ' <img src=\'components/com_sh404sef/assets/images/icon-48-errorpage.png\'/>';
		      $linkData = array( 'c' => 'config', 'layout' => 'errordocs', 'tmpl' => 'component');
		      $urlData = array( 'title' => JText16::_('COM_SH404SEF_CONFIG_ERROR_PAGE_DESC'), 'class' => 'modalediturl', 'anchor' => $img . '<span>' . JText16::_( 'COM_SH404SEF_CONFIG_ERROR_PAGE') . '</span>');
		      $modalOptions = array( 'size' => array('x' => '\\window.getSize().scrollSize.x*.9', 'y' => '\\window.getSize().size.y*.9'));
		      $link =  Sh404sefHelperHtml::makeLink( null, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
		      break;
		    case 'config_seo':
		      $img =  ' <img src=\'components/com_sh404sef/assets/images/icon-48-seo.png\'/>';
		      $linkData = array( 'c' => 'config', 'layout' => 'seo', 'tmpl' => 'component');
		      $urlData = array( 'title' => JText16::_('COM_SH404SEF_CONFIG_SEO_DESC'), 'class' => 'modalediturl', 'anchor' => $img . '<span>' . JText16::_( 'COM_SH404SEF_CONFIG_SEO') . '</span>');
		      $modalOptions = array( 'size' => array('x' =>700, 'y' => '\\window.getSize().size.y*.7'));
		      $link =  Sh404sefHelperHtml::makeLink( null, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
		      break;
		    case 'config_social_seo':
		      $img =  ' <img src=\'components/com_sh404sef/assets/images/icon-48-facebook.png\'/>';
		      $linkData = array( 'c' => 'config', 'layout' => 'social_seo', 'tmpl' => 'component');
		      $urlData = array( 'title' => JText16::_('COM_SH404SEF_CONFIG_SOCIAL_SEO_DESC'), 'class' => 'modalediturl', 'anchor' => $img . '<span>' . JText16::_( 'COM_SH404SEF_CONFIG_SOCIAL_SEO') . '</span>');
		      $modalOptions = array( 'size' => array('x' =>700, 'y' => '\\window.getSize().size.y*.7'));
		      $link =  Sh404sefHelperHtml::makeLink( null, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
		      break;
		    case 'config_sec':
		      $img =  ' <img src=\'components/com_sh404sef/assets/images/icon-48-sec.png\'/>';
		      $linkData = array( 'c' => 'config', 'layout' => 'sec', 'tmpl' => 'component');
		      $urlData = array( 'title' => JText16::_('COM_SH404SEF_CONFIG_SEC_DESC'), 'class' => 'modalediturl', 'anchor' => $img . '<span>' . JText16::_( 'COM_SH404SEF_CONFIG_SEC') . '</span>');
		      $modalOptions = array( 'size' => array('x' =>700, 'y' => '\\window.getSize().size.y*.9'));
		      $link =  Sh404sefHelperHtml::makeLink( null, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
		      break;
		    case 'config_analytics':
		      $img =  ' <img src=\'components/com_sh404sef/assets/images/icon-48-analytics.png\'/>';
		      $linkData = array( 'c' => 'config', 'layout' => 'analytics', 'tmpl' => 'component');
		      $urlData = array( 'title' => JText16::_('COM_SH404SEF_CONFIG_ANALYTICS_DESC'), 'class' => 'modalediturl', 'anchor' => $img . '<span>' . JText16::_( 'COM_SH404SEF_CONFIG_ANALYTICS') . '</span>');
		      $modalOptions = array( 'size' => array('x' =>700, 'y' => '\\window.getSize().size.y*.9'));
		      $link =  Sh404sefHelperHtml::makeLink( null, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
		      break;

		    case 'urlmanager':
		      $img = 'icon-48-sefmanager.png';
		      $title = JText16::_( 'COM_SH404SEF_VIEWURLDESC');
		      $anchor = JText16::_( 'COM_SH404SEF_VIEWURL');
		      $link = 'index.php?option=com_sh404sef&c=urls&layout=default&view=urls';
		      $link = Sh404sefHelperHtml::_doLinkCPImage( $img, $title, $anchor, $link);
		      break;
		    case '404manager':
		      $img = 'icon-48-404log.png';
		      $title = JText16::_( 'COM_SH404SEF_VIEW404DESC');
		      $anchor = JText16::_( 'COM_SH404SEF_404_MANAGER');
		      $link = 'index.php?option=com_sh404sef&c=urls&layout=view404&view=urls';
		      $link = Sh404sefHelperHtml::_doLinkCPImage( $img, $title, $anchor, $link);
		      break;
		    case 'aliasesmanager':
		      $img = 'icon-48-aliases.png';
		      $title = JText16::_( 'COM_SH404SEF_ALIASES_HELP');
		      $anchor = JText16::_( 'COM_SH404SEF_ALIASES_MANAGER');
		      $link = 'index.php?option=com_sh404sef&c=aliases&layout=default&view=aliases';
		      $link = Sh404sefHelperHtml::_doLinkCPImage( $img, $title, $anchor, $link);
		      break;
		    case 'pageidmanager':
		      $img = 'icon-48-pageid.png';
		      $title = JText16::_( 'COM_SH404SEF_CP_PAGEID_HELP');
		      $anchor = JText16::_( 'COM_SH404SEF_PAGEID_MANAGER');
		      $link = 'index.php?option=com_sh404sef&c=pageids&layout=default&view=pageids';
		      $link = Sh404sefHelperHtml::_doLinkCPImage( $img, $title, $anchor, $link);
		      break;
		    case 'metamanager':
		      $img = 'icon-48-metas.png';
		      $title = JText16::_( 'COM_SH404SEF_META_TAGS_DESC');
		      $anchor = JText16::_( 'COM_SH404SEF_META_TAGS');
		      $link = 'index.php?option=com_sh404sef&c=metas&layout=default&view=metas';
		      $link = Sh404sefHelperHtml::_doLinkCPImage( $img, $title, $anchor, $link);
		      break;
		    case 'analytics':
		      $img = 'icon-48-analytics.png';
		      $title = JText16::_( 'COM_SH404SEF_ANALYTICSDESC');
		      $anchor = JText16::_( 'COM_SH404SEF_ANALYTICS_MANAGER');
		      $link = 'index.php?option=com_sh404sef&c=analytics&layout=default&view=analytics';
		      $link = Sh404sefHelperHtml::_doLinkCPImage( $img, $title, $anchor, $link);
		      break;
		    case 'doc':
		      $img = 'icon-48-doc.png';
		      $title = JText16::_( 'COM_SH404SEF_INFODESC');
		      $anchor = JText16::_( 'COM_SH404SEF_INFO');
		      $link = 'index.php?option=com_sh404sef&layout=info&view=default&task=info';
		      $link = Sh404sefHelperHtml::_doLinkCPImage( $img, $title, $anchor, $link);
		      break;
		  }

		  return $link;

		}

		private function _doLinkCPImage( $img, $title, $anchor, $link) {

		  $link  = '<a href="' . $link . '" style="text-decoration: none;" title="' . $title . '">';
		  $link .= ' <img src="components/com_sh404sef/assets/images/' . $img . '"/>';
		  $link .= '<span>' . $anchor . '</span></a>';

		  return $link;
		}
}