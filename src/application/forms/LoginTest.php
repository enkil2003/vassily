<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: http://subversion.assembla.com/svn/vassilymas/trunk/application/forms/Login.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Form_LoginTest extends Zend_Form
{
    /**
     * Creates the categories form.
     * @see Zend_Form::init()
     * @return void
     */
    public function init()
    {
        $this->addPrefixPath(
            'My_Form_Decorator',
            'My/Form/Decorator/',
            'decorator'
        );
        
        $this->loadDefaultDecorators();
        $id = uniqid('form');
        $this->setAttrib('id',$id);
        
        $this->addDecorator(
            'JsAutoValidation',
            array(
                'validatorTriggerSelector' => 'LoginSubmit'
            )
        );
        
        $this->_view = $this->getView();
        $usernameOrEmail = $this->createElement(
            'text',
            'usernameOrEmail',
            array(
                'filters' => array(
                    'StringTrim'
                ),
                'required' => true,
                'validators' => array(
                    array(
                        'NotEmpty',
                        true,
                        array(
                            'messages' => array(
                                Zend_Validate_NotEmpty::INVALID => 'Debe ingresar un usuario',
                                Zend_Validate_NotEmpty::IS_EMPTY => 'Debe ingresar un usuario'
                            )
                        )
                    ),
                    array(
                        'StringLength',
                        false,
                        array(
                            'min' => 5,
                            'max' => 20,
                            'messages' => array(
                                Zend_Validate_StringLength::INVALID => 'Debe ingresar un usuario o email1',
                                Zend_Validate_StringLength::TOO_SHORT => 'El usuario debe tener un minimo de %min%',
                                Zend_Validate_StringLength::TOO_LONG => 'El usuario debe tener un maximo de %max%'
                            )
                        )
                    )
                ),
                'attribs' => array(
                    'placeholder' => $this->_view->translate('email o usuario')
                )
            )
        );
        $password = $this->createElement(
            'password',
            'password',
            array(
                'required' => true,
                'filters' => array(
                    'StringTrim'
                ),
                'validators' => array(
                    array(
                        'NotEmpty',
                        true,
                        array(
                            'messages' => array(
                                Zend_Validate_NotEmpty::INVALID => 'Debe ingresar un usuario',
                                Zend_Validate_NotEmpty::IS_EMPTY => 'Debe ingresar un usuario'
                            )
                        )
                    ),
                    array(
                        'StringLength',
                        false,
                        array(
                            'min' => 5,
                            'max' => 20,
                            'messages' => array(
                                Zend_Validate_StringLength::INVALID => 'Debe ingresar un usuario o email1',
                                Zend_Validate_StringLength::TOO_SHORT => 'El usuario debe tener un minimo de %min%',
                                Zend_Validate_StringLength::TOO_LONG => 'El usuario debe tener un maximo de %max%'
                            )
                        )
                    )
                ),
                'attribs' => array(
                    'placeholder' => $this->_view->translate('contraseña')
                )
            )
        );
        $this->addElements(array($usernameOrEmail, $password));
        $this->addElement(
            'submit',
            'LoginSubmit',
            array(
                'label' => 'Ingresar'
            )
        );
    }
}