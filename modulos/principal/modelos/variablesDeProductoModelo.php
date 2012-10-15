<?php

function actualizaVariableDeProducto($nombre, $valor) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE variablesDeProducto 
                            SET valor = :valor
                            WHERE nombre = :nombre");
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':nombre', $nombre);
    return $stmt->execute();
}

function deltaVariableDeProducto($nombre, $delta) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE variablesDeProducto 
                            SET valor = valor + :delta
                            WHERE nombre = :nombre");
    $stmt->bindParam(':delta', $delta);
    $stmt->bindParam(':nombre', $nombre);
    return $stmt->execute();
}

function getVariableDeProducto($nombre) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT valor FROM variablesdeproducto 
                            WHERE nombre = :nombre");
    $stmt->bindParam(':nombre', $nombre);
    $stmt->execute();
    $valor = NULL;
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $valor = $row['valor'];
    }
    return $valor;
}

function agregarArchivoPendientePorBorrar($archivo){
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT INTO archivopendienteporborrar (archivo)
                             VALUES(:archivo)");
    $stmt->bindParam(':archivo', $archivo);
    return $stmt->execute();
}
?>