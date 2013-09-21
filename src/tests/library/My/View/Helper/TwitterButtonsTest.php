<?php
class My_View_Helper_TwitterButtonsTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_fixture = $this->getMock(
            'My_View_Helper_TwitterButtonsTest',
            array(),
            array(),
            '',
            false
        );
    }
    
    public function tearDown()
    {
        $this->_fixture = null;
    }
    
    public function testToStringMagicMethod()
    {
//        $this_fixture = $this->getMock(
//            'My_View_Helper_TwitterButtons',
//            array('render'),
//            array(),
//            '',
//            false
//        );
//        
//        $this->_fixture->expects($this->once())
//            ->method('render')
//            ->will($this->returnValue('__CODE__'));
//        
//        ob_clean();
//        ob_start();
//        echo $this->_fixture;
//        $return = ob_get_contents();
//        ob_end_clean();
////        
//        $this->assertEquals('__CODE__', '__CODE__');
    }
}