<?php
	/*-------------------------
	Autor: Ing. Diego Gonzalez
	---------------------------*/
	 ob_start();
	session_start();

  if(isset($_POST['guardar'])){

   
        $proveedor   = $_POST['parametroClienteRuc'];
        $condiciones   = $_POST['condiciones'];
        $comentarios   = $_POST['formapago'];
        $transporte = $_POST['moneda'];
        echo "Guardando...";

      		/* Conxion a la Base de Datos*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
    $session_id= session_id();
	

	
	//En la siguiente linea hago una consulta a la BD para obtener el maximo Nº de Ticket 
	$sql=mysqli_query($con, "select LAST_INSERT_ID(tickets) as last from caja_encabezado order by id desc limit 0,1 ");
	$rw=mysqli_fetch_array($sql);//lo cargo en una variable
	$numero_ticket=$rw['last']+1;// le sumo 1 para el siguiente Nº de Ticket

	//En la siguiente linea hago una consulta a la BD para obtener el maximo Nº de Ticket 
	$sql2=mysqli_query($con, "select LAST_INSERT_ID(id) as last from caja_encabezado order by id desc limit 0,1 ");
	$rw2=mysqli_fetch_array($sql2);//lo cargo en una variable
	$numero_id=$rw2['last']+1;// le sumo 1 para el siguiente Nº de Ticket
	
	$perfil=mysqli_query($con,"select * from perfil limit 0,1");//Obtengo los datos de la emprea
	$rw_perfil=mysqli_fetch_array($perfil);
	
	$sql_proveedor=mysqli_query($con,"select * from vista_cliente where id='$proveedor' limit 0,1");//Obtengo los datos del proveedor
	$rw_proveedor=mysqli_fetch_array($sql_proveedor);
    // get the HTML
    

$sumador_total=0;//inicializo el Total
$nums=1;

$exentas=0;//inicializo el total en exentas
$iva5=0;//inicializo el total en iva 5%
$iva10=0;//inicializo el total en iva 10%

$liqui_iva5=0;//inicializo la liquidacion de iva 5%
$liqui_iva10=0;//inicializo la liquidacion de iva 10%

$total_costo=0;//inicializo el total de precio de compra 
$ganancia=0;//inicializo la ganancia
//en la siguiente lienea hago una consulta a mi base de datos
$sql=mysqli_query($con, "select * from productos, tmp where productos.id=tmp.id_producto and tmp.session_id='".$session_id."'");
while ($row=mysqli_fetch_array($sql))
	{
	$id_tmp=$row["id_tmp"];//OBTENGO EL ID DEL TMPORAL
	$id_producto=$row["id_producto"];//OBTENGO EL ID DEL PRODUCTO
	$codigo_producto=$row['codigo_barra'];//OBTENGO EL CODIGO DE BARRA DEL PRODUCTO
	$cantidad=$row['cantidad_tmp'];//OBTENGO LA CANTIDAD A VENDER
	$nombre_producto=$row['descripcion'];//OBTENGO LA DESCRIPCION DEL PRODUCTO
	$precio_venta=$row['precio_tmp'];//OBTENGO EL PRECIO DEL PRODUCTO
	$iva=$row['iva'];//OBTENGO EL IVA DEL PRODUCTO
	$precio_compra=$row['precio_costo'];//OBTENGO EL IVA DEL PRODUCTO
	$precio_venta_f=number_format($precio_venta,0);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,0);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador
	$exentas_detalle=0;//inicializo el total en exentas
	$iva5_detalle=0;//inicializo el total en iva 5%
	$iva10_detalle=0;//inicializo el total en iva 10%
	$subtotal_compra=$cantidad*$precio_compra;//calcula el subtotal del precio de compra por la cantidad
	$total_costo=$total_costo+$precio_compra;
	if ($nums%2==0){
		$clase="silver";
	} else {
		$clase="clouds";
	}
	if($iva==0){//si el iva es exentas suma la variable exentas 
		$exentas_detalle=$exentas_detalle+$precio_total;
		$exentas=$exentas+$precio_total;	
	}
	if($iva==21){//si el iva es 5% suma la variable 5%	
		$iva5_detalle=$iva5_detalle+$precio_total;
		$iva5=$iva5+$precio_total;
		$liqui_iva5=$iva5/21;
	}
	if($iva==11){//si el iva es 10% suma la variable 10%
		$iva10_detalle=$iva10_detalle+$precio_total;
		$iva10=$iva10+$precio_total;
		$liqui_iva10=$iva10/11;
	}


	//Inserta en la tabla caja_detalle de ka BD
	$insert_detail=mysqli_query($con, "INSERT INTO caja_detalle VALUES ('$numero_id','$id_producto','$cantidad','$precio_venta_r','','$precio_total_r','$exentas_detalle','$iva5_detalle','$iva10_detalle','$precio_compra','$subtotal_compra','')");
	$actualizar_stock=mysqli_query($con, "UPDATE productos SET stock = (stock-'$cantidad') where id='$id_producto'");
	$nums++;
}
	$total_neto=number_format($sumador_total,2,'.','');
	$iva=intval($rw_perfil['iva']);
	$total_iva=($total_neto* $iva) / 100;
	$total_iva=number_format($total_iva,0,'.','');
	$sumador_total=$total_neto+$total_iva; 
	$total_iva=$liqui_iva5+$liqui_iva10;
	$id_user = $_SESSION['user_id'];
	$ruc = $rw_proveedor['cedula_ruc'];
	$ganancia=$total_neto-$total_costo;
        date_default_timezone_set ("America/Asuncion");
        $zonahoraria = new DateTime();
        //echo $zonahoraria->format("Y/m/d - H:i:s");
    $date=$zonahoraria->format("Y-m-d H:i:s");
    $estado=0;
    $insert=mysqli_query($con,"INSERT INTO caja_encabezado VALUES ('','$numero_ticket','','$id_user','$proveedor','$total_neto','$date','','$ruc','','$exentas','$iva5','$iva10','$liqui_iva5','$liqui_iva10','$total_iva','$estado','$transporte','$comentarios','','','$total_costo','$ganancia','','$condiciones','')");

    $delete=mysqli_query($con,"DELETE FROM tmp WHERE session_id='".$session_id."'");
  }
?>
<html>
    <head>
        <meta http-equiv="refresh" content="0; url=http://www.barataopy.com/ticket/index-copy.php?ticket=<?php echo $numero_ticket;?>">
    </head>
    <body>
        
    </body>
    
</html>

