$(function(){
    if(layout == "desktop"){
        $("#menuClasesLink").click(function(e){
            //cambiamos la flecha
            if($("#flechaClases").hasClass('flechaAbajo')){
                $("#flechaClases").removeClass('flechaAbajo');
                $("#flechaClases").addClass('flechaArriba');  
            }else{
                $("#flechaClases").removeClass('flechaArriba');
                $("#flechaClases").addClass('flechaAbajo');
            }
            $("#flechitaClases").toggle();       
            $("#clases_menu").toggle("swing");  
        });
        //Evento para evitar que se cierre al dar click dentro del menu
        $("#clases_menu").mouseup(function(){
            return false;
        });
        //Evento en todo el body que cierra el menu si no 
        $(document).mouseup(function(e){    
            var id = $(e.target).parents("div").attr("id");
            if(id != "menuClasesLink"){
                cerrarClasesMenu();     
            }
            return true;
        });
    }else {
    //bind para dispositivos con pantalla tactil
    //NO SIRVE NINGÚN LINK SI HAY UN VIDEO ABAJO
    //SI EL VIDEO SE ESCONDE Y LUEGO SE MUESTRA YA NO
    //FUNCIONA. POR ESO SE QUITO ESTA FUNCIONALIDAD
    //
    }
});

function cerrarClasesMenu(){
    $("#clases_menu").hide("swing");
    $("#flechitaClases").hide("swing");       
    $("#flechaClases").removeClass("flechaArriba");
    $("#flechaClases").addClass("flechaAbajo");
}