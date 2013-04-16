//Funciones de la discusion
function actualizarVotosDiscusion(){    
    var idDiscusion = $("#discusion").attr("discusion");
    var votacion = getVotacionDiscusion(idDiscusion);
    if(votacion == 1){            
        $("#votacionDiscusionMenos_"+idDiscusion).removeClass("label label-important");
        $("#votacionDiscusionMenos_"+idDiscusion).children("i").removeClass("icon-white");
        $("#votacionDiscusionMas_"+idDiscusion).addClass("label label-success votado");
        $("#votacionDiscusionMas_"+idDiscusion).children("i").addClass("icon-white");     
    }else if(votacion == -1){
        $("#votacionDiscusionMas_"+idDiscusion).removeClass("label label-success");
        $("#votacionDiscusionMas_"+idDiscusion).children("i").removeClass("icon-white");
        $("#votacionDiscusionMenos_"+idDiscusion).addClass("label label-important votado");
        $("#votacionDiscusionMenos_"+idDiscusion).children("i").addClass("icon-white");
    }
}
function votarDiscusion($discusion, $delta){
    if (Modernizr.localstorage) {
        var variableGuardado = "unova.votacion.discusion." + $discusion;
        var valor = localStorage[variableGuardado];
        if(valor == null){
            //no hay votación anterior, la guardamos en localStorage
            localStorage[variableGuardado] = $delta;
            enviarVotacionDiscusion($discusion, $delta);
        }else{
            valor = parseInt(valor);
            //ya hay votación anterior, verificamos que sea voto diferente
            if(valor != $delta){
                //Cambio su voto
                localStorage[variableGuardado] = $delta;
                $delta = $delta * 2;
                enviarVotacionDiscusion($discusion, $delta);
            }
        }        
    }else{
        alert("Tu navegador no soporta esta funcionalidad. Te sugerimos actualizarlo");
    }
}
function enviarVotacionDiscusion($discusion, $delta){
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
            $("#votacionDiscusionMas_"+$discusion).children("span").text(puntuacionMas);
            $("#votacionDiscusionMenos_"+$discusion).children("span").text(puntuacionMenos);
            //actualizamos la barra
            $("#porcentajeDiscusionPositivo_"+$discusion).css("width",porcentajePositivo+"%");
            $("#porcentajeDiscusionNegativo_"+$discusion).css("width",porcentajeNegativo+"%");
        }else{
            bootbox.alert("Error. "+resultado.msg);
        }
    });
}
function getVotacionDiscusion($discusion){
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


//codigo para los comentarios
var directionHide = "left";
var directionShow = "right";
var easingType = "";

function mostrarPaginaComentarios($pagina, $force, $blind){
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
        $("#comentarioPager_"+$pagina).addClass("active");
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
        $("#comentariosPagerContent").hide(easingType, {
            direction: directionHide
        }, function() {
            $("#comentariosPagerLoading").show();
            //Hacemos la llamada ajax para actualizar el pager
            var data = {
                pagina: $pagina,
                rows: rows,
                discusion: discusion,
                orden : orden,
                ascendente: ascendente
            };    
            $.ajax({
                type: 'post',
                cache: false,
                url: '/cursos/comentario/obtenerComentarios',
                data: data
            }).done(function( html ) {
                var str = html.toString();
                if(str.indexOf("error") != -1){
                //Error            
                }else{
                    $("#comentariosPagerLoading").hide();                        
                    $("#comentariosPagerContent").html(html);
                    $("#comentariosPagerContent").show(easingType,{
                        direction:directionShow
                    });     
                    ligarEventosDeVotacion();
                    ligarEventosBorrarComentario();
                    actualizarVotos();
                    actualizarLinkHash();
                }
            });
        });   
    }
}
function validarComentariosNuevas($paginaDefault){
    var data = {
        discusion: discusion
    };    
    $.ajax({
        type: 'post',
        cache: false,
        url: '/cursos/comentario/obtenerNumeroComentarios',
        data: data
    }).done(function( html ) {
        var resultado = jQuery.parseJSON(html);
        if(numComentarios != resultado.n){
            //Hay comentarios nuevas
            numComentarios = resultado.n;
            actualizarPager();
            mostrarPaginaComentarios($paginaDefault, true, true);
        }
    });
}
    
function actualizarPager(){
    $("#paginationComentario").empty();
    maxPagina = Math.ceil(numComentarios / rows);
    var $dom = '<ul>';
    $dom +=  '<li class="btnPagination disabled" id="paginaMenos" pagina="1">';
    $dom +=     '<a href="javascript:void(0);">«</a></li>';
    $dom +=  '</li>';
    for(i=1;i<=maxPagina;i++){
        if(i == paginaActual)
            $dom += '<li id="comentarioPager_' + i + '" class="btnPagination active" pagina="' + i + '"><a href="javascript:void(0);">' + i + '</a></li>';
        else
            $dom += '<li id="comentarioPager_' + i + '" class="btnPagination" pagina="' + i + '"><a href="javascript:void(0);">' + i + '</a></li>';
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
    $("#paginationComentario").html($dom);
    ligarEventosDeClickPager();
}
function ligarEventosDeClickPager(){
    $(".btnPagination").click(function(){
        $pagina = parseInt($(this).attr("pagina"));
        mostrarPaginaComentarios($pagina,false, false);
    });           
}
function ligarEventosDeVotacion(){
    //Clicks en la votacion
    $(".comentarioVotacionMas").click(function(){
        $comentario = $(this).attr('comentario');
        $("#votacionMenos_"+$comentario).removeClass("label label-important");
        $("#votacionMenos_"+$comentario).children("i").removeClass("icon-white");
        $(this).addClass("label label-success votado");
        $(this).children("i").addClass("icon-white");              
        votarComentario($comentario, 1);
    });       
        
    $(".comentarioVotacionMenos").click(function(){
        $comentario = $(this).attr('comentario');
        $("#votacionMas_"+$comentario).removeClass("label label-success");
        $("#votacionMas_"+$comentario).children("i").removeClass("icon-white");
        $(this).addClass("label label-important votado");
        $(this).children("i").addClass("icon-white");
        votarComentario($comentario, -1);
    });
}
function ligarEventosBorrarComentario(){
    $(".btnBorrarComentario").click(function(){
        var idComentario = $(this).attr("comentario");
        var data = {
            idComentario: idComentario
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
                        url: '/cursos/comentario/eliminarComentario',
                        data: data
                    }).done(function( html ) {
                        var resultado = jQuery.parseJSON(html);
                        if(resultado.res){
                            validarComentariosNuevas(paginaActual);     
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
    ligarEventosBorrarComentario();
}

function actualizarVotos(){
    $(".comentario").each(function(){
        var idComentario = $(this).attr("comentario");
        var votacion = getVotacion(idComentario);
        if(votacion == 1){            
            $("#votacionMenos_"+idComentario).removeClass("label label-important");
            $("#votacionMenos_"+idComentario).children("i").removeClass("icon-white");
            $("#votacionMas_"+idComentario).addClass("label label-success votado");
            $("#votacionMas_"+idComentario).children("i").addClass("icon-white");     
        }else if(votacion == -1){
            $("#votacionMas_"+idComentario).removeClass("label label-success");
            $("#votacionMas_"+idComentario).children("i").removeClass("icon-white");
            $("#votacionMenos_"+idComentario).addClass("label label-important votado");
            $("#votacionMenos_"+idComentario).children("i").addClass("icon-white");
        }
    });
}
    
function votarComentario($comentario, $delta){
    if (Modernizr.localstorage) {
        var variableGuardado = "unova.votacion.comentario." + $comentario;
        var valor = localStorage[variableGuardado];
        if(valor == null){
            //no hay votación anterior, la guardamos en localStorage
            localStorage[variableGuardado] = $delta;
            enviarVotacion($comentario, $delta);
        }else{
            valor = parseInt(valor);
            //ya hay votación anterior, verificamos que sea voto diferente
            if(valor != $delta){
                //Cambio su voto
                localStorage[variableGuardado] = $delta;
                $delta = $delta * 2;
                enviarVotacion($comentario, $delta);
            }
        }        
    }else{
        alert("Tu navegador no soporta esta funcionalidad. Te sugerimos actualizarlo");
    }
}
function enviarVotacion($comentario, $delta){
    var data = {
        comentario: $comentario,
        delta: $delta
    };    
    $.ajax({
        type: 'post',
        cache: false,
        url: '/cursos/comentario/votarComentario',
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
            $("#votacionMas_"+$comentario).children("span").text(puntuacionMas);
            $("#votacionMenos_"+$comentario).children("span").text(puntuacionMenos);
            //actualizamos la barra
            $("#porcentajePositivo_"+$comentario).css("width",porcentajePositivo+"%");
            $("#porcentajeNegativo_"+$comentario).css("width",porcentajeNegativo+"%");
        }else{
            bootbox.alert("Error. "+resultado.msg);
        }
    });
}
function getVotacion($comentario){
    if (Modernizr.localstorage) {
        var variableGuardado = "unova.votacion.comentario." + $comentario;
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

function bindEventBtnAgregarComentario(){
    $('#agregarComentarioModal').on('hidden', function () {        
        $("#inputTitulo").val("");
        $("#editor").empty();
        $("#dialogoErrorComentario").empty();
    });
    $("#btnAgregarComentario").click(function(){
        $('#editor').removeClass("inputError");
        error = false;
        var msgError = "";
        $texto = $('#editor').cleanHtml();
        if($texto.length < 10 ){
            error = true;
            msgError = "Introduce el texto, por lo menos 10 letras";
            $('#editor').addClass("inputError");
        }
        if(error){
            var auxBlock = '<div class="alert alert-error alert-block">';
            auxBlock += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            auxBlock += '<strong>¡Error! </strong>  '+msgError;
            $("#dialogoErrorComentario").empty();
            $("#dialogoErrorComentario").html(auxBlock);
            $("#dialogoErrorComentario").show();
        }else{
            //Enviamos la solicitud par crear la comentario
            var data = {
                texto: $texto,
                discusion: discusion
            };    
            $.ajax({
                type: 'post',
                cache: false,
                url: '/cursos/comentario/agregarComentario',
                data: data
            }).done(function( html ) {
                $('#agregarComentarioModal').modal('hide');
                var resultado = jQuery.parseJSON(html);
                if(resultado.res){
                    //Se agrego la comentario, ordenamos por fecha descendente para que el usuario vea su entrada
                    orden = "fecha";
                    ascendente = 0;
                    $("#selectOrden").val(orden);
                    $("#selectAscendente").val(ascendente);                                
                    validarComentariosNuevas(1);
                }else{
                    bootbox.alert("Error. "+resultado.msg);
                }
                
            });
        }      
        return false;
    });
}
function bindEventsTabs(){
    
}
function actualizarPaginaPorLinkHash(){
    $auxPagina = 1;
    if (location.hash !== ''){ 
        var splitted = location.hash.split(",");
        var n = splitted.length;        
        if(n > 0){
            //Tenemos el valor de la página
            $auxPagina = splitted[0].substr(1);
            $auxPagina = parseInt($auxPagina,10);
        //console.log($auxPagina);
        }
        if(n > 1){
            //tenemos la informacion de la forma de ordenar
            var posiblesOrdenamientos = ["puntuacion","fecha","alfabetico"];
            if($.inArray(splitted[1], posiblesOrdenamientos) >= 0){
                orden = splitted[1];
                $("#selectOrden").val(orden);
            }
        }
        if(n > 2){
            //tenemos la informacion del ordenamiento
            var posiblesValores = ["mayor","menor"];
            var pos = $.inArray(splitted[2], posiblesValores)
            if(pos >= 0){
                ascendente = pos;
                $("#selectAscendente").val(ascendente);
            }
        }
    }    
    mostrarPaginaComentarios($auxPagina, true, true);
}
function actualizarLinkHash(){
    var posiblesValores = ["mayor","menor"];
    var auxHash = ""+paginaActual+","+$("#selectOrden").val()+","+posiblesValores[$("#selectAscendente").val()];    
    location.hash = auxHash;
}

$(document).ready(function() {
    //Codigo para la discusion
    //Actualizamos los votos de la discusion
    actualizarVotosDiscusion();
    //Clicks en la votacion de la discusión
    $(".discusionVotacionMas").click(function(){
        $discusion = $(this).attr('discusion');
        $("#votacionDiscusionMenos_"+$discusion).removeClass("label label-important");
        $("#votacionDiscusionMenos_"+$discusion).children("i").removeClass("icon-white");
        $(this).addClass("label label-success votado");
        $(this).children("i").addClass("icon-white");              
        votarDiscusion($discusion, 1);
    });       
        
    $(".discusionVotacionMenos").click(function(){
        $discusion = $(this).attr('discusion');
        $("#votacionDiscusionMas_"+$discusion).removeClass("label label-success");
        $("#votacionDiscusionMas_"+$discusion).children("i").removeClass("icon-white");
        $(this).addClass("label label-important votado");
        $(this).children("i").addClass("icon-white");
        votarDiscusion($discusion, -1);
    });
    
    //Codigo para los comentarios
    $("#editor").wysiwyg();
    actualizarVotos();
    bindEventBtnAgregarComentario();
    $("#selectOrden").change(function(){
        orden = $(this).val();
        mostrarPaginaComentarios(1, true, true);
    });
    $("#selectAscendente").change(function(){
        ascendente = $(this).val();
        mostrarPaginaComentarios(1, true, true);
    });
    ligarTodosLosEventos();    
    actualizarPaginaPorLinkHash();
});