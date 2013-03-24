<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headTomarClase.php');
require_once('layout/headers/headCierreTomarClase.php');
?>
<style type="text/css">
    body {
        min-height: 100%!important;
    }
</style>
<div class="container" style="padding-bottom: 175px;">
    <div class="row-fluid">
        <div class="span12 well well-large">
            <legend>
                <h1><?php echo $clase->titulo; ?></h1>
            </legend>
            <h4><?php echo $clase->descripcion; ?></h4>
            <p>Descarga el archivo del siguiente link</p>
            <p>
                <?php echo '<a style="text-decoration: underline;" href="' . $clase->archivo . '" target="_blank">' . $clase->titulo . '</a>'; ?>
            </p>
        </div>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>