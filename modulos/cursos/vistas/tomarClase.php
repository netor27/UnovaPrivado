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
        <div class="span12 well ">
            <legend>
                <h4 class="blue"><?php echo $clase->titulo; ?></h4>
            </legend>
            <?php
            if(isset($clase->descripcion)){
                echo "<p> $clase->descripcion </p>";
            }
            ?>          
            <div class="row-fluid"><h6></h6></div>
            <p>Descarga el archivo del siguiente link:</p>
            <p>
                <?php echo '<a style="text-decoration: underline;" href="' . $clase->archivo . '" target="_blank">' . $clase->titulo . '</a>'; ?>
            </p>
        </div>
    </div>
<?php
$noBreadCrumbs = false;
require_once('layout/foot.php');
?>