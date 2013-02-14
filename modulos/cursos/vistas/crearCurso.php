<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headCrearCurso.php');
require_once('layout/headers/headCierre.php');
?>


<div class="contenido">
    <div class="container">
        <div class="row-fluid">


            <div class="well well-large span12">
                <div class="row-fluid">
                    <legend><h4>Crear un curso</h4></legend>
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
                    <form id="customForm" action="/cursos/curso/crearCursoSubmit" method="post" class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label" for="inputTitulo">Título del curso</label>
                            <div class="controls">
                                <input class="span6" type="text" id="inputTitulo" name="titulo" value="<?php echo $titulo; ?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputDescripcion">Descripción corta</label>
                            <div class="controls">
                                <textarea class="span8" id="inputDescripcion" name="descripcionCorta" rows="5"><?php echo $descripcion; ?></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <button type="submit" class="span3 btn btn-primary">Crear curso</button>  
                                <a href="/cursos" class="span3 offset1 btn">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once('layout/foot.php');
?>
            