<?php 
//session_start();
require_once("../includes/session.php");
include("config/db.php");//Contienen las variables, el servidor, usuario, contraseña y nombre  de la base de datos
include("config/conexion.php");//Contiene de conexion a la base de datos

if(!isset($_SESSION['user_id'])){
  echo'
   <script>
     alret("Por favor inicia sesión ");
    
   </script>
  ';
  header("location: ../index.php");
  session_destroy();
  die();
}
//$user = current_user(); 
$id_user = $_SESSION['user_id'];

$ses_sql=mysqli_query($con, "select * from users where id='$id_user'");
$row = mysqli_fetch_assoc($ses_sql);
$user =$row['name'];
$userimg =$row['image'];

?>
<!DOCTYPE html>
  <html lang="en">
    <head>
    <meta charset="UTF-8">
    <title><?php if (!empty($page_title))
           echo remove_junk($page_title);
            elseif(!empty($user))
           echo ucfirst($user);
            else echo "Sistema de inventario";?>
    </title>
	
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
    <link rel="stylesheet" href="../../libs/css/main.css" />
    <link rel=icon href='http://localhost/josymatsystem/uploads/img/pedido.png' sizes="32x32" type="image/png">
	<svg xmlns="http://www.w3.org/2000/svg/" width="16" height="16" fill="currentCollor" class="bi bi-graph-down" viewBox="0 0 16 16">
		<!--<path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0Zm14.817 11.887a.5.5 0 0 0 .07-.7041-4.5-5.5a.5.5 0 0 0-.74-.037L7.06 8.233 3.404 3.206a.5.5 0 0 0-.808.58814 5.5a.5.5 0 0 0 .758.0612.609-2.61 4.15 5.073a.5.5 0 0 0 .704.07Z"/-->
	</svg>
  </head>
  <body>
  <?php  if ($session->isUserLoggedIn(true)): ?>
    <header id="header">
      <div class="logo pull-left"> <span class="glyphicon glyphicon-edit"></span>Nueva Compra </div>
      <div class="header-content">
      <div class="header-date pull-left">
      <h3><strong><?php echo date("d/m/Y  g:i a");?></strong></h3>
      </div>
 
      <div class="pull-right clearfix">
        <ul class="info-menu list-inline list-unstyled">
          <li class="profile">
            <a href="#" data-toggle="dropdown" class="toggle" aria-expanded="false">
              <img src="../uploads/users/<?php echo $userimg;?>" alt="user-image" class="img-circle img-inline">
              <span> <?php echo $user;?> <i class="caret"></i></span>
              
            </a>
            <ul class="dropdown-menu">
              <li>
                  <a href="../profile.php?id=<?php echo (int)$id_user;?>">
                      <i class="glyphicon glyphicon-user"></i>
                      Perfil
                  </a>
              </li>
             <li>
                 <a href="../edit_account.php" title="edit account">
                     <i class="glyphicon glyphicon-cog"></i>
                     Configuración
                 </a>
             </li>
             <li class="last">
                 <a href="../logout.php">
                     <i class="glyphicon glyphicon-off"></i>
                     Salir
                 </a>
             </li>
           </ul>
          </li>
        </ul>
      </div>
     </div>
    </header>

<?php endif;?>
<br>
<br>
<br>