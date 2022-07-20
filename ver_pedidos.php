<?php
  $page_title = 'Pedidos Pendientes';//titulo de la pagina
  require_once('includes/load.php');//llamos a todos los includes
    page_require_level(3);// nivel de susario
?>
<?php
$sales = pedidos_activos();//llamo a la funcion sql donce hace la consulta de los pedidos pendientes
?>
<?php 
  include_once('layouts/header.php'); //llamo al encabezado 
?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Pedidos pendientes</span>
          </strong>
          
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th class="text-center" style="width: 15%;"> Nº de Ticket</th>
                <th> Nombre del Cliente </th>
                <th class="text-center" style="width: 15%;"> Total </th>
                <th class="text-center" style="width: 15%;"> Fecha </th>
               <th class="text-center" style="width: 100px;"> Acciones </th>
             </tr>
            </thead>
           <tbody>
             <?php foreach ($sales as $sale):?>
             <tr>
               <td class="text-center"><?php echo count_id();?></td>
               <td class="text-center"><?php echo (int)$sale['tickets']; ?></td>
               <td><?php echo remove_junk($sale['nombre']); ?></td>
               <td class="text-center"><?php echo remove_junk($sale['total']); ?></td>
               <td class="text-center"><?php echo $sale['fecha']; ?></td>
               <td class="text-center">
                  <div class="btn-group">
                     <a href="ticket/index-copy.php?ticket=<?php echo (int)$sale['tickets'];?>" class="btn btn-warning btn-xs"  title="Imprimir" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-print"></span>
                     </a>
                     <a href="confirmar_pedido.php?ticket=<?php echo (int)$sale['tickets'];?>" class="btn btn-danger btn-xs"  title="Confirmar" data-toggle="tooltip">
                       <span class="glyphicon glyphicon glyphicon-ok"></span>
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
<?php include_once('layouts/footer.php');//pie de pagina ?>
