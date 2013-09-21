<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/modules/admin/views/helpers/AdminCrud.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Zend_View_Helper_AdminCrud extends Zend_View_Helper_Abstract
{
    private $_menu = array();
    private $_title = null;
    public function adminCrud()
    {
        return $this;
    }
    
    public function setTitle($title)
    {
        $this->_title = $title;
        return $this;
    }
    
    public function setMenuItems(array $menu)
    {
        $this->_menu = $menu;
        return $this;
    }
    
    public function __toString()
    {
        return $this->view->partial(
            'helpers/adminCrud.phtml',
            array(
                'title' => $this->_title,
                'menu' => $this->_menu
            )
        );
    }
}
