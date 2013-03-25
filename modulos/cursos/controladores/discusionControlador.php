<?php

function agregarDiscusion() {
    $res = false;
    if (validarUsuarioLoggeadoParaSubmits()) {
        $usuario = getUsuarioActual();
        if (isset($_POST['titulo']) && isset($_POST['texto']) && isset($_POST['idCurso'])) {
            $titulo = removeBadHtmlTags(trim($_POST['titulo']));
            $texto = removeBadHtmlTags(trim($_POST['texto']));
            $idCurso = removeBadHtmlTags($_POST['idCurso']);
            if (strlen($titulo) >= 5 && strlen($titulo) <= 140 && strlen($texto) >= 5) {
                require_once 'modulos/cursos/modelos/DiscusionModelo.php';
                $discusion = new Discusion();
                $discusion->titulo = $titulo;
                $discusion->texto = $texto;
                $discusion->idCurso = $idCurso;
                $discusion->idUsuario = $usuario->idUsuario;
                $discusion->idDiscusion = altaDiscusion($discusion);
                if ($discusion->idDiscusion >= 0) {
                    //Se agrego correctamente
                    $res = true;
                    $msg = "se agrego discusion: " . $discusion->idDiscusion;
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
    } else {
        $msg = "No hay usuario loggeado";
    }
    $resultado = array(
        "res" => $res,
        "msg" => $msg
    );
    $resultado = json_encode($resultado);
    echo $resultado;
}

?>