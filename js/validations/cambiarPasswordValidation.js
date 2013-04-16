$(document).ready(function(){
    var form = $("#customForm");  
    var passAnterior = $("#inputPassAnt");    
    var pass1 = $("#inputPass1");      
    var pass2 = $("#inputPass2");  
    var msgError = '<div class="row-fluid"><div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>¡Error! </strong>';
    var aux;
    function validatePassAnterior(){
        if(passAnterior.val().length < 1){
            aux =  msgError + 'Introduce tu contraseña anterior</div></div>';            
            $("#errorMessage").html(aux);
            $(passAnterior).addClass("inputError");
            return false;
        }else{
            $(passAnterior).removeClass("inputError");
            return true;
        }
    }
    
    function validatePass1(){  
        if(pass1.val().length <5){  
            aux =  msgError + 'Tu contraseña debe tener mínimo 5 caracteres</div></div>';            
            $("#errorMessage").html(aux);            
            $(pass1).addClass("inputError");
            return false;  
        }else{  
            $(pass1).removeClass("inputError");
            return true;  
        }  
    }  
    function validatePass2(){  
        if( pass1.val() != pass2.val() ){  
            var aux =  msgError + 'Las contraseñas no coinciden</div></div>';            
            $("#errorMessage").html(aux);
            $(pass2).addClass("inputError");
            return false;  
        }else{  
            $(pass2).removeClass("inputError");
            return true;  
        }  
    } 

form.submit(function(){  
        if(validatePassAnterior())
            if(validatePass1())
                if(validatePass2())  
                    return true                    
        return false;  
    });  
});