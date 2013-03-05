<?php

//Load de sdk
require_once 'vendor/autoload.php';

use Aws\Common\Aws;

function sendMailSES($text, $html, $subject, $from, $to = array()) {
    $text = utf8_decode($text);
    $html = utf8_decode($html);
    $subject = utf8_decode($subject);
    try {
        $client = Aws::factory(getServerRoot() . '/modulos/aws/modelos/configurationFile.php')->get('ses');
        echo 'Se creo el cliente<br>';
        $messageId = $client->sendEmail(array(
            'Source' => $from,
            'Destination' => array(
                'ToAddresses' => $to
            ),
            'Message' => array(
                'Subject' => array(
                    'Data' => $subject
                ),
                'Body' => array(
                    'Text' => array(
                        'Data' => $text
                    ),
                    'Html' => array(
                        'Data' => $html
                    )
                ),
            )
                )
        );
        return true;
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

?>