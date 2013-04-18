<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headListaGruposDelCurso.php');
require_once('layout/headers/headCierre.php');
?>
<div class="row-fluid">
    <div class="span3 offset9">
        <a href="/grupos/cursos/gruposDelCurso/<?php echo $idCurso; ?>" class="btn btn-primary span12">
            <i class="icon-white icon-plus"></i>
            Agregar grupo(s) a este curso
        </a>
    </div>
</div>
<div class="row-fluid"><h6></h6></div>
<div class="row-fluid">
    <div class="span12 well well-small">
        <legend>
            <h4 class="blue">Lista de grupos asignados a este curso</h4>
        </legend>
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
                        <div class="span4 well well-small ui-corner-all whiteBackground" >
                            <div class="row-fluid">
                                <div class="span12 break-words centerText">
                                    <legend>
                                        <h4><?php echo $grupo->nombre; ?></h4>
                                    </legend>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12 break-words">
                                    <p><?php echo $grupo->descripcion; ?></p>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12 btn-group">
                                    <a class="pull-right btn btn-small btn-danger dropdown-toggle" data-toggle="dropdown">
                                        <i class="icon-trash icon-white"></i>
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="pull-right dropdown-menu">
                                        <li>
                                            <a class="borrarGrupo" id="<?php echo $grupo->idGrupo; ?>" href="#">
                                                <i class="icon-trash"></i>
                                                Quitar grupo del curso
                                            </a>
                                        </li>
                                    </ul>                                    
                                </div>
                            </div>
                        </div>
                        <?php
                        if (($i % 3) == 2) {
                            echo '</div>';
                        }
                        $i++;
                    }
                    if (($i % 3) == 2 || ($i % 3) == 1) {
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
                                echo '<li><a href="/grupos/cursos/asignados/' . $idCurso . '&p=' . ($pagina - 1) . '">«</a></li>';
                            else
                                echo '<li class="disabled"><a href="#">«</a></li>';

                            for ($i = 1; $i <= $maxPagina; $i++) {
                                if ($i == $pagina)
                                    echo '<li class="active"><a href="#">' . $i . '</a></li>';
                                else
                                    echo '<li><a href="/grupos/cursos/asignados/' . $idCurso . '&p=' . $i . '">' . $i . '</a></li>';
                            }

                            if ($pagina < $maxPagina)
                                echo '<li><a href="/grupos/cursos/asignados/' . $idCurso . '&p=' . ($pagina + 1) . '">»</a></li>';
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
    </div>
</div>
<?php
require_once('layout/foot.php');
?>
            