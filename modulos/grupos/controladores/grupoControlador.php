<?php

function principal() {    
    if (validarUsuarioLoggeado()) {
        if (tipoUsuario() == "administradorPrivado") {
            $offset = 0;
            $numRows = 5;
            $pagina = 1;
            if (isset($_GET['p'])) {
                if (is_numeric($_GET['p'])) {                    
                    $pagina = intval($_GET['p']);
                    echo "pagina = " .$pagina . '<br>';
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


?>