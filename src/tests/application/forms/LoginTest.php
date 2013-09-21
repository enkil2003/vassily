<?php
/**
 * PEP Web Application
 *
 * (c) Disney.  All rights reserved.
 *
 * Perforce Metadata:
 * - $Author: ialessio $
 * - $Change: 898076 $
 * - $DateTime: 2011/06/24 13:24:43 $
 *
 * @package Default_Form
 * @copyright (c) Disney.  All rights reserved.
 * @version $Revision: #2 $
 */

/**
 * Simple Test for the Sign In Forgot Password Step Two Form
 */
class Form_LoginTest extends PHPUnit_Framework_TestCase
{
    public function testCreationOfForm()
    {
        require_once APPLICATION_PATH . '/forms/Login.php';
        $form = new Form_Login();
        $this->assertEquals('loginFormForm', $form->getId());
    }   

//    public function testInit()
//    {        
//        $form = $this->getMock(
//            'Default_Form_SignInForgotPasswordStepTwo',
//            array('setConfig'),
//            array(), 
//            'Default_Form_SignInForgotPasswordStepTwo_0', 
//            false                
//        );
//
//        $form->expects($this->once())
//             ->method('setConfig');
//
//        $form->init();
//    }
//    
//    public function testSetSecurityQuestions()
//    {
//        $form = $this->getMock(
//            'Default_Form_SignInForgotPasswordStepTwo', 
//            array('getElement'), 
//            array(), 
//            'Default_Form_SignInForgotPasswordStepTwo_00', 
//            false
//        );
//        
//        $element = $this->getMock(
//            'Zend_Form_Element', 
//            array('setDescription'),
//            array(),
//            'Zend_Form_Element_SecurityQuestion_00',
//            false
//        );        
//        
//        $form->expects($this->once())
//             ->method('getElement')
//             ->will($this->returnValue($element));
//
//        $element->expects($this->once())
//                ->method('setDescription');
//
//        $sq = new Default_Model_SecurityQuestion('', '');
//        $form->setSecurityQuestion($sq);
//    }
//    
//    public function testSetInvalidAnswer()
//    {
//        $form = $this->getMock(
//            'Default_Form_SignInForgotPasswordStepTwo', 
//            array('getElement'), 
//            array(), 
//            'Default_Form_SignInForgotPasswordStepTwo_000', 
//            false
//        );
//        
//        $element = $this->getMock(
//            'Zend_Form_Element', 
//            array('addError'),
//            array(),
//            'Zend_Form_Element_SecurityQuestion_000',
//            false
//        );        
//        
//        $form->expects($this->once())
//             ->method('getElement')
//             ->with(Default_Form_SignInForgotPasswordStepTwo::FORM_ELEMENT_SECURITY_QUESTION)
//             ->will($this->returnValue($element));
//
//        $element->expects($this->once())
//                ->method('addError')
//                ->with('signIn.forgotPassword.stepTwo.invalidAnswer');
//
//        $form->setInvalidAnswer();
//    }
//    
//    public function testSetQuestionsLocked()
//    {
//        $form = $this->getMock(
//            'Default_Form_SignInForgotPasswordStepTwo', 
//            array('addError', 'removeElement'), 
//            array(), 
//            'Default_Form_SignInForgotPasswordStepTwo_0000', 
//            false
//        );
//        
//        $form->expects($this->once())
//             ->method('addError')
//             ->with('signIn.forgotPassword.stepTwo.maximumAttemptsExceeded');
//        
//        $form->expects($this->exactly(2))
//             ->method('removeElement');
//        
//        $form->setQuestionsLocked();
//    }
//    
//    public function testSetTryNextQuestion()
//    {
//        $form = $this->getMock(
//            'Default_Form_SignInForgotPasswordStepTwo', 
//            array('addError', 'setSecurityQuestion'), 
//            array(), 
//            'Default_Form_SignInForgotPasswordStepTwo_00000', 
//            false
//        );
//        
//        $sq = new Default_Model_SecurityQuestion('', '');
//        
//        $form->expects($this->once())
//             ->method('addError')
//             ->with('signIn.forgotPassword.stepTwo.tryNextQuestion')
//             ->will($this->returnValue($form));
//        
//        $form->expects($this->once())
//             ->method('setSecurityQuestion')
//             ->with($sq);
//        
//        $form->setTryNextQuestion($sq);
//    }    
}
