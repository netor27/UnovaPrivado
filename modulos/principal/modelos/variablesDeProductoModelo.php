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
?>