<?php
class Vassilymas_View_Helper_RetrievePassword extends Zend_View_Helper_Abstract
{
    public function retrievePassword()
    {
        return '<a href="/olvide-mi-contraseña">Olvide mi contraseña</a>';
    }
}