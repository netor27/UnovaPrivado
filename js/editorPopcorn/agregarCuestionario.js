var cuestionarios = [];
var editarCuestionarioBandera = false;
var idEditar = -1;
var contadorOpcionMultiple=0;
var tipoPregunta = "";

function agregarOpcionDeRespuesta(){
    contadorOpcionMultiple++;
    var dom = '<div class="row-fluid respuestaContainer">'+
    '<div class="span1">'+
    '<input type="checkbox" name="respuesta" class="inputRadio" id="radio-'+contadorOpcionMultiple+'">'+
    '<label for="radio-'+contadorOpcionMultiple+'"></label>'+
    '</div>'+
    '<div class="span10">'+
    '<input placeholder="Escribe una respuesta" type="text" class="span12 opcionTexto">'+
    '</div>'+
    '<div class="span1">'+
    '<button class="btn btn-danger btnQuitarOpcion" style="display:none;">'+
    '<i class="icon-white icon-trash"></i>'+
    '</button>'+
    '</div>'+
    '</div>';
    $("#respuestasContainer").append(dom);
    bindEventoHoverRespuestaRow();
}

function cambioPreguntaCompletarTexto(){
    var str = $(this).val();
    var inicio, fin, answer;
    var hayRespuesta = true;
    while(hayRespuesta){
        inicio = str.indexOf("[");
        fin = str.indexOf("]",inicio);
        if(inicio >= 0 && fin >= 0){
            answer = replaceAll($.trim(str.substring(inicio+1,fin)),'[','');
            answer = replaceAll(answer,']','');
            str = str.substring(0,inicio) + 
            "<input readonly type='text' value='" + 
            answer + "' size='"+answer.length+"' class='inputTextGenerado' />" +
            str.substring(fin+1);
        }else{
            hayRespuesta = false;
        }
    }
    $("#preguntaCompletarResultado").html(str);   
}

function bindEventoHoverRespuestaRow(){
    $(".respuestaContainer").hover(
        function(){
            $(this).find("button").show();
        },function(){
            $(this).find("button").hide();
        });
    $(".btnQuitarOpcion").click(function(){        
        $(this).closest(".respuestaContainer").remove();
    });
}

function mostrarPaginaPregunta(pagina){
    tipoPregunta = pagina;
    $(".paginaPregunta").each(function(){
        $(this).hide();
    });
    $("#"+pagina).show();
}

function mostrarDialogoInsertarCuestionario(){
    clearFormaPregunta();
    editarCuestionarioBandera = false;    
    pauseVideo();
    var currentTime = getCurrentTime();    
    inicializarSlidersCuestionario(currentTime);
    $("#dialog-form-cuestionario").dialog('option', 'title', 'Agregar cuestionario');
    $("#dialog-form-cuestionario").dialog("open");
}

function cargarPreguntaEnArreglo(idPregunta, inicio){
    cuestionarios.push({
        idPregunta : idPregunta, 
        inicio : inicio
    });   
}

function agregarPregunta(){    
    var idTipoControlPregunta, pregunta, respuesta;
    var inicio = $("#tiempoInicioCuestionario").val();
    switch(tipoPregunta){
        case 'preguntaAbierta':
            idTipoControlPregunta = 1;
            pregunta = $.trim($("#preguntaAbiertaTexto").val());
            if(pregunta.length <= 0){
                //no hay pregunta
                return "Escribe tu pregunta";
            }
            respuesta = null;
            break;
        case 'opcionMultiple':
            idTipoControlPregunta = 2;
            pregunta = $.trim($("#preguntaOpcionMultipleTexto").val());
            if(pregunta.length <= 0){
                //no hay pregunta
                return "Escribe tu pregunta";
            }
            respuesta = [];
            var unaCorrecta = false;
            $(".respuestaContainer").each(function(){
                var strOpcion = $.trim($(this).find(".opcionTexto").val());
                strOpcion = strOpcion.replace(/(\r\n|\n|\r)/gm,"");
                if(strOpcion.length > 0){
                    var correcta = ($(this).find(".inputRadio").is(':checked'));
                    if(correcta)
                        unaCorrecta = true;
                    respuesta.push({
                        correcta : correcta,
                        texto : strOpcion
                    });
                }
            });  
            if(!unaCorrecta){
                return "Introduce una opción de respuesta correcta";
            }
            break;
        case 'completarEspacios':
            idTipoControlPregunta = 3;
            pregunta = $.trim($("#preguntaCompletarTexto").val());
            if(pregunta.length <= 0){
                //no hay pregunta
                return "Escribe tu pregunta";
            }
            respuesta = null;
            break;
        default:
            return "Selecciona el tipo de pregunta";
            break;
    }    
    pregunta = pregunta.replace(/(\r\n|\n|\r)/gm,"");    
    //La siguiente es una llamada asincrona
    crearPreguntaBD(idTipoControlPregunta, pregunta, respuesta, inicio);  
    clearFormaPregunta();
    return "ok";
}

function crearPreguntaBD(idTipoControlPregunta, pregunta, respuesta, inicio){
    var preguntaArray = {
        idTipoControlPregunta: idTipoControlPregunta,
        pregunta: pregunta,
        respuesta: respuesta
    };
    var data = {
        u: iu,
        uuid: uuid,
        cu: ic,
        cl: icl,
        pregunta: preguntaArray
    };    
    $.ajax({
        type: 'post',
        cache: false,
        url: '/cursos/control/agregarPregunta',
        data: data
    }).done(function( html ) {
        var res = jQuery.parseJSON(html);        
        if(res.resultado == "error"){
            console.log(res.mensaje);
        }else{
            var idPregunta = res.mensaje;
            cargarPreguntaEnArreglo(idPregunta, inicio);
            guardadoAutomatico();
        }
    });
}

function clearFormaPregunta(){
    mostrarPaginaPregunta('seleccionarTipoPregunta');    
    $("#preguntaAbiertaTexto").val("");
    $("#preguntaOpcionMultipleTexto").val("");
    $("#respuestasContainer").empty();
    agregarOpcionDeRespuesta();
    agregarOpcionDeRespuesta();
    agregarOpcionDeRespuesta();
    $("#preguntaCompletarResultado").empty();
    $("#preguntaCompletarTexto").val("");
    $("#errorContainerPreguntas").empty();
}

//Valida el input de los tiempos en el slider
function validarTiemposCuestionario(){        
    var $videoDuration = getTotalTime();
    $("#tiempoInicioCuestionario").val($("#tiempoInicioCuestionario").val().substr(0, 5));
    var $ini = stringToSeconds($("#tiempoInicioCuestionario").val());
    //validar los limites inferiores
    if($ini < 0)
        $ini = 0;
    //validar los limites superiores
    if($ini >= $videoDuration)
        $ini = $videoDuration-1;    
    $("#tiempoInicioSliderCuestionario").slider( "option", "value", $ini);    
    $("#tiempoInicioCuestionario").val(transformaSegundos($ini));
}

function inicializarSlidersCuestionario($inicio){
    var totalTime = getTotalTime();
    $('#tiempoInicioCuestionario').val(transformaSegundos($inicio));
    $('#tiempoInicioSliderCuestionario').slider({
        range: "min",
        min: 0,
        max: totalTime,
        value: $inicio,
        slide: function( event, ui ) {
            $("#tiempoInicioCuestionario").val(transformaSegundos(ui.value));
            validarTiemposCuestionario();
        }
    });
}

$(document).ready(function() {    
    $("#dialog-form-cuestionario").dialog({
        autoOpen: false,
        height:550,
        width: 960,
        modal: true,
        resizable: false,
        buttons:{
            "Aceptar": function(){
                var sinErrores;
                if(editarCuestionarioBandera){
                    sinErrores = editarPregunta();
                }else{
                    sinErrores = agregarPregunta();    
                }                
                if(sinErrores == "ok"){
                    $(this).dialog("close");
                    $('#cuestionarioTabs').tabs( "option", "active", 0 );
                }else{
                    var msgError = '<div class="row-fluid"><div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>¡Error! </strong>';
                    msgError =  msgError + sinErrores + '</div></div>';
                    $("#errorContainerPreguntas").html(msgError);
                }
            },
            "Cancelar": function(){
                $(this).dialog("close");
            }
        }
    });	    
    //validamos el tiempo que escriben en el campo de texto
    $("#tiempoInicioCuestionario").change(function() {
        validarTiempoCuestionario();
    });
    $('#cuestionarioTabs').tabs();
    $("#btnAgregarOtraOpcion").click(function(){
        agregarOpcionDeRespuesta();
    });
    $("#preguntaCompletarTexto").bind('input propertychange',cambioPreguntaCompletarTexto);
    bindEventoHoverRespuestaRow();
    clearFormaPregunta();
});