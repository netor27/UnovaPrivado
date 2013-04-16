<?php

function agregarComentario() {
    $res = false;
    $usuario = getUsuarioActual();
    if (isset($_POST['texto']) && isset($_POST['discusion'])) {
        $texto = $_POST['texto'];
        $idDiscusion = removeBadHtmlTags($_POST['discusion']);
        if (strlen($texto) > 0) {
            require_once 'modulos/cursos/modelos/ComentarioModelo.php';
            $comentario = new Comentario();
            $comentario->texto = $texto;
            $comentario->idDiscusion = $idDiscusion;
            $comentario->idUsuario = $usuario->idUsuario;
            $comentario->idComentario = altaComentario($comentario);
            if ($comentario->idComentario >= 0) {
                //Se agrego correctamente
                $res = true;
                $msg = "se agrego comentario: " . $comentario->idComentario;
            } else {
                //Ocurrió un error al agregar
                $msg = "Ocurrió un error al agregar a la base de datos";
            }
        } else {
            $msg = "Los datos introducidos no son válidos";
        }
    } else {
        $msg = "No hay datos";
    }
    $resultado = array(
        "res" => $res,
        "msg" => $msg
    );
    $resultado = json_encode($resultado);
    echo $resultado;
}

function obtenerComentarios() {
    if (isset($_POST['discusion']) && isset($_POST['pagina']) && isset($_POST['rows'])) {
        $idDiscusion = $_POST['discusion'];
        $pagina = $_POST['pagina'];
        if ($pagina < 1)
            $pagina = 1;
        $numRows = $_POST['rows'];
        $orden = $_POST['orden'];
        $ascendente = $_POST['ascendente'];
        $offset = $numRows * ($pagina - 1);
        require_once 'modulos/cursos/modelos/ComentarioModelo.php';
        $array = getComentarios($idDiscusion, $offset, $numRows, $orden, $ascendente);
        $comentarios = $array['comentarios'];
        if (sizeof($comentarios) > 0) {
            foreach ($comentarios as $comentario) {
                printComentario($comentario);
            }
        }else {
            echo '<h4 class="centerText">No hay comentarios</h4>';
        }
    } else {
        echo 'error -- datos no recibidos';
    }
}

function obtenerNumeroComentarios() {
    if (isset($_POST['discusion'])) {
        $idDiscusion = $_POST['discusion'];
        require_once 'modulos/cursos/modelos/ComentarioModelo.php';
        $array = getComentarios($idDiscusion, 0, 1, "fecha", 0);
        $res = array(
            "n" => $array['n']
        );
        $res = json_encode($res);
        echo $res;
    }
}

function votarComentario() {
    $res = false;
    if (isset($_POST['comentario']) && isset($_POST['delta'])) {
        $comentario = $_POST['comentario'];
        $delta = intval($_POST['delta']);
        /* El voto puede ser:
         *   1  Voto a favor
         *  -1  Voto en contra
         *   2  Había votado en contra y cambió su voto a favor. Es  2 para compensar su aniguo voto
         *  -2  Había votado a favor y cambió su voto en contra. Es -2 para compensar su aniguo voto
         */
        if ($delta > 2)
            $delta = 2;
        if ($delta < -2)
            $delta = -2;
        require_once 'modulos/cursos/modelos/ComentarioModelo.php';

        if (actualizarVotacionDeComentario($comentario, $delta)) {
            $nuevaPuntuacion = getPuntuacionComentario($comentario);
            if (isset($nuevaPuntuacion)) {
                $res = true;
                $msg = $nuevaPuntuacion;
            } else {
                $msg = "error al obtener la nueva puntuación";
            }
        } else {
            $msg = "error al actualizar la base de datos";
        }
    } else {
        $msg = "datos no válidos";
    }
    $resultado = json_encode(array(
        "res" => $res,
        "msg" => $msg
            ));
    echo $resultado;
}

function eliminarComentario() {
    $res = false;
    if (isset($_POST['idComentario'])) {
        $idComentario = intval($_POST['idComentario']);
        require_once 'modulos/cursos/modelos/ComentarioModelo.php';
        if (bajaComentario($idComentario) > 0) {
            $res = true;
            $msg = "se borro correctamente";
        } else {
            $msg = "No se borró nada";
        }
    } else {
        $msg = "datos no válidos";
    }
    $resultado = json_encode(array(
        "res" => $res,
        "msg" => $msg
            ));
    echo $resultado;
}

?>