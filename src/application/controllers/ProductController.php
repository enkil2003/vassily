<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2012-02-26 16:55:16 -0300 (Sun, 26 Feb 2012) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/controllers/ProductController.php $
 * @revision - $Revision: 435 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2012-02-26 16:55:16 -0300 (Sun, 26 Feb 2012) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

require_once 'VassilymasController.php';
class ProductController extends VassilymasController
{
    /**
     * Init function.
     * @see Zend_Controller_Action::init()
     * @return void
     */
    public function init()
    {
        $this->view->placeholder('headerPromotion')->append($this->view->partial('_headerPromotion.phtml'));
        $this->view->placeholder('social')->append($this->view->partial('social.phtml'));
    }
    
    /**
     * Default view for index action.
     * @return void
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $form = new Form_AddToCart();
        $form->setProductId($request->getParam('productId'));
        $product = Products::getProductById($request->getParam('productId'));
        $this->view->product = $product;
        $activeCategory = $request->getParam('activeCategory');
        $activeCategoryId = $request->getParam('activeCategoryId');
        $activeSubcategoryName = $request->getParam('activeSubcategoryName');
        $activeSubcategoryId = $request->getParam('activeSubcategoryId');
        
        $this->view->form = $form;
        $this->view->menuSteps()->setSteps(
            array(
                array(
                    'label' => ucwords($activeCategory),
                    'href' => "/showroom/{$activeCategory}",
                ),
                array(
                    'label' => $activeSubcategoryName,
                    'href' => "/showroom/{$activeCategory}/{$activeSubcategoryId}/{$activeSubcategoryName}",
                ),
                array(
                    'label' => $product['name'],
                    'selected' => true
                )
            )
        );
        
        $uri = $request->getRequestUri();
        
        $this->_helper->loadDefaultJs();
        $this->_helper->loadDefaultCss();
        // add pikachoose js
        $this->view->minifyFooterScript()->appendFile("/js/jquery/plugins/jquery.pikachoose.full.js");
        
        $this->view->facebookButtons()
             ->setHref($uri);
        
        $this->view->twitterButtons()
             ->setVia('vassilymas')
             ->setSize(My_View_Helper_TwitterButtons::TWITTER_BUTTON_SIZE_MEDIUM)
             ->setText('Recomendar este producto')
             ->setCount(My_View_Helper_TwitterButtons::TWITTER_COUNT_POSITION_NONE)
             ->setButtonType(My_View_Helper_TwitterButtons::TWITTER_SHARE_BUTTON);
        
        $this->view->googlePlusButtons()
             ->setHref($uri);
   }
}