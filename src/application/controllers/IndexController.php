<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2012-02-05 19:55:14 -0300 (Sun, 05 Feb 2012) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/controllers/IndexController.php $
 * @revision - $Revision: 384 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2012-02-05 19:55:14 -0300 (Sun, 05 Feb 2012) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

require_once 'VassilymasController.php';
class IndexController extends VassilymasController
{
    private $_category = null;
    private $_subcategoryId = null;
    
    /**
     * Configures common behaviors and features for all the actions in this controller.
     * @see Zend_Controller_Action::init()
     * @return void
     */
    public function init()
    {
        $this->_category = $this->_request->getParam('activeCategory', null);
        $this->_subcategoryId = $this->_request->getParam('activeSubcategoryId', null);
        $this->view->categoryName = $this->_category;
        $this->view->activeSubcategoryId = $this->_subcategoryId;
        $this->view->productId = $this->_request->getParam('productId', null);
        $this->view->menu()->setActiveCategory($this->_category);
        $this->view->subcategories()->setParentCategoryName($this->_category);
        $this->view->placeholder('headerPromotion')->append($this->view->partial('_headerPromotion.phtml'));
        $this->view->placeholder('footerPromotion')->append($this->view->partial('_footerPromotion.phtml'));
        $this->view->placeholder('social')->append($this->view->partial('social.phtml'));
    }
    
    /**
     * Default view for index action.
     * @return void
     */
    public function indexAction()
    {
    }
    
    /**
     * Default view for newsletter action.
     * @return void
     */
    public function newsletterAction()
    {
        $this->_clearLayoutPlaceHolders();
        $this->_helper->loadDefaultCss();
    }
    
    /**
     * Method to catch generic ajaxs calls
     * @return string json response
     */
    public function ajaxCallsAction()
    {
        $request = $this->getRequest();
        if (!$request->isXmlHttpRequest()) {
        	die;
        }
        $this->view->layout()->disableLayout();
        switch ($request->getParam('do')) {
            case 'addToNewsletter':
                $form = new Form_Newsletter();
                $data = array(
                    'name' => $request->getParam('name'),
                    'email' => $request->getParam('email')
                );
                $added = false;
                if ($form->isValid($data)) {
                    $mchimp = Vassilymas_Service_Locator::createMailchimpObject();
                    $added = $mchimp->add($form->getValue('name'), $form->getValue('email'));
                }
                echo Zend_Json::encode(array('added' => $added));
                break;
        }
        die;
    }
    
    /**
     * Default view for contact action.
     * @return void
     */
    public function contactAction()
    {
        $request = $this->getRequest();
        $form = new Form_Contact();
        if ($request->isPost() && $form->isValid($request->getPost())) {
            $contactData = $form->getValues();
            $emailService = Vassilymas_Service_Locator::createEmailObject();
            // send thank you email
            $emailService->send(
                Zend_Registry::get('config')->email->noreply,
                'Vassilymas',
                $form->getValue('email'),
                $form->getValue('name'),
                $this->view->translate('Gracias por su contacto'),
                'thanks-for-your-contact',
                array(
                    'name' => $form->getValue('name') . ' ' . $form->getValue('lastname')
                )
            );
            // send email to administrator
            $emailService->send(
                $form->getValue('email'),
                $form->getValue('name'),
                Zend_Registry::get('config')->email->email,
                'Vassilymas',
                $this->view->translate('Nos hicieron un contacto!!!'),
                'contact-arrived',
                array('contactData' => $contactData),
                Vassilymas_Service_Email::ADMIN_LAYOUT
            );
            Contact::createContact($contactData);
            $this->_helper->redirector(
                $this->view->translate('gracias-por-su-contacto'),
                ''
            );
        }
        $this->_helper->loadDefaultCss();
        $this->view->form = $form;
        $this->_clearLayoutPlaceHolders(array('social'));
    }
    
    /**
     * Default view for thanks for your contact action.
     * @return void
     */
    public function thanksForYourContactAction()
    {
        $this->_clearLayoutPlaceHolders();
        $this->_helper->loadDefaultCss();
    }
    
    public function testAction() {
        $form = new Form_TestForm();
        $this->_helper->loadDefaultCss();
        if($this->_request->isPost() && $form->isValid($_POST)) {
            
        }
        $this->view->form = $form;
    }
}