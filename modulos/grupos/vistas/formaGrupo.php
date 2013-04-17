<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headFormaGrupo.php');
require_once('layout/headers/headCierre.php');
?>
<div class="row-fluid">    
    <div class="well span8 offset2">
        <div class="row-fluid">
            <?php
            switch ($tipo) {
                case "alta":
                    echo '<legend><h4 class="blue">Agregar un grupo</h4></legend>';
                    break;
                case "edita":
                    echo '<legend><h4 class="blue">Modificar el grupo</h4></legend>';
                    break;
            }
            ?>
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
            <form id="customForm" class="form-horizontal" action="/grupos/grupo/grupoSubmit" method="post">
                <?php
                if ($tipo == "edita") {
                    echo '<input type="hidden" name="idGrupo" value="' . $grupo->idGrupo . '"/>';
                }
                ?>
                <input type="hidden" name="tipo" value="<?php echo $tipo; ?>">
                <input type="hidden" name="pagina" value="<?php echo $pagina; ?>">
                <div class="control-group">
                    <label class="control-label">Nombre:</label>
                    <div class="controls">
                        <input id="inputNombre" class="span6" type="text" name="nombre" value="<?php echo $grupo->nombre; ?>"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Descripción:</label>
                    <div class="controls">
                        <textarea id="inputDescripcion" name="descripcion" class="span8" rows="7"><?php echo $grupo->descripcion; ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="span2 btn btn-primary">Aceptar</button>
                        <a href="/grupos" class="btn span2 offset1">Cancelar</a>
                    </div>                            
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$noBreadCrumbs = true;
require_once('layout/foot.php');
?>
            