<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2012-02-05 17:38:39 -0300 (Sun, 05 Feb 2012) $
 * 
 * @filesource - $HeadURL: http://subversion.assembla.com/svn/vassilymas/trunk/application/controllers/UserController.php $
 * @revision - $Revision: 382 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2012-02-05 17:38:39 -0300 (Sun, 05 Feb 2012) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Vassilymas_View_Helper_RequiredMark extends Zend_View_Helper_Abstract
{
    public function requiredMark()
    {
        return <<<DISCLAIMER
<span class="requiredMark">*</span>

DISCLAIMER;
    }
}