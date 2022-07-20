<?php
	/*-------------------------
	Autor: Ing. Diego Gonzalez
	---------------------------*/
    session_start();
    $session_id= session_id();
    

	/* Connexion a la base de datos*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$sumador_total=0;//inicializo el Total

	$exentas=0;//inicializo el total en exentas
	$iva5=0;//inicializo el total en iva 5%
	$iva10=0;//inicializo el total en iva 10%
	
	$liqui_iva5=0;//inicializo la liquidacion de iva 5%
	$liqui_iva10=0;//inicializo la liquidacion de iva 10%
	//en la siguiente lienea hago una consulta a mi base de datos
	$sql=mysqli_query($con, "select * from productos, tmp where productos.id=tmp.id_producto and tmp.session_id='".$session_id."'");
	if(!$sql){//si la consulta esta vacia entoces lanza un error y termina la operacion
		var_dump(mysqli_error($con));
		exit;
	}


	while ($row=mysqli_fetch_array($sql))//pero si no esta vacio busca fila por fila
	{
		if(!$row){//si la fila esta vacia entoces lanza un error y termina la operacion
			var_dump(mysqli_error($sql));
			exit;
		}
	//pero si no esta vacio entoces obtiene los datos de cada fila
	$id_tmp=$row["id_tmp"];//OBTENGO EL ID DEL TMPORAL
	$codigo_producto=$row['codigo_barra'];//OBTENGO EL CODIGO DE BARRA DEL PRODUCTO
	$cantidad=$row['cantidad_tmp'];//OBTENGO LA CANTIDAD A VENDER
	$nombre_producto=$row['descripcion'];//OBTENGO LA DESCRIPCION DEL PRODUCTO
	$precio_venta=$row['precio_tmp'];//OBTENGO EL PRECIO DEL PRODUCTO
	$iva=$row['iva'];//OBTENGO EL IVA DEL PRODUCTO
	$precio_venta_f=number_format($precio_venta,0);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,0);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador
	
		
	}
	
	//aqui comienza el calculo del vuelto
	
    $efectivo = $_POST['efectivo'];//obtenemos el efectivo entregado
    $total=$sumador_total;//obtenemos el total general
    $resta= $efectivo-$total;
    
    
    
echo $efectivo;
?>

