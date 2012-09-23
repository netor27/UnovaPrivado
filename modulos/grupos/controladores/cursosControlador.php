<?php

function asignados() {
    if (validarUsuarioLoggeado()) {
        if (validarAdministradorPrivado()) {
            if (isset($_GET['i']) && is_numeric($_GET['i'])) {
                $idCurso = intval($_GET['i']);
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

?>