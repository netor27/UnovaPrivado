<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headTomarCurso.php');
require_once('layout/headers/headStarRating.php');
require_once('layout/headers/headCierre.php');
?>

<div class="row-fluid">
    <div class="span12 well well-large">
        <div class="span3">
            <img class="span12 img-polaroid" src="<?php echo $curso->imagen; ?>">
        </div>
        <div class="span9">                    
            <legend>
                <h4>
                    <?php echo $curso->titulo; ?>                        
                </h4>
            </legend>
            <div class="row-fluid">
                <div class="span4">
                    <strong>Autor de este curso:</strong><br>
                    <a href="/usuario/<?php echo $usuarioDelCurso->uniqueUrl . '&b=' . getRequestUri(); ?>"><?php echo $usuarioDelCurso->nombreUsuario; ?></a>
                </div>
                <div class="span4">
                    <strong>Calificación total del curso:</strong>
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
                    </div><br>
                </div>
                <div class="span4">
                    <?php
                    if ($esAlumno) {
                        ?>
                        <strong>Tú calificación de este curso:</strong>
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
            </div>
            <div class="row-fluid">
                <div class="span12"></div>
            </div>
            <div class="row-fluid">
                <div class="span8">
                    <p>
                        <strong>Descripción:</strong><br>
                        <?php echo $curso->descripcionCorta; ?>
                    </p>
                </div>
                <div class="span4">
                    <?php
                    if ($numAlumnos == 0) {
                        echo '<strong>Este curso no tiene alumnos</strong>';
                    } else if ($numAlumnos == 1) {
                        echo '<strong>Un alumno inscrito a este curso</strong> ';
                    } else {
                        echo '<strong>Este curso tiene ' . $numAlumnos . ' alumnos inscritos</strong> ';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>            
</div>
<div class="row-fluid">            
    <div id="cursoTabs" class="well well-small">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tabs-1" data-toggle="tab" >Contenido del curso</a></li>
            <li ><a href="#tabs-2" data-toggle="tab" >Foro</a></li>
        </ul>
        <div class="tab-content" style="overflow-x: visible">
            <div id="tabs-1" class="tab-pane active"> 
                <div class="span12" style="width:99%;">
                    <?php
                    $i = 1;
                    $j = 1;
                    if (isset($temas) && isset($clases)) {
                        foreach ($temas as $tema) {
                            ?>
                            <div class="temasContainer">
                                <div class="row-fluid">
                                    <div class="temaContainer span12">
                                        <div class="row-fluid ui-state-highlight ui-corner-top temaHeader">
                                            <div class="span7 temaNombre">
                                                <?php
                                                echo "Tema " . ($i + 1) . ": " . $tema->nombre;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="row-fluid">
                                            <div class="span12">
                                                <ul id="sortable<?php echo $i; ?>" class="connectedSortable">
                                                    <?php
                                                    for ($j = 0; $j < sizeof($clases); $j++) {
                                                        if ($clases[$j]->idTema == $tema->idTema) {
                                                            ?>
                                                            <li id="clase_<?php echo $clases[$j]->idClase; ?>"  class="ui-state-default ui-corner-all">
                                                                <a href="/curso/<?php echo $curso->uniqueUrl . "/" . $clases[$j]->idClase; ?>">
                                                                    <div class="row-fluid">
                                                                        <div class="span12">
                                                                            <div class="span1">
                                                                                <img class="iconClase" src="<?php echo getImagenTipoClase($clases[$j]->idTipoClase); ?>">
                                                                            </div>
                                                                            <div class="span11 nombreClaseContainer">
                                                                                <?php
                                                                                echo $clases[$j]->titulo;
                                                                                ?>  
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </a>
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
                            $i++;
                        }
                    } else {
                        ?>
                        <h2 style="text-align: center;">Este curso no tiene clases</h2>
                        <?php
                    }
                    ?>
                </div>

            </div>
            <div id="tabs-2" class="tab-pane">
                <h1>Aquí va el foro</h1>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="iu" name="iu" value="<?php echo $usuario->idUsuario; ?>">
<input type="hidden" id="ic" name="ic" value="<?php echo $curso->idCurso; ?>">
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
<?php
require_once('layout/foot.php');
?>