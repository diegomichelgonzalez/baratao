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
	$sql_count=mysqli_query($con,"select * from tmp where session_id='".$session_id."'");
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
	//Fin de variables por GET
	
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
    
     include(dirname('__FILE__').'/res/pedido_html.php');
    $content = ob_get_clean();

    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        // send the PDF
        $html2pdf->Output('Cotizacion.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
