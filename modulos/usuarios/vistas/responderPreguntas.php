<?php
require_once ('layout/headers/headInicio.php');
require_once ('layout/headers/headListaCursos.php');
require_once ('layout/headers/headResponderPreguntas.php');
require_once ('layout/headers/headCierre.php');
?>


<div class="contenido">
    <div class="container">
        <div class="row-fluid">
            <div class="span12">
                <h1>Preguntas sin responder</h1>
            </div>
        </div>
        <div class="row-fluid">
            <?php
            if (isset($preguntas)) {
                ?>
                <div class="span12">
                    <?php
                    $auxIdCurso = -1;

                    foreach ($preguntas as $pregunta) {

                        if ($pregunta->idCurso != $auxIdCurso) {
                            echo '<div>';
                            echo '<div style="overflow:hidden;display:block;padding-right:20px; padding-botton:10px;">
                    <a href="/curso/' . $pregunta->uniqueUrl . '&b='. getRequestUri() .'">
                    <img style="float:left;"src="' . $pregunta->imagen . '"/>
                    <h2 style="float:left;padding-top:20px;"> Preguntas del curso ' . $pregunta->titulo . '</h2>
                    </a>';
                            echo '</div></div>';
                            $auxIdCurso = $pregunta->idCurso;
                        }
                        echo '<div class="preguntaContainer whiteBox" style="width:97%;">';
                        echo '<div class="comentarioAvatar"><img src="' . $pregunta->avatar . '"></div>';
                        echo '<div class="comentarioUsuario"><a href="/usuario/' . $pregunta->uniqueUrlUsuario . '&b=' . getRequestUri() . '">' . $pregunta->nombreUsuario . '</a></div>';
                        echo '<br><div class="comentario">' . $pregunta->pregunta . '</div>';
                        if (isset($pregunta->respuesta)) {
                            echo '<br><div class="respuesta blueBox" style="width: 80%;">';
                            echo '<div class="comentarioAvatar"><img src="' . $pregunta->avatar . '"></div>';
                            echo '<div class="comentarioUsuario"><a href="/usuario/' . $pregunta->uniqueUrlUsuario . '&b=' . getRequestUri() . '">' . $pregunta->nombreUsuario . '</a></div>';
                            echo '<br><div class="comentario">' . $pregunta->respuesta . '</div>';
                            echo '</div>';
                        } else {
                            echo '<div class="respuesta">';
                            echo '<div class="loading" style="display:none;">';
                            echo '<img src="/layout/imagenes/loading.gif" style="width:30px;">';
                            echo '</div>';
                            echo '<form id="preguntaForm" method="POST" action="/cursos/curso/responderPreguntaCurso/' . $pregunta->idCurso . '/' . $pregunta->idPregunta . '"  class="preguntarForm">';
                            echo '<textarea id="pregunta" name="respuesta"  ></textArea>';
                            echo '<br><input type="submit" value="  Responder  ">';
                            echo '</form>';
                            echo '</div>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
                <?php
            } else {
                ?>
                <div class="span12">
                    <div class="well well-large"><h3>No hay preguntas sin responder</h3></div>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="row-fluid">
            <div class="span3 subir20px">
                <a class="btn btn-inverse btn-small" href="/usuarios/cursos/instructor">
                    <i class="icon-white icon-arrow-left"></i>
                    Regresar
                </a>
            </div>
        </div>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>