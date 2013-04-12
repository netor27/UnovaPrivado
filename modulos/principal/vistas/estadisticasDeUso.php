<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headCierre.php');
?>

<div class="row-fluid">
    <div class="span12 well">
        <div class="row-fluid">
            <div class="span12">
                <legend>
                    <h2>
                        Estadísticas de uso
                    </h2>
                </legend>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span10 offset1">
                <div class="row-fluid">
                    <div class="span4">
                        <h4 class="black">Usuarios registrados</h4>
                    </div>
                    <div class="span8">
                        <h4 class="black" style="margin-top:10px;"><?php echo $numUsuarios . " / " . $maxUsuarios; ?></h4>
                    </div>
                </div>
                <div class="row-fluid">
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
        </div>
        <div class="row-fluid">
            <div class="span10 offset1">
                <div class="row-fluid">
                    <div class="span4">
                        <h4 class="black">Espacio en disco utilizado</h4>
                    </div>
                    <div class="span8">
                        <h4 class="black" style="margin-top:10px;"><?php echo bytesToString($discoUsadoEnBytes, 1) . " / " . $maxDisco; ?>GB</h4>
                    </div>
                </div>
                <div class="row-fluid">
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
        </div>
        <div class="row-fluid">
            <div class="span10 offset1">
                <div class="row-fluid">
                    <div class="span4">
                        <h4 class="black">Ancho de banda utilizado</h4>
                    </div>
                    <div class="span8">
                        <h4 class="black" style="margin-top:10px;"><?php echo bytesToString($anchoUsadoEnBytes, 1) . " / " . $maxAncho; ?>GB</h4>
                    </div>
                </div>
                <div class="row-fluid">
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

<?php
require_once('layout/foot.php');
?>
            