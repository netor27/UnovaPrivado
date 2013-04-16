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
            <div class="span9">
                <?php
                if ($numAlumnos == 1)
                    echo '<h4>Hay un alumno inscritos al curso: "' . $curso->titulo . '"</h4>';
                else
                    echo '<h4>Hay ' . $numAlumnos . ' alumnos inscritos al curso: "' . $curso->titulo . '"</h4>';
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12"></div>
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
                        if ($i % 6 === 1) {
                            echo '<div class="row-fluid">';
                        }
                        ?>
                        <div class="span2">
                            <div class="thumbnail hoverBlueBorder">
                                <div class="caption centerText break-words">
                                    <a href="/usuario/<?php echo $alumno->uniqueUrl; ?>">
                                        <div class="row-fluid">
                                            <?php echo $alumno->nombreUsuario; ?>
                                        </div>
                                        <div class="row-fluid">
                                            <img src="<?php echo $alumno->avatar; ?>">
                                        </div>
                                    </a>
                                </div>
                                <div class="caption centerText">
                                    <a class=" btn btn-mini btn-danger borrarInscripcion" id="<?php echo $alumno->idUsuario; ?>">
                                        <i class="icon-white icon-trash"></i>
                                        Quitar de este curso
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($i % 6 === 0) {
                            echo '</div>';
                            echo '<div class="row-fluid"><div class=span12></div></div>';
                        }
                        $i++;
                    }
                    if ($i % 6 !== 1) {
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
                                echo '<li><a href="/cursos/curso/alumnos/' . $idCurso . '&p=' . ($pagina - 1) . '&pc=' . $paginaCursos . '">«</a></li>';
                            else
                                echo '<li class="disabled"><a href="#">«</a></li>';

                            for ($i = 1; $i <= $maxPagina; $i++) {
                                if ($i == $pagina)
                                    echo '<li class="active"><a href="#">' . $i . '</a></li>';
                                else
                                    echo '<li><a href="/cursos/curso/alumnos/' . $idCurso . '&p=' . $i . '&pc=' . $paginaCursos . '">' . $i . '</a></li>';
                            }

                            if ($pagina < $maxPagina)
                                echo '<li><a href="/cursos/curso/alumnos/' . $idCurso . '&p=' . ($pagina + 1) . '&pc=' . $paginaCursos . '">»</a></li>';
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
            