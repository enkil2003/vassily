<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/modules/admin/controllers/CategoryController.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

require_once 'CustomController.php';
class Admin_CategoryController extends Admin_CustomController
{
    const CONTROLLER_NAME = 'category';
    public function init()
    {
        parent::init();
        $this->_setDefaultMenu();
    }
    
    protected function _setDefaultMenu()
    {
        $this->view->placeholder('catalogLeftColumn')->append(
            $this->view->partial(
                'helpers/adminCrud.phtml',
                array(
                    'title' => 'Categorias',
                    'menu' => array(
                        array(
                            'url' => '/admin/category',
                            'title' => 'Agregar Categoría'
                        ),
                        array(
                            'url' => '/admin/category/modify',
                            'title' => 'Modificar Categoría'
                        ),
                    )
                )
            )
        );
    }
    
    public function indexAction()
    {
        $this->_helper->loadDefaultCss();
        $this->_helper->loadDefaultJs();
        $form = new Form_Categories();
        $form->setAction('/admin/'.self::CONTROLLER_NAME); /* @TODO es necesario esto? lo hago en otros lados? */
        $request = $this->getRequest();
        if ($request->isPost() && $form->isValid($request->getPost())) {
            $categoria = new Category();
            $categoria->name = $form->getValue('name');
            $categoria->save();
        }
        $this->view->form = $form;
    }
    /**
     * @TODO creo q no estoy usando esto!!! habla todo de subcategorias, ¿hay q migrar?
     */
    public function ajaxAction() {
        $request = $this->getRequest();
        if($request->isXmlHttpRequest()) {
            switch($request->getParam('request')) {
                case 'setSubcategoriesOrder':
                    $i = 0;
                    foreach ($_GET['order'] as $id) {
                        try {
                            $subcategory = Doctrine_Core::getTable('Subcategories')->findOneById($id);
                            $subcategory->order = $i;
                            $subcategory->save();
                        } catch ( Exception $e) {
                            echo $e->getMessage();
                        }
                        $i++;
                    }
                break;
            }
            die;
        }
    }
}