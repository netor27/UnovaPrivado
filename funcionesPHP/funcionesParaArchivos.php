<?php

function agregarUniqueCodeAlNombreDelArchivo(&$filePath, &$fileName, $maxLength = 200, $uniqueCodeLength = 7) {
    //Validamos que la cadena del archivo no séa mayor que $maxLength
    $file = $filePath . $fileName;
    $pathInfo = pathinfo($file);

    $aux = $pathInfo['filename'];
    if ((strlen($file) + $uniqueCodeLength) > $maxLength) {
        $longitud = $maxLength - (strlen($file) + $uniqueCodeLength + 1);
        $aux = substr($pathInfo['filename'], 0, $longitud);
    }

    //Agregamos el codigo al final del nombre y antes de la extension
    $fileName = $aux . "_" . getUniqueCode($uniqueCodeLength) . "." . $pathInfo['extension'];

    //Validamos que el archivo no exista previamente
    while (file_exists($filePath . $fileName)) {
        //tratamos con otro nombre hasta que uno de ellos no exista
        $fileName = $aux . "_" . getUniqueCode($uniqueCodeLength) . "." . $pathInfo['extension'];
    }
    return rename($file, $filePath . $fileName);
}

function getFileSize($file) {
    $size = filesize($file);
    if ($size < 0) {
        $size = fsize($file);
    }
}

function fsize($file) {
    // filesize will only return the lower 32 bits of
    // the file's size! Make it unsigned.
    $fmod = filesize($file);
    if ($fmod < 0)
        $fmod += 2.0 * (PHP_INT_MAX + 1);

    // find the upper 32 bits
    $i = 0;

    $myfile = fopen($file, "r");

    // feof has undefined behaviour for big files.
    // after we hit the eof with fseek,
    // fread may not be able to detect the eof,
    // but it also can't read bytes, so use it as an
    // indicator.
    while (strlen(fread($myfile, 1)) === 1) {
        fseek($myfile, PHP_INT_MAX, SEEK_CUR);
        $i++;
    }

    fclose($myfile);

    // $i is a multiplier for PHP_INT_MAX byte blocks.
    // return to the last multiple of 4, as filesize has modulo of 4 GB (lower 32 bits)
    if ($i % 2 == 1)
        $i--;

    // add the lower 32 bit to our PHP_INT_MAX multiplier
    return ((float) ($i) * (PHP_INT_MAX + 1)) + $fmod;
}

function borrarArchivo($fileName) {
    $fileName = substr($fileName, 1); //Eliminamos la primera / del nombre del archivo
    if (!unlink($fileName)) {
        //no se borró el archivo
        //Se guarda como pendiente de borrar.
        require_once 'modulos/principal/modelos/variablesDeProductoModelo.php';
        agregarArchivoPendientePorBorrar($fileName);
    }
}

?>