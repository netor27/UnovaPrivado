<?php

require_once 'modulos/cursos/clases/Discusion.php';

function altaDiscusion($discusion) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT INTO discusion (idCurso, idUsuario, fecha, titulo, texto, puntuacion) 
                            VALUES (:idCurso, :idUsuario, NOW(), :titulo, :texto, 0)");
    $stmt->bindParam(":idCurso", $discusion->idCurso);
    $stmt->bindParam(":idUsuario", $discusion->idUsuario);
    $stmt->bindParam(":titulo", $discusion->titulo);
    $stmt->bindParam(":texto", $discusion->texto);
    $id = -1;
    if ($stmt->execute()) {
        $id = $conex->lastInsertId();
    } else {
        print_r($stmt->errorInfo());
    }
    return $id;
}

function bajaDiscusion($idDiscusion) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("DELETE FROM discusion WHERE idDiscusion = :id");
    $stmt->bindParam(':id', $idDiscusion);
    $stmt->execute();
    return $stmt->rowCount();
}

function getDiscusion($idDiscusion) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM discusion
                            WHERE idDiscusion = :id");
    $stmt->bindParam(':id', $idDiscusion);
    $stmt->execute();
    $discusion = NULL;
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $discusion = new Discusion();
        //idCurso, idUsuario, fecha, titulo, texto, puntuacion
        $discusion->idDiscusion = $row['idDiscusion'];
        $discusion->idCurso = $row['idCurso'];
        $discusion->idUsuario = $row['idUsuario'];
        $discusion->fecha = $row['fecha'];
        $discusion->titulo = $row['titulo'];
        $discusion->texto = $row['texto'];
        $discusion->puntuacion = $row['puntuacion'];
    }
    return $discusion;
}

function getDiscusiones($idCurso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM discusion
                            WHERE idCurso = :id");
    $stmt->bindParam(':id', $idCurso);
    $discusion = NULL;
    $discusiones = array();
    $n = 0;
    if ($stmt->execute()) {
        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {
            $discusion = new Discusion();
            //idCurso, idUsuario, fecha, titulo, texto, puntuacion
            $discusion->idDiscusion = $row['idDiscusion'];
            $discusion->idCurso = $row['idCurso'];
            $discusion->idUsuario = $row['idUsuario'];
            $discusion->fecha = $row['fecha'];
            $discusion->titulo = $row['titulo'];
            $discusion->texto = $row['texto'];
            $discusion->puntuacion = $row['puntuacion'];
            $discusiones[$n] = $discusion;
            $n++;
        }
    }
    return $discusiones;
}

?>