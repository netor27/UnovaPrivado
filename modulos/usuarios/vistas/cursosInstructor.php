<?php
require_once ('layout/headers/headInicio.php');
require_once ('layout/headers/headBootstrap.php');
require_once ('layout/headers/headListaCursos.php');
require_once ('layout/headers/headCierre.php');
?>

<div class="contenido">    
    <div class="row-fluid">
        <div class="span5">
            <h4 style="text-align: center;">Eres profesor en <?php echo $numCursos; ?> cursos</h4>
        </div>
        <div class="span4 offset3">
            <h4>
                <a href="/usuarios/cursos/responderPreguntas" class="btn btn-primary">Responder las preguntas pendientes</a>
            </h4>
        </div>
    </div>

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
                    echo '<li><a href="/usuarios/cursos/instructor:p=' . ($pagina - 1) . '">«</a></li>';
                else
                    echo '<li class="disabled"><a href="#">«</a></li>';

                for ($i = 1; $i <= $maxPagina; $i++) {
                    if ($i == $pagina)
                        echo '<li class="active"><a href="#">' . $i . '</a></li>';
                    else
                        echo '<li><a href="/usuarios/cursos/instructor:p=' . $i . '">' . $i . '</a></li>';
                }

                if ($pagina < $maxPagina)
                    echo '<li><a href="/usuarios/cursos/instructor:p=' . ($pagina + 1) . '">»</a></li>';
                else
                    echo '<li class="disabled"><a href="#">»</a></li>';
                ?>
            </ul>
        </div>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>
