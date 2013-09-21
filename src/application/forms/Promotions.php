<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/forms/Promotions.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

require_once 'VassilymasAbstract.php';
class Form_Promotions extends Form_VassilymasAbstract
{
    /**
     * Creates the promotions form.
     * @see Zend_Form::init()
     * @return void
     */
    public function init()
    {
        $this->setMethod('post')
            ->setAction('/admin/promotions/')
            ->setEnctype('multipart/form-data');
        $this->createElement(
            'file',
            'headerPromotion'
        );
        /* @TODO agregar validadores */
        $headerPromotion = $this->createElement(
            'file',
            'headerPromotion',
            array(
                'decorators' => array(
                    'label',
                    'file'
                ),
                'label' => $this->_view->translate('Banner del encabezado'),
                'placeholder' => $this->_view->translate('seleccione una imagen'),
                'destination' => APPLICATION_PATH . '/../public/uploads/promotions',
                'MaxFileSize' => 2097152,
                'filters' => array(
                    array('Rename', array('header.png'))
                ),
                'validators' => array(
                    array('Count', false, 1),
                    'isImage',
                    array('Size', false, 2097152),
                    array('Extension', false, 'png'),
                    array(
                        'ImageSize',
                        false,
                        array(
                            'width' => 917,
                            'height' => 89,
                        )
                    )
                )
            )
        );
        $leftPromotion = $this->createElement(
            'file',
            'leftPromotion',
            array(
                'decorators' => array(
                    'label',
                    'file'
                ),
                'label' => $this->_view->translate('Banner de la columna izquierda'),
                'placeholder' => $this->_view->translate('seleccione una imagen'),
                'destination' => APPLICATION_PATH . '/../public/uploads/promotions',
                'MaxFileSize' => 2097152,
                'filters' => array(
                    array('Rename', array('promotion.jpg'))
                ),
                'validators' => array(
                    array('Count', false, 1),
                    array('Size', false, 2097152),
                    array('Extension', false, 'jpg'),
                    'isImage',
                    array(
                        'ImageSize',
                        false,
                        array(
                            'width' => 550,
                            'height' => 403,
                        )
                    )
                )
            )
        );
        $rightPromotion = $this->createElement(
            'file',
            'rightPromotion',
             array(
                'decorators' => array(
                    'label',
                    'file'
                ),
                'label' => $this->_view->translate('Banner de la columna derecha'),
                'placeholder' => $this->_view->translate('seleccione una imagen'),
                'destination' => APPLICATION_PATH . '/../public/uploads/promotions',
                'MaxFileSize' => 2097152,
                'filters' => array(
                    array('Rename', array('promotionText.png'))
                ),
                'validators' => array(
                    array('Count', false, 1),
                    'isImage',
                    array('Size', false, 2097152),
                    array('Extension', false, 'png'),
                    array(
                        'ImageSize',
                        false,
                        array(
                            'width' => 350,
                            'height' => 403,
                        )
                    )
                )
            )
        );
        $this->addElements(array($headerPromotion, $rightPromotion, $leftPromotion));
        $this->addDefaultSubmit();
    }
}