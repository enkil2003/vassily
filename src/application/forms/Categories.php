<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/forms/Categories.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Form_Categories extends Form_VassilymasAbstract
{
    /**
     * Creates the categories form.
     * @see Zend_Form::init()
     * @return void
     */
    public function init()
    {
        $name = $this->createElement(
            'text',
            'name',
            array(
                'DisableLoadDefaultDecorators' => true,
                'decorators' => array(
                    'ViewHelper'
                ),
                'required' => true,
                'validators' => array(
                    'alpha',
                ),
                'filters' => array(
                    'StringTrim',
                    'StringToLower',
                    'HtmlEntities'
                ),
                'attribs' => array(
                    'required' => 'required',
                    'pattern' => '[a-zA-Z ]{5,}',
                    'maxlength' => '30',
                    'data-invalid' => "Please Read and Accept the Terms and Conditions"
                )
            )
        );
        $submit = $this->createElement(
            'button',
            'submit',
            array(
                'DisableLoadDefaultDecorators' => true,
                'decorators' => array(
                    'ViewHelper'
                ),
                'label' => 'Enviar',
                'type' => 'submit'
            )
        );
        $this->addElements(array($name, $submit));
    }
}
