<?php 
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/views/scripts/_email/text/welcome.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */
?>
<?php
header("content-type: text/plain");
?>
<?php echo $this->translate('Hola')?> <?php echo $this->fullname?>

<?php echo $this->translate('Bienvenido a Vassilymas. Antes de poder ingresar te requerimos la confirmacion de la cuenta.');?>
<?php echo $this->translate('Esto lo hacemos para que nadie pueda registrar emails no deseados.')?>

<?php echo $this->translate('Active su cuenta visitando copiando y pegando la siguiente direccion en un explorador de internet')?>

<?php echo $this->url?>

