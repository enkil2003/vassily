<?php 
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2012-02-21 02:05:29 -0300 (Tue, 21 Feb 2012) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/controllers/UserController.php $
 * @revision - $Revision: 425 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2012-02-21 02:05:29 -0300 (Tue, 21 Feb 2012) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

require_once 'VassilymasController.php';
class UserController extends VassilymasController
{
    /**
     * Default view for control panel action.
     * @return void
     */
    public function controlPanelAction()
    {
        $this->view->placeholder('social')->append($this->view->partial('social.phtml'));
        $this->_setResgitrationAndLoginMenuSteps($this->view->translate('Mi Vassilymas'));
    }
    
    /**
     * Default view for logout action.
     * @return void
     */
    public function logoutAction()
    {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Auth::getInstance()->clearIdentity();
            $order = new Zend_Session_Namespace('order');
            $order->unsetAll();
        }
        $this->_redirect('/');
    }
    
    /**
     * Shows the default informative registration success view.
     * @return void
     */
    public function successAction()
    {
        
    }
    
    /**
     * Default view for confirmation action.
     * @return void
     */
    public function confirmationAction()
    {
        $this->_setResgitrationAndLoginMenuSteps($this->view->translate('Registrate'));
        $this->_helper->loadDefaultCss();
        $this->_helper->loadDefaultJs();
        $this->view->headMeta()->appendName('refresh', '1;url=/login');
    }
    
    /**
     * This action is in change of handling mailchimp post request
     * @return void
     */
    public function mailchimpAction()
    {
        $request = $this->getRequest();
        $data = $request->getPost('data');
        User::activateUser($data['merges']['CONFIRM']);
        die;
    }
    
    /**
     * This action is in change of handling mailchimp post request
     * @return void
     */
    public function activateUserAction()
    {
        $request = $this->getRequest();
        $code = $request->getParam('code');
        User::activateUser($code);
        $this->_forward('confirmation');
    }
    
    /**
     * Handles login form and login process
     * @return void
     */
    public function loginAction()
    {
        // avoid relogin
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $this->_helper->redirector('user-already-logged-in');
        }
        
        $request = $this->getRequest();
        // configure the form
        $form = new Form_Login();
        
        // receive the form
        if ($request->isPost() && $form->isValid($request->getPost())) {
            $adapter = new My_Auth_Adapter($form->getValue('usernameOrEmail'), $form->getValue('password'));
            /*
             * @FIX: tuve que poner esta linea abajo, sino no autenticaba el servidor, pero localmente no lo necesitaba
             * llegue por casualidad a esta linea mirando como autentica el zend_auth::authenticate
             */
            $result = $adapter->authenticate();
            $auth->authenticate($adapter);
            if ($auth->hasIdentity()) {
                // nos fijamos si tenemos una orden de compra temporal y la asociamos al usuario
                $cart = Vassilymas_Service_Locator::createCartObject();
                if ($cart->hasOrder()) {
                    $user = $auth->getIdentity();
                    $cart->bindUserToOrder($user['id']);
                }
                
                // nos fijamos si tengo algun request anterior al logueo
                $aclMemory = new Zend_Session_Namespace(My_Plugins_AclPlugin::ACL_SESSION_NAME);
                if ($aclMemory->request) {
                    // si estamos recordando algun request anterior lo visitamos
                    // @TODO: que pasa si hay modulo de por medio?
                    $this->_helper->_redirector->gotoSimpleAndExit(
                        $aclMemory->request['action'],
                        $aclMemory->request['controller']
                    );
                }
                $this->_helper->_redirector->gotoSimpleAndExit(
                    $this->view->translate('mi-vassilymas'),
                    ''
                );
            } else {
                $form->markAsError();
                $this->view->errors = array_shift($result->getMessages());
            }
        } else {
            $this->view->error = $this->view->translate('El usuario/email y password no coinciden con ningun usuario registrado');
        }
        // configure view
        $this->view->placeholder('social')->append($this->view->partial('social.phtml'));
        $this->view->form = $form;
        
        $this->_setResgitrationAndLoginMenuSteps($this->view->translate('Registrate'));
        $this->_clearLayoutPlaceHolders(array('social'));
        $this->_helper->loadDefaultCss();
        $this->_helper->loadDefaultJs();
    }
    
    public function ajaxLoginAction()
    {
        $request = $this->getRequest();
        $auth = Zend_Auth::getInstance();
        $form = new Form_Login();
        $form->isValid($request->getPost());
        $hasIdentity = false;
        $response = array();
        if ($request->isXmlHttpRequest()) {
            $adapter = new My_Auth_Adapter($form->getValue('usernameOrEmail'), $form->getValue('password'));
            /*
             * @FIX: tuve que poner esta linea abajo, sino no autenticaba el servidor, pero localmente no lo necesitaba
             * llegue por casualidad a esta linea mirando como autentica el zend_auth::authenticate
             */
            $result = $adapter->authenticate();
            $auth->authenticate($adapter);
            $hasIdentity = $auth->hasIdentity();
            if ($hasIdentity) {
                // nos fijamos si tenemos una orden de compra temporal y la asociamos al usuario
                $cart = Vassilymas_Service_Locator::createCartObject();
                if ($cart->hasOrder()) {
                    $user = $auth->getIdentity();
                    $cart->bindUserToOrder($user['id']);
                }
                $response['userData'] = User::getUserData($user['id']);
            } else {
                $response['error']['userFriendlyMessage'] = $this->view->translate('Credenciales incorrectas');
            }
        }
        $response['hasIdentity'] = $hasIdentity;
        header("content-type: application/json");
        echo Zend_Json::encode($response);
        die;
    }
    
    /**
     * Default view for already logged users
     * @return void
     */
    public function userAlreadyLoggedInAction()
    {
    }
    
    /**
     * Temporary step for switching between users login, a second transparent loggin
     * @return void
     */
    public function logoutBeforeLoginAction()
    {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Auth::getInstance()->clearIdentity();
            $order = new Zend_Session_Namespace('order');
            $order->unsetAll();
        }
        $this->_redirect('/'.$this->view->translate('login'));
    }
    
    /**
     * Default view for register action.
     * @return void
     */
    public function registerAction()
    {
        $request = $this->getRequest();
        $form = new Form_Register();
        if ($request->isPost() && $form->isValid($request->getPost())) {
            try {
                $confirmationCode = uniqid();
                User::addUser(
                    array(
                        'username' => $form->getValue('username'),
                        'email' => $form->getValue('email'),
                        'password' => $form->getValue('password'),
                        'confirmation_code' => $confirmationCode,
                        'active' => 0
                    ),
                    array(
                        'name' => $form->getValue('name'),
                        'lastname' => $form->getValue('lastname'),
                        'newsletter' => $form->getValue('newsletter'),
                        'address' => $form->getValue('address'),
                        'zip' => $form->getValue('zip'),
                        'city' => $form->getValue('city'),
                        'province' => $form->getValue('province'),
                        'phone' => $form->getValue('phone'),
                        'celphone' => $form->getValue('celphone'),
                        'aditionalData' => $form->getValue('aditionalData')
                    )
                );
                // does the user want our newsletter?
                if ($form->getValue('newsletter')) {
                    $mchimp = Vassilymas_Service_Locator::createMailchimpObject();
                    $added = $mchimp->add($form->getValue('name'), $form->getValue('email'), $confirmationCode);
                } else {
                    $mail = Vassilymas_Service_Locator::createEmailObject();
                    try {
                        $mail->send(
                            Zend_Registry::get('config')->email->noreply,
                            'Vassilymas',
                            $form->getValue('email'),
                            '',
                            $this->view->translate('Bienvenido a Vassilymas'),
                            'welcome',
                            array(
                                'fullname' => $form->getValue('name') . ' ' . $form->getValue('lastname'),
                                'url' => "{$_SERVER['HTTP_HOST']}/activate-user?code={$confirmationCode}"
                            )
                        );
                    } catch (Exception $e) {
                        echo $e->getMessage();
                        die;
                    } 
                }
            } catch (Exception $e) {
                echo $e->getMessage();
                die;
            }
            $this->_helper->_redirector->gotoSimpleAndExit(
                $this->view->translate('registracion-exitosa'),
                ''
            );
            return;
        }
        $this->_clearLayoutPlaceHolders(array('social'));
        $this->_helper->loadDefaultCss();
        $this->_setResgitrationAndLoginMenuSteps($this->view->translate('Registrate'));
        $this->view->form = $form;
    }
    
    /**
     * Default view for registration complete action.
     * @return void
     */
    public function registrationCompleteAction()
    {
        $this->_clearLayoutPlaceHolders(array('social'));
        $this->_helper->loadDefaultCss();
        $this->_setResgitrationAndLoginMenuSteps($this->view->translate('Registrate'));
    }
    
    /**
     * Default view for personal information action.
     * @return void
     */
    public function personalInformationAction()
    {
        $request = $this->getRequest();
        $form = new Form_RegisterUpdate();
        $user = Zend_Auth::getInstance()->getIdentity();
        if ($request->isPost() && $form->isValid($request->getPost())) {
            $form->getValue('changePassword');
            if (
                $form->getValue('changePassword') != '' &&
                ($form->getValue('changePassword') == $form->getValue('confirmPassword'))
            ) {
                $password = $form->getValue('changePassword');
            } else {
                $password = $user['password'];
            }
            try {
                User::updateUser(
                    array(
                        'id' => $user['id'], // no queremos usar el de form por seguridad!!
                        'email' => $form->getValue('email'),
                        'password' => $password
                    ),
                    array(
                        'name' => $form->getValue('name'),
                        'lastname' => $form->getValue('lastname'),
                        'newsletter' => $form->getValue('newsletter'),
                        'address' => $form->getValue('address'),
                        'zip' => $form->getValue('zip'),
                        'city' => $form->getValue('city'),
                        'province' => $form->getValue('province'),
                        'phone' => $form->getValue('phone'),
                        'celphone' => $form->getValue('celphone'),
                        'aditionalData' => $form->getValue('aditionalData')
                    )
                );
                // does the user want to be removed from the newsletter?
                if (!$form->getValue('newsletter')) {
                    $mchimp = Vassilymas_Service_Locator::createMailchimpObject();
                    $mchimp->remove($form->getValue('email'));
                }
            } catch (Exception $e) {
                echo $e->getMessage();
                die;
            }
            $this->_helper->_redirector->gotoSimpleAndExit(
                $this->view->translate('datos-actualizados'),
                ''
            );
            return;
        }
        $form->populate(User::getUserData($user['id']));
        $this->view->form = $form;
        
        $this->_helper->loadDefaultCss();
        $this->_clearLayoutPlaceHolders(array('social'));
        $this->_setResgitrationAndLoginMenuSteps($this->view->translate('Mis Datos'));
    }
    
    /**
     * Default view for update personal information action.
     * @return void
     */
    public function updatePersonalInformationSuccessAction()
    {
        $this->_clearLayoutPlaceHolders(array('social'));
        $this->_setResgitrationAndLoginMenuSteps($this->view->translate('Mis Datos'));
        $this->_helper->loadDefaultCss();
        $user = Zend_Auth::getInstance()->getIdentity();
        $userData = User::getUserData($user['id']);
        $mail = Vassilymas_Service_Locator::createEmailObject();
        try {
            $mail->send(
                Zend_Registry::get('config')->email->noreply,
                'Vassilymas',
                $userData['email'],
                $userData['name'] . ' ' . $userData['lastname'],
                $this->view->translate('Sus datos han sido actualizados'),
                'user/personal-information-has-been-updated',
                array(
                    'fullname' => $userData['name'] . ' ' . $userData['lastname']
                )
            );
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }
    
    /**
     * Default view password reset action.
     * @return void
     */
    public function passwordResetAction()
    {
        $request = $this->getRequest();
        $form = new Form_PasswordReset();
        $this->_helper->loadDefaultCss();
        if ($request->isPost() && $form->isValid($request->getPost())) {
            // envio un mail al usuario con un vinculo y un hash unico
            $config = Zend_Registry::get('config')->email->noreply;
            $resetCode = uniqid('reset');
            $mail = Vassilymas_Service_Locator::createEmailObject();
            try {
                User::setResetCode($form->getValue('email'), $resetCode);
                $fullname = User::getUserFullNameByEmail($form->getValue('email'));
                
                $mail->send(
                    Zend_Registry::get('config')->email->noreply,
                    'Vassilymas',
                    $form->getValue('email'),
                    '',
                    $this->view->translate('Resetear contraseña'),
                    'password-reset',
                    array(
                        'fullname' => $fullname,
                        'url' => "http://{$_SERVER['HTTP_HOST']}/" . $this->view->translate('cambiar-contraseña') .
                            "?code={$resetCode}"
                    )
                );
                /* @TODO cambiar esto a redirect para prevenir refresh del form */
                $this->render('password-reset-mail-sent');
            } catch (Exception $e) {
                echo $e->getMessage();
                die;
            } 
            return;
        }
        $form->addDefaultSubmit($this->view->translate('Recuperar contraseña'));
        $this->view->form = $form;
    }
    
    /**
     * Default view for reset password confirmation action.
     * @return void
     */
    public function resetPasswordConfirmationAction()
    {
        $request = $this->getRequest();
        
        $user = User::getUserByResetCode($request->getParam('code'));
        $fullname = Userdata::getFullNameByUserId($user['id']);
        $password = User::confirmResetCode($request->getParam('code'));
        $mail = Vassilymas_Service_Locator::createEmailObject();
        $mail->send(
            Zend_Registry::get('config')->email->noreply,
            'Vassilymas',
            $user['email'],
            '',
            $this->view->translate('Su clave ha cambiado'),
            'reset-password-confirmation',
            array(
                'fullname' => $fullname,
                'password' => $password,
                'username' => $user['username']
            )
        );
        
        $this->_helper->loadDefaultCss();
        $this->view->password = $password;
    }
    
    /**
     * This methods is responsable for populating the menustep view helper.
     * @param string $selected optional, name of the selected step item
     * @return void
     */
    private function _setResgitrationAndLoginMenuSteps($selected = null)
    {
        $hasIdentity = Zend_Auth::getInstance()->hasIdentity();
        $this->view->menuSteps()->setSteps(
            array(
                array(
                    'label' => $this->view->translate('Mi Vassilymas'),
                    'href' => '/'.$this->view->translate('mi-vassilymas'),
                ),
                array(
                    'label' => $this->view->translate('Mi Carrito'),
                    'href' => '/'.$this->view->translate('mi-carrito'),
                ),
                array(
                    'label' => $hasIdentity? $this->view->translate('Mis Datos'):$this->view->translate('Registrate'),
                    'href' => $hasIdentity? '/'.$this->view->translate('mis-datos'):'/'.$this->view->translate('registrate'),
                )
            )
        )->setSelectedLabel($selected);
    }
}
