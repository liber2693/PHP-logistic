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

	$("#boton_confimar_eliminar").on("click", function(event){
		eliminar_usuario();
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
                '<td colspan="7" style="font-size:120%"class="text-center"><b><br>No User</b></td>'+
                '</tr>');
            }else{
                lista.forEach( function(data, indice, array) {
                	estatus = data.estatus == 1 ? "ACTIVE":"INACTIVE";
                	actividad = data.actividad == 1 ? "i_verde.png":"i_rojo.png";

                	$("#table_id").append(
                    '<tr>'+
	                    '<td>'+data.usuario+'</td>'+
	                    '<td>'+data.nombre+'</td>'+
	                    '<td>'+data.apellido+'</td>'+
	                    '<td>'+data.rol+'</td>'+
	                    '<td><img src="../images/'+actividad+'"></td>'+
	                    '<td>'+estatus+'</td>'+
	                    '<td>'+
							'<div class="btn-group">'+
								'<button class="btn btn-warning" style="font-size:16px" title="Edit User" onclick="editar_user('+data.id+')" data-toggle="modal" data-target="#myModalActualziar"><i class="fa fa-pencil"></i></button>'+
								'<button class="btn btn-danger" style="font-size:16px"  title="Delete User" onclick="delete_user('+data.id+')" data-toggle="modal" data-target="#myModalEliminar"><i class="fa fa-times"></i></button>'+
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
			$("#Actualizar_usuario").val(data.usuario);
			$("#Actualizar_rol").val(data.rol);
			if(data.estatus_logico == 1){
				$("#Actualizar_estatus").attr('checked', true);
			}
		}
    })
}

function actualizar_usuario(){
	console.log("actualziar usuario");

	var id = $("#id_usuario").val();
	var nombre = $("#Actualizar_nombre").val().trim();
	var apellido = $("#Actualizar_apellido").val().trim();
	var usuario = $("#Actualizar_usuario").val().trim();
	var rol = $("#Actualizar_rol").val();
	var password1 = $("#Actualizar_password1").val();
	var password2 = $("#Actualizar_password2").val();
	campo1 = password1.length > 0 ? btoa(password1) : null;
	campo2 = password2.length > 0 ? btoa(password2) : null;
	

	var estatus = $("#Actualizar_estatus").prop('checked');
	if (estatus == true) {
		estatus = 1;
	}else{
		estatus = 0
	}
	
	$(".upt").css({"border":"1px solid #c7c7cc"});
	$("#Actualziar_campo_password1").empty();
	$("#Actualziar_campo_password2").empty();
	$("#ya_existe_actualizar").empty();

	if(nombre.length == 0){
		$("#Actualizar_nombre").css({"border":"2px solid #ff3333"});
        event.preventDefault();
	}
	if(apellido.length == 0){
		$("#Actualizar_apellido").css({"border":"2px solid #ff3333"});
        event.preventDefault();
	}
	if(rol == 0){
		$("#Actualizar_rol").css({"border":"2px solid #ff3333"});
        event.preventDefault();
	}
	/*if(password1.length == 0){
		$("#Actualizar_password1").css({"border":"2px solid #ff3333"});
        event.preventDefault();
	}
	if(password2.length == 0){
		$("#Actualizar_password2").css({"border":"2px solid #ff3333"});
        event.preventDefault();
	}*/
	if(password1 != password2){
		$("#Actualizar_password1").css({"border":"2px solid #ff3333"});
		$("#Actualizar_password2").css({"border":"2px solid #ff3333"});
		$("#Actualziar_campo_password1").html("Password no coinciden");
		$("#Actualziar_campo_password2").html("Password no coinciden");
		return;
	}

	//if(nombre.length > 0 && apellido.length > 0 && usuario.length > 0 && rol !=0 && password1.length > 0 && password2.length > 0)
	if(nombre.length > 0 && apellido.length > 0 && usuario.length > 0 && rol !=0)
	{
		$.ajax({                        
		    type: 'POST',                 
		    url: "../controllers/usuarioControllers.php", 
		    dataType: "json",                    
		    data: {
		    	"id" : id,
		    	"nombre" : nombre,
				"apellido" : apellido,
				"usuario_actualizar" : usuario,
				"rol" : rol,
				"password1" : campo1,
				"password2" : campo2,
				"estatus" : estatus
		    },
		    beforeSend: function(){
	           $('#loader_imagen').show();
	        },
	    	success: function(data){
	        	$('#loader_imagen').hide();	
				
				if (data == 1) {
	        		verMensajeAlert("success","<strong>User!</strong> Actualziado con exito.", $("#mensaje_usuario"));
					$("#myModalActualziar").modal("hide");
					limpiar_campos()
					lista_usuarios()
					$("#mensaje_usuario_update").empty();
				}  
				else{
					verMensajeAlert("warning","<strong>User!</strong> Ya esta registrado.", $("#mensaje_usuario_update"));
					$("#ya_existe_actualizar").removeClass('ocultar').html("Usuario Ya existe");
				}  	
	        }
	    })
	}
	else
	{
		verMensajeAlert("danger","<strong>Campo vacio!</strong> Todos los campos son requeridos.", $("#mensaje_usuario_update"));
	}
}

function delete_user(id){
	console.log("modal para elimnar el registro: "+id);
	$("#id_registro").val(id);
}

function eliminar_usuario(){
	console.log("eliminar")
	var id_registro = $("#id_registro").val();

	$.ajax({                        
	    type: 'POST',                 
	    url: "../controllers/usuarioControllers.php", 
	    dataType: "json",                    
	    data: {
	    	"id_registro" : id_registro,
	    },
	    /*beforeSend: function(){
           $('#loader_imagen').show();
        },*/
    	success: function(data){
        	//$('#loader_imagen').hide();	
			
			if (data == 1) {
        		verMensajeAlert("success","<strong>User!</strong> Eliminado con exito.", $("#mensaje_usuario"));
				$("#myModalEliminar").modal("hide");
				limpiar_campos()
				lista_usuarios()
			}  
			else{
				verMensajeAlert("warning","<strong>User!</strong> No pudo eliminarse.", $("#mensaje_usuario"));
				
			} 	
        }
    })
}

function limpiar_campos(){
	$(".user_campus").val("");
	$("#rol").val("0");

}