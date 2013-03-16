<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headPerfil.php');
require_once('layout/headers/headCierre.php');
?>
<div class="row-fluid">
    <div class="span12 well well-large">
        <div class="span3">
            <img class="span12 img-polaroid"src="<?php echo $usuarioPerfil->avatar; ?>" >
            <?php
            if ($miPerfil) {
                echo '<a href="/usuarios/usuario/cambiarImagen" style="padding-left: 53px;">Cambiar imagen</a>';
            }
            ?>
        </div>
        <div class="span9">
            <legend>
                <h3><?php echo $usuarioPerfil->nombreUsuario; ?></h3>
            </legend>
            <div class="row-fluid">
                <div class="span8">
                    <div class="row-fluid">
                        <h4 class="black">
                            <?php echo $usuarioPerfil->tituloPersonal; ?>
                        </h4>
                    </div>
                    <div class="row-fluid">
                        <strong>
                            <?php
                            if ($numCursos > 0) {
                                if ($numCursos == 1)
                                    echo "Enseñando en " . $numCursos . " curso";
                                else
                                    echo "Enseñando en " . $numCursos . " cursos";
                            }
                            ?>
                        </strong>
                    </div>
                    <div class="row-fluid">
                        <strong>
                            <?php
                            if ($numTomados == 1)
                                echo "Tomando " . $numTomados . " curso";
                            else
                                echo "Tomando " . $numTomados . " cursos";
                            ?>
                        </strong>
                    </div>
                </div>
                <div class="span4">
                    <?php
                    if ($miPerfil) {
                        ?>
                        <div class="row-fluid">
                            <div class="span12">
                            <a  href="/usuarios/usuario/editarInformacion/<?php echo $usuarioPerfil->idUsuario; ?>">
                                <div class="btn span12">
                                    <i class=" icon-pencil"></i>
                                    Editar mi información
                                </div>
                            </a>
                            </div>
                        </div>
                    <div class="row-fluid"><h4></h4></div>
                        <div class="row-fluid">
                            <div class="span12">
                                <a href="/usuarios/usuario/cambiarPassword">
                                    <div class="btn span12">
                                        <i class=" icon-cog"></i>
                                        Cambiar mi contraseña
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12 well well-large">
        <legend><h3>Biografía</h3></legend>
        <?php
        if (isset($usuarioPerfil->bio)) {
            echo $usuarioPerfil->bio;
        }
        ?>
    </div>
</div>
<div class="row-fluid">
    <div class="span2">
        <?php
        if (isset($backUrl)) {
            ?>
            <a href="<?php echo $backUrl; ?>" class="btn btn-inverse btn-small">
                <i class="icon-white icon-arrow-left"></i>
                Regresar
            </a>
            <?php
        } else {
            ?>
            <a href="/" class="btn btn-inverse btn-small">
                <i class="icon-white icon-arrow-left"></i>
                Regresar al inicio
            </a>
            <?php
        }
        ?>

    </div>
</div>
<?php
require_once('layout/foot.php');
?>
