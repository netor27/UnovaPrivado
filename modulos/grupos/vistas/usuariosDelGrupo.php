<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headGridster.php');
require_once('layout/headers/headListaUsuariosDeGrupo.php');
require_once('layout/headers/headCierre.php');
?>

<div class="container">
    <div class="contenido">
        <div class="well well-large">
            <div class="row-fluid">
                <div class="span6">
                    <?php
                    if ($numUsuarios == 1)
                        echo '<h4>Hay un usuario en este grupo</h4>';
                    else
                        echo '<h4>Hay ' . $numUsuarios . ' usuarios en este grupo</h4>';
                    ?>
                </div>
                <div class="span3 offset3">
                    <div style="padding-top: 20px;">
                        <a href="/grupos/usuarios/usuariosDelGrupo/<?php echo $idGrupo; ?>" class="btn btn-primary">
                            <i class="icon-white icon-plus"></i>
                            Agregar usuario(s) al grupo
                        </a>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12"></div>
            </div>
            <?php
            $columna = 1;
            $fila = 1;
            if (isset($usuarios)) {
                ?>
                <div class="row-fluid">
                    <div id="alumnosContainer" class="span12">
                        <div class="gridster ready">
                            <ul style="height: 480px; position: relative; ">
                                <?php
                                foreach ($usuarios as $usuario) {
                                    ?>
                                    <li class="cuadro ui-corner-all" data-row="1" data-col="1" data-sizex="1" data-sizey="1" style="background: url('<?php echo $usuario->avatar; ?>')">
                                        <div class="cuadroFooter ui-corner-bottom ease3">
                                            <span class="cuadroFooterTitulo">
                                                <a href="/usuario/<?php echo $usuario->uniqueUrl . '&b='. getRequestUri(); ?>">
                                                    <?php echo $usuario->nombreUsuario; ?>
                                                </a>
                                            </span>
                                            <br>
                                            <span class="cuadroFooterLink">
                                                <a class="btn btn-mini btn-danger btnQuitar" id="<?php echo $usuario->idUsuario; ?>">
                                                    <i class="icon-white icon-trash"></i>
                                                    Quitar usuario del grupo                                                
                                                </a>
                                            </span>
                                        </div>
                                    </li>
                                    <?php
                                }
                                ?>                        
                            </ul>
                        </div>

                    </div>
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
                <?php
            }
            ?>
            <div class="row-fluid">
                <div class="span3 subir20px">
                    <a class="btn btn-inverse btn-small" href="/grupos">
                        <i class="icon-white icon-arrow-left"></i>
                        Regresar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
require_once('lib/js/jqueryGridster/gridsterSinDraggable.php');
require_once('layout/foot.php');
?>
            