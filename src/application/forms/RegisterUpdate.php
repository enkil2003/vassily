<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2012-02-07 01:43:26 -0300 (Tue, 07 Feb 2012) $
 * 
 * @filesource - $HeadURL: http://subversion.assembla.com/svn/vassilymas/trunk/application/forms/Register.php $
 * @revision - $Revision: 389 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2012-02-07 01:43:26 -0300 (Tue, 07 Feb 2012) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Form_RegisterUpdate extends Form_RegisterAbstract
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
            'update'
        );
        $this->setConfig($config->register);
        
        $this->_addProvinceElements($this->getElement('province'));
    }
}
