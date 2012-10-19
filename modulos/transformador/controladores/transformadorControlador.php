<?php

require_once 'funcionesPHP/ConfiguracionPrivada.php';

function transformarArchivo($idArchivo) {
    require_once 'modulos/transformador/modelos/archivoPorTransformarModelo.php';
    $archivo = getArchivoPorTransformar($idArchivo);
    //print_r($archivo);
    //$archivo['idArchivo'];
    //$archivo['idTipoClase'];
    $idClase = $archivo['idClase'];
    $idTipoClase = $archivo['idTipoClase'];
    //$archivo['archivo'];

    require_once 'modulos/transformador/modelos/transformadorModelo.php';

    switch ($idTipoClase) {
        case 0:
            //es un video
            $res = transformarVideo($archivo['archivo']);
            break;
        case 4:
            $res = transformarAudio($archivo['archivo']);
            //es audio
            break;
    }
    if (isset($res)) {
        $archivoMp = $res['outputFileMp'];
        $archivoOg = $res['outputFileOg'];
        $duration = $res['duration'];
        $returnVar = $res['return_var'];
        if ($returnVar == 0) {
            //se transformaron los 2 archivos correctamente, borramos el original
            if (file_exists($archivo['archivo']))
                unlink($archivo['archivo']);

            //Hay que subir los dos archivos al CDN
            require_once 'modulos/cdn/modelos/cdnModelo.php';

            //Subimos al cdn el archivo mp
            $path = pathinfo($archivoMp);
            $fileNameMp = $path['basename'];
            $resMp = crearArchivoCDN($archivoMp, $fileNameMp, $idTipoClase);

            //Subimos al cdn el archivo og
            $path = pathinfo($archivoOg);
            $fileNameOg = $path['basename'];
            $resOg = crearArchivoCDN($archivoOg, $fileNameOg, $idTipoClase);

            

            if (isset($resMp) && isset($resOg)) {
                $uriMp = $resMp['uri'];
                $uriOg = $resOg['uri'];
                $size = floatval($resMp['size']) + floatval($resOg['size']);

                require_once 'modulos/cursos/modelos/ClaseModelo.php';
                if (actualizaArchivosDespuesTransformacion($archivo['idClase'], $uriMp, $uriOg, $size, $duration)) {
                    //actualizamos el ancho de banda utilizado
                    require_once('modulos/principal/modelos/variablesDeProductoModelo.php');
                    deltaVariableDeProducto("usoActualAnchoDeBanda", $size);

                    //enviar emai de aviso
                    $curso = getCursoPerteneciente($idClase);
                    require_once 'modulos/cursos/modelos/CursoModelo.php';
                    $usuario = getUsuarioDeCurso($curso->idCurso);
                    require_once 'modulos/email/modelos/envioEmailModelo.php';
                    $clase = getClase($idClase);
                    if (enviarMailTransformacionVideoCompleta($usuario->email, $curso->titulo, $clase->titulo, DOMINIO_PRIVADO . '/curso/' . $curso->uniqueUrl, $idTipoClase)) {
                        //todo paso bien, eliminamos la tupla de la bd
                        bajaArchivoPorTransformar($idArchivo);
                        return "Archivo transformado correctamente " . $archivo['archivo'];
                    } else {
                        //no se envió el mail, pero se transformó correctamente
                        establecerEstadoArchivoEnBd($idArchivo, "Mail no enviado", "Todo se hizo correctamente pero no se envió el mail");
                        return "Todo se hizo correctamente pero no se envio el mail idArchivo=" . $idArchivo;
                    }
                } else {
                    //no se actualizó la bd con la información
                    establecerEstadoArchivoEnBd($idArchivo, "BD no actualizada", "No se actualizo la bd con la info de los archivos transformados, archivo1= " . $uriMp . " archivo 2= " . $uriOg);
                    return "No se actualizo la bd con la info de los archivos transformados idArchivo=" . $idArchivo;
                }
            } else {
                //no se subió alguno de los archivos al cdn
                $msg = "";
                if (isset($resMp)) {
                    $msg .= "El archivo mp se subió bien, " . $resMp['uri'];
                }
                if (isset($resOg)) {
                    $msg .= "El archivo og se subió bien, " . $resOg['uri'];
                }
                establecerEstadoArchivoEnBd($idArchivo, "Error al subir al CDN", "Alguno de los archivos no se subió al cdn. log= " . $msg);
                return "Todo se hizo correctamente pero no se envio el mail idArchivo=" . $idArchivo;
            }
        } else {
            //ocurrió un error, si exite alguno de los archivos, lo borramos.            
            if (file_exists($archivoMp))
                unlink($archivoMp);
            if (file_exists($archivoOg))
                unlink($archivoOg);

            establecerEstadoArchivoEnBd($idArchivo, "No transformado", "Ocurrio un error al momento de transformar el archivo " . $archivo['archivo'] . ", return_value=" . $returnVar);
            return "Error en la transformación del archivo, return_value=" . $returnVar;
        }
    } else {
        //error en el tipo de archivo
        return "Archivo no reconocido";
    }
}

function establecerEstadoArchivoEnBd($idArchivo, $estado, $mensaje) {
    //enviamos un mail para avisar que algo pasó mal
    require_once 'modulos/email/modelos/envioEmailModelo.php';
    $msg = "IdArchivo = " . $idArchivo . ", estado = '" . $estado . "' , mensaje = '" . $mensaje . "'";
    enviarMailErrorTransformacion($msg);
    require_once 'modulos/transformador/modelos/archivoPorTransformarModelo.php';
    return modificarArchivoEstadoMensaje($idArchivo, $estado, $mensaje);
}

?>