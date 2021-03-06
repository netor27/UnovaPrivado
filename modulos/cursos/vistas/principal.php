<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headListaCursos.php');
require_once('layout/headers/headCierre.php');
?>
<div class="row-fluid">
    <div class="span3 offset9">        
        <a href="/cursos/curso/crearCurso" class="btn span12">
            <i class="icon-plus"></i>
            Crea un curso
        </a>
    </div>
</div>
<div class="row-fluid"><h1></h1></div>
<div class="row-fluid">
    <div class="well well-small">        
        <legend>
            <h4 class="blue">Lista de todos los cursos</h4>
        </legend>
        <?php
        $columna = 1;
        $fila = 1;
        if (isset($cursos)) {
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
                                        <button class="btn btn-mini offset3 span6" style="margin-top: 5px;">Ver curso</button>
                                    </a>
                                </div>
                                <div class="span8">
                                    <div class="row-fluid">
                                        <p>
                                            <strong>Autor:</strong>
                                            <a href="/usuario/<?php echo $curso->uniqueUrlUsuario; ?>">
                                                <?php echo $curso->nombreUsuario; ?>
                                            </a>
                                        </p>
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
                                    <div class="row-fluid">
                                        <div class="btn-group span4 offset8">
                                            <a class="btn btn-small btn-primary dropdown-toggle" data-toggle="dropdown">
                                                <i class="icon-pencil icon-white"></i> Administrar
                                                <span class="caret"></span>
                                            </a>                                            
                                            <ul class="dropdown-menu">
                                                <li><a href="/cursos/curso/alumnos/<?php echo $curso->idCurso; ?>"><i class="icon-user"></i> Editar usuarios inscritos</a></li>
                                                <li><a href="/grupos/cursos/asignados/<?php echo $curso->idCurso; ?>"><i class="icon-globe"></i> Editar grupos asignados</a></li>
                                                <li class="divider"></li>
                                                <li><a class="borrarCurso" id="<?php echo $curso->idCurso; ?>" href="#"><i class="icon-fire"></i> Eliminar curso</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($i % 2 == 1) {
                            echo '</div>';
                        }
                        $i++;
                    }
                    if ($i % 2 == 1) {
                        echo '</div>';
                    }
                    ?>          
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <div class="pagination pagination-centered ">
                        <ul>
                            <?php
                            if ($pagina > 1)
                                echo '<li><a href="/cursos&p=' . ($pagina - 1) . '">«</a></li>';
                            else
                                echo '<li class="disabled"><a >«</a></li>';

                            for ($i = 1; $i <= $maxPagina; $i++) {
                                if ($i == $pagina)
                                    echo '<li class="active"><a >' . $i . '</a></li>';
                                else
                                    echo '<li><a href="/cursos&p=' . $i . '">' . $i . '</a></li>';
                            }

                            if ($pagina < $maxPagina)
                                echo '<li><a href="/cursos&p=' . ($pagina + 1) . '">»</a></li>';
                            else
                                echo '<li class="disabled"><a >»</a></li>';
                            ?>
                        </ul>                        
                    </div>
                </div>
            </div>
            <?php
        }else {
            ?>
            <div class="row-fluid">
                <h3>No hay cursos dados de alta</h3>
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
            