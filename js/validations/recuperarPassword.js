$(document).ready(function(){
    var form = $("#customForm");  
    var correo = $("#inputEmail");  
    
    function validateCorreo(){  
        if(validateEmail(correo.val())){  
            //Es valido
            $('#inputEmail').popover('hide');
            return true;  
        } else {  
            $('#inputEmail').attr("data-original-title","Error");
            $('#inputEmail').attr("data-content","Introduce un correo electrónico válido");
            $('#inputEmail').popover("show");
            return false;  
        }  
    } 
   
    //On blur
    correo.blur(validateCorreo);  
    
    form.submit(function(){  
        if(validateCorreo())  
            return true  
        else  
            return false;  
    });  
});