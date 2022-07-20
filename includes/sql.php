<?php
  require_once('includes/load.php');

/*--------------------------------------------------------------*/
/* Función para buscar todas las filas de la tabla de la base de datos por nombre de tabla
/*--------------------------------------------------------------*/
function find_all($table) {
   global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table));
   }
}
/*--------------------------------------------------------------*/
/* Función para realizar consultas
/*--------------------------------------------------------------*/
function find_by_sql($sql)
{
  global $db;
  $result = $db->query($sql);
  $result_set = $db->while_loop($result);
 return $result_set;
}
/*--------------------------------------------------------------*/
/*  Función para buscar datos de la tabla por id
/*--------------------------------------------------------------*/
function find_by_id($table,$id)
{
  global $db;
  $id = (int)$id;
    if(tableExists($table)){
          $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}
/*--------------------------------------------------------------*/
/* Función para eliminar datos de la tabla por id
/*--------------------------------------------------------------*/
function delete_by_id($table,$id)
{
  global $db;
  if(tableExists($table))
   {
    $sql = "DELETE FROM ".$db->escape($table);
    $sql .= " WHERE id=". $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }
}
/*--------------------------------------------------------------*/
/* Función para ID de recuento por nombre de tabla
/*--------------------------------------------------------------*/

function count_by_id($table){
  global $db;
  if(tableExists($table))
  {
    $sql    = "SELECT COUNT(id) AS total FROM ".$db->escape($table);
    $result = $db->query($sql);
     return($db->fetch_assoc($result));
  }
}
/*--------------------------------------------------------------*/
/* Determinar si existe la tabla de la base de datos
/*--------------------------------------------------------------*/
function tableExists($table){
  global $db;
  $table_exit = $db->query('SHOW TABLES FROM '.DB_NAME.' LIKE "'.$db->escape($table).'"');
      if($table_exit) {
        if($db->num_rows($table_exit) > 0)
              return true;
         else
              return false;
      }
  }
 /*--------------------------------------------------------------*/
 /* Inicie sesión con los datos proporcionados en $ _POST,
 /* procedente del formulario de inicio de sesión.
/*--------------------------------------------------------------*/
  function authenticate($username='', $password='') {
    global $db;
    $username = $db->escape($username);
    $password = $db->escape($password);
    $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
    $result = $db->query($sql);
    if($db->num_rows($result)){
      $user = $db->fetch_assoc($result);
      $password_request = sha1($password);
      if($password_request === $user['password'] ){
        return $user['id'];
      }
    }
   return false;
  }
  /*--------------------------------------------------------------*/
  /* Inicie sesión con los datos proporcionados en $ _POST,
  /* procedente del formulario login_v2.php.
  /* Si usó este método, elimine la función de autenticación.
 /*--------------------------------------------------------------*/
   function authenticate_v2($username='', $password='') {
     global $db;
     $username = $db->escape($username);
     $password = $db->escape($password);
     $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
     $result = $db->query($sql);
     if($db->num_rows($result)){
       $user = $db->fetch_assoc($result);
       $password_request = sha1($password);
       if($password_request === $user['password'] ){
         return $user;
       }
     }
    return false;
   }


  /*--------------------------------------------------------------*/
  /* Buscar usuario de inicio de sesión actual por ID de sesión
  /*--------------------------------------------------------------*/
  function current_user(){
      static $current_user;
      global $db;
      if(!$current_user){
         if(isset($_SESSION['user_id'])):
             $user_id = intval($_SESSION['user_id']);
             $current_user = find_by_id('users',$user_id);
        endif;
      }
    return $current_user;
  }
  /*--------------------------------------------------------------*/
  /* Buscar todos los usuarios por
  /* Unirse a la tabla de usuarios y a la tabla de gropus de usuarios
  /*--------------------------------------------------------------*/
  function find_all_user(){
      global $db;
      $results = array();
      $sql = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.last_login,";
      $sql .="g.group_name ";
      $sql .="FROM users u ";
      $sql .="LEFT JOIN user_groups g ";
      $sql .="ON g.group_level=u.user_level ORDER BY u.name ASC";
      $result = find_by_sql($sql);
      return $result;
  }
  /*--------------------------------------------------------------*/
  /* Buscar y mostrar todos los clientes 
  /*--------------------------------------------------------------*/
  function todos_los_clientes(){
    global $db;
    $results = array();
    $sql = "SELECT id,cedula_ruc,nombre,apellido,direccion,celular1,celular2 FROM clientes";
    $result = find_by_sql($sql);
    return $result;
}
  /*--------------------------------------------------------------*/
  /* Buscar y mostrar todos los proveedores
  /*--------------------------------------------------------------*/
  function todos_los_proveedores(){
    global $db;
    $results = array();
    $sql = "SELECT id,nombre,ruc,direccion,telefono1,telefono2,correo FROM proveedor";
    $result = find_by_sql($sql);
    return $result;
}
  /*--------------------------------------------------------------*/
  /* Función para actualizar el último inicio de sesión de un usuario.
  /*--------------------------------------------------------------*/

 function updateLastLogIn($user_id)
	{
		global $db;
    $date = make_date();
    $sql = "UPDATE users SET last_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
    $result = $db->query($sql);
    return ($result && $db->affected_rows() === 1 ? true : false);
	}

  /*--------------------------------------------------------------*/
  /* Buscar todo el nombre del grupo
  /*--------------------------------------------------------------*/
  function find_by_groupName($val)
  {
    global $db;
    $sql = "SELECT group_name FROM user_groups WHERE group_name = '{$db->escape($val)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* Encuentra el nivel de grupo
  /*--------------------------------------------------------------*/
  function find_by_groupLevel($level)
  {
    global $db;
    $sql = "SELECT group_level FROM user_groups WHERE group_level = '{$db->escape($level)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* Función para comprobar qué nivel de usuario tiene acceso a la página.
  /*--------------------------------------------------------------*/
   function page_require_level($require_level){
     global $session;
     $current_user = current_user();
     $login_level = find_by_groupLevel($current_user['user_level']);
     //Si el usuario no inicia sesión
     if (!$session->isUserLoggedIn(true)):
            $session->msg('d','Por favor Iniciar sesión...');
            redirect('index.php', false);
      //si el estado del grupo es desactivado
     elseif($login_level['group_status'] === '0'):
           $session->msg('d','Este nivel de usaurio esta inactivo!');
           redirect('home.php',false);
      //Inicio de sesión de chequeo El nivel de usuario y el nivel requerido es menor o igual a
     elseif($current_user['user_level'] <= (int)$require_level):
              return true;
      else:
            $session->msg("d", "¡Lo siento!  no tienes permiso para ver la página.");
            redirect('home.php', false);
        endif;

     }
   /*--------------------------------------------------------------*/
   /* Función para encontrar todos los nombres de productos
   /* UNIRSE con la tabla de base de datos de categorías y medios
   /*--------------------------------------------------------------*/
  function join_product_table(){
     global $db;
    $sql  =" SELECT *FROM vista_productos";
    
    return find_by_sql($sql);

   }
  /*--------------------------------------------------------------*/
  /* Función para encontrar todos los nombres de productos
  /* Solicitud procedente de ajax.php para sugerir automáticamente
  /*--------------------------------------------------------------*/

   function filtrar_producto($product_name){
     global $db;
     $p_name = remove_junk($db->escape($product_name));
     $sql = "SELECT descripcion FROM productos WHERE descripcion like '%$p_name%' LIMIT 5";
     $result = find_by_sql($sql);
     return $result;
   }

  /*--------------------------------------------------------------*/
  /* Función para encontrar toda la información del producto por título del producto
  /* Solicitud procedente de ajax.php
  /*--------------------------------------------------------------*/
  function find_all_product_info_by_title($title){
    global $db;
    $sql  = "SELECT * FROM productos ";
    $sql .= " WHERE descripcion ='{$title}'";
    $sql .=" LIMIT 1";
    return find_by_sql($sql);
  }

    /*--------------------------------------------------------------*/
  /* Funcion para consultaar cliente por nombre
  /*--------------------------------------------------------------*/
  function venta_cliente($nombre){
    global $db;
    $sql  = "SELECT id,nombre FROM clientes ";
    $sql .= " WHERE nombre ='{$nombre}'";
    $sql .=" LIMIT 1";
    return find_by_sql($sql);
  }

  /*--------------------------------------------------------------*/
  /* Función para actualizar la cantidad de producto
  /*--------------------------------------------------------------*/
  function update_product_qty($qty,$p_id){
    global $db;
    $qty = (int) $qty;
    $id  = (int)$p_id;
    $sql = "UPDATE productos SET stock=stock -'{$qty}' WHERE id = '{$id}'";
    $result = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);

  }
  /*--------------------------------------------------------------*/
  /* Función para mostrar producto reciente agregado
  /*--------------------------------------------------------------*/
 function productos_recientes($limit){
   global $db;
   $sql   = "SELECT p.id,p.descripcion,p.precio_venta_minorista,p.imagen AS foto,c.name AS categoria,";
   $sql  .= "m.file_name AS image FROM productos p";
   $sql  .= " LEFT JOIN categories c ON c.id = p.kcategoria";
   $sql  .= " LEFT JOIN media m ON m.id = p.imagen";
   $sql  .= " ORDER BY p.id DESC LIMIT ".$db->escape((int)$limit);
   return find_by_sql($sql);
 }
 /*--------------------------------------------------------------*/
 /* Función para encontrar el producto de mayor venta
 /*--------------------------------------------------------------*/
 function productos_mas_vendidos($limit){
  global $db;
  $sql  = " SELECT p.descripcion, COUNT(d.id_producto) AS cantVendida, SUM(d.cantidad) AS CantTotal
  FROM caja_detalle d
  LEFT JOIN productos p ON p.id = d.id_producto
  GROUP BY d.id_producto
  ORDER BY SUM(d.cantidad) DESC LIMIT ".$db->escape((int)$limit);
  return $db->query($sql);
}
 /*--------------------------------------------------------------*/
 /* Función para buscar todas las ventas
 /*--------------------------------------------------------------*/

 function todas_las_ventas(){
  global $db;
  $sql  = "SELECT *FROM vista_ventas
  ORDER BY fecha DESC";
  return find_by_sql($sql);
}
 /*--------------------------------------------------------------*/
 /* Función para buscar todos los pedidos activos
 /*--------------------------------------------------------------*/

 function pedidos_activos(){
  global $db;
  $sql  = "SELECT *FROM vista_ventas
  WHERE vista_ventas.estado=3
  ORDER BY fecha DESC";
  return find_by_sql($sql);
}
 /*--------------------------------------------------------------*/
 /* Función para buscar todas las compras
 /*--------------------------------------------------------------*/

 function todas_las_compras(){
  global $db;
  $sql  = "SELECT *FROM vista_compras
  ORDER BY fecha DESC";
  return find_by_sql($sql);
}
 /*--------------------------------------------------------------*/
 /* Función para mostrar las ventas reciente
 /*--------------------------------------------------------------*/
function ventas_recientes($limit){
  global $db;
  $sql  = "SELECT * FROM vista_ventas_recientes ORDER BY fecha DESC LIMIT ".$db->escape((int)$limit);
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Función para generar informe de ventas por dos fechas
/*--------------------------------------------------------------*/
function ventas_por_fecha($start_date,$end_date){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT *FROM vista_ventas";
  $sql .= " WHERE vista_ventas.date BETWEEN '{$start_date}' AND '{$end_date}'";
  $sql .= " GROUP BY DATE(vista_ventas.date),vista_ventas.nombre";
  $sql .= " ORDER BY DATE(vista_ventas.date) DESC";
  return $db->query($sql);
}
/*--------------------------------------------------------------*/
/*Función para generar informe de ventas diarias
/*--------------------------------------------------------------*/
function  ventas_diaria($year,$month){
  global $db;
  $sql  = "SELECT caja_detalle.cantidad,
  DATE_FORMAT(caja_encabezado.fecha, '%Y-%m-%e') AS fecha,
  productos.descripcion,
  Sum(caja_detalle.costo * caja_detalle.cantidad) AS total_precio
  FROM caja_encabezado
  INNER JOIN caja_detalle ON caja_detalle.id = caja_encabezado.id
  INNER JOIN productos ON productos.id = caja_detalle.id_producto
  WHERE DATE_FORMAT(caja_encabezado.fecha, '%Y-%m' ) = '{$year}-{$month}'
  GROUP BY DATE_FORMAT( caja_encabezado.fecha,  '%e' ),caja_detalle.id_producto";
  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Función para generar informe de ventas mensual
/*--------------------------------------------------------------*/
function  ventas_mensual($year){
  global $db;
  $sql  = "SELECT
  caja_detalle.cantidad,
  DATE_FORMAT(caja_encabezado.fecha, '%Y-%m-%e') AS date,
  productos.descripcion,
  caja_detalle.subtotal
  FROM
  caja_encabezado
  INNER JOIN caja_detalle ON caja_encabezado.id = caja_detalle.id
  INNER JOIN productos ON caja_detalle.id_producto = productos.id";
  $sql .= " WHERE DATE_FORMAT(caja_encabezado.fecha, '%Y' ) = '{$year}'";
  $sql .= " GROUP BY DATE_FORMAT( caja_encabezado.fecha,  '%c' ),caja_detalle.id_producto";
  $sql .= " ORDER BY date_format(caja_encabezado.fecha, '%c' ) ASC";
  return find_by_sql($sql);
}

?>
