<?php
class Form_TestForm extends Zend_Form
{
    /**
     * Creates the contact form.
     * @see Zend_Form::init()
     * @return void
     */
    public function init()
    {
        $config = new Zend_Config_Ini(
            APPLICATION_PATH . '/configs/forms/test.ini',
            'contact'
        );
        $this->setConfig($config->contact);
    }
}