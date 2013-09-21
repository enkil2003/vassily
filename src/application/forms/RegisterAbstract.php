<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2012-02-07 01:43:26 -0300 (Tue, 07 Feb 2012) $
 * 
 * @filesource - $HeadURL: http://subversion.assembla.com/svn/vassilymas/trunk/application/forms/Register.php $
 * @revision - $Revision: 389 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2012-02-07 01:43:26 -0300 (Tue, 07 Feb 2012) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

class Form_RegisterAbstract extends Zend_Form
{
    protected function _addProvinceElements(Zend_Form_Element_Select $element)
    {
        $element->addMultiOptions(
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
