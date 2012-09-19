$(function(){
    $("a.borrarCurso").click(function(e) {
        e.preventDefault();
        var id = $(this).attr("id");
        bootbox.dialog("Se eliminará permanentemente este curso<br>¿Estás seguro?", 
            [{
                "label" : "Eliminar",
                "class" : "btn-danger",
                "icon"  : "icon-warning-sign icon-white",
                "callback": function() {
                    console.log("se eliminara el id "+ id);
                    document.location.href="/cursos/curso/eliminar/"+id;
                }
            }, {
                "label" : "Cancelar",
                "class" : "btn-primary"
            }]);
    });
});