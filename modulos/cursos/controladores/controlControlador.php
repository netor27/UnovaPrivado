<?php

function agregarPregunta() {
    $res = "error";
    $msg = "";
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
                //$_POST['pregunta']
                $pregunta = $_POST['pregunta'];
                //contiene idTipoControlPregunta, pregunta, respuesta, inicio
                require_once 'modulos/cursos/modelos/ControlModelo.php';
                //Obtenemos el "control" correspondiente a esta clase
                $control = getControlDeClase($idClase);
                if (!isset($control)) {
                    //si el "control" no existe, lo creamos
                    $idControl = altaControl($idClase);
                    if ($idControl < 0) {
                        $msg = 'Error al crear el control';
                    } else {
                        $control = new Control();
                        $control->idControl = $idControl;
                    }
                }
                if ($msg == "") {
                    require_once 'modulos/cursos/modelos/ControlPreguntaModelo.php';
                    $controlPregunta = new ControlPregunta();
                    $controlPregunta->idControl = $control->idControl;
                    $controlPregunta->idTipoControlPregunta = $pregunta['idTipoControlPregunta'];
                    $controlPregunta->pregunta = $pregunta['pregunta'];
                    $controlPregunta->respuesta = $pregunta['respuesta'];
                    $idPregunta = altaControlPregunta($controlPregunta);
                    if ($idPregunta >= 0) {
                        $res = "ok";
                        $msg = $idPregunta;
                    } else {
                        $msg = "Error al agregar pregunta en la bd";
                    }
                }
            } else {
                //Error en la integridad usuario-curso-clase
                $msg = "Error de integridad usuario-curso-clase";
            }
        } else {
            //Error en los datos recibidos
            $msg = "Datos recibidos incorrectos";
        }
    } else {
        //Usuario no loggeado
        $msg = "usuario no loggeado";
    }
    echo json_encode(array("res" => $res, "mensaje" => $msg));
}

function editarPregunta() {
    $res = "error";
    $msg = "";
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
                //$_POST['pregunta']
                $pregunta = $_POST['pregunta'];
                //contiene idControlPregunta, pregunta, respuesta
                require_once 'modulos/cursos/modelos/ControlPreguntaModelo.php';
                $controlPregunta = new ControlPregunta();
                $controlPregunta->idControlPregunta = $pregunta['idControlPregunta'];
                $controlPregunta->pregunta = $pregunta['pregunta'];
                $controlPregunta->respuesta = $pregunta['respuesta'];

                if (actualizarControlPregunta($controlPregunta)) {
                    $res = "ok";
                } else {
                    $msg = "Error al actualizar pregunta en la bd";
                }
            } else {
                //Error en la integridad usuario-curso-clase
                $msg = "Error de integridad usuario-curso-clase";
            }
        } else {
            //Error en los datos recibidos
            $msg = "Datos recibidos incorrectos";
        }
    } else {
        //Usuario no loggeado
        $msg = "usuario no loggeado";
    }
    echo json_encode(array("res" => $res, "mensaje" => $msg));
}

function borrarPregunta() {
    $res = "error";
    $msg = "";
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
                //$_POST['idPregunta']
                $idPregunta = $_POST['idPregunta'];
                //contiene idControlPregunta
                require_once 'modulos/cursos/modelos/ControlPreguntaModelo.php';
                if (bajaControlPregunta($idPregunta)) {
                    $res = "ok";
                } else {
                    $msg = "Error al agregar pregunta en la bd";
                }
            } else {
                //Error en la integridad usuario-curso-clase
                $msg = "Error de integridad usuario-curso-clase";
            }
        } else {
            //Error en los datos recibidos
            $msg = "Datos recibidos incorrectos";
        }
    } else {
        //Usuario no loggeado
        $msg = "usuario no loggeado";
    }
    echo json_encode(array("res" => $res, "mensaje" => $msg));
}

function obtenerPregunta() {
    $res = "error";
    $msg = "";
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
                //$_POST['idPregunta']
                $idPregunta = $_POST['idPregunta'];
                require_once 'modulos/cursos/modelos/ControlPreguntaModelo.php';
                $pregunta = getPregunta($idPregunta);
                if (isset($pregunta) && !is_null($pregunta)) {
                    $res = "ok";
                    $msg = json_encode($pregunta);
                } else {
                    $res = "borrar";
                    $msg = "la pregunta no existe";
                }
            } else {
                //Error en la integridad usuario-curso-clase
                $msg = "Error de integridad usuario-curso-clase";
            }
        } else {
            //Error en los datos recibidos
            $msg = "Datos recibidos incorrectos";
        }
    } else {
        //Usuario no loggeado
        $msg = "usuario no loggeado";
    }
    echo json_encode(array("res" => $res, "mensaje" => $msg));
}

function obtenerPreguntaAlumno() {
    $res = "error";
    $msg = "";
    if (validarUsuarioLoggeado()) {
        $usuario = getUsuarioActual();
        require_once 'modulos/cursos/modelos/ClaseModelo.php';
        require_once 'modulos/cursos/modelos/CursoModelo.php';
        //$_POST['idPregunta']
        $idPregunta = $_POST['idPregunta'];
        require_once 'modulos/cursos/modelos/ControlPreguntaModelo.php';
        $pregunta = getPregunta($idPregunta);
        if (isset($pregunta) && !is_null($pregunta)) {
            $res = "ok";
            $msg = json_encode($pregunta);
        }else{
            $msg = "la pregunta no existe";
        }
    } else {
        //Usuario no loggeado
        $msg = "usuario no loggeado";
    }
    echo json_encode(array("res" => $res, "mensaje" => $msg));
}

?>