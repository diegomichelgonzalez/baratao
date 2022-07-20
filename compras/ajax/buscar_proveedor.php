<?php
define( 'DB_HOST', '195.179.237.0' );          // servidor de la BD
define( 'DB_USER', 'u609417362_baratao' );             // usuario de la BD
define( 'DB_PASS', 'Ntcdiego5.' );             // Senha de la BD
define( 'DB_NAME', 'u609417362_barataobd' );        // Nombre de la BD

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$sql = "SELECT * FROM proveedor
		WHERE ruc LIKE '%".$_GET['q']."%'
		LIMIT 10"; 
$result = $mysqli->query($sql);
$json = [];
while($row = $result->fetch_assoc()){
     $json[] = ['id'=>$row['id'], 'text'=>$row['nombre']];
}
echo json_encode($json);