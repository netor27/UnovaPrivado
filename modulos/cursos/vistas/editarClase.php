<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headEditarClase.php');
require_once('layout/headers/headCierre.php');
?>
<div class="row-fluid">
    <?php
    if ($clase->idTipoClase == 0 || $clase->idTipoClase == 4) {
        ?>
        <div class="span4 offset6">
            <a class="span12 btn btn-info"  href="/cursos/clase/editor/<?php echo $curso->idCurso . "/" . $clase->idClase; ?>">
                Agregar interactividad a esta clase
            </a>
        </div>
        <?php
    }
    ?>
</div>
<div class="row-fluid"><h3></h3></div>
<div class="row-fluid">
    <div class="span12 well span9 offset1">
        <div class="row-fluid">
            <legend><h4 class="black">Editar clase</h4></legend>
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
            <form id="customForm" action="/clases/clase/editarClaseSubmit" method="post" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="inputTitulo">Título: </label>
                    <div class="controls">
                        <input class="span11" type="text" id="inputTitulo" name="titulo" value="<?php echo $clase->titulo; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputDescripcion">Descripción: </label>
                    <div class="controls">
                        <textarea class="span12" id="inputDescripcion" name="descripcion" rows="5"><?php echo $clase->descripcion; ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Aceptar</button>  
                        <a class="btn offset2" href="/curso/<?php echo $curso->uniqueUrl; ?>"> Cancelar </a>
                    </div>
                </div>
                <input type="hidden" name="idCurso" value="<?php echo $idCurso; ?>"/>
                <input type="hidden" name="idClase" value="<?php echo $clase->idClase; ?>"/>
            </form>
        </div>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>