<?php
  $page_title = 'Editar Marcas';
  require_once('includes/load.php');
  // nivel de acceso
  page_require_level(1);
?>
<?php
  //.
  $categorie = find_by_id('marcas',(int)$_GET['id']);
  if(!$categorie){
    $session->msg("d","Falta el ID de la Marca");
    redirect('marcas.php');
  }
?>

<?php
if(isset($_POST['editar_marcas'])){
  $req_field = array('marcas-name');
  validate_fields($req_field);
  $cat_name = remove_junk($db->escape($_POST['marcas-name']));
  if(empty($errors)){
        $sql = "UPDATE marcas SET marcas='{$cat_name}'";
       $sql .= " WHERE id='{$categorie['id']}'";
     $result = $db->query($sql);
     if($result && $db->affected_rows() === 1) {
       $session->msg("s", "Marca actualizada con éxito.");
       redirect('marcas.php',false);
     } else {
       $session->msg("d", "Lo siento, actualización falló.");
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
   <div class="col-md-5">
     <div class="panel panel-default">
       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Editando <?php echo remove_junk(ucfirst($categorie['marcas']));?></span>
        </strong>
       </div>
       <div class="panel-body">
         <form method="post" action="editar_marcas.php?id=<?php echo (int)$categorie['id'];?>">
           <div class="form-group">
               <input type="text" class="form-control" name="marcas-name" value="<?php echo remove_junk(ucfirst($categorie['marcas']));?>">
           </div>
           <button type="submit" name="editar_marcas" class="btn btn-primary">Actualizar Marca</button>
       </form>
       </div>
     </div>
   </div>
</div>



<?php include_once('layouts/footer.php'); ?>
