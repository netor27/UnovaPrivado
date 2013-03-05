<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headTinyMCE.php');
require_once('layout/headers/headCrearCurso.php');
require_once('layout/headers/headCierre.php');
?>
<div class="contenido">
    <div class="container">
        <div class="row-fluid">
            <div class="span12"></div>
        </div>
        <div class="well span12 ">
            <div class="row-fluid">
                <legend><h4>Editar información del curso</h4></legend>
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
                <form method="post" id="customForm" class="form-horizontal" action="/cursos/curso/editarInformacionCursoSubmit/<?php echo $cursoParaModificar->idCurso; ?>">
                    <div class="control-group">
                        <label class="control-label" for="inputTitulo">Título del curso</label>
                        <div class="controls">
                            <input class="span5" type="text" id="inputTitulo" name="titulo" value="<?php echo $cursoParaModificar->titulo; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputDescripcion">Descripción corta</label>
                        <div class="controls">
                            <textarea class="span10" id="inputDescripcion" name="descripcionCorta" rows="5"><?php echo $cursoParaModificar->descripcionCorta; ?></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputDescripcion">Descripción</label>
                        <div class="controls">
                            <textarea id="descripcion" name="descripcion"><?php echo $cursoParaModificar->descripcion; ?></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="span3 btn btn-primary">Aceptar</button>  
                            <a href="/curso/<?php echo $cursoParaModificar->uniqueUrl;?>" class="span3 offset1 btn ">Cancelar</a>  
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
require_once('layout/foot.php');
?>