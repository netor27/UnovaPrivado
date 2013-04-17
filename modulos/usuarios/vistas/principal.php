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
                echo '<a href="/alumnos/usuario/altaAlumnos" class="btn  span12">';
                echo '<i class=" icon-plus"></i> ';
                echo 'Agregar alumno(s)';
                echo '</a>';
                break;
            case 'profesores':
                echo '<a href="/profesores/usuario/altaProfesores" class="btn  span12">';
                echo '<i class="icon-plus"></i> ';
                echo 'Agregar prefesor(es)';
                echo '</a>';
                break;
            case 'administradores':
                echo '<a href="/administradores/usuario/altaAdministradores" class="btn  span12">';
                echo '<i class=" icon-plus"></i> ';
                echo 'Agregar administrador(es)';
                echo '</a>';
                break;
        }
        ?>
    </div>
</div>
<div class="row-fluid"><h6></h6></div>
<div class="row-fluid">
    <div class="well well-small">
        <legend >            
            <h4 class="blue">
                <?php
                switch ($tipo) {
                    case 'alumnos':
                        echo 'Lista de todos los alumnos';
                        break;
                    case 'profesores':
                        echo 'Lista de todos los profesores';
                        break;
                    case 'administradores':
                        echo 'Lista de todos los administradores';
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
                        if ($i % 4 === 1) {
                            echo '<div class="row-fluid">';
                        }
                        ?>
                        <div class="span3">
                            <div class="well well-small hoverBlueBorder whiteBackground">
                                <div class="row-fluid ">                                    
                                    <div class="span4">
                                        <a href="/usuario/<?php echo $usuario->uniqueUrl; ?>">
                                            <img class="hidden-phone img-polaroid" src="<?php echo $usuario->avatar; ?>"/>
                                            <img class="visible-phone imageSmallPhone img-polaroid" src="<?php echo $usuario->avatar; ?>"/>
                                        </a>
                                    </div>
                                    <div class="span7 offset1">
                                        <div class="row-fluid">
                                            <div class="span12 break-words">
                                                <a href="/usuario/<?php echo $usuario->uniqueUrl; ?>">
                                                    <?php echo $usuario->nombreUsuario; ?>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row-fluid"><div class="span12"></div></div>
                                        <div class="row-fluid">
                                            <div class="span12">
                                                <div class="btn-group pull-right">
                                                    <a class="btn btn-small btn-danger dropdown-toggle" data-toggle="dropdown">
                                                        <i class="icon-trash icon-white"> </i> 
                                                         <span class="caret"> </span>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="borrarUsuario" id="<?php echo $usuario->idUsuario; ?>">
                                                                <i class=" icon-trash"></i>
                                                                Eliminar alumno                                        
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>                                
                        </div>
                        <?php
                        if ($i % 4 === 0) {
                            echo '</div>';
                        }
                        $i++;
                    }
                    if ($i % 4 !== 1) {
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
            