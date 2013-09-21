<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2012-02-26 16:55:16 -0300 (Sun, 26 Feb 2012) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/controllers/CartController.php $
 * @revision - $Revision: 435 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2012-02-26 16:55:16 -0300 (Sun, 26 Feb 2012) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

require_once 'VassilymasController.php';
class CartController extends VassilymasController
{
    /**
     * Init function.
     * @see Zend_Controller_Action::init()
     * @return void
     */
    public function init()
    {
        
    }
    
    /**
     * Add to Cart Action, redirects to cart/show-cart custom route, mi-carrito
     * @void
     */
    public function addAction()
    {
        $request = $this->getRequest();
        $form = new Form_AddToCart();
        if ($request->isPost() && $form->isValid($request->getPost())) {
            $cart = Vassilymas_Service_Locator::createCartObject();
            $cart->addItemToOrder($form->getValue('productId'));
            $this->_helper->redirector(
                $this->view->translate('mi-carrito'),
                ''
            );
        }
    }
    
    /**
     * Shows the cart view
     * @return void
     */
    public function showCartAction()
    {
        $auth = Zend_Auth::getInstance();
        $hasIdentity = $auth->hasIdentity();
        
        $request = $this->getRequest();
        $cart = Vassilymas_Service_Locator::createCartObject();
        
        $this->view->minifyFooterScript()->appendFile(
             "/js/jquery/jquery-ui-1.8.15.custom.min.js"
        );
        $this->view->headLink()->appendStylesheet(
             "/css/smoothness/jquery-ui-1.8.15.custom.css"
        );
        $this->view->addHelperPath(
            'ZendX/JQuery/View/Helper',
            'ZendX_JQuery_View_Helper'
        );
        $this->_clearLayoutPlaceHolders(array('social'));
        $this->_setResgitrationAndLoginMenuSteps(
            $this->view->translate('Mi Carrito')
        );
        $this->view->orderdetails = Vassilymas_Service_Locator::createCartObject()
            ->getOrderDetails();
        // first load the default css
        $this->_helper->loadDefaultCss();
        
        // only if we have products, we need these javascripts and styles
        if (count($this->view->orderdetails)) {
            $this->view->headLink()->appendStylesheet("/js/jquery/plugins/confirm/jquery.confirm.css");
            $this->view->headLink()->appendStylesheet("/js/jquery/plugins/confirm/customization.css");
            $this->view->headLink()->appendStylesheet("/js/jquery/plugins/fancybox/jquery.fancybox.css");
            $this->view->minifyFooterScript()->appendFile("/js/jquery/plugins/jquery.putCursorAtTheEnd.js");
            $this->view->minifyFooterScript()->appendFile("/js/jquery/plugins/jquery.allowOnlyNumeric.js");
            $this->view->minifyFooterScript()->appendFile("/js/jquery/plugins/jquery.printf.js");
            $this->view->minifyFooterScript()->appendFile("/js/jquery/plugins/fancybox/jquery.fancybox.js");
            $this->view->minifyFooterScript()->appendFile("/js/jquery/plugins/jquery.confirm.js");
            $this->view->minifyFooterScript()->appendFile("/js/jquery/plugins/validate/jquery.validate.js");
            $this->_helper->loadDefaultJs();
        }
        
        $form = new Form_Checkout();
        /* @TODO ricardo: validate this form */
        if ($request->isPost() /* && $form->isValid($request->getPost() */) {
            if ($request->getPost('payMethod') === 'arrival') {
                // proced to checkout
                $cart->checkout($request->getPost());
                
                // remember the user name, and redirect to the success page
                $fullname = $request->getPost('name') . ' ' . $request->getPost('lastname');
                if ($hasIdentity) {
                    $user = $auth->getIdentity();
                    $userData = User::getUserData($user['id']);
                    $fullname = "{$userData['name']} {$userData['lastname']}";
                }
                $this->_helper->flashMessenger->addMessage(
                    $fullname
                );
                $this->_helper->redirector(
                    $this->view->translate('pedido-realizado'),
                    ''
                );
            } else {
                $this->_helper->redirector(
                    $this->view->translate('dineromail'),
                    ''
                );
            }
        } else if($request->isPost()) {
            print_r($form->getErrors());die;
        }
        
        if ($hasIdentity) {
            $user = $auth->getIdentity();
            $this->view->user = User::getUserData($user['id']);
        }
        
        $this->view->form = $form;
        $this->view->configJs()->setSimpleVars(
            array(
                'user' => $hasIdentity
            )
        );
    }
    
    public function checkoutSuccessAction()
    {
        $messages = $this->_helper->flashMessenger->getMessages();
        $this->view->name = $messages[0];
        $this->view->headLink()->appendStylesheet( "/css/cart/show-cart.css");
        $this->_helper->loadDefaultCss();
    }
    
    public function dineromailAction()
    {
        
    }
    
    /**
     * This method is in change of handling ajax requests
     * @return void
     */
    public function ajaxCallsAction()
    {
        $request = $this->getRequest();
        if (!$request->isXmlHttpRequest()) {
            throw new Exception("no soup for you!");
        }
        $this->view->layout()->disableLayout();
        $cart = Vassilymas_Service_Locator::createCartObject();
        $response = array();
        switch ($request->get('do')) {
            case 'remove':
                $cart->removeItemFromOrder($request->get('id'));
                $response['result'] = true;
                break;
            case 'update':
                $cart->setItemQuantity($request->get('id'), $request->get('quantity'));
                $response['result'] = true;
                break;
        }
        echo Zend_Json::encode($response);
        die;
    }
    
    /**
     * Helper method to create controller's menu steps
     * @param string $selected name for the selected step
     * @return void
     */
    private function _setResgitrationAndLoginMenuSteps($selected = null)
    {
        $hasIdentity = Zend_Auth::getInstance()->hasIdentity();
        $this->view->menuSteps()->setSteps(
            array(
                array(
                    'label' => $this->view->translate('Mi Vassilymas'),
                    'href' => '/'.$this->view->translate('mi-vassilymas'),
                ),
                array(
                    'label' => $this->view->translate('Mi Carrito'),
                    'href' => '/'.$this->view->translate('mi-carrito'),
                ),
                array(
                    'label' => $hasIdentity? $this->view->translate('Mis Datos'):$this->view->translate('Registrate'),
                    'href' => $hasIdentity? '/'.$this->view->translate('mis-datos'):'/'.$this->view->translate('registrate'),
                )
            )
        )->setSelectedLabel($selected);
    }
}