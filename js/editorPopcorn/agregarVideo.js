var videos = [];
var editarVideoBandera = false;
var idEditarVideo = -1;

$(function(){    
    $("#dialog-form-video").dialog({
        autoOpen: false,
        height:450,
        width: 550,
        modal: true,
        resizable: false,
        buttons:{
            "Aceptar": function(){
                if(editarVideoBandera){
                    editarVideo();
                }else{
                    agregarVideo();    
                }                
                $(this).dialog("close");
                $("#urlVideo").val("");
                $('#videoTabs').tabs( "option", "active", 0 );
                $('#colorSeleccionadoVideo').html("");
                guardadoAutomatico();
            },
            "Cancelar": function(){
                $(this).dialog("close");
                $('#videoTabs').tabs( "option", "active", 0 );
                $('#colorSeleccionadoVideo').html("");
            }
        }
    });	 
    $('#videoTabs').tabs();
    
    $("#colorHiddenVideo").val("#FFFFFF");
    $('#colorSelectorVideo').colorpicker({
        color: "#ffffff",
        history: false,
        strings: "Escoje un color,Colores estándar,Más colores,Regresar"
    });
    
    $("#colorSelectorVideo").on("change.color", function(event, color){
        $('#colorSeleccionadoVideo').css('backgroundColor', color);
        $('#colorSeleccionadoVideo').html("");
        $("#colorHiddenVideo").val(color);
    })
       
    $("#sinColorVideo").click(function(){
        $("#colorSelectorVideo").colorpicker("val", "transparent");
        $('#colorSeleccionadoVideo').css('backgroundColor', 'transparent');
        $('#colorSeleccionadoVideo').html("Sin color");
        $("#colorHiddenVideo").val('transparent');        
    });
    $("#sinColorVideo").button();
    //validamos el tiempo que escriben en el campo de texto
    $("#tiempoInicioTexto").change(function() {
        validarTiemposTexto("inicio");
    });
    $("#tiempoFinTexto").change(function() {
        validarTiemposTexto("fin");
    });
});

function mostrarDialogoInsertarVideo(){
    editarVideoBandera = false;    
    pauseVideo();
    var currentTime = getCurrentTime();
    inicializarSlidersVideo(currentTime, currentTime+10);
    $("#dialog-form-video").dialog("open");
}

function cargarVideoEnArreglo(urlVideo, inicio, fin, color, top, left, width, height){
    videos.push({
        urlVideo : urlVideo,
        inicio : inicio,
        fin : fin,
        color : color,
        top : top,
        left : left,
        height : height,
        width: width
    }); 
}

function agregarVideo(){    
    var urlVideo = $("#urlVideo").val();
    var inicio = $("#tiempoInicioVideo").val();
    var fin = $("#tiempoFinVideo").val();
    var color = $("#colorHiddenVideo").val();    
    agregarVideoDiv(videos.length, urlVideo, inicio, fin, color, 50, 50, 20, 18);
    cargarVideoEnArreglo(urlVideo, inicio, fin, color, 50, 50, 20, 18);    
}

function mostrarDialogoEditarVideo(idVideo){
    editarVideoBandera = true;
    idEditarVideo = idVideo;
    pauseVideo();
    $("#urlVideo").val(videos[idVideo].urlVideo);    
    var inicio = stringToSeconds(videos[idVideo].inicio);
    var fin = stringToSeconds(videos[idVideo].fin);    
    var color = videos[idVideo].color;    
    cambiarColorPicker(color,"Video");    
    inicializarSlidersVideo(inicio, fin);
    $("#dialog-form-video").dialog("open");
}

function editarVideo(){
    var urlVideo = $("#urlVideo").val();
    var inicio = $("#tiempoInicioVideo").val();
    var fin = $("#tiempoFinVideo").val();
    var color = $("#colorHiddenVideo").val();
    
    $containmentWidth = getContainmentWidth();
    $containmentHeight  = getContainmentHeight();
    
    var position = $("#video_"+idEditarVideo).offset();    
    position.top = position.top * 100 / $containmentHeight;
    position.left = position.left * 100 / $containmentWidth;     
        
    var width = $("#video_"+idEditarVideo).width();
    var height = $("#video_"+idEditarVideo).height();
    width = width * 100 / $containmentWidth;
    height = height * 100/ $containmentHeight;
    
    cargarVideoEnArreglo(urlVideo, inicio, fin, color, position.top, position.left, width, height);
    
    borrarVideo(idEditarVideo);
}

function agregarVideoDiv(indice, urlVideo, inicio, fin, color, top, left, width, height){
    var textoDiv = '<div id="videoContainer_'+indice+'" class="ui-corner-all videoAgregado stack" style="background-color: '+color+'; position: fixed; top: '+getUnidadPx(top)+'; left: '+getUnidadPx(left)+'; width: '+getUnidadPx(width)+'; height: '+getUnidadPx(height)+';">' +
    '<p class="ui-widget-header dragHandle">Arr&aacute;strame de aqu&iacute;<br></p>'+
    '<div class="elementButtons"id="eb_vid_'+indice+'">' +
    '<a href="#" onclick=mostrarDialogoEditarVideo('+indice+')>'+
    '<div class="ui-state-default ui-corner-all littleBox">' +
    '<span class="ui-icon ui-icon-wrench" >' +
    'Editar' +
    '</span>' +
    '</div>' +
    '</a>'+
    '<a href="#" onclick=dialogoBorrarVideo('+indice+')>'+
    '<div class="ui-state-default ui-corner-all littleBox">' +
    '<span class="ui-icon ui-icon-closethick" >' +
    'Borrar' +
    '</span>' +
    '</div>' +
    '</a>'+    
    '</div>' +
    '<div id="video_'+indice+'" class="videoPopcorn" style="width:98%; height: 98%;position: absolute;top:1%;left:1%;">'+
    '</div>' +
    '</div>';
 
    $popPrincipal.footnote({
        start: inicio,
        end: fin,
        text: textoDiv,
        target: "footnotediv"
    });
    
    $("#videoContainer_"+indice).draggable({
        handle: "p", 
        stack: ".stack",
        containment: "#editorContainment",
        stop: function(event, ui){
            //ui.position - {top, left} current position
            var id = ui.helper.attr("id");
            var indice = id.split("_")[1];
            $containmentWidth = getContainmentWidth();
            $containmentHeight  = getContainmentHeight();
            videos[indice].top = ui.offset.top * 100 / $containmentHeight;
            videos[indice].left = ui.offset.left * 100 / $containmentWidth;
        },
        snap: true
    });
    
    $("#videoContainer_"+indice).hover(function(){
        $("#eb_vid_"+indice).show();
    },function(){
        $("#eb_vid_"+indice).hide();
    })
    
    $("#videoContainer_"+indice).resizable({
        minHeight: 180,
        minWidth: 260,
        stop: function(event, ui){
            //ui.size - {width, height} current size
            var id = ui.helper.attr("id");
            var indice = id.split("_")[1];
            $containmentWidth = getContainmentWidth();
            $containmentHeight  = getContainmentHeight();
            videos[indice].width = ui.size.width * 100 / $containmentWidth;
            videos[indice].height = ui.size.height * 100 / $containmentHeight;
        },
        containment: "#editorContainment"
//      resize: function(event, ui) {
//            $("#video_"+indice).children().each(function() {
//                var orig = $(this);		
//                orig.attr("width", ui.size.width)
//                orig.attr("height", ui.size.height);	
//            });
//        }
    });
    var auxVarVideo = Popcorn.smart('#video_'+indice, urlVideo);
    auxVarVideo.autoplay(false);
    auxVarVideo.pause();
    auxVarVideo.on("playing", function() {    	
        pauseVideo();
    });
}

function dialogoBorrarVideo(indice){
    $( "#modalDialog" ).dialog( "option", "title", "Eliminar video" );
    $("#modalDialog").html("<p>&iquest;Seguro que deseas eliminar este elemento?</p>");    
    $( "#modalDialog" ).dialog({
        draggable: false,
        resizable: false,
        height: 200,
        width: 400,
        modal: true,
        buttons: {
            Si: function() {
                borrarVideo(indice);
                $( this ).dialog( "close" );
                guardadoAutomatico();                
            },
            Cancelar: function() {
                $( this ).dialog( "close" );
            }
        }
    });  
    $( "#modalDialog" ).dialog("open");
}

function borrarVideo(indice){    
    destroyPopcorn();   
    videos.splice(indice,1);
    inicializarPopcorn();        
}

function eliminarVideos(){
    $(".videoAgregado").remove();
    $(".videoAgregado").draggable("destroy");
    $(".videoAgregado").resizable("destroy");
}

function cargarVideos(){    
    var i;    
    for(i=0;i<videos.length;i++){
        agregarVideoDiv(i, videos[i].urlVideo, videos[i].inicio, videos[i].fin, videos[i].color, videos[i].top, videos[i].left, videos[i].width, videos[i].height);
    }
}

//Valida el input de los tiempos en el slider
function validarTiemposVideo($respetar){        
    var $videoDuration = getTotalTime();
    $("#tiempoInicioVideo").val($("#tiempoInicioVideo").val().substr(0, 5));
    $("#tiempoFinVideo").val($("#tiempoFinVideo").val().substr(0, 5));
    
    var $ini = stringToSeconds($("#tiempoInicioVideo").val());
    var $fin = stringToSeconds($("#tiempoFinVideo").val());
    
    //validar los limites inferiores
    if($ini < 0)
        $ini = 0;
    if($fin <= 0)
        $fin = 1;
    
    //validar los limites superiores
    if($ini >= $videoDuration)
        $ini = $videoDuration-1;    
    if($fin > $videoDuration)
        $fin = $videoDuration;
    
    //validar entre inicio y fin
    if($ini >= $fin){
        if($respetar == "inicio"){
            $fin = $ini + 1;
        }else if($respetar == "fin"){
            $ini = $fin - 1;
        }
    }
    $("#tiempoInicioSliderVideo").slider( "option", "value", $ini);    
    $("#tiempoFinSliderVideo").slider( "option", "value", $fin );    
    
    $("#tiempoInicioVideo").val(transformaSegundos($ini));
    $("#tiempoFinVideo").val(transformaSegundos($fin));
}

function inicializarSlidersVideo($inicio, $fin){
    var totalTime = getTotalTime();
    $('#tiempoInicioVideo').val(transformaSegundos($inicio));
    $('#tiempoInicioSliderVideo').slider({
        range: "min",
        min: 0,
        max: totalTime,
        value: $inicio,
        slide: function( event, ui ) {
            $("#tiempoInicioVideo").val(transformaSegundos(ui.value));
            validarTiemposVideo("inicio");
        }
    });
    $('#tiempoFinVideo').val(transformaSegundos($fin));
    $('#tiempoFinSliderVideo').slider({
        range: "min",
        min: 0,
        max: totalTime,
        value: $fin,
        slide: function( event, ui ) {
            $("#tiempoFinVideo").val(transformaSegundos(ui.value));
            validarTiemposVideo("fin");
        }
    });
}
