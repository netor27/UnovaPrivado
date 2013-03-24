<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headAsignarUsuarioCurso.php');
require_once('layout/headers/headCierre.php');
?>
<div class="well">
    <div class="row-fluid">
        <legend>
            <h4 class="black">Inscribir usuarios al curso: "<?php echo $curso->titulo; ?>"</h4>
        </legend>
    </div>
    <div class="row-fluid">
        <div class="span1">
            Filtrar
        </div>
        <div class="span4">
            <input type="text" id="textUsuarios">
        </div>
        <div class="span2">

        </div>
        <!--<div class="span1">
            Filtrar
        </div>
        <div class="span4">
            <input type="text" id="textInscritos">
        </div>-->
    </div>
    <div class="row-fluid">
        <div class="span5">
            <select name="usuarios[]" id="listaUsuarios" class="listaUsuarios" size="20" multiple="true">
                <?php
                if (isset($usuarios)) {
                    foreach ($usuarios as $usuario) {
                        echo '<option value="' . $usuario->idUsuario . '">' . $usuario->nombreUsuario . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="span2">

        </div>
        <div class="span5">
            <select name="inscritos[]" id="listaInscritos" class="listaUsuarios" size="20" multiple="true">
                <?php
                if (isset($usuariosDelCurso)) {
                    foreach ($usuariosDelCurso as $usuario) {
                        echo '<option value="' . $usuario->idUsuario . '">' . $usuario->nombreUsuario . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="row-fluid">
            <div class="span5">
                <div class="span8 offset2 btn btn-success" id="btnAgregar">                        
                    Agregar al curso
                    <i class="icon-white icon-arrow-right"></i>
                </div>
            </div>
            <div class="span5 offset2">
                <div class="span8 offset2 btn btn-warning" id="btnQuitar">
                    <i class="icon-white icon-arrow-left"></i>
                    Quitar del curso
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12"></div>
        </div>
        <div class="row-fluid">
            <div class="span3 offset6">
                <div class="span12 btn" id="btnCancelar">
                    Salir
                </div>
            </div>
            <div class="span3">
                <div class="span12 btn btn-primary" id="btnGuardar">
                    <i class="icon-white icon-ok"></i>
                    Guardar Cambios
                </div>
            </div>
        </div>
    </div>
</div>

</div>



<?php
require_once('layout/foot.php');
?>
            