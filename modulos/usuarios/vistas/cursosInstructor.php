<?php
require_once ('layout/headers/headInicio.php');
require_once ('layout/headers/headListaCursos.php');
require_once ('layout/headers/headCierre.php');
?>

<div class="container">
    <div class="contenido">
        <div class="row-fluid">
            <div class="span5">
                <h4 >Eres profesor en <?php echo $numCursos; ?> cursos</h4>
            </div>
            <div class="span4 offset3">
                <div style="padding-top: 20px;">
                    <a href="/usuarios/cursos/responderPreguntas" class="btn btn-primary">Responder las preguntas pendientes</a>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12"></div>
        </div>
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
                        if ($i % 3 == 0) {
                            echo '<ul class="thumbnails">';
                        }
                        ?>
                        <li class="span4">
                            <div class="thumbnail">
                                <a href="/curso/<?php echo $curso->uniqueUrl; ?>"><h3 class="centerText"><?php echo $curso->titulo; ?></h3></a>
                                <img src="<?php echo $curso->imagen; ?>" class="img-polaroid">
                                <div class="caption">                                    
                                    <div class="row-fluid">
                                        <legend>
                                            <strong>Autor:</strong> 
                                            <a href="/usuario/<?php echo $curso->uniqueUrlUsuario; ?>">
                                                <?php echo $curso->nombreUsuario; ?>
                                            </a>
                                        </legend>
                                    </div>
                                    <div class="row-fluid centerText">
                                        <div class="span6">
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
                                        </div>
                                        <div class="span6">
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
                                    </div>
                                    <p>
                                        <strong>Descripción</strong>
                                    </p>
                                    <p class="descripcion">
                                        <?php echo $curso->descripcionCorta; ?>
                                    </p>
                                    <?php
                                    if (tipoUsuario() == "administradorPrivado") {
                                        ?>
                                        <div class="row-fluid">
                                            <div class="btn-group span9">
                                                <a class="btn  btn-small btn-primary dropdown-toggle" data-toggle="dropdown" >
                                                    <i class="icon-pencil icon-white"></i>
                                                    <span class="caret"></span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="/cursos/curso/alumnos/<?php echo $curso->idCurso . "&pc=" . $pagina; ?>"><i class="icon-user"></i> Editar usuarios inscritos</a></li>
                                                    <li><a href="/grupos/cursos/asignados/<?php echo $curso->idCurso; ?>"><i class="icon-globe"></i> Editar grupos asignados</a></li>
                                                </ul>
                                            </div>                                            
                                            <div class="btn-group span3">
                                                <a class="btn  btn-small btn-danger dropdown-toggle" data-toggle="dropdown" >
                                                    <i class="icon-trash icon-white"></i>
                                                    <span class="caret"></span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="borrarCurso" id="<?php echo $curso->idCurso; ?>"><i class="icon-fire"></i> Eliminar</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                            if ($i % 3 == 2) {
                                echo '</ul>';
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
            <div class="row-fluid">
                <div class="span12">

                </div>
                <div class="span12 centerText">
                    <h2>Aún no créas ningún curso</h2>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>