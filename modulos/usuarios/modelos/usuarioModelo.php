<?php

require_once 'modulos/usuarios/clases/Usuario.php';

function altaUsuario($usuario) {
    require_once 'bd/conex.php';
    global $conex;
    $uuid = md5($usuario->email) . getUniqueCode(4);
    $usuario->setRandomProfilePic();
    $stmt = $conex->prepare("INSERT into usuario 
                            (email, password, nombreUsuario, uniqueUrl, fechaRegistro, uuid, tipoUsuario, avatar) 
                            values(:email,:password,:nombreUsuario,:uniqueUrl, NOW() ,:uuid , :tipoUsuario, :avatar)");
    $stmt->bindParam(':email', $usuario->email);
    $stmt->bindParam(':password', $usuario->password);
    $stmt->bindParam(':nombreUsuario', $usuario->nombreUsuario);
    $stmt->bindParam(':uuid', $uuid);
    $stmt->bindParam(':uniqueUrl', $usuario->uniqueUrl);
    $stmt->bindParam(':tipoUsuario', $usuario->tipoUsuario);
    $stmt->bindParam(':avatar', $usuario->avatar);
    $id = -1;

    if ($stmt->execute()) {
        $id = $conex->lastInsertId();
        return array("resultado" => "ok", "id" => $id, "uuid" => $uuid);
    } else {
        $error = $stmt->errorInfo();
        return array("resultado" => "error", "errorId" => $error[1]);
    }
}

function eliminarUsuario($idUsuario) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("DELETE FROM usuario WHERE idUsuario = :id");
    $stmt->bindParam(':id', $idUsuario);
    $stmt->execute();
    return $stmt->rowCount();
}

//Funciones de actualización
function actualizaInformacionUsuario($usuario) {
    require_once 'bd/conex.php';

    global $conex;
    $stmt = $conex->prepare("UPDATE usuario 
                            SET nombreUsuario = :nombreUsuario, uniqueUrl = :uniqueUrl, tituloPersonal = :tituloPersonal, bio = :bio 
                            WHERE idUsuario = :id");

    $stmt->bindParam(':nombreUsuario', $usuario->nombreUsuario);
    $stmt->bindParam(':tituloPersonal', $usuario->tituloPersonal);
    $stmt->bindParam(':uniqueUrl', $usuario->uniqueUrl);
    $stmt->bindParam(':bio', $usuario->bio);
    $stmt->bindParam(':id', $usuario->idUsuario);
    return $stmt->execute();
}

function actualizaPassword($usuario) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE usuario 
                            SET password = :password 
                            WHERE idUsuario = :id");
    $stmt->bindParam(':password', $usuario->password);
    $stmt->bindParam(':id', $usuario->idUsuario);
    return $stmt->execute();
}

function actualizaAvatar($usuario) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE usuario 
                            SET avatar = :avatar 
                            WHERE idUsuario = :id");
    $stmt->bindParam(':avatar', $usuario->avatar);
    $stmt->bindParam(':id', $usuario->idUsuario);
    return $stmt->execute();
}

function actualizaEmail($usuario) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE usuario 
                            SET email = :email, activado = 0 
                            WHERE idUsuario = :id");
    $stmt->bindParam(':email', $usuario->email);
    $stmt->bindParam(':id', $usuario->idUsuario);
    return $stmt->execute();
}

function setActivado($idUsuario, $valor) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE usuario 
                            SET activado = :valor 
                            WHERE idUsuario = :id");
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':id', $idUsuario);
    return $stmt->execute();
}

function getUsuarios() {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->query("SELECT * 
                          FROM usuario
                          WHERE tipoUsuario != 1
                          ORDER BY nombreUsuario ASC");
    $usuarios = null;
    $usuario = null;
    $i = 0;
    foreach ($stmt as $row) {
        $usuario = new Usuario();
        $usuario->idUsuario = $row['idUsuario'];
        $usuario->email = $row['email'];
        $usuario->password = $row['password'];
        $usuario->nombreUsuario = $row['nombreUsuario'];
        $usuario->tipoUsuario = $row['idTipoUsuario'];
        $usuario->avatar = $row['avatar'];
        $usuario->bio = $row['bio'];
        $usuario->activado = $row['activado'];
        $usuario->fechaRegistro = $row['fechaRegistro'];
        $usuario->tituloPersonal = $row['tituloPersonal'];
        $usuario->uniqueUrl = $row['uniqueUrl'];
        $usuarios[$i] = $usuario;
        $i++;
    }
    return $usuarios;
}

function getUsuariosPorTipo($tipo, $offset, $numRows) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT SQL_CALC_FOUND_ROWS u.*
                            FROM usuario u
                            WHERE tipoUsuario = :tipo
                            ORDER BY u.nombreUsuario ASC
                            LIMIT $offset, $numRows");
    $stmt->bindParam(":tipo", $tipo);
    if (!$stmt->execute())
        print_r($stmt->errorInfo());
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
}

function getUsuario($idUsuario) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM usuario WHERE idUsuario = :id");
    $stmt->bindParam(':id', $idUsuario);
    $stmt->execute();
    $usuario = NULL;
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $usuario = new Usuario();
        $usuario->idUsuario = $row['idUsuario'];
        $usuario->email = $row['email'];
        $usuario->password = $row['password'];
        $usuario->nombreUsuario = $row['nombreUsuario'];
        $usuario->tipoUsuario = $row['idTipoUsuario'];
        $usuario->avatar = $row['avatar'];
        $usuario->bio = $row['bio'];
        $usuario->activado = $row['activado'];
        $usuario->fechaRegistro = $row['fechaRegistro'];
        $usuario->tituloPersonal = $row['tituloPersonal'];
        $usuario->uuid = $row['uuid'];
        $usuario->uniqueUrl = $row['uniqueUrl'];
    }
    return $usuario;
}

function getUsuarioFromUuid($uuid) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM usuario WHERE uuid = :uuid");
    $stmt->bindParam(':uuid', $uuid);
    $stmt->execute();
    $usuario = NULL;
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $usuario = new Usuario();
        $usuario->idUsuario = $row['idUsuario'];
        $usuario->email = $row['email'];
        $usuario->password = $row['password'];
        $usuario->nombreUsuario = $row['nombreUsuario'];
        $usuario->tipoUsuario = $row['idTipoUsuario'];
        $usuario->avatar = $row['avatar'];
        $usuario->bio = $row['bio'];
        $usuario->activado = $row['activado'];
        $usuario->fechaRegistro = $row['fechaRegistro'];
        $usuario->tituloPersonal = $row['tituloPersonal'];
        $usuario->uuid = $row['uuid'];
        $usuario->uniqueUrl = $row['uniqueUrl'];
    }
    return $usuario;
}

function getUsuariosParaResumenSemanal($offset, $numRows) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->query("SELECT idUsuario, email, nombreUsuario 
                           FROM usuario
                           WHERE activado = 1
                           LIMIT $offset, $numRows");
    $usuarios = null;
    $usuario = null;
    $i = 0;
    foreach ($stmt as $row) {
        $usuario = new Usuario();
        $usuario->idUsuario = $row['idUsuario'];
        $usuario->nombreUsuario = $row['nombreUsuario'];
        $usuario->email = $row['email'];
        $usuarios[$i] = $usuario;
        $i++;
    }
    return $usuarios;
}

function getTotalUsuarios() {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->query("SELECT COUNT(idUsuario) as cuenta 
                          FROM usuario
                          WHERE tipoUsuario != 1");
    $count = 0;
    foreach ($stmt as $row) {
        $count = $row['cuenta'];
    }
    return $count;
}

function getUsuarioFromUniqueUrl($uniqueUrl) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM usuario WHERE uniqueUrl = :uniqueUrl");
    $stmt->bindParam(':uniqueUrl', $uniqueUrl);
    $stmt->execute();
    $usuario = NULL;
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $usuario = new Usuario();
        $usuario->idUsuario = $row['idUsuario'];
        $usuario->email = $row['email'];
        $usuario->password = $row['password'];
        $usuario->nombreUsuario = $row['nombreUsuario'];
        $usuario->tipoUsuario = $row['idTipoUsuario'];
        $usuario->avatar = $row['avatar'];
        $usuario->bio = $row['bio'];
        $usuario->activado = $row['activado'];
        $usuario->fechaRegistro = $row['fechaRegistro'];
        $usuario->tituloPersonal = $row['tituloPersonal'];
        $usuario->uuid = $row['uuid'];
        $usuario->uniqueUrl = $row['uniqueUrl'];
    }
    return $usuario;
}

function getIdUsuarioFromUuid($uuid) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT idUsuario FROM usuario WHERE uuid = :uuid");
    $stmt->bindParam(':uuid', $uuid);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        return $row['idUsuario'];
    }else
        return -1;
}

function getUsuarioFromEmail($email) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM usuario WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = NULL;
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $usuario = new Usuario();
        $usuario->idUsuario = $row['idUsuario'];
        $usuario->email = $row['email'];
        $usuario->password = $row['password'];
        $usuario->nombreUsuario = $row['nombreUsuario'];
        $usuario->tipoUsuario = $row['idTipoUsuario'];
        $usuario->avatar = $row['avatar'];
        $usuario->bio = $row['bio'];
        $usuario->activado = $row['activado'];
        $usuario->fechaRegistro = $row['fechaRegistro'];
        $usuario->tituloPersonal = $row['tituloPersonal'];
        $usuario->uuid = $row['uuid'];
        $usuario->uniqueUrl = $row['uniqueUrl'];
    }
    return $usuario;
}

function validarPassAnterior($idUsuario, $passAnterior) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT count(*) AS cuenta
                            FROM usuario 
                            WHERE idUsuario = :id AND password = :passAnterior");
    $stmt->bindParam('id', $idUsuario);
    $stmt->bindParam('passAnterior', $passAnterior);
    $n = 0;
    if ($stmt->execute()) {
        $row = $stmt->fetch();
        $n = $row['cuenta'];
    }
    return ($n == 1);
}

function getUUIDFromEmail($email) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT uuid 
                            FROM usuario
                            WHERE email = :email");
    $stmt->bindParam('email', $email);
    $stmt->execute();
    $res = NULL;
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $res = $row['uuid'];
    }
    return $res;
}

function reestablecerPasswordPorUUID($uuid, $pass) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE usuario 
                            SET password = :password 
                            WHERE uuid = :id");
    $stmt->bindParam(':password', $pass);
    $stmt->bindParam(':id', $uuid);

    return $stmt->execute();
}

function elNombreUsuarioEsUnico($uniqueUrl) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT idUsuario FROM usuario where uniqueUrl = :uniqueUrl");
    $stmt->bindParam(':uniqueUrl', $uniqueUrl);

    $stmt->execute();
    return ($stmt->rowCount() == 0);
}

?>
