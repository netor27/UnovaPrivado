<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headRecuperarPassword.php');
require_once('layout/headers/headCierre.php');
?>

<div class="contenido">
    <div class="container">
        <div class="row-fluid">
            <div class="span12"></div>
        </div>
        <div class="well span8 offset2">
            <div class="row-fluid">
                <legend>Recuperar contraseña</legend>
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
                <div class="row-fluid">
                    <div class="span10 offset1">
                        <h3>Te enviaremos un link para que recuperes tu contraseña</h3>
                    </div>
                </div>
                <form method="post" id="customForm" action="/usuarios/usuario/recuperarPasswordSubmit" class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="inputEmail">Correo electrónico:</label>
                        <div class="controls">
                            <input id="inputEmail" name="email" type="text" />
                        </div>
                    </div>                    
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary"> Aceptar </button>  
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