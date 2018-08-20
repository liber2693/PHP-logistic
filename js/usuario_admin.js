$(function(){
	console.log("entrando modulo de adminstracion de usuario");
	
	lista_usuarios()
	
	$("#usuario").on("blur",function() {
		buscar_usuario(this.value);
	})

	$("#guardar").on("click", function(event){
		guardar_usuario();
	})

	$("#boton_actualizar").on("click", function(event){
		actualizar_usuario();
	})

})


function buscar_usuario(text){
	console.log(text);

	//ya_existe //	
}

function guardar_usuario(){
	console.log("registrando un usuario");

	var nombre = $("#nombre").val().trim();
	var apellido = $("#apellido").val().trim();
	var usuario = $("#usuario").val().trim();
	var rol = $("#rol").val().trim();
	var password1 = btoa($("#password1").val());
	var password2 = btoa($("#password2").val());

	$(".col-sm-4").removeClass("has-error");
	$("#campo_password1").empty();
	$("#campo_password2").empty();

	if(nombre.length == 0){
		$("#nombre_div").addClass("has-error");
		event.preventDefault();
	}
	if(apellido.length == 0){
		$("#apellido_div").addClass("has-error");
		event.preventDefault();
	}
	if(usuario.length == 0){
		$("#usuario_div").addClass("has-error");
		event.preventDefault();
	}
	if(rol == 0){
		$("#rol_div").addClass("has-error");
		event.preventDefault();
	}
	if(password1.length == 0){
		$("#password1_div").addClass("has-error");
		event.preventDefault();
	}
	if(password2.length == 0){
		$("#password2_div").addClass("has-error");
		event.preventDefault();
	}

	if(password1 != password2){
		$("#password1_div").addClass("has-error");
		$("#password2_div").addClass("has-error");
		$("#campo_password1").html("Password no coinciden");
		$("#campo_password2").html("Password no coinciden");
		return;
	}

	if(nombre.length > 0 && apellido.length > 0 && usuario.length > 0 && rol != 0 && password1.length > 0 && password2.length > 0)
	{
		$.ajax({                        
		    type: 'POST',                 
		    url: "../controllers/usuarioControllers.php", 
		    dataType: "json",                    
		    data: {
		    	"nombre" : nombre,
				"apellido" : apellido,
				"usuario" : usuario,
				"rol" : rol,
				"password1" : password1,
				"password2" : password2
		    },
		    beforeSend: function(){
	           $('#loader_imagen').show();
	        },
	    	success: function(data){
	        	$('#loader_imagen').hide();	
				
				if (data == 1) {
	        		verMensajeAlert("success","<strong>User!</strong> registrado con exito.", $("#mensaje_usuario"));
					limpiar_campos()
					lista_usuarios()
				}  
				else{
					verMensajeAlert("warning","<strong>User!</strong> Ya esta registrado.", $("#mensaje_usuario"));
				}    	
	        }
	    })
	}
	else
	{
		verMensajeAlert("danger","<strong>Campo vacio!</strong> Todos los campos son requeridos.", $("#mensaje_usuario"));
	}
}

function lista_usuarios(){
	console.log("listar");
	$("#table_id > tbody:last").children().remove();
	
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "../controllers/usuarioControllers.php",
        data: { 'tabla' : 1},
        success: function(data){
            var lista = data;
            if(lista==0){
                $("#table_id").append(
                '<tr>'+
                '<td colspan="6" style="font-size:120%"class="text-center"><b><br>No User</b></td>'+
                '</tr>');
            }else{
                lista.forEach( function(data, indice, array) {
                	$("#table_id").append(
                    '<tr>'+
	                    '<td>'+data.usuario+'</td>'+
	                    '<td>'+data.nombre+'</td>'+
	                    '<td>'+data.apellido+'</td>'+
	                    '<td>'+data.rol+'</td>'+
	                    '<td>'+data.actividad+'</td>'+
	                    '<td>'+
							'<div class="btn-group">'+
								'<button class="btn btn-warning" style="font-size:16px" onclick="editar_user('+data.id+')" data-toggle="modal" data-target="#myModalActualziar"><i class="fa fa-pencil"></i></button>'+
								'<a class="btn btn-danger" style="font-size:16px" href="#" data-toggle="tooltip" title="Docket Details"><i class="fa fa-times"></i></a>'+
							'</div>'+
						'</td>'+
                    '</tr>');
                });
            }
        }
    })
}

function editar_user(id){
	console.log("actualizar datos del usuario: "+id);

	$.ajax({
        type: "GET",
        dataType: "json",
        url: "../controllers/usuarioControllers.php",
        data: { 'id' : id},
        success: function(data){
        	$("#id_usuario").val(data.id_usuario);
			$("#Actualizar_nombre").val(data.nombre);
			$("#Actualizar_apellido").val(data.apellido);
			$("#Actuaalizar_usuario").val(data.usuario);
			$("#Actuaalizar_rol").val(data.rol);
        }
    })
}

function actualizar_usuario(){
	console.log("actualziar usuario");

	var id = $("#id_usuario").val();
	var nombre = $("#Actualizar_nombre").val().trim();
	var apellido = $("#Actualizar_apellido").val().trim();
	var usuario = $("#Actuaalizar_usuario").val().trim();
	var rol = $("#Actuaalizar_rol").val();
	var password1 = btoa($("#Actuaalizar_password1").val());
	var password2 = btoa($("#Actuaalizar_password2").val());

	$(".upt").css({"border":"1px solid #c7c7cc"});
	$("#Actualziar_campo_password1").empty();
	$("#Actualziar_campo_password2").empty();

	if(nombre.length == 0){
		$("#Actualizar_nombre").css({"border":"2px solid #ff3333"});
        event.preventDefault();
	}
	if(apellido.length == 0){
		$("#Actualizar_apellido").css({"border":"2px solid #ff3333"});
        event.preventDefault();
	}
	if(rol == 0){
		$("#Actuaalizar_rol").css({"border":"2px solid #ff3333"});
        event.preventDefault();
	}
	if(password1.length == 0){
		$("#Actuaalizar_password1").css({"border":"2px solid #ff3333"});
        event.preventDefault();
	}
	if(password2.length == 0){
		$("#Actuaalizar_password2").css({"border":"2px solid #ff3333"});
        event.preventDefault();
	}
	if(password1 != password2){
		$("#Actuaalizar_password1").css({"border":"2px solid #ff3333"});
		$("#Actuaalizar_password2").css({"border":"2px solid #ff3333"});
		$("#Actualziar_campo_password1").html("Password no coinciden");
		$("#Actualziar_campo_password2").html("Password no coinciden");
		return;
	}

	if(nombre.length > 0 && apellido.length > 0 && usuario.length > 0 && rol !=0 && password1.length > 0 && password2.length > 0)
	{
		$.ajax({                        
		    type: 'POST',                 
		    url: "../controllers/usuarioControllers.php", 
		    dataType: "json",                    
		    data: {
		    	"id" : id,
		    	"nombre" : nombre,
				"apellido" : apellido,
				"usuario" : usuario,
				"rol" : rol,
				"password1" : password1,
				"password2" : password2
		    },
		    /*beforeSend: function(){
	           $('#loader_imagen').show();
	        },*/
	    	success: function(data){
	        	/*$('#loader_imagen').hide();	
				
				if (data == 1) {
	        		verMensajeAlert("success","<strong>User!</strong> registrado con exito.", $("#mensaje_usuario"));
					limpiar_campos()
					lista_usuarios()
				}  
				else{
					verMensajeAlert("warning","<strong>User!</strong> Ya esta registrado.", $("#mensaje_usuario"));
				} */   	
	        }
	    })
	}
	else
	{
		verMensajeAlert("danger","<strong>Campo vacio!</strong> Todos los campos son requeridos.", $("#mensaje_usuario_update"));
	}
}

function limpiar_campos(){
	$(".user_campus").val("");
	$("#rol").val("0");

}