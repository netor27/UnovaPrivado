$(function(){
    $(".cuadro").hover(
        function () {
            $(this).children(".cuadroFooter").addClass("bottomFooterHover");
        }, 
        function () {
            $(this).children(".cuadroFooter").removeClass("bottomFooterHover");
                
        });
        
    $("a.borrarInscripcion").click(function(e){
        e.preventDefault();
        var id = $(this).attr("id");
        bootbox.dialog("Se eliminará permanentemente al usuario de este  curso<br>¿Estás seguro?", 
            [{
                "label" : "Eliminar",
                "class" : "btn-danger",
                "icon"  : "icon-warning-sign icon-white",
                "callback": function() {
                    $url = "/usuarios.php?c=cursos&a=eliminarInscripcion&ic="+curso+"&iu="+id+"&origen=listaAlumnos"+"&pagina="+pagina;
                    //console.log($url);
                    document.location.href = $url;
                }
            }, {
                "label" : "Cancelar",
                "class" : "btn-primary"
            }]);
    });
        
        
});