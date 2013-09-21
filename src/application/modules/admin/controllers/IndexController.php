<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/modules/admin/controllers/IndexController.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Admin_IndexController extends Zend_Controller_Action
{
    public function init() {
        $this->view->setScriptPath(APPLICATION_PATH.'/views/scripts/helpers');
        $this->view->addScriptPath(APPLICATION_PATH.'/modules/admin/views/scripts/');
        $this->view->addHelperPath(APPLICATION_PATH.'/views/helpers');
    }
    public function indexAction()
    {
    }
    
    public function addCategoryAction()
    {
//        require_once APPLICATION_PATH .'/forms/ExampleForm.php';
//        $form = new Forms_ExampleForm();
//        echo $form;die;
    }
}