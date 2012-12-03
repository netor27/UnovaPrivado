<?php

require_once 'modulos/cursos/modelos/ClaseModelo.php';
$idUsuario = $_GET['usuario'];
$i = 0;
$total = 0;
for ($i = 80; $i < 100; $i++) {
    $idClase = $i;
    if (registrarClaseTomada($idUsuario, $idClase)) {
        echo 'Se registro correctamente <br>';
        $total++;
    } else {
        echo 'No se registro <br>';
    }    
}
echo '<br>Se agregaron ' . $total . ' registros';
?>