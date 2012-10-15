<?php

function transformar($datosJson) {
    $datos = json_decode($datosJson);

    $idClase = $datos->idClase;
    $file = $datos->file;
    $fileType = $datos->fileType;

    require_once 'modulos/videos/modelos/transformador.php';

    $res = transformarArchivo($file);
    if ($res['return_var'] == 0) {
        $archivoMp4 = $res['outputFileMp4'];
        $archivoOgv = $res['outputFileOgv'];
        $duration = $res['duration'];

        //Hay que subir los dos archivos al CDN
        require_once 'modulos/cdn/modelos/cdnModelo.php';
        $tipoVideo = 0;

        //Subimos al cdn el archivo mp4
        $path = pathinfo($archivoMp4);
        $fileNameMp4 = $path['basename'];
        //putLog("Subiendo al CDN el archivo mp4 -> " . $archivoMp4);
        $resMp4 = crearArchivoCDN($archivoMp4, $fileNameMp4, $tipoVideo);

        //Subimos al cdn el archivo ogv
        $path = pathinfo($archivoOgv);
        $fileNameOgv = $path['basename'];

        $resOgv = crearArchivoCDN($archivoOgv, $fileNameOgv, $tipoVideo);

        require_once 'modulos/cursos/modelos/ClaseModelo.php';

        if (isset($resMp4) && isset($resOgv)) {
            $uriMp4 = $resMp4['uri'];
            $uriOgv = $resOgv['uri'];
            $size = floatval($resMp4['size']) + floatval($resOgv['size']);
            actualizaArchivosDespuesTransformacion($idClase, $uriMp4, $uriOgv, $size);
            actualizaDuracionClase($idClase, $duration);
            //actualizamos el ancho de banda utilizado
            require_once('modulos/principal/modelos/variablesDeProductoModelo.php');
            deltaVariableDeProducto("usoActualAnchoDeBanda", $size);            

            //enviar emai de aviso
            $curso = getCursoPerteneciente($idClase);
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            $usuario = getUsuarioDeCurso($curso->idCurso);
            require_once 'modulos/email/modelos/envioEmailModelo.php';
            $clase = getClase($idClase);
            //enviarMailTransformacionVideoCompleta($usuario->email, $curso->titulo, $clase->titulo, 'www.unova.mx/curso/' . $curso->uniqueUrl);
            return 1;
        } else {
            return -1;
        }
    } else {
        //putLog("ERROR transformando a mp4 y ogv. ERROR = " . $res['return_var']);
        return -2;
    }
}

?>