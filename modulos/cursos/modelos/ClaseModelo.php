<?php

require_once 'modulos/cursos/clases/Clase.php';

function altaClase($clase) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT INTO clase (idTema, titulo, idTipoClase, archivo, transformado, usoDeDisco, duracion)
                             VALUES(:idTema, :titulo, :tipoClase, :archivo, :transformado, :usoDeDisco, :duracion)");
    $stmt->bindParam(':idTema', $clase->idTema);
    $stmt->bindParam(':titulo', $clase->titulo);
    $stmt->bindParam(':tipoClase', $clase->idTipoClase);
    $stmt->bindParam(':archivo', $clase->archivo);
    $stmt->bindParam(':transformado', $clase->transformado);
    $stmt->bindParam(':usoDeDisco', $clase->usoDeDisco);
    $stmt->bindParam(':duracion', $clase->duracion);
    $id = -1;
    if ($stmt->execute())
        $id = $conex->lastInsertId();
    else {
        print_r($stmt->errorInfo());
    }
    return $id;
}

function bajaClase($idClase) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("DELETE FROM clase WHERE idClase = :id");
    $stmt->bindParam(':id', $idClase);
    $stmt->execute();
    return $stmt->rowCount();
}

function actualizaInformacionClase($clase) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE clase 
                            SET titulo = :titulo, descripcion = :descripcion
                            WHERE idClase = :idClase");
    $stmt->bindParam(':titulo', $clase->titulo);
    $stmt->bindParam(':descripcion', $clase->descripcion);
    $stmt->bindParam(':idClase', $clase->idClase);
    return $stmt->execute();
}

function actualizaDuracionClase($idClase, $duration) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE clase SET duracion = :duracion
                            WHERE idClase = :idClase");
    $stmt->bindParam(':duracion', $duration);
    $stmt->bindParam(':idClase', $idClase);
    return $stmt->execute();
}

function actualizaCodigoClase($idClase, $codigo) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE clase SET codigo = :codigo
                            WHERE idClase = :idClase");
    $stmt->bindParam(':codigo', $codigo);
    $stmt->bindParam(':idClase', $idClase);
    return $stmt->execute();
}

function actualizaOrdenClase($idClase, $idTema, $orden) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE clase 
                            SET orden = :orden, idTema = :idTema
                            WHERE idClase = :idClase");
    $stmt->bindParam(':orden', $orden);
    $stmt->bindParam(':idTema', $idTema);
    $stmt->bindParam(':idClase', $idClase);
    return $stmt->execute();
}

function actualizaArchivosDespuesTransformacion($idClase, $archivo, $archivo2, $usoDeDisco, $duration) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE clase 
                            SET transformado = 1, archivo = :archivo , archivo2 = :archivo2, 
                            usoDeDisco = :usoDeDisco, duracion = :duracion
                            WHERE idClase = :idClase");
    $stmt->bindParam(':archivo', $archivo);
    $stmt->bindParam(':archivo2', $archivo2);
    $stmt->bindParam(':usoDeDisco', $usoDeDisco);
    $stmt->bindParam(':idClase', $idClase);
    $stmt->bindParam(':duracion', $duration);
    return $stmt->execute();
}

function getClase($idClase) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM clase where idClase = :idClase");
    $stmt->bindParam(':idClase', $idClase);
    $stmt->execute();
    $clase = NULL;
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $clase = new Clase();
        $clase->idClase = $row['idClase'];
        $clase->idTema = $row['idTema'];
        $clase->idTipoClase = $row['idTipoClase'];
        $clase->titulo = $row['titulo'];
        $clase->orden = $row['orden'];
        $clase->codigo = $row['codigo'];
        $clase->descripcion = $row['descripcion'];
        $clase->archivo = $row['archivo'];
        $clase->archivo2 = $row['archivo2'];
        $clase->transformado = $row['transformado'];
        $clase->view = $row['views'];
        $clase->duracion = $row['duracion'];
        $clase->usoDeDisco = $row['usoDeDisco'];
    }
    return $clase;
}

function getTiposClase() {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM tipoclase");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    $tiposClase = null;
    $i = 0;
    foreach ($rows as $row) {
        require_once 'modulos/cursos/clases/TipoClase.php';
        $tipoClase = new TipoClase();
        $tipoClase->idTipoClase = $row['idTipoClase'];
        $tipoClase->nombre = $row['nombre'];
        $tipoClase->descripcion = $row['descripcion'];
        $tipoClase->imagen = $row['imagen'];
        $tiposClase[$i] = $tipoClase;
        $i++;
    }
    return $tiposClase;
}

function clasePerteneceACurso($idCurso, $idClase) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("Select c.idCurso, cl.idClase
                             FROM curso c, tema t, clase cl
                             WHERE c.idCurso = t.idCurso AND t.idTema = cl.idTema 
                             AND c.idCurso = :idCurso AND cl.idClase = :idClase");
    $stmt->bindParam(":idCurso", $idCurso);
    $stmt->bindParam(":idClase", $idClase);
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
        return true;
    } else {
        return false;
    }
}

function getCursoPerteneciente($idClase) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("Select c.idCurso, c.idUsuario, c.titulo, c.uniqueUrl, c.descripcionCorta, c.descripcion, c.imagen, c.rating
                             FROM curso c, tema t, clase cl
                             WHERE c.idCurso = t.idCurso AND t.idTema = cl.idTema 
                             AND cl.idClase = :idClase");
    $stmt->bindParam(":idClase", $idClase);
    $curso = NULL;
    if ($stmt->execute()) {
        $row = $stmt->fetch();
        require_once 'modulos/cursos/clases/Curso.php';
        $curso = new Curso();
        $curso->idCurso = $row['idCurso'];
        $curso->idUsuario = $row['idUsuario'];
        $curso->titulo = $row['titulo'];
        $curso->uniqueUrl = $row['uniqueUrl'];
        $curso->descripcionCorta = $row['descripcionCorta'];
        $curso->descripcion = $row['descripcion'];
        $curso->imagen = $row['imagen'];
        $curso->rating = $row['rating'];
    }
    return $curso;
}

function sumarVistaClase($idClase) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE clase 
                            SET views = views + 1
                            WHERE idClase = :idClase");
    $stmt->bindParam(':idClase', $idClase);
    return $stmt->execute();
}

function obtenerIdSiguienteClase($idClase, $clases) {
    $idSiguienteClase = -1;
    $bandera = true;
    $i = 0;
    $numClases = sizeof($clases);
    while ($bandera && $i < $numClases) {
        if ($clases[$i]->idClase == $idClase) {
            if ($i + 1 < sizeof($clases)) {
                $idSiguienteClase = $clases[$i + 1]->idClase;
                $bandera = false;
            }
        }
        $i++;
    }
    return $idSiguienteClase;
}

function getTotalDiscoUtilizado() {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->query("SELECT SUM(usoDeDisco) as suma 
                          FROM clase");
    $count = 0;
    foreach ($stmt as $row) {
        $count = $row['suma'];
    }
    return $count;
}

function borrarClasesConArchivosDeUsuario($idUsuario) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT c.idClase, c.archivo, c.archivo2, c.idTipoClase, c.transformado
                            FROM clase c, tema t, curso cu
                            WHERE c.idTema = t.idTema 
                            AND t.idCurso = cu.idCurso
                            AND cu.idUsuario = :idUsuario");
    $stmt->bindParam(':idUsuario', $idUsuario);
    if (!$stmt->execute())
        print_r($stmt->errorInfo());
    $rows = $stmt->fetchAll();
    $clase = null;
    $todoOk = true;
    $error = "";
    foreach ($rows as $row) {
        $clase = new Clase();
        $clase->archivo = $row['archivo'];
        $clase->archivo2 = $row['archivo2'];
        $clase->idTipoClase = $row['idTipoClase'];
        $clase->idClase = $row['idClase'];
        $clase->transformado = $row['transformado'];
        if ($clase->transformado == 1) {
            require_once 'modulos/cdn/modelos/cdnModelo.php';
            $splitted = explode("/", $row['archivo']);
            $fileName = $splitted[sizeof($splitted) - 1];

            deleteArchivoCdn($fileName, $clase->idTipoClase);
            if ($clase->idTipoClase == 0 || $clase->idTipoClase == 4) {
                //si es video o audio borramos el archivo2
                $splitted = explode("/", $clase->archivo2);
                $fileName = $splitted[sizeof($splitted) - 1];
                deleteArchivoCdn($fileName, $clase->idTipoClase);
            }
            if (bajaClase($clase->idClase) == 0) {
                $todoOk = false;
                $error = "Ocurrió un error al borrar la clase";
            }
        } else {
            $todoOk = false;
            $error = "No puedes borrar el curso mientras uno de sus archivos se está transformando";
        }
    }
    return array(
        "res" => $todoOk,
        "error" => $error);
}

function borrarClasesConArchivosDeCurso($idCurso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT c.idClase, c.archivo, c.archivo2, c.idTipoClase, c.transformado
                            FROM clase c, tema t
                            WHERE c.idTema = t.idTema 
                            AND t.idCurso = :idCurso");
    $stmt->bindParam(':idCurso', $idCurso);
    if (!$stmt->execute())
        print_r($stmt->errorInfo());
    $rows = $stmt->fetchAll();
    $clase = null;
    $todoOk = true;
    $error = "";
    foreach ($rows as $row) {
        $clase = new Clase();
        $clase->archivo = $row['archivo'];
        $clase->archivo2 = $row['archivo2'];
        $clase->idTipoClase = $row['idTipoClase'];
        $clase->idClase = $row['idClase'];
        $clase->transformado = $row['transformado'];
        if ($clase->transformado == 1) {
            require_once 'modulos/cdn/modelos/cdnModelo.php';
            $splitted = explode("/", $row['archivo']);
            $fileName = $splitted[sizeof($splitted) - 1];

            deleteArchivoCdn($fileName, $clase->idTipoClase);
            if ($clase->idTipoClase == 0 || $clase->idTipoClase == 4) {
                //si es video borramos el archivo2
                $splitted = explode("/", $clase->archivo2);
                $fileName = $splitted[sizeof($splitted) - 1];
                deleteArchivoCdn($fileName, $clase->idTipoClase);
            }
            if (bajaClase($clase->idClase) == 0) {
                $todoOk = false;
                $error = "Ocurrió un error al borrar la clase";
            }
        } else {
            $todoOk = false;
            $error = "No puedes borrar el curso mientras uno de sus archivos se está transformando";
        }
    }
    return array(
        "res" => $todoOk,
        "error" => $error);
}

function crearClaseDeArchivo($idUsuario, $idCurso, $idTema, $fileName, $fileType) {
    require_once 'modulos/usuarios/modelos/usuarioModelo.php';
    require_once 'modulos/cursos/modelos/CursoModelo.php';
    require_once 'modulos/cursos/modelos/TemaModelo.php';
    $filePath = "archivos/temporal/uploaderFiles/";

    $res = array();
    //Validamos que el curso sea del usuario y que el tema sea del curso        
    if (getIdUsuarioDeCurso($idCurso) == $idUsuario && $idCurso == getIdCursoPerteneciente($idTema)) {
        //Revisamos que el nombre del archivo no pase de 50 caractéres
        if (strlen($fileName) > 50) {
            $auxFileName = substr($fileName, 0, 50);
            if (!rename($filePath . $fileName, $filePath . $auxFileName)) {
                //Ocurrió un error al renombrar el archivo
                $res['resultado'] = false;
                $res['mensaje'] = "El nombre del archivo no es válido";
            }
            $fileName = $auxFileName;
        }

        $pathInfo = pathinfo($filePath . $fileName);
        $clase = new Clase();
        $clase->idTema = $idTema;
        $clase->titulo = $pathInfo['filename'];
        $clase->idTipoClase = getTipoClase($fileType);

        if ($clase->idTipoClase == 0 || $clase->idTipoClase == 4) {
            //Si es video o audio creamos la clase con la bandera que todavía no se transforma
            //guardamos en la cola que falta transformar este video
            $clase->transformado = 0;
            $clase->usoDeDisco = 0;
            $clase->duracion = "00:00";
            $idClase = altaClase($clase);

            //agregamos en la base de datos que hay que transformar este video
            $file = $filePath . $fileName;
            require_once 'modulos/transformador/modelos/archivoPorTransformarModelo.php';
            $idArchivo = altaArchivoPorTransformar($clase->idTipoClase, $idClase, $file);

            //guardamos este id en la cola de transformacion
            require_once 'lib/php/beanstalkd/ColaMensajes.php';
            $colaMensajes = new ColaMensajes("colatrans");
            $colaMensajes->push($idArchivo);
            $res['resultado'] = true;
            $res['url'] = $file;
        } else {
            $clase->transformado = 1;
            //Si es de otro tipo, lo subimos al CDN de rackspace y creamos la clase
            require_once 'modulos/cdn/modelos/cdnModelo.php';
            $file = $filePath . $fileName;
            $pathInfo = pathinfo($file);

            //Le agregamos al nombre del archivo un codigo aleatorio de 5 caracteres
            $fileName = substr($pathInfo['filename'], 0, 150) . "_" . getUniqueCode(7) . "." . $pathInfo['extension'];
            $res = crearArchivoCDN($file, $fileName, $clase->idTipoClase);
            if ($res != NULL) {
                //Si se creo correctamene el archivo CDN, creamos la clase y borramos el archivo local
                $uri = $res['uri'];
                $size = $res['size'];
                $clase->archivo = $uri;
                $clase->usoDeDisco = $size;
                altaClase($clase);
                require_once('modulos/principal/modelos/variablesDeProductoModelo.php');
                deltaVariableDeProducto("usoActualAnchoDeBanda", $size);
                $res['resultado'] = true;
                $res['url'] = $clase->archivo;
            } else {
                //Si ocurrió un error, se borra y regresamos false
                unlink($file);
                $res['resultado'] = false;
                $res['mensaje'] = "Ocurrió un error al guardar tu archivo en nuestros servidores. Intenta de nuevo más tarde-";
            }
        }
    } else {
        //Hay errores en la integridad usuario <-> curso
        //borramos el archivo
        unlink($filePath . $fileName);
        $res['resultado'] = false;
        $res['mensaje'] = "No tienes permisos para modificar este curso";
    }
    return $res;
}

function getTipoClase($fileType) {
    //Si es video
    if (stristr($fileType, "video")) {
        return 0;
    }

    if (stristr($fileType, "presentation") || stristr($fileType, "powerpoint")) {
        return 1;
    }

    if (stristr($fileType, "word") || stristr($fileType, "pdf")) {
        return 2;
    }

    //tipo de clase 3 son las tarjetas de aprendizaje, no es un archivo

    if (stristr($fileType, "audio")) {
        return 4;
    }
}

?>