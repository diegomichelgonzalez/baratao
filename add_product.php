<?php
  $page_title = 'Agregar producto';
  require_once('includes/load.php');
  // Verifica Qué nivel de usuario tiene permiso para ver esta página
  page_require_level(2);
  $all_iva = find_all('iva');
  $all_marcas = find_all('marcas');
  $all_categories = find_all('categories');
  $all_photo = find_all('media');
  
?>
<?php
 if(isset($_POST['add_product'])){
   $req_fields = array('product-titulo','product-categoria','precio-compra', 'precio-minorista', 'precio-mayorista','precio-cantina', 'stock-minimo','product-stock','product-photo', 'codigo-barra','product-marca','product-iva' );
   validate_fields($req_fields);
   if(empty($errors)){
     $p_name  = remove_junk($db->escape($_POST['product-titulo']));
     $p_cat   = remove_junk($db->escape($_POST['product-categoria']));
     $p_buy   = remove_junk($db->escape($_POST['precio-compra']));
     $p_sale  = remove_junk($db->escape($_POST['precio-minorista']));
	  $p_mayorista  = remove_junk($db->escape($_POST['precio-mayorista']));
    $p_cantina  = remove_junk($db->escape($_POST['precio-cantina']));
    $p_stock_minimo  = remove_junk($db->escape($_POST['stock-minimo']));
    $p_qty   = remove_junk($db->escape($_POST['product-stock']));
     if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
       $media_id = '1';
     } else {
       $media_id = remove_junk($db->escape($_POST['product-photo']));
     }
     $date    = make_date();
     $id_user = $_SESSION['user_id'];
     $p_barra  = remove_junk($db->escape($_POST['codigo-barra']));
     $p_marca  = remove_junk($db->escape($_POST['product-marca']));
     $p_iva  = remove_junk($db->escape($_POST['product-iva']));

     $query  = "INSERT INTO productos (";
     $query .=" descripcion,kcategoria,precio_costo,precio_venta_minorista,precio_venta_mayorista,precio_venta_cantina,stock_minimo,stock,imagen,fecha,id_usuario,codigo_barra,idmarca,iva";
     $query .=") VALUES (";
     $query .=" '{$p_name}', '{$p_cat}', '{$p_buy}', '{$p_sale}', '{$p_mayorista}', '{$p_cantina}', '{$p_stock_minimo}', '{$p_qty}', '{$media_id}', '{$date}', '{$id_user}','{$p_barra}', '{$p_marca}', '{$p_iva}'";
     $query .=")";
     $query .=" ON DUPLICATE KEY UPDATE descripcion='{$p_name}'";
     if($db->query($query)){
       $session->msg('s',"Producto agregado exitosamente. ");
       redirect('add_product.php', false);
     } else {
       $session->msg('d',' Lo siento, registro falló.');
       redirect('product.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('add_product.php',false);
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
  <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Agregar producto</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_product.php" class="clearfix">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-titulo" placeholder="Descripción">
               </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <select class="form-control" name="product-categoria">
                      <option value="">Selecciona una categoría</option>
                    <?php  foreach ($all_categories as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <select class="form-control" name="product-marca">
                      <option value="">Selecciona la Marca</option>
                    <?php  foreach ($all_marcas as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['marcas'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <select class="form-control" name="product-photo">
                      <option value="">Selecciona una imagen</option>
                    <?php  foreach ($all_photo as $photo): ?>
                      <option value="<?php echo (int)$photo['id'] ?>">
                        <?php echo $photo['file_name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i >ST</i>
                     </span>
                     <input type="number" class="form-control" name="product-stock" placeholder="Stock">
                  </div>
                 </div>
                 <div class="col-md-4">
                   <div class="input-group">
                     <span class="input-group-addon">
                       <i>Gs</i>
                     </span>
                     <input type="number" class="form-control" name="precio-compra" placeholder="Precio de compra">
                     
                  </div>
                 </div>
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i>Gs</i>
                      </span>
                      <input type="number" class="form-control" name="precio-minorista" placeholder="Precio Minorista">
                      
                   </div>
                  </div>
               </div>
              </div>
			  
			      <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="bi bi-graph-down">CB</i>
                     </span>
                     <input type="number" class="form-control" name="codigo-barra" placeholder="Código de Barra">
                  </div>
                 </div>
                 <div class="col-md-4">
                   <div class="input-group">
                     <span class="input-group-addon">
                       <i>Gs</i>
                     </span>
                     <input type="number" class="form-control" name="stock-minimo" placeholder="Stock Minimo">
                     
                  </div>
                 </div>
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i>Gs</i>
                      </span>
                      <input type="number" class="form-control" name="precio-mayorista" placeholder="Precio Mayorista">
                      
                   </div>
                  </div>
               </div>
              </div>

              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                   <div class="input-group">
                    <select class="form-control" name="product-iva">
                      <option value="">Selecciona el IVA</option>
                        <?php  foreach ($all_iva as $cat): ?>
                      <option value="<?php echo (int)$cat['iva'] ?>">
                        <?php echo $cat['porciento'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                 </div>
                 <div class="col-md-4">
                   <div class="input-group">
                     
                     
                  </div>
                 </div>
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i>Gs</i>
                      </span>
                      <input type="number" class="form-control" name="precio-cantina" placeholder="Precio Cantina">
                      
                   </div>
                  </div>
               </div>
              </div>
              <button type="submit" name="add_product" class="btn btn-danger" style="  justify-content: space-between; flex-direction: column; display: flex;">Agregar producto</button>
          </form>
         </div>
         
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
