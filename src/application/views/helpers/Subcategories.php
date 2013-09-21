<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2012-02-19 14:19:00 -0300 (Sun, 19 Feb 2012) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/views/helpers/Subcategories.php $
 * @revision - $Revision: 414 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2012-02-19 14:19:00 -0300 (Sun, 19 Feb 2012) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Zend_View_Helper_Subcategories extends Zend_View_Helper_Abstract
{
    private $_subcategories = array();
    private $_parentCategoryName = null;
    
    public function subcategories()
    {
        return $this;
    }
    
    private function _populate()
    {
        try {
            $c = Doctrine::getTable('Category')->findOneByName(
                $this->getParentCategoryName()
            )->toArray();
            $this->_subcategories = Subcategories::getOrderedSubcategoriesByCategoryId($c['id']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function setParentCategoryName($categoryName)
    {
        $this->_parentCategoryName = $categoryName;
    }
    
    public function getParentCategoryName()
    {
        return $this->_parentCategoryName;
    }
    
    /**
     * Object printed version.
     * @return string string representation for this object
     */
    public function __toString()
    {
        $this->_populate();
        $this->view->parentCategoryName = $this->_parentCategoryName;
        $this->view->subcategories = $this->_subcategories;
        $this->view->activeSubcategory = Zend_Controller_Front::getInstance()
            ->getRequest()->getParam('activeSubcategory');
        return $this->view->render('helpers/subcategories.phtml');
    }
}
