$(document).ready(function(){
    var form = $("#customForm");  
    var nombre = $("#inputNombre");  
    var descripcion = $("#inputDescripcion");  
    var msgError = '<div class="row-fluid"><div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>¡Error! </strong>';
    var aux;    
    function validateNombre(){  
        if(trim(nombre.val()).length < 5 ){  
            aux =  msgError + 'El nombre debe tener por lo menos 5 letras</div></div>';
            $("#errorMessage").html(aux);
            $(nombre).addClass("inputError");
            return false;  
        } else if(trim(nombre.val()).length > 100){
            aux =  msgError + 'El nombre no puede tener más de  100 letras</div></div>';
            $("#errorMessage").html(aux);
            $(nombre).addClass("inputError");
            return false;  
        } else{  
            $(nombre).removeClass("inputError");
            return true;  
        }  
    } 
    function validateDescripcion(){  
        return true;
    } 
   
    form.submit(function(){ 
        if(validateNombre()) 
            if(validateDescripcion())
                return true;  
        return false;  
    });  
});