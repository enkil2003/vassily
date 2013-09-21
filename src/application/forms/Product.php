<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/forms/Product.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Form_Product extends Form_VassilymasAbstract
{
    /**
     * This method is responsable for changing the way categories are loaded on the update form
     * @return Form_Product
     */
    protected function _createCategorySelector()
    {
        $categories = Category::getCategoriesAndSubcategories();
        foreach($categories as $cat) {
            $subcategories = $this->createElement(
                'multiCheckbox',
                'category_'.$cat['id'],
                array(
                    'DisableLoadDefaultDecorators' => true,
                    'decorators' => array(
                        'ViewHelper',
                        'label',
                        array('div' => 'htmlTag', 'tag' => 'div')
                    )
                )
            );
            foreach($cat['Subcategories'] as $subcategory) {
                $subcategories->addMultiOption($subcategory['id'], $subcategory['name']);
            }
            $this->addDisplayGroup(
                array($subcategories),
                $cat['name'],
                array(
                    'legend' => $cat['name'],
                )
            );
        }
        return $this;
    } 
    
    /**
     * Creates the product form.
     * @see Zend_Form::init()
     * @return void
     */
    public function init()
    {
        $this->setAttrib("enctype", "multipart/form-data");
        $this->_createCategorySelector();
        $name = $this->createElement(
            'text',
            'name',
            array(
                'decorators' => array(
                    'ViewHelper',
                    'label'
                ),
                'label' => 'Nombre',
                'required' => true,
                'placeholder' => 'ingrese un nombre',
                'filters' => array(
                    'StringTrim'
                )
            )
        );
        $description = $this->createElement(
            'textarea',
            'description',
            array(
                'decorators' => array(
                    'ViewHelper',
                    'label'
                ),
                'label' => 'Descripción',
                'required' => true,
                'filters' => array(
                    'StringTrim'
                ),
            )
        );
        $price = $this->createElement(
            'text',
            'price',
            array(
                'decorators' => array(
                    'ViewHelper',
                    'label'
                ),
                'label' => 'Precio',
                'required' => true,
                'placeholder' => 'ingrese un precio',
                'filters' => array(
                    'StringTrim'
                )
            )
        );
        $width = $this->createElement(
            'text',
            'width',
            array(
                'decorators' => array(
                    'ViewHelper',
                    'label'
                ),
                'label' => 'Ancho',
                'placeholder' => 'ingrese medidas (mts)'
            )
        );
        $height = $this->createElement(
            'text',
            'height',
            array(
                'decorators' => array(
                    'ViewHelper',
                    'label'
                ),
                'label' => 'Alto',
                'placeholder' => 'ingrese medidas (mts)'
            )
        );
        $depth = $this->createElement(
            'text',
            'depth',
            array(
                'decorators' => array(
                    'ViewHelper',
                    'label'
                ),
                'label' => 'Profundidad',
                'placeholder' => 'ingrese medidas (mts)'
            )
        );
        $price = $this->createElement(
            'text',
            'price',
            array(
                'decorators' => array(
                    'ViewHelper',
                    'label'
                ),
                'label' => 'Precio',
                'required' => true,
                'placeholder' => 'ingrese un precio'
            )
        );
        $materials = $this->createElement(
            'textarea',
            'materials',
            array(
                'decorators' => array(
                    'ViewHelper',
                    'label'
                ),
                'label' => 'Materiales',
                'required' => true,
            )
        );
        $this->addElements(
            array(
                $name,
                $description,
                $price,
                $width,
                $height,
                $depth,
                $materials
            )
        );
    }
}