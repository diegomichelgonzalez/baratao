<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
?>
<?php
  $categorie = find_by_id('marcas',(int)$_GET['id']);
  if(!$categorie){
    $session->msg("d","Falta el ID de la Marca");
    redirect('marcas.php');
  }
?>
<?php
  $delete_id = delete_by_id('marcas',(int)$categorie['id']);
  if($delete_id){
      $session->msg("s","Marca eliminada");
      redirect('marcas.php');
  } else {
      $session->msg("d","Eliminación falló");
      redirect('marcas.php');
  }
?>
