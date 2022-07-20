<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>
<?php //include_once('layouts/header.php'); ?>

<!DOCTYPE HTML>
<html>
<head>
<title>Iniciar Sesión</title>
<!-- Archivos de temas personalizados -->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<!-- para aplicaciones móviles -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta name="keywords" content="Flat Login Form Widget Responsive, Login form web template, Sign up Web Templates, Flat Web Templates, Login signup Responsive web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<!-- //para aplicaciones móviles -->
<!--Fuentes de Google-->
<link href='//fonts.googleapis.com/css?family=Signika:400,600' rel='stylesheet' type='text/css'>
<!--Fuentes de Google-->
<link rel=icon href='uploads/img/pedido.png' sizes="32x32" type="image/png">
</head>
<body>

<!--encabezado comienza aquí-->
<h1>Bienvenido</h1>
<div class="header agile">
	<div class="wrap">
		<div class="login-main wthree">
			<div class="login">
				<h3>Iniciar sesión</h3>
        		<?php echo display_msg($msg); ?>
        		<form method="post" action="auth.php" class="clearfix">
					<input type="text" placeholder="Correo electrónico" required="" name="username" required>
					<input type="password" placeholder="Contraseña" name="password" required>
					<input name="submit" type="submit" value="Ingresar">
				</form>
				<div class="clear"> </div>	
			</div>	
		</div>
	</div>
</div>
<!--header end here-->
<!--copy rights end here-->
<div class="copy-rights w3l">		 	
	<p>© <?php echo date("Y");?> <a href="" target="_blank">NelTec</a>  Todos los derechos reservados | Diseñado por NelTec Solution </p>		 	
</div>

       

<?php include_once('layouts/footer.php'); ?>
