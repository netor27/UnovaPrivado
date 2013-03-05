<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headCierre.php');
?>

<div class="contenido">
    <div class="container">
        <div class="row-fluid">
            <div class="span12"></div>
        </div>
        <div class="well span8 offset2">
            <div class="row-fluid">
                <legend><h4>Cambiar imagen de perfil</h4></legend>
            </div>
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
            <div class="row-fluid">
                <form method="post" id="customForm" enctype="multipart/form-data" action="/usuarios/usuario/cambiarImagenSubmit" class="form-horizontal">  
                    <div class="control-group">
                        <label class="control-label" for="inputTitulo">Imagen actual:</label>
                        <div class="controls">
                            <img class="img-polaroid" src="<?php echo $usuarioCambiar->avatar; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputImagen">Sube una imagen:</label>
                        <div class="controls">
                            <input id="imagen" name="imagen" type="file" />
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary"> Aceptar </button>  
                            <a href="/usuario/<?php echo $usuarioCambiar->uniqueUrl; ?>" class="btn offset1"> Cancelar </a>  
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>