<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headRecuperarPassword.php');
require_once('layout/headers/headCierre.php');
?>
<div class="row-fluid">
    <div class="well span8 offset2">
        <div class="row-fluid">
            <legend>
                <h4 class="blue">Recuperar contraseña</h4>
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
            <div class="row-fluid">
                <form method="post" id="customForm" action="/usuarios/usuario/recuperarPasswordSubmit" class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="inputEmail">Correo electrónico:</label>
                        <div class="controls">
                            <input class="span8" id="inputEmail" name="email" type="text" />
                        </div>
                    </div>                    
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary"> Aceptar </button>  
                            <a class="btn offset1" href="/"> Cancelar </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row-fluid">
                <div class="span12 rightText">
                    <h6 class="black">*Te enviaremos un correo con un link para que recuperes tu contraseña.</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>