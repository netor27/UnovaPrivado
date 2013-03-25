var cuestionarios = [];
var editarCuestionarioBandera = false;
var idEditar = -1;
$(function(){    
    $("#dialog-form-cuestionario").dialog({
        autoOpen: false,
        height:550,
        width: 960,
        modal: true,
        resizable: false,
        buttons:{
            "Aceptar": function(){
                if(editarCuestionarioBandera){
                //editarTexto();
                }else{
                //agregarTexto();    
                }                
                $(this).dialog("close");
                $('#cuestionarioTabs').tabs( "option", "active", 0 );
                guardadoAutomatico();
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
});

function mostrarDialogoInsertarCuestionario(){
    editarCuestionarioBandera = false;    
    pauseVideo();
    var currentTime = getCurrentTime();    
    inicializarSlidersCuestionario(currentTime);
    $("#dialog-form-cuestionario").dialog('option', 'title', 'Agregar cuestionario');
    $("#dialog-form-cuestionario").dialog("open");
    crearCuestionario();
}

function crearCuestionario(){
    var data = {
        u: iu,
        uuid: uuid,
        cu: ic,
        cl: icl
    };    
    $.ajax({
        type: 'post',
        cache: false,
        url: '/cursos/control/agregarControlSubmit',
        data: data
    }).done(function( html ) {
        var res = jQuery.parseJSON(html);        
        if(res.resultado == "error"){
            console.log("Error -- " + html);
            
        }else{
            var idCuestionario = res.mensaje;
            
        }
    });
}

/*
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
    var totalTime = getTotalTime();
    
    var color = textos[idTexto].color;
    
    cambiarColorPicker(color,"Texto");
    
    $('#tiempoInicioTexto').val(textos[idTexto].inicio);
    $('#tiempoFinTexto').val(textos[idTexto].fin);
    $('#tiempoRangeSliderTexto').slider({
        range: true,
        min: 0,
        max: totalTime,
        values: [ inicio, fin ],
        slide: function( event, ui ) {
            if(ui.values[0] == ui.values[1]){
                if(ui.values[1] == 0){
                    ui.values[1] = 1;
                }
                if(ui.values[0] == totalTime){
                    ui.values[0] = totalTime - 1;
                }
            }
            $('#tiempoInicioTexto').val(transformaSegundos(ui.values[ 0 ]));
            $('#tiempoFinTexto').val(transformaSegundos(ui.values[ 1 ]));
        }
    });
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
    $("#modalDialog").html("<p>&iquest;Seguro que deseas eliminar este elemento?</p>");
    $( "#modalDialog" ).dialog({
        height: 160,
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
*/

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

