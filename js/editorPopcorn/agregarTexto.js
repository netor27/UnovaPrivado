var textos = [];
var editarTextoBandera = false;
var idEditar = -1;

$(document).ready(function() {    
    $("#dialog-form-texto").dialog({
        autoOpen: false,
        height:550,
        width: 660,
        modal: true,
        resizable: false,
        buttons:{
            "Aceptar": function(){
                if(editarTextoBandera){
                    editarTexto();
                }else{
                    agregarTexto();    
                }                
                $(this).dialog("close");
                $('#textoTinyMce').html("");
                $('#textTabs').tabs( "option", "active", 0 );
                $('#colorSeleccionadoTexto').html("");
                guardadoAutomatico();
            },
            "Cancelar": function(){
                $(this).dialog("close");
                $('#textoTinyMce').html("");
                $('#textTabs').tabs( "option", "active", 0 );
                $('#colorSeleccionadoTexto').html("");
            }
        }
    });	
    
    $("#colorHiddenTexto").val("#FFFFFF");
    $('#colorSelectorTexto').colorpicker({
        color: "#ffffff",
        history: false,
        strings: "Escoje un color,Colores estándar,Más colores,Regresar"
    });
    
    $("#colorSelectorTexto").on("change.color", function(event, color){
        $('#colorSeleccionadoTexto').css('backgroundColor', color);
        $('#colorSeleccionadoTexto').html("");
        $("#colorHiddenTexto").val(color);
    })
    
    $('#textoTinyMce').tinymce({
        script_url : '/lib/js/tiny_mce/tiny_mce.js',
        theme : "advanced",
        skin:"o2k7",    
        skin_variant:"silver",
        width : "600",        
        height : "320",             
        language : 'es',
        // Theme options - button# indicated the row# only
        theme_advanced_buttons1 : "fontselect,fontsizeselect,|,bold,italic,underline,|,forecolor,backcolor,|,justifyleft,justifycenter,justifyright,|,bullist,numlist",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",      
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "none"
    });  
    
    $('#textTabs').tabs();
    
    $("#sinColorTexto").click(function(){
        $("#colorSelectorTexto").colorpicker("val", "transparent");
        $('#colorSeleccionadoTexto').css('backgroundColor', 'transparent');
        $('#colorSeleccionadoTexto').html("Sin color");
        $("#colorHiddenTexto").val('transparent');        
    });
    $("#sinColorTexto").button();
    
    //validamos el tiempo que escriben en el campo de texto
    $("#tiempoInicioTexto").change(function() {
        validarTiemposTexto("inicio");
    });
    $("#tiempoFinTexto").change(function() {
        validarTiemposTexto("fin");
    });
});

function mostrarDialogoInsertarTexto(){    
    editarTextoBandera = false;    
    pauseVideo();
    var currentTime = getCurrentTime();
    inicializarSlidersTexto(currentTime, currentTime+10);
    $("#dialog-form-texto").dialog('option', 'title', 'Agregar texto');
    $("#dialog-form-texto").dialog("open");
}

function cargarTextoEnArreglo(texto, inicio, fin, color, top, left, width, height){
    textos.push({
        texto : texto, 
        inicio : inicio,
        fin : fin,
        color : color,
        top : top,
        left : left,
        height : height,
        width: width
    });   
}

function agregarTexto(){    
    var texto = $("#textoTinyMce").tinymce().getContent();
    texto = texto.replace(/(\r\n|\n|\r)/gm,"");
    var inicio = $("#tiempoInicioTexto").val();
    var fin = $("#tiempoFinTexto").val();
    var color = $("#colorHiddenTexto").val();
    agregarTextoDiv(textos.length, texto, inicio, fin, color, 50, 50, 'auto', 'auto');
    cargarTextoEnArreglo(texto, inicio, fin, color, 50, 50, 'auto', 'auto');    
}

function mostrarDialogoEditarTexto(idTexto){
    editarTextoBandera = true;
    idEditar = idTexto;
    pauseVideo();
    $('#textoTinyMce').html(textos[idTexto].texto);    
    var inicio = stringToSeconds(textos[idTexto].inicio);
    var fin = stringToSeconds(textos[idTexto].fin);
    var color = textos[idTexto].color;    
    cambiarColorPicker(color,"Texto");    
    inicializarSlidersTexto(inicio, fin);
    $("#dialog-form-texto").dialog('option', 'title', 'Editar texto');
    $("#dialog-form-texto").dialog("open");
}

function editarTexto(){
    var texto = $("#textoTinyMce").tinymce().getContent();
    texto = texto.replace(/(\r\n|\n|\r)/gm,"");
    var inicio = $("#tiempoInicioTexto").val();
    var fin = $("#tiempoFinTexto").val();
    var color = $("#colorHiddenTexto").val();
    
    $containmentWidth = getContainmentWidth();
    $containmentHeight  = getContainmentHeight();
    
    var top = $("#texto_"+idEditar).draggable().offset().top;        
    var left = $("#texto_"+idEditar).draggable().offset().left;        
    top = top * 100 / $containmentHeight;
    left = left * 100 / $containmentWidth;    
    
    var width = $("#texto_"+idEditar).width();
    var height = $("#texto_"+idEditar).height();
    width = width * 100 / $containmentWidth;
    height = height * 100/ $containmentHeight;
    
    cargarTextoEnArreglo(texto, inicio, fin, color, top, left, width, height);
    borrarTexto(idEditar);
}

function agregarTextoDiv(indice, texto, inicio, fin, color, top, left, width, height){
    var textoDiv = '<div id="texto_'+indice+'" class="ui-corner-all textoAgregado stack draggable" style="background-color: '+color+'; position: fixed; top: '+getUnidadPx(top)+'; left: '+getUnidadPx(left)+'; width: '+getUnidadPx(width)+'; height: '+getUnidadPx(height)+';">' +
    '<div id="content_'+indice+'" style="width: 100%;height: 100%;overflow-y: auto;overflow-wrap: break-word;">'+
    '<div class="elementButtons" id="eb_txt_'+indice+'">' +
    '<a href="#" onclick=mostrarDialogoEditarTexto('+indice+')>'+
    '<div class="ui-state-default ui-corner-all littleBox">' +
    '<span class="ui-icon ui-icon-wrench" >' +
    'Editar' +
    '</span>' +
    '</div>' +
    '</a>'+
    '<a href="#" onclick=dialogoBorrarTexto('+indice+')>'+
    '<div class="ui-state-default ui-corner-all littleBox">' +
    '<span class="ui-icon ui-icon-closethick" >' +
    'Borrar' +
    '</span>' +
    '</div>' +
    '</a>'+    
    '</div>' +
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
    
    $("#texto_"+indice).draggable({
        handle: "#content_"+indice,
        containment: "#editorContainment",
        stack: ".stack",
        stop: function(event, ui){
            //ui.position - {top, left} current position
            var id = ui.helper.attr("id");
            var indice = id.split("_")[1];
            $containmentWidth = getContainmentWidth();
            $containmentHeight = getContainmentHeight();
            textos[indice].top = ui.offset.top * 100 / $containmentHeight;
            textos[indice].left = ui.offset.left * 100 / $containmentWidth;
        },
        snap: true,
        start: function() {
            // if we're scrolling, don't start and cancel drag
            if ($(this).data("scrolled")) {
                $(this).data("scrolled", false).trigger("mouseup");
                return false;
            }
            return true;
        }
    }).find("*").andSelf().scroll(function() {               
        // bind to the scroll event on current elements, and all children.
        //  we have to bind to all of them, because scroll doesn't propagate.        
        //set a scrolled data variable for any parents that are draggable, so they don't drag on scroll.
        $(this).parents(".ui-draggable").data("scrolled", true);
        
    });
    
    $("#texto_"+indice).hover(function(){
        $("#eb_txt_"+indice).show();
    },function(){
        $("#eb_txt_"+indice).hide();
    })
    
    $("#texto_"+indice).resizable({
        minHeight: 50,
        minWidth: 50,
        stop: function(event, ui){
            //ui.size - {width, height} current size
            var id = ui.helper.attr("id");
            var indice = id.split("_")[1];            
            $containmentWidth = getContainmentWidth();
            $containmentHeight  = getContainmentHeight();
            textos[indice].height = ui.size.height * 100/ $containmentHeight;
            textos[indice].width = ui.size.width * 100 / $containmentWidth;
        },
        containment: "#editorContainment"
    });
}

function dialogoBorrarTexto(indice){
    $( "#modalDialog" ).dialog( "option", "title", "Eliminar texto" );
    $("#modalDialog").html("<p>&iquest;Seguro que deseas eliminar este elemento?</p>");
    $( "#modalDialog" ).dialog({
        draggable: false,
        resizable: false,
        height: 200,
        width: 400,
        modal: true,
        buttons: {
            Si: function() {
                borrarTexto(indice);                
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

function borrarTexto(indice){    
    destroyPopcorn();    
    textos.splice(indice,1);
    inicializarPopcorn();   
}

function eliminarTextos(){
    $(".textoAgregado").remove();
    $(".textoAgregado").draggable("destroy");
    $(".textoAgregado").resizable("destroy");
}

function cargarTextos(){    
    var i;    
    for(i=0;i<textos.length;i++){
        agregarTextoDiv(i, textos[i].texto, textos[i].inicio, textos[i].fin, textos[i].color, textos[i].top, textos[i].left, textos[i].width, textos[i].height);
    }
}

function validarTiemposTexto($respetar){        
    var $videoDuration = getTotalTime();
    $("#tiempoInicioTexto").val($("#tiempoInicioTexto").val().substr(0, 5));
    $("#tiempoFinTexto").val($("#tiempoFinTexto").val().substr(0, 5));
    
    var $ini = stringToSeconds($("#tiempoInicioTexto").val());
    var $fin = stringToSeconds($("#tiempoFinTexto").val());
    
    console.log("Validando tiempos ["+$ini+","+$fin+"]");
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
    $("#tiempoInicioSliderTexto").slider( "option", "value", $ini);    
    $("#tiempoFinSliderTexto").slider( "option", "value", $fin );    
    
    $("#tiempoInicioTexto").val(transformaSegundos($ini));
    $("#tiempoFinTexto").val(transformaSegundos($fin));
}

function inicializarSlidersTexto($inicio, $fin){
    var totalTime = getTotalTime();
    $('#tiempoInicioTexto').val(transformaSegundos($inicio));
    $('#tiempoInicioSliderTexto').slider({
        range: "min",
        min: 0,
        max: totalTime,
        value: $inicio,
        slide: function( event, ui ) {
            $("#tiempoInicioTexto").val(transformaSegundos(ui.value));
            validarTiemposTexto("inicio");
        }
    });
    $('#tiempoFinTexto').val(transformaSegundos($fin));
    $('#tiempoFinSliderTexto').slider({
        range: "min",
        min: 0,
        max: totalTime,
        value: $fin,
        slide: function( event, ui ) {
            $("#tiempoFinTexto").val(transformaSegundos(ui.value));
            validarTiemposTexto("fin");
        }
    });
}

