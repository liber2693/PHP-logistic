$(document).ready(function() {
	$( "#login" ).submit(function(event) {
		event.preventDefault();
		var usuario = $('#usuario').val(); 
		var password = btoa($('#password').val());
		
    	//alert(password);
		
		if (usuario=='') {
    		$('#error').fadeIn();
				setTimeout(function() {
						$('#error').fadeOut(2000);
				},2000);
    		event.preventDefault();
    	}else{
				setTimeout(function() {
						$('#error').fadeOut(2000);
				},2000);
    	}
    	if (password=='') {
    		$('#error1').fadeIn();
				setTimeout(function() {
						$('#error1').fadeOut(2000);
				},2000);
    		event.preventDefault();
    	}else{
				setTimeout(function() {
						$('#error1').fadeOut(2000);
				},2000);
    	}
		//
	  	//alert(password);

    	$.ajax({                        
	    type: 'POST',                 
	    url: "controllers/sesionControllers.php", 
	    dataType: "json",                    
	    //data: ('')
	    data: $("#login").serialize(),
    		beforeSend: function(){
	    		$('#enviar').val('Connecting..'); 
            },
    		success: function(data){
	        	if(data == 1){
	    			$("#error2").fadeIn();
						setTimeout(function() {
								$('#error2').fadeOut(2000);
						},2000);
	    			event.preventDefault();
	    		}
	           	if (data == 2) {
	           		$("#error3").fadeIn();setTimeout(function() {
										$('#error3').fadeOut(2000);
								},2000);
	    			event.preventDefault();
	           	}
	           	if (data == 3) {
	           		var url = "view/create_docket.php";
					$(location).attr('href',url);
	           	}
	        }
	    })
    	
	});
});

					