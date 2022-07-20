<?php
  $page_title = 'Agregar venta';
  require_once('includes/load.php');
  // Nivel de permiso de usuario
   page_require_level(3);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Sistema de Pedidos</title>
	<meta name="author" content="Diego Gonzalez">
   <!-- CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />
	<link rel=icon href='img/pedido.png' sizes="32x32" type="image/png">
  </head>
  <body>
  <?php include_once('layouts/header.php'); ?>
<div class="container">
		
	<div class="row-fluid">
		  
		<div class="col-md-12">
			<!--<h2><span class="glyphicon glyphicon-edit"></span> Nueva Venta</h2>-->
		
			<hr>
			<form class="form-horizontal" role="form" id="datos_pedido">
				<div class="row">
				  
					<div class="col-md-3" style="background-color:powderblue; padding:10px; moz-border-radius:7px; webkit-border-radius:7px;">
				  		<div class="col-md-12">
				  			<label for="parametroClienteRuc" class="control-label">Ingrese el RUC</label>
					 		<select class="parametroClienteRuc form-control" name="parametroClienteRuc" id="parametroClienteRuc" required></select>
						</div>
				  	
				  		<!--<div class="col-md-12">
				  			<label for="parametroCliente" class="control-label">Seleccionar Cliente</label>
					 		<select class="parametroCliente form-control" name="parametroCliente" id="parametroCliente" required></select>
						</div>-->
				  </div>
				  
					
					<div class="col-md-2">
						<label for="condiciones" class="control-label">Condiciones de pago</label>
						<!--<select class="form-control" aria-label="Default select example" id="condiciones">
							<option value="1">Contado</option>
							<option value="2">Credito</option>
						</select>-->
						<input type="text" class="form-control input-sm" id="condiciones" value="Contado" required>
					</div>
					
					<div class="col-md-4">
						<label for="comentarios" class="control-label">Comentarios</label>
						<input type="text" class="form-control input-sm" id="comentarios" value="Ninguno" placeholder="Comentarios o instruciones especiales" >
					</div>
							
				</div>
						
				
				<hr>
				<div class="col-md-12">
					<div class="pull-right">
						<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-plus"></span> Agregar productos
						</button>
						<button type="submit" class="btn btn-default">
						  <span class="glyphicon glyphicon-print"></span> Guardar
						</button>
						<a href="admin.php">
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
			  <div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Buscar productos</h4>
				  </div>
				  <div class="modal-body">
					<form class="form-horizontal">
					  <div class="form-group">
					  	<div class="col-sm-4">
							<div class="input-group">
								<div class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></div>
								<input type="text" class="form-control producto" name="q2" id="q2" placeholder="Buscar Código de Barra" autocomplete="off" onchange="load2(1)" >
							</div>
							
						</div>
						<div class="col-sm-6">
							<div class="input-group">
								<div class="input-group-addon"><i class="glyphicon glyphicon-tasks"></i></div>
						  		<input type="text" class="form-control" id="q" placeholder="Buscar productos" onkeyup="load(1)">
							</div>
						</div>
						<div class="col-sm-2">
						<button type="button" class="btn btn-default" onclick="load(1)"><span class='glyphicon glyphicon-search'></span> Buscar</button>
						</div>
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
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<!-- script para abrir el modal al cargar la pagina-->
	<script type="text/javascript" src="js/modal_venta.js"></script>
	<!-- script para poner el foco en la caja de texto de codigo de barra-->
	<!--<script type="text/javascript"src="js/foco_barra.js"> </script>	-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
	<script>
		$(document).ready(function(){
			$("#q2:text:visible:first").focus();
		});
	</script>
	<script>
		$(document).ready(function(){
			load(1);
		});
		//funcion para buscar producto por descripcion
		function load(page){
			var q= $("#q").val();
			var parametros={"action":"ajax","page":page,"q":q};
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/productos_pedido.php',
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

		//<!-- funcion para buscar producto por codigo de barra-->
		function load2(page){
			var q= $("#q2").val();
			var parametros={"action":"ajax","page":page,"q":q};
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
	<script>
	function agregar (id)
		{
			var precio_venta=$('#precio_venta_'+id).val();
			var cantidad=$('#cantidad_'+id).val();
			//Inicia validacion
			if (isNaN(cantidad))
			{
			alert('Esto no es un numero');
			document.getElementById('cantidad_'+id).focus();
			return false;
			}
			if (isNaN(precio_venta))
			{
			alert('Esto no es un numero');
			document.getElementById('precio_venta_'+id).focus();
			return false;
			}
			//Fin validacion
		var parametros={"id":id,"precio_venta":precio_venta,"cantidad":cantidad};	
		$.ajax({
        type: "POST",
        url: "./ajax/agregar_pedido.php",
        data: parametros,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },

        success: function(datos){
		$("#resultados").html(datos);
		}
			});
		}
		
			function eliminar (id)
		{
			
			$.ajax({
        type: "GET",
        url: "./ajax/agregar_pedido.php",
        data: "id="+id,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		}
			});

		}
		
		$("#datos_pedido").submit(function(){
		  var cliente = $("#parametroCliente").val();
		  //var ruc = $("#parametroClienteRuc").val();
		  var condiciones = $("#condiciones").val();
		  var comentarios = $("#comentarios").val();
		  if (proveedor>0)
		 {
			//alert(echo '+cliente+');
			VentanaCentrada('./pdf/documentos/pedido_pdf.php?proveedor='+cliente+'&condiciones='+condiciones+'&comentarios='+comentarios,'Pedido','','1024','768','true');	
		 } else {
			 alert("Selecciona el Cliente");
			 return false;
		 }
		 
	 	});
	</script>
	
	
<script type="text/javascript">
$(document).ready(function() {
    $( ".parametroClienteRuc" ).select2({        
    ajax: {
        url: "ajax/load_proveedores.php",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                q: params.term // search term
            };
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
    },
    minimumInputLength: 2
});
});
</script>


<!--script para filtrar cliente por nombre-->
<script type="text/javascript">
      $('.parametroCliente').select2({
        placeholder: 'Seleccione el Cliente',
        ajax: {
          url: 'ajax/ajax_cliente.php',
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
<?php include_once('layouts/footer.php'); ?>
