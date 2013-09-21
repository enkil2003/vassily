<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/forms/ProductUpdate.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Form_ProductUpdate extends Form_Product
{
    /**
     * This method is responsable for changing the way categories are loaded on the update form
     * @return Form_ProductUpdate
     */
    protected function _createCategorySelector()
    {
        $categoriesSelector = new Zend_Form_Element_Select(
            'categories',
            array(
                'DisableLoadDefaultDecorators' => true,
                'decorators' => array(
                    'ViewHelper',
                    'label',
                    array('div' => 'htmlTag', 'tag' => 'div')
                )
            )
        );
        $categoriesSelector->addMultiOption('-1', 'Seleccione una categoria');
        $q = new Doctrine_Query();
        $q->select('c.*')
            ->from('Category c')
            ->innerJoin('c.Subcategories s')
            ->innerJoin('s.SubcategoriesHasProducts shp')
            ->innerJoin('shp.Products');
        $categories = $q->execute(Doctrine_Core::HYDRATE_ARRAY);
        foreach($categories as $cat) {
            $categoriesSelector->addMultiOption($cat['id'], $cat['name']);
        }
        $this->addElement($categoriesSelector);
        
        $subcategoriesSelector = new Zend_Form_Element_Select(
            'subcategories',
            array(
                'DisableLoadDefaultDecorators' => true,
                'decorators' => array(
                    'ViewHelper',
                    'label',
                    array('div' => 'htmlTag', 'tag' => 'div'),
                ),
                'disabled' => true
            )
        );
        $subcategoriesSelector->addMultiOption('-1', 'Primero debe seleccionar una categoria');
        $this->addElement($subcategoriesSelector);
        return $this;
    } 
}