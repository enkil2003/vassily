<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/forms/PasswordReset.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

require_once 'VassilymasAbstract.php';
class Form_PasswordReset extends Form_VassilymasAbstract
{
    /**
     * Creates the password reset form.
     * @see Zend_Form::init()
     * @return void
     */
    public function init()
    {
        $this->addElementPrefixPath(
            'My_Validate_Doctrine',
            'My/Validate/Doctrine',
            Zend_Form_Element::VALIDATE
        );
        $email = $this->createElement(
            'text',
            'email',
            array(
                'DisableLoadDefaultDecorators' => true,
                'decorators' => array(
                    'ViewHelper'
                ),
                'required' => true,
                'filters' => array(
                    'StringTrim'
                ),
                'validators' => array(
                    'EmailAddress',
                    array('DbRecordExists', false, array('user', 'email'))
                ),
                'attribs' => array(
                    'placeholder' => $this->_view->translate('ejemplo@dominio.com')
                )
            )
        );
        $this->addElements(array($email));
    }
}