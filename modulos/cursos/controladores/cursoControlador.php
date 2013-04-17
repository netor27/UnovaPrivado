<?php

function principal() {
    if (validarUsuarioLoggeado()) {
        if (validarAdministradorPrivado()) {
            $offset = 0;
            $numRows = 4;
            $pagina = 1;
            if (isset($_GET['p'])) {
                if (is_numeric($_GET['p'])) {
                    $pagina = intval($_GET['p']);
                    $offset = $numRows * ($pagina - 1);
                }
            }
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            $res = getCursos($offset, $numRows);
            $cursos = $res['cursos'];
            $numCursos = $res['n'];
            $maxPagina = ceil($numCursos / $numRows);
            if ($pagina != 1 && $pagina > $maxPagina) {
                redirect("/cursos&p=" . $maxPagina);
            } else {
                clearBreadCrumbs();
                pushBreadCrumb(getUrl(), "Lista de cursos",true);
                require_once 'modulos/cursos/vistas/principal.php';
            }
        } else {
            goToIndex();
        }
    } else {
        goToIndex();
    }
}

function crearCurso() {
    if (validarUsuarioLoggeado()) {
        if (validarAdministradorPrivado() ||
                tipoUsuario() == "administrador" ||
                tipoUsuario() == "profesor") {
            $titulo = "";
            $descripcion = "";
            require_once 'modulos/cursos/vistas/crearCurso.php';
        } else {
            goToIndex();
        }
    }
}

function crearCursoSubmit() {
    if (validarAdministradorPrivado() ||
            tipoUsuario() == "administrador" ||
            tipoUsuario() == "profesor") {
        if (isset($_POST['titulo']) && isset($_POST['descripcionCorta'])) {
            $descripcionCorta = removeBadHtmlTags(trim($_POST['descripcionCorta']));
            $titulo = removeBadHtmlTags(trim($_POST['titulo']));

            if (strlen($titulo) >= 10 && strlen($titulo) <= 100 &&
                    strlen($descripcionCorta) >= 10 &&
                    strlen($descripcionCorta) <= 140) {
                require_once 'modulos/cursos/clases/Curso.php';
                $curso = new Curso();
                $curso->titulo = $titulo;
                $curso->descripcionCorta = $descripcionCorta;
                $curso->idUsuario = getUsuarioActual()->idUsuario;
                $curso->publicado = 1;
                require_once 'funcionesPHP/uniqueUrlGenerator.php';
                $curso->uniqueUrl = getCursoUniqueUrl($titulo);

                require_once 'modulos/cursos/modelos/CursoModelo.php';
                $id = altaCurso($curso);
                if ($id >= 0) {
                    $curso->idCurso = $id;
                    $url = "/curso/" . $curso->uniqueUrl;
                    setSessionMessage("Haz creado un curso", " ¡Bien! ", "success");
                    redirect($url);
                } else {
                    $msgForma = "Ya existe un curso con ese nombre. Escoje otro nombre";
                    require_once 'modulos/cursos/vistas/crearCurso.php';
                }
            } else {
                $msgForma = "Los datos que introduciste no son válidos.";

                require_once 'modulos/cursos/vistas/crearCurso.php';
            }
        } else {
            $msgForma = "Los datos que introduciste no son válidos.";
            require_once 'modulos/cursos/vistas/crearCurso.php';
        }
    } else {
        goToIndex();
    }
}

function detalles() {
    require_once 'modulos/cursos/modelos/CursoModelo.php';
    $cursoUrl = $_GET['i'];
    $curso = getCursoFromUniqueUrl($cursoUrl);

    if (is_null($curso)) {
        //si el curso no existe mandarlo a index
        setSessionMessage("El curso que intentas ver no existe", " ¡Error! ", "error");
        redirect("/");
    } else {
        $usuario = getUsuarioActual();
        //Verficiar si es el dueño del curso y lo mandamos a edición
        if ($curso->idUsuario == $usuario->idUsuario) {
            editarCurso($curso, $usuario);
        } else {
            require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
            //Revisamos si el usuario ya esta tomando este curso      
            $esAlumno = esUsuarioUnAlumnoDelCurso($usuario->idUsuario, $curso->idCurso);
            if ($esAlumno || tipoUsuario() == "administrador" || tipoUsuario() == "administradorPrivado") {
                //Si ya es un alumno o es un administrador, mostramos la página donde toma las clases
                tomarCurso($curso, $usuario, $esAlumno);
            } else {
                //No esta suscrito al curso, mostramos el error               
                setSessionMessage("Lo sentimos, no estas inscrito a este curso.", " ¡Error! ", "error");
                goToIndex();
            }
        }
    }
}

function tomarCurso($curso, $usuario, $esAlumno) {
    $temas = getTemas($curso->idCurso);
    $clases = getClases($curso->idCurso);
    $duracion = 0;
    if (isset($clases)) {
        foreach ($clases as $clase) {
            if ($clase->idTipoClase == 0)
                $duracion += $clase->duracion;
        }
    }
    $usuarioDelCurso = getUsuarioDeCurso($curso->idCurso);
    require_once 'modulos/cursos/modelos/ClaseModelo.php';
    if ($esAlumno)
        $ratingUsuario = getRatingUsuario($usuario->idUsuario, $curso->idCurso);
    $numAlumnos = getNumeroDeAlumnos($curso->idCurso);
    $tituloPagina = substr($curso->titulo, 0, 50);
    pushBreadCrumb(getUrl(), $curso->titulo,true);
    require_once 'modulos/cursos/vistas/tomarCurso.php';
}

function editarCurso($cursoParaModificar, $usuario) {
    require_once 'modulos/cursos/modelos/ClaseModelo.php';
    $temas = getTemas($cursoParaModificar->idCurso);
    $clases = getClases($cursoParaModificar->idCurso);
    $duracion = 0;
    if (isset($clases)) {
        foreach ($clases as $clase) {
            if ($clase->idTipoClase == 0)
                $duracion += transformaMMSStoMinutes($clase->duracion);
        }
    }
    $usuarioDelCurso = getUsuarioDeCurso($cursoParaModificar->idCurso);
    $tituloPagina = substr($cursoParaModificar->titulo, 0, 50);
    $numAlumnos = getNumeroDeAlumnos($cursoParaModificar->idCurso);
    pushBreadCrumb(getUrl(), $cursoParaModificar->titulo,true);
    require_once 'modulos/cursos/vistas/editarCurso.php';
}

function editarInformacionCurso() {
    require_once 'modulos/cursos/modelos/CursoModelo.php';

    $idCurso = $_GET['i'];
    $cursoParaModificar = getCurso($idCurso);

    if ($cursoParaModificar->idUsuario == getUsuarioActual()->idUsuario) {
        //El curso le pertenece al usuario loggeado.
        require_once 'modulos/cursos/vistas/editarInformacionCurso.php';
    } else {
        //Este curso no le pertenece a esta persona, no lo puede modificar.
        //Reenviar a index.                
        goToIndex();
    }
}

function editarInformacionCursoSubmit() {
    if (validarUsuarioLoggeadoParaSubmits()) {
        if (isset($_GET['i']) && isset($_POST['titulo']) && isset($_POST['descripcionCorta']) && isset($_POST['descripcion'])) {
            $idCurso = removeBadHtmlTags($_GET['i']);
            $titulo = removeBadHtmlTags(trim($_POST['titulo']));
            $descripcionCorta = removeBadHtmlTags(trim($_POST['descripcionCorta']));
            $descripcion = removeBadHtmlTags(trim($_POST['descripcion']));

            if (strlen($titulo) >= 10 && strlen($titulo) <= 100 && strlen($descripcionCorta) >= 10 && strlen($descripcionCorta) <= 140) {
                //Todo bien
                require_once 'modulos/cursos/modelos/CursoModelo.php';
                $curso = getCurso($idCurso);
                $tituloAnterior = $curso->titulo;
                if ($curso->idUsuario == getUsuarioActual()->idUsuario) {
                    //El curso le pertenece al usuario loggeado. Modificamos el contenido
                    $curso->titulo = $titulo;
                    require_once 'funcionesPHP/uniqueUrlGenerator.php';
                    if ($tituloAnterior != $curso->titulo) {
                        $curso->uniqueUrl = getCursoUniqueUrl($titulo);
                    }

                    $curso->descripcionCorta = $descripcionCorta;
                    $curso->descripcion = $descripcion;

                    if (actualizaInformacionCurso($curso)) {
                        require_once 'funcionesPHP/CargarInformacionSession.php';
                        setSessionMessage("Se modificó correctamente la información del curso.", " ¡Bien! ", "success");
                    } else {
                        setSessionMessage("Ocurrió un error al modificar el curso. Intenta de nuevo más tarde.", " ¡Error! ", "error");
                    }
                    redirect("/curso/" . $curso->uniqueUrl);
                } else {
                    //Este curso no le pertenece a esta persona, no lo puede modificar.
                    //Reenviar a index.                
                    setSessionMessage("No puedes modificar este curso", " ¡Espera! ", "error");
                    goToIndex();
                }
            } else {
                //Datos no validos
                setSessionMessage("Los datos enviados no son correctos", " ¡Error! ", "error");
                redirect("/cursos/curso/editarInformacionCurso/" . $idCurso);
            }
        } else {
            //no hay datos en post
            setSessionMessage("Los datos enviados no son correctos", " ¡Error! ", "error");
            redirect("/");
        }
    } else {
        goToIndex();
    }
}

function cambiarImagen() {
    if (validarUsuarioLoggeado()) {
        require_once 'modulos/cursos/modelos/CursoModelo.php';

        $idCurso = $_GET['i'];
        $cursoParaModificar = getCurso($idCurso);
        if ($cursoParaModificar->idUsuario == getUsuarioActual()->idUsuario) {
            require_once 'modulos/cursos/vistas/editarImagen.php';
        } else {
            setSessionMessage("No puedes modificar este curso.", " ¡Espera! ", "error");
            goToIndex();
        }
    }
}

function cambiarImagenSubmit() {
    if (validarUsuarioLoggeadoParaSubmits()) {
        if (isset($_FILES['imagen']) && isset($_GET['i'])) {
            $anchoImagen = 200;
            $altoImagen = 200;
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            $idCurso = $_GET['i'];
            $cursoParaModificar = getCurso($idCurso);
            if ($cursoParaModificar->idUsuario == getUsuarioActual()->idUsuario) {
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
                            $res = uploadFileToS3($dest, "cursosImgs");
                            //borramos la imagen con crop                                
                            unlink($dest);
                            if ($res['res']) {
                                $imagenAnterior = $cursoParaModificar->imagen;
                                //Se subió bien la imagen, guardamos en la bd
                                $cursoParaModificar->imagen = $res['link'];
                                if (actualizaImagenCurso($cursoParaModificar)) {
                                    //Se actualizo correctamente la imagen, borramos la anterior
                                    if (strpos($imagenAnterior, "http") !== false) {
                                        //Es una imagen en el S3, la borramos
                                        deleteFileFromS3ByUrl($imagenAnterior);
                                    } else {
                                        //Es una imagen predefinida, no borrar!
                                    }
                                    require_once 'funcionesPHP/CargarInformacionSession.php';
                                    setSessionMessage("Cambiaste correctamente tu imagen", " ¡Bien! ", "success");
                                    redirect("/curso/" . $cursoParaModificar->uniqueUrl);
                                } else {
                                    //error en bd
                                    setSessionMessage("Error BD", " ¡Error! ", "error");
                                    redirect("/cursos/curso/cambiarImagen/" . $cursoParaModificar->idCurso);
                                }
                            } else {
                                //No se subió la imagen
                                setSessionMessage("Ocurrió un error al guardar la imagen en nuestros servidores. Intenta de nuevo más tarde", " ¡Error! ", "error");
                                redirect("/curso/" . $cursoParaModificar->uniqueUrl);
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
                        redirect("/curso/" . $cursoParaModificar->uniqueUrl);
                    }
                } else {
                    //No es una imagen válida
                    setSessionMessage("No es una imagen válida. El tamaño máximo es de 10MB y formato png o jpg", " ¡Espera! ", "error");
                    redirect("/cursos/curso/cambiarImagen/" . $cursoParaModificar->idCurso);
                }
            } else {
                setSessionMessage("No puedes modificar este curso", " ¡Espera! ", "error");
                goToIndex();
            }
        } else {
            setSessionMessage("No es una imagen válida", " ¡Espera! ", "error");
            redirect("/cursos/curso/cambiarImagen/" . $cursoParaModificar->idCurso);
        }
    } else {
        goToIndex();
    }
}

function agregarContenido() {
    if (validarUsuarioLoggeado()) {
        if (isset($_GET['i'])) {
            $idCurso = $_GET['i'];
            $idTema = -1;
            $usuarioActual = getUsuarioActual();

            require_once 'modulos/cursos/modelos/CursoModelo.php';
            $curso = getCurso($idCurso);
            if ($usuarioActual->idUsuario == getIdUsuarioDeCurso($idCurso)) {
                if (isset($_GET['j'])) {
                    $idTema = $_GET['j'];
                } else {
                    //no hay get['idTema'],
                    //buscamos un tema y si no hay
                    //creamos un tema con el mismo nombre que el curso

                    require_once 'modulos/cursos/modelos/TemaModelo.php';
                    require_once 'modulos/cursos/clases/Tema.php';
                    $temas = getTemas($idCurso);
                    if (isset($temas)) {
                        $idTema = $temas[0]->idTema;
                    } else {
                        $tema = new Tema();
                        $tema->nombre = $curso->titulo;
                        $tema->idCurso = $curso->idCurso;
                        $idTema = altaTema($tema);
                    }
                }
                if ($idTema >= 0) {
                    //Tenemos un idTema correcto
                    require_once 'modulos/cursos/vistas/agregarContenido.php';
                } else {
                    //Ocurrió un error al dar de alta el tema
                    setSessionMessage("Ocurrió un error al dar de alta el tema", " ¡Error! ", "error");
                    redirect("/curso/" . $curso->uniqueUrl);
                }
            } else {
                //Error, el usuario no es dueño de este curso, no puede modificar
                goToIndex();
            }
        } else {
            //Error, no hay get['i']
            goToIndex();
        }
    }
}

function calificarCurso() {
    $idUsuario = $_GET['iu'];
    $idCurso = $_GET['ic'];
    $rating = $_GET['rating'];
    $msg = "";
    $res = false;
    $auxRating = 0;
    require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
    if (esUsuarioUnAlumnoDelCurso($idUsuario, $idCurso)) {
        if (setRatingUsuario($idUsuario, $idCurso, $rating)) {
            $res = true;
            $msg = "Tu calificación ha sido guardada. ¡Gracias!";
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            $auxRating = getRatingCurso($idCurso);
        } else {
            $msg = "Ocurrió un error al calificar el curso";
        }
    } else {
        $msg = "Ocurrió un error al calificar el curso";
    }
    echo json_encode(array(
        "res" => $res,
        "msg" => $msg,
        "rating" => $auxRating
    ));
}

function publicar() {
    $idCurso = $_GET['ic'];
    $usuario = getUsuarioActual();
    if (isset($usuario)) {
        if ($usuario->activado == 1) {
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            if (getIdUsuarioDeCurso($idCurso) == $usuario->idUsuario) {
                //Si el usuario loggeado es del curso, publicar
                if (setPublicarCurso($idCurso, 1)) {
                    echo ' ok';
                } else {
                    echo 'ERROR BD';
                }
            } else {
                echo 'ERROR. Usuario no dueño';
            }
        } else {
            //El usuario no ha confirmado su cuenta
            echo 'ERROR. Usuario no activado.';
        }
    } else {
        echo 'ERROR. Usuario no loggeado';
    }
}

function alumnos() {
    if (validarUsuarioLoggeado()) {
        if (validarAdministradorPrivado()) {
            if (isset($_GET['i']) && is_numeric($_GET['i'])) {
                $idCurso = intval($_GET['i']);
                $offset = 0;
                $numRows = 18;
                $pagina = 1;
                if (isset($_GET['p']) && is_numeric($_GET['p'])) {
                    $pagina = intval($_GET['p']);
                    $offset = $numRows * ($pagina - 1);
                }
                require_once 'modulos/cursos/modelos/CursoModelo.php';
                $curso = getCurso($idCurso);
                $res = getAlumnosDeCurso($idCurso, $offset, $numRows);
                $alumnos = $res['alumnos'];
                $numAlumnos = $res['n'];
                $maxPagina = ceil($numAlumnos / $numRows);
                if ($pagina != 1 && $pagina > $maxPagina) {
                    redirect("/cursos/curso/alumnos/" . $idCurso . "&p=" . $maxPagina);
                } else {
                    pushBreadCrumb(getUrl(), "Usuarios inscritos al curso",true);
                    require_once 'modulos/cursos/vistas/listaAlumnosDeCurso.php';
                }
            } else {
                setSessionMessage("Los datos enviados no son válidos", " ¡Error! ", "error");
                redirect("/cursos");
            }
        } else {
            goToIndex();
        }
    } else {
        goToIndex();
    }
}

function eliminar() {
    if (validarUsuarioLoggeado()) {
        if (validarAdministradorPrivado()) {
            if (isset($_GET['i']) && is_numeric($_GET['i'])) {
                $idCurso = intval($_GET['i']);
                require_once 'modulos/cursos/modelos/CursoModelo.php';
                $idUsuario = getIdUsuarioDeCurso($idCurso);
                //Debido a los archivos en el cdn no podemos borrar las clases por cascada,
                //pero si los cursos y temas.
                //Obtenemos todas la clases que pertenecen a este curso, borramos del cdn los archivos y las clases,
                //y borramos lo demás por cascada

                require_once 'modulos/cursos/modelos/ClaseModelo.php';
                $res = borrarClasesConArchivosDeCurso($idCurso);
                if ($res['res']) {
                    if (bajaCurso($idCurso) > 0) {
                        setSessionMessage("Se eliminó con éxito el curso", " ¡Bien! ", "success");
                    } else {
                        setSessionMessage("Ocurrió un error al eliminar", " ¡Error! ", "error");
                    }
                } else {
                    setSessionMessage($res['error'], " ¡Error! ", "error");
                }
            } else {
                setSessionMessage("Ocurrió un error", " ¡Error! ", "error");
            }
            redirect("/cursos");
        } else {
            goToIndex();
        }
    } else {
        goToIndex();
    }
}

?>
