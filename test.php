<?php

require_once 'funcionesPHP/funcionesGenerales.php';
require_once 'modulos/aws/modelos/sqsModelo.php';
require_once 'modulos/aws/modelos/s3Modelo.php';

if (isset($_GET['a'])) {
    $accion = $_GET['a'];
} else {
    $accion = "publicar";
}

if ($accion === 'publicar') {
    $sourceFile = "archivos/temporal/uploaderFiles/VideoIpod3Sec.MOV";
    $bucket = getBucketName();
    $key = generateFileKey($sourceFile);

    $mensaje = array(
        'bucket' => $bucket,
        'key' => $key
    );
    $mensajeJson = json_encode($mensaje);
    echo $mensajeJson;
    echo '<br> Length ' . strlen($mensajeJson);
    echo '<br>';
    if (AddMessageToQueue($mensajeJson)) {
        echo 'Mensaje enviado';
    } else {
        echo 'Error al enviar el mensaje';
    }
} else if ($accion === 'leer') {
    $mensaje = readMessageFromQueue();
    if (isset($mensaje)) {
        $arrayMessage = json_decode($mensaje['Body']);
        echo 'bucket = ' . $arrayMessage->bucket;
        echo '<br>';
        echo 'key = ' . $arrayMessage->key;
        echo '<br>';
        $receiptHandle = $mensaje['ReceiptHandle'];
        echo '<br>Receipt Handle= ' . $receiptHandle;
        echo '<br>';
        echo '<br>';        
        if(deleteMessageFromQueue($receiptHandle)){
            echo 'se borro';
        }else{
            echo 'error al borrar';
        }
    } else {
        echo 'no hay mensaje';
    }
}
?>