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
?>
<!DOCTYPE html>
<html lang="es" xml:lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Editor Unova</title>

        <link rel="stylesheet" href="/layout/css/MainStyle.css" />
        <link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/lib/bootstrap/css/bootstrap-responsive.min.css">

        <link rel="stylesheet" media="screen" type="text/css" href="/lib/js/colorPicker/evol.colorpicker.css" />
        <link rel="stylesheet" href="/lib/js/jquery-ui/bootstrap-theme/jquery-ui-1.10.0.custom.css" />
        <link type="text/css" href="/layout/css/editorPopcorn.css" rel="stylesheet" />	
        <link rel="stylesheet" href="/layout/css/cus-icons.css" />
        <script src="/lib/js/jquery-1.9.1.min.js"></script>	        
        <script src="/lib/js/jquery-migrate-1.1.1.js"></script>	        
        <script src="/lib/bootstrap/js/bootstrap.min.js"></script>
        <script src="/lib/js/ajaxFileUpload/ajaxfileupload.js"></script>
        <script src="/lib/js/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
        <?php
        //Si es tablet cargamos la librería touch-punch
        if (getTipoLayout() == "tablet") {
            ?>
            <script src="/lib/js/jquery-ui/jquery.ui.touch-punch.min.js"></script>
            <?
        }
        ?>
        <script src="/lib/js/popcorn-complete.min.js"></script>

        <script src="/lib/js/colorPicker/evol.colorpicker.min.js"></script>
        <script src="/lib/js/tiny_mce/jquery.tinymce.js"></script>
        <script src="/lib/bootstrap/js/bootstrap.file-input.js"></script>

        <script src="/js/editorPopcorn/funcionesPopcorn.js"></script>

        <script src="/js/editorPopcorn/agregarImagen.js"></script>
        <script src="/js/editorPopcorn/agregarTexto.js"></script>
        <script src="/js/editorPopcorn/agregarVideo.js"></script>
        <script src="/js/editorPopcorn/agregarLink.js"></script>
        <script src="/js/editorPopcorn/agregarCuestionario.js"></script>

        <script src="/js/editorPopcorn/cargarPopcorn.js"></script>
        <script src="/js/funciones.js"></script>        

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
        if (isset($imagen['tipo'])) {
            $tipo = $imagen['tipo'];
        } else {
            $tipo = "imagen";
        }
        ?>
                        cargarImagenEnArreglo('<?php echo $imagen['urlImagen']; ?>','<?php echo $imagen['inicio']; ?>','<?php echo $imagen['fin']; ?>','<?php echo $imagen['color']; ?>','<?php echo $imagen['top']; ?>','<?php echo $imagen['left']; ?>','<?php echo $imagen['width']; ?>','<?php echo $imagen['height']; ?>','<?php echo $tipo; ?>');
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
                        cargarLinkEnArreglo('','<?php echo $link['url']; ?>','<?php echo $link['inicio']; ?>','<?php echo $link['fin']; ?>','<?php echo $link['color']; ?>','<?php echo $link['top']; ?>','<?php echo $link['left']; ?>','<?php echo $link['width']; ?>','<?php echo $link['height']; ?>');
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
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="/" style="padding: 0px; padding-right: 40px;"><img src="/layout/imagenes/Unova_Logo_135x47.png"></a>
                    <?php
                    if (isset($usuario)) {
                        ?>
                        <div class="nav-collapse collapse">
                            <ul class="nav ">
                                <li class="dropdown ">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        Menú
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a id="btnSalir" href="#"><i class="icon-arrow-up"></i> Regresar al curso</a></li>                                                         
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav pull-right">                            
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Mis Cursos
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/usuarios/cursos/inscrito">Cursos a los que estoy inscrito</a></li>
                                        <li><a href="/usuarios/cursos/instructor">Cursos que imparto</a></li>
                                    </ul>                                
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <?php
                                        echo $usuario->nombreUsuario;
                                        ?> <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/usuario/<?php echo $usuario->uniqueUrl; ?>">Mi perfil</a></li>
                                        <li class="divider"></li>                                
                                        <li><a href="/login/login/logout">Cerrar sesión</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>    
        <div id="guardando">
            <img src="/layout/imagenes/loading.gif">Guardando...
        </div>        
        <div id="editorContainment">
            <div id="tools" class="ui-corner-all"  style="z-index:9999;">
                <div class="row-fluid">
                    <div class="span12 centerText">
                        <a href="#" id="btnMostrarHerramientas">
                            Insertar
                            <li class="divider"></li>     
                        </a>
                    </div>                    
                </div>
                <div class="row-fluid" id="herramientas">
                    <div class="row-fluid">
                        <div class="span12 ">
                            <a href="#" onclick="mostrarDialogoInsertarTexto()">
                                <i class="cus-page-white-text herramientasIcon"></i>Texto
                            </a>
                        </div>
                    </div>    
                    <div class="row-fluid">
                        <div class="span12 ">
                            <a href="#" onclick="mostrarDialogoInsertarImagen('imagen')">
                                <i class="cus-picture-add herramientasIcon"></i>Imagen
                            </a>
                        </div>
                    </div>    
                    <div class="row-fluid">
                        <div class="span12 ">
                            <a href="#" onclick="mostrarDialogoInsertarImagen('formas')">
                                <i class="cus-pictures herramientasIcon"></i>Forma predefinida
                            </a>
                        </div>
                    </div>    
                    <div class="row-fluid">
                        <div class="span12 ">
                            <a href="#" onclick="mostrarDialogoInsertarVideo()">
                                <i class="cus-film-add herramientasIcon"></i>Video
                            </a>
                        </div>
                    </div>    
                    <div class="row-fluid">
                        <div class="span12 ">
                            <a href="#" onclick="mostrarDialogoInsertarLink()">
                                <i class="cus-world-add herramientasIcon"></i>Página web
                            </a>
                        </div>
                    </div>          
                    <div class="row-fluid">
                        <div class="span12 ">
                            <a href="#" onclick="mostrarDialogoInsertarCuestionario()">
                                <i class="cus-help herramientasIcon"></i>Pregunta
                            </a>
                        </div>
                    </div> 
                </div>
            </div>
            <div id="videoContainer" class="draggable resizable" style="z-index:-10; position: absolute; top: <?php echo $top . '%'; ?>; left: <?php echo $left . '%'; ?>; width: <?php echo $width . '%'; ?>; height: <?php echo $height . '%'; ?>;">				
                <?php
                if ($clase->idTipoClase == 0) {
                    ?>
                    <video id="mediaPopcorn" class="videoClass">
                        <source src="<?php echo $clase->archivo; ?>" type="video/mp4">
                        <source src="<?php echo $clase->archivo2; ?>" type="video/ogg">
                    </video>
                    <?php
                } else if ($clase->idTipoClase == 4) {
                    ?>
                    <audio id="mediaPopcorn" class="videoClass">
                        <source src="<?php echo $clase->archivo; ?>" type="video/mp3">
                        <source src="<?php echo $clase->archivo2; ?>" type="video/ogg">
                    </audio>
                    <?php
                }
                ?>
            </div>
            <div id="footnotediv">
            </div>
        </div>       
        <div id="controlesContainer" class="ui-widget-header ui-corner-all">	
            <div id="botonPlayContainer">
                <a id="btnPlayToggle">
                    <div class="playBox" >
                        <div id="iconPlayPausa" class="pauseIcon"></div>
                    </div>
                </a>
            </div>
            <div id="sliderTiempoContainer">
                <div id="sliderContainer">
                    <div id="slider"></div>
                </div>
            </div>
            <div id="tiempoVideoContainer">
                <div id="controlTiempo"></div>
            </div>
        </div>
        <?php
        require_once 'modulos/editorPopcorn/vistas/formaAgregarTexto.php';
        require_once 'modulos/editorPopcorn/vistas/formaAgregarImagen.php';
        require_once 'modulos/editorPopcorn/vistas/formaAgregarVideo.php';
        require_once 'modulos/editorPopcorn/vistas/formaAgregarLink.php';
        require_once 'modulos/editorPopcorn/vistas/formaAgregarCuestionario.php';
        ?>
    </body>
</html>

