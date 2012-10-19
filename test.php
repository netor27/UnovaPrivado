<?php

function using_ie() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $ub = False;
    if (preg_match('/MSIE/i', $u_agent)) {
        $ub = True;
    }

    return $ub;
}

if (using_ie()) {
    echo 'ES INTERNET EXPLORER';
} else {
    echo 'NO es internet explorer';
}

//require_once 'modulos/transformador/modelos/archivoPorTransformarModelo.php';
//$id = altaArchivoPorTransformar(0, 12, "temp.mp4");
//echo "se dió de alta el id " . $id . '<br>';
//modificarArchivoEstadoMensaje($id, "nuevo estado", "nuevo mensaje");
//$archivo = getArchivoPorTransformar($id);
//echo "idArchivo = " . $archivo['idArchivo'] . '<br>';
//echo "idTipoClase = " . $archivo['idTipoClase'] . '<br>';
//echo "idClase = " . $archivo['idClase'] . '<br>';
//echo "archivo = " . $archivo['archivo'] . '<br>';
//echo "estado = " . $archivo['estado'] . '<br>';
//echo "mensaje = " . $archivo['mensaje'] . '<br>';

ob_start();
passthru('avconv -i "archivos/temporal/uploaderFiles/Module Main Menu.mov" 2>&1');
$duration = ob_get_contents();
ob_end_clean();

$search = '/Duration: (.*?),/';
$duration = preg_match($search, $duration, $matches, PREG_OFFSET_CAPTURE);
if (isset($matches[1]) && isset($matches[1][0])) {
    $duration = $matches[1][0];
} else {
    $duration = "00:00:00";
}


$exploded = explode(':', $duration);
switch (sizeof($exploded)) {
    case 0:
    case 1:
        $hours = 0;
        $mins = 0;
        $secs = 0;
        break;
    case 2:
        $hours = 0;
        $mins = $exploded[0];
        $secs = $exploded[1];
        break;
    case 3:
    case 4:
        $hours = $exploded[0];
        $mins = $exploded[1];
        $secs = $exploded[2];
        break;
    default:
        $hours = 0;
        $mins = 0;
        $secs = 0;
        break;
}

$mins = $mins + ($hours * 60);
if ($mins < 10) {
    $mins = '0' . $mins;
}
$secs = substr($secs, 0, 2);
$duration = $mins . ":" . $secs;

echo "<br><br>Duration = " . $duration;
?>