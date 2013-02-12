<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headCierre.php');
?>

<div class="container">
    <div class="span12">
        <h1></h1>
    </div>

    <div class="row-fluid">
        <div class="span12 well well-large">
            <div class="row-fluid">
                <div class="span12">
                    <legend>
                        
                            Panel de control
                        
                    </legend>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4">
                    <img class="span12 img-polaroid img-index" src="/layout/imagenes/index/cursos.jpg">
                    <a class="btn btn-large btn-info span12" href="/cursos">Administrar Cursos</a>
                </div>
                <div class="span4">
                    <img class="span12 img-polaroid img-index" src="/layout/imagenes/index/students.jpg">
                    <a class="btn btn-large btn-info span12" href="/alumnos">Administrar Alumnos</a>
                </div>
                <div class="span4">

                    <img class="span12 img-polaroid img-index" src="/layout/imagenes/index/professor.jpg">
                    <a class="btn btn-large btn-info span12" href="/profesores">Administrar Profesores</a>
                </div>
            </div>
            <div class="container">
                <div class="span12"></div>
            </div>
            <div class="row-fluid">
                <div class="span4">
                    <img class="span12 img-polaroid img-index" src="/layout/imagenes/index/grupos.jpg">
                    <a class="btn btn-large btn-info span12" href="/grupos">Administrar Grupos</a>
                </div>
                <div class="span4">
                    <img class="span12 img-polaroid img-index" src="/layout/imagenes/index/administrador.jpg">
                    <a class="btn btn-large btn-info span12" href="/administradores">Administrar Usuarios Administradores</a>
                </div>
                <div class="span4">
                    <img class="span12 img-polaroid img-index" src="/layout/imagenes/index/stadistics.jpg">
                    <a class="btn btn-large btn-info span12" href="/estadisticasDeUso">Estadísticas de uso</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>
            