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
    
    $('#pageMeComments').quickPager({
        pageSize: 5
    });
    $('#pageMePreguntas').quickPager({
        pageSize: 5
    });
    
    var options = {
        beforeSubmit: validarComentario,
        success: function(data) {        
            $("#loadingComment").hide();
            if(data.indexOf("error") == -1){
                bootbox.alert("<strong>Gracias por tu cometnario</strong>");
                $("#pageMeComments").prepend(data);
                $("#noComments").html("");
            }else{
                alert("Ocurrió un error al guardar tu comentario. Intenta de nuevo más tarde");
            }
            $("#comentarButton").show();
            $("#comentario").val("");
        }
    }; 
    $('#comentarioForm').ajaxForm(options);
    
    function validarComentario(formData, jqForm, options){
        $("#comentarButton").hide();
        $("#loadingComment").show();
        if(validate(formData, jqForm, options)){
            return true;
        }else{
            return false;
        }
    }
    
    function validate(formData, jqForm, options) { 
        for (var i=0; i < formData.length; i++) { 
            if (!formData[i].value) { 
                return false; 
            } 
        } 
        return true;
    }
    
    var preguntaOptions = { 
        beforeSubmit: validarPregunta,
        success: function(data) { 
            $("#loadingPregunta").hide();
            if(data.indexOf("error") == -1){
                bootbox.alert("<strong>Tu pregunta ha sido enviada la profesor.</strong>");
                $("#pageMePreguntas").prepend(data);
                $("#noPreguntas").html("");                
            }else{
                alert("Ocurrió un error al guardar tu pregunta. Intenta de nuevo más tarde");
            }
            $("#preguntarButton").show();
            $("#pregunta").val("");
        }
    }; 
    $('#preguntarForm').ajaxForm(preguntaOptions);
    
    function validarPregunta(formData, jqForm, options){
        $("#preguntarButton").hide();
        $("#loadingPregunta").show();
        if(validate(formData, jqForm, options)){
            return true;
        }else{
            return false;
        }
    }
    
    
});