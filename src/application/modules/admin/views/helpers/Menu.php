<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/modules/admin/views/helpers/Menu.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Zend_View_Helper_Menu extends Zend_View_Helper_Abstract
{
    private $_activeCategory = null;
    private $_categories = array();
    public function menu()
    {
        if ($this->_categories == null) {
            $this->_loadMenuOptions();
        }
        return $this;
    }
    private function _loadMenuOptions()
    {
        $this->_categories = array(
            array(
                'name' => 'subcategorías',
                'controller' => 'subcategory'
            ),
            array(
                'name' => 'productos',
                'controller' => 'products'
            ),
            array(
                'name' => 'promociones',
                'controller' => 'promotions',
            ),
        );
    }
    public function setActiveCategory($activeCategory)
    {
        foreach ($this->_categories as &$c) {
            $c['class'] = '';
            if ($activeCategory == $c['name']) {
                $c['class'] = 'active'; 
            }
        }
        $this->_activeCategory = $activeCategory;
        return $this;
    }
    public function getActiveCategory()
    {
        return $this->_activeCategory;
    }
    public function render()
    {
        $this->view->categories = $this->_categories;
        return $this->view->render('helpers/menu.phtml');
    }
    public function __toString()
    {
        try {
            return $this->render();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

