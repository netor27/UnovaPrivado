$(document).ready(function() {
    $(".cuadro").hover(
        function () {
            $(this).children(".cuadroFooter").addClass("bottomFooterHover");
        }, 
        function () {
            $(this).children(".cuadroFooter").removeClass("bottomFooterHover");
                
        });
        
    $("a.btnQuitar").click(function(e){
        e.preventDefault();
        var id = $(this).attr("id");
        bootbox.dialog("Se eliminará permanentemente al usuario de este grupo<br>¿Estás seguro?", 
            [{
                "label" : "Eliminar",
                "class" : "btn-danger",
                "icon"  : "icon-warning-sign icon-white",
                "callback": function() {
                    $url = "/grupos/usuarios/eliminarInscripcion:ig="+grupo+"&iu="+id+"&pagina="+pagina;
                    redirect($url);
                }
            }, {
                "label" : "Cancelar",
                "class" : "btn-primary"
            }]);
    });
        
        
});