//variable global para el video principal del curso
var $popPrincipal;
var $videoDuration;

$(document).ready(function() {
    //Configuración inicial    
    
    $( "#modalDialog" ).dialog({
        autoOpen: false,
        draggable: false,
        resizable: false,
        height: 200,
        width: 400        
    });  
    
    $("#videoContainer").draggable({
        containment: "#editorContainment"
    });
    $("#videoContainer").resizable({
        resize: function(event, ui) {
            var w = $("#videoContainer").width();
            var h = $("#videoContainer").height();
            $("#mediaPopcorn").width(w);
            $("#mediaPopcorn").height(h);
        },
        minHeight: 30,
        minWidth: 250,
        containment: "#editorContainment"
    });	
    $(".videoClass").bind("contextmenu", function(e) {
        e.preventDefault();
    });
    $("#tools").draggable({
        containment: "#editorContainment"
    });
    
    $("#btnMostrarHerramientas").click(function(){
        $("#herramientas").toggle("slow");
    });
});

Popcorn( function() {
    inicializarPopcorn();
});

function inicializarPopcorn(){
    $popPrincipal = Popcorn('#mediaPopcorn');
    $popPrincipal.controls($esAudio);
    $popPrincipal.volume(0);
    $popPrincipal.autoplay(true);

    $popPrincipal.on("timeupdate", function() {
        var current = parseInt($popPrincipal.currentTime());
        $("#slider").slider("value", current);        	
        $('#controlTiempo').text(transformaSegundos(current)+" / "+transformaSegundos($videoDuration));
    });

    $popPrincipal.on("playing", function() {    	
        $videoDuration = $popPrincipal.duration();
        //Configuración del slider
        $( "#slider" ).slider({
            range: "min",
            value: 0,
            min: 0,
            max: $videoDuration,
            slide: function( event, ui ) {				
                $popPrincipal.currentTime(ui.value);	
            }
        });
    });
    cargarTextos();
    cargarImagenes();    
    cargarLinks();
    cargarVideos();
}

//Funciones para pausar y reproducir el video principal
function playVideo(){
    $popPrincipal.play();
    //Establecemos el boton en pausa
    $("#iconPlayPausa").removeClass("playIcon");
    $("#iconPlayPausa").addClass("pauseIcon");    
}
function pauseVideo(){
    $popPrincipal.pause();
    //Establecemos el boton en play
    $("#iconPlayPausa").removeClass("pauseIcon");
    $("#iconPlayPausa").addClass("playIcon");    
}

//funciones para obtener el tiempo total y el actual
function getCurrentTime(){
    return parseInt($popPrincipal.currentTime());
}
function getTotalTime(){
    return parseInt($popPrincipal.duration());
}

//funcion para eliminar los datos en el popPrincipal
function destroyPopcorn(){
    $popPrincipal.destroy();
    eliminarTextos();
    eliminarImagenes();
    eliminarVideos();
    eliminarLinks();
}