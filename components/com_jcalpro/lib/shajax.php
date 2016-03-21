<?php
/**
 * @version		$Id: shajax.php 667 2011-01-24 21:02:32Z jeffchannell $
 * @package		sh404SEF
 * @copyright	Copyright (C) 2008 Yannick Gaultier. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 *
 * Helper class to set supporting js values and functions when using the
 * shajax.js ajax simple library
 *
 *
 */


/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

class shajaxSupport {

	// path to directory of javascript file(s)
	var $baseUrl = '';
	// path to default ajax loader image
	var $defaultImage = '';
	// live site url
	var $liveSiteUrl = '';
	// map to match elements with target urls
	var $urlMap = array();
	// flag to insert main javascript only once
	var $mainJsInserted = false;

	// singleton pattern
	function &getInstance( $baseUrl = '', $defaultImage = '') {

		static $instance = null;

		// create instance if not existing already
		if (is_null( $instance)) {
			$instance = new shajaxSupport();
			//set base paths
			$instance->baseUrl = $baseUrl;
			$instance->defaultImage = $defaultImage;
			$instance->liveSiteUrl = JUri::base();
		}

		return $instance;
	}

	/**
	* Insert link to javascript main file and set default variables
	*
	*/
	function addBaseJavascript() {

		// check if alreaedy done
		if ($this->mainJsInserted) {
			return;
		}

		// get lib for browser info
		jimport( 'joomla.environment.browser');

		// get Joomla global document
		$document = &JFactory::getDocument();

		// insert link to main js
		$document->addScript( $this->baseUrl . 'shajax.js');

		// set up variables and path
		$js = "/* default values for unobtrusive ajax function of shajax */\n";
		$js .= "<!--/*--><![CDATA[//><!--\n";
		$aLoader = '<img src="' . $this->defaultImage . '" border="0"  alt="progress" style="vertical-align: middle" hspace="2"/>';
		$js .= 'shajax.shajaxProgressImage = \'' . $aLoader . '\';'. "\n";
		$js .= 'shajax.shajaxLiveSiteUrl = \'' . $this->liveSiteUrl . '\';'. "\n";
		// disable prefetching for mobile browsers, too much bandwith
		$browser = &JBrowser::getInstance();
		if ($browser->hasQuirk( 'avoid_popup_windows')) {
			$js .= 'shajax.enablePrefetch = false;'. "\n";
		}
		$js .= "//--><!]]>\n";
		// insert link and set flag
		$document->addScriptDeclaration( $js);
		$this->mainJsInserted = true;
	}

	/**
	* Adds an item to the shajax url map
	*
	* @param string $elementId the unique id of the element requiring a specific target url
	* @param string $targetUrl the target url (absolute) for this element
	*/
	function addUrlMapItem( $elementId, $targetUrl) {

		$this->urlMap[$elementId] = $targetUrl;
	}

	/**
	* Builds and returns the javascript required
	* for the shajax url map
	*
	*/
	function getUrlMapJavascript( $moduleId) {

		if (!empty( $this->urlMap)) {
			$js = '<!-- url map for unobtrusive ajax function of shajax -->'. "\n";
			$js .= '<span id="shajaxRebuildUrlMap' . $moduleId . '">';
			$js .= '<script type="text/javascript">'."\n";
			$js .= '<!--/*--><![CDATA[//><!--'."\n";
			$js .= 'shajax.shajaxUrlMapRebuildFn = function rebuildUrlMap' . $moduleId."(){\n";
			foreach( $this->urlMap as $urlMapItemId => $urlMapItemUrl) {
				$js .= 'shajax.shajaxUrlMap["' . $urlMapItemId . '"] = "' . str_replace( '&amp;', '&', $urlMapItemUrl) . '";'. "\n";
			}
			$js .= '}' . "\n";
			$js .= 'shajax.shajaxUrlMapRebuildFn();'. "\n";
			$js .= '//--><!]]>' . "\n";
			$js .= '</script>'."\n";
			$js .= '</span>';
			$js .= '<!-- end of shajax url map -->'. "\n";

			return $js;
		}
	}

	/**
	* Builds and display some javascript to be
	* executed after the content has been displayed
	*
	* @param $element the element that we are replacing
	* @param $title optionnally reset page title
	* @return none
	*/
	function setPostDisplayAction( $element, $title = '') {

		$js = '<!-- post display actions of shajax -->'. "\n";
		$js .= '<span id="shajaxPostDisplayAction' . $element . '">';
		$js .= '<script type="text/javascript">'."\n";
		$js .= '/* <![CDATA[ */'."\n";
		$js .= 'shajax.shajaxPostDisplayActionFn = function postDisplayAction'.$element.'(){'. "\n";
		if (!empty( $title)) {
			$js .= 'document.title="'. htmlspecialchars($title, ENT_COMPAT, 'UTF-8').'"' . "\n";
		}
		// put here other functions to be performed
		$js .= '}' . "\n";
		$js .= 'shajax.shajaxPostDisplayActionFn();'. "\n";
		$js .= '/* ]]> */' . "\n";
		$js .= '</script>'."\n";
		$js .= '</span>';
		$js .= '<!-- end of post display actions of shajax -->'. "\n";

		return $js;
	}
}