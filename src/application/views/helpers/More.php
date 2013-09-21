<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2012-02-17 10:06:01 -0300 (Fri, 17 Feb 2012) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/views/helpers/More.php $
 * @revision - $Revision: 410 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2012-02-17 10:06:01 -0300 (Fri, 17 Feb 2012) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Zend_View_Helper_More extends Zend_View_Helper_Abstract
{
    /**
     * Generates the more button view helper.
     * @return string string representation for this object
     */
    public function more($url, $options = array())
    {
        return $this->view->partial(
            'helpers/more.phtml',
            array(
                'url' => $url,
                'class' => isset($options['extraClasses'])? $options['extraClasses']:'',
                'tag' => isset($options['tag'])? $options['tag']:'footer' 
            )
        );
    }
}