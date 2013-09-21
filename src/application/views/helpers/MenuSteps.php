<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/views/helpers/MenuSteps.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Zend_View_Helper_MenuSteps extends Zend_View_Helper_Abstract
{
    /**
     * Associatve array with Menu steps
     * @var array
     */
    protected $_steps;
    
    /**
     * Init method for menu steps view helper.
     * @return Zend_View_Helper_MenuSteps for fluent interface.
     */
    public function menuSteps()
    {
        return $this;
    }
    
    /**
     * Sets the steps to populatethe selected label for the menu step.
     * @param array $steps Associatve array with Menu steps to populate the view helper.
     * @return Zend_View_Helper_MenuSteps for fluent interface.
     */
    public function setSteps(array $steps)
    {
        $this->_steps = $steps;
        return $this;
    }
    
    /**
     * Sets the selected label for the menu step.
     * @param string $selectedLabel selected step label.
     * @return Zend_View_Helper_MenuSteps for fluent interface.
     */
    public function setSelectedLabel($selectedLabel)
    {
        foreach ($this->_steps as &$step) {
            if ($step['label'] == $selectedLabel) {
                $step['selected'] = true;
                break;
            }
        }
        return $this;
    }
    
    /**
     * Generates menu step html representation
     * @return string string representation for this object
     */
    public function render()
    {
        $html = $this->view->partial(
            'helpers/menuSteps.phtml',
            array(
                'steps' => $this->_steps
            )
        );
        return $html;
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
