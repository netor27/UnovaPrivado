var directionHide = "left";
var directionShow = "right";

function mostrarPaginaDiscusiones($pagina, $force){
    console.log("Cambiar a la pagina: "+$pagina);
    if($pagina > maxPagina)
        $pagina = maxPagina;   
        
    if($pagina > paginaActual){
        directionHide = "left";
        directionShow = "right";
    }else{
        directionHide = "right";
        directionShow = "left";
    }
    if(paginaActual != $pagina || $force){
        console.log("La pagina es " + $pagina);
        paginaActual = $pagina;
        console.log("La pagina es " + $pagina);
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
        console.log("La pagina es " + $pagina);
        $("#discusionesPagerContent").hide('slide', {
            direction: directionHide
        }, function() {
            $("#discusionesPagerLoading").show();
            //Hacemos la llamada ajax para actualizar el pager
            var data = {
                pagina: $pagina,
                rows: rows,
                curso: curso
            };    
            $.ajax({
                type: 'post',
                cache: false,
                url: '/cursos/discusion/obtenerDiscusiones',
                data: data
            }).done(function( html ) {
                var str = html.toString();
                if(str.indexOf("error") != -1){
                    console.log(html);                
                }else{
                    $("#discusionesPagerLoading").hide();                        
                    $("#discusionesPagerContent").html(html);
                    $("#discusionesPagerContent").show("slide",{
                        direction:directionShow
                    });     
                    ligarEventosDeClickDiscusion();
                    ligarEventosDeVotacion();
                    actualizarVotos();
                }
            });
        });   
    }
}
function validarDiscusionesNuevas(){
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
            numDiscusiones = resultado.n;
            console.log("hay discusiones nuevas");
            actualizarPager();
            mostrarPaginaDiscusiones(1,true);
        }
    });
}
    
function actualizarPager(){
    $("#paginationDiscusion").empty();
    maxPagina = Math.ceil(numDiscusiones / rows);
    console.log(maxPagina);
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
        mostrarPaginaDiscusiones($pagina,false);                    
    });           
}
function ligarEventosDeClickDiscusion(){
    $(".discusion").click(function(){
        var discusion = $(this).attr("discusion");
        alert("mostrar las entradas de la discusion "+discusion+ " -- En desarrollo --");
    });
}
function ligarEventosDeVotacion(){
    //Hover en la votacion
    $(".discusionVotacionMas").hover(function(){
        $(this).addClass("label label-success");
        $(this).children("i").addClass("icon-white");
    },function(){
        if(!$(this).hasClass("votado")){
            $(this).removeClass("label label-success");
            $(this).children("i").removeClass("icon-white");
        }            
    });
    $(".discusionVotacionMenos").hover(function(){
        $(this).addClass("label label-important");
        $(this).children("i").addClass("icon-white");
    },function(){
        if(!$(this).hasClass("votado")){
            $(this).removeClass("label label-important");
            $(this).children("i").removeClass("icon-white");
        }
    });
        
        
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
function ligarTodosLosEventos(){
    ligarEventosDeClickPager();
    ligarEventosDeClickDiscusion();
    ligarEventosDeVotacion();
}

function actualizarVotos(){
    $(".discusion").each(function(){
        var idDiscusion = $(this).attr("discusion");
        console.log("Discusion id="+idDiscusion);
        var votacion = getVotacion(idDiscusion);
        console.log(votacion);
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
            //mostramos la primara página
            $("#puntuacion_"+$discusion).html(resultado.msg);
            $("#puntuacion_"+$discusion).removeClass("badge-important");
            $("#puntuacion_"+$discusion).removeClass("badge-success");
            if (resultado.msg < 0) {
                $("#puntuacion_"+$discusion).addClass("badge-important");
            } else if (resultado.msg > 0) {
                $("#puntuacion_"+$discusion).addClass("badge-success");
            }
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
        return 0;
        console.log("Tu navegador no soporta esta funcionalidad. Te sugerimos actualizarlo");
    }
}
    
$(document).ready(function() {
    actualizarVotos();
    $("#btnAgregarDiscusion").click(function(){
        var $msg = "<legend><h4>Agregar un tema de discusión</h4></legend>";
        $msg += "<div class='row-fluid'>";
        $msg += "<div id='dialogoErrorDiscusion' style='display:none;'></div>";
        $msg += "</div>"
        $msg += "<div class='row-fluid'>";
        $msg += "<div class='span2'><strong style='padding-top:10px;'>Titulo:</strong></div>";
        $msg += "<div class='span8'><input class='span12' type='text' id='inputTitulo'></div>";
        $msg += "</div>"
        $msg += "<div class='row-fluid'>";
        $msg += "<div class='span2'><strong>Texto:</strong></div>";
        $msg += "<div class='span8'><textarea rows='10' class='span12' id='inputTexto'></textarea></div>";
        $msg += "</div>"
        bootbox.dialog($msg, 
            [{
                "label" : "Cancelar",
                "class" : "btn"
            }, {
                "label" : "Agregar",
                "class" : "btn-primary",
                "callback": function() {
                    var error = false;
                    var msgError = "";
                    $titulo = trim($("#inputTitulo").val());
                    $texto = trim($("#inputTexto").val());                
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
                        return false;
                    }else{
                        //Enviamos la solicitud par crear la discution
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
                            console.log(html);
                            if(resultado.res){
                                validarDiscusionesNuevas();
                            }else{
                                bootbox.alert("Error. "+resultado.msg);
                            }
                        });
                    }                
                }                                
            }]);
    });
    ligarTodosLosEventos();    
});
