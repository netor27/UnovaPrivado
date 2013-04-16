<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headCierre.php');
?>
<div class="left centerText" style="width: 890px">
    <h3 class="blue">Agregar tarjetas</h3>    
    <div id="formDiv" style="width:700px;" >  
        <form method="post" id="customForm" action="/cursos/clase/agregarTarjetasSubmit" enctype="multipart/form-data">  
            <input type="hidden" name="idCaja" value="1">
            <input type="file" id="archivoCsv" name="archivoCsv">
            <br>
            <input type="submit" >
        </form>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>
