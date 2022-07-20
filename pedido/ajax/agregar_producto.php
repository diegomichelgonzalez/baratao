<?php
	/*-------------------------
	Autor: Ing. Diego Gonzalez
	---------------------------*/
session_start();
$session_id= session_id();
if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['cantidad'])){$cantidad=$_POST['cantidad'];}
if (isset($_POST['precio_venta'])){$precio_venta=$_POST['precio_venta'];}

	/* Connexion a la base de datos*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
if (!empty($id) and !empty($cantidad) and !empty($precio_venta))//si ninguno de los campos otenidos no estan vacios entoces guarda los datos
{
$insert_tmp=mysqli_query($con, "INSERT INTO tmp_pedido (id_producto,cantidad_tmp,precio_tmp,session_id) VALUES ('$id','$cantidad','$precio_venta','$session_id')");
}
if (isset($_GET['id']))//codigo elimina un elemento del array
{
	$id=intval($_GET['id']);
$delete=mysqli_query($con, "DELETE FROM tmp WHERE id_tmp='".$id."'");
}

?>
<table class="table">
<tr>
	<th>CODIGO</th>
	<th>CANT.</th>
	<th>DESCRIPCION</th>
	<th><span class="pull-right">PRECIO UNIT.</span></th>
	<th><span class="pull-right">PRECIO TOTAL</span></th>
	<th></th>
</tr>
<?php
	$sumador_total=0;//inicializo el Total

	$exentas=0;//inicializo el total en exentas
	$iva5=0;//inicializo el total en iva 5%
	$iva10=0;//inicializo el total en iva 10%
	
	$liqui_iva5=0;//inicializo la liquidacion de iva 5%
	$liqui_iva10=0;//inicializo la liquidacion de iva 10%
	//en la siguiente lienea hago una consulta a mi base de datos
	$sql=mysqli_query($con, "select * from productos, tmp_pedido where productos.id=tmp_pedido.id_producto and tmp_pedido.session_id='".$session_id."'");
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
	
		if($iva==0){//si el iva es exentas carga el total en la columna Exentas 
			?>
			<tr>
				<td><?php echo $codigo_producto;?></td>
				<td><?php echo $cantidad;?></td>
				<td><?php echo $nombre_producto?></td>
				<td><span class="pull-right"><?php echo $precio_venta_f;?></span></td>
				<td><span class="pull-right"><?php echo $precio_total_f;?></span></td>
				<td ><span class="pull-right"><a href="#" onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></span></td>
			</tr>		
			<?php
			$exentas=$exentas+$precio_total;
			
		}

		if($iva==21){//si el iva es 5% carga el total en la columna 5%
			?>
			<tr>
				<td><?php echo $codigo_producto;?></td>
				<td><?php echo $cantidad;?></td>
				<td><?php echo $nombre_producto?></td>
				<td><span class="pull-right"><?php echo $precio_venta_f;?></span></td>
				<td><span class="pull-right"><?php echo $precio_total_f;?></span></td>
				<td ><span class="pull-right"><a href="#" onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></span></td>
			</tr>		
			<?php
			$iva5=$iva5+$precio_total;
			$liqui_iva5=$iva5/21;
			
		}

		if($iva==11){//si el iva es 10% carga el total en la columna 10%
			?>
			<tr>
				<td><?php echo $codigo_producto;?></td>
				<td><?php echo $cantidad;?></td>
				<td><?php echo $nombre_producto?></td>
				<td><span class="pull-right"><?php echo $precio_venta_f;?></span></td>
				<td><span class="pull-right"><?php echo $precio_total_f;?></span></td>
				<td ><span class="pull-right"><a href="#" onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></span></td>
			</tr>		
			<?php
			$iva10=$iva10+$precio_total;
			$liqui_iva10=$iva10/11;
		}
	}
	$total_iva=$liqui_iva5+$liqui_iva10;

?>

<tr>

	<td colspan = 4><span  class="pull-right">TOTAL</span></td>
	<td><span class="pull-right"><?php echo number_format($sumador_total,0);?></span></td>
	<td></td>
</tr>

</table>
			