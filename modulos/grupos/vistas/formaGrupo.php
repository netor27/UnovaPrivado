<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headCierre.php');
?>
<div class="row-fluid">
    <div class="span12">
        <div class="well ">
            <form class="form-horizontal" action="/grupos/grupo/grupoSubmit" method="post">
                <input type="hidden" name="tipo" value="<?php echo $tipo; ?>">
                <input type="hidden" name="pagina" value="<?php echo $pagina; ?>">
                <?php
                switch ($tipo) {
                    case "alta":
                        echo '<legend><h4 class="black">Agregar un grupo</h4></legend>';
                        break;
                    case "edita":
                        echo '<input type="hidden" name="idGrupo" value="' . $grupo->idGrupo . '"/>';
                        echo '<legend><h4 class="black">Modificar el grupo</h4></legend>';
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
                        <button type="submit" class="span3 btn btn-primary">Aceptar</button>
                        <a href="/grupos" class="btn span3 offset1">Cancelar</a>
                    </div>                            
                </div>
            </form>
        </div>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>
            