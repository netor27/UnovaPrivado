$(document).ready(function(){
    $("#editor").wysiwyg();
    var form = $("#customForm");  
    var titulo = $("#inputTitulo");  
    var descripcionCorta = $("#inputDescripcion");  
    var msgError = '<div class="row-fluid"><div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>¡Error! </strong>';
    var aux;
    function validateTitulo(){  
        if(trim(titulo.val()).length < 10 ){  
            aux =  msgError + 'El título debe tener por lo menos 10 letras</div></div>';            
            $("#errorMessage").html(aux);
            $(titulo).addClass("inputError");
            return false;  
        } else if(trim(titulo.val()).length > 100){
            aux =  msgError + 'El título no puede tener más de  100 letras</div></div>';            
            $("#errorMessage").html(aux);
            $(titulo).addClass("inputError");
            return false;  
        } else{  
            //Es valido
            $(titulo).removeClass("inputError");
            return true;  
        }  
    }  
    function validateDescripcionCorta(){        
        //Si no es valido        
        if(trim(descripcionCorta.val()).length < 10 ){  
            aux =  msgError + 'La descripción corta debe tener por lo menos 10 letras</div></div>';            
            $("#errorMessage").html(aux);
            $(descripcionCorta).addClass("inputError");
            return false;  
        } else if(trim(descripcionCorta.val()).length > 140){
            aux =  msgError + 'La descripción corta no puede tener más de  140 letras</div></div>';            
            $("#errorMessage").html(aux);
            $(descripcionCorta).addClass("inputError");
            return false;  
        }
        else{  
            //Si es valido 
            $(descripcionCorta).removeClass("inputError");
            return true;  
        }  
    }    
    function validateDescripcion(){
        $("#descripcion").val($('#editor').cleanHtml());
        return true;
    }
    form.submit(function(){  
        if(validateTitulo())
            if(validateDescripcionCorta())
                if(validateDescripcion())
                    return true;
        return false;
    });
});