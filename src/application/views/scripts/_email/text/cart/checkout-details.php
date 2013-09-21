Numero de orden: <?php echo $this->orderDetails[0]['order']?>
Productos:
<?php
$total = 0;
?>
<?php
foreach($this->orderDetails as $product):
    $total += $product['Products']['price'];
?>
Id: <?php echo $product['Products']['id'] ?>
SKU: <?php echo $product['Products']['sku'] ?>
Nombre: <?php echo $product['Products']['name'] ?>
Descripción: <?php echo $product['Products']['description'] ?>
Price: <?php echo $product['Products']['price'] ?>
Ancho: <?php echo $product['Products']['width'] ?>
Alto: <?php echo $product['Products']['height'] ?>
Profundidad: <?php echo $product['Products']['depth'] ?>
Materiales: <?php echo $product['Products']['materials'] ?>
Imagenes: <?php echo $product['Products']['Images'][0]['name'] ?><
<?php 
endforeach;
?>
Total: <?php echo $total ?>