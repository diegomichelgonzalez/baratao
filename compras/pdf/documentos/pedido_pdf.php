<?php
	/*-------------------------
	Autor: Ing. Diego Gonzalez
	---------------------------*/
	 ob_start();
	session_start();
	/* Connect To Database*/
	include("../../config/db.php");
	include("../../config/conexion.php");
	$session_id= session_id();
	$sql_count=mysqli_query($con,"select * from compra_temp where session_id='".$session_id."'");
	$count=mysqli_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('No hay productos agregados a la cotizacion')</script>";
	echo "<script>window.close();</script>";
	exit;
	}

	require_once(dirname(__FILE__).'/../html2pdf.class.php');
		
	//Variables por GET
	$proveedor=intval($_GET['proveedor']);
	$transporte=mysqli_real_escape_string($con,(strip_tags($_REQUEST['transporte'], ENT_QUOTES)));
	$condiciones=mysqli_real_escape_string($con,(strip_tags($_REQUEST['condiciones'], ENT_QUOTES)));
	$comentarios=mysqli_real_escape_string($con,(strip_tags($_REQUEST['comentarios'], ENT_QUOTES)));
	$timbrado=mysqli_real_escape_string($con,(strip_tags($_REQUEST['timbrado'], ENT_QUOTES)));
	$numerofactura=mysqli_real_escape_string($con,(strip_tags($_REQUEST['numerofactura'], ENT_QUOTES)));
	//Fin de variables por GET

	//En la siguiente linea hago una consulta a la BD para obtener el maximo Nº de Ticket 
	$sql2=mysqli_query($con, "select LAST_INSERT_ID(id) as last from compra_encabezado order by id desc limit 0,1 ");
	$rw2=mysqli_fetch_array($sql2);//lo cargo en una variable
	$numero_id=$rw2['last']+1;// le sumo 1 para el siguiente Nº de Ticket
	
	$perfil=mysqli_query($con,"select * from perfil limit 0,1");//Obtengo los datos de la empresa
	$rw_perfil=mysqli_fetch_array($perfil);
	
	$sql_proveedor=mysqli_query($con,"select * from proveedor where id='$proveedor' limit 0,1");//Obtengo los datos del proveedor
	$rw_proveedor=mysqli_fetch_array($sql_proveedor);
    // get the HTML
    
     include(dirname('__FILE__').'/res/pedido_html.php');
    $content = ob_get_clean();

    try
    {
        // inicializar HTML2PDF
        $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        // mostrar la página completa
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convertir
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        // enviar el PDF
        $html2pdf->Output('Cotizacion.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
