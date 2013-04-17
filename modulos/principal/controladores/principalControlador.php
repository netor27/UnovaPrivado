<?php

//require_once '';
function principal() {
    require_once 'modulos/cursos/modelos/CursoModelo.php';
    $array = getCursosFuncion();
    $numCursos = $array['n'];
    $cursos = $array['cursos'];
    clearBreadCrumbs();
    switch (tipoUsuario()) {
        case 'usuario':
            redirect("/usuarios/cursos/inscrito");
            break;
        case 'administradorPrivado':
        case 'administrador':
            require_once('modulos/principal/vistas/principalAdministradorPrivado.php');
            break;
        case 'profesor':
            redirect("/usuarios/cursos/instructor");
            break;
    }
}

function mantenerSesionAbierta(){
    $usuario = getUsuarioActual();
    echo "Solicitud " . date("h:i:s a") . " " . 'Usuario: ' . $usuario->nombreUsuario;
}

function contacto(){
    require_once 'modulos/principal/vistas/contacto.php';
}

?>