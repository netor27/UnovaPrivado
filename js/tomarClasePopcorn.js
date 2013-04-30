var $popPrincipal;
var $indice = 0;

$(document).ready(function() {    
    validarSesion();
    var segundos  = 30;
    setInterval(validarSesion, segundos * 1000);
    console.log("Se dejo el click derecho para el desarrollo, quitarlo para production");
    //    $("body").bind("contextmenu", function(e) {
    //        e.preventDefault();
    //    });
    //mantener la sesión abierta
    KeepAlive();
    setInterval(KeepAlive, '600000');
    $("#dialog-form-responderPregunta").dialog({
        autoOpen: false,
        height:550,
        width: 750,
        modal: true,
        resizable: false,
        buttons:{
            "Continuar": function(){
                $(this).dialog("close");
                $popPrincipal.play();
            }
        },
        closeOnEscape: false        
    });	 
});

function validarSesion(){
    $.ajax({
        type: "get",
        url: "/usuarios.php?a=validarLoginUnicoAjax" ,
        dataType: "text",
        success: function(data) {
            var str = data.toString();
            if(str.indexOf("valid session") != -1){  
            //Es una sesión válida
            }else{
                //Ya no es una sesión válida. Redireccionando..
                redirect("/?e=1&msg=sesionNoValida");
            }
        }
    });
}

Popcorn( function() {
    $popPrincipal = Popcorn('#mediaPopcorn');
    $popPrincipal.controls(true);
    $popPrincipal.volume(0.5);
    $popPrincipal.autoplay(true);
    cargarElementosGuardados();
});

function pauseVideo(){
    $popPrincipal.pause();
}

function getUnidadPx(unidad){
    if(unidad.indexOf("auto") != -1){
        return unidad;
    }else{
        return unidad + "%";
        
    }
}

function agregarTextoDiv(texto, inicio, fin, color, top, left, width, height){
    var textoDiv = '<div id="drag_'+$indice+'" class="ui-corner-all textoAgregado stack draggable" style="overflow:auto;background-color: '+color+'; position: fixed; top: '+getUnidadPx(top)+'; left: '+getUnidadPx(left)+'; width: '+getUnidadPx(width)+'; height: '+getUnidadPx(height)+';">' +
    '<div id="content_'+$indice+'" style="width: 100%;height: 100%;overflow-y: auto;overflow-wrap: break-word;">'+
    '<div>' +
    texto +
    '</div>' +
    '</div>' +
    '</div>';
 
    $popPrincipal.footnote({
        start: inicio,
        end: fin,
        text: textoDiv,
        target: "footnotediv"
    });
    $("#drag_"+$indice).draggable({
        handle: "#content_"+$indice,
        containment: "#editorContainment",
        stack: ".stack",
        start: function() {
            // if we're scrolling, don't start and cancel drag
            if ($(this).data("scrolled")) {
                $(this).data("scrolled", false).trigger("mouseup");
                return false;
            }
        }
    }).find("*").addBack().scroll(function() {               
        // bind to the scroll event on current elements, and all children.
        //  we have to bind to all of them, because scroll doesn't propagate.
        
        //set a scrolled data variable for any parents that are draggable, so they don't drag on scroll.
        $(this).parents(".ui-draggable").data("scrolled", true);
        
    });
    $indice++;
}

function agregarImagenDiv(urlImagen, inicio, fin, color, top, left, width, height){
    var textoDiv = '<div id="drag_'+$indice+'"  class="ui-corner-all imagenAgregada stack draggable" style="background-color: '+color+'; position: fixed; top: '+getUnidadPx(top)+'; left: '+getUnidadPx(left)+'; width: '+getUnidadPx(width)+'; height: '+getUnidadPx(height)+';">' +
    '<div>'+
    '<img src="'+urlImagen+'" style="width:98%; height: 98%;position: absolute;top:1%;left:1%;"/>'+
    '</div>' +
    '</div>';
 
    $popPrincipal.footnote({
        start: inicio,
        end: fin,
        text: textoDiv,
        target: "footnotediv"
    });
    $("#drag_"+$indice).draggable({
        containment: "#editorContainment",
        stack: ".stack"
    });
    $indice++;
}

function agregarLinkDiv(texto, url, inicio, fin, color, top, left, width, height){
    var textoDiv = '<div id="link_'+$indice+'" class="ui-corner-all linkAgregado stack draggable" style="background-color: '+color+'; position: fixed; top: '+getUnidadPx(top)+'; left: '+getUnidadPx(left)+'; width: '+getUnidadPx(width)+'; height: '+getUnidadPx(height)+';">'+
    '<p class="ui-widget-header dragHandle">Arr&aacute;strame de aqu&iacute;<br></p>'+
    '</div>';
    $popPrincipal.footnote({
        start: inicio,
        end: fin,
        text: textoDiv,
        target: "footnotediv"
    });    
    $("#link_"+$indice).draggable({
        handle: "p", 
        containment: "#editorContainment",
        stack: ".stack"
    });
    $popPrincipal.webpage({
        id: "webpages_"+$indice,
        start: inicio,
        end: fin,
        src: url,
        target: "link_"+$indice
    });
    $indice++;
}

var $idVideo = 0;
function agregarVideoDiv(urlVideo, inicio, fin, color, top, left, width, height){
    var indiceVideo = $idVideo;
    $idVideo++;
    var textoDiv = '<div id="videoContainer_'+indiceVideo+'" class="ui-corner-all videoAgregado draggable" style="background-color: '+color+'; position: fixed; top: '+getUnidadPx(top)+'; left: '+getUnidadPx(left)+'; width: '+getUnidadPx(width)+'; height: '+getUnidadPx(height)+';">' +
    '<p class="ui-widget-header dragHandle">Arr&aacute;strame de aqu&iacute;<br></p>'+
    '<div id="video_'+indiceVideo+'" class="videoPopcorn" style="width:98%; height: 98%;position: absolute;top:1%;left:1%;">'+
    '</div>' +
    '</div>';
 
    $popPrincipal.footnote({
        start: inicio,
        end: fin,
        text: textoDiv,
        target: "footnotediv"
    });
    var auxVarVideo = Popcorn.smart('#video_'+indiceVideo, urlVideo);
    auxVarVideo.autoplay(false);
    auxVarVideo.pause();
    auxVarVideo.on("playing", function() {    	
        pauseVideo();
    });
    $("#videoContainer_"+indiceVideo).draggable({
        handle: "p",
        containment: "#editorContainment",
        stack: ".stack"
    });
}

function agregarPreguntaDiv(idPregunta, inicio){
    $popPrincipal.cue(inicio,function(){
        mostrarPregunta(idPregunta);
    });
}

function mostrarPregunta($idPregunta){
    pauseVideo();
    var data = {
        idPregunta: $idPregunta
    };    
    $.ajax({
        type: 'post',
        cache: false,
        url: '/cursos/control/obtenerPreguntaAlumno',
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
                    '<textarea class="span12" rows="5" id="respuestaTexto"></textarea>'+
                    '</div>'+
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
                        dom = dom + generarOpcionDeRespuesta(respuestas[i].texto, "false", false);
                    }
                    break;
                case '3':
                    titulo = "Completar los espacios en blanco";
                    dom = '<div class="row-fluid">'+
                    '<h3 class="black">'+procesarTextoPreguntaCompletar(pregunta.pregunta,false)+'</h3>'+
                    '</div>'+
                    '<div class="row-fluid"><h6></h6></div>'+
                    '<div class="row-fluid"><h6></h6></div>'+
                    '<div class="row-fluid"><h6></h6></div>';                    
                    break;
            }            
            $("#preguntaContainer").html(dom);
            $("#dialog-form-responderPregunta").dialog('option', 'title', titulo);
            $("#dialog-form-responderPregunta").dialog("open");
        }
    });
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
    '<h4 class="black">'+texto+'</h4>'+
    '</div>'+
    '</div>';
    return dom;
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
            "<input " + readonlyStr + " type='text' value='" + "' size='"+answer.length+"' class='inputTextGenerado' />" +
            str.substring(fin+1);
        }else{
            hayRespuesta = false;
        }
    }
    return str;
}
