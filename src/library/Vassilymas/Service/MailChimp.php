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

require_once APPLICATION_PATH . '/../library/ThirdParty/MCAPI.class.php';
class Vassilymas_Service_MailChimp
{
    /**
     * Adds a new email to the mailing list.
     * @param string $name
     * @param string $email
     * @param string $confirmationCode optional, used for transparent registration and newsletter subscription
     * @return boolean true on success
     */
    public function add($name, $email, $confirmationCode = '')
    {
        $config = Zend_Registry::get('config');
        $api = new MCAPI($config->mailchimp->apiKey);
        $merge_vars = array (
            'NAME' => $name,
            'MERGE1' => $confirmationCode
        );
        return $api->listSubscribe(
            $config->mailchimp->listId,
            $email,
            $merge_vars
        );
    }
    
    /**
     * Removes an email from the mailing list.
     * @param string $email
     * @return boolean true on success
     */
    public function remove($email)
    {
        $config = Zend_Registry::get('config');
        $api = new MCAPI($config->mailchimp->apiKey);
        return $api->listUnsubscribe(
            $config->mailchimp->listId,
            $email
        );
    }
}