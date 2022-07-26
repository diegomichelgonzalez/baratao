<?php
  $page_title = 'Lista de marcas';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  
  $all_categories = find_all('marcas')
?>
<?php
 if(isset($_POST['insertar_marca'])){
   $req_field = array('marcas-name');
   validate_fields($req_field);
   $cat_name = remove_junk($db->escape($_POST['marcas-name']));
   if(empty($errors)){
      $sql  = "INSERT INTO marcas (marcas)";
      $sql .= " VALUES ('{$cat_name}')";
      if($db->query($sql)){
        $session->msg("s", "Marca agregada exitosamente.");
        redirect('marcas.php',false);
      } else {
        $session->msg("d", "Lo siento, registro falló");
        redirect('marcas.php',false);
      }
   } else {
     $session->msg("d", $errors);
     redirect('marcas.php',false);
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
    <div class="col-md-5">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Agregar Marca</span>
         </strong>
        </div>
        <div class="panel-body">
          <form method="post" action="marcas.php">
            <div class="form-group">
                <input type="text" class="form-control" name="marcas-name" placeholder="Nombre de la Marca" required>
            </div>
            <button type="submit" name="insertar_marca" class="btn btn-primary">Agregar Marca</button>
        </form>
        </div>
      </div>
    </div>
    <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Lista de Marcas</span>
       </strong>
      </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">#</th>
                    <th>Marcas</th>
                    <th class="text-center" style="width: 100px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($all_categories as $cat):?>
                <tr>
                    <td class="text-center"><?php echo count_id();?></td>
                    <td><?php echo remove_junk(ucfirst($cat['marcas'])); ?></td>
                    <td class="text-center">
                      <div class="btn-group">
                        <a href="editar_marcas.php?id=<?php echo (int)$cat['id'];?>"  class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                          <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        <a href="eliminar_marcas.php?id=<?php echo (int)$cat['id'];?>"  class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar">
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
  </div>
  <?php include_once('layouts/footer.php'); ?>
