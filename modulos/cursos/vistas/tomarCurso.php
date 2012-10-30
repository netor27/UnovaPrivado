<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headTomarCurso.php');
require_once('layout/headers/headStarRating.php');
require_once('layout/headers/headCierre.php');
?>


<div class="contenido">    
    <div class="cursoHeader blueBox" style="width: 97.5%;">          
        <div id="cursoImageWrapper">

        </div>
        <div id="cursoTituloWrapper">            
            <div id="cursoImage">
                <img itemprop="image" src="<?php echo $curso->imagen; ?>" class="left">
            </div>
            <div id="cursoTitulo" itemprop="name"><?php echo $curso->titulo; ?></div>                
            <div id="cursoDescripcionCorta">      
                <p itemprop="description">
                    <?php echo $curso->descripcionCorta; ?>
                </p>
            </div>
        </div>
    </div>       

    <div class="cursoContainer">
        <div id="leftContainer" class="left">
            <div class="infoCursoContainer whiteBox" style="width: 97.5%;">
                <div id="cursoAutor" class="left">
                    <?php
                    echo 'Autor:<br> <a href="/usuario/' . $usuarioDelCurso->uniqueUrl . '">' . $usuarioDelCurso->nombreUsuario . '</a>';
                    ?>  
                    </a>
                </div>
                <div id="cursoDescripcion" class="left">
                    <?php
                    echo $curso->descripcion;
                    ?>
                </div>
            </div>
            <div id="temasContainer" class="whiteBox" style="width: 99%;">

                <?php
                $i = 1;
                $j = 1;
                if (isset($temas) && isset($clases)) {
                    foreach ($temas as $tema) {
                        echo '<h3> Tema ' . $i . ': <b>' . $tema->nombre . '</b></h3>';
                        echo '<ul>';
                        $j = 1;
                        foreach ($clases as $clase) {
                            if ($tema->idTema == $clase->idTema) {
                                switch ($clase->idTipoClase) {
                                    case 0:
                                        echo '<li class="single-class type-video">';
                                        echo '<a href="/curso/' . $curso->uniqueUrl . '/' . $clase->idClase . '"" class="thumb">';
                                        echo '<img src="/layout/imagenes/video.png">';
                                        echo '<div class="thumbText">' . $clase->duracion . '</div>';
                                        break;
                                    case 1:
                                        echo '<li class="single-class type-document">';
                                        echo '<a href="/curso/' . $curso->uniqueUrl . '/' . $clase->idClase . '"" class="thumb">';
                                        echo '<img src="/layout/imagenes/document.png">';
                                        break;
                                    case 2:
                                        echo '<li class="single-class type-presentation">';
                                        echo '<a href="/curso/' . $curso->uniqueUrl . '/' . $clase->idClase . '"" class="thumb">';
                                        echo '<img src="/layout/imagenes/presentation.png">';
                                        break;
                                    default:
                                        echo '<li class="single-class type-document">';
                                        echo '<a href="/curso/' . $curso->uniqueUrl . '/' . $clase->idClase . '"" class="thumb">';
                                        echo '<img src="/layout/imagenes/document.png">';
                                        break;
                                }

                                echo '</a>';
                                echo '<div class="details">';
                                echo '<h4>Clase ' . $j . ':</h4>';
                                if (strlen($clase->titulo) > 27)
                                    echo '<a href="/curso/' . $curso->uniqueUrl . '/' . $clase->idClase . '">' . substr($clase->titulo, 0, 27) . '...</a>';
                                else
                                    echo '<a href="/curso/' . $curso->uniqueUrl . '/' . $clase->idClase . '">' . $clase->titulo . '</a>';
                                echo '</div>';
                                echo '</li>';
                                $j++;
                            }
                        }
                        $i++;
                        echo '</ul>';
                    }
                }else {
                    ?>
                    <h2 style="text-align: center;">Este curso no tiene clases</h2>
                    <?php
                }
                ?>
            </div>

            <div id="cursoTabs">
                <ul>
                    <li><a href="#tabs-1">Comentarios</a></li>
                    <li><a href="#tabs-2">Preguntas</a></li>
                </ul>
                <div id="tabs-1">
                    <div id="comentariosContainer" >

                        <?php
                        if (isset($comentarios)) {
                            echo '<ul id="pageMeComments" class="pageMe">';
                            foreach ($comentarios as $comentario) {
                                echo '<li>';
                                if ($comentario->idUsuario == $curso->idUsuario)
                                    echo '<div class="comentarioContainer blueBox"  style="width:97%">';
                                else
                                    echo '<div class="comentarioContainer whiteBox"  style="width:97%">';
                                echo '<div class="comentarioAvatar"><img src="' . $comentario->avatar . '"></div>';
                                echo '<div class="comentarioUsuario"><a href="/usuario/' . $comentario->uniqueUrlUsuario . '">' . $comentario->nombreUsuario . '</a></div>';
                                echo '<div class="comentarioFecha">' . transformaDateDDMMAAAA(strtotime($comentario->fecha)) . '</div>';
                                echo '<br><div class="comentario">' . $comentario->texto . '</div>';
                                echo '</div>';
                                echo '</li>';
                            }
                            echo '</ul>';
                        }else {
                            ?>
                            <div id="pageMeComments">

                            </div>
                            <div id="noComments">
                                <h3>No hay comentarios</h3>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div id="comentar">
                        <form id="comentarioForm" action="/cursos/curso/comentarCurso/<?php echo $curso->idCurso; ?>" method="POST" class="comentarioForm">
                            <h3>Deja tu comentario</h3>
                            <textarea id="comentario" name="comentario"></textarea><br>
                            <input id="comentarButton" type="submit" value=" Comentar ">                            
                            <img id="loadingComment" src="/layout/imagenes/loading.gif">
                        </form>

                    </div>
                </div>
                <div id="tabs-2">
                    <div id="preguntasContainer">
                        <?php
                        if (isset($preguntas)) {
                            echo '<ul id="pageMePreguntas" class="pageMe">';
                            foreach ($preguntas as $pregunta) {
                                echo '<li>';
                                echo '<div class="preguntaContainer whiteBox">';
                                echo '<div class="comentarioAvatar"><img src="' . $pregunta->avatar . '"></div>';
                                echo '<div class="comentarioUsuario"><a href="/usuario/' . $pregunta->uniqueUrlUsuario . '">' . $pregunta->nombreUsuario . '</a></div>';
                                echo '<div class="comentarioFecha">' . transformaDateDDMMAAAA(strtotime($pregunta->fecha)) . '</div>';
                                echo '<br><div class="comentario">' . $pregunta->pregunta . '</div>';
                                if (isset($pregunta->respuesta)) {
                                    echo '<br><div class="respuesta blueBox" style="width: 95%;">';
                                    echo '<div class="comentarioAvatar"><img src="' . $usuarioDelCurso->avatar . '"></div>';
                                    echo '<div class="comentarioUsuario"><a href="/usuario/' . $usuarioDelCurso->uniqueUrl . '">' . $usuarioDelCurso->nombreUsuario . '</a></div>';
                                    echo '<div class="comentarioFecha">' . transformaDateDDMMAAAA(strtotime($pregunta->fechaRespuesta)) . '</div>';
                                    echo '<br><div class="comentario">' . $pregunta->respuesta . '</div>';
                                    echo '</div>';
                                }
                                echo '</div>';
                                echo '</li>';
                            }
                            echo '</ul>';
                        } else {
                            ?>
                            <div id="pageMePreguntas">

                            </div>
                            <div id="noPreguntas">
                                <h3>No hay preguntas</h3>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div id="preguntar">
                        <form id="preguntarForm" action="/cursos/curso/preguntarCurso/<?php echo $curso->idCurso; ?>" method="POST" class="preguntarForm">
                            <h3>Haz una pregunta al profesor</h3>
                            <textarea id="pregunta" name="pregunta"></textarea><br>
                            <input id="preguntarButton" type="submit" value=" Preguntar ">
                            <img id="loadingPregunta" src="/layout/imagenes/loading.gif">
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div id="rightContainer" class="right">
            <div id="numInscritos" class="whiteBox" style="width: 95%; text-align: center">
                <?php
                if ($numAlumnos == 1) {
                    echo "Este curso tiene <span> 1 </span> alumno inscrito";
                } else {
                    echo "Este curso tiene <span>" . $numAlumnos . "</span> alumnos inscritos";
                }
                if (isset($duracion) && $duracion > 0)
                    echo ' <br>y más de <span>' . $duracion . '</span> minutos de video';
                ?>
            </div>
            <div id="calificacion" class="whiteBox" style="width: 95%">
                Calificación total del curso
                <br>
                <div id="cursoStars">

                    <?php
                    $primera = true;
                    $aux = 0;
                    for ($i = 1; $i <= 20; $i++) {
                        $aux = ceil($i / 4);
                        if (($i / 4) < $curso->rating) {
                            echo '<input title="' . $aux . '" name="adv2" type="radio" disabled="disabled" class="wow star {split:4}"/>';
                        } else {
                            if ($primera && $curso->rating > 0) {
                                echo '<input title="' . $aux . '" name="adv2" type="radio" disabled="disabled" class="wow star {split:4}" checked="checked"/>';
                                $primera = false;
                            } else {
                                echo '<input title="' . $aux . '" name="adv2" type="radio" disabled="disabled" class="wow star {split:4}"/>';
                            }
                        }
                    }
                    ?>
                </div>
                <?php
                if ($esAlumno) {
                    ?>
                    <br>
                    Tu calificación del curso<br>
                    <div id="cursoStarsUsuario">                
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            if ($ratingUsuario == $i)
                                echo '<input value="' . $i . '" title="' . $i . '" type="radio" class="calificar" checked="checked"/>';
                            else
                                echo '<input value="' . $i . '" title="' . $i . '" type="radio" class="calificar" />';
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div id="instructor" class="whiteBox" style="width: 95%;">
                <div id="instructorHeader">
                    Instructor
                </div>
                <div id="instructorImage">
                    <img src="<?php echo $usuarioDelCurso->avatar; ?>"/>
                </div><br>
                <div id="instructorInfo">
                    <span id="nombre"><a href="/usuario/<?php echo $usuarioDelCurso->uniqueUrl; ?>"><?php echo $usuarioDelCurso->nombreUsuario; ?>  </a></span><br>
                    <span id="titulo"><?php echo $usuarioDelCurso->tituloPersonal; ?></span>
                </div>
                <div id="instructorBio">
                    <?php
                    echo $usuarioDelCurso->bio;
                    ?>
                </div>
            </div>
            <input type="hidden" id="iu" name="iu" value="<?php echo $usuario->idUsuario; ?>">
            <input type="hidden" id="ic" name="ic" value="<?php echo $curso->idCurso; ?>">
        </div>
    </div>

</div>
<?php
require_once('layout/foot.php');
?>