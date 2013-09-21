<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2012-02-21 02:51:26 -0300 (Tue, 21 Feb 2012) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/forms/VassilymasAbstract.php $
 * @revision - $Revision: 429 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2012-02-21 02:51:26 -0300 (Tue, 21 Feb 2012) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

abstract class Form_VassilymasAbstract extends Zend_Form
{
    /**
     * Default contructor preventing cross site forgery.
     * @param mixed $options
     * @return void
     */
    public function __construct($options = null)
    {
        $this->_view = $this->getView();
        parent::__construct($options);
        $this->addElement(
            'hash',
            'no_csrf',
            array(
                'salt' => 'unique',
                'disableLoadDefaultDecorators' => true,
                'decorators' => array(
                    'ViewHelper'
                )
            )
        );
    }
    /**
     * Easy way to add the submit button, or replace it for updating in child forms
     * @param mixed array/string if using arrays, use the same Zend_Form_Element_Submit $options, if string use the
     * desired button's name
     */
    public function addDefaultSubmit($options = null)
    {
        if(is_string($options)) {
            $_options['label'] = $options;
        } else {
            $_options = $options;
        }
        if(!$_options['label']) {
            $_options['label'] = 'Enviar';
        }
        $_options['disableLoadDefaultDecorators'] = isset($_options['disableLoadDefaultDecorators'])?
            $_options['disableLoadDefaultDecorators']:
            true;
        $_options['decorators'] = isset($_options['decorators'])
            ? $_options['decorators']
            : array('ViewHelper');
        $submit = new Zend_Form_Element_Submit('submit', $_options);
        $this->addElement($submit);
    }
    
    /**
     * Easy way to generate hidden id fields.
     * @return void
     */
    public function setRowId($id) {
        $this->addElement(
            'hidden',
            'id',
            array(
                'value' => $id,
                'disableLoadDefaultDecorators' => true,
                'decorators' => array(
                    'ViewHelper'
                )
            )
        );
    }
}