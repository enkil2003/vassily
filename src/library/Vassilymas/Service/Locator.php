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

class Vassilymas_Service_Locator
{
    private static $_cart = null;
    /**
     * Creates a new Shopping cart service
     * @return Vassilymas_Service_ShoppingCart
     */
    public static function createCartObject()
    {
        require_once 'ShoppingCart.php';
        if (null === self::$_cart) {
            self::$_cart = Vassilymas_Service_ShoppingCart::getInstance();
        }
        return self::$_cart;
    }
    
    /**
     * Creates a new Email Service
     * @return Vassilymas_Service_Email
     */
    public static function createEmailObject()
    {
        require_once 'Email.php';
        $email = new Vassilymas_Service_Email();
        return $email;
    }
    
    /**
     * Creates a new Mailchimp
     * @return Vassilymas_Service_Mailchimp
     */
    public static function createMailchimpObject()
    {
        require_once 'MailChimp.php';
        return new Vassilymas_Service_Mailchimp();
    }
}