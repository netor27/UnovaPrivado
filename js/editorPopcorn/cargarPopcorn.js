//variable global para el video principal del curso
var $popPrincipal;
var $videoDuration;
var $containmentWidth = 100;
var $containmentHeight = 100;

$(function(){
    //Configuración inicial    
    $("#videoContainer").draggable({
        containment: "#editorContainment",
        snap: true
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
});

Popcorn( function() {
    inicializarPopcorn();
});

function inicializarPopcorn(){
    $popPrincipal = Popcorn('#mediaPopcorn');
    $popPrincipal.controls($esAudio);
    $popPrincipal.volume(0.5);
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
}
function pauseVideo(){
    $popPrincipal.pause();
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