<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/controllers/ErrorController.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

require_once 'VassilymasController.php';
class ErrorController extends VassilymasController
{
    /**
     * Default view for error action.
     * @return void
     */
    public function errorAction()
    {
        // clear placeholders
        $this->_clearLayoutPlaceHolders();
        $errors = $this->_getParam('error_handler');
        if (!$errors || !$errors instanceof ArrayObject) {
            $this->view->message = $this->view->translate('Se ha generado un error');
            return;
        }
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $priority = Zend_Log::NOTICE;
                $this->view->message = $this->view->translate('Página no encontrada');
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $priority = Zend_Log::CRIT;
                $this->view->message = $this->view->translate('Error en la aplicación');
                break;
        }
        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->log($this->view->message."\n".$errors->exception."\n", $priority);
            $parameters = print_r($errors->request->getParams(), true);
            $log->log('Request Parameters'."\n".$parameters, $priority);
            $log->log("\n\n-------------------------------------------------------------------------------------\n", $priority);
        }
        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }
        $this->view->request   = $errors->request;
    }
    
    /**
     * Returns the registered logger to be used for errors.
     * @throws Zend_Exception when no logger resource is found in bootstrap.
     * @return mixed false if not found Zend_Log if found
     */
    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
            //throw new Zend_Exception('No logger was found for the errorController/errorAction');
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }
}

