<?php
class My_View_Helper_FacebookButtonsTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_helper = new My_View_Helper_FacebookButtons();
    }
    
    public function tearDown()
    {
        $this->_helper = null;
    }
    
    /**
     * @expectedException Zend_Exception
     */
    public function testExceptionWithWrongMagicMethodName()
    {
        $this->_helper->seMethod();
    }
    
    /**
     * @expectedException Zend_Exception
     */
    public function testExceptionWithUndefinedProperty()
    {
        $this->_helper->setUndefinedProperty();
    }
    
    public function testValidAttribute()
    {
        $appId = '__APPID__';
        $this->_helper->setAppId('__APPID__');
        $this->assertEquals('__APPID__', $this->_helper->getAppId('__APPID__'));
        
        $this->_helper->setShowFaces(true);
    }
    
    /**
     * @dataProvider DataProvidertestToString
     */
    public function testToString($value)
    {
        $this->_helper->setShowFaces($value);
        $helperOutput = $this->_helper->toString();
        if ($value === true) {
            $value = 'true';
        } else if ($value === false) {
            $value = 'false';
        }
        $this->assertEquals("<div class=\"fb-like\" data-show-faces=\"$value\" ></div>", $helperOutput);
    }
    
    public function DataProvidertestToString()
    {
        return array(array(true), array(false));
    }
    
    function testJavascriptSDK()
    {
        $appId = '__APPID__';
        $this->_helper->setAppId($appId);
        
        $result = <<<RESULT
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId={$appId}";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
RESULT;
        
        $this->assertEquals($result, $this->_helper->javascriptSDK());
    }
    
    public function testFacebookButtons()
    {
        $fb = $this->_helper->facebookButtons();
        
        $this->assertEquals($fb, $this->_helper);
    }
    
    public function testtoStringMagicMethod()
    {
        ob_start();
        echo $this->_helper->facebookButtons();
        $buffer = ob_get_contents();
        ob_clean();
        
        $this->assertEquals($buffer, $this->_helper->toString());
    }
}