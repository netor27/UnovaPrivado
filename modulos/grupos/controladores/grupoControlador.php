<?php

function principal() {
    if (validarUsuarioLoggeado()) {
        if (tipoUsuario() == "administradorPrivado") {
            $offset = 0;
            $numRows = 6;
            $pagina = 1;
            if (isset($_GET['p'])) {
                if (is_numeric($_GET['p'])) {
                    $pagina = intval($_GET['p']);
                    echo "pagina = " . $pagina . '<br>';
                    $offset = $numRows * ($pagina - 1);
                }
            }
            require_once 'modulos/grupos/modelos/grupoModelo.php';
            $res = getGrupos($offset, $numRows);
            $grupos = $res['grupos'];
            $numGrupos = $res['n'];
            $maxPagina = ceil($numGrupos / $numRows);
            require_once 'modulos/grupos/vistas/principal.php';
        } else {
            goToIndex();
        }
    } else {
        goToIndex();
    }
}

function agregar() {
    if (tipoUsuario() == "administradorPrivado") {
        $tipo = "alta";
        require_once 'modulos/grupos/clases/Grupo.php';
        $grupo = new Grupo();
        require_once('modulos/grupos/vistas/formaGrupo.php');
    } else {
        goToIndex();
    }
}

function borrar() {
    if (tipoUsuario() == "administradorPrivado") {
        if (isset($_GET['ig']) && is_numeric($_GET['ig']) &&
                isset($_GET['pagina']) && is_numeric($_GET['pagina'])) {
            require_once 'modulos/grupos/modelos/grupoModelo.php';
            $idGrupo = $_GET['ig'];
            $pagina = $_GET['pagina'];
            if(bajaGrupo($idGrupo)){
                setSessionMessage("<h4 class='success'>Se eliminó correctamente el grupo</h4>");
            }else{
                setSessionMessage("<h4 class='error'>Ocurrió un error al borrar el grupo. Intenta de nuevo más tarde</h4>");
            }
            redirect("/grupos:p=".$pagina);
        } else {
            setSessionMessage("<h4 class='error'>Datos no validos</h4>");
            redirect("/grupos");
        }
    } else {
        goToIndex();
    }
}

function modificar() {
    if (tipoUsuario() == "administradorPrivado") {
        $tipo = "edita";
        if (isset($_GET['i']) && is_numeric($_GET['i'])) {
            $idGrupo = $_GET['i'];
            require_once 'modulos/grupos/modelos/grupoModelo.php';
            $grupo = getGrupo($idGrupo);
            require_once('modulos/grupos/vistas/formaGrupo.php');
        } else {
            setSessionMessage("<h4 class='error'>Datos no validos</h4>");
            redirect("/grupos");
        }
    } else {
        goToIndex();
    }
}

function grupoSubmit() {
    if (tipoUsuario() == "administradorPrivado") {
        if (isset($_POST['tipo']) && isset($_POST['nombre']) && isset($_POST['descripcion'])) {
            $tipo = $_POST['tipo'];
            require_once 'modulos/grupos/modelos/grupoModelo.php';
            $grupo = new Grupo();
            $grupo->nombre = $_POST['nombre'];
            $grupo->descripcion = $_POST['descripcion'];

            switch ($tipo) {
                case 'alta':
                    if (altaGrupo($grupo) >= 0) {
                        setSessionMessage("<h4 class='success'>Se dió de alta un grupo correctamente</h4>");
                    } else {
                        setSessionMessage("<h4 class='error'>Ocurrió un error al dar de alta el grupo. Intenta de nuevo más tarde</h4>");
                    }
                    break;
                case 'edita':
                    $grupo->idGrupo = $_POST['idGrupo'];
                    if (modificaGrupo($grupo)) {
                        setSessionMessage("<h4 class='success'>Se modificó correctamente el grupo</h4>");
                    } else {
                        setSessionMessage("<h4 class='error'>Ocurrió un error al modificar el grupo. Intenta de nuevo más tarde</h4>");
                    }
                    break;
            }
        } else {
            setSessionMessage("<h4 class='error'>Datos no válidos</h4>");
        }
        redirect("/grupos");
    } else {
        goToIndex();
    }
}

?>