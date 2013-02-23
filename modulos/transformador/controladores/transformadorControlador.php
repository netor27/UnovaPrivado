<?php

require_once 'funcionesPHP/ConfiguracionPrivada.php';

function transformarArchivo($idArchivo) {
    require_once 'modulos/transformador/modelos/archivoPorTransformarModelo.php';
    $archivo = getArchivoPorTransformar($idArchivo);
    if (isset($archivo)) {
        $idClase = $archivo['idClase'];
        $idTipoClase = $archivo['idTipoClase'];
        //$archivo['archivo'];

        require_once 'modulos/transformador/modelos/transformadorModelo.php';
        switch ($idTipoClase) {
            case 0:
                //es un video
                modificarArchivoEstadoMensaje($idArchivo, "Identificado", "Es un archivo de video, se procedera a transformar");
                $res = transformarVideo($archivo['archivo']);
                $filePath = "archivos/video/";
                break;
            case 4:
                //es audio
                modificarArchivoEstadoMensaje($idArchivo, "Identificado", "Es un archivo de audio, se procedera a transformar");
                $res = transformarAudio($archivo['archivo']);
                $filePath = "archivos/audio/";
                break;
            default:
                modificarArchivoEstadoMensaje($idArchivo, "No identificado", "No se identifico el archivo");
                break;
        }
        if (isset($res)) {
            $returnVar = $res['return_var'];
            if ($returnVar != -2) {
                modificarArchivoEstadoMensaje($idArchivo, "Transformado", "La transformacion fue correcta");
                $archivoMp = $res['outputFileMp'];
                $archivoOg = $res['outputFileOg'];
                $duration = $res['duration'];
                if ($returnVar == 0) {
                    modificarArchivoEstadoMensaje($idArchivo, "Por mover", "Antes de mover a la carpeta archivos/video");
                    //Cambiamos el archivo de carpeta a archivos/video o archivos/audio
                    $path = pathinfo($archivoMp);
                    $archivoNuevoMp = $filePath . $path['basename'];
                    $resMp = rename($archivoMp, $archivoNuevoMp);

                    //Cambiamos el otro archivo de carpeta a archivos/video o archivos/audio
                    $path = pathinfo($archivoOg);
                    $archivoNuevoOg = $filePath . $path['basename'];
                    $resOg = rename($archivoOg, $archivoNuevoOg);

                    if ($resMp && $resOg) {
                        modificarArchivoEstadoMensaje($idArchivo, "Se movieron", "Los archivos se movieron correctamente");
                        require_once 'funcionesPHP/funcionesParaArchivos.php';
                        $size = getFileSize($archivoNuevoMp) + getFileSize($archivoNuevoOg);

                        require_once 'modulos/cursos/modelos/ClaseModelo.php';
                        $uriMp = $archivoNuevoMp;
                        $uriOg = $archivoNuevoOg;
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
                            if (enviarMailTransformacionVideoCompleta($usuario->email, $curso->titulo, $clase->titulo, getDomainName() . '/curso/' . $curso->uniqueUrl, $idTipoClase)) {
                                //todo paso bien, eliminamos la tupla de la bd
                                bajaArchivoPorTransformar($idArchivo);
                                //se transformaron los 2 archivos correctamente, borramos el original
                                if (file_exists($archivo['archivo'])) {
                                    unlink($archivo['archivo']);
                                }
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
                        if (!$resMp) {
                            $msg .= "El archivo mp NO se movió, " . $archivoMp;
                        }
                        if (!$resOg) {
                            $msg .= "El archivo og NO se movió, " . $archivoOg;
                        }
                        establecerEstadoArchivoEnBd($idArchivo, "Error al mover los archivos", "Alguno de los archivos no se movieron. log= " . $msg);
                        return "No se movieron los archivos a las carpetas correspondientes " . $idArchivo;
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
            }else {
                //el archivo no existe
                establecerEstadoArchivoEnBd($idArchivo, "No existe", "El archivo no existe: " . $archivo['archivo'] . ", return_value= " . $returnVar);
                return "El archivo no existe: " . $archivo['archivo'] . ", return_value= " . $returnVar;
            }
        } else {
            //error en el tipo de archivo
            establecerEstadoArchivoEnBd($idArchivo, "Archivo no reconocido", "El archivo no fue reconocido: " . $archivo['archivo']);
            return "Archivo no reconocido";
        }
    } else {
        //error al obtener los datos de la base de datos
        establecerEstadoArchivoEnBd($idArchivo, "Error al obtener datos de la bd", "Error al obtener datos de la bd del idArchivo: ",$idArchivo);
        return "Error al obtener datos de la bd idArchivo=" . $idArchivo;
    }
}

function establecerEstadoArchivoEnBd($idArchivo, $estado, $mensaje) {
    //enviamos un mail para avisar que algo pasó mal
    require_once 'modulos/email/modelos/envioEmailModelo.php';
    $linkPublicar = "<a href='" . getDomainName() . "/testQueueMessages.php?a=publicar&i=" . $idArchivo . "'>Publicar de nuevo</a>";
    $msg = "IdArchivo = " . $idArchivo . "<br> estado = '" . $estado . "' <br> mensaje = '" . $mensaje . "'";
    $msg .= "<br>Para publicar este archivo en la cola de mensajes, da click " . $linkPublicar;
    $subject = "Error en la transformacion - " . $idArchivo;
    enviarMailErrorTransformacion($msg, $subject);
    require_once 'modulos/transformador/modelos/archivoPorTransformarModelo.php';
    return modificarArchivoEstadoMensaje($idArchivo, $estado, $mensaje);
}

?>