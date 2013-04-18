<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headCierre.php');
?>
<div class="row-fluid">    
    <div class="span12 well well-small">
        <legend>
            <h3 class="blue">
                Bienvenido a Unova
            </h3>
        </legend>
        <div class="row-fluid">
            <div class="span12">
                <div class="centerText">
                    <h4 class="black">Eres un profesor en Unova, puedes impartir cursos y tomar clases de otros profesores.</h4>
                    <div class="row-fluid"><div class="span12"><h6></h6></div></div>
                    <div class="row-fluid">
                        <div class="span12">
                            <a class="btn btn-primary btn-large span4 offset1 " href="/usuarios/cursos/instructor" style="font-weight: bolder;">
                                Cursos que <br>imparto
                            </a>
                            <div class="span2">
                                <h6></h6>
                            </div>
                            <a class="btn btn-primary btn-large span4  " href="/usuarios/cursos/inscrito" style="font-weight: bolder;">
                                Cursos que <br>estoy inscrito
                            </a>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
        <div class="row-fluid"><div class="span12"><h6></h6></div></div>
        <div class="row-fluid"><div class="span12"><h6></h6></div></div>
    </div>    
</div>

<?php
require_once('layout/foot.php');
?>
            