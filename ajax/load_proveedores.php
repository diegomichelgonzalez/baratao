<?php
	/*-------------------------
	Autor: Ing. Diego Gonzalez
	---------------------------*/
	/* Conxion a la Base de Datos*/
	require_once ("../includes/config.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../includes/conexion.php");//Contiene funcion que conecta a la base de datos		
 //$con=@mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$search = strip_tags(trim($_GET['q'])); 
// Hacer consulta preparada
$query = mysqli_query($con, "SELECT * FROM vista_cliente WHERE nombre LIKE '%$search%' LIMIT 40");
// Hace una búsqueda rápida de los resultados
$list = array();
while ($list=mysqli_fetch_array($query)){
	$data[] = array('id' => $list['id'], 'text' => $list['nombre']);
}
// devuelve el resultado en json
echo json_encode($data);
?>