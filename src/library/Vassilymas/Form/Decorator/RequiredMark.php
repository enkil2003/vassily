<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2012-02-05 17:38:39 -0300 (Sun, 05 Feb 2012) $
 * 
 * @filesource - $HeadURL: $
 * @revision - $Revision: 382 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2012-02-05 17:38:39 -0300 (Sun, 05 Feb 2012) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Vassilymas_Form_Decorator_RequiredMark extends Zend_Form_Decorator_Abstract
{
    /**
     * Render the required advisory
     *
     * @param  string $content
     * @return string
     */
    public function render($content)
    {
        $element = $this->getElement();
        $view    = $element->getView();
        if (null === $view) {
            return $content;
        }

        $separator = $this->getSeparator();
        $placement = $this->getPlacement();
        
        $requiredAvisory = $view->requiredMark();
        switch ($placement) {
            case self::APPEND:
                return $content . $separator . $requiredAvisory;
            case self::PREPEND:
                return $requiredAvisory . $separator . $content;
        }
    }
}