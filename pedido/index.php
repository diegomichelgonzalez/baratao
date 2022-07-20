<?php include_once('config/header.php'); ?> 
<?php

	/*-------------------------
	Autor: Ing. Diego Gonzalez
	---------------------------*/

	// SQL Query para completar la informacion del usuario
$id_user = $_SESSION['user_id'];
$ses_sql=mysqli_query($con, "select name from users where id='$id_user'");
$row = mysqli_fetch_assoc($ses_sql);
$login_session =$row['name'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Modulo Venta</title>
	<meta name="author" content="NelTec">
   <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />
	<link rel=icon href='img/pedido.png' sizes="32x32" type="image/png">
  </head style="background:#F4F0EF; ">
  <body>
	  <br>
    <div class="container" style="background:#FCF7F6; ">

			<form class="form-horizontal" role="form" id="datos_pedido">
				<div class="row">
				  	<div class="col-md-4">
				  		
				  		<label for="parametroClienteRuc" class="control-label">Ingrese el RUC</label> &nbsp;
					 	<select class="parametroClienteRuc form-control" name="parametroClienteRuc" id="parametroClienteRuc" required></select>
						
				  	</div>
					
					<div class="col-md-2">
						<label for="condiciones" class="control-label">Condiciones de pago</label>
						<select class="form-control" aria-label="Default select example" id="condiciones" name="condiciones">
							<option value="CONTADO">Contado</option>
							<option value="CREDITO">Credito</option>
						</select>
						
					</div>
					
					<div class="col-md-2">
						<label for="formapago" class="control-label">Forma de Pago</label>
						<select class="form-control" aria-label="Default select example" id="formapago" name="formapago">
							<option value="EFECTIVO">Efectivo</option>
							<option value="CHEQUE">Cheque</option>
							<option value="TARJETAS">Tarjetas</option>
						</select>
						
					</div>
					<div class="col-md-2">
						<label for="moneda" class="control-label">Moneda</label>
						<select class="form-control" aria-label="Default select example" id="moneda" name="moneda">
							<option value="GUARANI">Guarani</option>
							<option value="DOLAR">Dolar</option>
							<option value="REAL">Real</option>
						</select>
						
					</div>	

					<div class="col-md-2">
						<label for="moneda" class="control-label">Tipo de Comprobante</label>
						<select class="form-control" aria-label="Default select example" id="comprobante" name="comprobante">
							<option value="TICKET">Ticket</option>
							<option value="FACTURA">Factura</option>
						</select>
					</div>
				</div>
				
				<hr>
				<div class="col-md-5">
					<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-plus"></span> Agregar productos
					</button>
				</div>
				<div class="col-md-7">
						
					<div class="pull-right">
						
						
							<button type="submit" class="btn btn-default">
						  <span class="glyphicon glyphicon-print"></span> Guardar
							</button>
							<a href="../admin.php">
								<button type="button" class="btn btn-default">
						  			<span class="glyphicon glyphicon-off"></span> Salir
								</button>
							</a>
						
					</div>	
				</div>
			</form>
			<br><br>
		<div id="resultados" class='col-md-12'></div><!-- Carga los datos ajax -->
	
			<!-- Modal -->
			<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-lg" style="max-height: 20px;" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Buscar productos</h4>
				  </div>
				  <div class="modal-body">
					<form class="form-horizontal">
						
					  	<div class="form-group">
					  		<div class="col-sm-4">
								<div class="input-group"><!-- Caja de texto para buscar por codigo de barra -->
									<div class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></div>
									<input autofocus type="text" class="form-control producto" name="q2" id="q2" placeholder="Buscar Código de Barra" autocomplete="off" onchange="load2(1)" >
									
								</div>
							</div>
							<div class="col-sm-6">
								<div class="input-group"><!-- Caja de texto para buscar por descripcion-->
									<div class="input-group-addon"><i class="glyphicon glyphicon-tasks"></i></div>
						  			<input type="text" class="form-control" id="q" placeholder="Buscar productos" onkeyup="load(1)">
								</div>
							</div>
							<!--<button type="button" class="btn btn-default" onclick="load(1)"><span class='glyphicon glyphicon-search'></span> Buscar</button>-->
					  	</div>
					</form>
					<div id="loader" style="position: absolute;	text-align: center;	top: 50px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
					<div class="outer_div" ></div><!-- Datos ajax Final -->
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					
				  </div>
				</div>
			  </div>
			</div>
			
			</div>	
		 </div>
	</div>

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<!-- Último JavaScript compilado y minificado -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
		<!-- script para abrir el modal al cargar la pagina-->
	<script type="text/javascript" src="js/modal_venta.js"></script>
	
	<!-- script para poner el foco en la caja de texto de codigo de barra-->
	<!--<script type="text/javascript"src="/js/foco_barra.js"> </script>-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<!-- script para abrir el modal al cargar la pagina-->
	<script type="text/javascript" src="js/modal_venta.js"></script>
	<!-- script para poner el foco en la caja de texto de codigo de barra-->
	<!--<script type="text/javascript"src="js/foco_barra.js"> </script>	-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
	<script type="text/javascript">
										$(document).ready(function(){
											//alert("valor de q es:#q2");
											$("#q2:text:visible:first").focus();
										});
									</script>
	<script>
		$(document).ready(function(){
			load(1);
		});

		//<!-- funcion para buscar producto por codigo de barra-->
		function load2(page){
			var q= $("#q2").val();//obtenemos el codigo de barra
			var r= $("input:radio[name='radio']:checked").val();//obtenemos el radiobuton selecionado
			var parametros={"action":"ajax","page":page,"q":q,"r":r};//cargamos los datos obtenido en un parametro
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_prod_barra.php',
				data: parametros,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}
	</script>


	//<!-- funcion para buscar producto por descripcion-->
	<script>
		$(document).ready(function(){
			load(1);
		});
		
		function load(page){
			var q= $("#q").val();
			var parametros={"action":"ajax","page":page,"q":q};
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_descripcion.php',
				data: parametros,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}
	</script>
	<script>
		function agregar (id)//funcion para agragar el producto selecionado a la grilla de ventas
		{
			
			var precio_venta=$('#precio_venta_'+id).val();
			var cantidad=$('#cantidad_'+id).val();
			//Inicia validacion
			if (isNaN(cantidad))
			{
				alert('La Cantidad no es un numero_'+cantidad);
				document.getElementById('cantidad_'+id).focus();
				return false;
			}
			if (isNaN(precio_venta))
			{
				alert('El precio de venta no es un numero');
				document.getElementById('precio_venta_'+id).focus();
				return false;
			}
			//Fin validacion
			var parametros={"id":id,"precio_venta":precio_venta,"cantidad":cantidad};	
			$.ajax({
        		type: "POST",
        		url: "./ajax/agregar_producto.php",
        		data: parametros,
		 		beforeSend: function(objeto){
					$("#resultados").html("Mensaje: Cargando...");
		  		},
        		success: function(datos){
					$("#resultados").html(datos);
				}
			});
		}
		
		function eliminar (id)//funcion para eliminar productos ya añadidos a la grilla de ventas
		{
			$.ajax({
        		type: "GET",
        		url: "./ajax/agregar_producto.php",
        		data: "id="+id,
		 		beforeSend: function(objeto){
					$("#resultados").html("Mensaje: Cargando...");
		  		},
        		success: function(datos){
					$("#resultados").html(datos);
				}
			});

		}
		
		$("#datos_pedido").submit(function(){//funcion para enviar los datos al ajax para que guarde las ventas y genere el pdf
		  var proveedor = $("#parametroClienteRuc").val();//enviamos el RUC por parametro 
		  var transporte = $("#moneda").val();//enviamos la moneda por parametro
		  var condiciones = $("#condiciones").val();//enviamos la condicion por parametro
		  var comentarios = $("#formapago").val();//enviamos la forma de pago por parametro
		  if (proveedor>0)
		 {
			VentanaCentrada('./pdf/documentos/pedido_pdf.php?proveedor='+proveedor+'&transporte='+transporte+'&condiciones='+condiciones+'&comentarios='+comentarios,'Pedido','','1024','768','true');	
		 } else {
			 alert("Selecciona el proveedor");
			 return false;
		 }
	 	});
	</script>
	
	


<!--script para filtrar cliente por cedula o ruc-->
<script type="text/javascript">
      $('.parametroClienteRuc').select2({
        placeholder: 'Seleccione el RUC',
        ajax: {
          url: 'ajax/ajax_cliente_ruc.php',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
      });
</script>


<!--script para mostrar el total a pagar-->
<script type="text/javascript">
      $('.parametroTotal').select2({
        placeholder: 'Total a pagar',
        ajax: {
          url: 'ajax/total_a_pagar.php',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
      });
</script>

  </body>
</html>