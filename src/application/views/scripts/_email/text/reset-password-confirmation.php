<?php 
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/views/scripts/_email/text/reset-password-confirmation.php $
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
<?php echo $this->translate('Hola')?> <?php echo $this->fullname?>,

<?php echo $this->translate('El cambio de contraseña se ha realizado con exito')?>

<?php echo $this->translate('Esta es tu nueva contraseña')?>
 <?php echo $this->password?>, <?php echo $this->translate('la puedes cambiar desde el panel de usuario')?>
http://<?php echo $_SERVER['HTTP_HOST']?>/<?php echo $this->translate('mis-datos')?>

<?php echo $this->translate('Recuerda que tu usuario es')?> <?php echo $this->username?>

<?php echo $this->translate('Muchas Gracias')?>

<?php echo $this->translate('Cualquier consulta o pregunta que desees realizar, por favor, escribinos a:')?>
info@vassilymas.com.ar

vassilymas!
www.vassilymas.com.ar