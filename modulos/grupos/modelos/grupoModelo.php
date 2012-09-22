<?php

require_once 'modulos/grupos/clases/Grupo.php';

function altaGrupo($grupo) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT into grupo 
                            (nombre, descripcion) 
                            values(:nombre, :descripcion)");
    $stmt->bindParam(':nombre', $grupo->nombre);
    $stmt->bindParam(':descripcion', $grupo->descripcion);
    $id = -1;
    if ($stmt->execute())
        $id = $conex->lastInsertId();
    else {
        print_r($stmt->errorInfo());
    }
    return $id;
}

function bajaGrupo($idGrupo) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("DELETE FROM grupo
                            WHERE idGrupo = :idGrupo");
    $stmt->bindParam(":idGrupo", $idGrupo);
    return $stmt->execute();
}

function modificaGrupo($grupo) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE grupo 
                            SET nombre = :nombre, descripcion = :descripcion
                            WHERE idGrupo = :idGrupo");
    $stmt->bindParam(":nombre", $grupo->nombre);
    $stmt->bindParam(":descripcion", $grupo->descripcion);
    $stmt->bindParam(":idGrupo", $grupo->idGrupo);
    return $stmt->execute();
}

function getGrupo($idGrupo){
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * from grupo
                            WHERE idGrupo = :idGrupo");
    $stmt->bindParam(":idGrupo", $idGrupo);
    if($stmt->execute()){
        $row = $stmt->fetch();
        $grupo = new Grupo();
        $grupo->idGrupo = $row['idGrupo'];
        $grupo->nombre = $row['nombre'];
        $grupo->descripcion = $row['descripcion'];
        return $grupo;
    }else{
        return null;
    }
}

function getGrupos($offset, $numRows) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->query("SELECT SQL_CALC_FOUND_ROWS * FROM grupo
                           ORDER BY nombre asc
                           LIMIT $offset, $numRows");
    if (!$stmt->execute())
        print_r($stmt->errorInfo());
    $rows = $stmt->fetchAll();

    $r = $conex->query("SELECT FOUND_ROWS() as numero")->fetch();
    $n = $r['numero'];

    $grupos = null;
    $grupo = null;
    $i = 0;
    foreach ($rows as $row) {
        $grupo = new Grupo();
        $grupo->idGrupo = $row['idGrupo'];
        $grupo->nombre = $row['nombre'];
        $grupo->descripcion = $row['descripcion'];
        $grupos[$i] = $grupo;
        $i++;
    }
    $array = array(
        "n" => $n,
        "grupos" => $grupos
    );
    return $array;
}

function getGruposAsignadosAlCurso($idCurso, $offset, $numRows) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT SQL_CALC_FOUND_ROWS g.* 
                            FROM grupo g, grupocurso gc
                            WHERE gc.idGrupo = g.idGrupo
                            AND gc.idCurso = :idCurso
                            ORDER BY g.nombre asc
                            LIMIT $offset, $numRows");
    $stmt->bindParam(":idCurso", $idCurso);
    if ($stmt->execute()) {
        $rows = $stmt->fetchAll();
        $r = $conex->query("SELECT FOUND_ROWS() as numero")->fetch();
        $n = $r['numero'];
        $grupos = null;
        $grupo = null;
        $i = 0;
        foreach ($rows as $row) {
            $grupo = new Grupo();
            $grupo->nombre = $row['nombre'];
            $grupo->descripcion = $row['descripcion'];
            $grupos[$i] = $grupo;
            $i++;
        }
        $array = array(
            "n" => $n,
            "grupos" => $grupos
        );
        return $array;
    } else {
        print_r($stmt->errorInfo());
        return null;
    }
}

function getGruposDelUsuario($idUsuario, $offset, $numRows) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT SQL_CALC_FOUND_ROWS g.* 
                            FROM grupo g, usuariogrupo ug
                            WHERE ug.idGrupo = g.idGrupo
                            AND ug.idUsuario = :idUsuario
                            ORDER BY g.nombre asc
                            LIMIT $offset, $numRows");
    $stmt->bindParam(":idUsuario", $idUsuario);
    if ($stmt->execute()) {
        $rows = $stmt->fetchAll();
        $r = $conex->query("SELECT FOUND_ROWS() as numero")->fetch();
        $n = $r['numero'];
        $grupos = null;
        $grupo = null;
        $i = 0;
        foreach ($rows as $row) {
            $grupo = new Grupo();
            $grupo->nombre = $row['nombre'];
            $grupo->descripcion = $row['descripcion'];
            $grupos[$i] = $grupo;
            $i++;
        }
        $array = array(
            "n" => $n,
            "grupos" => $grupos
        );
        return $array;
    } else {
        print_r($stmt->errorInfo());
        return null;
    }
}

function getUsuariosDelGrupo($idGrupo, $offset, $numRows){
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT SQL_CALC_FOUND_ROWS u.* 
                            FROM usuario u, usuariogrupo ug
                            WHERE u.idUsuario = ug.idUsuario
                            AND ug.idGrupo = :idGrupo
                            ORDER BY u.nombreUsuario
                            LIMIT $offset, $numRows");
    $stmt->bindParam(":idGrupo", $idGrupo);
    if ($stmt->execute()) {
        $rows = $stmt->fetchAll();
        $r = $conex->query("SELECT FOUND_ROWS() as numero")->fetch();
        $n = $r['numero'];
        $grupos = null;
        $grupo = null;
        $i = 0;
        foreach ($rows as $row) {
            $grupo = new Grupo();
            $grupo->nombre = $row['nombre'];
            $grupo->descripcion = $row['descripcion'];
            $grupos[$i] = $grupo;
            $i++;
        }
        $array = array(
            "n" => $n,
            "grupos" => $grupos
        );
        return $array;
    } else {
        print_r($stmt->errorInfo());
        return null;
    }
}

?>