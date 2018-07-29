$(document).ready(function() {
    //mascara de cifra con puntos(.) y comas(,)
    $("#dinero_us").maskMoney();
    $("#dinero_cad").maskMoney();
    for (var i = 0; i < 7; i++) {
        $("#dinero"+i+"").maskMoney();
    }
    //busca los servicios
    var tipo = $('#tipo').val();
    $.ajax({
    //async: true,
        type: "GET",
        dataType: "json",
        url: "../controllers/serviciosControllers.php",
        data: {'tipo' : tipo },
        success: function(data){
        var option = data;
            if (option==0) {
                 $("#lista_servicios").append("<option value='0'>No service available</option>");
            }else{
                option.forEach( function(data, indice, array) {
                  $("#lista_servicios").append("<option value="+data.id+">"+data.descripcion+"</option>");
                        //$("#Actualizar_benf_tipo_articulo").append("<option value="+data.id+">"+data.business_name+"</option> ")
                });
            }
        }
    })

    mostarLista();

    //seleccion del tipo de moneda, como se va pagar
    $("#us_dolar").click(function(){
        $("#campo_us").removeClass("ocultar");
        $("#campo_cad").addClass("ocultar");
        $("#dinero_us").focus();
        $("#dinero_cad").val("");
    });
    $("#cad_dolar").click(function(){
        $("#campo_cad").removeClass("ocultar");
        $("#campo_us").addClass("ocultar");
        $("#dinero_cad").focus();
        $("#dinero_us").val("");
    });

    $("#guardar_servicio").click(function(){
        //borrar los tr de la tabla menos la primera fila 
        
        //$('#seleccion_servicios_tabla').append('tr').not(':first').remove();
        //validar campos del pequeño fomulario
        var servicio = $("#lista_servicios").val(); 
        var dinero_us = $("#dinero_us").val();  
        var dinero_cad = $("#dinero_cad").val();    
        var nota = $("#nota").val();    
        var codigo = $("#codigo_documento").val();
        var usuario = $("#usuario_documento").val();
        
        
        if (servicio==0) {
            $("#lista_servicios").css({"border":"2px solid #ff3333"});
           event.preventDefault();
        }else{
            $("#lista_servicios").css({"border":"1px solid #c7c7cc"});
        }
        
        if ($('input[name="bill_to"]').is(':checked')) {
            $("#radio1").css({"border":"0"});
            $("#radio2").css({"border":"0"});
        } else {
            $("#radio1").css({"border":"2px solid #ff3333"});
            $("#radio2").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }
        if((servicio!=0) && (dinero_us.length>0) || (dinero_cad.length>0)){
            $("#seleccion_servicios_tabla > tbody:last").children().remove();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "../controllers/invoiceControllers.php",
                data: {'servicio' : servicio,
                       'dinero_us' : dinero_us,
                       'dinero_cad': dinero_cad,
                       'nota' : nota,
                       'codigo' : codigo,
                       'usuario' : usuario },
                success: function(data){
                    var lista = data;

                    if(lista==0){
                        $("#seleccion_servicios_tabla").append(
                        '<tr>'+
                        '<td colspan="5" class="text-center">tdere are no services available</td>'+
                        '</tr>');
                        $('#enviar_invoice').attr("disabled", true);
                    }else{
                        lista.forEach( function(data, indice, array) {
                            $("#seleccion_servicios_tabla").append(
                            '<tr>'+
                            '<td>'+data.codigo_ser+'</td>'+
                            '<td>'+data.descripcion+'</td>'+
                            '<td>'+data.nota+'</td>'+
                            '<td>'+data.dolar_us+'</td>'+
                            '<td>'+data.dolar_cad+'</td>'+
                            '<td><button type="button" class="btn btn-danger" title="Eliminar" onclick="eliminar('+data.id+')"><i class="fa fa-minus" aria-hidden="true"></i></td>'+
                            '</tr>');
                            $('#enviar_invoice').attr("disabled", false);
                        });
                    }
                    limpiar_campos();
                }
            })
        }else{
            $("#mensaje_servicios_selec").addClass("alert alert-block alert-danger fade in text-center").html("<strong>Disculpa!</strong> Debe registrar un servicio");
            setTimeout(function() {
                $("#mensaje_servicios_selec").removeClass().empty();
            },3000);
        }
    });

    //vericicar los tipo de envios
    // Comprobar cuando cambia un checkbox
    //mostrar el campo otro caundo selecciona el 6 
    $('input[type=checkbox]').on('change', function() {
        var valor = $(this).val();

        if ($(this).is(':checked') && valor==6) {
            $("#campo_otro").removeClass("ocultar");
        } else {
            $("#campo_otro").addClass("ocultar");
        }
    });

    $("#crear_invoice").submit(function(event) {
        
        var supplier = $("#supplier1").val();
        var dinero = $("#dinero1").val();
        var quien_paga = $("#quien_paga").val();

        if (supplier=='') {
            $("#supplier1").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#supplier1").css({"border":"1px solid #c7c7cc"});
        }
        if (dinero=='') {
            $("#dinero1").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#dinero1").css({"border":"1px solid #c7c7cc"});
        }
        if (quien_paga=='') {
            $("#quien_paga").css({"border":"2px solid #ff3333"});
            event.preventDefault();
        }else{
            $("#quien_paga").css({"border":"1px solid #c7c7cc"});
        }
        
        //validare que el envio este seleccionado
        var check = $("input[type='checkbox']:checked").length;
        if(check == ""){
            $("#mensaje_create_invoice").addClass("alert alert-block alert-danger fade in text-center").html("<strong>Disculpa!</strong> Debe seleccionar un tipo de envio");
            setTimeout(function() {
                $("#mensaje_create_invoice").removeClass().empty();
            },3000);
            $("#via_envio").css({"border":"2px solid #ff3333"});
           event.preventDefault();
        }else{
            $("#via_envio").css({"border":"0"});
        }
    });
});

function visible(i){
    //console.log(i);
    var campo=i+1;
    $("#campoSupplier"+campo+"").removeClass("oculto");
    $("#campoSupplier"+campo+"").addClass("mostrar");
   
}

function invisible(i){
    //console.log(i);   
    $("#campoSupplier"+i+"").removeClass("mostrar");
    $("#supplier"+i+"").val("");
    $("#dinero"+i+"").val("");   
}

function mostarLista(){
    var codigo = $("#codigo_documento").val();
    var usuario = $("#usuario_documento").val();
    //borrar los tr de la tabla menos la primera fila 
    $("#seleccion_servicios_tabla > tbody:last").children().remove();
    //llenar la tabla si existen servicios por este documento
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "../controllers/invoiceControllers.php",
        data: {'tabla' : 1,
               'codigo' : codigo,
               'usuario' : usuario },
        success: function(data){
            var lista = data;
            if(lista==0){
                $("#seleccion_servicios_tabla").append(
                '<tr>'+
                '<td colspan="5" class="text-center">tdere are no services available</td>'+
                '</tr>');
                $('#enviar_invoice').attr("disabled", true);
            }else{
                lista.forEach( function(data, indice, array) {
                    $("#seleccion_servicios_tabla").append(
                    '<tr>'+
                    '<td>'+data.codigo_ser+'</td>'+
                    '<td>'+data.descripcion+'</td>'+
                    '<td>'+data.nota+'</td>'+
                    '<td>'+data.dolar_us+'</td>'+
                    '<td>'+data.dolar_cad+'</td>'+
                    '<td><button type="button" class="btn btn-danger" title="Eliminar" onclick="eliminar('+data.id+')"><i class="fa fa-minus" aria-hidden="true"></i></td>'+
                    '</tr>');
                    $('#enviar_invoice').attr("disabled", false);
                });
            }
        }
    })
} 

function eliminar(id){
    console.log(id);
    $("#seleccion_servicios_tabla > tbody:last").children().remove();
    //llenar la tabla si existen servicios por este documento
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "../controllers/invoiceControllers.php",
        data: {'id' : id},
        success: function(data){
            var lista = data;
            if(lista==3){
                mostarLista()
            }else{
                console.log(id)
            }
        }
    })
}
function limpiar_campos(){

    $(".limpiar").val("");
    $("#lista_servicios").val("0");
}




