<?php
	/*-------------------------
	Autor: Ing. Diego Gonzalez
	---------------------------*/
	 ob_start();
	session_start();
	/* Connect To Database*/
	require_once ("../../includes/config.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../../includes/conexion.php");//Contiene funcion que conecta a la base de datos
	$session_id= session_id();
	$id_user = $_SESSION['user_id'];
	$sql_count=mysqli_query($con,"select * from tmp where session_id='".$id_user."'");
	$count=mysqli_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('No hay productos agregados a la cotizacion')</script>";
	echo "<script>window.close();</script>";
	exit;
	}

	require_once(dirname(__FILE__).'/../html2pdf.class.php');
		
	//Variables por GET
	$id_cliente=intval($_GET['parametroClienteRuc']);
	
	$transporte=mysqli_real_escape_string($con,(strip_tags($_REQUEST['transporte'], ENT_QUOTES)));
	$condiciones=mysqli_real_escape_string($con,(strip_tags($_REQUEST['condiciones'], ENT_QUOTES)));
	$comentarios=mysqli_real_escape_string($con,(strip_tags($_REQUEST['comentarios'], ENT_QUOTES)));
	//Fin de variables por GET
	$sql=mysqli_query($con, "select LAST_INSERT_ID(id_pedido) as last from pedidos order by id_pedido desc limit 0,1 ");//obtengo el id maximo cargado
	$rw=mysqli_fetch_array($sql);
	$numero_pedido=$rw['last']+1;	
	$perfil=mysqli_query($con,"select * from perfil limit 0,1");//Obtengo los datos de la emprea
	$rw_perfil=mysqli_fetch_array($perfil);
	
	$sql_cliente=mysqli_query($con,"select * from clientes where id='$id_cliente' limit 0,1");//Obtengo los datos del cliente
	$rw_proveedor=mysqli_fetch_array($sql_cliente);
    // get the HTML
    
     include(dirname('__FILE__').'/res/pedido_html.php');
    $content = ob_get_clean();

    try
    {
        // init HTML2PDF
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
