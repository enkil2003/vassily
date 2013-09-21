<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/views/helpers/Pikachoose.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Zend_View_Helper_Pikachoose extends Zend_View_Helper_Abstract
{
    /**
     * Returns the pikachoose view helper.
     * @param array $images images array.
     * @return string html string
     */
    public function pikachoose(array $images)
    {
        $href = defined('APPLICATION_CDN')? APPLICATION_CDN:'';
        $this->view->headLink()->appendStylesheet($href.'/css/pikachoose.css');
        $html = "<div class=\"pikachoose\">
  <ul id=\"pikame\">\n";
        foreach ($images as $image) {
            $html .= "<li>
      <img src=\"".$href."/uploads/thumb/{$image}\"
        ref=\"".$href."/uploads/image/{$image}\" alt='' title='' />
      <span></span>
    </li>\n";
        }
        $html .= "</ul>
</div>\n";
        return $html;
    }
}
