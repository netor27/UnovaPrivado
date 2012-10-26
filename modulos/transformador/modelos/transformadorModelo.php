<?php

/**
 * Description of transformador
 *
 * @author neto
 * 
 */
function transformarVideo($file) {
    $return_var = -1;
    $duration = obtenerDuracion($file);
    $pathInfo = pathinfo($file);

    require_once 'funcionesPHP/funcionesGenerales.php';
    $uniqueCode = getUniqueCode(7);

    $outputFileMp4 = $pathInfo['dirname'] . "/" . $pathInfo['filename'] . "_" . $uniqueCode . ".mp4";
    $outputFileOgv = $pathInfo['dirname'] . "/" . $pathInfo['filename'] . "_" . $uniqueCode . ".webm";

    $cmd = 'avconv -i "' . $file . '" -c:v libx264 -c:a libvo_aacenc "' . $outputFileMp4 . '" -c:v libvpx -c:a libvorbis "' . $outputFileOgv . '"';
    //putLog($cmd);
    ob_start();
    passthru($cmd, $return_var);
    $aux = ob_get_contents();
    ob_end_clean();

    return array("return_var" => $return_var, "duration" => $duration, "outputFileMp" => $outputFileMp4, "outputFileOg" => $outputFileOgv);
}

function transformarAudio($file) {
    $return_var = -1;
    $duration = obtenerDuracion($file);
    $pathInfo = pathinfo($file);

    require_once 'funcionesPHP/funcionesGenerales.php';
    $uniqueCode = getUniqueCode(7);

    $outputFileMp3 = $pathInfo['dirname'] . "/" . $pathInfo['filename'] . "_" . $uniqueCode . ".mp3";
    $outputFileOgg = $pathInfo['dirname'] . "/" . $pathInfo['filename'] . "_" . $uniqueCode . ".ogg";

    $cmd = 'avconv -i "' . $file . '" "' . $outputFileMp3 . '" -c libvorbis -ar 44100 -b 200k "' . $outputFileOgg . '"';
    //putLog($cmd);
    ob_start();
    passthru($cmd, $return_var);
    $aux = ob_get_contents();
    ob_end_clean();

    return array("return_var" => $return_var, "duration" => $duration, "outputFileMp" => $outputFileMp3, "outputFileOg" => $outputFileOgg);
}

function obtenerDuracion($file) {
    //Obtener la duración
    ob_start();
    passthru('avconv -i "' . $file . '" 2>&1');
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
    if ($mins < 10)
        $mins = '0' . $mins;
    $secs = substr($secs, 0, 2);
    $duration = $mins . ":" . $secs;
    return $duration;
}

?>