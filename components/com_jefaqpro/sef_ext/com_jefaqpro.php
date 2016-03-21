<?php
/**
 * sh404SEF support for com_jefaqpro component.
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

// ------------------  standard plugin initialize function - don't change ---------------------------
global $sh_LANG, $sefConfig;
$shLangName = '';
$shLangIso = '';
//$Itemid = '';
$title = array();
$shItemidString = '';
$dosef = shInitializePlugin( $lang, $shLangName, $shLangIso, $option);
if ($dosef == false) return;
// ------------------  standard plugin initialize function - don't change ---------------------------

// ------------------  load language file - adjust as needed ----------------------------------------
$shLangIso = shLoadPluginLanguage( 'com_jefaqpro', $shLangIso, '_SEF_SAMPLE_TEXT_STRING');
// ------------------  load language file - adjust as needed ----------------------------------------

// remove common URL from GET vars list, so that they don't show up as query string in the URL

shRemoveFromGETVarsList('option');
shRemoveFromGETVarsList('lang');

if (!empty($Itemid)) {
	$itemid = $Itemid.'-';
  shRemoveFromGETVarsList('Itemid');
}
if (!empty($limit))
  shRemoveFromGETVarsList('limit');
if (isset($limitstart))
  shRemoveFromGETVarsList('limitstart'); // limitstart can be zero



// start by inserting the menu element title (just an idea, this is not required at all)
$task 	= isset($task) ? @$task : null;
$Itemid = isset($Itemid) ? @$Itemid : null;
$view 	= isset($view) ? @$view : null;
$layout = isset($layout) ? @$layout : null;
$catid	= isset($catid) ? @$catid : null;

switch ($task) {
	case 'save':
		$title[] = $itemid.$sh_LANG[$shLangIso]['JE_COM_SEF_SH_VIEW_SAMPLE'];
		shRemoveFromGETVarsList('task');
	break;
	case 'lists':
		$title[] = $itemid.$sh_LANG[$shLangIso]['JE_COM_SEF_SH_LIST'];
		shRemoveFromGETVarsList('task');
	break;
	default:
     	$dosef 	 = true;
}

switch ($view) {
	case 'faq':
		if ($layout) {
			$title[] =  $itemid.$sh_LANG[$shLangIso]['JE_COM_SEF_SH_FORM'];
			shRemoveFromGETVarsList('layout');
		} else {
			$title[] =  $itemid.$sh_LANG[$shLangIso]['JE_COM_SEF_SH_FAQ'];
		}
	  break;
	case 'category':
		if ($layout) {
			shRemoveFromGETVarsList('layout');
			if ( !empty($catid) ) {
				shRemoveFromGETVarsList('catid');
				if ( $catid == '0' ) {
					$title[] 	  =  '0-'.$sh_LANG[$shLangIso]['JE_COM_SEF_SH_UNCATEGORY'];
				} else {
					$query 		  = "SELECT id,alias FROM #__je_faq_category where id='$catid'";
		   		    $db    		  = & JFactory::getDBO();
		   		    $db->setQuery($query);
		   		    $category 	  = $db->loadObject();

					if (shTranslateUrl($option, $shLangName))
						$result   = $database->loadObject();
					else $result  = $database->loadObject( false );
					if (!empty($result)) $title[] = $itemid.$category->id.'-'.$category->alias;
					else $title[] = $itemid.$catid;
				}
			} else {
				$title[] 		  = $itemid.$view;
			}
		} else {
				$title[] 	 	  = $itemid.$sh_LANG[$shLangIso]['JE_COM_SEF_SH_CATEGORY'];
		}
	  break;
	default:
		$dosef = false;
		break;
}

if (!empty($view))
  shRemoveFromGETVarsList('view');


// ------------------  standard plugin finalize function - don't change ---------------------------
if ($dosef){
   $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString,
      (isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null),
      (isset($shLangName) ? @$shLangName : null));
}
// ------------------  standard plugin finalize function - don't change ---------------------------

?>
