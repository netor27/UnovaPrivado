$(function(){
   
    $("a.borrarGrupo").click(function(e){
        e.preventDefault();
        var id = $(this).attr("id");
        bootbox.dialog("Se eliminará permanentemente el grupo<br>¿Estás seguro?", 
            [{
                "label" : "Eliminar",
                "class" : "btn-danger",
                "icon"  : "icon-warning-sign icon-white",
                "callback": function() {
                    $url = "/grupos.php?c=grupo&a=borrar&ig="+id+"&pagina="+pagina;
                    redirect($url);
                }
            }, {
                "label" : "Cancelar",
                "class" : "btn-primary"
            }]);
    });
});