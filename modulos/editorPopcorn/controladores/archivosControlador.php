<?php

function principal() {
    echo 'acción no disponible';
}

function subirImagen() {
    //Regresara un json con error y link
    $error = "";
    $link = "";
    if (validarUsuarioLoggeado()) {
        if (isset($_POST['u']) && isset($_POST['uuid']) && isset($_POST['cu']) && isset($_POST['cl'])) {
            $idUsuario = $_POST['u'];
            $uuid = $_POST['uuid'];
            $idCurso = $_POST['cu'];
            $idClase = $_POST['cl'];
            $usuario = getUsuarioActual();
            require_once 'modulos/cursos/modelos/ClaseModelo.php';
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            if ($usuario->idUsuario == getIdUsuarioDeCurso($idCurso)
                    && $usuario->idUsuario == $idUsuario
                    && $usuario->uuid == $uuid
                    && clasePerteneceACurso($idCurso, $idClase)) {

                $pathInfo = pathinfo($_FILES['imagen']['name']);
                $uniqueCode = getUniqueCode(15);
                $fileName = "extraMedia_" . $uniqueCode . "_." . $pathInfo['extension'];
                $destDir = "archivos/extraMedia/" . $idClase . "/";
                if (!is_dir($destDir)) {
                    //El directorio no existe, lo creamos
                    mkdir($destDir);
                }
                $destination = $destDir . $fileName;
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destination)) {
                    $link = "/" . $destination;
                    //con la siguiente funcion obtenemos el ancho y el alto de la imagen
                    //list($width, $height, $type, $attr) = getimagesize($destination);        
                } else {
                    $error = "error al mover el archivo";
                }
            } else {
                $error = "No tienes permiso para modificar";
            }
        } else {
            $error = "datos no validos";
        }
    } else {
        $error = "Usuario no válido";
    }
    $array = array(
        "error" => $error,
        "link" => $link,
        "post" => $_POST
    );
    echo json_encode($array);
}

?>