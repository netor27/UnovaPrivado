$(function(){
    $("a.borrarCurso").click(function(e) {
        e.preventDefault();
        var id = $(this).attr("id");
        bootbox.dialog("<h4>Se eliminará permanentemente este curso<br>¿Estás seguro?</h4>", 
            [{
                "label" : "Cancelar",
                "class" : "btn"
            }, {
                "label" : "Eliminar",
                "class" : "btn-danger",
                "icon"  : "icon-warning-sign icon-white",
                "callback": function() {
                    $url = "/cursos/curso/eliminar/"+id;
                    redirect($url);
                }
                
            }]);
    });
});