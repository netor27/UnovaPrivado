<?php
//
//require_once 'funcionesPHP/funcionesGenerales.php';
//require_once 'funcionesPHP/uniqueUrlGenerator.php';
//require_once 'modulos/usuarios/modelos/usuarioModelo.php';
//
//getTipoUsuarioTexto();
//
//$tipos = array(0 => "alumno", 2 => "administrador", 3 => "profesor"); //alumno
//foreach ($tipos as $tipo => $texto) {
//    $numUsuarios = rand(50, 100);
//    for ($i = 0; $i < $numUsuarios; $i++) {
//        $usuario = new Usuario();
//        $usuario->email = $texto . "_" . $i . "@unova.mx";
//        $usuario->password = md5($texto . "_" . $i);
//        $usuario->nombreUsuario = $texto . "_" . $i;
//        $usuario->uniqueUrl = getUsuarioUniqueUrl($usuario->nombreUsuario);
//        $usuario->tipoUsuario = $tipo;
//        $res = altaUsuario($usuario);
//        print_r($res);        
//        echo '<br>';
//    }
//    echo "&&&&&&&&&&&&  Se dieron de alta " . $numUsuarios . " del tipo " . $tipo."<br>";
//}
?>