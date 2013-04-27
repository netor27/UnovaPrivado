<?php

require_once 'modulos/cursos/clases/ControlPregunta.php';

function altaControlPregunta($controlPregunta) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT INTO controlpregunta (idControl, idTipoControlPregunta, pregunta, respuesta) 
                            VALUES (:idControl, :idTipoControlPregunta, :pregunta, :respuesta)");
    $stmt->bindParam(":idControl", $controlPregunta->idControl);
    $stmt->bindParam(":idTipoControlPregunta", $controlPregunta->idTipoControlPregunta);
    $stmt->bindParam(":pregunta", $controlPregunta->pregunta);
    $stmt->bindParam(":respuesta", json_encode($controlPregunta->respuesta));
    $id = -1;
    if ($stmt->execute()) {
        $id = $conex->lastInsertId();
    } else {
        print_r($stmt->errorInfo());
    }
    return $id;
}

function bajaControlPregunta($idControlPregunta) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("DELETE FROM controlpregunta WHERE idControlPregunta = :id");
    $stmt->bindParam(':id', $idControlPregunta);
    $stmt->execute();
    return $stmt->rowCount();
}

function actualizarControlPregunta($controlPregunta){
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE controlpregunta 
                    SET pregunta = :pregunta, respuesta = :respuesta
                    WHERE idControlPregunta = :id");
    $stmt->bindParam();
    $stmt->bindParam(":pregunta", $controlPregunta->pregunta);
    $stmt->bindParam(":respuesta", json_encode($controlPregunta->respuesta));
    $stmt->bindParam(':id', $controlPregunta->idControlPregunta);
    return $stmt->execute();
}

function getPreguntasDeControl($idControl) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT p.idControlPregunta, p.idControl, p.idTipoControlPregunta, p.pregunta, p.respuesta
                            FROM controlpregunta p
                            WHERE p.idControl =  :idControl");
    $stmt->bindParam(":idControl", $idControl);
    $pregunta = NULL;
    $preguntas = array();
    $i = 0;
    if ($stmt->execute()) {
        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {
            $pregunta = new ControlPregunta();
            $pregunta->idControl = $row['idControl'];
            $pregunta->idControlPregunta = $row['idControlPregunta'];
            $pregunta->idTipoControlPregunta = $row['idTipoControlPregunta'];
            $pregunta->pregunta = $row['pregunta'];
            $pregunta->respuesta = $row['respuesta'];
            $preguntas[$i] = $pregunta;
            $i++;
        }
    } else {
        echo $stmt->queryString . "<br>";
        print_r($stmt->errorInfo());
    }
    return $preguntas;
}

function getIdsPreguntasDeControl($idControl){
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT idControlPregunta
                            FROM controlpregunta 
                            WHERE idControl =  :idControl");
    $stmt->bindParam(":idControl", $idControl);
    $i = 0;
    $preguntas = array();
    if ($stmt->execute()) {
        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {
            $preguntas[$i] = $row['idControlPregunta'];
            $i++;
        }
    } else {
        echo $stmt->queryString . "<br>";
        print_r($stmt->errorInfo());
    }
    return $preguntas;
}
?>