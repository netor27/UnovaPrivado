<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headListaUsuarios.php');
require_once('layout/headers/headCierre.php');
?>
<script>
    var tipo = "<?php echo $tipo; ?>";    
</script>
<div class="row-fluid">
    <div class="span3 offset9">
        <?php
        switch ($tipo) {
            case 'alumnos':
                echo '<a href="/alumnos/usuario/altaAlumnos" class="btn btn-primary span12">';
                echo '<i class="icon-white icon-plus"></i>';
                echo 'Agregar alumno(s)';
                echo '</a>';
                break;
            case 'profesores':
                echo '<a href="/profesores/usuario/altaProfesores" class="btn btn-primary span12">';
                echo '<i class="icon-white icon-plus"></i>';
                echo 'Agregar prefesor(es)';
                echo '</a>';
                break;
            case 'administradores':
                echo '<a href="/administradores/usuario/altaAdministradores" class="btn btn-primary span12">';
                echo '<i class="icon-white icon-plus"></i>';
                echo 'Agregar administrador(es)';
                echo '</a>';
                break;
        }
        ?>
    </div>
</div>
<div class="row-fluid"><h1></h1></div>
<div class="row-fluid">
    <div class="well well-small">
        <legend >            
            <h4 >
                <?php
                switch ($tipo) {
                    case 'alumnos':
                        echo 'Lista de alumnos';
                        break;
                    case 'profesores':
                        echo 'Lista de profesores';
                        break;
                    case 'administradores':
                        echo 'Lista de administradores';
                        break;
                }
                ?>
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
                                        <div class="span12">
                                            <?php echo $usuario->nombreUsuario; ?>                                    
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span12 centerText">
                                            <img class="hidden-phone" src="<?php echo $usuario->avatar; ?>"/>
                                            <img class="visible-phone imageSmallPhone" src="<?php echo $usuario->avatar; ?>"/>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                                <div class="caption centerText">
                                    <a class="btn btn-mini btn-danger borrarUsuario" id="<?php echo $usuario->idUsuario; ?>">
                                        <i class="icon-white icon-trash"></i>
                                        Eliminar                                          
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
                                echo '<li><a href="/' . $tipo . '&p=' . ($pagina - 1) . '">«</a></li>';
                            else
                                echo '<li class="disabled"><a href="#">«</a></li>';

                            for ($i = 1; $i <= $maxPagina; $i++) {
                                if ($i == $pagina)
                                    echo '<li class="active"><a href="#">' . $i . '</a></li>';
                                else
                                    echo '<li><a href="/' . $tipo . '&p=' . $i . '">' . $i . '</a></li>';
                            }

                            if ($pagina < $maxPagina)
                                echo '<li><a href="/' . $tipo . '&p=' . ($pagina + 1) . '">»</a></li>';
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
    </div>
</div>
<?php
require_once('layout/foot.php');
?>
            