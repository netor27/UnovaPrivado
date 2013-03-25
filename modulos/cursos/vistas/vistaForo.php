<?php
require_once 'modulos/cursos/modelos/DiscusionModelo.php';
$discusiones = getDiscusiones($cursoAux->idCurso);
?>
<div class="row-fluid ">
    <div class="span9">
        <strong><p>Temas de discusión en este curso:</p></strong>
    </div>
    <div class="span3">
        <button class="btn btn-primary">
            <i class="icon-plus icon-white"></i> Agregar un tema de discusión
        </button>
    </div>        
</div>
<?php
foreach ($discusiones as $discusion) {
    ?>
    <div class="row-fluid ui-state-default ui-corner-all margin-top10">
        <div class="span12">
            <div class="row-fluid">
                <div class="span2">
                    Avatar usuario <?php echo $discusion->idUsuario; ?>
                </div>
                <div class="span10">
                    <div class="row-fluid">
                        <div class="span10">
                            Nombre usuario <?php echo $discusion->idUsuario; ?>
                        </div>
                        <div class="span2">
                            <?php echo $discusion->fecha; ?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <?php echo $discusion->titulo; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>