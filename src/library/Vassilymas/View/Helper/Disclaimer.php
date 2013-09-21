<?php
class Vassilymas_View_Helper_Disclaimer extends Zend_View_Helper_Abstract
{
    public function disclaimer()
    {
        $content = $this->view->translate(
          'Para cualquier consulta, completá el siguiente formulario.<br />'
          . 'Por favor danos la mayor cantidad de detalles posibles<br />'
          . 'para efectivizar la respuesta'
        );
        
        $disclaimer = <<<DISCLAIMER
<div class="disclaimer">
  <p>
    {$content}
  </p>
</div>
DISCLAIMER;
        
        return $disclaimer;
    }
}