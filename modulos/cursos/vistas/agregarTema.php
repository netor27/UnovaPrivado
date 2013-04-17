<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headAgregarTema.php');
require_once('layout/headers/headCierre.php');
?>
<div class="row-fluid">
    <div class="well span8 offset2">
        <div class="row-fluid">
            <legend>
                <h4 class="blue">Agregar un tema</h4>
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
            <form id="customForm" action="/temas/tema/agregarTemaSubmit" method="post" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="inputTitulo">Título del tema:</label>
                    <div class="controls">
                        <input class="span11" type="text" id="inputTitulo" name="titulo"/>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Agregar tema</button>
                        <a class="btn offset1" href="/curso/<?php echo $cursoParaModificar->uniqueUrl; ?>"> Cancelar </a>
                    </div>
                </div>
                <input type="hidden" name="idCurso" value="<?php echo $idCurso; ?>"/>
            </form>
        </div>
    </div>
</div>
<?php
$noBreadCrumbs = false;
require_once('layout/foot.php');
?>