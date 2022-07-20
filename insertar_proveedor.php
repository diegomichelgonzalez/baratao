<?php
  $page_title = 'Agregar Proveedor';
  require_once('includes/load.php');
  // Nivel de acceso a la pagina
  page_require_level(1);
  
?>
<?php
  if(isset($_POST['btnGuardar'])){

   $req_fields = array('proveedor','ruc','direccion','telefono1','telefono2','correo' );
   validate_fields($req_fields);

   if(empty($errors)){
        $proveedor   = remove_junk($db->escape($_POST['proveedor']));
        $ruc   = remove_junk($db->escape($_POST['ruc']));
        $direccion   = remove_junk($db->escape($_POST['direccion']));
        $telefono1   = remove_junk($db->escape($_POST['telefono1']));
        $telefono2   = remove_junk($db->escape($_POST['telefono2']));
        $correo   = remove_junk($db->escape($_POST['correo']));
        
        $query = "INSERT INTO proveedor (";
        $query .="nombre,ruc,direccion,telefono1,telefono2,correo";
        $query .=") VALUES (";
        $query .=" '{$proveedor}', '{$ruc}', '{$direccion}', '{$telefono1}', '{$telefono2}', '{$correo}'";
        $query .=")";
        if($db->query($query)){
          //sucess
          $session->msg('s'," El Proveedor fue registrado Exitosamente");
          redirect('insertar_proveedor.php', false);
        } else {
          //failed
          $session->msg('d',' No se pudo registrar al Proveedor');
          redirect('insertar_proveedor.php', false);
        }
   } else {
     $session->msg("d", $errors);
      redirect('insertar_proveedor.php',false);
   }
 }
?>
<?php include_once('layouts/header.php'); ?>
  <?php echo display_msg($msg); ?>
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Agregar Proveedor</span>
       </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-6">
          <form method="post" action="insertar_proveedor.php">

            <div class="form-group">
                <label for="proveedor">Proveedor</label>
                <input type="text" class="form-control" name="proveedor" placeholder="Proveedor" required>
            </div>
            <div class="form-group">
                <label for="ruc">RUC</label>
                <input type="text" class="form-control" name="ruc" placeholder="RUC" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" class="form-control" name ="direccion"  placeholder="Dirección">
            </div>
            <div class="col-md-6">
            <div class="form-group">
                <label for="telefono1">1er Telefono</label>
                <input type="text" class="form-control" name ="telefono1"  placeholder="1er Telefono">
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
                <label for="telefono2">2do Telefono</label>
                <input type="text" class="form-control" name ="telefono2"  placeholder="2do Telefono">
            </div>
            </div>
            <div class="form-group">
                <label for="correo">Correo</label>
                <input type="text" class="form-control" name ="correo"  placeholder="Correo">
            </div>
            <div class="form-group clearfix">
              <button type="submit" name="btnGuardar" class="btn btn-primary">Guardar</button>
            </div>
        </form>
        </div>

      </div>

    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
