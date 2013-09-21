<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/views/helpers/Menu.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Zend_View_Helper_Menu extends Zend_View_Helper_Abstract
{
    /**
     * Name for the active category.
     * @var string
     */
    private $_activeCategory = null;
    
    /**
     * Categories to populate the menu
     * @var array
     */
    private $_categories = array();
    
    /**
     * Init method for menu view helper.
     * @return Zend_View_Helper_Menu for fluent interface.
     */
    public function menu ()
    {
        if ($this->_categories == null) {
            $this->_loadCategories();
        }
        return $this;
    }
    
    /**
     * Loads categories from database.
     * @throws Exception if problem is encountered with the database.
     * @return void.
     */
    private function _loadCategories()
    {
        try {
            $this->_categories = Doctrine_Core::getTable('Category')->findAll(Doctrine_Core::HYDRATE_ARRAY);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    /**
     * Sets the active category in the menu.
     * @param string $activeCategory name for the active category.
     * @return Zend_View_Helper_Menu for fluent interface.
     */
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
    
    /**
     * Returns the active category for the helper
     * @return string string representation for this object
     */
    public function getActiveCategory()
    {
        return $this->_activeCategory;
    }
    
    /**
     * Generates menu step html representation
     * @return string string representation for this object
     */
    public function render()
    {
        $this->view->categories = $this->_categories;
        return $this->view->render('helpers/menu.phtml');
    }
    
    /**
     * Generates menu step html representation
     * @return string string representation for this object
     */
    public function __toString()
    {
        return $this->render();
    }
}

