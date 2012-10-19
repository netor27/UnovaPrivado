<?php

function inscribirUsuario() {
    if (validarAdministradorPrivado()) {
        if (isset($_GET['i']) && is_numeric($_GET['i'])) {
            $idCurso = $_GET['i'];
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            $curso = getCurso($idCurso);
            $usuariosDelCurso = getTodosAlumnosDecurso($idCurso);
            require_once 'modulos/usuarios/modelos/usuarioModelo.php';
            $usuarios = getUsuarios();
            require_once 'modulos/usuarios/vistas/asignarUsuarioCurso.php';
        } else {
            setSessionMessage("<h4 class='error'>Datos no válidos</h4>");
            redirect("/cursos");
        }
    } else {
        goToIndex();
    }
}

function asignarUsuarios() {
    if (validarAdministradorPrivado()) {
        if (isset($_POST['idCurso']) && is_numeric($_POST['idCurso'])) {
            $idCurso = $_POST['idCurso'];
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            $curso = getCurso($idCurso);
            require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
            //si hay idUsuariosQuitar eliminamos de la bd las relaciones en usuariocurso
            if (isset($_POST['idUsuariosQuitar'])) {
                foreach ($_POST['idUsuariosQuitar'] as $value) {
                    eliminarInscripcionUsuarioCurso($value, $idCurso);
                }
            }
            //si hay idUsuariosInscribir agregamos a la bd las relaciones en usuariocurso
            if (isset($_POST['idUsuariosInscribir'])) {
                foreach ($_POST['idUsuariosInscribir'] as $value) {
                    //Validar que el usuario no séa el dueño del curso.
                    //Si es el dueño del curso, no inscribirlo
                    if ($curso->idUsuario != $value) {
                        inscribirUsuarioCurso($value, $idCurso);
                    }
                }
            }
            echo 'ok';
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }
}

function eliminarInscripcion() {
    if (validarAdministradorPrivado()) {
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
                redirect("/cursos/curso/alumnos/" . $idCurso . "&p=" . $pagina);
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
        $offset = 0;
        $numRows = 5;
        $pagina = 1;
        if (isset($_GET['p'])) {
            if (is_numeric($_GET['p'])) {
                $pagina = intval($_GET['p']);
                $offset = $numRows * ($pagina - 1);
            }
        }

        $res = getCursosInstructorDetalles($usuario->idUsuario, "titulo", "ASC", $offset, $numRows);
        $cursos = $res['cursos'];
        $numCursos = $res['n'];
        $maxPagina = ceil($numCursos / $numRows);
        if ($pagina != 1 && $pagina > $maxPagina) {
            redirect("/usuarios/cursos/instructor&p=" . $maxPagina);
        } else {
            require_once 'modulos/usuarios/vistas/cursosInstructor.php';
        }
    }
}

function inscrito() {
    require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
    if (validarUsuarioLoggeado()) {
        $usuario = getUsuarioActual();
        $offset = 0;
        $numRows = 5;
        $pagina = 1;
        if (isset($_GET['p'])) {
            if (is_numeric($_GET['p'])) {
                $pagina = intval($_GET['p']);
                $offset = $numRows * ($pagina - 1);
            }
        }
        $res = getCursosInscritoDetalles($usuario->idUsuario, "titulo", "ASC", $offset, $numRows);
        $cursos = $res['cursos'];
        $numCursos = $res['n'];
        $maxPagina = ceil($numCursos / $numRows);
        if ($pagina != 1 && $pagina > $maxPagina) {
            redirect("/usuarios/cursos/inscrito&p=" . $maxPagina);
        } else {
            require_once 'modulos/usuarios/vistas/cursosAlumno.php';
        }
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