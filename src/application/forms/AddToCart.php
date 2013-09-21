<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2012-02-05 18:06:07 -0300 (Sun, 05 Feb 2012) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/forms/AddToCart.php $
 * @revision - $Revision: 383 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2012-02-05 18:06:07 -0300 (Sun, 05 Feb 2012) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Form_AddToCart extends Zend_Form
{
    /**
     * Sets the product id for the product to be added
     * @param int $id
     * @return void
     */
    public function setProductId($id)
    {
        $this->getElement('productId')->setValue($id);
    }
    
    /**
     * Creates the add to cart form.
     * @see Zend_Form::init()
     * @return void
     */
    public function init()
    {
        $config = new Zend_Config_Ini(
            APPLICATION_PATH . '/configs/forms/addToCart.ini',
            'addToCart'
        );
        $this->setConfig($config->addToCart);
    }
}