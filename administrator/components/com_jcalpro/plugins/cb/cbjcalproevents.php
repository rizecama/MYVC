<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );



class geteventsTab extends cbTabHandler
{
  function geteventsTab() {
    $this->cbTabHandler();
  }

  /*Main function */
  function getDisplayTab($tab,$user,$ui) {

    // init params from plugin
    $params = new JParameter($this->params->_raw);

    // get id of the profiled user, for use by the module code
    $profiledUserId = $user->id;
    
    // get output of module
    $html = '';
    if( is_readable(JPATH_ROOT. DS. 'components'.DS.'com_jcalpro'.DS.'include'.DS.'latest.inc.php') ) {
      ob_start();
      include( JPATH_ROOT. DS. 'components'.DS.'com_jcalpro'.DS.'include'.DS.'latest.inc.php' );
      $html = ob_get_contents();
      ob_end_clean();
    }

    return $html;
  }

}

