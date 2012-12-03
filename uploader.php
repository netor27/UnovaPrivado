<?php

error_reporting(E_ALL | E_STRICT);

require_once 'funcionesPHP/funcionesGenerales.php';

require('lib/php/jqueryFileUpload/upload.class.php');

$upload_handler = new UploadHandler();

header('Pragma: no-cache');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Content-Disposition: inline; filename="files.json"');
header('X-Content-Type-Options: nosniff');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'OPTIONS':
        break;
    case 'HEAD':
    case 'GET':
        $upload_handler->get();
        break;
    case 'POST':
        if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
            $upload_handler->delete();
        } else {
            $info = array();
            $file = new stdClass();
            //validamos los datos del POST
            if (isset($_POST['idUsuario']) && isset($_POST['idCurso']) && isset($_POST['idTema']) && isset($_POST['uuid'])) {
                require_once 'modulos/usuarios/clases/Usuario.php';
                require_once 'funcionesPHP/funcionesGenerales.php';
                session_start();
                $uuid = $_POST['uuid'];
                
                require_once 'modulos/usuarios/modelos/usuarioModelo.php';
                $usuario = getUsuarioFromUuid($uuid);
                $idUsuario = $_POST['idUsuario'];
                $idCurso = $_POST['idCurso'];
                $idTema = $_POST['idTema'];
                
                //validamos un usuario correcto
                if (isset($usuario) && $idUsuario == $usuario->idUsuario) {
                    $info = $upload_handler->post();
                    $file = $info[0];
                    if (!isset($file->error)) {
                        //No hubo error en la subida de los archivos
                        require_once 'modulos/cursos/modelos/ClaseModelo.php';
                        $res = crearClaseDeArchivo($idUsuario, $idCurso, $idTema, $file->name, $file->type);
                        if ($res['resultado']) {                        
                            $file->url = $res['url'];
                            $file->delete_url = "#";
                            $file->error = "";
                        } else {
                            $file->error = $res['mensaje'];
                        }
                    } 
                } else {
                    //error de login
                    $file->error = "Tus datos de sesión son incorrectos";
                }
            } else {
                //error de datos
                $file->error = "Los datos recibidos no son válidos";
            }
            $info[0] = $file;
            writeJSON($info);
        }
        break;
    default:
        header('HTTP/1.1 405 Method Not Allowed');
}

function writeJSON($info) {
    header('Vary: Accept');
    $json = json_encode($info);
    $redirect = isset($_REQUEST['redirect']) ?
            stripslashes($_REQUEST['redirect']) : null;
    if ($redirect) {
        header('Location: ' . sprintf($redirect, rawurlencode($json)));
        return;
    }
    if (isset($_SERVER['HTTP_ACCEPT']) &&
            (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
        header('Content-type: application/json');
    } else {
        header('Content-type: text/plain');
    }
    echo $json;
}