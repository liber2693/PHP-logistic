function vermMensajeAlert(tipo, texto, target){
    
    var temp = '<div class="alert alert-{{tipo}} ocultar  text-center" role="alert">{{texto}}</div>';

    temp = temp.replace("{{tipo}}", tipo);
    temp = temp.replace("{{texto}}", texto);
    var $temp = $(temp);

    $temp.on("show",function(){
        $(this).fadeIn().delay(3000).fadeOut("slow", function(){
            this.remove();
        });
    });

    target.html($temp);

    return $temp;
}