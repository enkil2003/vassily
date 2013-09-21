<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2012-01-30 01:16:23 -0300 (Mon, 30 Jan 2012) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/Bootstrap.php $
 * @revision - $Revision: 376 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2012-01-30 01:16:23 -0300 (Mon, 30 Jan 2012) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * This constant holds the name for category url param
     * @var string
     */
    const CATEGORY_URL_PARAM_NAME = 'categoria';
    
    /**
     * This constant holds the name for product url param
     * @var string
     */
    const PRODUCT_URL_PARAM_NAME = 'producto';
    
    /**
     * Load the configuration file and sets the configuration available in the registry
     * @return Zend_Config
     */
    protected function _initConfig()
    {
        $config = new Zend_Config($this->getOptions(), true);
        Zend_Registry::set('config', $config);
        return $config;
    }
    
    /**
     * Configures session settings
     * @return void
     */
    protected function _initSession()
    {
        $config = Zend_Registry::get('config');
        // we dont want cookies all over the site
        session_set_cookie_params (
            $config->session->setCookieParams->time,
            $config->session->setCookieParams->path,
            $config->session->setCookieParams->domain
        );
    }
    
    /**
     * Configures email settings.
     * @return mixed Zend_Mail_Transport_Abstract or void
     */
    protected function _initEmail()
    {
        $config = Zend_Registry::get('config');
        //SMTP server configuration
        if ($config->email->transport === 'smtp') {
            $params = array (
                'auth' => $config->email->auth,
                'ssl' => $config->email->ssl,
                'port' => $config->email->port,
                'username' => $config->email->email,
                'password' => $config->email->password
            );
            return Zend_Mail::setDefaultTransport(new Zend_Mail_Transport_Smtp($config->email->smtp, $params));
        }
    }
    
    /**
     * Configures view settings.
     * @return Zend_View
     */
    protected function _initConfigureView()
    {
        $view = $this->getPluginResource('view')->getView();
        $view->headTitle()->append('Vassilymas');
        return $view;
    }
    
    /**
     * Configures social view helpers like facebook, twitter, etc.
     * @return void
     */
    protected function _initSocialSetup()
    {
        $config = Zend_Registry::get('config');
        $view = $this->getPluginResource('view')->getView();
        $view->twitterButtons()->setTwitterAccount(
            $config->twitter->account
        );
        $view->facebookButtons()
            ->setAppId($config->facebook->appId)
            ->setHref($config->facebook->href)
            ->setSend($config->facebook->send)
            ->setLayout($config->facebook->layout)
            ->setWidth($config->facebook->width)
            ->setShowFaces($config->facebook->faces)
            ->setFont($config->facebook->font);
        
        $view->googlePlusButtons()
            ->setSize(My_View_Helper_GooglePlusButtons::GOOGLE_PLUS_SIZE_MEDIUM);
    }
    
    /**
     * Configures php on the fly compression.
     * @return void
     */
    protected function _initCompressResponse()
    {
//        $front = Zend_Controller_Front::getInstance();
//        $front->registerPlugin(new My_Controller_Plugin_CompressResponse());
    }
    
    /**
     * Configures php on the fly compression.
     * @return void
     */
    protected function _initTranslation()
    {
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new My_Controller_Plugin_LanguageSelector());
    }
    
    /**
     * Configures Doctrine settings.
     * @return Doctrine_Connection
     */
    protected function _initDoctrine()
    {
        //Load the autoloader
        Zend_Loader_Autoloader::getInstance()->registerNamespace('Doctrine')->
                pushAutoloader(array('Doctrine', 'autoload'));
        $manager = Doctrine_Manager::getInstance();
        foreach ($this->_options['doctrine']['attr'] as $key => $val) {
            $manager->setAttribute(constant("Doctrine::$key"), $val);
        }
        $conn = Doctrine_Manager::connection($this->_options['doctrine']['dsn'], 'doctrine');
        $conn->setCharset('utf8');
        
        Doctrine::loadModels($this->_options["doctrine"]["models_path"]);
        
        return $conn;
    }
    
    /*
    protected function _initTranslate()
    {
    // http://www.codeforest.net/multilanguage-support-in-zend-framework
        $translate = new Zend_Translate(
            'gettext',
            APPLICATION_PATH . "/langs/",
            null,
            array(
                'scan' => Zend_Translate::LOCALE_DIRECTORY
            )
        );
        $registry = Zend_Registry::getInstance();
        $registry->set('Zend_Translate', $translate);
        $translate->setLocale('en');
    }
    */
    // @TODO investigar mas como usar estos logs a mi favor
    /*
    protected function _initFirephpLog()
    {
        $writer = new Zend_Log_Writer_Firebug();
        $logger = new Zend_Log();
        $logger->addWriter($writer);
        Zend_Registry::set('firephpLogger', $logger);
        return $logger;
    }
    
    */
    
    /**
     * Configures PHP error logger settings.
     * @return Zend_Log
     */
    protected function _initPhpErrorLogger()
    {
        $streamWriter = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../logs/php/error.log');
        $logger = new Zend_Log($streamWriter);
        $filter = new Zend_Log_Filter_Priority(Zend_Log::WARN);
        $logger->addFilter($filter);
        $logger->registerErrorHandler();
        return $logger;
    }
    
    /**
     * Configures Zend Router settings.
     * @return Zend_Controller_Router_Interface
     */
    protected function _initRouter()
    {
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();
        $routes = array(
            // Index Controller
            'contacto' => new Zend_Controller_Router_Route(
                'contacto',
                array(
                    'controller' => 'index',
                    'action' => 'contact'
                )
            ),
            'contactUs' => new Zend_Controller_Router_Route(
                'contact-us',
                array(
                    'controller' => 'index',
                    'action' => 'contact'
                )
            ),
            
            'graciasPorSuContacto' => new Zend_Controller_Router_Route(
                'gracias-por-su-contacto',
                array(
                    'controller' => 'index',
                    'action' => 'thanks-for-your-contact'
                )
            ),
            'thanksForYourContacto' => new Zend_Controller_Router_Route(
                'thanks-for-your-contact',
                array(
                    'controller' => 'index',
                    'action' => 'thanks-for-your-contact'
                )
            ),
            
            'miCarrito' => new Zend_Controller_Router_Route(
                'mi-carrito',
                array(
                    'controller' => 'cart',
                    'action' => 'show-cart'
                )
            ),
            'myCart' => new Zend_Controller_Router_Route(
                'my-cart',
                array(
                    'controller' => 'cart',
                    'action' => 'show-cart'
                )
            ),
            
            'pedidoRealizado' => new Zend_Controller_Router_Route(
                'pedido-realizado',
                array(
                    'controller' => 'cart',
                    'action' => 'checkout-success'
                )
            ),
            'checkoutSuccess' => new Zend_Controller_Router_Route(
                'checkout-success',
                array(
                    'controller' => 'cart',
                    'action' => 'checkout-success'
                )
            ),
            
            'dineromail' => new Zend_Controller_Router_Route(
                'dineromail',
                array(
                    'controller' => 'cart',
                    'action' => 'dineromail'
                )
            ),
            
            'newsletter' => new Zend_Controller_Router_Route(
                'newsletter',
                array(
                    'controller' => 'index',
                    'action' => 'newsletter'
                )
            ),
            // User Controller
            'registrate' => new Zend_Controller_Router_Route(
                'registrate',
                array(
                    'controller' => 'user',
                    'action' => 'register'
                )
            ),
            'register' => new Zend_Controller_Router_Route(
                'register',
                array(
                    'controller' => 'user',
                    'action' => 'register'
                )
            ),
            
            'login' => new Zend_Controller_Router_Route(
                'login',
                array(
                    'controller' => 'user',
                    'action' => 'login'
                )
            ),
            'logout' => new Zend_Controller_Router_Route(
                'logout',
                array(
                    'controller' => 'user',
                    'action' => 'logout'
                )
            ),
            
            'misDatos' => new Zend_Controller_Router_Route(
                'mis-datos',
                array(
                    'controller' => 'user',
                    'action' => 'personal-information'
                )
            ),
            'myPersonalInformation' => new Zend_Controller_Router_Route(
                'my-personal-information',
                array(
                    'controller' => 'user',
                    'action' => 'personal-information'
                )
            ),
            
            'miVassilymas' => new Zend_Controller_Router_Route(
                'mi-vassilymas',
                array(
                    'controller' => 'user',
                    'action' => 'control-panel'
                )
            ),
            'myVassilymas' => new Zend_Controller_Router_Route(
                'my-vassilymas',
                array(
                    'controller' => 'user',
                    'action' => 'control-panel'
                )
            ),
            'confirmation' => new Zend_Controller_Router_Route(
                'confirmacion',
                array(
                    'controller' => 'user',
                    'action' => 'confirmation'
                )
            ),
            
            'resetPassword' => new Zend_Controller_Router_Route(
                'olvide-mi-contraseña',
                array(
                    'controller' => 'user',
                    'action' => 'password-reset'
                )
            ),
            'passwordReset' => new Zend_Controller_Router_Route(
                'foget-my-password',
                array(
                    'controller' => 'user',
                    'action' => 'password-reset'
                )
            ),
            
            'cambiarContraseñas' => new Zend_Controller_Router_Route(
                'cambiar-contraseña',
                array(
                    'controller' => 'user',
                    'action' => 'reset-password-confirmation'
                )
            ),
            'passwordResetConfirmation' => new Zend_Controller_Router_Route(
                'change-credentials',
                array(
                    'controller' => 'user',
                    'action' => 'reset-password-confirmation'
                )
            ),
            
            'datosActualizadosConExito' => new Zend_Controller_Router_Route(
                'updated-personal-information',
                array(
                    'controller' => 'user',
                    'action' => 'update-personal-information-success'
                )
            ),
            'updatePersonalInformationSuccess' => new Zend_Controller_Router_Route(
                'datos-actualizados',
                array(
                    'controller' => 'user',
                    'action' => 'update-personal-information-success'
                )
            ),
            
            'registrationComplete' => new Zend_Controller_Router_Route(
                'registracion-exitosa',
                array(
                    'controller' => 'user',
                    'action' => 'registration-complete'
                )
            ),
            'registrationCompleteEnglish' => new Zend_Controller_Router_Route(
                'registration-success',
                array(
                    'controller' => 'user',
                    'action' => 'registration-complete'
                )
            ),
            'activateUser' => new Zend_Controller_Router_Route(
                'activate-user',
                array(
                    'controller' => 'user',
                    'action' => 'activate-user'
                )
            ),
            'activarUsuario' => new Zend_Controller_Router_Route(
                'activar-usuario',
                array(
                    'controller' => 'user',
                    'action' => 'activate-user'
                )
            ),
            
            // Catalog Controller
            'categoria' => new Zend_Controller_Router_Route(
                'showroom/:activeCategory',
                array(
                    'controller' => 'catalog',
                    'action' => 'index'
                )
            ),
            'subcategoria' => new Zend_Controller_Router_Route(
                'showroom/:activeCategory/:activeSubcategoryId/:activeSubcategory',
                array(
                    'controller' => 'catalog',
                    'action' => 'index'
                )
            ),
            // Product Controller
            'producto' => new Zend_Controller_Router_Route(
                'showroom/:activeCategory/:activeSubcategoryId/:activeSubcategoryName/:productId/:productName',
                array(
                    'controller' => 'product',
                    'action' => 'index'
                )
            ),
            // Error Controller
            'error' => new Zend_Controller_Router_Route(
                'error',
                array(
                    'controller' => 'error',
                    'action' => 'template'
                )
            ),
        );
        $router->addRoutes($routes);
        return $router;
    }
    
    // @TODO buscar alguna manera facil de cargar analitics y poder intercambiarlos entre sitios
    
    /**
     * Configures Google Analytics settings.
     * @return void
     */
    /*
    protected function _initAnalytics()
    {
        $view = $this->getPluginResource('view')->getView();
        $googleAnalytics = $view->googleAnalytics(
            Zend_Registry::get('config')->google->analytics->trackId
        );
    }
    */
}
