<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headBootstrap.php');
require_once('layout/headers/headCierre.php');
?>

<div class="container-fluid">
    <div class="span12">
        <h1></h1>
    </div>

    <div class="row-fluid">

        <div class="span3 well well-large">
            <div class="row-fluid">
                <div class="span12">
                    <legend>
                        Administrador
                    </legend>
                </div>
            </div>
            <!--Sidebar content-->
            <div class="row-fluid">
                <div class="span12">
                    <a class="btn btn-large btn-primary span12" href="/cursos">Cursos</a>
                </div>
            </div>
            <div class="row-fluid"><div class="span12"></div></div>
            <div class="row-fluid">
                <div class="span12">
                    <a class="btn btn-large btn-primary span12" href="/alumnos">Alumnos</a>
                </div>
            </div>
            <div class="row-fluid"><div class="span12"></div></div>
            <div class="row-fluid">
                <div class="span12">
                    <a class="btn btn-large btn-primary span12" href="/profesores">Profesores</a>
                </div>
            </div>
            <div class="row-fluid"><div class="span12"></div></div>
            <div class="row-fluid">
                <div class="span12">
                    <a class="btn btn-large btn-primary span12" href="#">Grupos</a>
                </div>
            </div>
            <div class="row-fluid"><div class="span12"></div></div>
            <div class="row-fluid">
                <div class="span12">
                    <a class="btn btn-large btn-warning span12" href="/administradores">Administradores</a>
                </div>
            </div>
        </div>
        <div class="span9 well well-large">
            <!--Body content-->
            <div class="row-fluid">
                <div class="span12">
                    <legend>Estado del servicio</legend>
                </div>
            </div>
        </div>
    </div>
</div>







</div>
</div>
<?php
require_once('layout/foot.php');
?>
            