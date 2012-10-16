<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headBootstrap.php');
require_once('layout/headers/headCierre.php');
?>

<div class="container-fluid">
    <div class="span12">
        <h1></h1>
    </div>

    <div class="row-fluid">

        <div class="span3 well well-large">
            <div class="row-fluid">
                <div class="span12">
                    <legend>
                        Administrador
                    </legend>
                </div>
            </div>
            <!--Sidebar content-->
            <div class="row-fluid">
                <div class="span12">
                    <a class="btn btn-large span12" href="/cursos">Cursos</a>
                </div>
            </div>
            <div class="row-fluid"><div class="span12"></div></div>
            <div class="row-fluid">
                <div class="span12">
                    <a class="btn btn-large btn-primary span12" href="/alumnos">Alumnos</a>
                </div>
            </div>
            <div class="row-fluid"><div class="span12"></div></div>
            <div class="row-fluid">
                <div class="span12">
                    <a class="btn btn-large btn-primary span12" href="/profesores">Profesores</a>
                </div>
            </div>
            <div class="row-fluid"><div class="span12"></div></div>
            <div class="row-fluid">
                <div class="span12">
                    <a class="btn btn-large btn-primary span12" href="/grupos">Grupos</a>
                </div>
            </div>
            <div class="row-fluid"><div class="span12"></div></div>
            <div class="row-fluid">
                <div class="span12">
                    <a class="btn btn-large btn-warning span12" href="/administradores">Administradores</a>
                </div>
            </div>
        </div>
        <div class="span9 well well-large">
            <!--Body content-->
            <div class="row-fluid">
                <div class="span12">
                    <legend>Estado del servicio</legend>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <div class="span6">
                        <h3>Usuarios</h3>
                    </div>
                    <div class="span4 offset1">
                        <h3><?php echo $numUsuarios . " / " . $maxUsuarios; ?></h3>
                    </div>
                    <div class="span12">
                        <?php
                        if ($usuariosPorcentaje < 50) {
                            echo '<span class="badge badge-success" style="padding: 3px; float: left; width: 25px; text-align: center;">
                             ' . $usuariosPorcentaje . '%</span>';
                            echo '<div class="progress progress-striped progress-success" style="margin-left:38px;">';
                        } else if ($usuariosPorcentaje < 75) {
                            echo '<span class="badge badge-warning" style="padding: 3px; float: left; width: 25px; text-align: center;">
                             ' . $usuariosPorcentaje . '%</span>';
                            echo '<div class="progress progress-striped progress-warning" style="margin-left:38px;">';
                        } else {
                            echo '<span class="badge badge-important" style="padding: 3px; float: left; width: 25px; text-align: center;">
                             ' . $usuariosPorcentaje . '%</span>';
                            echo '<div class="progress progress-striped progress-danger" style="margin-left:38px;">';
                        }
                        echo '<div class="bar" style="width:' . $usuariosPorcentaje . '%;"></div>';
                        echo '</div>';
                        ?>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <div class="span6">
                        <h3>Espacio en disco</h3>
                    </div>
                    <div class="span4 offset1">
                        <h3><?php echo $discoUsado . " / " . $maxDisco; ?>GB</h3>
                    </div>
                    <div class="span12">
                        <?php
                        if ($discoPorcentaje < 50) {
                            echo '<span class="badge badge-success" style="padding: 3px; float: left; width: 25px; text-align: center;">
                             ' . $discoPorcentaje . '%</span>';
                            echo '<div class="progress progress-striped progress-success" style="margin-left:38px;">';
                        } else if ($discoPorcentaje < 75) {
                            echo '<span class="badge badge-warning" style="padding: 3px; float: left; width: 25px; text-align: center;">
                             ' . $discoPorcentaje . '%</span>';
                            echo '<div class="progress progress-striped progress-warning" style="margin-left:38px;">';
                        } else {
                            echo '<span class="badge badge-important" style="padding: 3px; float: left; width: 25px; text-align: center;">
                             ' . $discoPorcentaje . '%</span>';
                            echo '<div class="progress progress-striped progress-danger" style="margin-left:38px;">';
                        }
                        echo '<div class="bar" style="width:' . $discoPorcentaje . '%;"></div>';
                        echo '</div>';
                        ?>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <div class="span6">
                        <h3>Ancho de banda</h3>
                    </div>
                    <div class="span4 offset1">
                        <h3><?php echo $anchoUsado . " / " . $maxAncho; ?>GB</h3>
                    </div>
                    <div class="span12">
                        <?php
                        if ($anchoPorcentaje < 50) {
                            echo '<span class="badge badge-success" style="padding: 3px; float: left; width: 25px; text-align: center;">
                             ' . $anchoPorcentaje . '%</span>';
                            echo '<div class="progress progress-striped progress-success" style="margin-left:38px;">';
                        } else if ($anchoPorcentaje < 75) {
                            echo '<span class="badge badge-warning" style="padding: 3px; float: left; width: 25px; text-align: center;">
                             ' . $anchoPorcentaje . '%</span>';
                            echo '<div class="progress progress-striped progress-warning" style="margin-left:38px;">';
                        } else {
                            echo '<span class="badge badge-important" style="padding: 3px; float: left; width: 25px; text-align: center;">
                             ' . $anchoPorcentaje . '%</span>';
                            echo '<div class="progress progress-striped progress-danger" style="margin-left:38px;">';
                        }
                        echo '<div class="bar" style="width:' . $anchoPorcentaje . '%;"></div>';
                        echo '</div>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>







</div>
</div>
<?php
require_once('layout/foot.php');
?>
            