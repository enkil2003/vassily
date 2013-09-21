<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/forms/Newsletter.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Form_Newsletter extends Form_VassilymasAbstract
{
    /**
     * Creates the newsletter form.
     * @see Zend_Form::init()
     * @return void
     */
    public function init()
    {
        $this->removeDecorator('FormElements');
        $email = new My_Form_Element_Email('email', array('placeholder' => $this->_view->translate('ingrese su email')));
        $email->addValidator(new Zend_Validate_EmailAddress());
        $email->removeDecorator('HtmlTag')->removeDecorator('label');
        
        $name = new Zend_Form_Element_Text('name', array('placeholder' => $this->_view->translate('Nombre')));
        $name->removeDecorator('HtmlTag')->removeDecorator('label');
        $this->addElements(array($email, $name));
    }
}