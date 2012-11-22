<?php
$json = $clase->codigo;

$var = json_decode($json, true);

if (isset($var['textos']))
    $textos = $var['textos'];
if (isset($var['imagenes']))
    $imagenes = $var['imagenes'];
if (isset($var['videos']))
    $videos = $var['videos'];
if (isset($var['links']))
    $links = $var['links'];



if (isset($var['videoData'])) {
    $videoData = $var['videoData'];
    $top = $videoData['top'];
    $left = $videoData['left'];
    $width = $videoData['width'];
    $height = $videoData['height'];
} else {
    $top = 20;
    $left = 25;
    $width = 50;
    $height = 50;
}

if (isset($var['backgroundColor'])) {
    $backgroundColor = $var['backgroundColor'];
} else {
    $backgroundColor = "#000";
}
?>

<!DOCTYPE html>
<html lang="es" xml:lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Editor Unova</title>

        <link rel="stylesheet" media="screen" type="text/css" href="/lib/js/colorPicker/colorpicker.css" />
        <link rel="stylesheet" href="/lib/js/jquery-ui/ui-lightness/jquery-ui-1.9.1.custom.css" />
        <link type="text/css" href="/layout/css/headerEditor.css" rel="stylesheet" />	
        <link type="text/css" href="/layout/css/editorPopcorn.css" rel="stylesheet" />	


        <script src="/lib/js/jquery-1.8.2.min.js"></script>		
        <script src="/lib/js/jquery-ui/jquery-ui-1.9.1.custom.min.js"></script>
        <script src="/lib/js/popcorn-complete.min.js"></script>

        <script src="/lib/js/colorPicker/colorpicker.js"></script>
        <script src="/lib/js/tiny_mce/jquery.tinymce.js"></script>

        <script src="/js/editorPopcorn/funcionesPopcorn.js"></script>

        <script src="/js/editorPopcorn/agregarImagen.js"></script>
        <script src="/js/editorPopcorn/agregarTexto.js"></script>
        <script src="/js/editorPopcorn/agregarVideo.js"></script>
        <script src="/js/editorPopcorn/agregarLink.js"></script>

        <script src="/js/editorPopcorn/cambiarColorFondo.js"></script>

        <script src="/js/editorPopcorn/cargarPopcorn.js"></script>
        <script src="/js/funciones.js"></script>        

        <script language="javascript">
            function showHideControles(){
                $("#controlesContainer").toggle("slow");
                $(".toggleControles").toggle();
            }
        </script>

        <script languague="javascript">
            function cargarElementosGuardados(){
<?php
if (isset($textos))
    foreach ($textos as $texto) {
        ?>
                        cargarTextoEnArreglo( '<?php echo $texto['texto']; ?>','<?php echo $texto['inicio']; ?>','<?php echo $texto['fin']; ?>','<?php echo $texto['color']; ?>','<?php echo $texto['top']; ?>','<?php echo $texto['left']; ?>','<?php echo $texto['width']; ?>','<?php echo $texto['height']; ?>');
        <?php
    }
if (isset($imagenes))
    foreach ($imagenes as $imagen) {
        ?>
                        cargarImagenEnArreglo('<?php echo $imagen['urlImagen']; ?>','<?php echo $imagen['inicio']; ?>','<?php echo $imagen['fin']; ?>','<?php echo $imagen['color']; ?>','<?php echo $imagen['top']; ?>','<?php echo $imagen['left']; ?>','<?php echo $imagen['width']; ?>','<?php echo $imagen['height']; ?>');
        <?php
    }
if (isset($videos))
    foreach ($videos as $video) {
        ?>
                        cargarVideoEnArreglo('<?php echo $video['urlVideo']; ?>','<?php echo $video['inicio']; ?>','<?php echo $video['fin']; ?>','<?php echo $video['color']; ?>','<?php echo $video['top']; ?>','<?php echo $video['left']; ?>','<?php echo $video['width']; ?>','<?php echo $video['height']; ?>');
        <?php
    }
if (isset($links))
    foreach ($links as $link) {
        ?>
                        cargarLinkEnArreglo('<?php echo $link['texto']; ?>','<?php echo $link['url']; ?>','<?php echo $link['inicio']; ?>','<?php echo $link['fin']; ?>','<?php echo $link['color']; ?>','<?php echo $link['top']; ?>','<?php echo $link['left']; ?>','<?php echo $link['width']; ?>','<?php echo $link['height']; ?>');
        <?php
    }
?>
    }
        </script>
        <script>
        var iu = <?php echo $usuario->idUsuario; ?>;
        var uuid = "<?php echo $usuario->uuid; ?>";
        var ic = <?php echo $idCurso; ?>;
        var icl = <?php echo $idClase; ?>;
        var urlCurso = "<?php echo "/curso/" . $curso->uniqueUrl; ?>";
        var $esAudio = <?php if ($clase->idTipoClase == 0) echo "false"; else echo "true"; ?>;
        </script>
    </head>
    <body>
        <div id="modalDialog">

        </div>
        <div id="e_bar">
            <div id="top-bar">
                <a  class="logo left" id="logo"> <img src="/layout/imagenes/Unova_Logo_135x47.png"></a>
                <div class="element left ease3">
                    <a class="link">
                        <div id="menuLink">
                            <span class="left">Menú</span>  
                            <div id="flechaMenu" class="flechaAbajo left"></div>
                        </div>
                    </a>         
                    <div id="menu">
                        <div id="flechitaMenu"></div>
                        <div id="menuLinks">
                            <a id="btnGuardar">
                                <div class="menuElement">
                                    <div class="">Guardar</div>
                                </div>
                            </a>
                            <a id="btnSalir">
                                <div class="menuElement">
                                    <div class="">Salir</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="element left ease3">
                    <a class="link">
                        <div id="menuAgregarLink">
                            <span class="left">Editar</span>  
                            <div id="flechaMenu" class="flechaAbajo left"></div>
                        </div>
                    </a>         
                    <div id="menuAgregar">
                        <div id="flechitaMenuAgregar"></div>
                        <div id="menuAgregarLinks">
                            <a id="btnCambiarColor" onclick="mostrarDialogoCambiarColorFondo()">
                                <div class="menuElement">
                                    <div class="">Cambiar color fondo</div>
                                </div>
                            </a>
                            <a id="btnAgregarTexto" onClick="mostrarDialogoInsertarTexto()">
                                <div class="menuAgregarElement">
                                    <div class="">
                                        <span>Agregar texto</span>
                                    </div>
                                </div>
                            </a>
                            <a id="btnAgregarImagen" onClick="mostrarDialogoInsertarImagen()">
                                <div class="menuAgregarElement">
                                    <div class=""><span>Agregar imagen</span></div>
                                </div>
                            </a>
                            <a id="btnAgregarVideo" onClick="mostrarDialogoInsertarVideo()">
                                <div class="menuAgregarElement">
                                    <div class=""><span>Agregar video</span></div>
                                </div>
                            </a>
                            <a id="btnAgregarPagina" onClick="mostrarDialogoInsertarLink()">
                                <div class="menuAgregarElement">
                                    <div class=""><span>Agregar página web</span></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="editorContainment" style="background-color: <?php echo $backgroundColor; ?>">
            <div id="videoContainer" class="draggable resizable ui-widget-content" style="z-index:-10; background:transparent; position: absolute; top: <?php echo $top . '%'; ?>; left: <?php echo $left . '%'; ?>; width: <?php echo $width . '%'; ?>; height: <?php echo $height . '%'; ?>;">				
                <?php
                if ($clase->idTipoClase == 0) {
                    ?>
                    <video id="mediaPopcorn" class="videoClass">
                        <source src="/archivos/descarga/archivoDeClase/<?php echo $clase->idClase; ?>/1" type="video/mp4">
                        <source src="/archivos/descarga/archivoDeClase/<?php echo $clase->idClase; ?>/2" type="video/ogg">
                    </video>
                    <?php
                } else if ($clase->idTipoClase == 4) {
                    ?>
                    <audio id="mediaPopcorn" class="videoClass">
                        <source src="/archivos/descarga/archivoDeClase/<?php echo $clase->idClase; ?>/1" type="video/mp3">
                        <source src="/archivos/descarga/archivoDeClase/<?php echo $clase->idClase; ?>/2" type="video/ogg">
                    </audio>
                    <?php
                }
                ?>
            </div>
            <div id="footnotediv">
            </div>
            <?php
            require_once 'modulos/editorPopcorn/vistas/formaAgregarTexto.php';
            require_once 'modulos/editorPopcorn/vistas/formaAgregarImagen.php';
            require_once 'modulos/editorPopcorn/vistas/formaAgregarVideo.php';
            require_once 'modulos/editorPopcorn/vistas/formaAgregarLink.php';
            require_once 'modulos/editorPopcorn/vistas/formaCambiarColor.php';
            ?>
            <div id="footer">
                <div id="ShowHideControles">
                    <a   onclick="showHideControles()">
                        <div title="Mostrar controles" class="ui-state-default ui-corner-all littleBox toggleControles" style="display:none;">
                            >>
                        </div>
                        <div title="Ocultar controles"  class="ui-state-default ui-corner-all littleBox toggleControles" style="" >
                            <<
                        </div>
                    </a>

                </div>
                <div id="controlesContainer" class="ui-widget-header ui-corner-all">	

                    <div id="controles">
                        <a  onclick="playVideo()" title="Play"  >
                            <div class="ui-state-default ui-corner-all littleBox" >
                                <span class="ui-icon ui-icon-play" style="float:left;margin: 0 4px;">
                                    Play
                                </span>
                            </div>
                        </a>
                        <a  onclick="pauseVideo()" title="Pause">
                            <div class="ui-state-default ui-corner-all littleBox">
                                <span class="ui-icon ui-icon-pause" style="float:left;margin: 0 4px;">
                                    Pause
                                </span>
                            </div>
                        </a>
                    </div>
                    <div id="sliderContainer">
                        <div id="controlTiempo"></div>
                        <div id="slider"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

