<?php

/**
 * BaseProducts
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $sku
 * @property string $name
 * @property string $description
 * @property float $price
 * @property float $width
 * @property float $height
 * @property float $depth
 * @property string $materials
 * @property Doctrine_Collection $Images
 * @property Doctrine_Collection $Orderdetail
 * @property Doctrine_Collection $SubcategoriesHasProducts
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: BaseProducts.php 321 2011-12-31 05:14:39Z enkil2003 $
 */
abstract class BaseProducts extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('products');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
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
        $this->hasColumn('name', 'string', 45, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '45',
             ));
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('price', 'float', 15, array(
             'type' => 'float',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '15',
             ));
        $this->hasColumn('width', 'float', 15, array(
             'type' => 'float',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '0.00',
             'notnull' => false,
             'autoincrement' => false,
             'length' => '15',
             ));
        $this->hasColumn('height', 'float', 15, array(
             'type' => 'float',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '0.00',
             'notnull' => false,
             'autoincrement' => false,
             'length' => '15',
             ));
        $this->hasColumn('depth', 'float', 15, array(
             'type' => 'float',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '0.00',
             'notnull' => false,
             'autoincrement' => false,
             'length' => '15',
             ));
        $this->hasColumn('materials', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Images', array(
             'local' => 'id',
             'foreign' => 'products_id'));

        $this->hasMany('Orderdetail', array(
             'local' => 'id',
             'foreign' => 'product'));

        $this->hasMany('SubcategoriesHasProducts', array(
             'local' => 'id',
             'foreign' => 'products_id'));
    }
}