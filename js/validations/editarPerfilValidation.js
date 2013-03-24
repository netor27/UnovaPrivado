$(document).ready(function(){
    var form = $("#customForm");  
    var nombre = $("#inputNombre");  
    var tituloPersonal = $("#inputTitulo");
    var msgError = '<div class="row-fluid"><div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>¡Error! </strong>';
    var aux;
    
    function validateName(){  
        if(nombre.val().length < 4 ){  
            aux =  msgError + 'Tu nombre debe tener por lo menos 4 letras</div></div>';            
            $("#errorMessage").html(aux);
            return false;  
        } else if(nombre.val().length > 50){
            aux =  msgError + 'Tu nombre no puede tener más de 50 letras</div></div>';            
            $("#errorMessage").html(aux);
            return false;  
        }
        else{
            return true;          
        }
    }  
    function validateTituloPersonal(){  
        if(tituloPersonal.val().length > 100){
            aux =  msgError + 'Tu título personal no puede tener más de 100 letras</div></div>';            
            $("#errorMessage").html(aux);
            return false;  
        }else{  
            return true;  
        }  
    }  
        
    form.submit(function(){  
        if(validateName())
            if(validateTituloPersonal())
                return true;          
        return false;
    });  
});