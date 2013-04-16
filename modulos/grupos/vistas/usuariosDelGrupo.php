<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headListaUsuariosDeGrupo.php');
require_once('layout/headers/headCierre.php');
?>
<div class="row-fluid">
    <div class="span3 offset9">
        <a href="/grupos/usuarios/usuariosDelGrupo/<?php echo $idGrupo; ?>" class="btn btn-primary span12">
            <i class="icon-white icon-plus"></i>
            Agregar usuario(s) al grupo
        </a>
    </div>
</div>
<div class="row-fluid"><h1></h1></div>
<div class="row-fluid">
    <div class="well well-small">
        <legend>
            <h4>
                Lista de usuarios inscritos en este grupo
            </h4>
        </legend>
        <?php
        $columna = 1;
        $fila = 1;
        if (isset($usuarios)) {
            ?>
            <div class="row-fluid">
                <ul class="thumbnails">
                    <?php
                    $i = 1;
                    foreach ($usuarios as $usuario) {
                        if ($i % 6 === 1) {
                            echo '<div class="row-fluid">';
                        }
                        ?>
                        <div class="span2">
                            <div class="thumbnail hoverBlueBorder">
                                <div class="caption centerText break-words">
                                    <a href="/usuario/<?php echo $usuario->uniqueUrl; ?>">
                                        <div class="row-fluid">
                                            <?php echo $usuario->nombreUsuario; ?>
                                        </div>
                                        <div class="row-fluid">
                                            <img src="<?php echo $usuario->avatar; ?>">
                                        </div>
                                    </a>
                                </div>
                                <div class="caption centerText">
                                    <a class=" btn btn-mini btn-danger btnQuitar" id="<?php echo $usuario->idUsuario; ?>">
                                        <i class="icon-white icon-trash"></i>
                                        Quitar de este curso
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($i % 6 === 0) {
                            echo '</div>';
                            echo '<div class="row-fluid"><div class=span12></div></div>';
                        }
                        $i++;
                    }
                    if ($i % 6 !== 1) {
                        echo '</div>';
                    }
                    ?>
                </ul>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <div class="pagination pagination-centered">
                        <ul>
                            <?php
                            if ($pagina > 1)
                                echo '<li><a href="/grupos/usuarios/inscritos/' . $idGrupo . '&p=' . ($pagina - 1) . '">«</a></li>';
                            else
                                echo '<li class="disabled"><a href="#">«</a></li>';

                            for ($i = 1; $i <= $maxPagina; $i++) {
                                if ($i == $pagina)
                                    echo '<li class="active"><a href="#">' . $i . '</a></li>';
                                else
                                    echo '<li><a href="/grupos/usuarios/inscritos/' . $idGrupo . '&p=' . $i . '">' . $i . '</a></li>';
                            }

                            if ($pagina < $maxPagina)
                                echo '<li><a href="/grupos/usuarios/inscritos/' . $idGrupo . '&p=' . ($pagina + 1) . '">»</a></li>';
                            else
                                echo '<li class="disabled"><a href="#">»</a></li>';
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
        }else {
            ?>
            <div class="row-fluid">
                <h3>No hay usuarios en este grupo</h3>
            </div>
            <div class="row-fluid"><div class="span12"></div></div>
            <?php
        }
        ?>        
    </div>
</div>
<?php
require_once('layout/foot.php');
?>
            