<?php
require_once 'modulos/editorPopcorn/clases/FormaPredefinida.php';

function getFormasPredefinidas() {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT idFormaPredefinida, nombre, imagen
                            FROM editor_formaspredefinidas
                            ORDER BY nombre ASC");
    if (!$stmt->execute())
        print_r($stmt->errorInfo());
    $rows = $stmt->fetchAll();

    $formas = null;
    $forma = null;
    $i = 0;
    foreach ($rows as $row) {
        $forma = new FormaPredefinida();
        $forma->idFormaPredefinida = $row['idFormaPredefinida'];
        $forma->nombre = $row['nombre'];
        $forma->imagen = $row['imagen'];
        $formas[$i] = $forma;
        $i++;
    }
    return $formas;
}

?>