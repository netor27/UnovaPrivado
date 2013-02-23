<?php

//Load de sdk
require_once 'vendor/autoload.php';

//Para acceder al S3
use Aws\Common\Aws;
use Aws\Sqs\Exception\SqsException;

function getQueueUrl() {
    return "https://sqs.us-east-1.amazonaws.com/023247576146/testingQueue";
}

function AddMessageToQueue($message) {
    $client = Aws::factory('modulos/aws/modelos/configurationFile.php')->get('sqs');

    $res = $client->sendMessage(array(
        'QueueUrl' => getQueueUrl(),
        'MessageBody' => $message,
            ));
    $arrayRes = $res->toArray();
    $resultado = false;
    if (isset($arrayRes['MessageId'])) {
        if (strlen($arrayRes['MessageId']) > 0) {
            $resultado = true;
        }
    }
    return $resultado;
}

function readMessageFromQueue() {
    $client = Aws::factory('modulos/aws/modelos/configurationFile.php')->get('sqs');
    $result = $client->receiveMessage(array(
        'QueueUrl' => getQueueUrl(),
        'MaxNumberOfMessages' => 1,
        'VisibilityTimeout' => 3600,
        'WaitTimeSeconds' => 20
            ));

    $aux = $result->toArray();
    $resultado = null;
    if (count($aux['Messages']) > 0) {
        //Si leyó más de un mensaje, sólo regresamos el último
        //Es raro que pase, pero hay que validar
        foreach ($aux['Messages'] as $message) {
            $resultado = $message;
        }
    }
    return $resultado;
}

function deleteMessageFromQueue($receiptHandle) {
    $client = Aws::factory('modulos/aws/modelos/configurationFile.php')->get('sqs');
    $res = false;
    try {
        $res = $client->deleteMessage(array(
            'QueueUrl' => getQueueUrl(),
            'ReceiptHandle' => $receiptHandle
                ));
        return true;
    } catch (SqsException $e) {
        //Ocurrió un error al borrar el mensaje
        return false;
    }
}

?>