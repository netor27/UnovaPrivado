<?php

require_once 'bd/conex.php';

function altaArchivoPorTransformar($idTipoClase, $idClase, $archivo) {
    global $conex;
    $stmt = $conex->prepare("INSERT INTO archivo(idTipoClase, idClase, archivo, estado, mensaje)
                                  VALUES(:idTipoClase, :idClase, :archivo, 'sin transformar', 'Insert inicial')");
    $stmt->bindParam(":idTipoClase", $idTipoClase);
    $stmt->bindParam(":idClase", $idClase);
    $stmt->bindParam(":archivo", $archivo);
    $id = -1;
    if ($stmt->execute())
        $id = $conex->lastInsertId();
    else {
        print_r($stmt->errorInfo());
    }
    return $id;
}

function bajaArchivoPorTransformar($id){
    global $conex;
    $stmt = $conex->prepare("DELETE FROM archivo WHERE idArchivo = :id");
    $stmt->bindParam(":id",$id);
    return $stmt->execute();
}

function modificarArchivoEstadoMensaje($id, $estado, $mensaje) {
    global $conex;
    $stmt = $conex->prepare("UPDATE archivo SET estado = :estado, mensaje = :mensaje
                            WHERE idArchivo = :id");
    $stmt->bindParam(":estado", $estado);
    $stmt->bindParam(":mensaje", $mensaje);
    $stmt->bindParam(":id", $id);
    return $stmt->execute();
}

function getArchivoPorTransformar($id){
    global $conex;
    $stmt = $conex->prepare("SELECT * from archivo WHERE idArchivo = :id");
    $stmt->bindParam(":id", $id);
    if($stmt->execute()){
        $row = $stmt->fetch();
        return $row;
    }else{
        return null;
    }
}

?>