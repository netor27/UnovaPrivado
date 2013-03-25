<?php

function agregarControlSubmit() {
    $res = "error";
    if (validarUsuarioLoggeado()) {
        if (isset($_POST['u']) && isset($_POST['uuid']) && isset($_POST['cu']) && isset($_POST['cl'])) {
            $idUsuario = $_POST['u'];
            $uuid = $_POST['uuid'];
            $idCurso = $_POST['cu'];
            $idClase = $_POST['cl'];

            $usuario = getUsuarioActual();
            require_once 'modulos/cursos/modelos/ClaseModelo.php';
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            if ($usuario->idUsuario == getIdUsuarioDeCurso($idCurso)
                    && $usuario->idUsuario == $idUsuario
                    && $usuario->uuid == $uuid
                    && clasePerteneceACurso($idCurso, $idClase)) {
                require_once 'modulos/cursos/modelos/ControlModelo.php';
                $idControl = altaControl($idClase);
                if($idControl >= 0){
                    $res = "ok";
                    $msg = $idControl;
                }else{
                    //No se agrego a la bd
                    $msg = "Error al agregar archivo en la bd";
                }
            }else{
                //Error en la integridad usuario-curso-clase
                $msg = "Error de integridad usuario-curso-clase";
            }
        }else{
            //Error en los datos recibidos
            $msg = "Datos recibidos incorrectos";
        }
    }else{
        //Usuario no loggeado
        $msg = "usuario no loggeado";
    }
    $resultado = array(
        "res" => $res,
        "mensaje" => $msg
    );
    $resultado = json_encode($resultado);
    echo $resultado;
}

function borrarControl() {
    
}

?>