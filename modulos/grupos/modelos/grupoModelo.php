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

function getGrupo($idGrupo) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * from grupo
                            WHERE idGrupo = :idGrupo");
    $stmt->bindParam(":idGrupo", $idGrupo);
    if ($stmt->execute()) {
        $row = $stmt->fetch();
        $grupo = new Grupo();
        $grupo->idGrupo = $row['idGrupo'];
        $grupo->nombre = $row['nombre'];
        $grupo->descripcion = $row['descripcion'];
        return $grupo;
    } else {
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

function getTodosLosGrupos() {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->query("SELECT * FROM grupo
                           ORDER BY nombre asc");
    if (!$stmt->execute())
        print_r($stmt->errorInfo());
    $rows = $stmt->fetchAll();

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
    return $grupos;
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
    } else {
        print_r($stmt->errorInfo());
        return null;
    }
}

function getTodosGruposAsignadosAlCurso($idCurso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT g.* 
                            FROM grupo g, grupocurso gc
                            WHERE gc.idGrupo = g.idGrupo
                            AND gc.idCurso = :idCurso
                            ORDER BY g.nombre asc");
    $stmt->bindParam(":idCurso", $idCurso);
    if ($stmt->execute()) {
        $rows = $stmt->fetchAll();
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
        return $grupos;
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

function getUsuariosDelGrupo($idGrupo, $offset, $numRows) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT SQL_CALC_FOUND_ROWS u.* 
                            FROM usuario u, usuariogrupo ug
                            WHERE u.idUsuario = ug.idUsuario
                            AND ug.idGrupo = :idGrupo
                            ORDER BY u.nombreUsuario ASC
                            LIMIT $offset, $numRows");
    $stmt->bindParam(":idGrupo", $idGrupo);
    if ($stmt->execute()) {
        $rows = $stmt->fetchAll();
        $r = $conex->query("SELECT FOUND_ROWS() as numero")->fetch();
        $n = $r['numero'];
        $usuarios = null;
        $usuario = null;
        $i = 0;
        foreach ($rows as $row) {
            $usuario = new Usuario();
            $usuario->idUsuario = $row['idUsuario'];
            $usuario->avatar = $row['avatar'];
            $usuario->nombreUsuario = $row['nombreUsuario'];
            $usuario->uniqueUrl = $row['uniqueUrl'];
            $usuarios[$i] = $usuario;
            $i++;
        }
        $array = array(
            "n" => $n,
            "usuarios" => $usuarios
        );
        return $array;
    } else {
        print_r($stmt->errorInfo());
        return null;
    }
}

function getTodosUsuariosDelGrupo($idGrupo) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT u.* 
                            FROM usuario u, usuariogrupo ug
                            WHERE u.idUsuario = ug.idUsuario
                            AND ug.idGrupo = :idGrupo
                            ORDER BY u.nombreUsuario ASC");
    $stmt->bindParam(":idGrupo", $idGrupo);
    if ($stmt->execute()) {
        $rows = $stmt->fetchAll();
        $usuarios = null;
        $usuario = null;
        $i = 0;
        foreach ($rows as $row) {
            $usuario = new Usuario();
            $usuario->idUsuario = $row['idUsuario'];
            $usuario->avatar = $row['avatar'];
            $usuario->nombreUsuario = $row['nombreUsuario'];
            $usuario->uniqueUrl = $row['uniqueUrl'];
            $usuarios[$i] = $usuario;
            $i++;
        }
        return $usuarios;
    } else {
        print_r($stmt->errorInfo());
        return null;
    }
}

function agregarUsuarioAlGrupo($idUsuario, $idGrupo) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT INTO usuariogrupo(idGrupo, idUsuario)
                            VALUES(:idGrupo, :idUsuario)");
    $stmt->bindParam(":idGrupo", $idGrupo);
    $stmt->bindParam(":idUsuario", $idUsuario);
    return $stmt->execute();
}

function quitarUsuarioDelGrupo($idUsuario, $idGrupo) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("DELETE FROM usuariogrupo
                            WHERE idGrupo = :idGrupo
                            AND idUsuario = :idUsuario");
    $stmt->bindParam(":idGrupo", $idGrupo);
    $stmt->bindParam(":idUsuario", $idUsuario);
    return $stmt->execute();
}

function agregarGrupoAlCurso($idGrupo, $idCurso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT INTO grupocurso(idGrupo, idCurso, fechaInscripcion)
                            VALUES(:idGrupo, :idCurso, NOW())");
    $stmt->bindParam(":idGrupo", $idGrupo);
    $stmt->bindParam(":idCurso", $idCurso);
    return $stmt->execute();
}

function quitarGrupoDelCurso($idGrupo, $idCurso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("DELETE FROM grupocurso
                            WHERE idGrupo = :idGrupo
                            AND idCurso = :idCurso");
    $stmt->bindParam(":idGrupo", $idGrupo);
    $stmt->bindParam(":idCurso", $idCurso);
    return $stmt->execute();
}

?>  