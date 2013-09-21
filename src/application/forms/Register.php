<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2012-02-21 02:05:29 -0300 (Tue, 21 Feb 2012) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/forms/Register.php $
 * @revision - $Revision: 425 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2012-02-21 02:05:29 -0300 (Tue, 21 Feb 2012) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Form_Register extends Form_RegisterAbstract
{
    /**
     * Creates the register form.
     * @see Zend_Form::init()
     * @return void
     */
    public function init()
    {
        $config = new Zend_Config_Ini(
            APPLICATION_PATH . '/configs/forms/register.ini',
            'register'
        );
        $this->setConfig($config->register);
        
        $this->_addProvinceElements($this->getElement('province'));
    }
}
