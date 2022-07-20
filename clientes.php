<?php
  $page_title = 'Lista de Clientes';
  require_once('includes/load.php');
?>
<?php
// Checkin What level user has permission to view this page
 page_require_level(1);
//pull out all user form database
 $all_users = todos_los_clientes();
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Clientes</span>
       </strong>
         <a href="insertar_cliente.php" class="btn btn-info pull-right">Agregar Cliente</a>
      </div>
     <div class="panel-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center" style="width: 50px;">#</th>
            <th class="text-center">Nº Documento </th>
            <th class="text-center">Nombre </th>
            <th class="text-center">Apellido</th>
            <th class="text-center" style="width: 15%;">Dirección</th>
            <th class="text-center" style="width: 10%;">1er Celular</th>
            <th class="text-center" style="width: 10%;">2do Celular</th>
            <th class="text-center" style="width: 100px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($all_users as $a_user): ?>
          <tr>
           <td class="text-center"><?php echo count_id();?></td>
           <td><?php echo remove_junk(ucwords($a_user['cedula_ruc']))?></td>
           <td><?php echo remove_junk(ucwords($a_user['nombre']))?></td>
           <td><?php echo remove_junk(ucwords($a_user['apellido']))?></td>
           <td><?php echo remove_junk(ucwords($a_user['direccion']))?></td>
           <td><?php echo remove_junk($a_user['celular1'])?></td>
           <td><?php echo remove_junk($a_user['celular2'])?></td>
           <td class="text-center">
             <div class="btn-group">
                <a href="editar_cliente.php?id=<?php echo (int)$a_user['id'];?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                  <i class="glyphicon glyphicon-pencil"></i>
               </a>
                <a href="eliminar_cliente.php?id=<?php echo (int)$a_user['id'];?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar">
                  <i class="glyphicon glyphicon-remove"></i>
                </a>
                </div>
           </td>
          </tr>
        <?php endforeach;?>
       </tbody>
     </table>
     </div>
    </div>
  </div>
</div>
  <?php include_once('layouts/footer.php'); ?>
