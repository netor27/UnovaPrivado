<?php

require_once 'modulos/cursos/modelos/DiscusionModelo.php';
require_once 'funcionesPHP/funcionesGenerales.php';
for ($i = 0; $i < 100; $i++) {
    $discusion = new Discusion();
    $discusion->idCurso = 47;
    $discusion->idUsuario = rand(181, 188);
    $discusion->titulo = "Titulo de la discusion " . rand(1, 100);
    $discusion->texto = " Este es el texto " . getUniqueCode();

    $id = altaDiscusion($discusion);
    echo '<br>se dio de alta la discusion ' . $id;
}