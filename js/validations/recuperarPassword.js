$(document).ready(function(){
    var form = $("#customForm");  
    var correo = $("#inputEmail");  
    var msgError = '<div class="row-fluid"><div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>¡Error! </strong>';
    var aux;
    
    function validateCorreo(){  
        if(validateEmail(correo.val())){  
            //Es valido
            return true;  
        } else {  
            aux =  msgError + 'Introduce un correo electrónico válido</div></div>';            
            $("#errorMessage").html(aux);
            return false;  
        }  
    } 
    form.submit(function(){  
        if(validateCorreo())  
            return true  
        else  
            return false;  
    });  
});