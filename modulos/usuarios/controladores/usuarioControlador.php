<?php

function principal() {
    if (validarAdministradorPrivado()) {
        listarUsuarios("alumnos");
    } else {
        goToIndex();
    }
}

function listaProfesores() {
    if (validarAdministradorPrivado()) {
        listarUsuarios("profesores");
    } else {
        goToIndex();
    }
}

function listaAdministradores() {
    if (validarAdministradorPrivado()) {
        listarUsuarios("administradores");
    } else {
        goToIndex();
    }
}

function listarUsuarios($tipo) {
    if (isset($tipo)) {
        $offset = 0;
        $numRows = 16;
        $pagina = 1;
        if (isset($_GET['p'])) {
            if (is_numeric($_GET['p'])) {
                $pagina = intval($_GET['p']);
                $offset = $numRows * ($pagina - 1);
            }
        }
        require_once 'modulos/usuarios/modelos/usuarioModelo.php';
        $tipoUsuarioAlumno = 0;
        switch ($tipo) {
            case 'alumnos':
                $tipoUsuarioAlumno = 0;
                break;
            case 'profesores':
                $tipoUsuarioAlumno = 3;
                break;
            case 'administradores':
                $tipoUsuarioAlumno = 2;
                break;
        }
        $res = getUsuariosPorTipo($tipoUsuarioAlumno, $offset, $numRows);
        $usuarios = $res['usuarios'];
        $numUsuarios = $res['n'];
        $maxPagina = ceil($numUsuarios / $numRows);
        if ($pagina != 1 && $pagina > $maxPagina) {
            redirect('/' . $tipo . '&p=' . $maxPagina);
        } else {
            clearBreadCrumbs();
            pushBreadCrumb(getUrl(), "Lista de " . $tipo, true);
            require_once 'modulos/usuarios/vistas/principal.php';
        }
    } else {
        goToIndex();
    }
}

function detalles() {
    $uniqueUrl = $_GET['i'];
    require_once 'modulos/usuarios/modelos/usuarioModelo.php';
    //$usuarioPerfil = getUsuario($idUsuario);
    $usuarioPerfil = getUsuarioFromUniqueUrl($uniqueUrl);

    if (!is_null($usuarioPerfil)) {
        $tituloPagina = $usuarioPerfil->nombreUsuario;
        $titulo = $usuarioPerfil->nombreUsuario;
        $imageThumbnail = $usuarioPerfil->avatar;
        $descripcion = $usuarioPerfil->tituloPersonal;

        $miPerfil = false;
        if (validarUsuarioLoggeadoParaSubmits()) {
            if (getUsuarioActual()->idUsuario == $usuarioPerfil->idUsuario) {
                $miPerfil = true;
            }
        }
        require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
        $numTomados = getNumeroCursosTomados($usuarioPerfil->idUsuario);
        $numCursos = getNumeroCursosCreados($usuarioPerfil->idUsuario);
        pushBreadCrumb(getUrl(), $usuarioPerfil->nombreUsuario,true);
        require_once 'modulos/usuarios/vistas/perfil.php';
    } else {
        setSessionMessage("El usuario no existe", " ¡Error! ", "error");
        redirect("/");
    }
}

function editarInformacion() {
    if (validarUsuarioLoggeado()) {
        $id = getUsuarioActual()->idUsuario;
        require_once 'modulos/usuarios/modelos/usuarioModelo.php';
        $usuario = getUsuario($id);
        require_once 'modulos/usuarios/vistas/editarPerfil.php';
    }
}

function editarInformacionSubmit() {
    if (validarUsuarioLoggeadoParaSubmits()) {
        $usuarioParaEditar = getUsuarioActual();
        $nombreAnterior = $usuarioParaEditar->nombreUsuario;
        if (isset($_POST['nombre']))
            $usuarioParaEditar->nombreUsuario = strip_tags(trim($_POST['nombre']));
        if (isset($_POST['tituloPersonal']))
            $usuarioParaEditar->tituloPersonal = str_replace('"', '', strip_tags(trim($_POST['tituloPersonal'])));
        if (isset($_POST['bio']))
            $usuarioParaEditar->bio = trim($_POST['bio']);

        require_once 'modulos/usuarios/modelos/usuarioModelo.php';
        if ($nombreAnterior != $usuarioParaEditar->nombreUsuario) {
            require_once 'funcionesPHP/uniqueUrlGenerator.php';
            $usuarioParaEditar->uniqueUrl = getUsuarioUniqueUrl($usuarioParaEditar->nombreUsuario);
        }
        if (actualizaInformacionUsuario($usuarioParaEditar)) {
            cargarUsuarioSession();
            setSessionMessage("Se actualizó tu información de perfil", " ¡Bien! ", "success");
            redirect("/usuario/" . $usuarioParaEditar->uniqueUrl);
        } else {
            $error = "Ocurrió un error al actualizar tu información. <br>Intenta de nuevo más tarde";
            $usuario = getUsuario($usuarioParaEditar->idUsuario);
            require_once 'modulos/usuarios/vistas/editarPerfil.php';
        }
    } else {
        goToIndex();
    }
}

function cambiarImagen() {
    if (validarUsuarioLoggeado()) {
        require_once 'modulos/usuarios/modelos/usuarioModelo.php';
        $usuarioCambiar = getUsuario(getUsuarioActual()->idUsuario);
        require_once 'modulos/usuarios/vistas/editarImagen.php';
    }
}

function cambiarImagenSubmit() {
    if (validarUsuarioLoggeadoParaSubmits()) {
        if (isset($_FILES['imagen'])) {
            $anchoImagen = 200;
            $altoImagen = 200;
            require_once 'modulos/usuarios/modelos/usuarioModelo.php';
            $usuarioCambiar = getUsuario(getUsuarioActual()->idUsuario);
            if ((($_FILES["imagen"]["type"] == "image/jpeg")
                    || ($_FILES["imagen"]["type"] == "image/pjpeg")
                    || ($_FILES["imagen"]["type"] == "image/png"))
                    && ($_FILES["imagen"]["size"] < 10485760)) {//tamaño maximo de imagen de 10MB                
                require_once 'funcionesPHP/CropImage.php';
                //guardamos la imagen en el formato original
                $file = "archivos/temporal/original_" . $_FILES["imagen"]["name"];

                if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $file)) {
                    $dest = "archivos/temporal/cropped_" . $_FILES["imagen"]["name"];
                    //Hacemos el crop de la imagen
                    if (cropImage($file, $dest, $altoImagen, $anchoImagen)) {
                        //Se hizo el crop correctamente                    
                        //borramos la imagen original
                        unlink($file);
                        //Subimos la imagen recortada al S3 de Amazon
                        require_once 'modulos/aws/modelos/s3Modelo.php';
                        $res = uploadFileToS3($dest, "avatars");
                        //borramos la imagen con crop                                
                        unlink($dest);
                        if ($res['res']) {
                            $imagenAnterior = $usuarioCambiar->avatar;
                            $usuarioCambiar->avatar = $res['link'];
                            //actualizamos la información en la bd                
                            if (actualizaAvatar($usuarioCambiar)) {
                                //se actualizo correctamente la imagen, borramos la anterior
                                if (strpos($imagenAnterior, "http") !== false) {
                                    //Es una imagen en el S3, la borramos
                                    deleteFileFromS3ByUrl($imagenAnterior);
                                } else {
                                    //Es una imagen predefinida, no borrar!
                                }
                                require_once 'funcionesPHP/CargarInformacionSession.php';
                                cargarUsuarioSession();
                                setSessionMessage("Haz cambiado tu imagen correctamente. Espera unos minutos para ver el cambio", " ¡Bien! ", "success");
                                redirect("/usuario/" . $usuarioCambiar->uniqueUrl);
                            } else {
                                //error en bd
                                setSessionMessage("Error al actualizar la base de datos", " ¡Error! ", "error");
                                redirect("/usuarios/usuario/cambiarImagen");
                            }
                        } else {
                            //No se subió la imagen
                            setSessionMessage("Ocurrió un error al guardar la imagen en nuestros servidores. Intenta de nuevo más tarde", " ¡Error! ", "error");
                            redirect("/usuarios/usuario/cambiarImagen");
                        }
                    } else {
                        //borramos la imagen temporal
                        unlink($file);
                        //No se pudo hacer el "crop" de la imagen
                        setSessionMessage("Ocurrió un error al procesar tu imagen. Intenta de nuevo más tarde", " ¡Error! ", "error");
                        redirect("/cursos/curso/cambiarImagen/" . $cursoParaModificar->idCurso);
                    }
                } else {
                    //No se subió la imagen
                    setSessionMessage("Ocurrió un error al recibir tu imagen. Intenta de nuevo más tarde", " ¡Error! ", "error");
                    redirect("/usuarios/usuario/cambiarImagen");
                }
            } else {
                //El archivo no es válido o es demasiado grande
                setSessionMessage("No es una imagen válida. El tamaño máximo es de 10MB y formato png o jpg", " ¡Error! ", "error");
                redirect("/usuarios/usuario/cambiarImagen");
            }
        } else {
            setSessionMessage("No es una imagen válida", " ¡Espera! ", "error");
            redirect("/usuarios/usuario/cambiarImagen");
        }
    } else {
        goToIndex();
    }
}

function cambiarPassword() {
    if (validarUsuarioLoggeado()) {
        $usuario = getUsuarioActual();
        require_once 'modulos/usuarios/vistas/cambiarPassword.php';
    }
}

function cambiarPasswordSubmit() {
    if (validarUsuarioLoggeadoParaSubmits()) {
        if (isset($_POST['pass1']) && isset($_POST['pass2']) && isset($_POST['passAnt'])) {
            $usuario = getUsuarioActual();
            $passAnterior = md5($_POST['passAnt']);
            require_once 'modulos/usuarios/modelos/usuarioModelo.php';
            if (validarPassAnterior($usuario->idUsuario, $passAnterior)) {
                $pass1 = trim($_POST['pass1']);
                $pass2 = trim($_POST['pass2']);
                if (strlen($pass1) >= 5 && strlen($pass1) >= 5 && $pass1 == $pass2) {
                    $usuario->password = md5($pass1);
                    actualizaPassword($usuario);
                    setSessionMessage("Se cambió correctamente tu contraseña", " ¡Bien! ", "success");
                    redirect("/usuario/" . $usuario->uniqueUrl);
                } else {
                    $msgForma = "La contraseña no es válida";
                    require_once 'modulos/usuarios/vistas/cambiarPassword.php';
                }
            } else {
                $msgForma = "La contraseña anterior no es correcta.";
                require_once 'modulos/usuarios/vistas/cambiarPassword.php';
            }
        } else {
            $msgForma = "Los datos no son válidos";
            require_once 'modulos/usuarios/vistas/cambiarPassword.php';
        }
    } else {
        goToIndex();
    }
}

function recuperarPassword() {
    require_once 'modulos/usuarios/vistas/recuperarPassword.php';
}

function recuperarPasswordSubmit() {
    if (isset($_POST['email'])) {
        require_once 'modulos/usuarios/modelos/usuarioModelo.php';
        $email = $_POST['email'];

        $uuid = getUUIDFromEmail($email);
        if (!empty($uuid)) {

            $link = getDomainName() . "/usuarios/usuario/reestablecerPassword/" . $uuid;
            //Enviar el mail //
            require_once 'modulos/email/modelos/envioEmailModelo.php';
            enviarMailOlvidePassword($email, $link);
            setSessionMessage("Te hemos enviado un correo electrónico para que reestablescas tu contraseña.", "", "info");
        } else {
            setSessionMessage("No tenemos registrado este correo electrónico.", " ¡Espera! ", "error");
        }
    }
    goToIndex();
}

function reestablecerPassword() {
    $uuid = $_GET['i'];
    require_once 'modulos/usuarios/vistas/reestablecerPassword.php';
}

function reestablecerPasswordSubmit() {
    if (isset($_POST['uuid']) && isset($_POST['pass1']) && isset($_POST['pass2'])) {
        $pass1 = trim($_POST['pass1']);
        $pass2 = trim($_POST['pass2']);
        $uuid = trim($_POST['uuid']);
        require_once 'modulos/usuarios/modelos/usuarioModelo.php';
        $usuario = getUsuarioFromUuid($uuid);
        if (isset($usuario)) {
            if ($pass1 == $pass2 && strlen($pass1) >= 5) {
                require_once 'modulos/usuarios/modelos/usuarioModelo.php';
                if (reestablecerPasswordPorUUID($uuid, md5($pass1)) > 0) {

                    require_once 'modulos/principal/modelos/loginModelo.php';
                    loginUsuario($usuario->email, $usuario->password, false);
                    setSessionMessage("Se guardó tu nueva contraseña", " ¡Bien! ", "success");
                    goToIndex();
                } else {
                    $msgForma = "Ocurrió un error al cambiar tu contraseña. Intenta de nuevo más tarde.";
                    require_once 'modulos/usuarios/vistas/reestablecerPassword.php';
                }
            } else {
                $msgForma = "Los datos que introduciste no son válidos.";
                require_once 'modulos/usuarios/vistas/reestablecerPassword.php';
            }
        } else {
            $msgForma = "Los datos que introduciste no son válidos.";
            require_once 'modulos/usuarios/vistas/reestablecerPassword.php';
        }
    } else {
        setSessionMessage("Datos no válidos", " ¡Error! ", "error");
        goToIndex();
    }
}

function confirmarCuenta() {
    $uuid = $_GET['i'];
    require_once 'modulos/usuarios/modelos/usuarioModelo.php';
    $idUsuario = getIdUsuarioFromUuid($uuid);
    if (setActivado($idUsuario, 1)) {
        setSessionMessage("Tu cuenta ha sido confirmada. ¡Gracias!", " ¡Bien! ", "success");
        require_once 'funcionesPHP/CargarInformacionSession.php';
        cargarUsuarioSession();
    } else {
        setSessionMessage("Ocurrió un error al confirmar tu cuenta. Intenta de nuevo más tarde", " ¡Error! ", "error");
    }
    goToIndex();
}

function enviarCorreoConfirmacion() {
    $usuario = getUsuarioActual();
    if (isset($usuario)) {
        require_once 'modulos/email/modelos/envioEmailModelo.php';
        $urlConfirmacion = getDomainName() . "/usuarios/usuario/confirmarCuenta/" . $usuario->uuid;
        enviarMailConfirmacion($usuario->email, $urlConfirmacion);
        setSessionMessage("Te hemos enviado un correo de confirmación", "", "info");
        redirect("/usuario/" . $usuario->uniqueUrl);
    } else {
        setSessionMessage("Ocurrió un error, intentalo más tarde", " ¡Error! ", "error");
        goToIndex();
    }
}

function eliminar() {
    if (validarAdministradorPrivado()) {
        $pagina = 1;
        if (isset($_GET['pagina']) && is_numeric($_GET['pagina']))
            $pagina = $_GET['pagina'];
        $tipo = "alumnos";
        if (isset($_GET['tipo']))
            $tipo = $_GET['tipo'];
        if (isset($_GET['iu']) && is_numeric($_GET['iu'])) {
            $idUsuario = $_GET['iu'];
            $pagina = $_GET['pagina'];
            $usuario = getUsuarioActual();
            if ($usuario->idUsuario != $idUsuario) {
                //Debido a los archivos en el cdn no podemos borrar las clases por cascada,
                //pero si los cursos y temas.
                //Obtenemos todas la clases que pertenecen a este usuario, borramos del cdn los archivos
                //y borramos lo demás por cascada
                require_once 'modulos/cursos/modelos/ClaseModelo.php';
                $res = borrarClasesConArchivosDeUsuario($idUsuario);
                if ($res['res']) {
                    require_once 'modulos/usuarios/modelos/usuarioModelo.php';
                    if (eliminarUsuario($idUsuario) > 0) {
                        setSessionMessage("Se eliminó correctamente el usuario", " ¡Bien! ", "success");
                    } else {
                        setSessionMessage("Ocurrió un error al eliminar al usuario", " ¡Error! ", "error");
                    }
                } else {
                    setSessionMessage($res['error'], " ¡Error! ", "error");
                }
            } else {
                setSessionMessage("No puedes borrar tu propio usuario", " ¡Error! ", "error");
            }
        } else {
            setSessionMessage("Datos no válidos", " ¡Error! ", "error");
        }
        redirect("/" . $tipo . "&p=" . $pagina);
    } else {
        setSessionMessage("usuario no valido", " ¡Error! ", "error");
        goToIndex();
    }
}

function altaAlumnos() {
    if (validarAdministradorPrivado()) {
        $tipo = "altaAlumno";
        require_once 'modulos/usuarios/vistas/altaUsuario.php';
    }
}

function altaProfesores() {
    if (validarAdministradorPrivado()) {
        $tipo = "altaProfesor";
        require_once 'modulos/usuarios/vistas/altaUsuario.php';
    }
}

function altaAdministradores() {
    if (validarAdministradorPrivado()) {
        $tipo = "altaAdministrador";
        require_once 'modulos/usuarios/vistas/altaUsuario.php';
    }
}

function altaUsuariosSubmit() {
    if (validarAdministradorPrivado()) {
        if (isset($_POST['tipo']) && isset($_POST['usuarios'])) {
            $tipo = $_POST['tipo'];
            $tipoUsuario = 0;
            switch ($tipo) {
                case 'altaAlumno':
                    $tipoUsuario = 0;
                    break;
                case 'altaProfesor':
                    $tipoUsuario = 3;
                    break;
                case 'altaAdministrador':
                    $tipoUsuario = 2;
                    break;
            }
            $splitted = explode(",", $_POST['usuarios']);

            require_once 'modulos/usuarios/modelos/usuarioModelo.php';
            require_once 'funcionesPHP/uniqueUrlGenerator.php';

            $email = "";
            $name = "";
            $usuarios = array();
            $fallos = array();
            $numAltas = 0;
            $numFallos = 0;
            foreach ($splitted as $split) {
                $email = comprobar_email(trim($split));
                if (!empty($email)) {
                    //el email es válido
                    $usuario = new Usuario();
                    $usuario->tipoUsuario = $tipoUsuario;
                    $usuario->email = $email;
                    $name = strstr($email, '@', true);
                    $usuario->nombreUsuario = $name;
                    $usuario->password = md5(getUniqueCode(10));
                    $usuario->uniqueUrl = getUsuarioUniqueUrl($name);
                    $res = altaUsuario($usuario);
                    if ($res['resultado'] == 'ok') {
                        //se dió de alta con éxito el usuario
                        $usuario->idUsuario = $res['id'];
                        $usuario->uuid = $res['uuid'];
                        //le enviamos un correo electrónico para que pueda acceder
                        require_once 'modulos/email/modelos/envioEmailModelo.php';
                        $urlReestablecer = getDomainName() . "/usuarios/usuario/establecerPassword/" . $usuario->uuid;
                        enviarMailSuscripcionUsuario($email, $urlReestablecer);
                        array_push($usuarios, $usuario);
                        $numAltas++;
                    } else {
                        $mensajeError = "";
                        //Ocurrió un error al dar de alta el usuario
                        if ($res['errorId'] == '1062') {
                            //el error es por email duplicado
                            //informamos que este usuario ya está dado de alta
                            $mensajeError = "Este correo electrónico ya fue dado de alta";
                        } else {
                            //error desconocido
                            $mensajeError = "Ocurrió un error al dar de alta. Intenta de nuevo más tarde";
                        }
                        $fallos[$numFallos] = array("email" => $email, "mensaje" => $mensajeError);
                        $numFallos++;
                    }
                } else {
                    //el email no es válido
                    $mensajeError = "No es un email válido";
                    $fallos[$numFallos] = array("email" => $split, "mensaje" => $mensajeError);
                    $numFallos++;
                }
            }
            require_once 'modulos/usuarios/vistas/resultadoDeAltaUsuarios.php';
        } else {
            setSessionMessage("Datos no válidos", " ¡Error! ", "error");
            goToIndex();
        }
    } else {
        goToIndex();
    }
}

function altaUsuariosArchivoCsvSubmit() {
    if (validarAdministradorPrivado()) {
        if (isset($_FILES['csv'])) {
            if ($_FILES['csv']['error'] == 0) {
                $name = $_FILES['csv']['name'];
                $ext = strtolower(end(explode('.', $_FILES['csv']['name'])));
                $type = $_FILES['csv']['type'];
                $tmpName = $_FILES['csv']['tmp_name'];

                // check the file is a csv
                if ($ext === 'csv') {
                    if (($handle = fopen($tmpName, 'r')) !== FALSE) {
                        // necessary if a large csv file
                        set_time_limit(0);
                        require_once 'modulos/usuarios/modelos/usuarioModelo.php';
                        require_once 'funcionesPHP/uniqueUrlGenerator.php';
                        $tipo = $_POST['tipo'];
                        $tipoUsuario = 0;
                        switch ($tipo) {
                            case 'altaAlumno':
                                $tipoUsuario = 0;
                                break;
                            case 'altaProfesor':
                                $tipoUsuario = 3;
                                break;
                            case 'altaAdministrador':
                                $tipoUsuario = 2;
                                break;
                        }
                        $email = "";
                        $name = "";
                        $usuarios = array();
                        $fallos = array();
                        $numAltas = 0;
                        $numFallos = 0;
                        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                            $email = comprobar_email(trim($data[0]));
                            if (isset($data[1])) {//la linea tiene nombre
                                $name = trim($data[1]);
                            } else {
                                $name = strstr($email, '@', true);
                            }

                            if (!empty($email)) {
                                $usuario = new Usuario();
                                $usuario->tipoUsuario = $tipoUsuario;
                                $usuario->email = $email;
                                $usuario->nombreUsuario = $name;
                                $usuario->password = md5(getUniqueCode(10));
                                $usuario->uniqueUrl = getUsuarioUniqueUrl($name);
                                $res = altaUsuario($usuario);
                                if ($res['resultado'] == 'ok') {
                                    //se dió de alta con éxito el usuario
                                    $usuario->idUsuario = $res['id'];
                                    $usuario->uuid = $res['uuid'];
                                    array_push($usuarios, $usuario);
                                    $numAltas++;
                                } else {
                                    $mensajeError = "";
                                    //Ocurrió un error al dar de alta el usuario
                                    if ($res['errorId'] == '1062') {
                                        //el error es por email duplicado
                                        //informamos que este usuario ya está dado de alta
                                        $mensajeError = "Este correo electrónico ya fue dado de alta";
                                    } else {
                                        //error desconocido
                                        $mensajeError = "Ocurrió un error al dar de alta. Intenta de nuevo más tarde";
                                    }
                                    $fallos[$numFallos] = array("email" => $email, "mensaje" => $mensajeError);
                                    $numFallos++;
                                }
                            } else {
                                //el email no es válido
                                $mensajeError = "No es un email válido";
                                $fallos[$numFallos] = array("email" => trim($data[0]), "mensaje" => $mensajeError);
                                $numFallos++;
                            }
                        }
                        require_once 'modulos/usuarios/vistas/resultadoDeAltaUsuarios.php';
                        fclose($handle);
                    } else {
                        setSessionMessage("Ocurrió un error al procesar tu archivo. Intenta de nuevo más tarde", " ¡Error! ", "error");
                        redirect("/alumnos/usuario/altaAlumnos");
                    }
                } else {
                    setSessionMessage("No es un archivo .csv", " ¡Espera! ", "error");
                    redirect("/alumnos/usuario/altaAlumnos");
                }
            } else {
                setSessionMessage("Archivo no válido", " ¡Espera! ", "error");
                redirect("/alumnos/usuario/altaAlumnos");
            }
        } else {
            setSessionMessage("Archivo no válido", " ¡Error! ", "error");
            redirect("/alumnos/usuario/altaAlumnos");
        }
    }
}

function establecerPassword() {
    $uuid = $_GET['i'];
    require_once 'modulos/usuarios/vistas/reestablecerPassword.php';
}

function validarLoginUnicoAjax() {
    echo 'valid session';
}

?>
