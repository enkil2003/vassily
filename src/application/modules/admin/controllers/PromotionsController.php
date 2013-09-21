<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/modules/admin/controllers/PromotionsController.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

require_once 'CustomController.php';
class Admin_PromotionsController extends Admin_CustomController
{
    const CONTROLLER_NAME = 'promotions';
    /**
     * init hook with custom construct settings
     */
    public function init()
    {
        parent::init();
        $this->_setDefaultMenu();
    }
    /**
     * Default View for index action
     * @return void
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $form = new Form_Promotions();
        if ($request->isPost() && $form->isValid($request->getPost())) {
            try {
                $form->headerPromotion->receive();
                $this->updateHeaderPromotion();
                
                $form->rightPromotion->receive();
                $this->updateRightPromotion();
                
                $form->leftPromotion->receive();
                $this->updateLeftPromotion();
            } catch (Zend_File_Transfer_Exception $e) {
                // @TODO handle this the right way
                echo $e->getMessage();
                die;
            }
        }
        $this->view->form = $form;
        $this->_helper->loadDefaultCss();
        $this->_helper->loadDefaultJs();
    }
    /**
     * Verifies if the administrator has updated the header promotion
     */
    private function updateHeaderPromotion()
    {
        if (!file_exists(APPLICATION_PATH . '/../public/uploads/promotions/header.png')) {
            return;
        }
        if (file_exists(APPLICATION_PATH . '/../public/images/header.png')) {
            unlink(APPLICATION_PATH . '/../public/images/header.png');
        }
        copy(
            APPLICATION_PATH . '/../public/uploads/promotions/header.png',
            APPLICATION_PATH . '/../public/images/header.png'
        );
        unlink(APPLICATION_PATH . '/../public/uploads/promotions/header.png');
    }
    /**
     * Verifies if the administrator has updated the left promotion
     */
    private function updateLeftPromotion()
    {
        if (!file_exists(APPLICATION_PATH . '/../public/uploads/promotions/promotion.jpg')) {
            return;
        }
        if (file_exists(APPLICATION_PATH . '/../public/images/promotion.jpg')) {
            unlink(APPLICATION_PATH . '/../public/images/promotion.jpg');
        }
        copy(
            APPLICATION_PATH . '/../public/uploads/promotions/promotion.jpg',
            APPLICATION_PATH . '/../public/images/promotion.jpg'
        );
        unlink(APPLICATION_PATH . '/../public/uploads/promotions/promotion.jpg');
    }
    /**
     * Verifies if the administrator has updated the right promotion
     */
    private function updateRightPromotion()
    {
        if (!file_exists(APPLICATION_PATH . '/../public/uploads/promotions/promotionText.png')) {
            return;
        }
        if (file_exists(APPLICATION_PATH . '/../public/images/promotionText.png')) {
            unlink(APPLICATION_PATH . '/../public/images/promotionText.png');
        }
        copy(
            APPLICATION_PATH . '/../public/uploads/promotions/promotionText.png',
            APPLICATION_PATH . '/../public/images/promotionText.png'
        );
        unlink(APPLICATION_PATH . '/../public/uploads/promotions/promotionText.png');
    }
    /**
     * @see Admin_CustomController::_setDefaultMenu()
     */
    protected function _setDefaultMenu()
    {
        $this->view->placeholder('catalogLeftColumn')->append(
            $this->view->partial(
                'helpers/adminCrud.phtml',
                array(
                    'title' => 'Promociones',
                    'menu' => array(
                        array(
                            'url' => '/admin/promotions',
                            'title' => 'Modificar Promociones'
                        )
                    )
                )
            )
        );
    }
}