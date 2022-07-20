<?php
  $page_title = 'Confirmar Pedidos';
  require_once('includes/load.php');
  // nivel de acceso
  page_require_level(1);
?>
<?php
  //.
  $categorie = $_GET['ticket'];
  if(!$categorie){
    
    $session->msg("d","Falta el Nº de ticket");
    redirect('ver_pedidos.php');
  }
?>

<?php

  if(empty($errors)){
        $sql = "UPDATE caja_encabezado SET estado=0";
       $sql .= " WHERE tickets='$categorie'";
     $result = $db->query($sql);
     if($result && $db->affected_rows() === 1) {
       $session->msg("s", "Pedido confirmado con éxito.");
       redirect('ver_pedidos.php',false);
     } else {
       $session->msg("d", "Lo siento, algo falló al confirmar el pedido.");
       redirect('ver_pedidos.php',false);
     }
  } else {
    $session->msg("d", $errors);
    redirect('ver_pedidos.php',false);
  }

?>