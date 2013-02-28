<?php

require_once('bd/bd.php');
try {
    if (isset($_SERVER['PARAM1']))
        $BDhost = $_SERVER['PARAM1'];
    else
        $BDhost = 'localhost';
    
    if (isset($_SERVER['PARAM2']))
        $BDbase = $_SERVER['PARAM2'];
    else
        $BDbase = 'dbunovaprivado';
    
    if (isset($_SERVER['PARAM3']))
        $BDusuario = $_SERVER['PARAM3'];
    else
        $BDusuario = 'UnoVaUser';
    
    if (isset($_SERVER['PARAM4']))
        $BDpswd = $_SERVER['PARAM4'];
    else
        $BDpswd = 'dbUnovaPass2012';
    
    global $conex;
    $conex = new Configpdo('mysql', $BDhost, $BDbase, $BDusuario, $BDpswd);
} catch (PDOException $e) {
    echo "ocurrió un error con la base de datos";
}

function beginTransaction() {
    global $conex;
    $conex->beginTransaction();
}

function commitTransaction() {
    global $conex;
    $conex->commit();
}

function rollBackTransaction() {
    global $conex;
    $conex->rollBack();
}

?>