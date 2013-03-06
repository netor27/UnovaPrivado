<?php

//Load de sdk
require_once 'vendor/autoload.php';

use Aws\Common\Aws;

function sendMailSES($text, $html, $subject, $from, $to = array()) {
    try {
        $client = Aws::factory(getServerRoot() . '/modulos/aws/modelos/configurationFile.php')->get('ses');
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
        return false;
    }
}

?>