<?php
//require_once 'funcionesPHP/funcionesGenerales.php';
//require_once 'modulos/aws/modelos/sqsModelo.php';

//$message = '{"bucket":"unovaTesting","key":"porTransformar\/380269367483a031f1557667400c5af70fb53469cd721188ee3593123a2678f74c3d323d62720ac95a490deba8e6b438b6dc66dda161cb312c3e2d5fdab92860a83eee29176811474254c4.mp3","tipo":4,"host":"privado.localhost","idClase":115}';
//AddMessageToQueue($message);

//$mensaje = readMessageFromQueue();
//
//print_r($mensaje);
//echo '<br>';
//$body = json_decode($mensaje['Body']);
//echo 'bucket => ' . $body->bucket;
//echo '<br>';
//print_r($body);
//echo '<br>';    
//deleteMessageFromQueue($mensaje['ReceiptHandle']);

echo $_GET['msg'];
echo '<br>';
echo '<br>';
echo '<br>';
$msg = $_GET['msg'];
$msg = json_decode($msg);
print_r($msg);