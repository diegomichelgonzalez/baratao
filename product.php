<?php
  $page_title = 'Lista de productos';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $products = join_product_table();
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
         <div class="pull-right">
           <a href="add_product.php" class="btn btn-primary">Agragar producto</a>
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Imagen</th>
                <th> Descripción </th>
                <th class="text-center" style="width: 8%;"> Categoría </th>
                <th class="text-center" style="width: 2%;"> Stock </th>
                <th class="text-center" style="width: 6%;"> Precio compra </th>
                <th class="text-center" style="width: 6%;"> Precio Minorista </th>
				<th class="text-center" style="width: 6%;"> Precio Mayorista </th>
				<th class="text-center" style="width: 8%;"> Cod. Barra </th>
                <th class="text-center" style="width: 8%"> Acciones </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product):?>
              <tr>
                <td class="text-center"><?php echo remove_junk($product['id']);?></td>
                <td>
                  <?php if($product['imagen'] === '0'): ?>
                    <img class="img-avatar img-circle" src="uploads/products/no_image.jpg" alt="">
                  <?php else: ?>
                  <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['img']; ?>" alt="">
                <?php endif; ?>
                </td>
                <td> <?php echo remove_junk($product['descripcion']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['categoria']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['stock']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['precio_costo']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['precio_venta_minorista']); ?></td>
				        <td class="text-center"> <?php echo remove_junk($product['precio_venta_mayorista']); ?></td>
				<td class="text-center"> <?php echo remove_junk($product['codigo_barra']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_product.php?id=<?php echo $product['id'];?>" class="btn btn-info btn-xs"  title="Editar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                     <a href="delete_product.php?id=<?php echo $product['id'];?>" class="btn btn-danger btn-xs"  title="Eliminar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
