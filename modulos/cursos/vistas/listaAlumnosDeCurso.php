<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headBootstrap.php');
require_once('layout/headers/headGridster.php');
require_once('layout/headers/headListaAlumnosDeCurso.php');
require_once('layout/headers/headCierre.php');
?>

<div class="contenido">
    <div class="row-fluid">
        <div class="span12">
            <?php
            if ($numAlumnos == 1)
                echo '<h4>Hay un alumno inscritos al curso:</h4>';
            else
                echo '<h4>Hay ' . $numAlumnos . ' alumnos inscritos al curso:</h4>';
            ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span7">
            <h5> <?php echo $curso->titulo; ?></h5>
        </div>        
        <div class="span4 offset1">
            <div>
                <a href="#" class="btn btn-primary">
                    <i class="icon-white icon-plus"></i>
                    Inscribir usuario(s) a este curso
                </a>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div id="alumnosContainer" class="span12">
            <div class="gridster ready">
                <ul style="height: 480px; position: relative; ">
                    <?php
                    $columna = 1;
                    $fila = 1;
                    foreach ($alumnos as $alumno) {
                        ?>
                        <li class="cuadro ui-corner-all" data-row="1" data-col="1" data-sizex="1" data-sizey="1" style="background: url('<?php echo $alumno->avatar; ?>')">
                            <div class="cuadroFooter ui-corner-bottom ease3">
                                <span class="cuadroFooterTitulo">
                                    <a href="/usuario/<?php echo $alumno->uniqueUrl;?>">
                                        <?php echo $alumno->nombreUsuario; ?>
                                    </a>
                                </span>
                                <br>
                                <span class="cuadroFooterLink">
                                    <a class="btn btn-mini btn-danger">
                                        <i class="icon-white icon-trash"></i>
                                        Quitar de este curso
                                    </a>
                                </span>
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="pagination pagination-centered">
            <ul>
                <?php
                if ($pagina > 1)
                    echo '<li><a href="/cursos/curso/alumnos/' . $idCurso . '/' . ($pagina - 1) . '">«</a></li>';
                else
                    echo '<li class="disabled"><a href="#">«</a></li>';

                for ($i = 1; $i <= $maxPagina; $i++) {
                    if ($i == $pagina)
                        echo '<li class="active"><a href="#">' . $i . '</a></li>';
                    else
                        echo '<li><a href="/cursos/curso/alumnos/' . $idCurso . '/' . $i . '">' . $i . '</a></li>';
                }

                if ($pagina < $maxPagina)
                    echo '<li><a href="/cursos/curso/alumnos/' . $idCurso . '/' . ($pagina + 1) . '">»</a></li>';
                else
                    echo '<li class="disabled"><a href="#">»</a></li>';
                ?>
            </ul>
        </div>
    </div>

</div>



<?php
require_once('lib/js/jqueryGridster/gridsterSinDraggable.php');
require_once('layout/foot.php');
?>
            