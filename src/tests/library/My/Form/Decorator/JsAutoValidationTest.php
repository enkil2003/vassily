<?php
class My_Form_Decorator_JsAutoValidationTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_fixture = new My_Form_Decorator_JsAutoValidation();
    }
    
    public function tearDown()
    {
        $this->_fixture = null;
    }
    
    public function testGetJsNamespace()
    {
        $class = new ReflectionClass ('My_Form_Decorator_JsAutoValidation');
        $method = $class->getMethod ('getJsNamespace');
        $method->setAccessible(true);
        $output = $method->invoke ($this->_fixture);
        
        $this->assertEquals('My', $output);
    }
    
    public function testSetJsNamespace()
    {
        $newNamespace = '__NEW__';
        $class = new ReflectionClass ('My_Form_Decorator_JsAutoValidation');
        $method = $class->getMethod ('setJsNamespace');
        $method->setAccessible(true);
        $method->invoke ($this->_fixture, $newNamespace);
        
        $method = $class->getMethod ('getJsNamespace');
        $method->setAccessible(true);
        $output = $method->invoke ($this->_fixture);
        
        $this->assertEquals($newNamespace, $output);
    }
    
    public function testGetElementErrorDecorator()
    {
        $formMock = $this->getMock(
            'Zend_Form',
            array('getElements'),
            array(),
            '',
            false
        );
        
        $elementMock = $this->getMock(
            'Zend_Form_Element',
            array('getDecorator', 'getName','hasErrors', 'getView', 'getDecorators'),
            array(),
            '',
            false
        );
        
        $formMock->expects($this->once())
            ->method('getElements')
            ->will($this->returnValue(array($elementMock)));
            
        
        $errorDecoratorMock = $this->getMock(
            'Zend_Form_Decorator_Errors',
            array('getOptions', 'setOption', 'render', 'getSeparator', 'getPlacement'),
            array(),
            '',
            false
        );
        
        $viewMock = $this->getMock(
            'Zend_View',
            array('getHelper'),
            array(),
            '',
            false
        );
        
        $formErrorsHelperMock = $this->getMock(
            'Zend_View_Helper_FormErrors',
            array('setOption', 'getElementStart', 'getElementEnd', 'getElementSeparator'),
            array(),
            '',
            false
        );
        
        // line 79
        $elementMock->expects($this->once())
             ->method('getDecorator')
             ->with($this->equalTo('Errors'))
             ->will($this->returnValue($errorDecoratorMock));
             
        // line 83
        $elementMock->expects($this->once())
            ->method('getView')
            ->will($this->returnValue($viewMock));
        
        // line 83
        $viewMock->expects($this->once())
            ->method('getHelper')
            ->will($this->returnValue($formErrorsHelperMock));
        
        // line 88
        $errorDecoratorMock->expects($this->once())
            ->method('setOption')
            ->with(
                $this->equalTo('class'),
                $this->equalTo('errors')
            );
        
        // line 96
        $errorDecoratorMock->expects($this->once())
            ->method('getSeparator')
            ->will($this->returnValue('__SEPARATOR__'));
            
        // line 97
        $errorDecoratorMock->expects($this->once())
            ->method('getPlacement')
            ->will($this->returnValue('__APPEND__'));
        
        $elementMock->addDecorator($errorDecoratorMock);
        
        // line 100
        $formErrorsHelperMock->expects($this->once())
            ->method('getElementStart')
            ->will($this->returnValue('__START__'));
        
        // line 101
        $formErrorsHelperMock->expects($this->once())
            ->method('getElementSeparator')
            ->will($this->returnValue('__SEPARATOR__'));
        
        // line 102
        $formErrorsHelperMock->expects($this->once())
            ->method('getElementEnd')
            ->will($this->returnValue('__END__'));
        
        // line 104
        $errorDecoratorMock->expects($this->once())
            ->method('getOptions')
            ->will($this->returnValue(array('class' => 'errors')));
        
        $class = new ReflectionClass ('My_Form_Decorator_JsAutoValidation');
        $method = $class->getMethod ('_getElementErrorDecorator');
        $method->setAccessible(true);
        $return = $method->invoke ($this->_fixture, $formMock);
        
        $expected = array(
            array(
                'errorDecorator' =>  array(
                    'separator' => '__SEPARATOR__',
                    'placement' => '__APPEND__'
                ),
                'formErrorsHelper' => array(
                    'elementStart' => '__START__',
                    'elementSeparator' => '__SEPARATOR__',
                    'elementEnd' => '__END__'
                ),
                'options' => array(
                    'class' => 'errors'
                )
            )
        );
        
        $this->assertEquals($expected, $return);
    }
    
    public function testGetElementErrorDecoratorReturnVoid()
    {
        $formMock = $this->getMock(
            'Zend_Form',
            array('getElements'),
            array(),
            '',
            false
        );
        
        $elementMock = $this->getMock(
            'Zend_Form_Element',
            array('getDecorator'),
            array(),
            '',
            false
        );
        
        $formMock->expects($this->once())
            ->method('getElements')
            ->will($this->returnValue(array($elementMock)));
        
        $elementMock->expects($this->once())
             ->method('getDecorator')
             ->with('Errors')
             ->will($this->returnValue(false));
             
        $class = new ReflectionClass ('My_Form_Decorator_JsAutoValidation');
        $method = $class->getMethod ('_getElementErrorDecorator');
        $method->setAccessible(true);
        $return = $method->invoke ($this->_fixture, $formMock);
        
        $this->assertEquals(array(), $return);
    }
    
    public function testGetElementFiltersReturnVoid()
    {
        $elementMock = $this->getMock(
            'Zend_Form_Element',
            array('getDecorator'),
            array(),
            '',
            false
        );
        
        $elementMock = $this->getMock(
            'Zend_Form_Element',
            array('getFilters'),
            array(),
            '',
            false
        );
        
        $elementMock->expects($this->once())
            ->method('getFilters')
            ->will($this->returnValue(false));
        
        $class = new ReflectionClass ('My_Form_Decorator_JsAutoValidation');
        $method = $class->getMethod ('_getElementFilters');
        $method->setAccessible(true);
        $return = $method->invoke ($this->_fixture, $elementMock);
    }
    
    public function testGetElementFiltersWithStringTrim()
    {
        $elementMock = $this->getMock(
            'Zend_Form_Element',
            array('getFilters', 'getName'),
            array(),
            '',
            false
        );
        
        $stringTrimFilterMock = $this->getMock(
            'Zend_Filter_StringTrim',
            array(),
            array(),
            'Mock_Filter_StringTrim',
            false
        );
        
        $elementMock->expects($this->once())
            ->method('getFilters')
            ->will($this->returnValue(array($stringTrimFilterMock)));
        
        $class = new ReflectionClass ('My_Form_Decorator_JsAutoValidation');
        $method = $class->getMethod ('_getElementFilters');
        $method->setAccessible(true);
        $return = $method->invoke ($this->_fixture, $elementMock);
        $expected = array('StringTrim');
        $this->assertEquals($expected, $return);
    }
    
    public function testGetElementValidators()
    {
        $elementMock = $this->getMock(
            'Zend_Form_Element',
            array('getValidators', 'getName'),
            array(),
            '',
            false
        );
        
        $validatorMock = $this->getMock(
            'Zend_Validate_EmailAddress',
            array(),
            array(),
            '',
            false
        );
        
        $this->_fixture = $this->getMock(
            'My_Form_Decorator_JsAutoValidation',
            array('_buildValidationRules'),
            array(),
            '',
            false
        );
        
        $this->_fixture->expects($this->once())
            ->method('_buildValidationRules')
            ->with($this->equalTo($elementMock))
            ->will($this->returnValue('__SCRIPT__'));
        
        $elementMock->expects($this->once())
            ->method('getValidators')
            ->will($this->returnValue(array($validatorMock)));
        
        $class = new ReflectionClass ('My_Form_Decorator_JsAutoValidation');
        $method = $class->getMethod ('_getElementValidators');
        $method->setAccessible(true);
        $return = $method->invoke ($this->_fixture, $elementMock);
        
        $this->assertEquals('__SCRIPT__', $return);
    }
    
    public function testGetElementValidatorsRequiredElementWithNotEmptyValidator()
    {
        $elementMock = $this->getMock(
            'Zend_Form_Element',
            array('getValidator', 'getValidators', 'getName', 'isRequired'),
            array(),
            '',
            false
        );
        
        $elementMock->expects($this->once())
            ->method('isRequired')
            ->will($this->returnValue(true));
        
        $this->_fixture = $this->getMock(
            'My_Form_Decorator_JsAutoValidation',
            array('_buildValidationRules'),
            array(),
            '',
            false
        );
        
        // line 161
        $elementMock->expects($this->once())
            ->method('getValidator')
            ->with('NotEmpty')
            ->will($this->returnValue(true));
        
        $class = new ReflectionClass ('My_Form_Decorator_JsAutoValidation');
        $method = $class->getMethod ('_getElementValidators');
        $method->setAccessible(true);
        $return = $method->invoke ($this->_fixture, $elementMock);
        
        $this->assertEquals('', $return);
    }
    
    public function testGetElementValidatorsRequiredElementButNoNotEmptyValidator()
    {
        $this->_fixture = $this->getMock(
            'My_Form_Decorator_JsAutoValidation',
            array('_buildValidationRules'),
            array(),
            '',
            false
        );
        
        $elementMock = $this->getMock(
            'Zend_Form_Element',
            array('addValidators', 'removeValidator', 'getValidator', 'getValidators', 'getName', 'isRequired'),
            array(),
            '',
            false
        );
        
        $validatorMock = $this->getMock(
            'Zend_Validate_EmailAddress',
            array(),
            array(),
            'Mock_Validate_EmailAddress',
            false
        );
        
        $collectedValidators = array(array('NotEmpty', true), $validatorMock);
        
        // line 158 and 170
        $elementMock->expects($this->exactly(2))
            ->method('getValidators')
            ->will($this->onConsecutiveCalls(array($validatorMock), $collectedValidators));
        
        // line 161
        $elementMock->expects($this->once())
            ->method('isRequired')
            ->will($this->returnValue(true));
        
        // line 161
        $elementMock->expects($this->once())
            ->method('getValidator')
            ->will($this->returnValue(false));
            
        // line 167
        $elementMock->expects($this->once())
            ->method('removeValidator')
            ->with('EmailAddress');
        
        // line 169
        $elementMock->expects($this->once())
            ->method('addValidators')
            ->with($this->equalTo($collectedValidators));
        
        // line 170
        $elementMock->expects($this->at(1))
            ->method('getValidators')
            ->will($this->returnValue($collectedValidators));
        
        $class = new ReflectionClass ('My_Form_Decorator_JsAutoValidation');
        $method = $class->getMethod ('_getElementValidators');
        $method->setAccessible(true);
        $return = $method->invoke ($this->_fixture, $elementMock);
        
        $this->assertEquals('', $return);
    }
    
    public function testBuildValidationRules()
    {
        $elementMock = $this->getMock(
            'Zend_Form_Element',
            array('getElements', 'getName', 'getValidators'),
            array(),
            '',
            false
        );
        
        $formMock = $this->getMock(
            'Zend_Form',
            array('getId'),
            array(),
            '',
            false
        );
        
        $this->_fixture = $this->getMock(
            'My_Form_Decorator_JsAutoValidation',
            array('getJsNamespace', 'getElement'),
            array(),
            '',
            false
        );
        
        // line 237 
        $this->_fixture->expects($this->once())
            ->method('getJsNamespace')
            ->will($this->returnValue('__JS_NAMESPACE__'));
        
        // line 239
        $this->_fixture->expects($this->once())
            ->method('getElement')
            ->will($this->returnValue($formMock));
        
        // line 239
        $formMock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('__FORM_ID__'));
        
        // line 240
        $elementMock->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('__ELEMENT_NAME__'));
        /////
        $return = array(
            'Mock_Validate_StringLength' => $this->getMock(
                'Zend_Validate_StringLength',
                array('__construct'),
                array(),
                'Mock_Validate_StringLength',
                false
            )
        );
        
        $elementMock->expects($this->once())
            ->method('getValidators')
            ->will($this->returnValue($return));
            
        $class = new ReflectionClass ('My_Form_Decorator_JsAutoValidation');
        $method = $class->getMethod ('_buildValidationRules');
        $method->setAccessible(true);
        $return = $method->invoke($this->_fixture, $elementMock);
        
        $expected = array(
            'NotRequired' => TRUE,
            'StringLength' => array(
                'min' => '',
                'max' => '',
                'encoding' => '',
                'messages' => array(),
                'messageVariables' => array('min', 'max'),
                'messageTemplates' => array(
                    'stringLengthInvalid' => "Invalid type given. String expected",
                    'stringLengthTooShort' => "'%value%' is less than %min% characters long",
                    'stringLengthTooLong' => "'%value%' is more than %max% characters long"
                ),
                'errors' => array(),
                'obscureValue' => '',
                'translator' => '',
                'defaultTranslator' => '',
                'messageLength' => -1
            )
        );
        
        $this->assertEquals($expected, $return);
        
        // NotRequired is the first validator, as act as a flag
        $shiftedValidator = array_shift($return);
        $this->assertEquals(TRUE, $shiftedValidator);
    }
    
    public function testBuildValidatorParameters()
    {
        $elementMock = $this->getMock(
            'Zend_Form_Element',
            array('getElements', 'getName', 'getValidators'),
            array(),
            '',
            false
        );
        
        $stringLengthValidatorMock = $this->getMock(
            'Zend_Validate_StringLength',
            array('__construct'),
            array(),
            '',
            false
        );
        
        $class = new ReflectionClass ('My_Form_Decorator_JsAutoValidation');
        $method = $class->getMethod ('_buildValidatorParameters');
        $method->setAccessible(true);
        $return = $method->invoke($this->_fixture, $stringLengthValidatorMock);
        
        $expected = array(
            'min' => '',
            'max' => '',
            'encoding' => '',
            'messages' => array(),
            'messageVariables' => array('min','max'),
            'messageTemplates' => array(
                'stringLengthInvalid' => 'Invalid type given. String expected',
                'stringLengthTooShort' => "'%value%' is less than %min% characters long",
                'stringLengthTooLong' => "'%value%' is more than %max% characters long"
            ),
            'errors' => array(),
            'obscureValue' => '',
            'translator' => '',
            'defaultTranslator' => '',
            'messageLength' => -1
        );
        
        $this->assertEquals($expected, $return);
    }
    
    public function testSetValidationTriggerSelector()
    {
        $formMock = $this->getMock(
            'Zend_Form',
            array('getElement'),
            array(),
            '',
            false
        );
        
        $elementMock = $this->getMock(
            'Zend_Form_Element_Submit',
            array('getName'),
            array(),
            '',
            false
        );
        
        $this->_fixture =  $this->getMock(
            'My_Form_Decorator_JsAutoValidation',
            array('getElement'),
            array(),
            '',
            false
        );
        
        $this->_fixture->expects($this->once())
            ->method('getElement')
            ->will($this->returnValue($formMock));
        
        $formMock->expects($this->once())
            ->method('getElement')
            ->with($this->equalTo('__TRIGGER__'))
            ->will($this->returnValue($elementMock));
        
        $return = $this->_fixture->setValidationTriggerSelector('__TRIGGER__');
        
        $this->assertEquals($return, $this->_fixture);
    }
    
    /**
     * @expectedException Zend_Exception
     */
    public function testSetValidationTriggerSelectorException()
    {
        $formMock = $this->getMock(
            'Zend_Form',
            array('getElement'),
            array(),
            '',
            false
        );
        
        $this->_fixture =  $this->getMock(
            'My_Form_Decorator_JsAutoValidation',
            array('getElement'),
            array(),
            '',
            false
        );
        
        $this->_fixture->expects($this->once())
            ->method('getElement')
            ->will($this->returnValue($formMock));
        
        $formMock->expects($this->once())
            ->method('getElement')
            ->with($this->equalTo('__TRIGGER__'))
            ->will($this->returnValue(null));
        
        $this->_fixture->setValidationTriggerSelector('__TRIGGER__');
    }
    
    public function testBuildJsVars()
    {
        $this->_fixture = $this->getMock(
            'My_Form_Decorator_JsAutoValidation',
            array('getView', 'getElement', '_getElementValidators', '_getElementErrorDecorator', '_getElementFilters'),
            array(),
            '',
            false
        );
        
        $formMock = $this->getMock(
            'Zend_Form',
            array('getView','getDecorator', 'getElements', 'getId'),
            array(),
            '',
            false
        );
        
        $elementMock = $this->getMock(
            'Zend_Form_Element',
            array(),
            array(),
            '',
            false
        );
        
        $viewMock = $this->getMock(
            'Zend_View',
            array('inlineScript'),
            array(),
            '',
            false
        );
        
        $stdMock = $this->getMock(
            'stdClass',
            array('captureStart', 'captureEnd'),
            array(),
            '',
            false
        );
        
        $stdMock->expects($this->once())
            ->method('captureStart')
            ->will($this->returnValue(null));
        
        $stdMock->expects($this->once())
            ->method('captureEnd')
            ->will($this->returnValue(null));
        
        $viewMock->expects($this->exactly(2))
            ->method('inlineScript')
            ->will($this->returnValue($stdMock));
        
        // line 180
        $this->_fixture->expects($this->any())
            ->method('getElement')
            ->will($this->returnValue($formMock));
        
        // line 181
        $formMock->expects($this->any())
            ->method('getDecorator')
            ->will($this->returnValue(false));
        
        // line 186
        $formMock->expects($this->once())
            ->method('getElements')
            ->will($this->returnValue(array($elementMock)));
        
        // line 187
        $this->_fixture->expects($this->once())
            ->method('_getElementValidators')
            ->with($this->equalTo($elementMock))
            ->will($this->returnValue(null));
        
        // line 190
        $this->_fixture->expects($this->once())
            ->method('_getElementErrorDecorator')
            ->with($this->equalTo($elementMock))
            ->will($this->returnValue(null));
        
        // line 193
        $this->_fixture->expects($this->once())
            ->method('_getElementFilters')
            ->with($this->equalTo($elementMock))
            ->will($this->returnValue(null));
        
        // line 203
        $formMock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('__FORM_ID__'));
        
        // line 214
        $formMock->expects($this->once())
            ->method('getView')
            ->will($this->returnValue($viewMock));
        
        ob_clean();
        ob_start();
        $class = new ReflectionClass ('My_Form_Decorator_JsAutoValidation');
        $method = $class->getMethod ('_buildJsVars');
        $method->setAccessible(true);
        $method->invoke ($this->_fixture);
        $return = ob_get_contents();
        ob_end_clean();
        
        $expected = <<<RETURN
var My = My || {};
My.Forms = My.Forms || {};
My.Forms.__FORM_ID__ = {};
My.Forms.__FORM_ID__.elements = [];
My.Forms.__FORM_ID__.FormErrorDecorator = null;

RETURN;
        $this->assertEquals($expected, $return);
    }
    
    public function testGetValidatorOptions()
    {
        $class = new ReflectionClass ('My_Form_Decorator_JsAutoValidation');
        $method = $class->getMethod ('getValidatorOptions');
        $method->setAccessible(true);
        $return = $method->invoke($this->_fixture);
        
        $this->assertNull($return);
    }
    
    public function testGetFormErrorsDecorator()
    {
        $this->_fixture = $this->getMock(
            'My_Form_Decorator_JsAutoValidation',
            array('getView', 'getElement', '_getElementValidators', '_getElementErrorDecorator', '_getElementFilters'),
            array(),
            '',
            false
        );
        
        $formMock = $this->getMock(
            'Zend_Form',
            array('getView','getDecorator', 'getElements', 'getId'),
            array(),
            '',
            false
        );
        
        $elementMock = $this->getMock(
            'Zend_Form_Element',
            array('getName', 'getLabel'),
            array(),
            '',
            false
        );
        
        $viewMock = $this->getMock(
            'Zend_View',
            array('getHelper'),
            array(),
            '',
            false
        );
        
        $formErrorDecoratorMock = $this->getMock(
            'Zend_Form_Decorator_FormErrors',
            array('getOnlyCustomFormErrors','getShowCustomFormErrors','ignoreSubForms','getSeparator','getPlacement','getMarkupListStart','getMarkupListItemStart', 'getMarkupListItemEnd', 'getMarkupElementLabelEnd', 'getMarkupElementLabelStart', 'getMarkupListEnd'),
            array(),
            '',
            false
        );
        
        $formErrorsViewHelperMock = $this->getMock(
            'Zend_View_Helper_FormErrors',
            array('getElementStart', 'getElementSeparator', 'getElementEnd'),
            array(),
            '',
            false
        );
        
        // line 383
        $this->_fixture->expects($this->once())
            ->method('getElement')
            ->will($this->returnValue($formMock));
        
        // line 384
        $formMock->expects($this->once())
            ->method('getView')
            ->will($this->returnValue($viewMock));
        
        // line 384
        $viewMock->expects($this->once())
            ->method('getHelper')
            ->with($this->equalTo('formErrors'))
            ->will($this->returnValue($formErrorsViewHelperMock));
        
        // line 385
        $formMock->expects($this->once())
            ->method('getDecorator')
            ->with($this->equalTo('FormErrors'))
            ->will($this->returnValue($formErrorDecoratorMock));
        
        // line 387
        $formMock->expects($this->once())
            ->method('getElements')
            ->will($this->returnValue(array($elementMock)));
        
        // line 388
        $elementMock->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('__ELEMENT_NAME__'));
        
        // line 388
        $elementMock->expects($this->once())
            ->method('getLabel')
            ->will($this->returnValue('__ELEMENT_LABEL__'));
        
        $formErrorDecoratorMock->expects($this->once())
            ->method('getMarkupElementLabelEnd')
            ->will($this->returnValue('__MARKUP_ELEMENT_LABEL_END__'));
        
        $formErrorDecoratorMock->expects($this->once())
            ->method('getMarkupElementLabelStart')
            ->will($this->returnValue('__MARKUP_ELEMENT_LABEL_START__'));
        
        $formErrorDecoratorMock->expects($this->once())
            ->method('getMarkupListEnd')
            ->will($this->returnValue('__MARKUP_LIST_END__'));
        
        $formErrorDecoratorMock->expects($this->once())
            ->method('getMarkupListItemEnd')
            ->will($this->returnValue('__MARKUP_LIST_ITEM_END__'));
        
        $formErrorDecoratorMock->expects($this->once())
            ->method('getMarkupListItemStart')
            ->will($this->returnValue('__MARKUP_LIST_ITEM_START__'));
        
        $formErrorDecoratorMock->expects($this->once())
            ->method('getMarkupListStart')
            ->will($this->returnValue('__MARKUP_LIST_START__'));
        
        $formErrorDecoratorMock->expects($this->once())
            ->method('getPlacement')
            ->will($this->returnValue('__PLACEMENT__'));
        
        $formErrorDecoratorMock->expects($this->once())
            ->method('getSeparator')
            ->will($this->returnValue('__SEPARATOR__'));
        
        $formErrorDecoratorMock->expects($this->once())
            ->method('ignoreSubForms')
            ->will($this->returnValue('__IGNORE_SUB_FORMS__'));
        
        $formErrorDecoratorMock->expects($this->once())
            ->method('getShowCustomFormErrors')
            ->will($this->returnValue('__SHOW_CUSTOM_FORM_ERRORS__'));
        
        $formErrorDecoratorMock->expects($this->once())
            ->method('getOnlyCustomFormErrors')
            ->will($this->returnValue('__ONLY_CUSTOM_FORM_ERRORS__'));
        
        $formErrorsViewHelperMock->expects($this->once())
            ->method('getElementStart')
            ->will($this->returnValue('__ELEMENT_START__'));
        
        $formErrorsViewHelperMock->expects($this->once())
            ->method('getElementSeparator')
            ->will($this->returnValue('__ELEMENT_SEPARATOR__'));
        
        $formErrorsViewHelperMock->expects($this->once())
            ->method('getElementEnd')
            ->will($this->returnValue('__ELEMENT_END__'));
        
        $class = new ReflectionClass ('My_Form_Decorator_JsAutoValidation');
        $method = $class->getMethod ('_getFormErrorsDecorator');
        $method->setAccessible(true);
        $return = $method->invoke($this->_fixture);
        
        $expected = array(
            'elementLabelEnd' => '__MARKUP_ELEMENT_LABEL_END__',
            'elementLabelStart' => '__MARKUP_ELEMENT_LABEL_START__',
            'listEnd' => '__MARKUP_LIST_END__',
            'listItemEnd' => '__MARKUP_LIST_ITEM_END__',
            'listItemStart' => '__MARKUP_LIST_ITEM_START__',
            'listStart' => '__MARKUP_LIST_START__',
            'placement' => '__PLACEMENT__',
            'separator' => '__SEPARATOR__',
            'ignoreSubForms' => '__IGNORE_SUB_FORMS__',
            'showCustomFormErrors' => '__SHOW_CUSTOM_FORM_ERRORS__',
            'onlyCustomFormErrors' => '__ONLY_CUSTOM_FORM_ERRORS__',
            'labels' => array('__ELEMENT_NAME__' => '__ELEMENT_LABEL__'),
            'formErrorsHelper' => array(
                'elementStart' => '__ELEMENT_START__',
                'elementSeparator' => '__ELEMENT_SEPARATOR__',
                'elementEnd' => '__ELEMENT_END__'
            )
        );
        
        $this->assertEquals($expected, $return);
    }
    
    public function testRender()
    {
        $this->_fixture = $this->getMock(
            'My_Form_Decorator_JsAutoValidation',
            array('getFormId', '_buildJsVars', 'getOptions','getOption','getView', 'getElement', '_getElementValidators', '_getElementErrorDecorator', '_getElementFilters'),
            array(),
            '',
            false
        );
        
        $formMock = $this->getMock(
            'Zend_Form',
            array('setAttrib','getView','getDecorator', 'getElements', 'getId'),
            array(),
            '',
            false
        );
        
        $elementMock = $this->getMock(
            'Zend_Form_Element',
            array('getName', 'getLabel'),
            array(),
            '',
            false
        );
        
        $viewMock = $this->getMock(
            'Zend_View',
            array('inlineScript', 'headScript'),
            array(),
            '',
            false
        );
        
        $inlineScriptMock = $this->getMock(
            'stdClass',
            array('captureStart', 'captureEnd'),
            array(),
            '',
            false
        );
        
        $headScriptMock = $this->getMock(
            'stdClass',
            array('appendFile'),
            array(),
            '',
            false
        );
        
        // line 309
        $this->_fixture->expects($this->once())
            ->method('getElement')
            ->will($this->returnValue($formMock));
        
        // line 310
        $formMock->expects($this->once())
            ->method('getView')
            ->will($this->returnValue($viewMock));
        
        // line 312
        $this->_fixture->expects($this->once())
            ->method('getFormId')
            ->will($this->returnValue('__FORM_ID__'));
        
        // line 315
        $this->_fixture->expects($this->once())
            ->method('getOption')
            ->with($this->equalTo('trigger'))
            ->will($this->returnValue(null));
        
//        // line 304
//        $this->_fixture->expects($this->once())
//            ->method('getOptions')
//            ->will($this->returnValue(null));
//        
//        // line 296
//        $formMock->expects($this->once())
//            ->method('getId')
//            ->will($this->returnValue('__FORM_ID__'));
//        
//        $formMock->expects($this->once())
//            ->method('setAttrib')
//            ->with($this->equalTo('id'), $this->equalTo('__FORM_ID__'));
//        
        // line 333
        $viewMock->expects($this->exactly(2))
            ->method('inlineScript')
            ->will($this->returnValue($inlineScriptMock));
        // line 333
        $inlineScriptMock->expects($this->once())
            ->method('captureStart')
            ->will($this->returnValue(null));
        // line 350
        $inlineScriptMock->expects($this->once())
            ->method('captureEnd')
            ->will($this->returnValue(null));
        // line 351
        $viewMock->expects($this->once())
            ->method('headScript')
            ->will($this->returnValue($headScriptMock));
        // line 351
        $headScriptMock->expects($this->once())
            ->method('appendFile')
            ->with($this->equalTo('/js/Validator.js'));
        
        $this->_fixture->expects($this->once())
            ->method('_buildJsVars');
        
        ob_clean();
        ob_start();
        $result = $this->_fixture->render('__CONTENT__');
        $return = ob_get_contents();
        ob_end_clean();
        
        $expected = <<<SCRIPT
$(function() {
    $('#__FORM_ID__').bind(
        'submit.JsAutoValidation',
        function(e) {
            e.preventDefault();
            if(
                My.Form.validate(
                    $('#__FORM_ID__'),
                    {}
                )
            ) {
                $('#__FORM_ID__').unbind('submit.JsAutoValidation').submit();
            }
        }
    );
});
SCRIPT;
        $this->assertEquals($expected, $return);
    }
    private function getMockObjects($options = array())
    {
        $return = array();
        if ($options['formMock']) {
            $formMock = $this->getMock(
                'Zend_Form',
                $options['formMock']['methods']
                    ? $options['formMock']['methods']
                    :array(),
                array(),
                '',
                false
            );
            $return['formMock'] = $formMock;
        }
        
        if ($options['elementMock']) {
            $elementMock = $this->getMock(
                $options['elementMock']['class']
                    ? $options['elementMock']['class']
                    : 'Zend_Form_Element',
                $options['formMock']['methods']
                    ? $options['formMock']['methods']
                    :array(),
                array(),
                '',
                false
            );
            $return['elementMock'] = $elementMock;
        }
        
    }
    
    public function testRenderWithTriggerEspecified()
    {
        $this->_fixture = $this->getMock(
            'My_Form_Decorator_JsAutoValidation',
            array('getFormId', '_buildJsVars', 'getOptions','getOption','getView', 'getElement', '_getElementValidators', '_getElementErrorDecorator', '_getElementFilters'),
            array(),
            '',
            false
        );
        
        $formMock = $this->getMock(
            'Zend_Form',
            array('setAttrib','getView','getDecorator', 'getElement', 'getElements', 'getId'),
            array(),
            '',
            false
        );
        
        $elementMock = $this->getMock(
            'Zend_Form_Element',
            array('getName', 'getLabel'),
            array(),
            '',
            false
        );
        
        $submitMock = $this->getMock(
            'Zend_Form_Element_Submit',
            array('getName'),
            array(),
            '',
            false
        );
        
        $viewMock = $this->getMock(
            'Zend_View',
            array('inlineScript', 'headScript'),
            array(),
            '',
            false
        );
        
        $inlineScriptMock = $this->getMock(
            'stdClass',
            array('captureStart', 'captureEnd'),
            array(),
            '',
            false
        );
        
        $headScriptMock = $this->getMock(
            'stdClass',
            array('appendFile'),
            array(),
            '',
            false
        );
        
      // line 309
        $this->_fixture->expects($this->once())
            ->method('getElement')
            ->will($this->returnValue($formMock));
        
        // line 310
        $formMock->expects($this->once())
            ->method('getView')
            ->will($this->returnValue($viewMock));
        // line 312
        $this->_fixture->expects($this->once())
            ->method('getFormId')
            ->will($this->returnValue('__FORM_ID__'));
        // line 313
        $this->_fixture->expects($this->once())
            ->method('getOptions')
            ->will($this->returnValue(null));
        // line 315
        $this->_fixture->expects($this->at(3))
            ->method('getOption')
            ->with($this->equalTo('trigger'))
            ->will($this->returnValue('__TRIGGER__'));
//        
      // line 316
        $formMock->expects($this->once())
            ->method('getElement')
            ->with('__TRIGGER__')
            ->will($this->returnValue($submitMock));
        // line 316
        $submitMock->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('__SUBMIT_NAME__'));
        // line 317
        $this->_fixture->expects($this->at(4))
            ->method('getOption')
            ->with($this->equalTo('event'))
            ->will($this->returnValue(null));
        // line 304
        $this->_fixture->expects($this->once())
            ->method('getOptions')
            ->will($this->returnValue(null));
        
        // line 333
        $viewMock->expects($this->exactly(2))
            ->method('inlineScript')
            ->will($this->returnValue($inlineScriptMock));
        // line 333
        $inlineScriptMock->expects($this->once())
            ->method('captureStart')
            ->will($this->returnValue(null));
        // line 350
        $inlineScriptMock->expects($this->once())
            ->method('captureEnd')
            ->will($this->returnValue(null));
        // line 351
        $viewMock->expects($this->once())
            ->method('headScript')
            ->will($this->returnValue($headScriptMock));
        // line 351
        $headScriptMock->expects($this->once())
            ->method('appendFile')
            ->with($this->equalTo('/js/Validator.js'));
        
        $this->_fixture->expects($this->once())
            ->method('_buildJsVars');
        
        ob_clean();
        ob_start();
        $result = $this->_fixture->render('__CONTENT__');
        $return = ob_get_contents();
        ob_end_clean();
        
        $expected = <<<SCRIPT
$(function() {
    $("[name='__SUBMIT_NAME__']","#__FORM_ID__").bind(
        'click.JsAutoValidation',
        function(e) {
            e.preventDefault();
            if(
                My.Form.validate(
                    $('#__FORM_ID__'),
                    {}
                )
            ) {
                $("[name='__SUBMIT_NAME__']", "#__FORM_ID__").unbind('click.JsAutoValidation').click();
            }
        }
    );
});
SCRIPT;
        $this->assertEquals($expected, $return);
    }
    
    public function testGedFormId()
    {
        $this->_fixture = $this->getMock(
            'My_Form_Decorator_JsAutoValidation',
            array('_getFormErrorsDecorator', 'getView', 'getElement', '_getElementValidators', '_getElementErrorDecorator', '_getElementFilters'),
            array(),
            '',
            false
        );
        
        $formMock = $this->getMock(
            'Zend_Form',
            array('addAttribs','getView','getDecorator', 'getElements', 'getId'),
            array(),
            '',
            false
        );
        
        $this->_fixture->expects($this->once())
            ->method('getElement')
            ->will($this->returnValue($formMock));
            
        $formMock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue(null));
        
        $formMock->expects($this->once())
            ->method('addAttribs');
           
        $return1 = $this->_fixture->getFormId();
        $return2 = $this->_fixture->getFormId();
        $this->assertEquals($return1, $return2);
    }
    
    public function testBuildJsVarsWithValidatorsDecoratorsAndFilters()
    {
        $this->_fixture = $this->getMock(
            'My_Form_Decorator_JsAutoValidation',
            array('_getFormErrorsDecorator', 'getView', 'getElement', '_getElementValidators', '_getElementErrorDecorator', '_getElementFilters'),
            array(),
            '',
            false
        );
        
        $formMock = $this->getMock(
            'Zend_Form',
            array('getView','getDecorator', 'getElements', 'getId'),
            array(),
            '',
            false
        );
        
        $elementMock = $this->getMock(
            'Zend_Form_Element',
            array(),
            array(),
            '',
            false
        );
        
        $viewMock = $this->getMock(
            'Zend_View',
            array('inlineScript'),
            array(),
            '',
            false
        );
        
        $stdMock = $this->getMock(
            'stdClass',
            array('captureStart', 'captureEnd'),
            array(),
            '',
            false
        );
        
        $stdMock->expects($this->once())
            ->method('captureStart')
            ->will($this->returnValue(null));
        
        $stdMock->expects($this->once())
            ->method('captureEnd')
            ->will($this->returnValue(null));
        
        $viewMock->expects($this->exactly(2))
            ->method('inlineScript')
            ->will($this->returnValue($stdMock));
        
        // line 180
        $this->_fixture->expects($this->any())
            ->method('getElement')
            ->will($this->returnValue($formMock));
        
        // line 181
        $formMock->expects($this->any())
            ->method('getDecorator')
            ->will($this->returnValue(true));
        
        // line 186
        $formMock->expects($this->once())
            ->method('getElements')
            ->will($this->returnValue(array($elementMock)));
        
        // line 187
        $this->_fixture->expects($this->once())
            ->method('_getElementValidators')
            ->with($this->equalTo($elementMock))
            ->will($this->returnValue('__VALIDATORS__'));
        
        // line 190
        $this->_fixture->expects($this->once())
            ->method('_getElementErrorDecorator')
            ->with($this->equalTo($elementMock))
            ->will($this->returnValue('__DECORATORS__'));
        
        $this->_fixture->expects($this->once())
            ->method('_getFormErrorsDecorator')
            ->will($this->returnValue(array()));
        
        // line 193
        $this->_fixture->expects($this->once())
            ->method('_getElementFilters')
            ->with($this->equalTo($elementMock))
            ->will($this->returnValue('__FILTERS__'));
        
        // line 203
        $formMock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('__FORM_ID__'));
        
        // line 214
        $formMock->expects($this->once())
            ->method('getView')
            ->will($this->returnValue($viewMock));
        
        ob_clean();
        ob_start();
        $class = new ReflectionClass ('My_Form_Decorator_JsAutoValidation');
        $method = $class->getMethod ('_buildJsVars');
        $method->setAccessible(true);
        $method->invoke ($this->_fixture);
        $return = ob_get_contents();
        ob_end_clean();
        
        $expected = <<<RETURN
var My = My || {};
My.Forms = My.Forms || {};
My.Forms.__FORM_ID__ = {};
My.Forms.__FORM_ID__.elements = {"":{"validators":"__VALIDATORS__","decorators":"__DECORATORS__","filters":"__FILTERS__"}};
My.Forms.__FORM_ID__.FormErrorDecorator = [];

RETURN;
        $this->assertEquals($expected, $return);
    }
    
    public function testGetElementValidatorsWithZendForm()
    {
        $formMock = $this->getMock(
            'Zend_Form',
            array('getElements'),
            array(),
            '',
            false
        );
        
        $elementMock = $this->getMock(
            'Zend_Form_Element',
            array('getValidators', 'getName'),
            array(),
            '',
            false
        );
        
        $validatorMock = $this->getMock(
            'Zend_Validate_EmailAddress',
            array(),
            array(),
            '',
            false
        );
        
        $this->_fixture = $this->getMock(
            'My_Form_Decorator_JsAutoValidation',
            array('_buildValidationRules'),
            array(),
            '',
            false
        );
        
        $this->_fixture->expects($this->once())
            ->method('_buildValidationRules')
            ->with($this->equalTo($elementMock))
            ->will($this->returnValue('__VALIDATORS__'));
        
        $formMock->expects($this->once())
            ->method('getElements')
            ->will($this->returnValue(array($elementMock)));
        
        $elementMock->expects($this->once())
            ->method('getValidators')
            ->will($this->returnValue(array($validatorMock)));
        
        $class = new ReflectionClass ('My_Form_Decorator_JsAutoValidation');
        $method = $class->getMethod ('_getElementValidators');
        $method->setAccessible(true);
        $return = $method->invoke ($this->_fixture, $formMock);
        
        $this->assertEquals(
            array('__VALIDATORS__'),
            $return
        );
    }
    
    public function testBuildValidatorParametersWithBreakOnFailure()
    {
        $elementMock = $this->getMock(
            'Zend_Form_Element',
            array('getElements', 'getName', 'getValidators'),
            array(),
            '',
            false
        );
        
        $stringLengthValidatorMock = $this->getMock(
            'Zend_Validate_StringLength',
            array('__construct'),
            array(),
            '',
            false
        );
        
        $stringLengthValidatorMock->zfBreakChainOnFailure = 1;
        
        $class = new ReflectionClass ('My_Form_Decorator_JsAutoValidation');
        $method = $class->getMethod ('_buildValidatorParameters');
        $method->setAccessible(true);
        $return = $method->invoke($this->_fixture, $stringLengthValidatorMock);
        
        $expected = array(
            'min' => '',
            'max' => '',
            'encoding' => '',
            'messages' => array(),
            'messageVariables' => array('min','max'),
            'messageTemplates' => array(
                'stringLengthInvalid' => 'Invalid type given. String expected',
                'stringLengthTooShort' => "'%value%' is less than %min% characters long",
                'stringLengthTooLong' => "'%value%' is more than %max% characters long"
            ),
            'errors' => array(),
            'obscureValue' => '',
            'translator' => '',
            'defaultTranslator' => '',
            'messageLength' => -1,
            'breakChainOnFailure' => 1
        );
        
        $this->assertEquals($expected, $return);
    }
}

class JsAutoValidationMock extends My_Form_Decorator_JsAutoValidation
{
    protected $_validationTriggerSelector = '__CUSTOM_ELEMENT__';
}
