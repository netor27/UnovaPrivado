<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headIndexAdministradorPrivado.php');
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
                    <legend><h3>Administración</h3></legend>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4" id="cursos">
                    <a href="/cursos">
                        <img class="span12 img-polaroid img-index" src="/layout/imagenes/index/cursos.jpg">
                        <button class="btn btn-large btn-info span12" >Administrar Cursos</button>
                    </a>
                </div>
                <div class="span4"id="alumnos">
                    <a href="/alumnos">
                        <img class="span12 img-polaroid img-index" src="/layout/imagenes/index/students.jpg">
                        <button class="btn btn-large btn-info span12" >Administrar Alumnos</button>
                    </a>
                </div>
                <div class="span4"id="profesores">
                    <a href="/profesores">
                        <img class="span12 img-polaroid img-index" src="/layout/imagenes/index/professor.jpg">
                        <button class="btn btn-large btn-info span12" >Administrar Profesores</button>
                    </a>
                </div>
            </div>
            <div class="container">
                <div class="span12"></div>
            </div>
            <div class="row-fluid">
                <div class="span4"id="grupos">
                    <a href="/grupos">
                        <img class="span12 img-polaroid img-index" src="/layout/imagenes/index/grupos.jpg">
                        <button class="btn btn-large btn-info span12" >Administrar Grupos</button>
                    </a>
                </div>
                <div class="span4"id="administradores">
                    <a  href="/administradores">
                        <img class="span12 img-polaroid img-index" src="/layout/imagenes/index/administrador.jpg">
                        <button class="btn btn-large btn-info span12">Otros Administradores</button>
                    </a>
                </div>
                <div class="span4"id="estadisticas">
                    <a href="/estadisticasDeUso">
                        <img class="span12 img-polaroid img-index" src="/layout/imagenes/index/stadistics.jpg">
                        <button class="btn btn-large btn-info span12" >Estadísticas de uso</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>
            
