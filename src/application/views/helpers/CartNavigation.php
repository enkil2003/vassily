<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/views/helpers/CartNavigation.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

/**
 * 
 * This class is responsable for rendering the cart navigational steps
 * @author Ricardo
 *
 */
class Zend_View_Helper_CartNavigation extends Zend_View_Helper_Abstract
{
    public function cartNavigation($selected = 'step1')
    {
        $this->_selected = $selected;
        return $this;
    }
    /**
     * Generates menu step html representation
     * @return string string representation for this object
     */
    public function render()
    {
        return $this->view->partial('helpers/cartNavigation.phtml', array('selected' => $this->_selected));
    }
    
    /**
     * Generates menu step html representation
     * @return string string representation for this object
     */
    public function __toString()
    {
        return $this->render();
    }
}

