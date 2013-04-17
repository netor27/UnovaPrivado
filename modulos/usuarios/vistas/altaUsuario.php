<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headAltaUsuario.php');
require_once('layout/headers/headUploadInputStyler.php');
require_once('layout/headers/headCierre.php');
?>
<div class="row-fluid">
    <div class="well span12">
        <form class="form-horizontal" action="/alumnos/usuario/altaUsuariosSubmit" method="post">
            <input type="hidden" name="tipo" value="<?php echo $tipo; ?>">
            <?php
            switch ($tipo) {
                case "altaAlumno":
                    $urlRegreso = "/alumnos";
                    echo '<legend><h4 class="blue">Agregar alumnos</h4></legend>';
                    break;
                case "altaProfesor":
                    $urlRegreso = "/profesores";
                    echo '<legend><h4 class="blue">Agregar profesores</h4></legend>';
                    break;
                case "altaAdministrador":
                    $urlRegreso = "/administradores";
                    echo '<legend><h4 class="blue">Agregar administradores</h4></legend>';
                    break;
            }
            ?>
            <div class="control-group">
                <label class="control-label">Emails</label>
                <div class="controls">
                    <?php
                    switch ($tipo) {
                        case "altaAlumno":
                            echo '<textarea name="usuarios" class="span10" rows="6" placeholder="Introduce los emails de los alumnos separados por comas"></textarea>';
                            break;
                        case "altaProfesor":
                            echo '<textarea name="usuarios" class="span10" rows="6" placeholder="Introduce los emails de los profesores separados por comas"></textarea>';
                            break;
                        case "altaAdministrador":
                            echo '<textarea name="usuarios" class="span10" rows="6" placeholder="Introduce los emails de los administradores separados por comas"></textarea>';
                            break;
                    }
                    ?>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary">Aceptar</button>
                    <a href="<?php echo $urlRegreso; ?>" class="btn offset1">Cancelar</a>
                </div>
            </div>
        </form>
        <div class="row-fluid"><h6></h6></div>
        <form class="form-horizontal" action="/alumnos/usuario/altaUsuariosArchivoCsvSubmit" method="post" enctype="multipart/form-data">
            <input type="hidden" name="tipo" value="<?php echo $tipo; ?>">
            <?php
            switch ($tipo) {
                case "altaAlumno":
                    echo '<legend><h4 class="blue">Agregar alumnos con un archivo .csv</h4></legend>';
                    break;
                case "altaProfesor":
                    echo '<legend><h4 class="blue">Agregar profesores con un archivo .csv</h4></legend>';
                    break;
                case "altaAdministrador":
                    echo '<legend><h4 class="blue">Agregar administradores con un archivo .csv</h4></legend>';
                    break;
            }
            ?>
            <div class="control-group">
                <label class="control-label">Archivo en formato .cvs</label>
                <div class="controls">
                    <input type="file" name="csv" title="<i class='icon-file'/> Click para seleccionar archivo">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <div class="btn btn-info" id="btnAyuda">
                        <i class="icon-white icon-info-sign"></i>
                        Ayuda
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary">
                        Aceptar
                    </button>
                    <a href="<?php echo $urlRegreso; ?>" class="btn offset1">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
$noBreadCrumbs = true;
require_once('layout/foot.php');
?>
            