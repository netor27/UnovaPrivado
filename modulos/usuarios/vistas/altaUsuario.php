<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headAltaUsuario.php');
require_once('layout/headers/headCierre.php');
?>
<div class="container">
    <div class="contenido">
        <div class="row-fluid">
            <div class="span12">
                <div class="well well-large">
                    <form class="form-horizontal" action="/alumnos/usuario/altaUsuariosSubmit" method="post">
                        <input type="hidden" name="tipo" value="<?php echo $tipo; ?>">
                        <?php
                        switch ($tipo) {
                            case "altaAlumno":
                                $urlRegreso = "/alumnos";
                                echo '<legend><h4>Agregar alumnos</h4></legend>';
                                break;
                            case "altaProfesor":
                                $urlRegreso = "/profesores";
                                echo '<legend><h4>Agregar profesores</h4></legend>';
                                break;
                            case "altaAdministrador":
                                $urlRegreso = "/administradores";
                                echo '<legend><h4>Agregar administradores</h4></legend>';
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
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal" action="/alumnos/usuario/altaUsuariosArchivoCsvSubmit" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="tipo" value="<?php echo $tipo; ?>">
                        <?php
                        switch ($tipo) {
                            case "altaAlumno":
                                echo '<legend><h4>Agregar alumnos con un archivo .csv</h4></legend>';
                                break;
                            case "altaProfesor":
                                echo '<legend><h4>Agregar profesores con un archivo .csv</h4></legend>';
                                break;
                            case "altaAdministrador":
                                echo '<legend><h4>Agregar administradores con un archivo .csv</h4></legend>';
                                break;
                        }
                        ?>
                        <div class="control-group">
                            <label class="control-label">Seleccionar archivo .cvs</label>
                            <div class="controls">
                                <input type="file" name="csv">
                            </div>
                            <div class="span2 btn btn-info" id="btnAyuda">
                                <i class="icon-white icon-info-sign"></i>
                                Ayuda
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <button type="submit" class="btn">
                                    Aceptar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span3">
            <a class="btn btn-inverse btn-small" href="<?php echo $urlRegreso; ?>">
                <i class="icon-white icon-arrow-left"></i>
                Regresar
            </a>
        </div>
    </div>
</div>



<?php
require_once('layout/foot.php');
?>
            