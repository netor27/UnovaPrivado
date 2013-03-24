<?php
require_once ('layout/headers/headInicio.php');
require_once ('layout/headers/headListaCursos.php');
require_once ('layout/headers/headCierre.php');
?>

<?php
$columna = 1;
$fila = 1;
if (isset($cursos)) {
    ?>
    <div class="row-fluid">
        <div class="span12">
            <h3>Cursos a los que estoy inscrito (<?php echo sizeof($cursos) ?>)</h3>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <?php
            $i = 0;
            foreach ($cursos as $curso) {
                if ($i % 2 == 0) {
                    echo '<div class="row-fluid">';
                }
                ?>
                <div class="span6 well well-small cursoContainer">
                    <div class="row-fluid">
                        <div class="span12">
                            <legend>
                                <a href="/curso/<?php echo $curso->uniqueUrl . '&b=' . getRequestUri(); ?>"  class="tituloCurso">
                                    <h4 class="centerText"><?php echo $curso->titulo; ?></h4>
                                </a>
                            </legend>
                        </div>
                    </div>
                    <div class="row-fluid" style="margin-bottom:10px;">
                        <div class="span4">
                            <a href="/curso/<?php echo $curso->uniqueUrl . '&b=' . getRequestUri(); ?>">
                                <img src="<?php echo $curso->imagen; ?>" class="img-polaroid span12">
                                <button class="btn btn-mini offset3 span6">Ver curso</button>
                            </a>
                        </div>
                        <div class="span8">
                            <div class="row-fluid">
                                <strong>Autor:</strong>
                                <a href="/usuario/<?php echo $curso->uniqueUrlUsuario . '&b=' . getRequestUri(); ?>">
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
                            <div class="row-fluid">

                            </div>
                        </div>
                    </div>
                    <?php
                    $clasesCompletadas = $curso->numeroDeTomadas;
                    $clasesTotales = $curso->numeroDeClases;
                    if ($clasesTotales != 0)
                        $porcentaje = $clasesCompletadas / $clasesTotales * 100;
                    else
                        $porcentaje = 0;
                    ?>
                    <div class="row-fluid">
                        <p>
                            <strong>Avance:</strong>                                    
                            <?php
                            echo "$clasesCompletadas de $clasesTotales clases";
                            ?>
                        </p>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="progress">
                                <div class="bar" style="width: <?php echo $porcentaje . "%"; ?>;"></div>
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
            ?>          
        </div>
    </div>
    <div class="pagination pagination-centered">
        <ul>
            <?php
            if ($pagina > 1)
                echo '<li><a href="/usuarios/cursos/inscrito&p=' . ($pagina - 1) . '">«</a></li>';
            else
                echo '<li class="disabled"><a href="#">«</a></li>';

            for ($i = 1; $i <= $maxPagina; $i++) {
                if ($i == $pagina)
                    echo '<li class="active"><a href="#">' . $i . '</a></li>';
                else
                    echo '<li><a href="/usuarios/cursos/inscrito&p=' . $i . '">' . $i . '</a></li>';
            }

            if ($pagina < $maxPagina)
                echo '<li><a href="/usuarios/cursos/inscrito&p=' . ($pagina + 1) . '">»</a></li>';
            else
                echo '<li class="disabled"><a href="#">»</a></li>';
            ?>
        </ul>
    </div>
    </div>
    <?php
}else {
    ?>
    <div class="row-fluid">
        <div class="span12 centerText">
            <h2>Aún no estas inscrito a ningún curso<br> Regresa más tarde</h2>
        </div>
    </div>
    <?php
}
?>
<?php
if ($usuario->tipoUsuario != 0) {
    ?>
    <div class="row-fluid">
        <div class="span3 subir20px">
            <a class="btn btn-inverse btn-small" href="/">
                <i class="icon-white icon-arrow-left"></i>
                Regresar al inicio
            </a>
        </div>
    </div>
    <?php
}
?>
<?php
require_once('layout/foot.php');
?>
