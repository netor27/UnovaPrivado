<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headBootstrap.php');
require_once('layout/headers/headGridster.php');
require_once('layout/headers/headCierre.php');
?>

<div class="contenido">
    <?php
    if ($numAlumnos == 1)
        echo '<h4>Hay un alumno inscritos al curso:</h4>';
    else
        echo '<h4>Hay ' . $numAlumnos . ' alumnos inscritos al curso:</h4>';
    ?>

    <h5> <?php echo $curso->titulo; ?></h5>
    <div id="alumnosContainer">
        <div class="gridster ready">
            <ul style="height: 480px; position: relative; ">
                <?php
                $columna = 1;
                $fila = 1;
                foreach ($alumnos as $alumno) {
                    ?>
                    <li class="cuadro" data-row="1" data-col="1" data-sizex="1" data-sizey="1" style="background: url('<?php echo $alumno->avatar; ?>')">
                        
                    </li>
                        <?php
                    }
                    ?>
            </ul>
        </div>
    </div>
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



<?php
require_once('lib/js/jqueryGridster/gridsterSinDraggable.php');
require_once('layout/foot.php');
?>
            