<?php
  $page_title = 'Editar Proveedor';
  require_once('includes/load.php');
  // nivel de permiso
   page_require_level(1);
?>
<?php
  $e_proveedor = find_by_id('proveedor',(int)$_GET['id']);
  //$groups  = find_all('user_groups');
  if(!$e_proveedor){
    $session->msg("d","Falta la identificación del Proveedor");
    redirect('proveedor.php');
  }
?>

<?php
//Actualizar la información básica del Cliente
  if(isset($_POST['update'])) {
    $req_fields = array('proveedor','ruc','direccion','telefono1','telefono2','correo');
    validate_fields($req_fields);
    if(empty($errors)){
      $id=$_GET['id'];
      $proveedor   = remove_junk($db->escape($_POST['proveedor']));
      $ruc   = remove_junk($db->escape($_POST['ruc']));
      $direccion   = remove_junk($db->escape($_POST['direccion']));
      $telefono1   = remove_junk($db->escape($_POST['telefono1']));
      $telefono2   = remove_junk($db->escape($_POST['telefono2']));
      $correo   = remove_junk($db->escape($_POST['correo']));

        $sql = "UPDATE proveedor SET nombre ='{$proveedor}', ruc ='{$ruc}',direccion='{$direccion}',telefono1='{$telefono1}',telefono2='{$telefono2}', correo ='{$correo}' WHERE id='{$db->escape($id)}'";
        $result = $db->query($sql);
          if($result && $db->affected_rows() === 1){
            $session->msg('s',"Proveedor actualizado ");
            redirect('editar_proveedor.php?id='.(int)$e_proveedor['id'], false);
          } else {
            $session->msg('d',' Lo siento no se actualizó los datos.');
            redirect('editar_proveedor.php?id='.(int)$e_proveedor['id'], false);
            echo $_POST['cedula-ruc'];
          }
    } else {
      $session->msg("d", $errors);
      redirect('editar_proveedor.php?id='.(int)$e_proveedor['id'],false);
    }
  }
?>

<?php include_once('layouts/header.php'); ?>
 <div class="row">
   <div class="col-md-12"> <?php echo display_msg($msg); ?> </div>
  <div class="col-md-6">
     <div class="panel panel-default">
       <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          Actualizar Cliente <?php echo remove_junk(ucwords($e_proveedor['nombre'])); ?>
        </strong>
       </div>
       <div class="panel-body">
          <form method="post" action="editar_proveedor.php?id=<?php echo (int)$e_proveedor['id'];?>" class="clearfix">
            <div class="form-group">
              <label for="proveedor">Proveedor</label>
              <input type="text" class="form-control" name="proveedor" value="<?php echo remove_junk(ucwords($e_proveedor['nombre'])); ?>">
            </div>
            <div class="form-group">
              <label for="ruc">RUC</label>
              <input type="text" class="form-control" name="ruc" value="<?php echo remove_junk(ucwords($e_proveedor['ruc'])); ?>">
            </div>
            <div class="form-group">
              <label for="direccion">Dirección</label>
              <input type="text" class="form-control" name="direccion" value="<?php echo remove_junk(ucwords($e_proveedor['direccion'])); ?>">
            </div>
            <div class="col-md-6">
            <div class="form-group">
              <label for="telefono1">1er Telefono</label>
              <input type="text" class="form-control" name="telefono1" value="<?php echo remove_junk(ucwords($e_proveedor['telefono1'])); ?>">
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
              <label for="telefono2">2do Telefono</label>
              <input type="text" class="form-control" name="telefono2" value="<?php echo remove_junk(ucwords($e_proveedor['telefono2'])); ?>">
            </div>
            </div>
            <div class="form-group">
              <label for="correo">Correo</label>
              <input type="text" class="form-control" name="correo" value="<?php echo remove_junk(ucwords($e_proveedor['correo'])); ?>">
            </div>
            <div class="form-group clearfix">
                    <button type="submit" name="update" class="btn btn-info">Actualizar</button>
            </div>
        </form>
       </div>
     </div>
  </div>
  

 </div>
<?php include_once('layouts/footer.php'); ?>
