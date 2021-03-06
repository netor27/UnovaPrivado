<?php
require_once ('layout/headers/headInicio.php');
require_once ('layout/headers/headListaCursos.php');
require_once ('layout/headers/headCierre.php');
?>
<div class="row-fluid">
    <div class="span3 offset9">
        <a href="/cursos/curso/crearCurso" class="btn span12">
            <i class="icon-plus"></i>
            Crea un curso
        </a>
    </div>
</div>
<div class="row-fluid"><h6></h6></div>
<div class="row-fluid">
    <div class="span12 well well-small">
        <legend>
            <h4 class="blue">Cursos que impartes</h4>
        </legend>
        <?php
        if (isset($cursos)) {
            $columna = 1;
            $fila = 1;
            ?>
            <div class="row-fluid">
                <div class="span12">
                    <?php
                    $i = 0;

                    foreach ($cursos as $curso) {
                        if ($i % 2 == 0) {
                            echo '<div class="row-fluid">';
                        }
                        ?>
                        <div class="span6 well well-small cursoContainer ease3 whiteBackground">
                            <div class="row-fluid">
                                <div class="span12">
                                    <legend>
                                        <a href="/curso/<?php echo $curso->uniqueUrl; ?>" class="tituloCurso">
                                            <h4 class="centerText"><?php echo $curso->titulo; ?></h4>
                                        </a>
                                    </legend>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span4 centerText">
                                    <a href="/curso/<?php echo $curso->uniqueUrl; ?>">
                                        <img class="hidden-phone img-polaroid span12" src="<?php echo $curso->imagen; ?>">
                                        <img class="visible-phone imageSmallPhone img-polaroid span12" src="<?php echo $curso->imagen; ?>">
                                        <button class="btn btn-mini offset3 span6" style="margin-top:5px;">Ver curso</button>
                                    </a>
                                </div>
                                <div class="span8">
                                    <div class="row-fluid">
                                        <strong>Autor:</strong>
                                        <a href="/usuario/<?php echo $curso->uniqueUrlUsuario; ?>">
                                            <?php echo $curso->nombreUsuario; ?>
                                        </a>
                                    </div>
                                    <div class="row-fluid">
                                        <p>
                                            <?php
                                            if ($curso->numeroDeAlumnos == 0) {
                                                echo 'No tiene alumnos';
                                            } else if ($curso->numeroDeAlumnos == 1)
                                                echo 'Un alumno';
                                            else
                                                echo $curso->numeroDeAlumnos . " alumnos";
                                            ?>
                                        </p>
                                        <p>
                                            <?php
                                            if ($curso->numeroDeClases == 0) {
                                                echo 'No hay clases';
                                            } else if ($curso->numeroDeClases == 1)
                                                echo 'Una clase';
                                            else
                                                echo $curso->numeroDeClases . " clases";
                                            ?>
                                        </p>
                                    </div>
                                    <div class="row-fluid">
                                        <p class="descripcion">
                                            <strong>Descripción: </strong>
                                            <?php echo $curso->descripcionCorta; ?>
                                        </p>
                                    </div>
                                    <?php
                                    if ($usuario->tipoUsuario == 2) {
                                        ?>
                                        <div class="row-fluid">
                                            <div class="btn-group span3 offset6">
                                                <a class="btn btn-small btn-primary dropdown-toggle" data-toggle="dropdown">
                                                    <i class="icon-pencil icon-white"></i>  Administrar
                                                    <span class="caret"></span>
                                                </a>     
                                                <ul class="dropdown-menu">
                                                    <li><a href="/cursos/curso/alumnos/<?php echo $curso->idCurso; ?>"><i class="icon-user"></i> Editar usuarios inscritos</a></li>
                                                    <li><a href="/grupos/cursos/asignados/<?php echo $curso->idCurso; ?>"><i class="icon-globe"></i> Editar grupos asignados</a></li>
                                                    <li class="divider"></li>
                                                    <li><a class="borrarCurso" id="<?php echo $curso->idCurso; ?>"><i class="icon-fire"></i> Eliminar curso</a></li>
                                                </ul>                                                
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($i % 2 == 1) {
                            echo '</div>';
                        }
                        $i++;
                    }
                    ?>          
                </div>
            </div>
            <div class="pagination pagination-centered">
                <ul>
                    <?php
                    if ($pagina > 1)
                        echo '<li><a href="/usuarios/cursos/instructor&p=' . ($pagina - 1) . '">«</a></li>';
                    else
                        echo '<li class="disabled"><a >«</a></li>';

                    for ($i = 1; $i <= $maxPagina; $i++) {
                        if ($i == $pagina)
                            echo '<li class="active"><a >' . $i . '</a></li>';
                        else
                            echo '<li><a href="/usuarios/cursos/instructor&p=' . $i . '">' . $i . '</a></li>';
                    }

                    if ($pagina < $maxPagina)
                        echo '<li><a href="/usuarios/cursos/instructor&p=' . ($pagina + 1) . '">»</a></li>';
                    else
                        echo '<li class="disabled"><a >»</a></li>';
                    ?>
                </ul>
            </div>
            <?php
        }else {
            ?>
            <h3 class="centerText">Aún no has creado ningún curso</h3>
            <div class="span6 offset3">
                <a href="/cursos/curso/crearCurso" class="btn btn-primary btn-large span12" style="font-weight: bolder;">
                    <i class="icon-plus icon-white"></i>
                    Crea un curso aquí
                </a>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>