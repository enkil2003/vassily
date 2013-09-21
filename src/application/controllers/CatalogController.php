<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2012-02-19 14:19:00 -0300 (Sun, 19 Feb 2012) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/controllers/CatalogController.php $
 * @revision - $Revision: 414 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2012-02-19 14:19:00 -0300 (Sun, 19 Feb 2012) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

require_once 'VassilymasController.php';
class CatalogController extends VassilymasController
{
    /**
     * Init function.
     * @see Zend_Controller_Action::init()
     * @return void
     */
    public function init()
    {
        $this->view->menu()->setActiveCategory($this->_request->getParam('activeCategory', null));
        $this->view->subcategories()->setParentCategoryName($this->_request->getParam('activeCategory', null));
        $this->view->placeholder('headerPromotion')->append($this->view->partial('_headerPromotion.phtml'));
        $this->view->placeholder('social')->append($this->view->partial('social.phtml'));
        $this->view->headLink()->appendStylesheet(APPLICATION_CDN . "/css/catalog.css");
    }
    
    /**
     * Default view for index action.
     * @return void
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $category = $request->getParam('activeCategory', null);
        $subcategory = $request->getParam('activeSubcategory', null);
        $subcategoryId = $request->getParam('activeSubcategoryId', null);
        $page = $request->getParam('pagina', 1);
        $productsAndPager = !$subcategoryId ?
            Products::getRandomProductsByCategoryName($category):
            Products::getProductsAndPagerBySubcategoryId($subcategoryId, $page);
        $this->view->products = $productsAndPager->products;
        $this->view->pager = isset($productsAndPager->pager)
            ? $productsAndPager->pager
            : null;
        $this->view->category = $category;
        $this->view->subcategoryId = $subcategoryId;
        $this->view->subcategory = $subcategory;
        $this->view->currentPage = $page;
        $this->_helper->loadDefaultJs();
    }
}