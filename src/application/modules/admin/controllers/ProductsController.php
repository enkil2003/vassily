<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2012-02-26 17:56:46 -0300 (Sun, 26 Feb 2012) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/modules/admin/controllers/ProductsController.php $
 * @revision - $Revision: 439 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2012-02-26 17:56:46 -0300 (Sun, 26 Feb 2012) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */

require_once 'CustomController.php';
class Admin_ProductsController extends Admin_CustomController
{
    const CONTROLLER_NAME = 'products';
    const TEMP_DIR = '/../public/uploads/temp';
    const DEST_DIR = '/../public/uploads/image';
    const THUMB_DIR = '/../public/uploads/thumb';
    const IMAGE_WIDTH = 390;
    const IMAGE_HEIGHT = 255;
    const FIXED_WIDTH_HEIGHT = 390;
    const FIXED_THUMB_WIDTH_HEIGHT = 93;
    const IMAGE_QUALITY = 75;
    private $_allowedExtensions = array('jpeg','jpg','png','gif');
    /**
     * init hook with custom construct settings
     */
    public function init()
    {
        parent::init();
        $this->_setDefaultMenu();
    }
    
    /**
     * Default View for index action
     * @return void
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $form = new Form_Product();
        $form->addDefaultSubmit();
        if ($productId = $request->getParam('id')) {
            // tengo que saber en que subcategorias el producto esta registrado
            $q = new Doctrine_Query();
            $q->select('shp.subcategories_id')
                ->from('SubcategoriesHasProducts shp')
                ->where('shp.products_id = '.$productId);
            $subcategoriesHasProducts = $q->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
            $product = Products::getProductById($productId);
            $subcats = array();
            foreach ($subcategoriesHasProducts as $subcat) {
                $subcats[] = $subcat['subcategories_id'];
            }
            // populate categories fields
            foreach ($form->getDisplayGroups() as $dg) {
                foreach ($dg->getElements() as $element) {
                    $options = $element->setValue($subcats);
                }
            }
            // populate product fields
            $form->getElement('name')->setValue($product['name']);
            $form->getElement('price')->setValue($product['price']);
            $form->getElement('width')->setValue($product['width']);
            $form->getElement('height')->setValue($product['height']);
            $form->getElement('depth')->setValue($product['depth']);
            $form->getElement('description')->setValue($product['description']);
            $form->getElement('materials')->setValue($product['materials']);
            $form->getElement('submit')->setLabel('Modificar Producto');
            $form->setRowId($productId);
            // populate images
            $images = array();
            foreach ($product['Images'] as $image) {
                $images[] = $image['name'];
            }
            $this->view->images = $images;
        }
        if ($request->isPost() && $form->isValid($request->getPost())) {
            /* @TODO Backend validation */
            $displayGroups = $form->getDisplayGroups();
            $subcategories = array();
            foreach ($displayGroups as $dg) {
                $categories =$dg->getElements();
                foreach ($categories as $c) {
                    foreach ($c->getValue() as $subcategoryId){
                        $subcategories[] = $subcategoryId;
                    }
                }
            }
            /* @TODO esto esta duplicado en el metodo save-product q uso por ajax */
            $product = new Products();
            $product->name = $form->getValue('name');
            $product->description = $form->getValue('description');
            $product->price = $form->getValue('price');
            $product->width = $form->getValue('width');
            $product->height = $form->getValue('height');
            $product->depth = $form->getValue('depth');
            $product->materials = $form->getValue('materials');
            $product->save();
            foreach ($subcategories as $id) {
                $shp = new SubcategoriesHasProducts();
                $shp->subcategories_id = $id;
                $shp->products_id = $product->id;
                $shp->save();
            }
            echo Zend_Json::encode(array('product_id' => $product->id));
            die;
        }
        $this->view->form = $form;
        // add plupload css
        $this->view->headLink()->appendStylesheet(APPLICATION_CDN . "/js/jquery/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css");
        // add plupload js
        $this->view->minifyFooterScript()->appendFile("/js/yahoo/browserplus-2.4.21.min.js");
        $this->view->minifyFooterScript()->appendFile("/js/jquery/plupload/js/plupload.full.js");
        $this->view->minifyFooterScript()->appendFile("/js/jquery/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js");
        
        // add tiny mce
        $this->view->minifyFooterScript()->appendFile(APPLICATION_CDN . "/js/jquery/plugins/tinymce/tiny_mce.js");
        $this->view->minifyFooterScript()->appendFile("/js/jquery/plugins/tinymce/jquery.tinymce.js");
        
        $this->_helper->loadDefaultCss();
        $this->_helper->loadDefaultJs();
    }
    
    public function saveProductAjaxAction()
    {
        $request = $this->getRequest();
        if (!$request->isXmlHttpRequest()) {
            throw new Exception("No soup for you!!!");
        }
        $form = new Form_Product();
        $form->populate($request->getPost());
        $displayGroups = $form->getDisplayGroups();
        $subcategories = array();
        if ($request->getPost('id')) {
            $product = Doctrine_Core::getTable('Products')->find($request->getPost('id'));
            $q = new Doctrine_Query();
            $q->delete('SubcategoriesHasProducts shp')
                ->where('shp.products_id = '.$request->getPost('id'));
            $q->execute();
        } else {
            $product = new Products();
        }
        // Esto esta duplicado mas arriba en el metodo 
        $product->name = $form->getValue('name'); 
        $product->description = $form->getValue('description'); 
        $product->price = $form->getValue('price');
        $product->width = $form->getValue('width');
        $product->height = $form->getValue('height');
        $product->depth = $form->getValue('depth');
        $product->materials = $form->getValue('materials');
        $product->save();
        $subcategories = array();
        foreach ($request->getPost('subcategories') as $id) {
            $shp = new SubcategoriesHasProducts();
            $shp->products_id = $product->id;
            $shp->subcategories_id = $id;
            $shp->save();
        }
        // si estoy editando, quizas tengo que borrar imagenes
        $imagesToDelete = $request->getPost('imagesToDelete', array()); 
        foreach ($imagesToDelete as $image) {
            $q = new Doctrine_Query();
            $q->delete('Images i')
                ->where('name = ?', $image)
                ->execute();
            /* @TODO ver porque no borra las imagenes, tiraba warnings y lo comente para poder seguir */
            @unlink(APPLICATION_PATH.'/../public/uploads/image/'.$image);
            @unlink(APPLICATION_PATH.'/../public/uploads/thumb/'.$image);
        }
        $productSession = new Zend_Session_Namespace('savingProduct');
        $productSession->id = $product->id;
        echo Zend_Json::encode(array('product_id' => $product->id));
        die;
    }
    /**
     * @see Admin_CustomController::_setDefaultMenu()
     */
    protected function _setDefaultMenu()
    {
        $this->view->placeholder('catalogLeftColumn')->append(
            $this->view->partial(
                'helpers/adminCrud.phtml',
                array(
                    'title' => 'Productos',
                    'menu' => array(
                        array(
                            'url' => '/admin/products',
                            'title' => 'Agregar Producto'
                        ),
                        array(
                            'url' => '/admin/products/modify',
                            'title' => 'Modificar Producto'
                        ),
                    )
                )
            )
        );
    }
    /**
     * Default view for modify action
     * @return void
     */
    public function modifyAction()
    {
        $this->_helper->loadDefaultCss();
        $this->_helper->loadDefaultJs();
        $this->view->form = new Form_ProductUpdate();
        $this->view->minifyFooterScript()->appendFile("/js/jquery/plugins/jquery.tablesorter.js");
        // add plupload css
        $this->view->headLink()->appendStylesheet(APPLICATION_CDN . "/js/jquery/plugins/tablesorter/themes/blue/style.css");
    }
    public function getProductGridAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $products = Products::getProductsBySubcategoryId($request->getParam('subcategories_id'));
            $body = array();
            if (is_array($products)) {
                foreach($products as $p) {
                    $body[] = array(
                        array(
                            'url' => '/admin/products/index/id/'.$p['id'],
                            'text' => $p['id']
                        ),
                        array(
                            'url' => '/admin/products/index/id/'.$p['id'],
                            'text' => $p['name']
                        ),
                        array(
                            'url' => '/admin/products/index/id/'.$p['id'],
                            'text' => $p['description']
                        )
                    );
                }
            }
            $header = array('id', 'nombre', 'descripcion');
            echo $this->view->partial(
                '_tableGenerator.phtml',
                array(
                    'id' => 'grilla',
                    'header' => $header,
                    'body' => $body
                )
            );
            die;
        }
    }
    /**
     * Method for removing a product and related images
     * @return void
     */
    public function removeAction()
    {
        $request = $this->getRequest();
        if ($request->isPost() && $request->isXmlHttpRequest()) {
            Products::deleteById($this->_request->getPost('id'));
            exit();
        }
    }
    public function getSubcategoriesAction()
    {
        $request = $this->getRequest();
        if ($request->isPost() && $request->isXmlHttpRequest()) {
            $q = new Doctrine_Query();
            $q->select('s.id, s.name')
                ->from('Subcategories s')
                ->innerJoin('s.SubcategoriesHasProducts shp')
                ->innerJoin('shp.Products')
                ->where("s.Category = ".$request->getPost('category'));
            $subcategories = $q->execute(Doctrine_Core::HYDRATE_ARRAY)->toArray();
            echo Zend_Json::encode($subcategories);
            die;
        }
    }
    
    /**
     * Default Action for uploading images
     * @return void
     */
    public function uploadImageAction()
    {
        $productSession = new Zend_Session_Namespace('savingProduct');
        // HTTP headers for no cache etc
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        // Settings
        //$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
        $targetDir = APPLICATION_PATH.'/../public/uploads/temp/'.$productSession->id;;
        //$cleanupTargetDir = false; // Remove old files
        //$maxFileAge = 60 * 60; // Temp file age in seconds
        // 5 minutes execution time
        @set_time_limit(5 * 60);
        // Uncomment this one to fake upload time
        // usleep(5000);
        // Get parameters
        $chunk = isset($_REQUEST["chunk"]) ? $_REQUEST["chunk"] : 0;
        $chunks = isset($_REQUEST["chunks"]) ? $_REQUEST["chunks"] : 0;
        $fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';
        // Clean the fileName for security reasons
        $fileName = preg_replace('/[^\w\._]+/', '', $fileName);
        // Make sure the fileName is unique but only if chunking is disabled
        if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
            $ext = strrpos($fileName, '.');
            $fileName_a = substr($fileName, 0, $ext);
            $fileName_b = substr($fileName, $ext);
            $count = 1;
            while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b)) {
                $count++;
            }
            $fileName = $fileName_a . '_' . $count . $fileName_b;
        }
        // Create target dir
        if (!file_exists($targetDir)) {
            @mkdir($targetDir);
        }
        // Look for the content type header
        if (isset($_SERVER["HTTP_CONTENT_TYPE"])) {
            $contentType = $_SERVER["HTTP_CONTENT_TYPE"];
        } else {
            $contentType = $_SERVER["CONTENT_TYPE"];
        }
        // Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
        if (strpos($contentType, "multipart") !== false) {
            if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
                // Open temp file
                $out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
                if ($out) {
                    // Read binary input stream and append it to temp file
                    $in = fopen($_FILES['file']['tmp_name'], "rb");
        
                    if ($in) {
                        while ($buff = fread($in, 4096)) {
                            fwrite($out, $buff);
                        }
                    } else {
                        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                    }
                    fclose($in);
                    fclose($out);
                    @unlink($_FILES['file']['tmp_name']);
                } else {
                    die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
                }
            } else {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }
        } else {
            // Open temp file
            $out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
            if ($out) {
                // Read binary input stream and append it to temp file
                $in = fopen("php://input", "rb");
                if ($in) {
                    while ($buff = fread($in, 4096))
                        fwrite($out, $buff);
                } else {
                    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                }
                fclose($in);
                fclose($out);
            } else {
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            }
        }
        // Return JSON-RPC response
        die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
    }
    
    /**
     * Action for adding images to product
     * (this method is called from the view, once the product has been added and we have a valid product id)
     * @return void
     */
    public function addImagesToProductAction()
    {
        $productSession = new Zend_Session_Namespace('savingProduct');
        $product_id = $productSession->id;
        $productSession->unsetAll();
        unset($productSession);
        $temp = opendir(APPLICATION_PATH.self::TEMP_DIR.'/'.$product_id);
        while (($file = readdir($temp)) !== false) {
            $source = APPLICATION_PATH.self::TEMP_DIR.'/'.$product_id;
            $filenameArr = explode('.', $file);
            $ext = $filenameArr[count($filenameArr)-1];
            if (in_array($ext, $this->_allowedExtensions)) {
                do {
                   $newName = uniqid('img_').$file;
                   $newName = str_replace($ext, 'jpg', $newName);
                } while (file_exists(APPLICATION_PATH.self::DEST_DIR.'/'.$newName));
                require_once APPLICATION_PATH . "/../library/PEAR/WideImage/WideImage.php";
                $image = WideImage::load($source.'/'.$file);
                $image->resize(self::IMAGE_WIDTH, self::IMAGE_HEIGHT, 'outside', 'any')
                    ->crop("left", "top", self::IMAGE_WIDTH, self::IMAGE_HEIGHT)
                    ->saveToFile(APPLICATION_PATH.self::DEST_DIR.'/'.$newName, self::IMAGE_QUALITY);
                
                $image->resize(self::FIXED_THUMB_WIDTH_HEIGHT, self::FIXED_THUMB_WIDTH_HEIGHT, 'outside', 'any')
                    ->crop("left", "top", self::FIXED_THUMB_WIDTH_HEIGHT, self::FIXED_THUMB_WIDTH_HEIGHT)
                    ->saveToFile(APPLICATION_PATH.self::THUMB_DIR.'/'.$newName, self::IMAGE_QUALITY);
                unlink($source.'/'.$file);
            } else {
                continue;
            }
            if ($product_id) {
                $image = new Images();
                $image->products_id = $product_id;
                $image->name = $newName;
                $image->save();
            }
        }
        rmdir($source);
        echo Zend_Json::encode(array('exito' => $product_id));
        die;
    }
}