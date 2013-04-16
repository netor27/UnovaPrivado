<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headListaGruposDelCurso.php');
require_once('layout/headers/headCierre.php');
?>
<div class="row-fluid">
    <div class="span6">
        <?php
        if ($numGrupos == 1) {
            echo '<h4>Hay un grupo asignado a este curso:</h4>';
        } else {
            echo '<h4>Hay ' . $numGrupos . ' grupos asignados a este curso:</h4>';
        }
        ?>
        <h5><?php echo $curso->titulo; ?></h5>
    </div>

    <div class="span4 offset2">
        <div style="padding-top: 20px;">
            <a href="/grupos/cursos/gruposDelCurso/<?php echo $idCurso; ?>" class="btn btn-primary">
                <i class="icon-white icon-plus"></i>
                Agregar grupo(s) a este curso
            </a>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span12"></div>
</div>
<?php
$columna = 1;
$fila = 1;
if (isset($grupos)) {
    ?>
    <div class="row-fluid">
        <div class="span12">
            <?php
            $i = 0;
            foreach ($grupos as $grupo) {
                if (($i % 3) == 0) {
                    echo '<div class="row-fluid">';
                }
                ?>
                <div class="thumbnail span4 well well-small ui-corner-all" >
                    <div class="row-fluid">
                        <div class="span12">
                            <h4><?php echo $grupo->nombre; ?></h4>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <p><?php echo $grupo->descripcion; ?></p>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <a class="btn btn-mini btn-danger borrarGrupo" id="<?php echo $grupo->idGrupo; ?>">
                                <i class="icon-white icon-trash"></i>
                                Quitar grupo del curso
                            </a>
                        </div>
                    </div>
                </div>
                <?php
                if (($i % 3) == 2) {
                    echo '</div>';
                }
                $i++;
            }
            if (($i % 3) == 2 || ($i % 3) == 1 ) {
                echo '</div>';
            }
            ?>                        
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <div class="pagination pagination-centered">
                <ul>
                    <?php
                    if ($pagina > 1)
                        echo '<li><a href="/grupos/cursos/asignados/' . $idCurso . '&p=' . ($pagina - 1) . '&pc=' . $paginaCursos . '">«</a></li>';
                    else
                        echo '<li class="disabled"><a href="#">«</a></li>';

                    for ($i = 1; $i <= $maxPagina; $i++) {
                        if ($i == $pagina)
                            echo '<li class="active"><a href="#">' . $i . '</a></li>';
                        else
                            echo '<li><a href="/grupos/cursos/asignados/' . $idCurso . '&p=' . $i . '&pc=' . $paginaCursos . '">' . $i . '</a></li>';
                    }

                    if ($pagina < $maxPagina)
                        echo '<li><a href="/grupos/cursos/asignados/' . $idCurso . '&p=' . ($pagina + 1) . '&pc=' . $paginaCursos . '">»</a></li>';
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
        <h3>No hay grupos asignados a este curso</h3>
    </div>
    <div class="row-fluid">
        <div class="span12"></div>
    </div>
    <?php
}
?>
<?php
require_once('layout/foot.php');
?>
            