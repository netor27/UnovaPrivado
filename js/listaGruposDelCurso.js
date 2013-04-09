$(document).ready(function() {
    $("a.borrarGrupo").click(function(e){
        e.preventDefault();
        var id = $(this).attr("id");
        bootbox.dialog("<h4>Se quitará permanentemente el grupo de este curso<br>¿Estás seguro?</h4>", 
            [{
                "label" : "Cancelar",
                "class" : "btn"
            }, {
                "label" : "Eliminar",
                "class" : "btn-danger",
                "icon"  : "icon-warning-sign icon-white",
                "callback": function() {
                    $url = "/grupos/cursos/eliminarGrupoDeCurso:ig="+id+"&ic="+curso+"&pagina="+pagina;
                    redirect($url);
                }
            }]);
    });
});