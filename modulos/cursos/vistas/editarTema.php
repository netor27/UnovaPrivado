<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headAgregarTema.php');
require_once('layout/headers/headCierre.php');
?>

<div class="contenido">
    <div class="container">
        <div class="row-fluid">
            <div class="span12"></div>
        </div>
        <div class="well span8 offset2">
            <div class="row-fluid">
                <legend>Editar el tema</legend>
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
                <form method="post" id="customForm" action="/temas/tema/editarTemaSubmit" class="form-horizontal">  
                    <div class="control-group">
                        <label class="control-label" for="inputTitulo">Título del tema</label>
                        <div class="controls">
                            <input class="span9" type="text" id="inputTitulo" name="titulo" value="<?php echo $tema->nombre; ?>"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary"> Aceptar </button>  
                        </div>
                    </div>
                    <input type="hidden" name="idTema" value="<?php echo $idTema; ?>"/>
                    <input type="hidden" name="idCurso" value="<?php echo $idCurso; ?>"/>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>