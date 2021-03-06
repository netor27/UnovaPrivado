$(document).ready(function(){
    var form = $("#customForm");  
    var titulo = $("#inputTitulo");  
    var msgError = '<div class="row-fluid"><div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>¡Error! </strong>';
    var aux;    
    function validateTitulo(){  
        if(trim(titulo.val()).length < 5 ){  
            aux =  msgError + 'El título debe tener por lo menos 5 letras</div></div>';
            $("#errorMessage").html(aux);
            $(titulo).addClass("inputError");
            return false;  
        } else if(trim(titulo.val()).length > 50){
            aux =  msgError + 'El título no puede tener más de  50 letras</div></div>';
            $("#errorMessage").html(aux);
            $(titulo).addClass("inputError");
            return false;  
        } else{  
            $(titulo ).removeClass("inputError");
            return true;  
        }  
    } 
   
    form.submit(function(){  
        if(validateTitulo())  
            return true  
        else  
            return false;  
    });  
});