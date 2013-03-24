$(document).ready(function(){
    var form = $("#customForm");  
    var titulo = $("#inputTitulo");  
    
    function validateTitulo(){  
        if(trim(titulo.val()).length < 5 ){  
            $('#inputTitulo').attr("data-original-title","Error");
            $('#inputTitulo').attr("data-content","El título debe tener por lo menos 5 letras");
            $('#inputTitulo').attr("data-placement","top");
            $('#inputTitulo').popover("show");
            return false;  
        } else if(trim(titulo.val()).length > 50){
            $('#inputTitulo').attr("data-original-title","Error");
            $('#inputTitulo').attr("data-content","El título no puede tener más de  50 letras");
            $('#inputTitulo').attr("data-placement","top");
            $('#inputTitulo').popover('show');
            return false;  
        } else{  
            //Es valido
            $('#inputTitulo').popover('hide');
            return true;  
        }  
    } 
   
    //On blur
    titulo.blur(validateTitulo);  
    
    form.submit(function(){  
        if(validateTitulo())  
            return true  
        else  
            return false;  
    });  
});