<?php

require_once 'modulos/editorPopcorn/clases/ArchivoExtra.php';

function agregarArchivoExtra($archivoExtra) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT INTO editor_archivosextra (idClase, link)
                            VALUES (:idClase, :link)");
    $stmt->bindParam(':idClase', $archivoExtra->idClase);
    $stmt->bindParam(':link', $archivoExtra->link);
    $id = -1;
    $val = $stmt->execute();
    if ($val) {
        $id = $conex->lastInsertId();
    } else {
        print_r($stmt->errorInfo());
    }
    return $id;
}

function getArchivosExtraDeClase($idClase) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT *
                            FROM editor_archivosextra
                            WHERE idClase = :idClase");
    $stmt->bindParam(":idClase",$idClase);
    
    if (!$stmt->execute())
        print_r($stmt->errorInfo());
    $rows = $stmt->fetchAll();

    $archivos = null;
    $archivo = null;
    $i = 0;
    foreach ($rows as $row) {
        $archivo = new ArchivoExtra();
        $archivo->idArchivoExtra = $row['idArchivoExtra'];
        $archivo->idClase = $row['idClase'];
        $archivo->link = $row['link'];
        $archivos[$i] = $archivo;
        $i++;
    }
    return $archivos;
}

function borrarArchivoExtra($idArchivoExtra){
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("DELETE FROM editor_archivosextra
                            WHERE idArchivoExtra = :idArchivoExtra");
    $stmt->bindParam(':idArchivoExtra', $idArchivoExtra);    
    if(!$stmt->execute()){
        print_r($stmt->errorInfo());
        return false;
    }else{
        return true;
    }
    
}
?>