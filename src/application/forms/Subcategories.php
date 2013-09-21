<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/forms/Subcategories.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Form_Subcategories extends Form_VassilymasAbstract
{
    /**
     * Populates the parent category element, based on the $childs param
     * @param boolean $childs true if you only want categories with subcategories
     */
    public function populateParentCategories($childs) {
        $parentCategory = $this->getElement('category');
        $parentCategory->clearMultiOptions();
        $parentCategory->addMultiOption('-1', $this->_view->translate('Seleccione una categoria'));
        if (!$childs) {
            $categories = Doctrine_Core::getTable('Category')->findAll()->toArray();
        } else {
            $categories = Doctrine_Query::create()->from('Category c')
                ->innerJoin('c.Subcategories s')->execute()->toArray();
        }
        foreach($categories as $c) {
            $parentCategory->addMultiOption($c['id'], $c['name']);
        }
    }
    
    /**
     * Creates the parent category element.
     * @return Zend_Form_Element_Select
     */
    private function createParentCategoryElement()
    {
        $parentCategory = $this->createElement(
            'select',
            'category',
            array(
                'DisableLoadDefaultDecorators' => true,
                'decorators' => array(
                    'ViewHelper'
                ),
                'required' => true,
                'validators' => array(
                    'Int'
                )
            )
        );
        return $parentCategory;
    }
    
    /**
     * Creates the subcategories form.
     * @see Zend_Form::init()
     * @return void
     */
    public function init()
    {
        $parentCategory = $this->createParentCategoryElement();
        $this->addElement($parentCategory);
        $this->populateParentCategories(false);
        $name = $this->createElement(
            'text',
            'name',
            array(
                'DisableLoadDefaultDecorators' => true,
                'decorators' => array(
                    'ViewHelper'
                ),
                'required' => true,
                'filters' => array(
                    'StringTrim',
                    array('StringToLower', array('encoding' => 'utf-8')),
                ),
                'attribs' => array(
                    'placeholder' => $this->_view->translate('ingrese el nombre')
                )
            )
        );
        $this->addElements(array($parentCategory, $name));
        $this->addDefaultSubmit($this->_view->translate('Agregar Subcategoría'));
    }
}
