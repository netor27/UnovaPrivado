<?php

function archivoDeClase() {
    $idClase = $_GET['i'];
    require_once 'modulos/cursos/modelos/ClaseModelo.php';
    $clase = getClase($idClase);

    $quiereArchivo2 = false;
    if (isset($_GET['j'])) {
        //si esta variable existe es porque se trata de un audio o un video y es para elegir
        //el archivo 1 o 2 de la clase
        if ($_GET['j'] == 2 &&
                ($clase->idTipoClase == 0 ||
                $clase->idTipoClase == 4)) {
            $quiereArchivo2 = true;
        }
    }
    $file_path = "error en filepath";
    if (isset($clase)) {
        require_once 'modulos/archivos/modelos/descargaModelo.php';
        if ($quiereArchivo2) {
            $file_path = $clase->archivo2;
        } else {
            $file_path = $clase->archivo;
        }
        descargarArchivo($file_path);
    } else {
        echo 'El archivo que buscas no existe';
    }
}

?>