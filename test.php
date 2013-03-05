<?php

require_once 'funcionesPHP/funcionesGenerales.php';
require_once 'modulos/aws/modelos/sesModelo.php';

$text = "Este es un texto de prueba";
$html = "Este es el html Los mails con html funcionan";
$subject = "Mail de prueba";
$from = "Unova-noreply@unova.mx";

$to[] = "neto.r27@gmail.com";
$to[] = "neto_r27@hotmail.com";
$to[] = "calvises@yahoo.com";

if (sendMail($text, $html, $subject, $from, $to)) {
    echo 'Se envio el correo';
} else {
    echo '<br>';
    echo 'Error al enviar';
}