<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headListaGrupos.php');
require_once('layout/headers/headCierre.php');
?>
<div class="row-fluid">
    <div class="span6">
        <?php
        if ($numGrupos == 1) {
            echo '<h1>Hay un grupo en total</h1>';
        } else {
            echo '<h1>Hay ' . $numGrupos . ' grupos en total</h1>';
        }
        ?>
    </div>
    <div class="span3 offset3">
        <div style="padding-top: 20px;">
            <a href="/grupos/grupo/agregar" class="btn btn-primary">
                <i class="icon-white icon-plus"></i>
                Agregar un grupo
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
                        <div class="btn-group span12">
                            <a class="pull-right btn btn-small btn-primary dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-pencil icon-white"></i> Editar 
                                <span class="caret"></span>
                            </a>                                            
                            <ul class="pull-right dropdown-menu">
                                <li><a href="/grupos/usuarios/inscritos/<?php echo $grupo->idGrupo; ?>"><i class="icon-user"></i> Editar usuarios del grupo</a></li>
                                <li><a href="/grupos/grupo/modificar/<?php echo $grupo->idGrupo; ?>"><i class="icon-pencil"></i> Editar información del grupo</a></li>
                                <li class="divider"></li>
                                <li><a class="borrarGrupo" href="" id="<?php echo $grupo->idGrupo; ?>"><i class="icon-fire"></i> Eliminar grupo</a></li>
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
            ?>                        
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <div class="pagination pagination-centered">
                <ul>
                    <?php
                    if ($pagina > 1)
                        echo '<li><a href="/grupos&p=' . ($pagina - 1) . '">«</a></li>';
                    else
                        echo '<li class="disabled"><a href="#">«</a></li>';

                    for ($i = 1; $i <= $maxPagina; $i++) {
                        if ($i == $pagina)
                            echo '<li class="active"><a href="#">' . $i . '</a></li>';
                        else
                            echo '<li><a href="/grupos&p=' . $i . '">' . $i . '</a></li>';
                    }

                    if ($pagina < $maxPagina)
                        echo '<li><a href="/grupos&p=' . ($pagina + 1) . '">»</a></li>';
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
        <h3>No hay grupos dados de alta</h3>
    </div>
    <div class="row-fluid"><div class="span12"></div></div>
    <?php
}
?>
<div class="row-fluid">
    <div class="span3 subir20px">
        <a class="btn btn-inverse btn-small" href="/">
            <i class="icon-white icon-arrow-left"></i>
            Regresar al inicio
        </a>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>
            