<?php

require_once 'modulos/cursos/clases/Control.php';

function altaControl($idClase) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT INTO control (idClase, tiempoLimite, aplicacionUnica) 
                            VALUES (:idClase, 0, 0)");
    $stmt->bindParam(":idClase", $idClase);
    $id = -1;
    if ($stmt->execute()) {
        $id = $conex->lastInsertId();
    } else {
        print_r($stmt->errorInfo());
    }
    return $id;
}

function bajaControl($idControl) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("DELETE FROM control WHERE idControl = :id");
    $stmt->bindParam(':id', $idControl);
    $stmt->execute();
    return $stmt->rowCount();
}

function getControl($idControl) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM control where idControl = :id");
    $stmt->bindParam(':id', $idControl);
    $stmt->execute();
    $control = NULL;
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $control = new Control();
        $control->idControl = $row['idControl'];
        $control->idClase = $row['idClase'];
        $control->aplicacionUnica = $row['aplicacionUnica'];
        $control->tiempoLimite = $row['tiempoLimite'];
    }
    return $control;
}

function getControlDeClase($idClase) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM control where idClase = :id");
    $stmt->bindParam(':id', $idClase);
    $stmt->execute();
    $control = NULL;
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $control = new Control();
        $control->idControl = $row['idControl'];
        $control->idClase = $row['idClase'];
        $control->aplicacionUnica = $row['aplicacionUnica'];
        $control->tiempoLimite = $row['tiempoLimite'];
    }
    return $control;
}

?>