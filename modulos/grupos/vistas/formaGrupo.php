<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headCierre.php');
?>
<div class="container">
    <div class="contenido">
        <div class="row-fluid">
            <div class="span12">
                <div class="well well-large">
                    <form class="form-horizontal" action="/grupos/grupo/grupoSubmit" method="post">
                        <input type="hidden" name="tipo" value="<?php echo $tipo; ?>">
                        <input type="hidden" name="pagina" value="<?php echo $pagina;?>">
                        <?php
                        switch ($tipo) {
                            case "alta":
                                echo '<legend>Agregar un grupo</legend>';
                                break;
                            case "edita":
                                echo '<input type="hidden" name="idGrupo" value="' . $grupo->idGrupo . '"/>';
                                echo '<legend>Modificar el grupo</legend>';
                                break;
                        }
                        ?>
                        <div class="control-group">
                            <label class="control-label">Nombre</label>
                            <div class="controls">
                                <input type="text" name="nombre" value="<?php echo $grupo->nombre; ?>"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Descripción</label>
                            <div class="controls">
                                <textarea name="descripcion" class="span7" rows="7"><?php echo $grupo->descripcion; ?></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <button type="submit" class="btn">Aceptar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span3">
            <a class="btn btn-inverse btn-small" href="/grupos">
                <i class="icon-white icon-arrow-left"></i>
                Regresar
            </a>
        </div>
    </div>
</div>



<?php
require_once('layout/foot.php');
?>
            