<?php

function inscribirUsuario() {
    if(tipoUsuario() == "administradorPrivado"){
        
    }
}

function eliminarInscripcion() {
    if (tipoUsuario() == "administradorPrivado") {
        if (isset($_GET['ic']) && is_numeric($_GET['ic']) &&
                isset($_GET['iu']) && is_numeric($_GET['iu']) &&
                isset($_GET['origen']) && isset($_GET['pagina'])) {
            $origen = $_GET['origen'];
            $pagina = $_GET['pagina'];
            $idCurso = intval($_GET['ic']);
            $idUsuario = intval($_GET['iu']);
            require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
            if (eliminarInscripcionUsuarioCurso($idUsuario, $idCurso)) {
                setSessionMessage("<h4 class='success'> Se elimino al usuario del curso correctamente</h4>");
            } else {
                setSessionMessage("<h4 class='error'>Ocurrió un error al quitar al usuario</h4>");
            }
            if ($origen == "listaAlumnos") {
                redirect("/cursos/curso/alumnos/" . $idCurso . "/" . $pagina);
            }
        } else {
            setSessionMessage("<h4 class='error'>Datos no válidos</h4>");
            redirect("/");
        }
    } else {
        goToIndex();
    }
}

function instructor() {
    require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
    if (validarUsuarioLoggeado()) {
        $usuario = getUsuarioActual();
        $cursos = getCursosInstructorDetalles($usuario->idUsuario, "titulo", "ASC");
        require_once 'modulos/usuarios/vistas/cursosInstructor.php';
    }
}

function inscrito() {
    require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
    if (validarUsuarioLoggeado()) {
        $usuario = getUsuarioActual();
        $cursos = getCursosInscritoDetalles($usuario->idUsuario, "fechaInscripcion", "DESC");
        require_once 'modulos/usuarios/vistas/cursosAlumno.php';
    }
}

function responderPreguntas() {
    //mostrar las preguntas que este usuario no ha contestado
    if (validarUsuarioLoggeado()) {
        $usuario = getUsuarioActual();
        require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
        $preguntas = getPreguntasSinResponder($usuario->idUsuario);
        require_once 'modulos/usuarios/vistas/responderPreguntas.php';
    }
}

?>