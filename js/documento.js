$(document).ready(function() {
    var url_paise = '../controllers/paisesControllers.php';
    $("#pais_origen").load(url_paise);
    $("#pais_destino").load(url_paise);
    $("#pais_origenE").load(url_paise);
    $("#pais_destinoE").load(url_paise);
	$("#importacion").submit(function(event) {
		//event.preventDefault();
		var shipper = $('#shipper').val(); 
		var fecha = $('#fecha').val();
        var pais_origen = $("#pais_origen").val();
        var origen = $('#origen').val();
        var pais_destino = $("#pais_destino").val();
        var destino = $('#destino').val();
		var proveedor = $('#proveedor').val();
		var pieza = $('#pieza').val();
		var tipo_pieza = $('#tipo_pieza').val();
		var peso = $('#peso').val();
		var tipo_peso = $('#tipo_peso').val();
		var alto = $('#alto').val();
		var ancho = $('#ancho').val();
		var largo = $('#largo').val();
		var medida = $('#medida').val();
		var archivo = $('#archivo').val();
        var telefono = $('#telefono').val();
        var codigo_zip = $('#codigo_zip').val();
        var descripcion = $('#descripcion').val();
		//archivo
		
    	//alert(archivo);
		//event.preventDefault();
		
		if (shipper=='') {
    		$("#shipper").css({"border":"2px solid #ff3333"});
	       event.preventDefault();
    	}else{
    		$("#shipper").css({"border":"0"});
    	}
    	if (fecha=='') {
    		$("#fecha").css({"border":"2px solid #ff3333"});
	        event.preventDefault();
    	}else{
    		$("#fecha").css({"border":"0"});
    	}
    	if (origen=='') {
    		$("#origen").css({"border":"2px solid #ff3333"});
	        event.preventDefault();
    	}else{
    		$("#origen").css({"border":"0"});
    	}
    	if (destino=='') {
    		$("#destino").css({"border":"2px solid #ff3333"});
	        event.preventDefault();
    	}else{
    		$("#destino").css({"border":"0"});
    	}
    	if (proveedor=='') {
    		$("#proveedor").css({"border":"2px solid #ff3333"});
	        event.preventDefault();
    	}else{
    		$("#proveedor").css({"border":"0"});
    	}
    	if (pieza=='') {
    		$("#pieza").css({"border":"2px solid #ff3333"});
	        event.preventDefault();
    	}else{
    		$("#pieza").css({"border":"0"});
    	}
    	if (tipo_pieza=='') {
    		$("#tipo_pieza").css({"border":"2px solid #ff3333"});
	        event.preventDefault();
    	}else{
    		$("#tipo_pieza").css({"border":"0"});
    	}
    	if (peso=='') {
    		$("#peso").css({"border":"2px solid #ff3333"});
	        event.preventDefault();
    	}else{
    		$("#peso").css({"border":"0"});
    	}
    	if (tipo_peso=='') {
    		$("#tipo_peso").css({"border":"2px solid #ff3333"});
	        event.preventDefault();
    	}else{
    		$("#tipo_peso").css({"border":"0"});
    	}
    	if (alto=='') {
    		$("#alto").css({"border":"2px solid #ff3333"});
	        event.preventDefault();
    	}else{
    		$("#alto").css({"border":"0"});
    	}
    	if (ancho=='') {
    		$("#ancho").css({"border":"2px solid #ff3333"});
	        event.preventDefault();
    	}else{
    		$("#ancho").css({"border":"0"});
    	}
    	if (largo=='') {
    		$("#largo").css({"border":"2px solid #ff3333"});
	        event.preventDefault();
    	}else{
    		$("#largo").css({"border":"0"});
    	}
    	if (medida==0) {
    		$("#medida").css({"border":"2px solid #ff3333"});
	        event.preventDefault();
    	}else{
    		$("#medida").css({"border":"0"});
    	}
    	if (archivo=='') {
    		$("#archivo").css({"border":"2px solid #ff3333"});
	        event.preventDefault();
    	}else{
    		$("#archivo").css({"border":"0"});
    	}
        if (pais_origen==0) {
            $("#pais_origen").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#pais_origen").css({"border":"0"});
        }
        if (pais_destino==0) {
            $("#pais_destino").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#pais_destino").css({"border":"0"});
        }
        if (telefono=='') {
            $("#telefono").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#telefono").css({"border":"0"});
        }
        if (codigo_zip=='') {
            $("#codigo_zip").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#codigo_zip").css({"border":"0"});
        }
         if (descripcion=='') {
            $("#descripcion").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#descripcion").css({"border":"0"});
        }
        //alert(password);
    });
    
    $("#exportacion").submit(function(event) {
        //event.preventDefault();
        var shipper = $('#shipperE').val(); 
        var fecha = $('#fechaE').val();
        var pais_origen = $("#pais_origenE").val();
        var origen = $('#origenE').val();
        var pais_destino = $("#pais_destinoE").val();
        var destino = $('#destinoE').val();
        var proveedor = $('#proveedorE').val();
        var pieza = $('#piezaE').val();
        var tipo_pieza = $('#tipo_piezaE').val();
        var peso = $('#pesoE').val();
        var tipo_peso = $('#tipo_pesoE').val();
        var alto = $('#altoE').val();
        var ancho = $('#anchoE').val();
        var largo = $('#largoE').val();
        var medida = $('#medidaE').val();
        var archivo = $('#archivoE').val();
        var telefono = $('#telefonoE').val();
        var codigo_zip = $('#codigo_zipE').val();
        var descripcion = $('#descripcionE').val();
        //archivo
        
        //alert(archivo);
        //event.preventDefault();
        
        if (shipper=='') {
            $("#shipperE").css({"border":"2px solid #ff3333"});
           event.preventDefault();
        }else{
            $("#shipperE").css({"border":"0"});
        }
        if (fecha=='') {
            $("#fechaE").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#fechaE").css({"border":"0"});
        }
        if (origen=='') {
            $("#origenE").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#origenE").css({"border":"0"});
        }
        if (destino=='') {
            $("#destinoE").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#destinoE").css({"border":"0"});
        }
        if (proveedor=='') {
            $("#proveedorE").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#proveedorE").css({"border":"0"});
        }
        if (pieza=='') {
            $("#piezaE").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#piezaE").css({"border":"0"});
        }
        if (tipo_pieza=='') {
            $("#tipo_piezaE").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#tipo_piezaE").css({"border":"0"});
        }
        if (peso=='') {
            $("#pesoE").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#pesoE").css({"border":"0"});
        }
        if (tipo_peso=='') {
            $("#tipo_pesoE").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#tipo_pesoE").css({"border":"0"});
        }
        if (alto=='') {
            $("#altoE").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#altoE").css({"border":"0"});
        }
        if (ancho=='') {
            $("#anchoE").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#anchoE").css({"border":"0"});
        }
        if (largo=='') {
            $("#largoE").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#largoE").css({"border":"0"});
        }
        if (medida==0) {
            $("#medidaE").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#medidaE").css({"border":"0"});
        }
        if (archivo=='') {
            $("#archivoE").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#archivoE").css({"border":"0"});
        }
        if (pais_origen==0) {
            $("#pais_origenE").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#pais_origenE").css({"border":"0"});
        }
        if (pais_destino==0) {
            $("#pais_destinoE").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#pais_destinoE").css({"border":"0"});
        }
        if (telefono=='') {
            $("#telefonoE").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#telefonoE").css({"border":"0"});
        }
        if (codigo_zip=='') {
            $("#codigo_zipE").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#codigo_zipE").css({"border":"0"});
        }
         if (descripcion=='') {
            $("#descripcionE").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#descripcionE").css({"border":"0"});
        }
        //alert(password);
    });
    
    $("#enviar_actualizacion").submit(function(){
        var expedidor = $("#expedidor").val().trim();
        var fecha = $("#fecha").val().trim();
        var telefono = $("#telefono").val().trim();
        var codigo_zip = $("#codigo_zip").val().trim();
        var id_origen = $("#id_origen").val().trim();
        var origen = $("#origen").val().trim();
        var id_destino = $("#id_destino").val().trim();
        var destino = $("#destino").val().trim();
        var pieza = $("#pieza").val().trim();
        var tipo_pieza = $("#tipo_pieza").val().trim();
        var peso = $("#peso").val().trim();
        var tipo_peso = $("#tipo_peso").val().trim();
        var alto = $("#alto").val().trim();
        var ancho = $("#ancho").val().trim();
        var largo = $("#largo").val().trim();
        var medida = $("#medida").val().trim();
        var descripcion = $("#descripcion").val().trim();
        
        if (expedidor.length=='') {
            $("#expedidor").css({"border":"2px solid #ff3333"});
            return false;
        }else{
            $("#expedidor").css({"border":"1px solid #c7c7cc"});
        }

        if (fecha.length=='') {
            $("#fecha").css({"border":"2px solid #ff3333"});
            return false;
        }else{
            $("#fecha").css({"border":"1px solid #c7c7cc"});
        }

        if (telefono.length=='') {
            $("#telefono").css({"border":"2px solid #ff3333"});
            return false;
        }else{
            $("#telefono").css({"border":"1px solid #c7c7cc"});
        }
        if (codigo_zip.length=='') {
            $("#codigo_zip").css({"border":"2px solid #ff3333"});
            return false;
        }else{
            $("#codigo_zip").css({"border":"1px solid #c7c7cc"});
        }
        if (id_origen==0) {
            $("#id_origen").css({"border":"2px solid #ff3333"});
            return false;
        }else{
            $("#id_origen").css({"border":"1px solid #c7c7cc"});
        }
        if (origen.length=='') {
            $("#origen").css({"border":"2px solid #ff3333"});
            return false;
        }else{
            $("#origen").css({"border":"1px solid #c7c7cc"});
        }
        if (id_destino==0) {
            $("#id_destino").css({"border":"2px solid #ff3333"});
            return false;
        }else{
            $("#id_destino").css({"border":"1px solid #c7c7cc"});
        }
        if (destino.length=='') {
            $("#destino").css({"border":"2px solid #ff3333"});
            return false;
        }else{
            $("#destino").css({"border":"1px solid #c7c7cc"});
        }
        if (pieza.length=='') {
            $("#pieza").css({"border":"2px solid #ff3333"});
            return false;
        }else{
            $("#pieza").css({"border":"1px solid #c7c7cc"});
        }
        if (tipo_pieza.length=='') {
            $("#tipo_pieza").css({"border":"2px solid #ff3333"});
            return false;
        }else{
            $("#tipo_pieza").css({"border":"1px solid #c7c7cc"});
        }
        if (peso.length=='') {
            $("#peso").css({"border":"2px solid #ff3333"});
            return false;
        }else{
            $("#peso").css({"border":"1px solid #c7c7cc"});
        }
        if (tipo_peso.length=='') {
            $("#tipo_peso").css({"border":"2px solid #ff3333"});
            return false;
        }else{
            $("#tipo_peso").css({"border":"1px solid #c7c7cc"});
        }
        if (alto.length=='') {
            $("#alto").css({"border":"2px solid #ff3333"});
            return false;
        }else{
            $("#alto").css({"border":"1px solid #c7c7cc"});
        }
        if (ancho.length=='') {
            $("#ancho").css({"border":"2px solid #ff3333"});
            return false;
        }else{
            $("#ancho").css({"border":"1px solid #c7c7cc"});
        }
        if (largo.length=='') {
            $("#largo").css({"border":"2px solid #ff3333"});
            return false;
        }else{
            $("#largo").css({"border":"1px solid #c7c7cc"});
        }
        if (medida==0) {
            $("#medida").css({"border":"2px solid #ff3333"});
            return false;
        }else{
            $("#medida").css({"border":"1px solid #c7c7cc"});
        }
        if (descripcion.length=='') {
            $("#descripcion").css({"border":"2px solid #ff3333"});
            return false;
        }else{
            $("#descripcion").css({"border":"1px solid #c7c7cc"});
        }
        
        
    });
});

function llenar_paises(idO,idD){
    var url_origen = '../controllers/paisesControllers.php?origen='+idO+'';
    var url_destino = '../controllers/paisesControllers.php?destino='+idD+'';

    $("#pais_origen_Actualizacion").load(url_origen);
    $("#pais_destino_Actualizacion").load(url_destino);

    
}

					