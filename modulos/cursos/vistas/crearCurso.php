<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headCrearCurso.php');
require_once('layout/headers/headCierre.php');
?>


<div class="contenido">
    <div class="left centerText" style="width: 890px">
        <h1 class="centerText">Crea un curso</h1>    
        <h5>Tu curso será creado pero no publicado hasta que lo decidas.</h5>
        <br><br>
        <?php
        if (isset($error) && $error != "") {
            echo '<h5 class="error centerText">' . $error . '</h5>';
        }
        if (isset($info) && $info != "") {
            echo '<h5 class="info centerText">' . $info . '</h5>';
        }
        ?>
        <div id="formDiv" style="width:700px;" >  
            <form method="post" id="customForm" action="/cursos/curso/crearCursoSubmit">  
                <div>  
                    <label for="titulo">Título</label>  
                    <input id="titulo" name="titulo" type="text" style="width:350px;"/>                          
                    <span id="tituloInfo">Título de tu curso</span>  
                </div>  
                <div>  
                    <label for="descripcionCorta">Descripción Corta</label>  
                    <textarea id="descripcionCorta" name="descripcionCorta"></textarea>                        
                    <br>
                    <span id="descripcionCortaInfo">Escribe una descripción corta de tu curso.</span>  
                </div>   
                <div>  
                    <input id="send" name="send" type="submit" value="  Aceptar  " />  
                </div> 
            </form>  
        </div>
    </div>
</div>
</div>

<?php
require_once('layout/foot.php');
?>
            