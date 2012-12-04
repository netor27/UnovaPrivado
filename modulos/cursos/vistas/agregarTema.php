<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headAgregarTema.php');
require_once('layout/headers/headCierre.php');
?>


<div class="contenido">
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12"></div>
        </div>
        <div class="well span8 offset2">
            <div class="row-fluid">
                <legend>Agregar un tema</legend>
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
                <form id="customForm" action="/temas/tema/agregarTemaSubmit" method="post" class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="inputTitulo">Título del tema</label>
                        <div class="controls">
                            <input class="span9" type="text" id="inputTitulo" name="titulo"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary">Agregar tema</button>  
                        </div>
                    </div>
                    <input type="hidden" name="idCurso" value="<?php echo $idCurso; ?>"/>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>