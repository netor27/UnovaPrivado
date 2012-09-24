<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headBootstrap.php');
require_once('layout/headers/headAsignarGrupoCurso.php');
require_once('layout/headers/headCierre.php');
?>

<div class="contenido">
    <div class="row-fluid">
        <div class="span12">
            <h4>Agregar grupos al curso:</h4>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span7">
            <h5><?php echo $curso->titulo; ?></h5>
            <h6><?php echo $curso->descripcionCorta; ?></h6>
        </div>                
    </div>    
    <div class="well">
        <div class="row-fluid">
            <div class="span1">
                Filtrar
            </div>
            <div class="span4">
                <input type="text" id="textUsuarios">
            </div>
            <div class="span2">

            </div>
            <!--<div class="span1">
                Filtrar
            </div>
            <div class="span4">
                <input type="text" id="textInscritos">
            </div>-->
        </div>
        <div class="row-fluid">
            <div class="span5">
                <select name="grupos[]" id="listaGrupos" class="listaGrupos" size="20">
                    <?php
                    if (isset($grupos)) {
                        foreach ($grupos as $grupo) {
                            echo '<option value="' . $grupo->idGrupo . '">' . $grupo->nombre . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="span2">

            </div>
            <div class="span5">
                <select name="inscritos[]" id="listaInscritos" class="listaGrupos" size="20">
                    <?php
                    if (isset($gruposDelCurso)) {
                        foreach ($gruposDelCurso as $grupo) {
                            echo '<option value="' . $grupo->idGrupo . '">' . $grupo->nombre . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="row-fluid">
                <div class="span5">
                    <div class="span8 offset2 btn btn-primary" id="btnAgregar">                        
                        Agregar al curso
                        <i class="icon-white icon-arrow-right"></i>
                    </div>
                </div>
                <div class="span5 offset2">
                    <div class="span8 offset2 btn btn-warning" id="btnQuitar">
                        <i class="icon-white icon-arrow-left"></i>
                        Quitar del curso
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12"></div>
            </div>
            <div class="row-fluid">
                <div class="span3 offset6">
                    <div class="span12 btn" id="btnCancelar">
                        Salir
                    </div>
                </div>
                <div class="span3">
                    <div class="span12 btn btn-success" id="btnGuardar">
                        <i class="icon-white icon-ok"></i>
                        Guardar Cambios
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



<?php
require_once('layout/foot.php');
?>
            