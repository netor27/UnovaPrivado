var links = [];
var editarLinkBandera = false;
var idEditarLink = -1;

$(document).ready(function() {    
    $("#dialog-form-link").dialog({
        autoOpen: false,
        height:450,
        width: 550,
        modal: true,
        resizable: false,
        buttons:{
            "Aceptar": function(){
                if(editarLinkBandera){
                    editarLink();
                }else{
                    agregarLink();    
                }                
                $(this).dialog("close");
                $('#urlLink').val("");
                $('#textoLink').val("");
                $('#linkTabs').tabs( "option", "active", 0 );
                $('#colorSeleccionadoLink').html("");
                guardadoAutomatico();
            },
            "Cancelar": function(){
                $(this).dialog("close");
                $('#linkTabs').tabs( "option", "active", 0 );
                $('#colorSeleccionadoLink').html("");
            }
        }
    });	
    
    $("#colorHiddenLink").val("#FFFFFF");
    $('#colorSelectorLink').colorpicker({
        color: "#ffffff",
        history: false,
        strings: "Escoje un color,Colores estándar,Más colores,Regresar"
    });
    
    $("#colorSelectorLink").on("change.color", function(event, color){
        $('#colorSeleccionadoLink').css('backgroundColor', color);
        $('#colorSeleccionadoLink').html("");
        $("#colorHiddenLink").val(color);
    });
    $('#linkTabs').tabs();    
    $("#sinColorLink").click(function(){
        $("#colorSelectorLink").colorpicker("val", "transparent");
        $('#colorSeleccionadoLink').css('backgroundColor', 'transparent');
        $('#colorSeleccionadoLink').html("Sin color");
        $("#colorHiddenLink").val('transparent');        
    });
    $("#sinColorLink").button();
    //validamos el tiempo que escriben en el campo de texto
    $("#tiempoInicioLink").change(function() {
        validarTiemposLink("inicio");
    });
    $("#tiempoFinLink").change(function() {
        validarTiemposLink("fin");
    });
});

function mostrarDialogoInsertarLink(){
    editarLinkBandera = false;    
    pauseVideo();
    var currentTime = getCurrentTime();
    inicializarSlidersLink(currentTime, currentTime+10);
    $("#dialog-form-link").dialog('option', 'title', 'Agregar un link');
    $("#dialog-form-link").dialog("open");
}

function cargarLinkEnArreglo(texto, url, inicio, fin, color, top, left, width, height){    
    links.push({
        texto : texto, 
        url : url,
        inicio : inicio,
        fin : fin,
        color : color,
        top : top,
        left : left,
        height : height,
        width: width
    }); 
}

function agregarLink(){    
    var texto = $("#textoLink").val();
    var url = $("#urlLink").val();
    var inicio = $("#tiempoInicioLink").val();
    var fin = $("#tiempoFinLink").val();
    var color = $("#colorHiddenLink").val();
    
    agregarLinkDiv(links.length, texto, url, inicio, fin, color, 10, 10, 50, 50);
    cargarLinkEnArreglo(texto, url, inicio, fin, color, 10, 10, 50, 50); 
}

function mostrarDialogoEditarLink(idLink){
    editarLinkBandera = true;
    idEditarLink = idLink;
    pauseVideo();
    $('#textoLink').val(links[idLink].texto);
    $('#urlLink').val(links[idLink].url);
    
    var inicio = stringToSeconds(links[idLink].inicio);
    var fin = stringToSeconds(links[idLink].fin);
    var totalTime = getTotalTime();
    
    var color = links[idLink].color;
    
    cambiarColorPicker(color,"Link");
    
    inicializarSlidersLink(inicio, fin);
    $("#dialog-form-link").dialog('option', 'title', 'Editar link');
    $("#dialog-form-link").dialog("open");
}

function editarLink(){
    var texto = $("#textoLink").val();
    var url = $("#urlLink").val();
    var inicio = $("#tiempoInicioLink").val();
    var fin = $("#tiempoFinLink").val();
    var color = $("#colorHiddenLink").val();
    
    $containmentWidth = getContainmentWidth();
    $containmentHeight  = getContainmentHeight();
    
    var position = $("#link_"+idEditarLink).position();    
    position.top = position.top * 100 / $containmentHeight;
    position.left = position.left * 100 / $containmentWidth;     
    
    var width = $("#link_"+idEditarLink).width();
    var height = $("#link_"+idEditarLink).height();
    width = width * 100 / $containmentWidth;
    height = height * 100/ $containmentHeight;
    
    cargarLinkEnArreglo(texto, url, inicio, fin, color, position.top, position.left, width, height);
    borrarLink(idEditarLink);
}

function agregarLinkDiv(indice, texto, url, inicio, fin, color, top, left, width, height){
    var textoDiv = '<div id="link_'+indice+'" class="ui-corner-all linkAgregado stack draggable" style="background-color: '+color+'; position: fixed; top: '+getUnidadPx(top)+'; left: '+getUnidadPx(left)+'; width: '+getUnidadPx(width)+'; height: '+getUnidadPx(height)+';">' +
    '<p class="ui-widget-header dragHandle">Arr&aacute;strame de aqu&iacute;<br></p>'+
    '<div class="elementButtons"id="eb_lnk_'+indice+'">' +
    '<a href="#" onclick=mostrarDialogoEditarLink('+indice+')>'+
    '<div class="ui-state-default ui-corner-all littleBox">' +
    '<span class="ui-icon ui-icon-wrench" >' +
    'Editar' +
    '</span>' +
    '</div>' +
    '</a>'+
    '<a href="#" onclick=dialogoBorrarLink('+indice+')>'+
    '<div class="ui-state-default ui-corner-all littleBox">' +
    '<span class="ui-icon ui-icon-closethick" >' +
    'Borrar' +
    '</span>' +
    '</div>' +
    '</a>'+    
    '</div>' +
    '</div>';
    
    $popPrincipal.footnote({
        start: inicio,
        end: fin,
        text: textoDiv,
        target: "footnotediv"
    });
    
    $("#link_"+indice).draggable({
        handle: "p", 
        containment: "#editorContainment",
        stack: ".stack",
        stop: function(event, ui){
            //ui.position - {top, left} current position
            var id = ui.helper.attr("id");
            var indice = id.split("_")[1];
            $containmentWidth = getContainmentWidth();
            $containmentHeight  = getContainmentHeight();
            links[indice].top = ui.offset.top * 100 / $containmentHeight;
            links[indice].left = ui.offset.left * 100 / $containmentWidth;            
        }
    });
    
    $("#link_"+indice).hover(function(){
        $("#eb_lnk_"+indice).show();
    },function(){
        $("#eb_lnk_"+indice).hide();
    })
    
    $("#link_"+indice).resizable({
        minHeight: 50,
        minWidth: 50,
        stop: function(event, ui){
            //ui.size - {width, height} current size
            var id = ui.helper.attr("id");
            var indice = id.split("_")[1];
            $containmentWidth = getContainmentWidth();
            $containmentHeight  = getContainmentHeight();
            links[indice].width = ui.size.width * 100 / $containmentWidth;
            links[indice].height = ui.size.height * 100/ $containmentHeight;
        },
        containment: "#editorContainment"
    });
    
    $popPrincipal.webpage({
        id: "webpages_"+indice,
        start: inicio,
        end: fin,
        src: url,
        target: "link_"+indice
      });
}

function dialogoBorrarLink(indice){
    $( "#modalDialog" ).dialog( "option", "title", "Eliminar p&aacute;gina web" );
    $("#modalDialog").html("<p>&iquest;Seguro que deseas eliminar este elemento?</p>");
    $("#modalDialog").destroy();
    $("#modalDialog" ).dialog({
        draggable: false,
        resizable: false,
        height: 200,
        width: 400,
        modal: true,
        buttons: {
            Si: function() {
                borrarLink(indice);                
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

function borrarLink(indice){    
    destroyPopcorn();    
    links.splice(indice,1);
    inicializarPopcorn();        
}

function eliminarLinks(){
    $(".linkAgregado").remove();
    $(".linkAgregado").draggable("destroy");
    $(".linkAgregado").resizable("destroy");
}

function cargarLinks(){    
    var i;    
    for(i=0;i<links.length;i++){
        agregarLinkDiv(i, decode_utf8(links[i].texto), links[i].url, links[i].inicio, links[i].fin, links[i].color, links[i].top, links[i].left, links[i].width, links[i].height);
    }
}

//Valida el input de los tiempos en el slider
function validarTiemposLink($respetar){        
    var $videoDuration = getTotalTime();
    $("#tiempoInicioLink").val($("#tiempoInicioLink").val().substr(0, 5));
    $("#tiempoFinLink").val($("#tiempoFinLink").val().substr(0, 5));
    
    var $ini = stringToSeconds($("#tiempoInicioLink").val());
    var $fin = stringToSeconds($("#tiempoFinLink").val());
    
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
    $("#tiempoInicioSliderLink").slider( "option", "value", $ini);    
    $("#tiempoFinSliderLink").slider( "option", "value", $fin );    
    
    $("#tiempoInicioLink").val(transformaSegundos($ini));
    $("#tiempoFinLink").val(transformaSegundos($fin));
}

function inicializarSlidersLink($inicio, $fin){
    var totalTime = getTotalTime();
    $('#tiempoInicioLink').val(transformaSegundos($inicio));
    $('#tiempoInicioSliderLink').slider({
        range: "min",
        min: 0,
        max: totalTime,
        value: $inicio,
        slide: function( event, ui ) {
            $("#tiempoInicioLink").val(transformaSegundos(ui.value));
            validarTiemposLink("inicio");
        }
    });
    $('#tiempoFinLink').val(transformaSegundos($fin));
    $('#tiempoFinSliderLink').slider({
        range: "min",
        min: 0,
        max: totalTime,
        value: $fin,
        slide: function( event, ui ) {
            $("#tiempoFinLink").val(transformaSegundos(ui.value));
            validarTiemposLink("fin");
        }
    });
}

