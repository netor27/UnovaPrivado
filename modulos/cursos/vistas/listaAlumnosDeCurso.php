<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headListaAlumnosDeCurso.php');
require_once('layout/headers/headCierre.php');
?>
<div class="row-fluid">
    <div class="span3 offset9">
        <a href="/usuarios/cursos/inscribirUsuario/<?php echo $curso->idCurso; ?>" class="btn btn-primary">
            <i class="icon-white icon-plus"></i>
            Inscribir usuario(s) a este curso
        </a>
    </div>
</div>
<div class="row-fluid"><h6></h6></div>
<div class="row-fluid">
    <div class="well ">
        <div class="row-fluid">
            <legend>
                <h4 class="blue">
                    Usuarios inscritos a este curso                    
                </h4>
            </legend>
        </div>
        <?php
        $columna = 1;
        $fila = 1;
        if (isset($alumnos)) {
            ?>
            <div class="row-fluid">
                <ul class="thumbnails">
                    <?php
                    $i = 1;
                    foreach ($alumnos as $alumno) {
                        if ($i % 4 === 1) {
                            echo '<div class="row-fluid">';
                        }
                        ?>
                        <div class="span3">
                            <div class="well well-small hoverBlueBorder whiteBackground">
                                <div class="row-fluid" style="position:relative;">
                                    <div class="span4">
                                        <a href="/usuario/<?php echo $alumno->uniqueUrl; ?>">
                                            <img class="hidden-phone img-polaroid" src="<?php echo $alumno->avatar; ?>"/>
                                            <img class="visible-phone imageSmallPhone img-polaroid" src="<?php echo $alumno->avatar; ?>"/>
                                        </a>
                                    </div>
                                    <div class="span7 offset1" style="height: 55px;overflow: hidden;">
                                        <div class="row-fluid">
                                            <div class="span12 break-words">
                                                <a href="/usuario/<?php echo $alumno->uniqueUrl; ?>">
                                                    <?php echo $alumno->nombreUsuario; ?>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row-fluid" style="position:absolute;bottom:0px;right: 0px;">
                                            <div class="span12">
                                                <div class="btn-group pull-right">
                                                    <a class="btn btn-small btn-danger dropdown-toggle" data-toggle="dropdown">
                                                        <i class="icon-trash icon-white"> </i> 
                                                        <span class="caret"> </span>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="borrarInscripcion" id="<?php echo $alumno->idUsuario; ?>">
                                                                <i class="icon-trash"></i>
                                                                Quitar de este curso
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($i % 4 === 0) {
                            echo '</div>';
                        }
                        $i++;
                    }
                    if ($i % 4 !== 1) {
                        echo '</div>';
                    }
                    ?>
                </ul>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <div class="pagination pagination-centered">
                        <ul>
                            <?php
                            if ($pagina > 1)
                                echo '<li><a href="/cursos/curso/alumnos/' . $idCurso . '&p=' . ($pagina - 1) . '">«</a></li>';
                            else
                                echo '<li class="disabled"><a href="#">«</a></li>';

                            for ($i = 1; $i <= $maxPagina; $i++) {
                                if ($i == $pagina)
                                    echo '<li class="active"><a href="#">' . $i . '</a></li>';
                                else
                                    echo '<li><a href="/cursos/curso/alumnos/' . $idCurso . '&p=' . $i . '">' . $i . '</a></li>';
                            }

                            if ($pagina < $maxPagina)
                                echo '<li><a href="/cursos/curso/alumnos/' . $idCurso . '&p=' . ($pagina + 1) . '">»</a></li>';
                            else
                                echo '<li class="disabled"><a href="#">»</a></li>';
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
        }else {
            ?>
            <div class="row-fluid">
                <h3>No hay usuarios asignados a este curso</h3>
            </div>
            <div class="row-fluid"><div class="span12"></div></div>
            <?php
        }
        ?>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>
            