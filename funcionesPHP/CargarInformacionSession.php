<?php

function cargarUsuarioSession() {
    require_once "modulos/usuarios/modelos/usuarioModelo.php";
    $auxUs = getUsuarioActual();
    if (isset($auxUs)) {
        $usuarioSess = getUsuario($auxUs->idUsuario);
        if (isset($usuarioSess)) {
            $usuario = new Usuario();
            $usuario->idUsuario = $usuarioSess->idUsuario;
            $usuario->activado = $usuarioSess->activado;
            $usuario->avatar = $usuarioSess->avatar;
            $usuario->email = $usuarioSess->email;
            $usuario->nombreUsuario = $usuarioSess->nombreUsuario;
            $usuario->tipoUsuario = $usuarioSess->tipoUsuario;
            $usuario->uuid = $usuarioSess->uuid;
            $usuario->uniqueUrl = $usuarioSess->uniqueUrl;
            $_SESSION['usuario'] = $usuarioSess;
        }
    }
}

?>