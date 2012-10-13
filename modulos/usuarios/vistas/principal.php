<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headBootstrap.php');
require_once('layout/headers/headGridster.php');
require_once('layout/headers/headListaUsuarios.php');
require_once('layout/headers/headCierre.php');
?>
<script>
    var tipo = "<?php echo $tipo; ?>";    
</script>
    

<div class="container">
    <div class="contenido">
        <div class="well well-large">

            <div class="row-fluid">
                <div class="span6">
                    <?php
                    switch ($tipo) {
                        case 'alumnos':
                            if ($numUsuarios == 1)
                                echo '<h4>Hay un alumno</h4>';
                            else
                                echo '<h4>Hay ' . $numUsuarios . ' alumnos</h4>';
                            break;
                        case 'profesores':
                            if ($numUsuarios == 1)
                                echo '<h4>Hay un profesor</h4>';
                            else
                                echo '<h4>Hay ' . $numUsuarios . ' profesores</h4>';
                            break;
                        case 'administradores':
                            if ($numUsuarios == 1)
                                echo '<h4>Hay un administrador</h4>';
                            else
                                echo '<h4>Hay ' . $numUsuarios . ' administradores</h4>';
                            break;
                    }
                    ?>
                </div>
                <div class="span3 offset3">
                    <div style="padding-top: 20px;">
                        <?php
                        switch ($tipo) {
                            case 'alumnos':
                                echo '<a href="/alumnos/usuario/altaAlumnos" class="btn btn-primary">';
                                echo '<i class="icon-white icon-plus"></i>';
                                echo 'Agregar alumno(s)';
                                echo '</a>';
                                break;
                            case 'profesores':
                                echo '<a href="/profesores/usuario/altaProfesores" class="btn btn-primary">';
                                echo '<i class="icon-white icon-plus"></i>';
                                echo 'Agregar prefesor(es)';
                                echo '</a>';
                                break;
                            case 'administradores':
                                echo '<a href="/administradores/usuario/altaAdministradores" class="btn btn-primary">';
                                echo '<i class="icon-white icon-plus"></i>';
                                echo 'Agregar administrador(es)';
                                echo '</a>';
                                break;
                        }
                        ?>
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
                                                <a href="/usuario/<?php echo $usuario->uniqueUrl; ?>">
                                                    <?php echo $usuario->nombreUsuario; ?>
                                                </a>
                                            </span>
                                            <br>
                                            <span class="cuadroFooterLink">
                                                <a class="btn btn-mini btn-danger borrarUsuario" id="<?php echo $usuario->idUsuario; ?>">
                                                    <i class="icon-white icon-trash"></i>
                                                    <?php
                                                    switch($tipo){
                                                        case 'alumnos':
                                                            echo 'Eliminar alumno';
                                                            break;
                                                        case 'profesores':
                                                            echo 'Eliminar profesor';
                                                            break;
                                                        case 'administradores':
                                                            echo 'Eliminar admin';
                                                            break;
                                                    }
                                                    ?>                                                    
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
                                    echo '<li><a href="/'.$tipo.'&p=' . ($pagina - 1) . '">«</a></li>';
                                else
                                    echo '<li class="disabled"><a href="#">«</a></li>';

                                for ($i = 1; $i <= $maxPagina; $i++) {
                                    if ($i == $pagina)
                                        echo '<li class="active"><a href="#">' . $i . '</a></li>';
                                    else
                                        echo '<li><a href="/'.$tipo.'&p=' . $i . '">' . $i . '</a></li>';
                                }

                                if ($pagina < $maxPagina)
                                    echo '<li><a href="/'.$tipo.'&p=' . ($pagina + 1) . '">»</a></li>';
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
                    <h3>No hay <?php echo $tipo; ?> dados de alta</h3>
                </div>
                <?php
            }
            ?>
            <div class="row-fluid">
                <div class="span3">
                    <a class="btn btn-inverse btn-small" href="/">
                        <i class="icon-white icon-arrow-left"></i>
                        Regresar al inicio
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
            