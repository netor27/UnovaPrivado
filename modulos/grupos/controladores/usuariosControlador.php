<?php

function inscritos() {
    if (validarAdministradorPrivado()) {
        if (isset($_GET['i']) && is_numeric($_GET['i'])) {
            $idGrupo = $_GET['i'];
            require_once 'modulos/grupos/modelos/grupoModelo.php';
            $offset = 0;
            $numRows = 18;
            $pagina = 1;
            if (isset($_GET['p'])) {
                if (is_numeric($_GET['p'])) {
                    $pagina = intval($_GET['p']);
                    $offset = $numRows * ($pagina - 1);
                }
            }
            $res = getUsuariosDelGrupo($idGrupo, $offset, $numRows);
            $usuarios = $res['usuarios'];
            $numUsuarios = $res['n'];
            $maxPagina = ceil($numUsuarios / $numRows);
            if ($pagina != 1 && $pagina > $maxPagina) {
                redirect("grupos/usuarios/inscritos/1&p=" . $maxPagina);
            } else {
                pushBreadCrumb(getUrl(), "Lista de usuarios del grupo",true);
                require_once 'modulos/grupos/vistas/usuariosDelGrupo.php';
            }
        } else {
            setSessionMessage("Grupo no válido"," ¡Error! ", "error");
            redirect("/grupos");
        }
    } else {
        goToIndex();
    }
}

function usuariosDelGrupo() {
    if (validarAdministradorPrivado()) {
        if (isset($_GET['i']) && is_numeric($_GET['i'])) {
            $idGrupo = $_GET['i'];
            require_once 'modulos/grupos/modelos/grupoModelo.php';
            $grupo = getGrupo($idGrupo);
            $usuariosDelGrupo = getTodosUsuariosDelGrupo($idGrupo);
            require_once 'modulos/usuarios/modelos/usuarioModelo.php';
            $usuarios = getUsuarios();
            require_once 'modulos/grupos/vistas/asignarUsuarioGrupo.php';
        } else {
            setSessionMessage("Grupo no válido"," ¡Error! ", "error");
            redirect("/grupos");
        }
    } else {
        goToIndex();
    }
}

function asignarUsuarios() {
    if (validarAdministradorPrivado()) {
        if (isset($_POST['idGrupo']) && is_numeric($_POST['idGrupo'])) {
            $idGrupo = $_POST['idGrupo'];
            require_once 'modulos/grupos/modelos/grupoModelo.php';
            //si hay idUsuariosQuitar eliminamos de la bd las relaciones en usuariocurso
            if (isset($_POST['idUsuariosQuitar'])) {
                foreach ($_POST['idUsuariosQuitar'] as $value) {
                    quitarUsuarioDelGrupo($value, $idGrupo);
                }
            }
            //si hay idUsuariosInscribir agregamos a la bd las relaciones en usuariocurso
            if (isset($_POST['idUsuariosInscribir'])) {
                foreach ($_POST['idUsuariosInscribir'] as $value) {
                    agregarUsuarioAlGrupo($value, $idGrupo);
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
        if (isset($_GET['ig']) && is_numeric($_GET['ig']) &&
                isset($_GET['iu']) && is_numeric($_GET['iu']) &&
                isset($_GET['pagina'])) {
            $origen = $_GET['origen'];
            $pagina = $_GET['pagina'];
            $idGrupo = intval($_GET['ig']);
            $idUsuario = intval($_GET['iu']);
            require_once 'modulos/grupos/modelos/grupoModelo.php';
            if (quitarUsuarioDelGrupo($idUsuario, $idGrupo)) {
                setSessionMessage("Se quitó al usuario del grupo correctamente"," ¡Bien! ", "success");
            } else {
                setSessionMessage("Ocurrió un error al quitar al usuario"," ¡Error! ", "error");
            }
            redirect("/grupos/usuarios/inscritos/" . $idGrupo . "&p=" . $pagina);
        } else {
            setSessionMessage("Datos no válidos"," ¡Error! ", "error");
            redirect("/");
        }
    } else {
        goToIndex();
    }
}

?>