<?php

function sendMail($text, $html, $subject, $from, $to) {
    $text = utf8_decode($text);
    $html = utf8_decode($html);
    $subject = utf8_decode($subject);
    return sendMailConSwift($text, $html, $subject, $from, $to);
}

/*
  SMTP Username:
  AKIAIM6EJFSLCQGK4PMQ
  SMTP Password:
  ApaxbFcCEegA3YK3yW8fPLVX9I/mqzhEDnKlMvIM691S
 */

function sendMailConSwift($text, $html, $subject, $from, $to) {
    include_once "lib/php/swift/swift_required.php";
    $username = 'unovamx';
    $password = 'LanzamientoUnova2012';
    // Setup Swift mailer parameters
    $transport = Swift_SmtpTransport::newInstance('smtp.sendgrid.net', 587);
    $transport->setUsername($username);
    $transport->setPassword($password);
    $swift = Swift_Mailer::newInstance($transport);

    // Create a message (subject)
    $message = new Swift_Message($subject);

    // attach the body of the email
    $message->setFrom($from);
    $message->setBody($html, 'text/html');
    $message->setTo($to);
    $message->addPart($text, 'text/plain');

    // send message 
    $recipients = $swift->send($message, $failures);
    if ($recipients <= 0) {
        //echo "Something went wrong - ";
        //print_r($failures);
        $recipients = 0;
        return false;
    }
    return true;
}

?>