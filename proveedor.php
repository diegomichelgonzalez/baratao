<?php
  $page_title = 'Lista de Proveedores';
  require_once('includes/load.php');
?>
<?php
// nivel de acceso a la pagina
 page_require_level(1);
//mostrar todos los proveedores
 $proveedores = todos_los_proveedores();
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
          <span>Proveedores</span>
       </strong>
         <a href="insertar_proveedor.php" class="btn btn-info pull-right">Agregar Proveedor</a>
      </div>
     <div class="panel-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center" style="width: 50px;">#</th>
            <th class="text-center">Proveedor </th>
            <th class="text-center">RUC</th>
            <th class="text-center" style="width: 15%;">Dirección</th>
            <th class="text-center" style="width: 10%;">1er Telefono</th>
            <th class="text-center" style="width: 10%;">2do Telefono</th>
            <th class="text-center" style="width: 10%;">Correo</th>
            <th class="text-center" style="width: 100px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($proveedores as $a_proveedores): ?>
          <tr>
           <td class="text-center"><?php echo count_id();?></td>
           <td><?php echo remove_junk(ucwords($a_proveedores['nombre']))?></td>
           <td><?php echo remove_junk(ucwords($a_proveedores['ruc']))?></td>
           <td><?php echo remove_junk(ucwords($a_proveedores['direccion']))?></td>
           <td><?php echo remove_junk($a_proveedores['telefono1'])?></td>
           <td><?php echo remove_junk($a_proveedores['telefono2'])?></td>
           <td><?php echo remove_junk(ucwords($a_proveedores['correo']))?></td>
           <td class="text-center">
             <div class="btn-group">
                <a href="editar_proveedor.php?id=<?php echo (int)$a_proveedores['id'];?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                  <i class="glyphicon glyphicon-pencil"></i>
               </a>
                <a href="eliminar_proveedor.php?id=<?php echo (int)$a_proveedores['id'];?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar">
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
