<?php

//require_once '';
function principal() {
    require_once 'modulos/categorias/modelos/categoriaModelo.php';
    $categorias = getCategorias();
    require_once 'modulos/cursos/modelos/CursoModelo.php';
    $array = getCursosFuncion();
    $numCursos = $array['n'];
    $cursos = $array['cursos'];

    switch(tipoUsuario()){
        case 'usuario':
            require_once('modulos/principal/vistas/principal.php');
            break;
        case 'administradorPrivado':
            require_once('modulos/principal/vistas/principalAdministradorPrivado.php');
            break;
        case 'administrador';
            require_once('modulos/principal/vistas/principal.php');
            break;
    }    
}

?>