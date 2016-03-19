<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );



class getminicalTab extends cbTabHandler
{
  function getminicalTab() {
    $this->cbTabHandler();
  }

  /*Main function */
  function getDisplayTab($tab,$user,$ui) {

    // init params from plugin
    $params = new JParameter($this->params->_raw);

    // get id of the profiled user, for use by the module code
    $profiledUserId = $user->id;
    
    // get output of module
    if( is_readable(JPATH_ROOT. DS. 'components'.DS.'com_jcalpro'.DS.'include'.DS.'minical.inc.php') ) {
      include( JPATH_ROOT. DS. 'components'.DS.'com_jcalpro'.DS.'include'.DS.'minical.inc.php' );
    }

    return  jclMinical( $params, 'cbjcalprominical', $profiledUserId);
  }

}

