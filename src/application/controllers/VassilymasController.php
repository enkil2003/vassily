<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/controllers/VassilymasController.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

abstract class VassilymasController extends Zend_Controller_Action
{
    /**
     * Layout's placeholders
     * @var array placeholders
     */
    protected $_placeholders = array(
        'headerPromotion',
        'catalogLeftColumn',
        'catalog',
        'admin',
        'social',
        'footerPromotion'
    );
    
    /**
     * Clears common placeholders
     * @param mixed $exeptions placeholder string / array
     */
    protected function _clearLayoutPlaceHolders($exeptions = array())
    {
        $exeptions = !is_array($exeptions)? array($exeptions):$exeptions;
        $count = count($exeptions);
        foreach($this->_placeholders as $ph) {
            if($count && in_array($ph, $exeptions)) {
                continue;
            }
            $this->view->placeholder($ph)->exchangeArray(array()); 
        }
    }
}