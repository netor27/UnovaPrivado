<?php
require_once ('layout/headers/headInicio.php');
require_once ('layout/headers/headListaCursos.php');
require_once ('layout/headers/headCierre.php');
?>


<div class="contenido">

    <div class="cursosContainer">
        <h1><?php echo $titulo; ?></h1>
        <ul>
            <?php
            if (isset($cursos) && !is_null($cursos)) {
                foreach ($cursos as $curso) {
                    ?>
                    <li>
                        <a href="/curso/<?php echo $curso->uniqueUrl . '&b=' . getRequestUri(); ?>">
                            <div class="thumb" style="background: url(<?php echo $curso->imagen; ?>);">
                            </div>
                        </a>
                        <div class="detalles">
                            <?php
                            echo '<a href="/curso/' . $curso->uniqueUrl . '&b='. getRequestUri() .'">' . $curso->titulo . '</a>';
                            echo '<br><span class="autor"> Hecho por <a href="/usuario/' . $curso->uniqueUrlUsuario . '&b=' . getRequestUri() . '">' . $curso->nombreUsuario . '  </a></span>';
                            echo '<br><span class="descripcionCorta">' . $curso->descripcionCorta . '</span>';
                            ?>                    
                        </div>
                        <div class="numDetalles numAlumnos">                    
                            <?php echo $curso->numeroDeAlumnos; ?>
                            <span>Alumnos</span>
                        </div>
                        <div class="numDetalles numClases">
                            <?php echo $curso->numeroDeClases; ?>
                            <span>Clases</span>
                        </div>
                    </li>
                    <?php
                }
            } else {
                echo '<li><h2>oops! nada por aquí!</h2></li>';
            }
            ?>
        </ul>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>
