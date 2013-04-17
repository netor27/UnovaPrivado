<?php

function principal() {
    if (validarUsuarioLoggeado()) {
        if (validarAdministradorPrivado()) {
            $offset = 0;
            $numRows = 6;
            $pagina = 1;
            if (isset($_GET['p'])) {
                if (is_numeric($_GET['p'])) {
                    $pagina = intval($_GET['p']);
                    $offset = $numRows * ($pagina - 1);
                }
            }
            require_once 'modulos/grupos/modelos/grupoModelo.php';
            $res = getGrupos($offset, $numRows);
            $grupos = $res['grupos'];
            $numGrupos = $res['n'];
            $maxPagina = ceil($numGrupos / $numRows);
            if ($pagina != 1 && $pagina > $maxPagina)
                redirect("/grupos&p=" . $maxPagina);
            clearBreadCrumbs();
            pushBreadCrumb(getUrl(), "Lista de grupos", true);
            require_once 'modulos/grupos/vistas/principal.php';
        } else {
            goToIndex();
        }
    } else {
        goToIndex();
    }
}

function agregar() {
    if (validarAdministradorPrivado()) {
        $tipo = "alta";
        require_once 'modulos/grupos/clases/Grupo.php';
        $grupo = new Grupo();
        require_once('modulos/grupos/vistas/formaGrupo.php');
    } else {
        goToIndex();
    }
}

function borrar() {
    if (validarAdministradorPrivado()) {
        if (isset($_GET['ig']) && is_numeric($_GET['ig']) &&
                isset($_GET['pagina']) && is_numeric($_GET['pagina'])) {
            require_once 'modulos/grupos/modelos/grupoModelo.php';
            $idGrupo = $_GET['ig'];
            $pagina = $_GET['pagina'];
            if (bajaGrupo($idGrupo)) {
                setSessionMessage("Se eliminó correctamente el grupo", " ¡Bien! ", "success");
            } else {
                setSessionMessage("Ocurrió un error al borrar el grupo. Intenta de nuevo más tarde", " ¡Error! ", "error");
            }
            redirect("/grupos&p=" . $pagina);
        } else {
            setSessionMessage("Datos no validos", " ¡Error! ", "error");
            redirect("/grupos");
        }
    } else {
        goToIndex();
    }
}

function modificar() {
    if (validarAdministradorPrivado()) {
        $tipo = "edita";
        if (isset($_GET['i']) && is_numeric($_GET['i'])) {
            $idGrupo = $_GET['i'];
            require_once 'modulos/grupos/modelos/grupoModelo.php';
            $grupo = getGrupo($idGrupo);
            require_once('modulos/grupos/vistas/formaGrupo.php');
        } else {
            setSessionMessage("Datos no validos", " ¡Error! ", "error");
            redirect("/grupos");
        }
    } else {
        goToIndex();
    }
}

function grupoSubmit() {
    if (validarAdministradorPrivado()) {
        if (isset($_POST['tipo']) && isset($_POST['nombre']) && isset($_POST['descripcion'])) {
            $tipo = $_POST['tipo'];
            require_once 'modulos/grupos/modelos/grupoModelo.php';
            $grupo = new Grupo();
            $grupo->nombre = $_POST['nombre'];
            $grupo->descripcion = $_POST['descripcion'];

            switch ($tipo) {
                case 'alta':
                    if (altaGrupo($grupo) >= 0) {
                        setSessionMessage("Se dió de alta un grupo correctamente", " ¡Bien! ", "success");
                    } else {
                        setSessionMessage("Ocurrió un error al dar de alta el grupo. Intenta de nuevo más tarde", " ¡Error! ", "error");
                    }
                    break;
                case 'edita':
                    $grupo->idGrupo = $_POST['idGrupo'];
                    if (modificaGrupo($grupo)) {
                        setSessionMessage("Se modificó correctamente el grupo", " ¡Bien! ", "success");
                    } else {
                        setSessionMessage("Ocurrió un error al modificar el grupo. Intenta de nuevo más tarde", " ¡Error! ", "error");
                    }
                    break;
            }
        } else {
            setSessionMessage("Datos no válidos", " ¡Error! ", "error");
        }
        redirect("/grupos");
    } else {
        goToIndex();
    }
}

?>