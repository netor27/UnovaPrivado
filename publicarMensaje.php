<?php

require_once 'funcionesPHP/funcionesGenerales.php';

if (isset($_GET['key']) && isset($_GET['msg'])) {
    if ($_GET['key'] == 'er105706') {
        $msg = $_GET['msg'];
        //$msgDecoded = json_decode($msg);
        require_once 'modulos/aws/modelos/sqsModelo.php';
        if(AddMessageToQueue($msg)){
            Echo 'Se publico el mensaje en Amazon SQS';
        }
    } else {
        require_once 'errorPages/404Page.php';
    }
} else {
    require_once 'errorPages/404Page.php';
}
?>