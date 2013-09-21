<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2012-01-01 08:28:17 -0300 (Sun, 01 Jan 2012) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/forms/Checkout.php $
 * @revision - $Revision: 333 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2012-01-01 08:28:17 -0300 (Sun, 01 Jan 2012) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

require_once 'VassilymasAbstract.php';
/* @TODO buscar una manera mejor de incluir mis filtros */
require_once 'My/Filter/Ucfirst.php';
require_once 'My/Filter/Ucwords.php';
class Form_Checkout extends Form_VassilymasAbstract
{
    public function init()
    {
        $this->addElement(
            'radio',
            'reception',
            array(
                'DisableLoadDefaultDecorators' => true,
                'decorators' => array(
                    'ViewHelper',
                    'label',
                ),
                'separator' => '',
                'multiOptions' => array(
                    'send' => $this->_view->translate('Envio a domicilio'),
                    'pickup' => $this->_view->translate('Retiro por sucursal'),
                    'anotherAddress' => $this->_view->translate('Indique donde desea recibir su compra')
                ),
                'value' => 'send'
            )
        );
        
        $this->addElement(
            'radio',
            'payMethod',
            array(
                'DisableLoadDefaultDecorators' => true,
                'decorators' => array(
                    'ViewHelper',
                    'label',
                ),
                'separator' => '',
                'multiOptions' => array(
                    'arrival' => $this->_view->translate('Pago a contra entrega'),
                    'transaction' => $this->_view->translate('Otros medios de pago'),
                )
            )
        );
        
        $this->_createSimpleTextElementsForValidation(
            array(
                'address',
                'zip',
                'city',
                'state',
                'homePhone',
                'celphone',
                'name',
                'lastname',
                'identification',
                'phone',
            )
        );
        
        $this->_createSimpleTextAreaElementsForValidation(
            array(
                'anotherAddressAditionalInfo',
                'pickUpAditionalInfo'
            )
        );
        
        $this->removeElement('no_csrf');
    }
    
    private function _createSimpleTextElementsForValidation($elements = array())
    {
        foreach($elements as $name) {
            $this->addElement(
                'textarea',
                $name,
                array(
                    'filters' => array(
                        'StringTrim'
                    )
                )
            );
        }
    }
    
    private function _createSimpleTextAreaElementsForValidation($elements = array())
    {
        foreach($elements as $name) {
            $this->addElement(
                'textarea',
                $name,
                array(
                    'filters' => array(
                        'StringTrim'
                    )
                )
            );
        }
    }
}