<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
.pumpkin{
	background:#d35400;
	padding: 4px 4px 4px;
	color:white;
	font-weight:bold;
	font-size:12px;
}
.silver{
	background:#bdc3c7;
	padding: 3px 4px 3px;
}
.clouds{
	background:#ecf0f1;
	padding: 3px 4px 3px;
}
.border-top{
	border-top: solid 1px #bdc3c7;
	
}
.border-left{
	border-left: solid 1px #bdc3c7;
}
.border-right{
	border-right: solid 1px #bdc3c7;
}
.border-bottom{
	border-bottom: solid 1px #bdc3c7;
}

table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
}
-->
</style>
<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
        <page_footer>
        <table class="page_footer">
            <tr>

                <td style="width: 50%; text-align: left">
                    P&aacute;gina [[page_cu]]/[[page_nb]]
                </td>
                <td style="width: 50%; text-align: right">
                    &copy; <?php echo "NelTecSoluction "; echo  $anio=date('Y'); ?>
                </td>
            </tr>
        </table>
    </page_footer>
    <table cellspacing="0" style="width: 100%;">
        <tr>

            <td  style="width: 25%; color: #444444;">
                <img style="width: 100%;" src="../../img/logo.jpg" alt="Logo"><br>
                
            </td>
			<td style="width: 75%;text-align:right;font-size:24px;color:#2c3e50">
			TICKET Nº <?php echo $numero_ticket;?>
			</td>
			
        </tr>
    </table>
    <br>
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
		<tr>
			<td class='pumpkin' style="width:45%; ">Cliente</td>
			<td  style="width:10%; "></td>
			<td class='pumpkin' style="width:45%; ">Comercial</td>
		</tr>
		<tr>
			<td style="width:45%; ">
				<?php echo $rw_proveedor['nombre']?><br>
				Dirección: <?php echo $rw_proveedor['direccion']?><br> 
				Teléfono: <?php echo $rw_proveedor['celular1']?><br>
			</td>
			<td  style="width:10%; "></td>
			<td style="width:45%; ">
				<?php echo $rw_perfil['nombre_comercial']; ?><br>
				Nº Documento:<?php echo $rw_proveedor['cedula_ruc']?>
				Dirección:<?php echo $rw_perfil['direccion']; ?><br>
				Teléfono: <?php echo $rw_perfil['telefono']; ?><br>
				Email: <?php echo $rw_perfil['email']; ?>
			</td>
			
		</tr>
	</table>
	<br>
	<table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
		<tr>
			<td class='pumpkin' style="width:33%; ">Nº Documento</td>
			<td class='pumpkin' style="width:34%; ">CONDICIONES DE PAGO</td>
			<td class='pumpkin' style="width:33%; text-align:right ">FECHA</td>
		</tr>
		<tr>
			<td style="width:33%; ">
				<?php echo $rw_proveedor['cedula_ruc']?>
			</td>
			<td style="width:34%; ">
				<?php echo $condiciones;?>
			</td>
			<td  style="width:33%; text-align:right"><?php echo date("d-m-Y");?></td>
		</tr>
	</table>
	

	<br>
   
    
       
  
    <table cellspacing="0" style="width: 100%; border: solid 0px #7f8c8d; text-align: center; font-size: 10pt;padding:1mm;">
        <tr >
            <th class="pumpkin" style="width: 14% ">CODIGO</th>
			<th class="pumpkin" style="width: 7% ">CANT.</th>
            <th class="pumpkin" style="width: 55%">DESCRIPCION</th>
            <th class="pumpkin" style="width: 14%;text-align:right">PRECIO UNIT.</th>
            <th class="pumpkin" style="width: 10%;text-align:right">TOTAL</th>
            
        </tr>
   
<?php
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

	?>
        <tr>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: center"><?php echo $codigo_producto; ?></td>
			<td class='<?php echo $clase;?>' style="width: 7%; text-align: center"><?php echo $cantidad; ?></td>
            <td class='<?php echo $clase;?>' style="width: 55%; text-align: left"><?php echo $nombre_producto;?></td>
            <td class='<?php echo $clase;?>' style="width: 14%; text-align: right"><?php echo $precio_venta_f;?></td>
            <td class='<?php echo $clase;?>' style="width: 10%; text-align: right"><?php echo $precio_total_f;?></td>  
        </tr>
	<?php 
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
	$ganancia=$total_neto-$total_costo

	?>
	</table>
    <table cellspacing="0" style="width: 100%; border: solid 0px black; background: white; font-size: 11pt;padding:1mm;">
        <tr>
			<th style="width: 25%; text-align: right;"></th>
			<th style="width: 25%; text-align: right;"></th>
            <th style="width: 25%; text-align: right;">SUBTOTAL :</th>
            <th style="width: 25%; text-align: right;"><?php echo number_format($total_neto,0);?></th>
        </tr>
		<tr>
			<th style="width: 25%; text-align: right;">-</th>
			<th style="width: 25%; text-align: right;">-</th>
            <th style="width: 25%; text-align: right;">-</th>
            <th style="width: 25%; text-align: right;">-</th>
        </tr>
		<tr>
			<th style="width: 35%; text-align: right;">Liquidación de IVA 5%:&nbsp;   <?php echo number_format($liqui_iva5);?>  </th>
            <th style="width: 35%; text-align: right;">Liquidación de IVA 10%:&nbsp;   <?php echo number_format($liqui_iva10);?></th>
            <th style="width: 30%; text-align: right;">Total IVA:&nbsp; <?php echo number_format($total_iva,0);?></th>
        </tr>
    </table>
	
	
	<br>
	  

</page>

<?php
$date=date("Y-m-d H:i:s");
$estado=0;
$insert=mysqli_query($con,"INSERT INTO caja_encabezado VALUES ('','$numero_ticket','','$id_user','$proveedor','$total_neto','$date','','$ruc','','$exentas','$iva5','$iva10','$liqui_iva5','$liqui_iva10','$total_iva','$estado','$transporte','$comentarios','','','$total_costo','$ganancia','','$condiciones','')");
//$insert=mysqli_query($con,"INSERT INTO caja_encabezado VALUES ('','$numero_pedido','','$id_user','$proveedor','$total_neto','$date','','$ruc','','$exentas','$iva5','$iva10','$liqui_iva5','$liqui_iva10','$total_iva','$estado','','','','','','','')");
$delete=mysqli_query($con,"DELETE FROM tmp WHERE session_id='".$session_id."'");
?>