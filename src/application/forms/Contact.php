<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2012-02-26 16:55:16 -0300 (Sun, 26 Feb 2012) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/forms/Contact.php $
 * @revision - $Revision: 435 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2012-02-26 16:55:16 -0300 (Sun, 26 Feb 2012) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Form_Contact extends Zend_Form
{
    /**
     * Creates the contact form.
     * @see Zend_Form::init()
     * @return void
     */
    public function init()
    {
        $config = new Zend_Config_Ini(
            APPLICATION_PATH . '/configs/forms/contact.ini',
            'contact'
        );
        $this->setConfig($config->contact);
        
        $this->getView()->minifyFooterScript()->appendFile('/js/jquery/plugins/jquery.scrollTo.min.js');
        $validator = $this->getDecorator('JsAutoValidation');
        $validator->setOption(
            'validatorOptions',
            array(
                'onInvalidValidation' => new Zend_Json_Expr(
            <<<FUNCTION
function(validator) {
    $.scrollTo($('ul.errors:eq(0)').parent(), {duration:500});
}
FUNCTION
            ))
        );
        $this->getElement('province')
            ->addMultiOptions(
                array(
                    'Ciudad autónoma de Buenos Aires' => 'Ciudad autónoma de Buenos Aires',
                    'Buenos Aires' => 'Buenos Aires',
                    'Catamarca' => 'Catamarca',
                    'Chaco' => 'Chaco',
                    'Chubut' => 'Chubut',
                    'Córdoba' => 'Córdoba',
                    'Corrientes' => 'Corrientes',
                    'Entre Ríos' => 'Entre Ríos',
                    'Formosa' => 'Formosa',
                    'Jujuy' => 'Jujuy',
                    'La Pampa' => 'La Pampa',
                    'La Rioja' => 'La Rioja',
                    'Jujuy' => 'Jujuy',
                    'Mendoza' => 'Mendoza',
                    'Misiones' => 'Misiones',
                    'Neuquén' => 'Neuquén',
                    'Río Negro' => 'Río Negro',
                    'Salta' => 'Salta',
                    'San Juan' => 'San Juan',
                    'San Luis' => 'San Luis',
                    'Santa Cruz' => 'Santa Cruz',
                    'Santa Fe' => 'Santa Fe',
                    'Santiago del Estero' => 'Santiago del Estero',
                    'Tierra del Fuego' => 'Tierra del Fuego',
                    'Tucumán' => 'Tucumán'
                )
            );
    }
}