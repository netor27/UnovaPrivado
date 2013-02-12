$(function(){
    $(".cuadro").hover(
        function () {
            $(this).children(".cuadroFooter").addClass("bottomFooterHover");
        }, 
        function () {
            $(this).children(".cuadroFooter").removeClass("bottomFooterHover");
        });
    $("a.borrarUsuario").click(function(e){
        e.preventDefault();
        var id = $(this).attr("id");
        bootbox.dialog("<h4>Se eliminará permanentemente el usuario<br>¿Estás seguro?</h4>", 
            [{
                "label" : "Cancelar",
                "class" : "btn"
            }, {
                "label" : "Eliminar",
                "class" : "btn-danger",
                "icon"  : "icon-warning-sign icon-white",
                "callback": function() {
                    $url = "/usuarios.php?c=usuario&a=eliminar&iu="+id+"&pagina="+pagina+"&tipo="+tipo;
                    redirect($url);
                }
                
            }]);
    });
});