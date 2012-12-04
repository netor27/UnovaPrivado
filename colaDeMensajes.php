<?php
//
// Key = er105706 
//
$key = "";
if (isset($_GET['key'])) {
    $key = $_GET['key'];
}
if ($key == "er105706") {
    require_once('lib/php/beanstalkd/ColaMensajes.php');
    $colaMensajes = new ColaMensajes("colatrans");

    $accion = "";
    if (!isset($_GET['a'])) {
        $accion = "status";
    } else {
        $accion = $_GET['a'];
    }
    if ($accion == "publicar") {
        if (isset($_GET['i'])) {
            $id = $_GET['i'];
        } else {
            $id = rand(0, 200);
        }
        $colaMensajes->push("" . $id);
        echo 'se publico un job<br>';
    }
    if ($accion == "leer") {
        $job = $colaMensajes->pop();
        if ($job == "") {
            echo 'no hay datos en job, suponemos time_out<br>';
        } else {
            echo $job->getData() . '<br><br>';
            $colaMensajes->deleteJob($job);
        }
    }
    $colaMensajes->printStats();
}
?>