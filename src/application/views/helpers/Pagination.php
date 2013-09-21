<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/views/helpers/Pagination.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Zend_View_Helper_Pagination extends Zend_View_Helper_Abstract
{
    /**
     * This methods returns the pagination object for fluent interface.
     * @return Zend_View_Helper_Pagination fluent interface.
     */
    public function pagination()
    {
        return $this;
    }
    
    /**
     * Object printed version.
     * @return string string representation for this object
     */
    public function __toString()
    {
        return $this->view->render('/helpers/pagination.phtml');
    }
}