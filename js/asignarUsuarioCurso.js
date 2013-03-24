jQuery.fn.filterByText = function(textbox, selectSingleMatch) {
    return this.each(function() {
        var select = this;
        var options = [];
        $(select).find('option').each(function() {
            options.push({
                value: $(this).val(), 
                text: $(this).text()
            });
        });
        $(select).data('options', options);
        $(textbox).bind('change keyup', function() {
            var options = $(select).empty().data('options');
            var search = $.trim($(this).val());
            var regex = new RegExp(search,'gi');

            $.each(options, function(i) {
                var option = options[i];
                if(option.text.match(regex) !== null) {
                    $(select).append(
                        $('<option>').text(option.text).val(option.value)
                        );
                }
            });
            if (selectSingleMatch === true && 
                $(select).children().length === 1) {
                $(select).children().get(0).selected = true;
            }
        });
    });
};

var usuariosQuitar = [];

$(function() {
    $('#listaUsuarios').filterByText($('#textUsuarios'), true);
    //$('#listaInscritos').filterByText($('#textInscritos'), true);
  
    $("#btnAgregar").click(function(){
        $('#listaUsuarios option:selected').each(function(index, value){
            var $id = $(value).attr("value");
            var bandera = false;
            $('#listaInscritos option').each(function(i) {
                if($id == this.value){
                    bandera = true;
                }
            });        
            if(!bandera){
                $(value).clone().appendTo('#listaInscritos');
            }
        });
    });
    
    //dobleclick para agregar
    $('#listaUsuarios').dblclick(function(){
        var $id = $('#listaUsuarios option:selected').attr("value");
        var bandera = false;
        $('#listaInscritos option').each(function(i) {
            if($id == this.value){
                bandera = true;
            }
        });        
        if(!bandera){
            $('#listaUsuarios option:selected').clone().appendTo('#listaInscritos');
        }
    });
  
    $("#btnQuitar").click(function(){
        $('#listaInscritos option:selected').each(function(index, value){
            var valor = $(value).attr("value");
            usuariosQuitar.push(valor);
        });
        $('#listaInscritos option:selected').remove();
    });
    
    //doble click para quitar
    $('#listaInscritos').dblclick(function(){
        var valor = $('#listaInscritos option:selected').attr("value");
        usuariosQuitar.push(valor);        
        $('#listaInscritos option:selected').remove();
    });
  
    $("#btnGuardar").click(function(){
        if(! $(this).hasClass("disabled")){
            var usuariosInscribir = [];
            $('#listaInscritos option').each(function(i) {
                usuariosInscribir.push(this.value);
            });
            $("#btnGuardar").html("Guardando...");
            $("#btnGuardar").addClass("disabled");
            $.ajax({
                type: "post",
                url: "/usuarios/cursos/asignarUsuarios" ,
                dataType: "text",
                data: {
                    'idCurso' : curso,
                    'idUsuariosInscribir' : usuariosInscribir,
                    'idUsuariosQuitar' : usuariosQuitar
                },
                success: function(data) {
                    var str = data.toString();
                    if(str.indexOf("ok") != -1){                    
                        bootbox.dialog("<h4>Se actualizaron los datos correctamente.<br>¿Qué deseas hacer?</h4>", 
                            [{
                                "label" : "Seguir modificando",
                                "class" : "btn"
                            }, {
                                "label" : "Salir",
                                "class" : "btn-primary",
                                "callback": function() {
                                    regresar();
                                }                                
                            }]);
                    }else{ 
                        bootbox.alert("Ocurrió un error al actualizar los datos. <br>Intenta de nuevo más tarde");
                    }
                },
                complete: function(){
                    $("#btnGuardar").html('<i class="icon-white icon-ok"></i>Guardar Cambios');
                    $("#btnGuardar").removeClass("disabled");
                }
            });    
        }
    });
  
    $("#btnCancelar").click(function(){
        regresar();
    });
});  

function regresar(){
    $url = "/cursos/curso/alumnos/"+curso;
    redirect($url);
}
