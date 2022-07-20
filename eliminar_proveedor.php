<?php
  require_once('includes/load.php');
  // nivel de acceso
   page_require_level(1);
?>
<?php
  $delete_id = delete_by_id('proveedor',(int)$_GET['id']);
  if($delete_id){
      $session->msg("s","Proveedor Eliminado");
      redirect('proveedor.php');
  } else {
      $session->msg("d","Se ha producido un error al eliminar el Proveedor");
      redirect('proveedor.php');
  }
?>
