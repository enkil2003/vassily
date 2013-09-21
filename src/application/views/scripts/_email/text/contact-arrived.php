<?php 
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: https://subversion.assembla.com/svn/vassilymas/trunk/src/application/views/scripts/_email/text/contact-arrived.php $
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
Hemos recibido un contacto

Nombre: <?php echo $this->contactData['name']; ?> <?php echo $this->contactData['lastname']; ?>

Email: <?php echo $this->contactData['email']; ?>

Teléfono: <?php echo $this->contactData['phone']; ?>

Ciudad: <?php echo $this->contactData['city']; ?>

Comentarios: <?php echo $this->contactData['comments']; ?>