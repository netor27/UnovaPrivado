$(function(){
    $("a.borrarGrupo").click(function(e){
        e.preventDefault();
        var id = $(this).attr("id");
        bootbox.dialog("Se quitará permanentemente el grupo de este curso<br>¿Estás seguro?", 
            [{
                "label" : "Eliminar",
                "class" : "btn-danger",
                "icon"  : "icon-warning-sign icon-white",
                "callback": function() {
                    $url = "/grupos/cursos/eliminarGrupoDeCurso:ig="+id+"&ic="+curso+"&pagina="+pagina;
                    redirect($url);
                }
            }, {
                "label" : "Cancelar",
                "class" : "btn-primary"
            }]);
    });
});