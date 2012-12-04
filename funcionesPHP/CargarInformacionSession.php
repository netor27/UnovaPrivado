<?php

function cargarCursosSession() {
    $usuario = getUsuarioActual();
    if (isset($usuario)) {
        require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
        $aux = NULL;
        //obtener los ultimos 5 cursos a los que se ha 
        //inscrito y guardarlos en la sesión para mostrarlos en el menú            
        if (tipoUsuario() == 'administradorPrivado' ||
                tipoUsuario() == 'profesor') {
            $numCursos = 3;
            //Obtener los ultimos cursos que ha creado el usuario
            //guardarlos en la sesión para mostrarlos en el menú
            $aux = getCursosInstructor($usuario->idUsuario, 0, $numCursos, "fechaCreacion", "DESC");
            $_SESSION['cursosPropios'] = $aux;
        } else {
            $numCursos = 6;
        }
        $auxCursos = getCursosInscrito($usuario->idUsuario, 0, $numCursos);
        $_SESSION['cursos'] = $auxCursos;
    }
}

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