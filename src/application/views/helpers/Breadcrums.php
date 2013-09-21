<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/views/helpers/Breadcrums.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

/**
 * Helper for making easy breadcrumbs
 */
class Zend_View_Helper_Breadcrums extends Zend_View_Helper_Abstract
{
    /**
     * Items to populate the bredcrums.
     * @var array
     */
    private $_items = array();
    
    /**
     * Breadcrum separator.
     * @var string
     */
    private $_separator = ' / ';
 
    /**
     * @param string $title
     * @param string $route
     * @param array $params
     * @return Zend_View_Helper_Breadcrums
     */
    public function breadcrums($title = null, $route = null, array $params = array())
    {
        if (is_null($title)) {
            return $this;
        }
        $item['title']  = $title;
        $item['router'] = $route;
        $item['params'] = $params;
        $this->_items[] = $item; 
        return $this;
    }

    /**
     * Renders the breadcrum
     */
    public function render()
    {
        $router = Zend_Controller_Front::getInstance()->getRouter();
        $items = array();
        foreach ($this->_items as $item) {
            if ($item['router'] == $router->getCurrentRouteName()) {
                $items[] = $item['title'];
            } else {
                $url = $router->assemble($item['params'], $item['router']);
                $items[] = sprintf('<a href="%s">%s</a>', $url, $item['title']);
            }
        }
        return implode($this->getSeparator(), $items);
    }

    /**
     * Object printed version.
     * @return string string representation for this object
     */
    public function __toString()
    {
        return $this->render();
    }
 
    /**
     * Sets the breadcrum's separator
     * @param string $separator
     */
    public function setSeparator($separator)
    {
        $this->_separator = $separator;
    }
    
    /**
     * Returns the breadcrum's separator
     * @return string
     */
    public function getSeparator()
    {
        return $this->_separator;
    }
}