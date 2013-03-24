<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headCambiarPassword.php');
require_once('layout/headers/headCierre.php');
?>
<div class="row-fluid">
    <div class="well span8 offset2">
        <div class="row-fluid">
            <legend><h4 class="black">Cambiar contraseña</h4></legend>
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
            <form method="post" id="customForm" action="/usuarios/usuario/cambiarPasswordSubmit" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="inputPassAnt">Contraseña anterior:</label>
                    <div class="controls">
                        <input id="inputPassAnt" name="passAnt" type="password"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputPass1">Contraseña nueva:</label>
                    <div class="controls">
                        <input id="inputPass1" name="pass1" type="password"/>  
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputPass2">Repetir contraseña:</label>
                    <div class="controls">
                        <input id="inputPass2" name="pass2" type="password"/> 
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary"> Aceptar </button>  
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