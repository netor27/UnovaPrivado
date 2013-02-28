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

                $file = "archivos/temporal/original_" . $_FILES["imagen"]["name"];
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $file)) {
                    //Se subió correctamente el archivo, lo subimos al S3
                    require_once 'modulos/aws/modelos/s3Modelo.php';
                    
                    $res = uploadFileToS3($file, "popcornExtraFiles");
                    if ($res['res']) {
                        //se subio bien al s3
                        require_once 'modulos/editorPopcorn/modelos/archivosExtraModelo.php';
                        $archivoExtra = new ArchivoExtra();
                        $archivoExtra->idClase = $idClase;
                        $archivoExtra->link = $res['link'];
                        if (agregarArchivoExtra($archivoExtra) >= 0) {
                            //Se agrego bien a la bd
                            $link = $res['link'];
                        }else{
                            //error al agregar a la bd
                            $error = "Error al guardar en la bd";
                        }
                    } else {
                        //no se subio al s3
                        $error = "no se subio al s3";
                    }
                    //sin importar si se subio bien, borramos el archivo temporal
                    unlink($file);
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