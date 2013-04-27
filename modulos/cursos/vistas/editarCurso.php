<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headEditarCurso.php');
require_once('layout/headers/headStarRating.php');
require_once('layout/headers/headCierre.php');
?>
<div class="row-fluid">
    <div class="span12 well well-small">
        <div class="row-fluid">
            <div class="span3">
                <div class="row-fluid">
                    <img class="hidden-phone span12 img-polaroid" src="<?php echo $cursoParaModificar->imagen; ?>"/>
                    <img class="visible-phone imageSmallPhone span12 img-polaroid" src="<?php echo $cursoParaModificar->imagen; ?>"/>
                </div>
                <div class="row-fluid">
                    <a class="span12 centerText" href="/cursos/curso/cambiarImagen/<?php echo $cursoParaModificar->idCurso; ?>">
                        <i class="icon-picture"></i> Cambiar imagen
                    </a>
                </div>            
            </div>
            <div class="span9">
                <div class="row-fluid">                    
                    <legend class="pull-left">
                        <h2 class="pull-left">
                            <?php echo $cursoParaModificar->titulo; ?>
                        </h2> 
                        <a class="pull-left" href="/cursos/curso/editarInformacionCurso/<?php echo $cursoParaModificar->idCurso; ?>" style=" padding-left: 8px;">
                            <i class="black icon-pencil editarPencil" style="font-size: 14px;">   </i>
                        </a>
                    </legend>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <strong>Descripción corta: </strong><?php echo $cursoParaModificar->descripcionCorta; ?>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
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
                </div>
                <div class="row-fluid">
                    <div class="span3">
                        <h5 class="black">Calificación del curso:</h5>
                    </div>
                    <div class="span2 cursoRating">
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
            </div>
        </div>
        <legend></legend>
        <div class="row-fluid">
            <div id="cursoTabs" class="">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tabs-1" data-toggle="tab" id="tabContenido">Contenido del curso</a></li>
                    <li><a href="#tabs-2" data-toggle="tab" id="tabDescripcion">Descripción</a></li>
                    <li><a href="#tabs-3" data-toggle="tab" id="tabForo">Foro</a></li>
                </ul>
                <div class="tab-content" style="overflow:visible;">
                    <div id="tabs-1" class="tab-pane active">
                        <?php
                        if ((isset($error) && $error != "") || (isset($info) && $info != "")) {
                            ?>
                            <div class="row-fluid">
                                <div class="span12">
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
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <?php
                        if (isset($temas)) {
                            ?>
                            <input type="hidden" name="numTemas" id="numTemas" value="<?php echo sizeof($temas); ?>" />
                            <?php
                            $banderaMensaje = false;
                            for ($i = 0; $i < sizeof($temas); $i++) {
                                ?>
                                <div class="temasContainer">
                                    <div class="row-fluid">
                                        <div class="temaContainer span12">
                                            <input type="hidden" name="idTema<?php echo $i; ?>" id="idTema<?php echo $i; ?>" value="<?php echo $temas[$i]->idTema; ?>" />
                                            <div class="row-fluid ui-state-highlight ui-corner-top temaHeader">       
                                                <div class="span7 temaNombre">
                                                    <?php
                                                    echo "Tema " . ($i + 1) . ": " . $temas[$i]->nombre;
                                                    ?>
                                                    <a class="temaNombreIcon" href="/temas/tema/editarTema/<?php echo $cursoParaModificar->idCurso . '/' . $temas[$i]->idTema; ?>">
                                                        <i class="icon-pencil editarPencil"></i>
                                                    </a>
                                                </div>
                                                <div class="span3 temaNombreLinks">                                            
                                                    <a href="/cursos/curso/agregarContenido/<?php echo $cursoParaModificar->idCurso . '/' . $temas[$i]->idTema; ?>">
                                                        <i class="icon-plus"></i>
                                                        Agregar clases a este tema
                                                    </a>
                                                </div>
                                                <div class="span2 temaNombreLinks">
                                                    <a class="deleteTema" id="<?php echo $temas[$i]->idTema; ?>" curso="<?php echo $cursoParaModificar->idCurso; ?>" >
                                                        <i class="icon-trash"></i>
                                                        Borrar
                                                    </a>
                                                </div>
                                                <div class="temaContainerMessage"></div>                                    
                                            </div>
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <ul id="sortable<?php echo $i; ?>" class="connectedSortable">
                                                        <?php
                                                        for ($j = 0; $j < sizeof($clases); $j++) {
                                                            if ($clases[$j]->idTema == $temas[$i]->idTema) {
                                                                if (!$banderaMensaje) {
                                                                    $banderaMensaje = true;
                                                                    echo '<li id="clase_' . $clases[$j]->idClase . '"  class="ui-state-default ui-corner-all mensajeArrastrarContainer">';
                                                                } else {
                                                                    ?>
                                                                    <li id="clase_<?php echo $clases[$j]->idClase; ?>"  class="ui-state-default ui-corner-all">
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <div class="row-fluid">
                                                                        <div class="span10">
                                                                            <div class="span1 centerText">
                                                                                <a href="/curso/<?php echo $cursoParaModificar->uniqueUrl . "/" . $clases[$j]->idClase; ?>">
                                                                                    <img class="iconClase" src="<?php echo getImagenTipoClase($clases[$j]->idTipoClase); ?>">
                                                                                </a>
                                                                            </div>
                                                                            <div class="span11 nombreClaseContainer">
                                                                                <a class="nombreClase" href="/curso/<?php echo $cursoParaModificar->uniqueUrl . "/" . $clases[$j]->idClase; ?>">
                                                                                    <?php
                                                                                    echo $clases[$j]->titulo;
                                                                                    ?>  
                                                                                </a>
                                                                                <a href="/cursos/clase/editarClase/<?php echo $cursoParaModificar->idCurso . "/" . $clases[$j]->idClase; ?>" alt="Cambiar nombre">
                                                                                    <i class="icon-pencil editarPencil"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="span1 claseLinksContainer hidden-phone hidden-tablet">
                                                                            <?php
                                                                            if ($clases[$j]->idTipoClase == 0 || $clases[$j]->idTipoClase == 4) {
                                                                                ?>
                                                                                <a class="claseLinks hidden-phone" href="/cursos/clase/editor/<?php echo $cursoParaModificar->idCurso . "/" . $clases[$j]->idClase; ?>">Editar</a>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                        <div class="span1 claseLinksContainer">
                                                                            <?php
                                                                            echo '<a class="claseLinks deleteClase" id="' . $clases[$j]->idClase . '" curso="' . $cursoParaModificar->idCurso . '" >Borrar</a>';
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <div class="row-fluid ui-state-highlight ui-corner-top temaHeader agregarTemaBoton">                                   
                            <a href="/temas/tema/agregarTema/<?php echo $cursoParaModificar->idCurso; ?>">
                                <div class="span12">
                                    <div class="span3 offset5 temaNombre">                        
                                        <i class="icon icon-plus"></i>
                                        Agregar un tema                        
                                    </div>                 
                                </div>
                            </a>
                        </div>
                    </div>
                    <div id="tabs-2" class="tab-pane">
                        <div class="row-fluid">
                            <div class="span12">
                                <a href="/cursos/curso/editarInformacionCurso/<?php echo $cursoParaModificar->idCurso; ?>" class="btn pull-right"><i class="icon-pencil editarPencil"></i> Editar esta información</a>
                            </div>                    
                        </div>
                        <div class="row-fluid">
                            <div id="descripcionContent" class="mostrarListas">
                                <?php
                                echo $cursoParaModificar->descripcion;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div id="tabs-3" class="tab-pane">
                        <?php
                        $cursoAux = $cursoParaModificar;
                        require_once 'modulos/cursos/vistas/vistaForo.php';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once('layout/foot.php');
?>