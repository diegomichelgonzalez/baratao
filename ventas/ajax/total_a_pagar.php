<?php
	/*-------------------------
	Autor: Ing. Diego Gonzalez
	---------------------------*/
session_start();
$session_id= session_id();

	/* Connexion a la base de datos*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	

?>


<?php
	$sumador_total=0;
	$sql=mysqli_query($con, "select * from productos, tmp where productos.id=tmp.id_producto and tmp.session_id='".$session_id."'");
	if(!$sql){
		var_dump(mysqli_error($con));
		exit;
	}
	while ($row=mysqli_fetch_array($sql))
	{
		if(!$row){
			var_dump(mysqli_error($sql));
			exit;
		}
	$id_tmp=$row["id_tmp"];
	$codigo_producto=$row['codigo_barra'];
	$cantidad=$row['cantidad_tmp'];
	$nombre_producto=$row['descripcion'];
	$precio_venta=$row['precio_tmp'];
	$precio_venta_f=number_format($precio_venta,0);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,0);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador

	}
	echo json_encode($sumador_total);

?>

			