<?php

/**
 * BaseOrderdetail
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $product
 * @property integer $order
 * @property float $price
 * @property integer $quantity
 * @property string $sku
 * @property Orders $Orders
 * @property Products $Products
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: BaseOrderdetail.php 321 2011-12-31 05:14:39Z enkil2003 $
 */
abstract class BaseOrderdetail extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('orderdetail');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('product', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('order', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('price', 'float', 15, array(
             'type' => 'float',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '15',
             ));
        $this->hasColumn('quantity', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '1',
             'notnull' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('sku', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '100',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Orders', array(
             'local' => 'order',
             'foreign' => 'id'));

        $this->hasOne('Products', array(
             'local' => 'product',
             'foreign' => 'id'));
    }
}