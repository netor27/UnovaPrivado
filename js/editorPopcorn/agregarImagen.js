var imagenes = [];
var editarImagenBandera = false;
var idEditarImagen = -1;
var formaBandera = false;

$(function(){    
    $("#dialog-form-imagen").dialog({
        autoOpen: false,
        height:450,
        width: 650,
        modal: true,
        resizable: false,
        buttons:{
            "Aceptar": function(){
                if(editarImagenBandera){
                    editarImagen();
                }else{
                    agregarImagen();    
                }
                $(this).dialog("close");
                $("#urlImagen").val("");
                $('#imagenTabs').tabs( "option", "active", 0 );
                $('#colorSeleccionadoImagen').html("");      
                guardadoAutomatico();
            },
            "Cancelar": function(){
                $(this).dialog("close");
                $('#imagenTabs').tabs( "option", "active", 0 );
                $('#colorSeleccionadoImagen').html("");
                $("#urlImagen").val("");
            }
        }
    });	 
    
    $('#imagenTabs').tabs();
    
    $("#colorHiddenImagen").val("#FFFFFF");
    $('#colorSelectorImagen').colorpicker({
        color: "#ffffff",
        history: false,
        strings: "Escoje un color,Colores estándar,Más colores,Regresar"
    });
    
    $("#colorSelectorImagen").on("change.color", function(event, color){
        $('#colorSeleccionadoImagen').css('backgroundColor', color);
        $('#colorSeleccionadoImagen').html("");
        $("#colorHiddenImagen").val(color);
    })
    
    $("#sinColorImagen").click(function(){
        $("#colorSelectorImagen").colorpicker("val", "transparent");
        $('#colorSeleccionadoImagen').css('backgroundColor', 'transparent');
        $('#colorSeleccionadoImagen').html("Sin color");
        $("#colorHiddenImagen").val('transparent');        
    });   
    
    $(".formaPredefinida").click(function(){
        var url = $(this).attr("url");
        $("#urlImagen").val(url);
        $(".formaPredefinida").removeClass("formaSelected");
        $(this).addClass("formaSelected");
    });    
    $("#sinColorImagen").button();        
    $("#buttonUpload").button();     
    //validamos el tiempo que escriben en el campo de texto
    $("#tiempoInicioImagen").change(function() {
        validarTiemposImagen("inicio");
    });
    $("#tiempoFinImagen").change(function() {
        validarTiemposImagen("fin");
    });
});

function mostrarDialogoInsertarImagen(tipo){        
    if(tipo == "imagen"){
        $("#formaSubirImagen").show();
        $("#formaElegirForma").hide();
        $("#dialog-form-imagen").dialog('option', 'title', 'Agregar una imagen');
        formaBandera = false;        
    }else if(tipo == "formas"){        
        $("#formaElegirForma").show();
        $("#formaSubirImagen").hide();
        $("#dialog-form-imagen").dialog('option', 'title', 'Agregar una forma predefinida');
        formaBandera = true;
    }    
    //mostramos la forma como nueva
    $("#loadingUploadImage").hide();    
    $("#resultadoDeSubirImagen").hide();
    $("#resultadoDeSubirImagen").html("");
    editarImagenBandera = false;    
    pauseVideo();
    var currentTime = getCurrentTime();
    inicializarSlidersImagen(currentTime, currentTime+10);
    $("#dialog-form-imagen").dialog("open");
}

function cargarImagenEnArreglo(urlImagen, inicio, fin, color, top, left, width, height,tipo){
    imagenes.push({
        urlImagen : urlImagen,
        inicio : inicio,
        fin : fin,
        color : color,
        top : top,
        left : left,
        height : height,
        width: width,
        tipo: tipo
    }); 
}

function agregarImagen(){    
    var urlImagen = $("#urlImagen").val();
    var inicio = $("#tiempoInicioImagen").val();
    var fin = $("#tiempoFinImagen").val();
    var color = $("#colorHiddenImagen").val();
    
    var tipo = "";
    if(formaBandera)
        tipo = "formas";
    else
        tipo = "imagen";    
    
    agregarImagenDiv(imagenes.length, urlImagen, inicio, fin, color, 50, 50, 20, 20, tipo);
    cargarImagenEnArreglo(urlImagen, inicio, fin, color, 50, 50, 20, 10, tipo);
}

function mostrarDialogoEditarImagen(idImagen, tipo){
    
    if(tipo == "imagen"){
        $("#formaSubirImagen").show();
        $("#formaElegirForma").hide();
        $("#dialog-form-imagen").dialog('option', 'title', 'Editar imagen');
        formaBandera = false;        
    }else if(tipo == "formas"){        
        $("#formaElegirForma").show();
        $("#formaSubirImagen").hide();
        $("#dialog-form-imagen").dialog('option', 'title', 'Editar forma predefinida');
        formaBandera = true;
    }
    editarImagenBandera = true;
    idEditarImagen = idImagen;
    pauseVideo();
    $("#urlImagen").val(imagenes[idImagen].urlImagen);    
    var inicio = stringToSeconds(imagenes[idImagen].inicio);
    var fin = stringToSeconds(imagenes[idImagen].fin);
    var totalTime = getTotalTime();    
    var color = imagenes[idImagen].color;    
    cambiarColorPicker(color,"Imagen");    
    inicializarSlidersImagen(inicio, fin);
    $("#dialog-form-imagen").dialog("open");
}

function editarImagen(){
    var urlImagen = $("#urlImagen").val();
    var inicio = $("#tiempoInicioImagen").val();
    var fin = $("#tiempoFinImagen").val();
    var color = $("#colorHiddenImagen").val();
    
    $containmentWidth = getContainmentWidth();
    $containmentHeight  = getContainmentHeight();
    
    var position = $("#imagen_"+idEditarImagen).position();   
    position.top = position.top * 100 / $containmentHeight;
    position.left = position.left * 100 / $containmentWidth;     
    
    var width = $("#imagen_"+idEditarImagen).width();
    var height = $("#imagen_"+idEditarImagen).height();
    width = width * 100 / $containmentWidth;
    height = height * 100/ $containmentHeight;
    
    var tipo = "";
    if(formaBandera)
        tipo = "formas";
    else
        tipo = "imagen";    
    
    cargarImagenEnArreglo(urlImagen, inicio, fin, color, position.top, position.left, width, height, tipo);
    borrarImagen(idEditarImagen);
}

function agregarImagenDiv(indice, urlImagen, inicio, fin, color, top, left, width, height, tipo){
    var textoDiv = '<div id="imagen_'+indice+'" class="ui-corner-all imagenAgregada  stack draggable" style="background-color: '+color+'; position: fixed; top: '+getUnidadPx(top)+'; left: '+getUnidadPx(left)+'; width: '+getUnidadPx(width)+'; height: '+getUnidadPx(height)+';">' +
    '<div class="elementButtons"id="eb_img_'+indice+'">' +
    '<a href="#" onclick=mostrarDialogoEditarImagen('+indice+',"'+tipo+'")>'+
    '<div class="ui-state-default ui-corner-all littleBox">' +
    '<span class="ui-icon ui-icon-wrench" >' +
    'Editar' +
    '</span>' +
    '</div>' +
    '</a>'+
    '<a href="#" onclick=dialogoBorrarImagen('+indice+')>'+
    '<div class="ui-state-default ui-corner-all littleBox">' +
    '<span class="ui-icon ui-icon-closethick" >' +
    'Borrar' +
    '</span>' +
    '</div>' +
    '</a>'+    
    '</div>' +
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
    
    $("#imagen_"+indice).draggable({
        containment: "#editorContainment",
        stack: ".stack",
        stop: function(event, ui){
            //ui.position - {top, left} current position
            var id = ui.helper.attr("id");
            var indice = id.split("_")[1];
            $containmentWidth = getContainmentWidth();
            $containmentHeight  = getContainmentHeight();
            imagenes[indice].top = ui.offset.top * 100 / $containmentHeight;
            imagenes[indice].left = ui.offset.left * 100 / $containmentWidth;
        },
        snap: true
    });
    
    $("#imagen_"+indice).hover(function(){
        $("#eb_img_"+indice).show();
    },function(){
        $("#eb_img_"+indice).hide();
    })
    
    $("#imagen_"+indice).resizable({
        minHeight: 50,
        minWidth: 100,
        stop: function(event, ui){
            //ui.size - {width, height} current size
            var id = ui.helper.attr("id");
            var indice = id.split("_")[1];
            $containmentWidth = getContainmentWidth();
            $containmentHeight  = getContainmentHeight()
            imagenes[indice].width = ui.size.width * 100 / $containmentWidth;
            imagenes[indice].height = ui.size.height * 100 / $containmentHeight;
        },
        containment: "#editorContainment"
    });
}

function dialogoBorrarImagen(indice){
    $( "#modalDialog" ).dialog( "option", "title", "Eliminar imagen" );
    $("#modalDialog").html("<p>&iquest;Seguro que deseas eliminar este elemento?</p>");
    $( "#modalDialog" ).dialog({
        draggable: false,
        resizable: false,
        height: 200,
        width: 400,
        modal: true,
        buttons: {
            Si: function() {
                borrarImagen(indice);                
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

function borrarImagen(indice){    
    destroyPopcorn();   
    imagenes.splice(indice,1);
    inicializarPopcorn();        
}

function eliminarImagenes(){
    $(".imagenAgregada").remove();
    $(".imagenAgregada").draggable("destroy");
    $(".imagenAgregada").resizable("destroy");
}

function cargarImagenes(){    
    var i;    
    for(i=0;i<imagenes.length;i++){
        agregarImagenDiv(i, imagenes[i].urlImagen, imagenes[i].inicio, imagenes[i].fin, imagenes[i].color, imagenes[i].top, imagenes[i].left, imagenes[i].width, imagenes[i].height, imagenes[i].tipo);
    }
}

//Valida el input de los tiempos en el slider
function validarTiemposImagen($respetar){        
    var $videoDuration = getTotalTime();
    $("#tiempoInicioImagen").val($("#tiempoInicioImagen").val().substr(0, 5));
    $("#tiempoFinImagen").val($("#tiempoFinImagen").val().substr(0, 5));
    
    var $ini = stringToSeconds($("#tiempoInicioImagen").val());
    var $fin = stringToSeconds($("#tiempoFinImagen").val());
    
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
    $("#tiempoInicioSliderImagen").slider( "option", "value", $ini);    
    $("#tiempoFinSliderImagen").slider( "option", "value", $fin );    
    
    $("#tiempoInicioImagen").val(transformaSegundos($ini));
    $("#tiempoFinImagen").val(transformaSegundos($fin));
}

function inicializarSlidersImagen($inicio, $fin){
    var totalTime = getTotalTime();
    $('#tiempoInicioImagen').val(transformaSegundos($inicio));
    $('#tiempoInicioSliderImagen').slider({
        range: "min",
        min: 0,
        max: totalTime,
        value: $inicio,
        slide: function( event, ui ) {
            $("#tiempoInicioImagen").val(transformaSegundos(ui.value));
            validarTiemposImagen("inicio");
        }
    });
    $('#tiempoFinImagen').val(transformaSegundos($fin));
    $('#tiempoFinSliderImagen').slider({
        range: "min",
        min: 0,
        max: totalTime,
        value: $fin,
        slide: function( event, ui ) {
            $("#tiempoFinImagen").val(transformaSegundos(ui.value));
            validarTiemposImagen("fin");
        }
    });
}

function ajaxImageFileUpload(){
    //starting setting some animation when the ajax starts and completes
    $("#loadingUploadImage")
    .ajaxStart(function(){
        $(this).show();
    })
    .ajaxComplete(function(){
        $(this).hide();
    });
    var data = {
        u: iu,
        uuid: uuid,
        cu: ic,
        cl: icl
    }
   
    $.ajaxFileUpload({
        url:'/subirArchivos.php?a=subirImagen', 
        secureuri:false,
        fileElementId:'fileToUploadImage',
        dataType: 'json',
        data: data,
        success: function (data, status){
            if(typeof(data.error) != 'undefined'){
                if(data.error != ''){
                    alert(data.error);
                }else{
                    $("#formaSubirImagen").hide();
                    var domImg = "<h3>Tu imagen se subió correctamente</h3><br><img src='"+data.link+"' style='width:200px;'/>";
                    $("#resultadoDeSubirImagen").html(domImg);
                    $("#resultadoDeSubirImagen").show();
                    $("#urlImagen").val(data.link);
                }
            }
        },
        error: function (data, status, e){
            alert(e);
        }
    })
    return false;
}  