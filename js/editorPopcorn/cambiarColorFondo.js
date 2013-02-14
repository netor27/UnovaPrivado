$(function(){    
    $("#dialog-form-colorFondo").dialog({
        autoOpen: false,
        height:450,
        width: 400,
        modal: true,
        draggable: true,
        resizable: false,
        buttons:{
            "Aceptar": function(){              
                $(this).dialog("close");
                guardadoAutomatico();
            },
            "Cancelar": function(){
                $(this).dialog("close");
            }
        }
    });	
    $color = hexc($("#editorContainment").css("background-color"));
    $('#colorSeleccionadoFondo').css('backgroundColor', "#"+$color);
    $('#colorSelectorFondo').ColorPicker({
        color: $color,
        flat: true,
        onChange: function (hsb, hex, rgb) {
            $('#colorSeleccionadoFondo').css('backgroundColor', '#' + hex);
            $("#editorContainment").css('backgroundColor',"#"+hex);
        }
    });
});

function mostrarDialogoCambiarColorFondo(){    
    pauseVideo();
    $color = hexc($("#editorContainment").css("background-color"));
    $('#colorSeleccionadoFondo').css('backgroundColor', "#"+$color);
    $("#dialog-form-colorFondo").dialog("open");
}

function hexc(colorval) {
    var parts = colorval.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    delete(parts[0]);
    for (var i = 1; i <= 3; ++i) {
        parts[i] = parseInt(parts[i]).toString(16);
        if (parts[i].length == 1) parts[i] = '0' + parts[i];
    }
    return '#' + parts.join('');
}