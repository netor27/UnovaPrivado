<?php

require_once 'funcionesPHP/funcionesGenerales.php';
require_once 'modulos/aws/modelos/sqsModelo.php';

//Generamos los datos del mensaje
$datosDelMensaje = array(
    "bucket" => "demoUnova",
    "key" => "porTransformar/clase_210.mpg",
    "tipo" => 0,
    "host" => "demo.unova.mx",
    "idClase" => 210
);
$datosJson = json_encode($datosDelMensaje);
if (AddMessageToQueue($datosJson)) {
    echo '<br>==================================';
    echo '<br>Se publico un mensaje:<br>';
    echo $datosJson;
}

//Generamos los datos del mensaje
$datosDelMensaje = array(
    "bucket" => "demoUnova",
    "key" => "porTransformar/clase_233.mpg",
    "tipo" => 0,
    "host" => "demo.unova.mx",
    "idClase" => 233
);
$datosJson = json_encode($datosDelMensaje);
if (AddMessageToQueue($datosJson)) {
    echo '<br>==================================';
    echo '<br>Se publico un mensaje:<br>';
    echo $datosJson;
}