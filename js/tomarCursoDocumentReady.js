$(document).ready(function() {
    $('.wow').rating();
    $('.calificar').rating({
        callback: function(value, link){        
            if(value == undefined)
                value = 0;
            var ic = $("#ic").val();
            var iu = $("#iu").val();
            var url = '/cursos.php?a=calificarCurso&ic=' + ic + '&iu=' + iu + '&rating=' + value;            
            $.ajax({
                type: 'get',
                url: url,             
                success: function(data) {
                    var res = jQuery.parseJSON(data);        
                    console.log(res);
                    if(res.res){                                           
                        var aux = parseInt(res.rating * 4, 10);
                        if(aux > 0)
                            aux = aux - 1;
                        else{
                            aux = false;
                        }
                        console.log("Poner valor = "+aux);
                        
                        $('input.wow').rating('readOnly',false);
                        $('input.wow').rating('select',aux);                        
                        $('input.wow').rating('readOnly');
                    //bootbox.alert("<strong>Calificación enviada</strong><br><p>"+res.msg+"</p>");
                    }else{
                    //bootbox.alert("<strong>Error al guardar tu calificación</strong><br><p>"+res.msg+"</p>");
                    }                    
                }
            }); 
        }
    }); 
});