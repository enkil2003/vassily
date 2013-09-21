<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2012-02-26 16:55:16 -0300 (Sun, 26 Feb 2012) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/modules/admin/controllers/SubcategoryController.php $
 * @revision - $Revision: 435 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2012-02-26 16:55:16 -0300 (Sun, 26 Feb 2012) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

require_once 'CustomController.php';
class Admin_SubcategoryController extends Admin_CustomController
{
    const CONTROLLER_NAME = 'subcategory';
    /**
     * init hook with custom construct settings
     */
    public function init()
    {
        parent::init();
        $this->view->placeholder('admin')->setPrefix('<div id="adminPanel">');
        $this->view->placeholder('admin')->setPostfix('</div>');
        $this->view->actions = array(
            array(
                'name' => 'Nueva Subcategoria',
                'controller' => self::CONTROLLER_NAME,
                'action' => ''
            ),
            array(
                'name' => 'Modificar Categoria',
                'controller' => self::CONTROLLER_NAME,
                'action' => 'modify'
            )
        );
        $this->_setDefaultMenu();
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
                    'title' => 'Subcategorías',
                    'menu' => array(
                        array(
                            'url' => '/admin/subcategory',
                            'title' => 'Agregar Subcategoría'
                        ),
                        array(
                            'url' => '/admin/subcategory/modify',
                            'title' => 'Modificar Subategoría'
                        ),
                    )
                )
            )
        );
    }
    /**
     * Default view for index action
     * @return void
     */
    public function indexAction()
    {
        $form = new Form_Subcategories();
        $form->setAction('/admin/'.self::CONTROLLER_NAME);
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest() && $form->isValid($request->getPost())) {
            Subcategories::create($form->getValue('category'), $form->getValue('name'));
            $this->view->layout()->disableLayout();
            echo Zend_Json::encode(array('success' => true));
            die;
        }
        $this->_helper->loadDefaultCss();
        $this->_helper->loadDefaultJs();
        $this->view->form = $form;
    }
    /**
     * Default view for modify action
     * @return void
     */
    public function modifyAction()
    {
        $form = new Form_Subcategories();
        $form->populateParentCategories(true);
        $form->setAction('/admin/subcategorias');
        $this->view->form = $form;
        $this->_helper->loadDefaultCss();
        $this->_helper->loadDefaultJs();
        // add jeditable css
        $this->view->minifyFooterScript()->appendFile("/js/jquery/plugins/jquery.jeditable.js");
    }
    public function sortAction()
    {
        $form = new Form_Subcategories();
        $form->setAction('/admin/'.self::CONTROLLER_NAME);
        $this->view->form = $form;
    }
    /**
     * Handles diferent ajax request for subcategory controller
     * @return void
     */
    public function ajaxAction()
    {
        $request = $this->getRequest();
        if (!$request->isXmlHttpRequest()) {
            die;
        }
        switch ($request->getParam('request')) {
            case 'subcategoriesList':
                echo Zend_Json::encode($this->_getSubcategoriesList((int)$request->getParam('parentCategoryId')));
                break;
            case 'setSubcategoriesOrder':
                $this->_setSubcategoriesOrder($request->getParam('order'));
                break;
            case 'modifySubcategoryName':
                $res = Doctrine_Query::create()
                    ->update('Subcategories')
                    ->set('name', "'{$request->getPost('value')}'")
                    ->where('id = '.$request->getPost('id'))
                    ->execute();
                echo $request->getPost('value');
                break;
            case 'remove':
                echo Zend_Json::encode(array('result' => (bool)Subcategories::deleteById($request->getParam('id'))));
                break;
            case 'edit':
                echo Zend_Json::encode(
                    array(
                        'result' => (bool)Subcategories::changeName(
                            $request->getParam('id'),
                            $request->getParam('name')
                        )
                    )
                );
                break;
        }
        die;
    }
    /*******************/
    /* PRIVATE METHODS */
    /*******************/
    /**
     * Returns all subcategories filtered from category id
     * @param int$categoryId category id
     * @return void
     */
    private function _getSubcategoriesList($categoryId)
    {
        $subcategories = Subcategories::getAllOrderedSubcategoriesByCategoryId($categoryId);
        return $subcategories;
    }
    /**
     * Saves the new subcategories order
     * @param array $order an array conformed with the id and order for the subcategories
     * @return void
     */
    private function _setSubcategoriesOrder($order)
    {
        $i = 1;
        foreach ($order as $id) {
            try {
                $subcategory = Doctrine_Core::getTable('subcategories')
                    ->findOneById($id);
                $subcategory->order = $i;
                $subcategory->save();
            } catch ( Exception $e) {
                echo $e->getMessage();
            }
            $i++;
        }
    }
}