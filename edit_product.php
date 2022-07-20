<?php
  $page_title = 'Editar producto';
  require_once('includes/load.php');
  // Verifica ¿Qué nivel de usuario tiene permiso para ver esta página?
   page_require_level(2);
?>
<?php
$product = find_by_id('productos',(int)$_GET['id']);
$all_categories = find_all('categories');
$all_photo = find_all('media');
$all_marcas = find_all('marcas');
$all_iva = find_all('iva');
if(!$product){
  $session->msg("d","Falta el id del producto.");
  redirect('product.php');
}
?>
<?php
 if(isset($_POST['product'])){
    $req_fields = array('product-titulo','product-categoria','precio-compra', 'precio-minorista', 'precio-mayorista','precio-cantina', 'stock-minimo','product-stock','product-photo', 'codigo-barra','product-marca','product-iva' );
    validate_fields($req_fields);

   if(empty($errors)){
		$p_descripcion  = remove_junk($db->escape($_POST['product-titulo']));
		$p_categoria   = (int)$_POST['product-categoria'];
		$p_precio_compra   = remove_junk($db->escape($_POST['precio-compra']));
		$p_precio_minorista  = remove_junk($db->escape($_POST['precio-minorista']));
		$p_precio_mayorista  = remove_junk($db->escape($_POST['precio-mayorista']));
		$p_precio_cantina  = remove_junk($db->escape($_POST['precio-cantina']));
		$p_stock_minimo  = remove_junk($db->escape($_POST['stock-minimo']));
		$p_stock   = remove_junk($db->escape($_POST['product-stock']));
       if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
         $media_id = '0';
       } else {
         $media_id = remove_junk($db->escape($_POST['product-photo']));
       }
    $p_barra  = remove_junk($db->escape($_POST['codigo-barra']));
    $p_marca  = remove_junk($db->escape($_POST['codigo-marca']));
    $p_iva  = remove_junk($db->escape($_POST['codigo-iva']));

       $query   = "UPDATE productos SET";
       $query  .=" descripcion ='{$p_descripcion}', kcategoria ='{$p_categoria}', precio_costo ='{$p_precio_compra}',";
       $query  .=" precio_venta_minorista ='{$p_precio_minorista}', precio_venta_mayorista ='{$p_precio_mayorista}', precio_venta_cantina ='{$p_precio_cantina}',"; 
       $query  .=" stock_minimo='{$p_stock_minimo}', stock ='{$p_stock}',imagen='{$media_id}',codigo_barra='{$p_barra}',";
       $query  .=" idmarca='{$p_marca}', iva ='{$p_iva}'";
       $query  .=" WHERE id ='{$product['id']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Producto ha sido actualizado. ");
                 redirect('product.php', false);
               } else {
                 $session->msg('d',' Lo siento, actualización falló.');
                 redirect('edit_product.php?id='.$product['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('edit_product.php?id='.$product['id'], false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Editar producto</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-7">
           <form method="post" action="edit_product.php?id=<?php echo (int)$product['id'] ?>">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-titulo" value="<?php echo remove_junk($product['descripcion']);?>">
               </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <select class="form-control" name="product-categoria">
                    <option value="">Selecciona una categoría</option>
                   <?php  foreach ($all_categories as $cat): ?>
                     <option value="<?php echo (int)$cat['id']; ?>" <?php if($product['kcategoria'] === $cat['id']): echo "selected"; endif; ?> >
                       <?php echo remove_junk($cat['name']); ?></option>
                   <?php endforeach; ?>
                 </select>
                  </div>
                  <div class="col-md-4">
                    <select class="form-control" name="product-marca">
                    <option value="">Seleccione la Marca</option>
                   <?php  foreach ($all_marcas as $marca): ?>
                     <option value="<?php echo (int)$marca['id']; ?>" <?php if($product['idmarca'] === $marca['id']): echo "selected"; endif; ?> >
                       <?php echo remove_junk($marca['marcas']); ?></option>
                   <?php endforeach; ?>
                 </select>
                  </div>
                  <div class="col-md-4">
                    <select class="form-control" name="product-photo">
                      <option value=""> Sin imagen</option>
                      <?php  foreach ($all_photo as $photo): ?>
                        <option value="<?php echo (int)$photo['id'];?>" <?php if($product['imagen'] === $photo['id']): echo "selected"; endif; ?> >
                          <?php echo $photo['file_name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Cantidad en Stock</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                       <i class="glyphicon glyphicon-shopping-cart"></i>
                      </span>
                      <input type="number" class="form-control" name="product-stock" value="<?php echo remove_junk($product['stock']); ?>">
                   </div>
                  </div>
                 </div>
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Precio de compra</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i>Gs</i>
                      </span>
                      <input type="number" class="form-control" name="precio-compra" value="<?php echo remove_junk($product['precio_costo']);?>">
                      
                   </div>
                  </div>
                 </div>
                  <div class="col-md-4">
                   <div class="form-group">
                     <label for="qty">Precio Minorista</label>
                     <div class="input-group">
                       <span class="input-group-addon">
                         <i>Gs</i>
                       </span>
                       <input type="number" class="form-control" name="precio-minorista" value="<?php echo remove_junk($product['precio_venta_minorista']);?>">
                       
                    </div>
                   </div>
                  </div>
               </div>
              </div>
			  
			   <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Código de Barra</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                       <i class="glyphicon glyphicon-shopping-cart"></i>
                      </span>
                      <input type="number" class="form-control" name="codigo-barra" value="<?php echo remove_junk($product['codigo_barra']); ?>">
                   </div>
                  </div>
                 </div>
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Stock Minimo</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i>Gs</i>
                      </span>
                      <input type="number" class="form-control" name="stock-minimo" value="<?php echo remove_junk($product['stock_minimo']);?>">
                      
                   </div>
                  </div>
                 </div>
                  <div class="col-md-4">
                   <div class="form-group">
                     <label for="qty">Precio Mayorista</label>
                     <div class="input-group">
                       <span class="input-group-addon">
                         <i>Gs</i>
                       </span>
                       <input type="number" class="form-control" name="precio-mayorista" value="<?php echo remove_junk($product['precio_venta_mayorista']);?>">
                       
                    </div>
                   </div>
                  </div>
               </div>
              </div>

              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                 <label for="qty">Selecione el IVA</label>
                  <select class="form-control" name="product-iva">
                    <option value="">Seleccione el IVA</option>
                      <?php  foreach ($all_iva as $iva): ?>
                    <option value="<?php echo (int)$iva['id']; ?>" <?php if($product['iva'] === $iva['iva']): echo "selected"; endif; ?> >
                      <?php echo remove_junk($iva['porciento']); ?></option>
                    <?php endforeach; ?>
                 </select> 
                 </div>
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty"></label>
                    
                  </div>
                 </div>
                  <div class="col-md-4">
                   <div class="form-group">
                     <label for="qty">Precio Cantina</label>
                     <div class="input-group">
                       <span class="input-group-addon">
                         <i>Gs</i>
                       </span>
                       <input type="number" class="form-control" name="precio-cantina" value="<?php echo remove_junk($product['precio_venta_cantina']);?>">
                       
                    </div>
                   </div>
                  </div>
               </div>
              </div>
              <button type="submit" name="product" class="btn btn-danger">Actualizar</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
