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
                $('#imagenTabs').tabs('select', 0);
                $('#colorSeleccionadoImagen').html("");      
                guardadoAutomatico();
            },
            "Cancelar": function(){
                $(this).dialog("close");
                $('#imagenTabs').tabs('select', 0);
                $('#colorSeleccionadoImagen').html("");
                $("#urlImagen").val("");
            }
        }
    });	 
    
    //validamos el tiempo que escriben en el campo de Imagen
    $("#tiempoInicioImagen").blur(validarTiemposImagen);
    $("#tiempoFinImagen").blur(validarTiemposImagen);
    
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
    
});

function mostrarDialogoInsertarImagen(tipo){
    
    if(tipo == "imagen"){
        $("#formaSubirImagen").show();
        $("#formaElegirForma").hide();
        formaBandera = false;        
    }else if(tipo == "formas"){        
        $("#formaElegirForma").show();
        $("#formaSubirImagen").hide();
        formaBandera = true;
    }
    
    //mostramos la forma como nueva
    $("#loadingUploadImage").hide();    
    $("#resultadoDeSubirImagen").hide();
    $("#resultadoDeSubirImagen").html("");
    
    
    editarImagenBandera = false;    
    pauseVideo();
    var currentTime = getCurrentTime();
    var totalTime = getTotalTime();
    $('#tiempoInicioImagen').val(transformaSegundos(currentTime));
    $('#tiempoFinImagen').val(transformaSegundos(currentTime + 10));
    $('#tiempoRangeSliderImagen').slider({
        range: true,
        min: 0,
        max: totalTime,
        values: [ currentTime, currentTime + 10 ],
        slide: function( event, ui ) {
            if(ui.values[0] == ui.values[1])
                ui.values[1] = ui.values[1]+1;
            $('#tiempoInicioImagen').val(transformaSegundos(ui.values[ 0 ]));
            $('#tiempoFinImagen').val(transformaSegundos(ui.values[ 1 ]));
        }
    });
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
        formaBandera = false;        
    }else if(tipo == "formas"){        
        $("#formaElegirForma").show();
        $("#formaSubirImagen").hide();
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
    
    $('#tiempoInicioImagen').val(imagenes[idImagen].inicio);
    $('#tiempoFinImagen').val(imagenes[idImagen].fin);
    $('#tiempoRangeSliderImagen').slider({
        range: true,
        min: 0,
        max: totalTime,
        values: [ inicio, fin ],
        slide: function( event, ui ) {
            if(ui.values[0] == ui.values[1])
                ui.values[1] = ui.values[1]+1;
            $('#tiempoInicioImagen').val(transformaSegundos(ui.values[ 0 ]));
            $('#tiempoFinImagen').val(transformaSegundos(ui.values[ 1 ]));
        }
    });
    $("#dialog-form-imagen").dialog("open");
}

function editarImagen(){
    var urlImagen = $("#urlImagen").val();
    var inicio = $("#tiempoInicioImagen").val();
    var fin = $("#tiempoFinImagen").val();
    var color = $("#colorHiddenImagen").val();
    
    $containmentWidth = $("#editorContainment").width();
    $containmentHeight  = $("#editorContainment").height();
    
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
    
    agregarImagenDiv(imagenes.length, urlImagen, inicio, fin, color, position.top, position.left, width, height, tipo);
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
            $containmentWidth = $("#editorContainment").width();
            $containmentHeight  = $("#editorContainment").height();            
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
            $containmentWidth = $("#editorContainment").width();
            $containmentHeight  = $("#editorContainment").height();            
            imagenes[indice].width = ui.size.width * 100 / $containmentWidth;
            imagenes[indice].height = ui.size.height * 100 / $containmentHeight;
        },
        containment: "#editorContainment"
    });
}

function dialogoBorrarImagen(indice){
    $("#modalDialog").html("<p>&iquest;Seguro que deseas eliminar este elemento?</p>");
    $( "#modalDialog" ).dialog({
        height: 160,
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
function validarTiemposImagen(){    
    var $videoDuration = getTotalTime();
    $("#tiempoInicioImagen").val($("#tiempoInicioImagen").val().substr(0, 5));
    $("#tiempoFinImagen").val($("#tiempoFinImagen").val().substr(0, 5));
    
    var $ini = stringToSeconds($("#tiempoInicioImagen").val().substr(0, 5));
    var $fin = stringToSeconds($("#tiempoFinImagen").val().substr(0, 5));
    
    if($ini < 0)
        $ini = 0;
    if($fin < 0)
        $fin = 1;
    if($ini >= $videoDuration)
        $ini = $videoDuration-1;
    
    if($ini >= $fin)
        $fin = $ini +1;
    
    if($fin > $videoDuration)
        $fin = $videoDuration;
    
    $("#tiempoRangeSliderImagen").slider( "option", "values", [$ini,$fin] );    
    $("#tiempoInicioImagen").val(transformaSegundos($ini));
    $("#tiempoFinImagen").val(transformaSegundos($fin));
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