var directionHide = "left";
var directionShow = "right";
var easingType = "";

function mostrarPaginaDiscusiones($pagina, $force, $blind){
    if($pagina > maxPagina)
        $pagina = maxPagina;   
    if($blind){
        easingType = "blind";
    }else{
        easingType = "slide";
    }
        
    if($pagina > paginaActual){
        directionHide = "left";
        directionShow = "right";
    }else{
        directionHide = "right";
        directionShow = "left";
    }
    if(paginaActual != $pagina || $force){
        paginaActual = $pagina;
        $(".btnPagination.active").removeClass("active");
        $("#discusionPager_"+$pagina).addClass("active");
        if($pagina > 1){
            //Establecemos el valor de paginaMenos
            $("#paginaMenos").attr("pagina", $pagina-1);
            $("#paginaMenos").removeClass("disabled");
            $("#paginaMenos").removeClass("active");
        }else{
            $("#paginaMenos").attr("pagina", 1);
            $("#paginaMenos").addClass("disabled");
            $("#paginaMenos").addClass("active");
        }
        if($pagina < maxPagina){
            $("#paginaMas").attr("pagina", $pagina+1);
            $("#paginaMas").removeClass("disabled");
            $("#paginaMas").removeClass("active");
        }else{
            $("#paginaMas").attr("pagina", maxPagina);
            $("#paginaMas").addClass("disabled");
            $("#paginaMas").addClass("active");
        }               
        $("#discusionesPagerContent").hide(easingType, {
            direction: directionHide
        }, function() {
            $("#discusionesPagerLoading").show();
            //Hacemos la llamada ajax para actualizar el pager
            var data = {
                pagina: $pagina,
                rows: rows,
                curso: curso,
                orden : orden,
                ascendente: ascendente
            };    
            $.ajax({
                type: 'post',
                cache: false,
                url: '/cursos/discusion/obtenerDiscusiones',
                data: data
            }).done(function( html ) {
                var str = html.toString();
                if(str.indexOf("error") != -1){
                //Error            
                }else{
                    $("#discusionesPagerLoading").hide();                        
                    $("#discusionesPagerContent").html(html);
                    $("#discusionesPagerContent").show(easingType,{
                        direction:directionShow
                    });     
                    ligarEventosDeVotacion();
                    ligarEventosBorrarDiscusion();
                    actualizarVotos();
                    actualizarLinkHash();
                }
            });
        });   
    }
}
function validarDiscusionesNuevas($paginaDefault){
    var data = {
        curso: curso
    };    
    $.ajax({
        type: 'post',
        cache: false,
        url: '/cursos/discusion/obtenerNumeroDiscusiones',
        data: data
    }).done(function( html ) {
        var resultado = jQuery.parseJSON(html);
        if(numDiscusiones != resultado.n){
            //Hay discusiones nuevas
            numDiscusiones = resultado.n;
            actualizarPager();
            mostrarPaginaDiscusiones($paginaDefault, true, true);
        }
    });
}
    
function actualizarPager(){
    $("#paginationDiscusion").empty();
    maxPagina = Math.ceil(numDiscusiones / rows);
    var $dom = '<ul>';
    $dom +=  '<li class="btnPagination disabled" id="paginaMenos" pagina="1">';
    $dom +=     '<a href="javascript:void(0);">«</a></li>';
    $dom +=  '</li>';
    for(i=1;i<=maxPagina;i++){
        if(i == paginaActual)
            $dom += '<li id="discusionPager_' + i + '" class="btnPagination active" pagina="' + i + '"><a href="javascript:void(0);">' + i + '</a></li>';
        else
            $dom += '<li id="discusionPager_' + i + '" class="btnPagination" pagina="' + i + '"><a href="javascript:void(0);">' + i + '</a></li>';
    }  
    var $siguientePagina = 2;
    var $auxSig = ""
    if($siguientePagina > maxPagina){
        $siguientePagina = maxPagina;
    }
    if($siguientePagina == 1){
        $auxSig = " disabled";
    }
    $dom += '<li class="btnPagination '+$auxSig+'" id="paginaMas" pagina="'+$siguientePagina+'">';
    $dom +='<a href="javascript:void(0);">»</a>';
    $dom +='</li>';
    $dom +='</ul>';
    $("#paginationDiscusion").html($dom);
    ligarEventosDeClickPager();
}
function ligarEventosDeClickPager(){
    $(".btnPagination").click(function(){
        $pagina = parseInt($(this).attr("pagina"));
        mostrarPaginaDiscusiones($pagina,false, false);
    });           
}
function ligarEventosDeVotacion(){
    //Clicks en la votacion
    $(".discusionVotacionMas").click(function(){
        $discusion = $(this).attr('discusion');
        $("#votacionMenos_"+$discusion).removeClass("label label-important");
        $("#votacionMenos_"+$discusion).children("i").removeClass("icon-white");
        $(this).addClass("label label-success votado");
        $(this).children("i").addClass("icon-white");              
        votarDiscusion($discusion, 1);
    });       
        
    $(".discusionVotacionMenos").click(function(){
        $discusion = $(this).attr('discusion');
        $("#votacionMas_"+$discusion).removeClass("label label-success");
        $("#votacionMas_"+$discusion).children("i").removeClass("icon-white");
        $(this).addClass("label label-important votado");
        $(this).children("i").addClass("icon-white");
        votarDiscusion($discusion, -1);
    });
}
function ligarEventosBorrarDiscusion(){
    $(".btnBorrarDiscusion").click(function(){
        var idDiscusion = $(this).attr("discusion");
        var data = {
            idDiscusion: idDiscusion
        }; 
        bootbox.dialog("<h4>Se eliminará permanentemente esta entrada del foro<br>¿Estás seguro?</h4>", 
            [{
                "label" : "Cancelar",
                "class" : "btn"
            }, {
                "label" : "Eliminar",
                "class" : "btn-danger",
                "icon"  : "icon-warning-sign icon-white",
                "callback": function() {
                    $.ajax({
                        type: 'post',
                        cache: false,
                        url: '/cursos/discusion/eliminarDiscusion',
                        data: data
                    }).done(function( html ) {
                        var resultado = jQuery.parseJSON(html);
                        if(resultado.res){
                            validarDiscusionesNuevas(paginaActual);     
                        //bootbox.alert("Haz eliminado una entrada del foro");
                        }else{
                            bootbox.alert("Ocurrió un error al borrar la entrada. Intenta de nuevo más tarde");
                        }
                    });
                }
            }]);
        return false;
    });
}
function ligarTodosLosEventos(){
    ligarEventosDeClickPager();
    ligarEventosDeVotacion();
    ligarEventosBorrarDiscusion();
}

function actualizarVotos(){
    $(".discusion").each(function(){
        var idDiscusion = $(this).attr("discusion");
        var votacion = getVotacion(idDiscusion);
        if(votacion == 1){            
            $("#votacionMenos_"+idDiscusion).removeClass("label label-important");
            $("#votacionMenos_"+idDiscusion).children("i").removeClass("icon-white");
            $("#votacionMas_"+idDiscusion).addClass("label label-success votado");
            $("#votacionMas_"+idDiscusion).children("i").addClass("icon-white");     
        }else if(votacion == -1){
            $("#votacionMas_"+idDiscusion).removeClass("label label-success");
            $("#votacionMas_"+idDiscusion).children("i").removeClass("icon-white");
            $("#votacionMenos_"+idDiscusion).addClass("label label-important votado");
            $("#votacionMenos_"+idDiscusion).children("i").addClass("icon-white");
        }
    });
}
    
function votarDiscusion($discusion, $delta){
    if (Modernizr.localstorage) {
        var variableGuardado = "unova.votacion.discusion." + $discusion;
        var valor = localStorage[variableGuardado];
        if(valor == null){
            //no hay votación anterior, la guardamos en localStorage
            localStorage[variableGuardado] = $delta;
            enviarVotacion($discusion, $delta);
        }else{
            valor = parseInt(valor);
            //ya hay votación anterior, verificamos que sea voto diferente
            if(valor != $delta){
                //Cambio su voto
                localStorage[variableGuardado] = $delta;
                $delta = $delta * 2;
                enviarVotacion($discusion, $delta);
            }
        }        
    }else{
        alert("Tu navegador no soporta esta funcionalidad. Te sugerimos actualizarlo");
    }
}
function enviarVotacion($discusion, $delta){
    var data = {
        discusion: $discusion,
        delta: $delta
    };    
    $.ajax({
        type: 'post',
        cache: false,
        url: '/cursos/discusion/votarDiscusion',
        data: data
    }).done(function( html ) {
        var resultado = jQuery.parseJSON(html);
        if(resultado.res){            
            var puntuacionMas = parseInt(resultado.msg.puntuacionMas);
            var puntuacionMenos = parseInt(resultado.msg.puntuacionMenos);
            var votosTotales = puntuacionMas + puntuacionMenos;
            var porcentajePositivo, porcentajeNegativo;
            if(puntuacionMas > 0){
                if(puntuacionMenos > 0){
                    porcentajePositivo = Math.round(puntuacionMas / votosTotales * 100);                    
                    porcentajeNegativo = 100 - porcentajePositivo;                    
                }else{
                    porcentajePositivo = 100;
                    porcentajeNegativo = 0;
                }
            }else{
                if(puntuacionMenos > 0){
                    porcentajePositivo = 0;
                    porcentajeNegativo = 100;
                }else{
                    porcentajePositivo = 0;
                    porcentajeNegativo = 0;
                }
            }
            //actualizamos el texto de los botones    
            $("#votacionMas_"+$discusion).children("span").text(puntuacionMas);
            $("#votacionMenos_"+$discusion).children("span").text(puntuacionMenos);
            //actualizamos la barra
            $("#porcentajePositivo_"+$discusion).css("width",porcentajePositivo+"%");
            $("#porcentajeNegativo_"+$discusion).css("width",porcentajeNegativo+"%");
        }else{
            bootbox.alert("Error. "+resultado.msg);
        }
    });
}
function getVotacion($discusion){
    if (Modernizr.localstorage) {
        var variableGuardado = "unova.votacion.discusion." + $discusion;
        var valor = localStorage[variableGuardado];
        if(valor == null){
            //no hay votación anterior
            return 0;
        }else{
            valor = parseInt(valor);
            return valor;
        }        
    }else{
        //El navegador no soporta esta funcionalidad.
        return 0;        
    }
}

function bindEventBtnAgregarDiscusion(){
    $('#agregarDiscusionModal').on('hidden', function () {        
        $("#inputTitulo").val("");
        $("#editor").empty();
    });
    $("#btnAgregarDiscusion").click(function(){
        error = false;
        var msgError = "";
        $titulo = trim($("#inputTitulo").val());
        console.log($('#editor').html());
        $texto = $('#editor').cleanHtml();
        console.log($texto);
        if($texto.length <= 0 ){
            error = true;
            msgError = "Introduce el texto";
        }
        if($titulo.length <= 0 ){
            error = true;
            msgError = "Introduce un título";
        }
        if($titulo.length > 140 ){
            error = true;
            msgError = "El título no puede tener más de 140 letras";
        }
        if(error){
            var auxBlock = '<div class="alert alert-error alert-block">';
            auxBlock += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            auxBlock += '<strong>¡Error! </strong>  '+msgError;
            $("#dialogoErrorDiscusion").empty();
            $("#dialogoErrorDiscusion").html(auxBlock);
            $("#dialogoErrorDiscusion").show();
        }else{
            //Enviamos la solicitud par crear la discusion
            var data = {
                titulo: $titulo,
                texto: $texto,
                curso: curso
            };    
            $.ajax({
                type: 'post',
                cache: false,
                url: '/cursos/discusion/agregarDiscusion',
                data: data
            }).done(function( html ) {
                var resultado = jQuery.parseJSON(html);
                if(resultado.res){
                    //Se agrego la discusion, ordenamos por fecha descendente para que el usuario vea su entrada
                    orden = "fecha";
                    ascendente = 0;
                    $("#selectOrden").val(orden);
                    $("#selectAscendente").val(ascendente);                                
                    validarDiscusionesNuevas(1);
                }else{
                    bootbox.alert("Error. "+resultado.msg);
                }
            });
        }      
        $('#agregarDiscusionModal').modal('hide');
        return false;
    });
}
function bindEventsTabs(){
    $('#tabContenido').on('shown', function(e) {
        location.hash = "Contenido";
    });
    $('#tabDescripcion').on('shown', function(e) {
        location.hash = "Descripción";
    });
    $('#tabForo').on('shown', function(e) {
        actualizarLinkHash();
    });
}
function actualizarPaginaPorLinkHash(){
    if (location.hash !== ''){ 
        if(location.hash.indexOf("Contenido") >= 0){
            $('#tabContenido').tab("show");
        }else if(location.hash.indexOf("Descripción") >= 0){
            $('#tabDescripcion').tab("show");
        }else if(location.hash.indexOf("Foro") >= 0){
            $('#tabForo').tab("show");
            var splitted = location.hash.split(",");
            var n = splitted.length;
            $auxPagina = 1;
            if(n > 1){
                //Tenemos el valor de la página
                $auxPagina = parseInt(splitted[1],10);
            }
            if(n > 2){
                //tenemos la informacion de la forma de ordenar
                var posiblesOrdenamientos = ["puntuacion","fecha","alfabetico"];
                if($.inArray(splitted[2], posiblesOrdenamientos) >= 0){
                    orden = splitted[2];
                    $("#selectOrden").val(orden);
                }
            }
            if(n > 3){
                //tenemos la informacion del ordenamiento
                var posiblesValores = ["mayor","menor"];
                var pos = $.inArray(splitted[3], posiblesValores)
                if(pos >= 0){
                    ascendente = pos;
                    $("#selectAscendente").val(ascendente);
                }
            }
            mostrarPaginaDiscusiones($auxPagina, true, true);
        }
    }    
}
function actualizarLinkHash(){
    var posiblesValores = ["mayor","menor"];
    var auxHash = "Foro,"+paginaActual+","+$("#selectOrden").val()+","+posiblesValores[$("#selectAscendente").val()];    
    location.hash = auxHash;
}

$(document).ready(function() {
    $("#editor").wysiwyg();
    actualizarVotos();
    bindEventBtnAgregarDiscusion();
    $("#selectOrden").change(function(){
        orden = $(this).val();
        mostrarPaginaDiscusiones(1, true, true);
    });
    $("#selectAscendente").change(function(){
        ascendente = $(this).val();
        mostrarPaginaDiscusiones(1, true, true);
    });
    ligarTodosLosEventos();    
    actualizarPaginaPorLinkHash();
    bindEventsTabs();
});
