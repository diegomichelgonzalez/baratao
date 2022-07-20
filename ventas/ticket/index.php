

<!DOCTYPE html>
<html lang="es">
<html>
    <head>
   
        <link rel="stylesheet" href="estilo.css">
        <script src="ticket.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    </head>
    <body>
    <div class="ticket">

            <img
                src="logo.bmp"
                alt="Logotipo">
            <p class="centrado"><br>RECIBO</p>
         
           
            
            <div class="form-group">
  	      	<label for="usr">CLIENTE:</label>
  	    	<input type="text" class="form-control" id="cliente">
           </div>
            <div class="form-group">
  	      	<label for="usr">FECHA VTO:</label>
  	    	<input type="date" class="form-control" id="FECHA">
           </div>
            <div class="form-group">
  	      	<label for="usr">FECHA DE PAGO:</label>
  	    	<input type="date" class="form-control" id="FECHA">
           </div>
 	  <div class="form-group">
  	      	<label for="usr">PERIODO:</label>
  	    	<input type="Text" class="form-control" id="PERIODO">
           </div>
                
               
              
            <table>
                <thead>
                    <tr>
                        <th class="producto">DESCRIPCIÒN</th>
                        <th class="precio"> MONTO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <br>
                        <td class="producto">S.Internet</td>
                        <td class="precio"><input type="number" class="form-control" id="PERIODO"></td>
                    </tr>
                   
                </tbody>
            </table>
            <p class="centrado">*****************************</p>
            <p class="justificado">Obs. El pago de su factura cuenta con una toleracia de 10 dias.
             Transcurrido ese tiempo se procedera al corte del servicio.
            </p>
            <p class="centrado">*****************************</p>
            <p class="centrado">RECLAMOS</p>
            <p class="centrado">0983 842 214</p>
            <p class="centrado">0983 624 704</p>
            <p class="centrado">****************************</p>
            <p class="centrado">¡GRACIAS POR SU PAGO!</p>

               
                <button class="oculto-impresion" id="btnImprimir" onclick="imprimir()">Imprimir</button>
   </div>
           

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    </body>
</html>