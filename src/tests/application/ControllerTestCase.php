<?php
class ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase
{
    public $application;
 
    public function setUp()
    {
        $this->application = new Zend_Application(
            APPLICATION_ENV,
            APPLICATION_PATH . '/configs/application.ini'
        );
 
        $this->bootstrap = array($this, 'appBootstrap');
 
        parent::setUp();
    }
 
    public function tearDown()
    {
//        Zend_Db_Table::getDefaultAdapter()->closeConnection();
        parent::tearDown();
    }
 
    public function appBootstrap()
    {
        $this->application->bootstrap();
    }
 
}