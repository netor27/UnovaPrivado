<?php

function asignados() {
    if (validarUsuarioLoggeado()) {
        if (validarAdministradorPrivado()) {
            if (isset($_GET['i']) && is_numeric($_GET['i'])) {
                $idCurso = intval($_GET['i']);
                require_once 'modulos/cursos/modelos/CursoModelo.php';
                $curso = getCurso($idCurso);
                $offset = 0;
                $numRows = 5;
                $pagina = 1;
                if (isset($_GET['p'])) {
                    if (is_numeric($_GET['p'])) {
                        $pagina = intval($_GET['p']);
                        echo "pagina = " . $pagina . '<br>';
                        $offset = $numRows * ($pagina - 1);
                    }
                }
                require_once 'modulos/grupos/modelos/grupoModelo.php';
                $res = getGruposAsignadosAlCurso($idCurso, $offset, $numRows);
                $grupos = $res['grupos'];
                $numGrupos = $res['n'];
                $maxPagina = ceil($numGrupos / $numRows);
                require_once 'modulos/grupos/vistas/cursosAsignadosAlGrupo.php';
            } else {
                setSessionMessage("<h4 class='error'>Ocurrió un error</h4>");
                goToIndex();
            }
        } else {
            goToIndex();
        }
    } else {
        goToIndex();
    }
}

function gruposDelCurso() {
    if (validarAdministradorPrivado()) {
        if (isset($_GET['i']) && is_numeric($_GET['i'])) {
            $idCurso = $_GET['i'];
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            $curso = getCurso($idCurso);
            require_once 'modulos/grupos/modelos/grupoModelo.php';
            $gruposDelCurso = getTodosGruposAsignadosAlCurso($idCurso);
            $grupos = getTodosLosGrupos();
            require_once 'modulos/grupos/vistas/asignarGrupoCurso.php';
        } else {
            setSessionMessage("<h4 class='error'>Curso no válido</h4>");
            redirect("/grupos");
        }
    } else {
        goToIndex();
    }
}

function asignarGrupos() {
    if (validarAdministradorPrivado()) {
        if (isset($_POST['idCurso']) && is_numeric($_POST['idCurso'])) {
            $idCurso = $_POST['idCurso'];
            require_once 'modulos/grupos/modelos/grupoModelo.php';
            //si hay idUsuariosQuitar eliminamos de la bd las relaciones en usuariocurso
            if (isset($_POST['idGruposQuitar'])) {
                foreach ($_POST['idGruposQuitar'] as $value) {
                    quitarGrupoDelCurso($value,$idCurso);
                }
            }
            //si hay idUsuariosInscribir agregamos a la bd las relaciones en usuariocurso
            if (isset($_POST['idGruposInscribir'])) {
                foreach ($_POST['idGruposInscribir'] as $value) {
                    agregarGrupoAlCurso($value, $idCurso);
                }
            }
            echo 'ok';
        } else {
            echo "error datos";
        }
    } else {
        echo "error login";
    }
}

function eliminarGrupoDeCurso() {
    if (validarAdministradorPrivado()) {
        if (isset($_GET['ig']) && is_numeric($_GET['ig']) &&
                isset($_GET['ic']) && is_numeric($_GET['ic']) &&
                isset($_GET['pagina'])) {
            $pagina = $_GET['pagina'];
            $idCurso = intval($_GET['ic']);
            $idGrupo = intval($_GET['ig']);
            require_once 'modulos/grupos/modelos/grupoModelo.php';
            if (quitarGrupoDelCurso($idGrupo, $idCurso)) {
                setSessionMessage("<h4 class='success'> Se quitó al grupo del curso correctamente</h4>");
            } else {
                setSessionMessage("<h4 class='error'>Ocurrió un error al quitar al grupo</h4>");
            }

            redirect("/grupos/cursos/asignados/" . $idCurso . ":p=" . $pagina);
        } else {
            setSessionMessage("<h4 class='error'>Datos no válidos</h4>");
            redirect("/");
        }
    } else {
        goToIndex();
    }
}

?>