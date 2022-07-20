<?php
  require_once('includes/load.php');
  // nivel de acceso
   page_require_level(1);
?>
<?php
  $delete_id = delete_by_id('clientes',(int)$_GET['id']);
  if($delete_id){
      $session->msg("s","Cliente Eliminado");
      redirect('clientes.php');
  } else {
      $session->msg("d","Se ha producido un error al eliminar el Cliente");
      redirect('clientes.php');
  }
?>
