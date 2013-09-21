<?php 
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/views/scripts/_email/text/password-reset.php $
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
<?php echo $this->translate('Visita esta url para confirmar el cambio de contraseña')?>
 <?php echo $this->url?>
<?php echo $this->translate('Hola')?> <?php echo $this->fullname?>,

<?php echo $this->translate('Has solicitado un cambio de contraseña. Pero para ello requerimos tu confirmación.
Puedes confirmar el cambio de contraseña visitando el siguiente vinculo.
Copia y pega este vinculo en una ventana del navegador')?>


<?php echo $this->url?>

<?php echo $this->translate('Solo tienes 24 horas para confirmar el cambio de contraseña.')?>

<?php echo $this->translate('Muchas Gracias')?>

<?php echo $this->translate('Cualquier consulta o pregunta que desees realizar, por favor, escribinos a:')?>
info@vassilymas.com.ar

vassilymas!
www.vassilymas.com.ar