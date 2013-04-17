<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headIndexAdministradorPrivado.php');
require_once('layout/headers/headCierre.php');
?>
<div class="row-fluid">
    <div class="span12 well">
        <div class="row-fluid">
            <div class="span12">
                <legend>
                    <h4 class="blue">Página de inicio </h4>
                </legend>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span4" id="cursos">
                <a href="/cursos">
                    <div class="row-fluid hidden-phone">
                        <img class="span12 img-polaroid img-index" src="/layout/imagenes/index/cursos.jpg">
                    </div>
                    <div class="row-fluid margin-top10">
                        <button class="btn btn-large btn-info span12" >Administrar Cursos</button>
                    </div>                    
                </a>
            </div>
            <div class="span4"id="alumnos">
                <a href="/alumnos">
                    <div class="row-fluid hidden-phone">
                        <img class="span12 img-polaroid img-index" src="/layout/imagenes/index/students.jpg">
                    </div>
                    <div class="row-fluid margin-top10">
                        <button class="btn btn-large btn-info span12" >Administrar Alumnos</button>
                    </div>        
                </a>
            </div>
            <div class="span4"id="profesores">
                <a href="/profesores">
                    <div class="row-fluid hidden-phone">
                        <img class="span12 img-polaroid img-index" src="/layout/imagenes/index/professor.jpg">
                    </div>
                    <div class="row-fluid margin-top10">
                        <button class="btn btn-large btn-info span12" >Administrar Profesores</button>
                    </div>        
                </a>
            </div>
        </div>
        <div class="row-fluid margin-top20">
            <div class="span4"id="grupos">
                <a href="/grupos">
                    <div class="row-fluid hidden-phone">
                        <img class="span12 img-polaroid img-index" src="/layout/imagenes/index/groups.jpg">
                    </div>
                    <div class="row-fluid margin-top10">
                        <button class="btn btn-large btn-info span12" >Administrar Grupos</button>
                    </div>        
                </a>
            </div>
            <div class="span4"id="administradores">
                <a  href="/administradores">
                    <div class="row-fluid hidden-phone">
                        <img class="span12 img-polaroid img-index" src="/layout/imagenes/index/administrador.jpg">
                    </div>
                    <div class="row-fluid margin-top10">
                        <button class="btn btn-large btn-info span12">Otros Administradores</button>
                    </div>        
                </a>
            </div>
            <div class="span4"id="estadisticas">
                <a href="/estadisticasDeUso">
                    <div class="row-fluid hidden-phone">
                        <img class="span12 img-polaroid img-index" src="/layout/imagenes/index/stadistics.jpg">
                    </div>
                    <div class="row-fluid margin-top10">
                        <button class="btn btn-large btn-info span12" >Estadísticas de uso</button>
                    </div>        
                </a>
            </div>
        </div>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>
            
