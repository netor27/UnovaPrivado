$(document).ready(function() {
   
    $("a.borrarGrupo").click(function(e){
        e.preventDefault();
        var id = $(this).attr("id");
        bootbox.dialog("<h4>Se eliminará permanentemente el grupo<br>¿Estás seguro?</h4>", 
            [{
                "label" : "Cancelar",
                "class" : "btn"
            }, {
                "label" : "Eliminar",
                "class" : "btn-danger",
                "icon"  : "icon-warning-sign icon-white",
                "callback": function() {
                    $url = "/grupos.php?c=grupo&a=borrar&ig="+id+"&pagina="+pagina;
                    redirect($url);
                }                
            }]);
    });
});