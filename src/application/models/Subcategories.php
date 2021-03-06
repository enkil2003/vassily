<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/models/Subcategories.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

/**
 * Subcategories
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Subcategories.php 321 2011-12-31 05:14:39Z enkil2003 $
 */
class Subcategories extends BaseSubcategories
{
	/**
	 * Returns all subcategories filtered by parent category id.
	 * @param int $categoryId parent category id
	 * @return array Subcategories
	 */
	public static function getSubcategoryByCategoryId($categoryId)
	{
        $subcategory = Doctrine_Core::getTable('subcategories')
            ->findByCategory($categoryId)->toArray();
        return $subcategory;
	}
    public static function create($categoryId, $name)
    {
        $categoria = new Subcategories();
        $categoria->category = $categoryId;
        $categoria->name = $name;
        $categoria->save();
    }
    public function preSave($event)
    {
        // sets order default value
        if (!is_int($this->order)) {
            $q = Doctrine_Query::create()
                ->select('MAX(s.order) order')
                ->from('Subcategories s')
                ->where('s.Category = ?', $this->Category)
                ->fetchArray();
            $this->order = $q[0]['order']+1;
        }
    }
    /**
     * Returns all subcategories from model filtered by parent category id ordered by order ASC
     * @return array subcategories
     */
    public static function getAllSubcategoriesFromCategory($categoryId)
    {
        $q = Doctrine_Query::create()
            ->from('subcategories s')
            ->where("s.Category = $categoryId")
            ->orderBy('s.order ASC');
        return $q->fetchArray();
    }
    /**
     * Devuelve el nombre de la categoria por id
     * @param int $subcategoryId
     */
    public function getParentCategory($subcategoryId)
    {
        $q = Doctrine_Query::create()
            ->select('s.Category')
            ->from('subcategories s');
        $subcategory = $q->fetchArray();
        $q = Doctrine_Query::create()
            ->select('c.name')
            ->from('CategorY c')
            ->where('c.id = 15');
        $category = $q->fetchArray();
        return $category[0]['name'];
    }
    /**
     * Returns an array of subcategories that have associated products, ordered by order column
     * @param int ·categoryId parent category id
     * @return array ordered subcategories
     */
    public static function getOrderedSubcategoriesByCategoryId($categoryId)
    {
        $q = Doctrine_Query::create()
            ->from('Subcategories s')
            ->innerJoin('s.SubcategoriesHasProducts shp')
            ->where('s.Category = '.$categoryId)
            ->orderBy('order');
        $subcategories = $q->execute(Doctrine_Core::HYDRATE_ARRAY);
        return $subcategories->toArray();
    }
    /**
     * Returns an array of subcategories, ordered by order column
     * @param int ·categoryId parent category id
     * @return array ordered subcategories
     */
    public static function getAllOrderedSubcategoriesByCategoryId($categoryId)
    {
        $q = Doctrine_Query::create()
            ->from('Subcategories s')
            ->where('s.Category = '.$categoryId)
            ->orderBy('order');
        $subcategories = $q->execute(Doctrine_Core::HYDRATE_ARRAY);
        return $subcategories->toArray();
    }
    /**
     * Deletes a subcategory by given id
     * @param int $subcategoryId
     * @return int affected rows
     */
    public static function deleteById($subcategoryId)
    {
        return Doctrine_Query::create()
            ->delete('Subcategories s')
            ->where('s.id = ?', $subcategoryId)
            ->execute();
    }
    /**
     * Changes a subcategory name by id
     * @param int $id subcategory id
     * @param string $name new name for the subcategory
     */
    public static function changeName($id, $name)
    {
        $subcategories = new Subcategories();
        $subcategory = $subcategories->find($id);
        $subcategory->name = $name;
        $subcategory->save();
    }
}
