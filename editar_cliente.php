<?php
  $page_title = 'Editar Cliente';
  require_once('includes/load.php');
  // nivel de permiso
   page_require_level(1);
?>
<?php
  $e_cliente = find_by_id('clientes',(int)$_GET['id']);
  $groups  = find_all('user_groups');
  if(!$e_cliente){
    $session->msg("d","Falta la identificación del Cliente");
    redirect('clientes.php');
  }
?>

<?php
//Actualizar la información básica del Cliente
  if(isset($_POST['update'])) {
    $req_fields = array('cedula-ruc','nombre','apellido','direccion','celular1','celular2');
    validate_fields($req_fields);
    if(empty($errors)){
      $id=$_GET['id'];
      $cedula   = remove_junk($db->escape($_POST['cedula-ruc']));
      $nombre   = remove_junk($db->escape($_POST['nombre']));
      $apellido   = remove_junk($db->escape($_POST['apellido']));
      $direccion   = remove_junk($db->escape($_POST['direccion']));
      $celular1   = remove_junk($db->escape($_POST['celular1']));
      $celular2   = remove_junk($db->escape($_POST['celular2']));

        $sql = "UPDATE clientes SET cedula_ruc ='{$cedula}', nombre ='{$nombre}', apellido ='{$apellido}',direccion='{$direccion}',celular1='{$celular1}',celular2='{$celular2}' WHERE id='{$db->escape($id)}'";
        $result = $db->query($sql);
          if($result && $db->affected_rows() === 1){
            $session->msg('s',"Cliente actualizada ");
            redirect('editar_cliente.php?id='.(int)$e_cliente['id'], false);
          } else {
            $session->msg('d',' Lo siento no se actualizó los datos.'.$_GET['id'].$_POST['cedula-ruc'].$_POST['nombre'].$_POST['apellido'].$_POST['direccion'].$_POST['celular1'].$_POST['celular2']);
            redirect('editar_cliente.php?id='.(int)$e_cliente['id'], false);
            echo $_POST['cedula-ruc'];
          }
    } else {
      $session->msg("d", $errors);
      redirect('editar_cliente.php?id='.(int)$e_cliente['id'],false);
    }
  }
?>
<?php
// Update user password
if(isset($_POST['update-pass'])) {
  $req_fields = array('password');
  validate_fields($req_fields);
  if(empty($errors)){
           $id = (int)$e_cliente['id'];
     $password = remove_junk($db->escape($_POST['password']));
     $h_pass   = sha1($password);
          $sql = "UPDATE users SET password='{$h_pass}' WHERE id='{$db->escape($id)}'";
       $result = $db->query($sql);
        if($result && $db->affected_rows() === 1){
          $session->msg('s',"Se ha actualizado la contraseña del usuario. ");
          redirect('editar_cliente.php?id='.(int)$e_cliente['id'], false);
        } else {
          $session->msg('d','No se pudo actualizar la contraseña de usuario..');
          redirect('editar_cliente.php?id='.(int)$e_cliente['id'], false);
        }
  } else {
    $session->msg("d", $errors);
    redirect('editar_cliente.php?id='.(int)$e_cliente['id'],false);
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
          Actualizar Cliente <?php echo remove_junk(ucwords($e_cliente['nombre'])); ?>
        </strong>
       </div>
       <div class="panel-body">
          <form method="post" action="editar_cliente.php?id=<?php echo (int)$e_cliente['id'];?>" class="clearfix">
            <div class="form-group">
              <label for="cedula-ruc">Cedula/ruc</label>
              <input type="text" class="form-control" name="cedula-ruc" value="<?php echo remove_junk(ucwords($e_cliente['cedula_ruc'])); ?>">
            </div>
            <div class="form-group">
              <label for="nombre">Nombre</label>
              <input type="text" class="form-control" name="nombre" value="<?php echo remove_junk(ucwords($e_cliente['nombre'])); ?>">
            </div>
            <div class="form-group">
              <label for="apellido">Apellido</label>
              <input type="text" class="form-control" name="apellido" value="<?php echo remove_junk(ucwords($e_cliente['apellido'])); ?>">
            </div>
            <div class="form-group">
              <label for="direccion">Dirección</label>
              <input type="text" class="form-control" name="direccion" value="<?php echo remove_junk(ucwords($e_cliente['direccion'])); ?>">
            </div>
            <div class="col-md-6">
            <div class="form-group">
              <label for="celular1">1er Celular</label>
              <input type="text" class="form-control" name="celular1" value="<?php echo remove_junk(ucwords($e_cliente['celular1'])); ?>">
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
              <label for="celular2">2do Celular</label>
              <input type="text" class="form-control" name="celular2" value="<?php echo remove_junk(ucwords($e_cliente['celular2'])); ?>">
            </div>
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
