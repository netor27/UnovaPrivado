<?php

function loginUsuario($email, $password, $setCookies) {
    require_once ('bd/conex.php');
    $numeroTuplas = 0;
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM usuario WHERE email = :email and password = :pass");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pass', $password);
    $stmt->execute();

    require_once 'modulos/usuarios/clases/Usuario.php';
    $usuario = new Usuario();
    if ($stmt->rowCount() == 1) {
        $numeroTuplas = 1;
        $row = $stmt->fetch();
        $usuario->idUsuario = $row['idUsuario'];
        $usuario->activado = $row['activado'];
        $usuario->avatar = $row['avatar'];
        //$usuario->bio = $row['bio'];
        $usuario->email = $row['email'];
        $usuario->nombreUsuario = $row['nombreUsuario'];
        $usuario->tipoUsuario = $row['idTipoUsuario'];
        $usuario->uuid = $row['uuid'];
        $usuario->uniqueUrl = $row['uniqueUrl'];

        $_SESSION['usuario'] = $usuario;
        $_SESSION['contador'] = 1;

        if ($setCookies) {
            $tiempo = 2592000;//tiempo que va a durar la cookie, alrededor de 30 días
            setcookie("usrcookiePrv", $email, time() + $tiempo, '/');
            setcookie("clvcookiePrv", $password, time() + $tiempo, '/');
        }
        //actualizamos en la base de datos el sessionId actual
        actualizarIdSession($usuario->idUsuario);
    } else {
        //echo "rowCount = " . $stmt->rowCount();
    }
    return $numeroTuplas;
}

function actualizarIdSession($idUsuario) {
    $sessionId = session_id();
    require_once ('bd/conex.php');
    global $conex;
    $stmt = $conex->prepare("UPDATE usuario SET sessionId = :sessionId WHERE idUsuario = :idUsuario");
    $stmt->bindParam(':sessionId', $sessionId);
    $stmt->bindParam(':idUsuario', $idUsuario);
    $stmt->execute();
}

function validateSessionIdUsuario($idUsuario, $sessionId) {
    require_once ('bd/conex.php');
    global $conex;
    $stmt = $conex->prepare("SELECT idUsuario FROM usuario WHERE idUsuario = :id and sessionId = :sessionId");
    $stmt->bindParam(':id', $idUsuario);
    $stmt->bindParam(':sessionId', $sessionId);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        //el usuario y el sessionId son válidos regresar true
        return true;
    } else {
        return false;
    }
}

function salir() {
    $log = false;
    if (isset($_SESSION['usuario'])) {
        $_SESSION['usuario'] = null;
        session_destroy();
        //Si cerró sesión, matamos las cookies
        unset($_COOKIE['usrcookiePrv']);
        unset($_COOKIE['clvcookiePrv']);
        setcookie("usrcookiePrv", "logout", 1, '/');
        setcookie("clvcookiePrv", "logout", 1, '/');
        $log = true;
    }
    return $log;
}

?>