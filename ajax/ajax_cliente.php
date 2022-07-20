<?php
define( 'DB_HOST', 'localhost' );          // servidor de la BD
define( 'DB_USER', 'root' );             // usuario de la BD
define( 'DB_PASS', '' );             // Senha de la BD
define( 'DB_NAME', 'bdweb' );        // Nombre de la BD

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$sql = "SELECT * FROM vista_cliente
		WHERE nombre LIKE '%".$_GET['q']."%'
		LIMIT 10"; 
$result = $mysqli->query($sql);
$json = [];
while($row = $result->fetch_assoc()){
     $json[] = ['id'=>$row['id'], 'text'=>$row['nombre']];
}
echo json_encode($json);