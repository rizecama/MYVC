<?php
/**
 * Joomla! System plugin for SSL redirection
 *
 * @author Yireo (info@yireo.com)
 * @package Joomla!
 * @copyright Copyright 2011
 * @license GNU Public License
 * @link http://www.yireo.com
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

// Import the parent class
jimport( 'joomla.plugin.plugin' );

/**
 * SSL Redirect System Plugin
 */
class plgSystemSSLRedirect extends JPlugin
{
    /**
     * Load the parameters
     *
     * @access private
     * @param null
     * @return JParameter
     */
    private function getParams()
    {
        jimport('joomla.version');
        $version = new JVersion();
        if(version_compare($version->RELEASE, '1.5', 'eq')) {
            $plugin = JPluginHelper::getPlugin('system', 'sslredirect');
            $params = new JParameter($plugin->params);
            return $params;
        } else {
            return $this->params;
        }
    }

    /**
     * Event onAfterRoute
     *
     * @access public
     * @param null
     * @return null
     */
    public function onAfterRoute()
    {
        // Get system variables
        $application = JFactory::getApplication();
        $uri = JFactory::getURI();
        $current_path = $uri->toString(array('path', 'query', 'fragment'));
        $Itemid = JRequest::getInt('Itemid');

        // Redirect the backend
        if($application->isAdmin() == true && $this->getParams()->get('redirect_admin', 0) == 1) {
            if($uri->isSSL() == false) {
                $uri->setScheme('https');
                $application->redirect($uri->toString());
                return $application->close();
            }
        }

        // Do not rewrite for anything else but the frontend
        if($application->isSite() == false) {
            return false;
        }

        // Get and parse the menu-items from the plugin parameters
        $menu_items = $this->getParams()->get('menu_items');
        if(empty($menu_items)) { 
            $menu_items = array();
        } elseif(!is_array($menu_items)) {
            $menu_items = array($menu_items);
        }

        // Get and parse the components from the plugin parameters
        $components = $this->getParams()->get('components');
        if(empty($components)) { 
            $components= array();
        } elseif(!is_array($components)) {
            $components = array($components);
        }

        // Get and parse the excluded components from the plugin parameters
        $exclude_components = $this->getParams()->get('exclude_components');
        if(empty($exclude_components)) { 
            $exclude_components= array();
        } elseif(!is_array($exclude_components)) {
            $exclude_components = array($exclude_components);
        }

        // Get and parse the custom-pages from the plugin parameters
        $custom_pages = $this->getParams()->get('custom_pages');
        if(empty($custom_pages)) {
            $custom_pages = array();
        } else {
            $tmp = explode("\n", $custom_pages);
            $custom_pages = array();
            foreach($tmp as $index => $text) {
                if(!empty($text)) {
                    $custom_pages[$index] = trim($text);
                }
            }
        }

        // Don't do anything if the current component is excluded
        if(in_array(JRequest::getCmd('option'), $exclude_components)) {
            return;
        }

        // When SSL is currently disabled
        if($uri->isSSL() == false && $this->getParams()->get('redirect_nonssl', 1) == 1) {

            $redirect = false;

            // Do not redirect if this is POST-request 
            $post = JRequest::get('post');
            if(is_array($post) && !empty($post)) {
                $redirect = false;

            // Determine whether to do a redirect based on whether an user is logged in
            } elseif($this->getParams()->get('loggedin', 0) == 1 && JFactory::getUser()->guest == 0) { 
                $redirect = true;

            // Determine whether to do a redirect based on the menu-items
            } elseif(in_array($Itemid, $menu_items)) {
                $redirect = true;

            // Determine whether to do a redirect based on the component
            } elseif(in_array(JRequest::getCmd('option'), $components)) {
                $redirect = true;

            // Determine whether to do a redirect based on the custom-pages
            } elseif(!empty($custom_pages) && !empty($current_path)) {
                foreach($custom_pages as $custom_page) {
                    $pos = strpos($current_path, $custom_page);
                    if($pos !== false && ($pos == 0 || $pos == 1)) {
                        $redirect = true;
                        break;
                    }
                }
            }

            // Redirect to SSL
            if($redirect == true) {
                $uri->setScheme('https');
                $application->redirect($uri->toString());
            }

        // When SSL is currently enabled
        } elseif($uri->isSSL() == true && $this->getParams()->get('redirect_ssl', 1) == 1) {

            // Determine whether to do a redirect
            $redirect = true;

            // Do not redirect if this is POST-request 
            $post = JRequest::get('post');
            if(is_array($post) && !empty($post)) {
                $redirect = false;

            // Determine whether to do a redirect based on whether an user is logged in
            } elseif($this->getParams()->get('loggedin', 0) == 1 && JFactory::getUser()->guest == 0) { 
                $redirect = false;

            // Determine whether to do a redirect based on the menu-items
            } elseif(in_array($Itemid, $menu_items)) {
                $redirect = false;

            // Determine whether to do a redirect based on the component
            } elseif(in_array(JRequest::getCmd('option'), $components)) {
                $redirect = false;

            // Determine whether to do a redirect based on the custom-pages
            } elseif(!empty($custom_pages) && !empty($current_path)) {
                foreach($custom_pages as $custom_page) {
                    $pos = strpos($current_path, $custom_page);
                    if($pos !== false && ($pos == 0 || $pos == 1)) {
                        $redirect = false;
                        break;
                    }
                }
            }

            // Redirect to non-SSL
            if($redirect) {
                $uri->setScheme('http');
                $application->redirect($uri->toString());
                return $application->close();
            }
        }
    }
}
