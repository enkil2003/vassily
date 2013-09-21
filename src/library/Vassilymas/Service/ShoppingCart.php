<?php
/**
 * Vassilymas
 *
 * LICENSE http://www.gnu.org/licenses/gpl.txt
 *
 * This source file is subject to the GPL license that is bundled
 * with this package in the file LICENSE.txt located at the docs folder.
 *
 * @copyright  Copyright (c) 2011 and future, Ricardo Buquet
 * @license    http://www.gnu.org/licenses/gpl.txt     GPL  
 */

/**
 * This class is a facade for the most common operations with the ShoppingCart
 * @author Ricardo Buquet
 */
class Vassilymas_Service_ShoppingCart
{
    /**
     * Service_ShoppingCart instance
     * @var Service_ShoppingCart
     */
    private static $_instance = null;
    
    /**
     * ShoppingCart adapter object.
     * @var My_ShoppingCart_Adapter_Adapter
     */
    private $_shoppingCartAdapter = null;
    
    /**
     * Order object
     * @var My_ShoppingCart_Order
     */
    private $_order = null;
    
    /**
     * Private constructor method for shoppingcart
     * @param My_ShoppingCart_Adapter_Adapter $adapter
     */
    private function __construct()
    {
        $sessionOrder = new Zend_Session_Namespace('order');
        if (empty($sessionOrder->order)) {
            $this->_order = My_ShoppingCart_Order::getInstance();
            $sessionOrder->order = serialize($this->_order);
        } else {
            $this->_order = unserialize($sessionOrder->order);
        }
    }
    
    /**
     * Binds and user id to an order that has null in user field
     * @param int $userId
     * @return void
     */
    public function bindUserToOrder($userId)
    {
        $this->_order->bindUserToOrder($userId);
    }
    
    /**
     * Returns a Shopping Cart Instance
     * @return Service_ShoppingCart
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    /**
     * Checks if we have an order in session
     * @return boolean
     */
    public function hasOrder()
    {
        $order = new Zend_Session_Namespace('order');
        return !empty($order->order);
    }
    
    /**
     * Returns adapter's order number
     * @return String orderNumber
     */
    public function getOrderNumber()
    {
        $this->_order->getOrderNumber();
    }
    
    /**
     * Adds a new item to the order, or increment the quantity on existent items.
     * @param int $productId product's id
     * @param int $quantity Optional quantity, default 1
     * @return void
     */
    public function addItemToOrder($productId, $quantity = 1)
    {
        $this->_order->addItemToOrder($productId, $quantity);
    }
    
    /**
     * Removes items from order.
     * @param int $productId
     * @return void
     */
    public function removeItemFromOrder($productId) {
        $this->_order->removeItemFromOrder($productId);
    }
    
    /**
     * Updates items from order.
     * @param int $productId
     * @param int $quantity
     * @return void
     */
    public function setItemQuantity($productId, $quantity) {
        $this->_order->setItemQuantity($productId, $quantity);
    }
    
    /**
     * Returns all the details in the orden. This means, products, quantity and price at the time
     * being added to the card.
     * @return array Order details
     */
    public function getOrderDetails()
    {
        return $this->_order->getOrderDetails();
    }
    
    /**
     * Returns the orderdetail object.
     * @return My_ShoppingCart_Order
     */
    public function getOrder()
    {
        return $this->_order;
    }
    
    /**
     * Security method to prevent clonning the singleton
     * @throws Exception
     */
    public function __clone()
    {
        throw new Exception("You cannot clone a singleton instance");
    }
    
    public function _sendUserCheckoutEmail($checkoutData, $orderDetails)
    {
        $subject = 'Checkout de usuario no registrado';
        $fromEmail = 'info@vassilymas.com.ar';
        $fromName = 'Vassilymas';
        
        $auth = Zend_Auth::getInstance();
        
        if ($auth->hasIdentity()) {
            $subject = 'Checkout';
            $user = $auth->getIdentity();
            $userData = User::getUserData($user['id']);
            
            $toEmail = $userData['email'];
            $toName = "{$userData['name']} {$userData['lastname']}";
        } else {
            $toName = "{$checkoutData['name']} {$checkoutData['lastname']}";
            $toEmail = $checkoutData['email'];
        }
        
        Vassilymas_Service_Locator::createEmailObject()->send(
            $fromEmail,
            $fromName,
            $toEmail,
            $toName,
            $subject,
            'cart/checkout-details',
            array('orderDetails' => $orderDetails)
        );
    }
    
    public function _sendAdministratorCheckoutEmail($checkoutData, $orderDetails)
    {
        Vassilymas_Service_Locator::createEmailObject()->send(
            'ventas@vassilymas.com.ar',
            'Ventas Vassilymas',
            'enkil@fibertel.com.ar',
            'Ricardo Buquet',
            'Realizaron una compra',
            'cart/checkout-notification',
            array('orderDetails' => $orderDetails)
        );
    }
    
    public function clearCart()
    {
//        $this->_order->clear();
    }
    
    /**
     * Proced to checkout
     * @param array $checkoutData
     */
    public function checkout($checkoutData)
    {
        // tomo el carrito
        $orderDetails = $this->getOrderDetails();
        try {
            $this->_sendUserCheckoutEmail($checkoutData, $orderDetails);
            $this->_sendAdministratorCheckoutEmail($checkoutData, $orderDetails);
        } catch (Exception $e) {
            // @TODO ricardo: Capturar correctamente este mensaje
            user_error("no se pudo mandar el mail, esto es un mensaje de error, shoppingCart linea 223", E_USER_ERROR);
        }
        // marco la orden como completada
        $this->clearCart();
        
    }
}