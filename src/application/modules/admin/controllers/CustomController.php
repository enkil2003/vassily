<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2012-02-26 16:55:16 -0300 (Sun, 26 Feb 2012) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/modules/admin/controllers/CustomController.php $
 * @revision - $Revision: 435 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2012-02-26 16:55:16 -0300 (Sun, 26 Feb 2012) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

abstract class Admin_CustomController extends Zend_Controller_Action
{
    /**
     * Initiliazes common resources for admin, like css and js
     * @see Zend_Controller_Action::init()
     */
    public function init() 
    {
        $this->view->headLink()->appendStylesheet(APPLICATION_CDN . '/css/modules/admin/admin.css');
        $this->view->headLink()->appendStylesheet(APPLICATION_CDN . "/css/catalog.css");
        // add jquery ui
        $this->view->minifyFooterScript()->appendFile("/js/jquery/jquery-ui-1.8.15.custom.min.js");
        $this->view->headLink()->appendStylesheet(APPLICATION_CDN . "/css/smoothness/jquery-ui-1.8.15.custom.css");
    }
    
    /**
     * Sets defaults navigation menu actions for the controller
     */
    protected abstract function _setDefaultMenu();
}