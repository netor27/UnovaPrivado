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

//function actualizaTema($tema) {
//    require_once 'bd/conex.php';
//    global $conex;
//    $stmt = $conex->prepare("UPDATE tema SET nombre = :nombre
//                             WHERE idTema = :idTema");
//    $stmt->bindParam(':nombre', $tema->nombre);
//    $stmt->bindParam(':idTema', $tema->idTema);
//    return $stmt->execute();
//}
//
//function getTema($idTema) {
//    require_once 'bd/conex.php';
//    global $conex;
//    $stmt = $conex->prepare("SELECT * FROM tema where idTema = :id");
//    $stmt->bindParam(':id', $idTema);
//    $stmt->execute();
//    $tema = NULL;
//    if ($stmt->rowCount() > 0) {
//        $row = $stmt->fetch();
//        $tema = new Tema();
//        $tema->idCurso = $row['idCurso'];
//        $tema->idTema = $row['idTema'];
//        $tema->nombre = $row['nombre'];
//    }
//    return $tema;
//}

?>