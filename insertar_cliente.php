<?php
  $page_title = 'Agregar Cliente';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  //$groups = find_all('user_groups');
?>
<?php
  if(isset($_POST['add_user'])){

   $req_fields = array('cedula-ruc','nombre','apellido','direccion','celular1','celular2' );
   validate_fields($req_fields);

   if(empty($errors)){
        $cedula   = remove_junk($db->escape($_POST['cedula-ruc']));
        $nombre   = remove_junk($db->escape($_POST['nombre']));
        $apellido   = remove_junk($db->escape($_POST['apellido']));
        $direccion   = remove_junk($db->escape($_POST['direccion']));
        $celular1   = remove_junk($db->escape($_POST['celular1']));
        $celular2   = remove_junk($db->escape($_POST['celular2']));
        
        $query = "INSERT INTO clientes (";
        $query .="cedula_ruc,nombre,apellido,direccion,celular1,celular2";
        $query .=") VALUES (";
        $query .=" '{$cedula}', '{$nombre}', '{$apellido}', '{$direccion}', '{$celular1}', '{$celular2}'";
        $query .=")";
        if($db->query($query)){
          //sucess
          $session->msg('s'," El Cliente fue registrado Exitosamente");
          redirect('insertar_cliente.php', false);
        } else {
          //failed
          $session->msg('d',' No se pudo registrar al Cliente');
          redirect('insertar_cliente.php', false);
        }
   } else {
     $session->msg("d", $errors);
      redirect('insertar_cliente.php',false);
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
          <span>Agregar Cliente</span>
       </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-6">
          <form method="post" action="insertar_cliente.php">
            <div class="form-group">
                <label for="cedula-ruc">Cedula/ruc</label>
                <input type="text" class="form-control" name="cedula-ruc" placeholder="Nº de Cedula o ruc" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre" placeholder="Nombre" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" name="apellido" placeholder="Apellido" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" class="form-control" name ="direccion"  placeholder="Dirección">
            </div>
            <div class="col-md-6">
            <div class="form-group">
                <label for="celular1">1er Celular</label>
                <input type="text" class="form-control" name ="celular1"  placeholder="1er Celular">
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
                <label for="celular2">2do Celular</label>
                <input type="text" class="form-control" name ="celular2"  placeholder="2do Celular">
            </div>
            </div>
            <div class="form-group clearfix">
              <button type="submit" name="add_user" class="btn btn-primary">Guardar</button>
            </div>
        </form>
        </div>

      </div>

    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
