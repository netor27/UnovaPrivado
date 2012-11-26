<?php

$idClase = $_GET['idClase'];
$path = "archivos/extraMedia/" . $idClase . "/";

$i = 0;
echo 'Archivos en ' . $path . ':<br><br>';

$pathInfo = null;

foreach(glob($path . "*") as $file){
    echo $i . " => ". $file . '<br>';
    $pathInfo = pathinfo($file);
    echo "File Name = " . $pathInfo['filename'] . '<br>';
}
?>