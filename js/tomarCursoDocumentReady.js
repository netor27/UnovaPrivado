$(function(){
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
                    bootbox.alert("<strong>Calificación enviada</strong><br><p>"+data+"</p>");
                }
            }); 
        }
    });
});