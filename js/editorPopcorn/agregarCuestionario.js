var preguntas = [];
var editarCuestionarioBandera = false;
var idEditar = -1;
var contadorOpcionMultiple=0;
var tipoPregunta = "";
var idPreguntaPorCambiar = -1;

function agregarOpcionDeRespuesta(texto, correcta){
    var strChecked = "";
    if(correcta)
        strChecked = "checked";
    contadorOpcionMultiple++;
    var dom = '<div class="row-fluid respuestaContainer">'+
    '<div class="span1">'+
    '<input type="checkbox" name="respuesta" '+strChecked+' class="inputRadio" id="radio-'+contadorOpcionMultiple+'">'+
    '<label for="radio-'+contadorOpcionMultiple+'"></label>'+
    '</div>'+
    '<div class="span10">'+
    '<input placeholder="Escribe una respuesta" type="text" class="span12 opcionTexto" value="'+texto+'">'+
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

function generarOpcionDeRespuesta(texto, correcta, readonly){
    var i = Math.floor((Math.random()*10000)+1);
    var strChecked = "", strReadonly ="";
    if(correcta == "true")        
        strChecked = "checked";
    if(readonly)
        strReadonly = 'readonly onclick="javascript: return false;"';
    var dom = '<div class="row-fluid respuestaContainer">'+
    '<div class="span1">'+
    '<input type="checkbox" '+strChecked+' name="respuesta" class="inputRadio" id="radio-'+i+'" '+ strReadonly +'>'+
    '<label for="radio-'+i+'"></label>'+
    '</div>'+
    '<div class="span10">'+
    '<input readonly type="text" class="span12" value="'+texto+'">'+
    '</div>'+
    '</div>';
    return dom;
}

function cambioPreguntaCompletarTexto(){
    var str = procesarTextoPreguntaCompletar($("#preguntaCompletarTexto").val());
    $("#preguntaCompletarResultado").html(str, true);   
}

function procesarTextoPreguntaCompletar(str, readonly){
    var readonlyStr = "";
    var inicio, fin, answer;
    var hayRespuesta = true;
    if(readonly){
        readonlyStr = "readonly";
    }
    while(hayRespuesta){
        inicio = str.indexOf("[");
        fin = str.indexOf("]",inicio);
        if(inicio >= 0 && fin >= 0){
            answer = replaceAll($.trim(str.substring(inicio+1,fin)),'[','');
            answer = replaceAll(answer,']','');
            str = str.substring(0,inicio) + 
            "<input " + readonlyStr + " type='text' value='" + 
            answer + "' size='"+answer.length+"' class='inputTextGenerado' />" +
            str.substring(fin+1);
        }else{
            hayRespuesta = false;
        }
    }
    return str;
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
    clearFormaPregunta(3);
    editarCuestionarioBandera = false;    
    pauseVideo();
    var currentTime = getCurrentTime();    
    inicializarSlidersCuestionario(currentTime);
    $("#dialog-form-cuestionario").dialog('option', 'title', 'Agregar cuestionario');
    $("#dialog-form-cuestionario").dialog("open");
}

function cargarPreguntaEnArreglo(idPregunta, inicio){
    preguntas.push({
        idPregunta : idPregunta, 
        inicio : inicio
    });   
}

function agregarPreguntaDiv(idPregunta, inicio){
    $popPrincipal.cue(inicio,function(){
        mostrarPregunta(idPregunta);
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
    clearFormaPregunta(3);
    return "ok";
}

function editarPregunta(){    
    var pregunta, respuesta;
    var inicio = $("#tiempoInicioCuestionario").val();
    switch(tipoPregunta){
        case 'preguntaAbierta':
            pregunta = $.trim($("#preguntaAbiertaTexto").val());
            if(pregunta.length <= 0){
                //no hay pregunta
                return "Escribe tu pregunta";
            }
            respuesta = null;
            break;
        case 'opcionMultiple':
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
    editarPreguntaBD(idPreguntaPorCambiar, pregunta, respuesta, inicio);
    clearFormaPregunta(3);
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
            agregarPreguntaDiv(idPregunta, inicio);
            guardadoAutomatico();
        }
    });
}

function editarPreguntaBD(idPregunta, pregunta, respuesta, inicio){
    var preguntaArray = {
        idControlPregunta: idPregunta,
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
        url: '/cursos/control/editarPregunta',
        data: data
    }).done(function( html ) {
        var res = jQuery.parseJSON(html);        
        if(res.resultado == "error"){
            console.log(res.mensaje);
        }else{
            eliminarPreguntaDeArreglo(idPregunta);
            cargarPreguntaEnArreglo(idPregunta, inicio);
            agregarPreguntaDiv(idPregunta, inicio);
            guardadoAutomatico();
        }
    });
}

function clearFormaPregunta(numOpciones){
    $(".btnCambiarTipoPregunta").show();
    mostrarPaginaPregunta('seleccionarTipoPregunta');    
    $("#preguntaAbiertaTexto").val("");
    $("#preguntaOpcionMultipleTexto").val("");
    $("#respuestasContainer").empty();
    var i;
    for(i=0;i<numOpciones;i++)
        agregarOpcionDeRespuesta("",false);
    
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

function cargarPreguntas(){
    var i;    
    for(i=0;i<preguntas.length;i++){
        agregarPreguntaDiv(preguntas[i].idPregunta, preguntas[i].inicio);
    }
}

function eliminarPreguntas(){
//no hay nada que eliminar
}

function mostrarPregunta($idPregunta){
    pauseVideo();
    var data = {
        u: iu,
        uuid: uuid,
        cu: ic,
        cl: icl,
        idPregunta: $idPregunta
    };    
    $.ajax({
        type: 'post',
        cache: false,
        url: '/cursos/control/obtenerPregunta',
        data: data
    }).done(function( html ) {
        var res = jQuery.parseJSON(html);        
        
        if(res.resultado == "error"){
            console.log(res.mensaje);
        }else if(res.res == "borrar"){
            //esta pregunta ya no existe en la bd, borrar del arreglo
            eliminarPreguntaDeArreglo($idPregunta);
        }else{
            var pregunta = jQuery.parseJSON(res.mensaje);
            var dom, titulo;
            switch(pregunta.idTipoControlPregunta){
                case '1'://Pregunta abierta
                    titulo = "Pregunta abierta";
                    dom = '<div class="row-fluid">'+
                    '<h3 class="black">'+pregunta.pregunta+'</h3>'+
                    '</div>'+
                    '<div class="row-fluid">'+
                    '<div class="span12">'+
                    '<textarea class="span12" rows="5"></textarea>'+
                    '</div>'+
                    '</div>'+
                    '<div class="row-fluid">'+
                    '<div class="pull-right span6">'+
                    '<button class="btn span6" onclick="mostrarDialogoEditarPregunta('+$idPregunta+')">Editar pregunta</btn>'+
                    '<button class="btn btn-danger span6" onclick="eliminarPregunta('+$idPregunta+')">Eliminar pregunta</btn>'+
                    '</div>'+
                    '</div>';
                    break;
                case '2':
                    titulo = "Pregunta de opción múltiple";
                    dom = '<div class="row-fluid">'+
                    '<h3 class="black">'+pregunta.pregunta+'</h3>'+
                    '</div>';
                    var respuestas = jQuery.parseJSON(pregunta.respuesta);                    
                    var i = 0;
                    for(i=0;i<respuestas.length;i++){
                        dom = dom + generarOpcionDeRespuesta(respuestas[i].texto, respuestas[i].correcta, true);
                    }                                       
                    dom = dom + '<div class="row-fluid">'+
                    '<div class="pull-right span6">'+
                    '<button class="btn span6" onclick="mostrarDialogoEditarPregunta('+$idPregunta+')">Editar pregunta</btn>'+
                    '<button class="btn btn-danger span6" onclick="eliminarPregunta('+$idPregunta+')">Eliminar pregunta</btn>'+
                    '</div>'+
                    '</div>';
                    break;
                case '3':
                    titulo = "Completar los espacios en blanco";
                    dom = '<div class="row-fluid">'+
                    '<h3 class="black">'+procesarTextoPreguntaCompletar(pregunta.pregunta,true)+'</h3>'+
                    '</div>'+
                    '<div class="row-fluid"><h6></h6></div>'+
                    '<div class="row-fluid"><h6></h6></div>'+
                    '<div class="row-fluid"><h6></h6></div>'+
                    '<div class="row-fluid">'+
                    '<div class="pull-right span6">'+
                    '<button class="btn span6" onclick="mostrarDialogoEditarPregunta('+$idPregunta+')">Editar pregunta</btn>'+
                    '<button class="btn btn-danger span6" onclick="eliminarPregunta('+$idPregunta+')">Eliminar pregunta</btn>'+
                    '</div>'+
                    '</div>';                    
                    break;
            }            
            $("#preguntaContainer").html(dom);
            $("#dialog-form-responderPregunta").dialog('option', 'title', titulo);
            $("#dialog-form-responderPregunta").dialog("open");
        }
    });
}

function mostrarDialogoEditarPregunta(idPregunta){
    pauseVideo();
    $("#dialog-form-responderPregunta").dialog("close");
    var data = {
        u: iu,
        uuid: uuid,
        cu: ic,
        cl: icl,
        idPregunta: idPregunta
    };    
    $.ajax({
        type: 'post',
        cache: false,
        url: '/cursos/control/obtenerPregunta',
        data: data
    }).done(function( html ) {
        var res = jQuery.parseJSON(html);        
        
        if(res.resultado == "error"){
            console.log(res.mensaje);
        }else if(res.res == "borrar"){
            //esta pregunta ya no existe en la bd, borrar del arreglo
            eliminarPreguntaDeArreglo($idPregunta);
        }else{
            idPreguntaPorCambiar = idPregunta;
            var pregunta = jQuery.parseJSON(res.mensaje);
            clearFormaPregunta(0);
            editarCuestionarioBandera = true;
            var currentTime = getCurrentTime();    
            inicializarSlidersCuestionario(currentTime);
            $(".btnCambiarTipoPregunta").hide();
            $("#dialog-form-cuestionario").dialog('option', 'title', 'Editar cuestionario');
            $("#dialog-form-cuestionario").dialog("open");
            switch(pregunta.idTipoControlPregunta){
                case '1'://Pregunta abierta
                    $("#preguntaAbiertaTexto").val(pregunta.pregunta);
                    mostrarPaginaPregunta('preguntaAbierta');
                    break;
                case '2':
                    var respuestas = jQuery.parseJSON(pregunta.respuesta);                    
                    var i = 0;
                    for(i=0;i<respuestas.length;i++){
                        agregarOpcionDeRespuesta(respuestas[i].texto,(respuestas[i].correcta == "true"));
                    }                                       
                    $("#preguntaOpcionMultipleTexto").val(pregunta.pregunta);
                    mostrarPaginaPregunta('opcionMultiple');                    
                    break;
                case '3':
                    $("#preguntaCompletarTexto").val(pregunta.pregunta);
                    cambioPreguntaCompletarTexto();
                    mostrarPaginaPregunta('completarEspacios');
                    break;
            }            
        }
    });
}

function eliminarPregunta(idPregunta){
    if(confirm("¿Seguro que deseas eliminar la pregunta?")){
        var data = {
            u: iu,
            uuid: uuid,
            cu: ic,
            cl: icl,
            idPregunta: idPregunta
        };    
        $.ajax({
            type: 'post',
            cache: false,
            url: '/cursos/control/borrarPregunta',
            data: data
        }).done(function( html ) {
            var res = jQuery.parseJSON(html);        
            if(res.res == "error"){
                console.log(res.mensaje);
            }else{
                $("#dialog-form-responderPregunta").dialog("close");
                eliminarPreguntaDeArreglo(idPregunta);
            }
        });
    }   
}

function eliminarPreguntaDeArreglo(idPregunta){
    destroyPopcorn();    
    var i;
    for(i = 0; i < preguntas.length; i++){
        if(preguntas[i].idPregunta == idPregunta){
            preguntas.splice(i,1);
        }
    }
    inicializarPopcorn();   
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
        agregarOpcionDeRespuesta("",false);
    });
    $("#preguntaCompletarTexto").bind('input propertychange',cambioPreguntaCompletarTexto);
    
    bindEventoHoverRespuestaRow();
    clearFormaPregunta(3);
    
    $("#dialog-form-responderPregunta").dialog({
        autoOpen: false,
        height:550,
        width: 750,
        modal: true,
        resizable: false,
        buttons:{
            "Continuar": function(){
                $(this).dialog("close");
                playVideo();
            }
        },
        closeOnEscape: false        
    });	 
});