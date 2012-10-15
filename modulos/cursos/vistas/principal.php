<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headBootstrap.php');
require_once('layout/headers/headListaCursos.php');
require_once('layout/headers/headCierre.php');
?>

<div class="contenido">
    <h4 style="text-align: center;"><?php echo $numCursos; ?> Cursos en total</h4>
    <div style="background: #F7F7F7;">
        <div class="cursosContainer">
            <ul class="listaCursos">
                <?php
                if (isset($cursos) && !is_null($cursos)) {
                    foreach ($cursos as $curso) {
                        ?>
                        <li class="curso">
                            <a href="/curso/<?php echo $curso->uniqueUrl; ?>">
                                <div class="thumb" style="background: url(<?php echo $curso->imagen; ?>);"></div>
                            </a>                        
                            <div class="detalles">
                                <span class="titulo left">
                                    <?php
                                    echo '<a href="/curso/' . $curso->uniqueUrl . '">' . substr($curso->titulo, 0, 40) . '</a>';
                                    ?>                    
                                </span>
                                <br>
                                <span class="autor left">
                                    Autor: <a href="<?php echo $curso->uniqueUrlUsuario ?>"><?php echo $curso->nombreUsuario; ?></a>
                                </span>
                                <br>
                                <div class="left botones">
                                    <div class="left btn-group">
                                        <a class="btn btn-small btn-primary" href="/cursos/curso/alumnos/<?php echo $curso->idCurso . "&pc=" . $pagina; ?>"><i class="icon-user icon-white"></i> Usuarios</a>
                                        <a class="btn  btn-small btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="/cursos/curso/alumnos/<?php echo $curso->idCurso . "&pc=" . $pagina; ?>"><i class="icon-pencil"></i> Ver inscritos</a></li>
                                            <li><a href="/usuarios/cursos/inscribirUsuario/<?php echo $curso->idCurso; ?>"><i class="icon-plus"></i> Inscribir usuario(s)</a></li>                                            
                                        </ul>
                                    </div>
                                    <div class="left btn-group">
                                        <a class="btn btn-small btn-warning" href="/grupos/cursos/asignados/<?php echo $curso->idCurso . "&pc=" . $pagina; ?>"><i class="icon-share icon-white"></i> Grupos</a>
                                        <a class="btn  btn-small btn-warning dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="/grupos/cursos/asignados/<?php echo $curso->idCurso; ?>">
                                                    <i class="icon-pencil"></i> Ver asignados
                                                </a>
                                            </li>
                                            <li><a href="#"><i class="icon-plus"></i> Asignar grupo(s)</a></li>                                            
                                        </ul>
                                    </div>                                
                                </div>
                            </div>
                            <div>
                                <div class="numDetalles numAlumnos">   
                                    <?php echo $curso->numeroDeAlumnos; ?>
                                    <span>Alumnos</span>
                                </div>
                                <div class="numDetalles numClases">                                    
                                    <?php echo $curso->numeroDeClases; ?>
                                    <span>Clases</span>
                                </div>   
                            </div>

                            <div class="right botonBorrar">
                                <div class="left btn-group">
                                    <a class="btn btn-small btn-danger borrarCurso" href="#" 
                                       id="<?php echo $curso->idCurso; ?>">
                                        <i class="icon-fire icon-white"></i> Eliminar
                                    </a>
                                </div>
                            </div>
                        </li>
                        <?php
                    }
                } else {
                    echo '<li><h2>No hay más cursos</h2></li>';
                }
                ?>
            </ul>
        </div>
        <div class="pagination pagination-centered">
            <ul>
                <?php
                if ($pagina > 1)
                    echo '<li><a href="/cursos?p=' . ($pagina - 1) . '">«</a></li>';
                else
                    echo '<li class="disabled"><a href="#">«</a></li>';

                for ($i = 1; $i <= $maxPagina; $i++) {
                    if ($i == $pagina)
                        echo '<li class="active"><a href="#">' . $i . '</a></li>';
                    else
                        echo '<li><a href="/cursos?p=' . $i . '">' . $i . '</a></li>';
                }

                if ($pagina < $maxPagina)
                    echo '<li><a href="/cursos?p=' . ($pagina + 1) . '">»</a></li>';
                else
                    echo '<li class="disabled"><a href="#">»</a></li>';
                ?>
            </ul>
        </div>        
    </div>
    <div class="row-fluid">
        <div class="span3">
            <a class="btn btn-inverse btn-small" href="/">
                <i class="icon-white icon-arrow-left"></i>
                Regresar al inicio
            </a>
        </div>
    </div>
</div>



<?php
require_once('layout/foot.php');
?>
            