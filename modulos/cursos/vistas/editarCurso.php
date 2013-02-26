<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headEditarCurso.php');
require_once('layout/headers/headStarRating.php');
require_once('layout/headers/headCierre.php');
?>

<div class="contenido">    
    <div id="cursoHeader">
        <div id="cursoHeader_left">  
            <div class="row-fluid">
                <div class="span3">
                    <div id="cursoHeader_img" class="left">
                        <img src="<?php echo $cursoParaModificar->imagen; ?>" class="img-polaroid"/>
                        <br>
                        <a style="margin-left: 60px;" href="/cursos/curso/cambiarImagen/<?php echo $cursoParaModificar->idCurso; ?>">Cambiar imagen</a>
                    </div>            
                </div>
                <div class="span5">
                    <div id="cursoHeader_info" class="left">
                        <div class="row-fluid">
                            <div id="cursoHeader_info_titulo">
                                <h2 itemprop="name"><?php echo $cursoParaModificar->titulo; ?></h2>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6">
                                <?php
                                if ($numAlumnos == 0) {
                                    echo '<h5 class="black">No hay ningún usuario inscrito</h5>';
                                } else if ($numAlumnos == 1) {
                                    echo '<h5 class="black"><span style="font-weight:bold;">1</span> alumno inscrito</h5>';
                                } else {
                                    echo '<h5 class="black">' . $numAlumnos . ' alumnos inscritos</h5>';
                                }
                                ?>
                            </div>
                            <div class="span6">
                                <h5 class="black">Calificación del curso:</h5>
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($cursoParaModificar->rating == $i)
                                        echo '<input title="' . $i . '" name="adv2" type="radio" disabled="disabled" class="wow" checked="checked"/>';
                                    else
                                        echo '<input title="' . $i . '" name="adv2" type="radio" disabled="disabled" class="wow"/>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row-fluid"><div class="span12"></div></div>
                        <div class="row-fluid">
                            <div class="span12">
                                <strong>Descripción: </strong><?php echo $cursoParaModificar->descripcionCorta; ?>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="span4">
                    <div id="cursoHeader_right" class="right">
                        <a href="/cursos/curso/editarInformacionCurso/<?php echo $cursoParaModificar->idCurso; ?>" >
                            <div class="btn btn-info"><i class="icon-pencil icon-white"></i> Editar información del curso</div>
                        </a>
                    </div>
                </div>
            </div>


        </div>


    </div>
    <div id="cursoTabs">
        <ul>
            <li><a href="#tabs-1">Clases</a></li>
            <li><a href="#tabs-2">Descripción</a></li>
            <li><a href="#tabs-3">Comentarios</a></li>
            <li><a href="#tabs-4">Preguntas</a></li>
        </ul>

        <div id="tabs-1">
            <div class="mensajes">
                <?php
                if (isset($error) && $error != "") {
                    echo '<h5 class="error centerText">' . $error . '</h5>';
                }
                if (isset($info) && $info != "") {
                    echo '<h5 class="info centerText">' . $info . '</h5>';
                }
                ?>
            </div>
            <?php
            if (isset($temas)) {
                ?>
                <div class="row-fluid">
                    <div class="span5">
                        <h4>
                            <strong>
                                Arrastra y suelta las clases para ordenarlas
                            </strong>
                        </h4>
                    </div>
                    <div class="span4">
                        <a href="/cursos/curso/agregarContenido/<?php echo $cursoParaModificar->idCurso; ?>" class="btn btn-large btn-primary" id="agregarContenido"> Agregar contenido</a>
                    </div>
                    <div class="span3">
                        <a href="/temas/tema/agregarTema/<?php echo $cursoParaModificar->idCurso; ?>" class="btn">Agregar un tema</a>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span3"></div>
                </div>
                <input type="hidden" name="numTemas" id="numTemas" value="<?php echo sizeof($temas); ?>" />
                <?php
                for ($i = 0; $i < sizeof($temas); $i++) {
                    ?>
                    <div class="temaContainer" >
                        <input type="hidden" name="idTema<?php echo $i; ?>" id="idTema<?php echo $i; ?>" value="<?php echo $temas[$i]->idTema; ?>" />
                        <div class="temaHeader  ui-state-highlight">
                            <div class="temaNombre left">
                                <?php
                                if (strlen($temas[$i]->nombre) > 47)
                                    echo substr($temas[$i]->nombre, 0, 47) . "...";
                                else
                                    echo $temas[$i]->nombre;
                                ?>
                                <a href="/temas/tema/editarTema/<?php echo $cursoParaModificar->idCurso . '/' . $temas[$i]->idTema; ?>">
                                    <i class="icon-pencil"></i>
                                </a>
                            </div>                                                
                            <div class="temaNombreLinks right">    
                                <a href="/cursos/curso/agregarContenido/<?php echo $cursoParaModificar->idCurso . '/' . $temas[$i]->idTema; ?>">
                                    <i class="icon-plus"></i>
                                    Agregar clases a este tema
                                </a>
                                <a class="deleteTema" id="<?php echo $temas[$i]->idTema; ?>" curso="<?php echo $cursoParaModificar->idCurso; ?>" >
                                    <i class="icon-fire"></i>
                                    Borrar
                                </a>
                            </div>
                        </div>
                        <div class="temaContainerMessage"></div>
                        <br>  
                        <ul id="sortable<?php echo $i; ?>" class="connectedSortable">
                            <?php
                            for ($j = 0; $j < sizeof($clases); $j++) {
                                if ($clases[$j]->idTema == $temas[$i]->idTema) {
                                    ?>
                                    <li id="clase_<?php echo $clases[$j]->idClase; ?>"  class="ui-state-default claseContainer">
                                        <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                        <div class="claseSortableContainer">
                                            <div class="left">                                            
                                                <img class="left" src="<?php echo getImagenTipoClase($clases[$j]->idTipoClase);?>">
                                                <a href="/curso/<?php echo $cursoParaModificar->uniqueUrl . "/" . $clases[$j]->idClase; ?>">
                                                    <div class="left claseNombre">
                                                        <?php
                                                        if (strlen($clases[$j]->titulo) > 65)
                                                            echo substr($clases[$j]->titulo, 0, 65) . "...";
                                                        else
                                                            echo $clases[$j]->titulo;
                                                        ?>  
                                                        <a href="/cursos/clase/editarClase/<?php echo $cursoParaModificar->idCurso . "/" . $clases[$j]->idClase; ?>" alt="Cambiar nombre">
                                                            <i class="icon-pencil"></i>
                                                        </a>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="claseLinks right showOnHover">                                                   
                                                <?php
                                                if ($clases[$j]->idTipoClase == 0 || $clases[$j]->idTipoClase == 4) {
                                                    ?>
                                                    <a href="/cursos/clase/editor/<?php echo $cursoParaModificar->idCurso . "/" . $clases[$j]->idClase; ?>">Editar</a>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                echo '<a class="deleteClase" id="' . $clases[$j]->idClase . '" curso="' . $cursoParaModificar->idCurso . '" >Borrar</a>';
                                                ?>

                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>

                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="centerText" >
                    <a href="/cursos/curso/agregarContenido/<?php echo $cursoParaModificar->idCurso; ?>" class="btn btn-large btn-primary" id="agregarContenido">Agregar contenido</a>
                </div>
                <?php
            }
            ?>

        </div>
        <div id="tabs-2">
            <div class="right">
                <a href="/cursos/curso/editarInformacionCurso/<?php echo $cursoParaModificar->idCurso; ?>" class="btn"><i class="icon-pencil"></i> Editar esta información</a>
            </div>
            <br>
            <div id="descripcion" style="margin-top:30px;">
                <h2 style="padding-left: 20px;">Descripción corta</h2>   
                <div id="descripcionContent">
                    <p itemprop="description">
                        <?php
                        echo $cursoParaModificar->descripcionCorta;
                        ?>
                    </p>
                </div>
            </div>
            <div id="descripcion">                
                <h2 style="padding-left: 20px;">Descripción</h2>
                <div id="descripcionContent">
                    <?php
                    echo $cursoParaModificar->descripcion;
                    ?>
                </div>
            </div>

        </div>
        <div id="tabs-3">

            <?php
            if (isset($comentarios)) {
                echo '<ul id="pageMeComments" class="pageMe">';
                foreach ($comentarios as $comentario) {
                    echo '<li>';
                    if ($comentario->idUsuario == $cursoParaModificar->idUsuario)
                        echo '<div class="comentarioContainer blueBox" style="width:97%;">';
                    else
                        echo '<div class="comentarioContainer whiteBox" style="width:97%;">';
                    echo '<div class="comentarioAvatar"><img src="' . $comentario->avatar . '"></div>';
                    echo '<div class="comentarioUsuario"><a href="/usuario/' . $comentario->uniqueUrlUsuario . '&b=' . getRequestUri() . '">' . $comentario->nombreUsuario . '</a></div>';
                    echo '<div class="comentarioFecha">' . transformaDateDDMMAAAA(strtotime($comentario->fecha)) . '</div>';
                    echo '<br><div class="comentario">' . $comentario->texto . '</div>';
                    echo '</div>';
                    echo '</li>';
                }
                echo '</ul>';
            }else {
                ?>
                <div class="whiteBox"><h2 style="padding-left:20px;">No hay comentarios</h2></div>
                <?php
            }
            ?>
        </div>
        <div id="tabs-4">
            <?php
            if (isset($preguntas)) {
                echo '<ul id="pageMePreguntas" class="pageMe">';
                foreach ($preguntas as $pregunta) {
                    echo '<li>';
                    echo '<div class="preguntaContainer whiteBox" style="width:97%;">';
                    echo '<div class="comentarioAvatar"><img src="' . $pregunta->avatar . '"></div>';
                    echo '<div class="comentarioUsuario"><a href="/usuario/' . $pregunta->uniqueUrlUsuario . '&b=' . getRequestUri() . '">' . $pregunta->nombreUsuario . '</a></div>';
                    echo '<br><div class="comentario">' . $pregunta->pregunta . '</div>';
                    if (isset($pregunta->respuesta)) {
                        echo '<br><div class="respuesta blueBox" style="width: 80%;">';
                        echo '<div class="comentarioAvatar"><img src="' . $usuarioDelCurso->avatar . '"></div>';
                        echo '<div class="comentarioUsuario"><a href="/usuario/' . $usuarioDelCurso->uniqueUrl . '&b=' . getRequestUri() . '">' . $usuarioDelCurso->nombreUsuario . '</a></div>';
                        echo '<br><div class="comentario">' . $pregunta->respuesta . '</div>';
                        echo '</div>';
                    } else {
                        echo '<div class="respuesta">';
                        echo '<form id="preguntaForm" method="POST" action="/cursos/curso/responderPreguntaCurso/' . $cursoParaModificar->idCurso . '/' . $pregunta->idPregunta . '"  class="preguntarForm">';
                        echo '<textarea id="pregunta" name="respuesta"  ></textArea>';
                        echo '<br><input type="submit" value="  Responder  ">';
                        echo '</form>';
                        echo '</div>';
                    }
                    echo '</div>';
                    echo '</li>';
                }
                echo '</ul>';
            } else {
                ?>
                <div class="whiteBox"><h2 style="padding-left:20px;">No hay preguntas</h2></div>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">
            <?php
            if (isset($backUrl)) {
                ?>
                <a href="<?php echo $backUrl; ?>" class="btn btn-inverse btn-small">
                    <i class="icon-white icon-arrow-left"></i>
                    Regresar
                </a>
                <?php
            } else {
                ?>
                <a href="/" class="btn btn-inverse btn-small">
                    <i class="icon-white icon-arrow-left"></i>
                    Regresar al inicio
                </a>
                <?php
            }
            ?>

        </div>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>