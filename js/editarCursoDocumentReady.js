$(function(){    
    $('.wow').rating();    
    $("#cursoTabs").tabs();    
    var i;
    var n = 0;
    try{
        n = document.getElementById("numTemas").value;
    }catch(err){
        n = 0;
    }    
    for(i=0; i < n; i++){            
        makeSortable(i);
    }    
    $('.deleteTema').click(function() {
        var me = $(this);
        var parent = $(this).closest('.temaContainer');
        var url = '/temas/tema/borrarTema/' + $(this).attr('curso') + "/" + $(this).attr('id');        
        bootbox.dialog("<h4 class='black'>Se eliminará permanentemente el tema.<br> ¿Estás seguro?</h4>",
            [{
                "label" : "Cancelar",
                "class" : "btn"                
            }, {
                "label" : "Eliminar",
                "class" : "btn-danger",
                "icon"  : "icon-warning-sign icon-white",
                "callback": function() {
                    $.ajax({
                        type: 'get',
                        url: url, 
                        success: function(data) {
                            var str = data.toString();                
                            if(str.indexOf("ok") != -1){                    
                                parent.remove();
                            }else{      
                                bootbox.alert(data);
                            }                
                        }
                    });
                }
            }]);
    });
    
    $('.deleteClase').click(function() {
        var parent = $(this).closest('.claseContainer');        
        var url = '/clases/clase/borrarClase/' + $(this).attr('curso') + "/" + $(this).attr('id');
        var me = $(this);
        bootbox.dialog("<h4 class='black'>Se eliminará la clase permanentemente.<br>¿Estás seguro?</h4>",
            [{
                "label" : "Cancelar",
                "class" : "btn"                
            }, {
                "label" : "Eliminar",
                "class" : "btn-danger",
                "icon"  : "icon-warning-sign icon-white",
                "callback": function() {
                    $.ajax({
                        type: 'get',
                        url: url, 
                        success: function(data) {
                            var str = data.toString();                
                            if(str.indexOf("success") != -1){                    
                                parent.remove();
                            }else{
                                bootbox.alert(data);
                            }
                        }
                    });   
                }
            }]);
    });    
    $(".mensajeArrastrarContainer").popover({
        trigger: 'hover',        
        placement: 'top',
        title: 'Ordenanos arrastrandonos con tu mouse',
        content: 'Puedes arrastrarnos con el mouse para establecer el orden que tu quieras.'        
    });    
});

function makeSortable(num){
    var idTema = document.getElementById("idTema"+num).value;
    $( "#sortable" + num ).sortable({        
        cursor: "move",
        placeholder: "ui-widget-header",
        forcePlaceholderSize: true,
        connectWith: ".connectedSortable",           
        update : function () {    
            //Eliminamos el popover
            $(".mensajeArrastrarContainer").popover("destroy");
            //alert("actualize " + num + " i ="+i);           
            serial = $('#sortable'+num).sortable('serialize');                 
            $.ajax({
                url: "/cursos.php?c=ordenarClases&a=ordenar&idTema="+idTema,
                type: "post",
                data: serial,
                error: function(){
                    alert("Ocurrió un error al actualizar el orden de las clases");
                },
                success: function(data){
                //$("#cursoTabs").append(data);
                }
            });
        }
    });
}