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

class Vassilymas_Service_Email
{
    const ADMIN_LAYOUT = 'adminLayout';
    const LAYOUT = 'layout';
    
    /**
     * Constructor
     * @return void
     */
    public function __construct()
    {
        $this->_htmlScriptsPath = APPLICATION_PATH."/views/scripts/_email/html";
        $this->_txtScriptsPath = APPLICATION_PATH."/views/scripts/_email/text";
        $this->_view = new Zend_View();
        $this->_view
            ->setEncoding('utf-8')
            ->addScriptPath($this->_htmlScriptsPath);
    }
    
    /**
     * Sends an email.
     * @param string $fromEmail the email from who is sending the email.
     * @param string $fromName the name from who is sending the email.
     * @param string $toEmail the destination email.
     * @param string $toName the destination person name.
     * @param string $subject subject for the email.
     * @param string $template view template for the email.
     * @param string $templateData variables to populate the view template.
     * @param string $layout layout to be used in the email generation.
     * @return void
     */
    public function send($fromEmail, $fromName, $toEmail, $toName, $subject, $template, array $templateData = array(), $layout = 'layout')
    {
        $this->_layout = $layout;
        $email = new Zend_Mail('UTF-8');
        //Create email
        $email->setFrom($fromEmail, $fromName);
        $email->addTo($toEmail, $toName);
        $email->setSubject($subject);
        $email->setBodyText(file_get_contents($this->_txtScriptsPath."/{$template}.php"));
        // @TODO I don't know how to configure my own zend layout for this view
        $this->_prepareContent($template, $templateData);
        $html = $this->_getRenderedEmailTemplate();
        $email->setBodyHtml($html);
        $email->send();
    }
    
    /**
     * This function is responsable for template content renderization 
     * @param string $template template to render
     * @param array $templateData data to populate template
     * @return void
     */
    private function _prepareContent($template, $templateData)
    {
        $this->_content = $this->_render($template, $templateData);
    }
    
    /**
     * This function is responsable for rendering the layout along with the content.
     * The function has a simil "templating" engine to allow easy style creation.
     * You just have to create the styles as a normal html, then the method will rearrange the code, so the css will
     * be on top on the layout.
     * @return string html to send
     */
    private function _getRenderedEmailTemplate()
    {
        $style = '';
        if (strpos($this->_content, '</style>')) {
            list($style, $html) = explode('</style>', $this->_content);
            $style .= '</style>';
        } else {
            $html = $this->_content;
        }
        return $this->_render($this->_layout, array('style' => $style, 'content' => $html));
    }
    
    /**
     * This function is responsable to asign the variables to the view.
     * @param string $template template to render
     * @param array $templateData data to populate the template
     */
    private function _render($template, array $templateData = array())
    {
        foreach($templateData as $key => $val) {
            $this->_view->$key = $val;
        }
        return $this->_view->render($template.'.phtml');
    }
}