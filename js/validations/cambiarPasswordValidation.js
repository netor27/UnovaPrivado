$(document).ready(function(){
    var form = $("#customForm");  
    var passAnterior = $("#inputPassAnt");    
    var pass1 = $("#inputPass1");      
    var pass2 = $("#inputPass2");  

    function validatePassAnterior(){
        if(passAnterior.val().length < 1){
            $('#inputPassAnt').attr("data-original-title","Error");
            $('#inputPassAnt').attr("data-content","Introduce tu contraseña anterior");
            $('#inputPassAnt').popover("show");
            return false;
        }else{
            $('#inputPassAnt').popover("hide");
            return true;
        }
    }
    
    function validatePass1(){  
        if(pass1.val().length <5){  
            $('#inputPass1').attr("data-original-title","Error");
            $('#inputPass1').attr("data-content","Tu contraseña debe tener mínimo 5 caracteres");
            $('#inputPass1').popover("show");
            return false;  
        }else{  
            $('#inputPass1').popover("hide");
            return true;  
        }  
    }  
    function validatePass2(){  

        if( pass1.val() != pass2.val() ){  
            $('#inputPass2').attr("data-original-title","Error");
            $('#inputPass2').attr("data-content","Las contraseñas no coinciden");
            $('#inputPass2').popover("show");
            return false;  
        }else{  
            $('#inputPass2').popover("hide");
            return true;  
        }  
    } 

    //On blur
    passAnterior.blur(validatePassAnterior);
    pass1.blur(validatePass1);  
    pass2.blur(validatePass2);      

    form.submit(function(){  
        if(validatePassAnterior() && validatePass1() && validatePass2())  
            return true  
        else  
            return false;  
    });  
});