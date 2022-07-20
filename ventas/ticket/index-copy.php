<?php
 ob_start();
 session_start();
  //require_once ("../conexion.php");
  	/* Connexion a la base de datos*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
   
  //$usuario=$_SESSION['login_user_sys']; 
  $id_user = $_SESSION['user_id'];
  //Variables por GET
	$nro_ticket=intval($_GET['ticket']);
  $consulta="SELECT *from vista_ticket where tickets='$nro_ticket'";
  // $query = mysqli_query($con,$consulta);
   $nombre="";
   if ($res = mysqli_query($con, $consulta)) {
     
     if (mysqli_num_rows($res) > 0) {
         if($row = mysqli_fetch_array($res)) {
             
         
             
         }
     
         mysqli_free_result($res);
     }
     else {
         echo "NO hay resultados.";
     }
 }
 else {
     echo "ERROR: No puede ejecutar  $sql. ".mysqli_error($con);
 }

?>

<!DOCTYPE html>
<html lang="es">
<html>
    <head>
   
        <link rel="stylesheet" href="estilo.css">
        <script src="ticket.js"></script>
    </head>
    <body>
    <div class="ticket">

            <!--<img
                src="logo.bmp"
                alt="Logotipo">-->
            
           <!--<?php //date_default_timezone_set("America/Asuncion"); ?>
            <?php //$fecha = date('d/m/Y',strtotime($row['fechax'].'- 1 month')); ?>
             <?php// $fecha2 = date('M',strtotime($row['fechax'].'- 2 month')); ?>-->
            <p class="centrado"><br>BARATAO</p>
            <p class="justificado">Ticket Nº: <?php echo $row['tickets'];?>  </p>
            <p class="justificado">Fecha: <?php echo $row['fecha'];?>  </p>
            <p class="justificado">CLIENTE: <?php echo $row['nombre'];?>  </p>
            <table>
                <thead>
                    <tr>
                        <th class="producto">DESCRIPCIÒN</th>
                        <th class="cantidad"> Cant</th>
                        <th class="precio"> STotal</th>
                    </tr>
                    <tr>
                        <td colspan="3">-------------------------------------------------------</td>
                    </tr>
                   
                </thead>
                <tbody>
                    
                <?php 
                $descripcion;//OBTENGO LA DESCRIPCION DEL PRODUCTO
                $cantidad;//OBTENGO EL SUBTOTAL
                $subtotal;//OBTENGO EL SUBTOTAL
                $sql=mysqli_query($con, "SELECT *from vista_ticket where tickets='$nro_ticket'");
                    while ($row=mysqli_fetch_array($sql)){
                        $descripcion=$row["descripcion"];//OBTENGO LA DESCRIPCION DEL PRODUCTO
                        $cantidad=$row["cantidad"];//OBTENGO la cantidad
                        $subtotal=$row["subtotal"];//OBTENGO EL SUBTOTAL
                        $total=$row["total"];//OBTENGO EL TOTAL
                ?>
                    <tr>
                        <td class="producto"><?php echo $descripcion;?></td>
                        <td class="centrado"><?php echo $cantidad;?></td>
                        <td class="precio"><?php echo $subtotal;?></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
                <tfooter>
                    <tr>
                        <td colspan="3">-------------------------------------------------------</td>
                    </tr>
                    <tr><td class="producto">Total</td>
                        <td class="cantidad"></td>
                        <td class="precio"><?php echo $total;?></td>
                        
                    </tr>
                </tfooter>
            </table>
            <p class="centrado">*************************************</p>
            <p class="centrado">GRACIAS POR SU COMPRA
            </p>
           
                <button class="oculto-impresion" id="btnImprimir" onclick="imprimir()">Imprimir</button>
   </div>
 
    </body>
    <script type="text/javascript">
        window.onload = imprimir();
    </script>
</html>