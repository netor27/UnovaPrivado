<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headPerfil.php');
require_once('layout/headers/headCierre.php');
?>

<div class="contenido">    
    <div class="container">
        <div class="row-fluid">
            <div class="span12"> </div>
        </div>
        <div id="perfil_header">
            <div id="perfil_header_image" class="left">
                <img class="img-polaroid" src="<?php echo $usuarioPerfil->avatar; ?>" ><br>
                <?php
                if ($miPerfil) {
                    echo '<a href="/usuarios/usuario/cambiarImagen" style="padding-left: 37px;">Cambiar imagen</a>';
                }
                ?>

            </div>

            <div class="left" id="perfil_datos">
                <div id="perfil_nombre">
                    <h1>
                        <?php echo $usuarioPerfil->nombreUsuario; ?>
                    </h1>
                </div>
                <div id="perfil_titulo_personal">
                    <h3>
                        <?php echo $usuarioPerfil->tituloPersonal; ?>
                    </h3>

                </div>   
                <div id="perfil_cursos">
                    <h5>
                        <?php
                        if ($numCursos > 0) {
                            if ($numCursos == 1)
                                echo "Enseñando en " . $numCursos . " curso";
                            else
                                echo "Enseñando en " . $numCursos . " cursos";
                        }
                        ?>
                    </h5>
                    <h5>
                        <?php
                        if ($numTomados == 1)
                            echo "Tomando " . $numTomados . " curso";
                        else
                            echo "Tomando " . $numTomados . " cursos";
                        ?>
                    </h5>
                </div>
            </div>
            <?php
            if ($miPerfil) {
                ?>
                <div class="right" style="text-align: right">
                    <div id="perfil_header_links"">
                        <br><br>
                        <a  href="/usuarios/usuario/editarInformacion/<?php echo $usuarioPerfil->idUsuario; ?>">
                            <div class="btn btn-info right span3">Editar mi información</div>
                        </a>
                        <br><br>
                        <a href="/usuarios/usuario/cambiarPassword">
                            <div class="btn btn-info right span3">Cambiar mi contraseña</div>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php
        if (isset($usuarioPerfil->bio)) {
            ?>
            <div id="perfil_panel">
                <h3>Biografía</h3>
            </div>
            <div id="perfil_footer">
                <div id="bio" class="left">
                    <div id="bioContent">
                        <?php echo $usuarioPerfil->bio; ?>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
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
    </div>
</div>

<?php
require_once('layout/foot.php');
?>
