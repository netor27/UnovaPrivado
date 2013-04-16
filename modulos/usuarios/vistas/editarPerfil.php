<?php
require_once('layout/headers/headInicio.php');
require_once 'layout/headers/headBootstrap-wysiwyg.php';
require_once('layout/headers/headEditarPerfil.php');
//require_once('layout/headers/headTinyMCE.php');
require_once('layout/headers/headCierre.php');
?>
<div class="row-fluid">
    <div class="well span12 ">
        <div class="row-fluid">
            <legend>
                <h4 class="blue">Actualizar mi información</h4>
            </legend>
        </div>
        <div id="errorMessage">
            <?php
            if (isset($msgForma)) {
                ?>
                <div class="row-fluid">
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>¡Error! </strong> <?php echo $msgForma; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="row-fluid">
            <form method="post" id="customForm" action="/usuarios/usuario/editarInformacionSubmit" class="form-horizontal">  
                <div class="control-group">
                    <label class="control-label" for="inputNombre">Nombre:</label>
                    <div class="controls">
                        <input class="span9" id="inputNombre" name="nombre" type="text" value='<?php echo $usuario->nombreUsuario; ?>'/>  
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputTitulo">Título personal:</label>
                    <div class="controls">
                        <input class="span9" id="inputTitulo" name="tituloPersonal" type="text" value="<?php echo $usuario->tituloPersonal; ?>" placeholder="Ej. Experto en tocar la guitarra, Profesor de tiempo completo, diseñador web en Unova, etc."/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputBio" style="margin-top: 10px;">Biografía:</label>
                    <div class="controls">
                        <input type="hidden" id="bio" name="bio"/>
                        <?php
                        $valorEditor = $usuario->bio;
                        require_once 'lib/js/bootstrap-wysiwyg/editorDiv.php';
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Aceptar</button>  
                        <a href="/usuario/<?php echo $usuario->uniqueUrl; ?>" class="btn offset1"> Cancelar </a>  
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>
