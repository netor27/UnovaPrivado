$(function(){
    
    $('#menuLink').hover(function(){
        //cambiamos la flecha
        $("#flechaMenu").removeClass('flechaAbajo');
        $("#flechaMenu").addClass('flechaArriba');  
        $("#menu").show("swing"); 
        cerrarMenuAgregar();
    },function(){
        
        });
    
    $('#menuAgregarLink').hover(function(){
        //hover in, mostramos el menu
        $("#flechaMenuAgregar").removeClass('flechaAbajo');
        $("#flechaMenuAgregar").addClass('flechaArriba');  
        $("#menuAgregar").show("swing"); 
        cerrarMenu();
    },
    function(){
        //        //hover out, escondemos el menu
        //        $("#flechaMenuAgregar").removeClass('flechaArriba');
        //        $("#flechaMenuAgregar").addClass('flechaAbajo');
        });
    
    //Para evitar que al presionar enter se cierre el dialogo
    $('form').submit(function(e){
        return false;
    });

    $("#ShowHideToolbox").click(
        function(){
            $("#toolbox").toggle("slow");
            $(".showHideToolboxButton").toggle();
        });
    
    cargarElementosGuardados();
    
    $("#btnGuardar").click(
        function(){
            guardar(iu, uuid, ic, icl,false)
        });
    $("#btnSalir").click(
        function(){
            $("#modalDialog").html("<h1>Estás apunto de salir</h1>");
            $( "#modalDialog" ).dialog({
                height: 250,
                width: 500,
                draggable: true,
                resizable: false,
                modal: true,
                buttons:{ 
                    "Guardar y Salir": function(){
                        guardar(iu, uuid, ic, icl,true);
                        
                    },
                    "Salir sin guardar": function(){
                        salir();
                    },
                    "Cancelar":function(){
                        $(this).dialog("close");
                    }
                }
            });
        });
    $(document).mouseup(function(e){       
        var id = $(e.target).parents("div").attr("id");
        if(id != "menuLink"){
            cerrarMenu();
        }        
        if(id != "menuAgregarLink"){
            cerrarMenuAgregar();
        }   
    });
    $("#editorContainment").hover(function(){
        cerrarMenu();
        cerrarMenuAgregar();
    });
    
    //Para mantener la sesión abierta
    KeepAlive();
    setInterval(KeepAlive, '600000');
});

function cerrarMenu(){
    if($("#flechaMenu").hasClass("flechaArriba")){
        $("#menu").hide("swing");
        $("#flechaMenu").removeClass("flechaArriba");
        $("#flechaMenu").addClass("flechaAbajo");
    }
}

function cerrarMenuAgregar(){
    if($("#flechaMenuAgregar").hasClass("flechaArriba")){
        $("#menuAgregar").hide("swing");
        $("#flechaMenuAgregar").removeClass("flechaArriba");
        $("#flechaMenuAgregar").addClass("flechaAbajo");
    }
}

function getUnidadPx(unidad){
    var aux = ""+unidad;
    if(aux.indexOf("auto") != -1){
        return unidad;
    }else{
        return unidad + "%";
    }
}

function cambiarColorPicker(hex, id){
    console.log("Cambiando Color picker "+id+" con hex = "+hex);
    $("#colorSelector"+id).ColorPickerSetColor(hex);
    $('#colorSeleccionado'+id).css('backgroundColor', hex);
    $('#colorHidden'+id).val(hex);
}

//Funcion utilizada para transformar un entero que representa segundos a minutos en un string de la forma mm:ss
function transformaSegundos(segundos){
    var min = parseInt(segundos / 60);	
    var seg = segundos % 60;
    
    if(min < 10)
        min = "0"+min;    
    if(seg < 10)
        seg = "0"+seg;
    
    var res = (min + ":" + seg);
    res = res.substr(0, 5);
    
    return res;
}

//Transforma un string de la forrma mm:ss a un entero que representa los segundos
function stringToSeconds(str){
    var splitted = str.split(":");
    var minutos = parseInt(splitted[0]);
    var seg = parseInt(splitted[1]);
    
    if(!isNaN(minutos) && !isNaN(seg)){
        return (minutos * 60) + seg;
    }else{
        return 0;
    }
}

//Guardar los datos
function guardar(u, uuid, cu, cl, salirDespuesDeGuardar){    
    pauseVideo();
    
    $("#modalDialog").html("<h1>Guardando, espera un momento...</h1><br><img style='width:50px;' src='/layout/imagenes/loading.gif'>");
    $( "#modalDialog" ).dialog({
        height: 250,
        width: 500,
        draggable: true,
        resizable: false,
        modal: true,
        buttons:{ }
    });  
    
    backgroundColor = $("#editorContainment").css("background-color");
    console.log(backgroundColor);
    
    $containmentWidth = $("#editorContainment").width();
    $containmentHeight  = $("#editorContainment").height();    
    var videoData = {
        top: $("#videoContainer").position().top * 100 / $containmentHeight,
        left: $("#videoContainer").position().left * 100 / $containmentWidth,
        width: $("#videoContainer").width() * 100 / $containmentWidth,
        height: $("#videoContainer").height() * 100 / $containmentHeight
    }
    console.log(videoData['height']);
    
    logLinksAgregados();
    
    var data = {
        u: u,
        uuid: uuid,
        cu: cu,
        cl: cl,
        backgroundColor : backgroundColor,
        videoData: videoData,
        textos:  textos,
        imagenes: imagenes,
        videos: videos,
        links: links
    };
    
    $.ajax({
        type: 'post',
        cache: false,
        url: '/cursos/clase/guardarEdicionVideo',
        data: data
    }).done(function( html ) {
        var res = jQuery.parseJSON(html);        
        if(res.resultado == "error"){
            $("#modalDialog").html("<h3 class='error'>&iexcl;Error!</h3><br>"+res.mensaje);
        }else{
            console.log('antes de salir');
            if(salirDespuesDeGuardar){
                salir();
            }else{
                $("#modalDialog").html("<h1 class=''>"+res.mensaje+"</h3>");
                $( "#modalDialog" ).dialog({
                    height: 250,
                    width: 500,
                    draggable: true,
                    resizable: false,
                    modal: true,
                    buttons:{ 
                        "Aceptar": function(){
                            $(this).dialog("close");
                        }
                    }
                }); 
            }
        } 
    });
}

function salir(){
    redirect(urlCurso);
}