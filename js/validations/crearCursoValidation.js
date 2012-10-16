$(document).ready(function(){
    var form = $("#customForm");  
    var titulo = $("#inputTitulo");  
    var descripcionCorta = $("#inputDescripcion");  
    $('#inputTitulo').popover({
        trigger: "manual"
    });
    $('#inputDescripcion').popover({
        trigger: "manual"
    });

    function validateTitulo(){  
        if(trim(titulo.val()).length < 10 ){  
            $('#inputTitulo').attr("data-original-title","Error");
            $('#inputTitulo').attr("data-content","El título debe tener por lo menos 10 letras");
            $('#inputTitulo').popover("show");
            return false;  
        } else if(trim(titulo.val()).length > 100){
            $('#inputTitulo').attr("data-original-title","Error");
            $('#inputTitulo').attr("data-content","El título no puede tener más de  100 letras");
            $('#inputTitulo').popover('show');
            return false;  
        } else{  
            //Es valido
            $('#inputTitulo').popover('hide');
            return true;  
        }  
    }  
    function validateDescripcionCorta(){        
        //Si no es valido        
        if(trim(descripcionCorta.val()).length < 10 ){  
            $('#inputDescripcion').attr("data-original-title","Error");
            $('#inputDescripcion').attr("data-content","La descripción corta debe tener por lo menos 10 letras");
            $('#inputDescripcion').popover("show");
            return false;  
        } else if(trim(descripcionCorta.val()).length > 140){
            $('#inputDescripcion').attr("data-original-title","Error");
            $('#inputDescripcion').attr("data-content","La descripción corta no puede tener más de  140 letras");
            $('#inputDescripcion').popover('show');
            return false;  
        }
        else{  
            //Si es valido 
            $('#inputDescripcion').popover("hide");
            return true;  
        }  
    }    
    function trimDescripcionCorta(){
        if(trim(descripcionCorta.val()).length > 140){
            var str = trim(descripcionCorta.val());
            str = str.substr(0, 140);
            descripcionCorta.val(str);
            $('#inputDescripcion').attr("data-original-title","Error");
            $('#inputDescripcion').attr("data-content","La descripción corta no puede tener más de  140 letras");
            $('#inputDescripcion').popover('show');
        }
    }
    
    //On blur
    titulo.blur(validateTitulo);  
    descripcionCorta.blur(validateDescripcionCorta);  
//    //On key press  
//    titulo.keyup(validateTitulo);  
    descripcionCorta.keyup(trimDescripcionCorta);

    form.submit(function(){  
        var t = validateTitulo();
        var d = validateDescripcionCorta();
        return (t && d);
    });
});