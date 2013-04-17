<?php

function principal() {
    //obtener los datos del paquete
    require_once('modulos/principal/modelos/variablesDeProductoModelo.php');
    $maxUsuarios = getVariableDeProducto("limiteUsuarios");
    //Dividimos entre 1000000000 para convertir de Bytes a GB
    $maxDisco = getVariableDeProducto("limiteUsoEnDisco") / 1000000000;
    $maxAncho = getVariableDeProducto("limiteAnchoDeBanda") / 1000000000;

    //obtener los datos de uso
    require_once('modulos/usuarios/modelos/usuarioModelo.php');
    $numUsuarios = getTotalUsuarios();
    require_once('modulos/cursos/modelos/ClaseModelo.php');
    $discoUsadoEnBytes = round(getTotalDiscoUtilizado());
    $discoUsado = round(getTotalDiscoUtilizado() / 1000000000);
    $anchoUsadoEnBytes = getVariableDeProducto("usoActualAnchoDeBanda");
    $anchoUsado = round(getVariableDeProducto("usoActualAnchoDeBanda") / 1000000000);

    //Obtenemos los valores en porcentaje
    $usuariosPorcentaje = round(($numUsuarios / $maxUsuarios) * 100);
    $discoPorcentaje = round(($discoUsado / $maxDisco) * 100);
    $anchoPorcentaje = round(($anchoUsado / $maxAncho) * 100);

    clearBreadCrumbs();
    pushBreadCrumb(getUrl(), "Estadísticas de uso", true);
    require_once 'modulos/principal/vistas/estadisticasDeUso.php';
}

?>