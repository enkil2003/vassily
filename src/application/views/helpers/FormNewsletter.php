<?php
/**
 * Vassilymas
 *
 * LICENSE http://www.gnu.org/licenses/gpl.txt
 *
 * This source file is subject to the GPL license that is bundled
 * with this package in the file LICENSE.txt located at the docs folder.
 *
 * @copyright  Copyright (c) 2011 and future, Ricardo Buquet
 * @license    http://www.gnu.org/licenses/gpl.txt     GPL  
 */

class Zend_View_Helper_FormNewsletter extends Zend_View_Helper_Abstract
{
    /**
     * Generates the newsletter form to be used in the social partial.
     * @return Zend_View_Helper_FormNewsletter
     */
    public function formNewsletter()
    {
        return $this;
    }
    
    /**
     * Generates menu step html representation
     * @return string string representation for this object
     */
    public function __toString()
    {
        return $this->render();
    }
    
    /**
     * Generates menu step html representation
     * @return string string representation for this object
     */
    public function render()
    {
        $html = $this->view->partial(
            'helpers/formNewsletter.phtml',
            array(
                'form' => new Form_Newsletter()
            )
        );
        return $html;
    }
}