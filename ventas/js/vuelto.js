function Datos(){
    v1=$('#valor1').val();
    v2=$('#valor2').val();
 
    $.ajax({
		url:'funciones.php',
		type:'post',
		data:{'valor1':v1,'valor2':v2},
		success:function(respuesta){
			$('#resultados').html(respuesta);
    	}	   
    })
}