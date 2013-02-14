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
                    setSessionMessage("<h4 class='success'>¡Haz creado un curso!</h4>");
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
    $backUrl = null;
    if (isset($_GET['b'])) {
        $backUrl = $_GET['b'];
        if (isset($_GET['p'])) {
            $backUrl = $backUrl . '&p=' . $_GET['p'];
        }
    }
    $cursoUrl = $_GET['i'];
    $curso = getCursoFromUniqueUrl($cursoUrl);

    if (is_null($curso)) {
        //si el curso no existe mandarlo a index
        setSessionMessage("<h4 class='error'>El curso que intentas ver no existe</h4>");
        redirect("/");
    } else {
        $usuario = getUsuarioActual();
        //Verficiar si es el dueño del curso y lo mandamos a edición
        if ($curso->idUsuario == $usuario->idUsuario) {
            editarCurso($curso, $usuario, $backUrl);
        } else {
            require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
            //Revisamos si el usuario ya esta tomando este curso      
            $esAlumno = esUsuarioUnAlumnoDelCurso($usuario->idUsuario, $curso->idCurso);
            if ($esAlumno || tipoUsuario() == "administrador" || tipoUsuario() == "administradorPrivado") {
                //Si ya es un alumno o es un administrador, mostramos la página donde toma las clases
                tomarCurso($curso, $usuario, $esAlumno, $backUrl);
            } else {
                //No esta suscrito al curso, mostramos el error               
                setSessionMessage("<h4 class='error'>Lo sentimos, no estas inscrito a este curso.</h4>");
                goToIndex();
            }
        }
    }
}

function tomarCurso($curso, $usuario, $esAlumno, $backUrl) {
    $temas = getTemas($curso->idCurso);
    $clases = getClases($curso->idCurso);
    $duracion = 0;
    if (isset($clases)) {
        foreach ($clases as $clase) {
            if ($clase->idTipoClase == 0)
                $duracion += $clase->duracion;
        }
    }
    $comentarios = getComentarios($curso->idCurso);
    $preguntas = getPreguntas($curso->idCurso);
    $usuarioDelCurso = getUsuarioDeCurso($curso->idCurso);
    require_once 'modulos/cursos/modelos/ClaseModelo.php';
    $tiposClase = getTiposClase();
    if ($esAlumno)
        $ratingUsuario = getRatingUsuario($usuario->idUsuario, $curso->idCurso);
    $numAlumnos = getNumeroDeAlumnos($curso->idCurso);
    $tituloPagina = substr($curso->titulo, 0, 50);
    require_once 'modulos/cursos/vistas/tomarCurso.php';
}

function editarCurso($cursoParaModificar, $usuario, $backUrl) {
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

    $comentarios = getComentarios($cursoParaModificar->idCurso);
    $preguntas = getPreguntas($cursoParaModificar->idCurso);
    $usuarioDelCurso = getUsuarioDeCurso($cursoParaModificar->idCurso);
    $tiposClase = getTiposClase();
    $tituloPagina = substr($cursoParaModificar->titulo, 0, 50);
    $numAlumnos = getNumeroDeAlumnos($cursoParaModificar->idCurso);
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
                        cargarCursosSession();
                        setSessionMessage("<h4 class='success'>Se modificó correctamente la información del curso.</h4>");
                    } else {
                        setSessionMessage("<h4 class='error'>Currió un error al modificar el curso. Intenta de nuevo más tarde.</h4>");
                    }
                    redirect("/curso/" . $curso->uniqueUrl);
                } else {
                    //Este curso no le pertenece a esta persona, no lo puede modificar.
                    //Reenviar a index.                
                    setSessionMessage("<h4 class='error'>No puedes modificar este curso</h4>");
                    goToIndex();
                }
            } else {
                //Datos no validos
                setSessionMessage("<h4 class='error'>Los datos enviados no son correctos</h4>");
                redirect("/cursos/curso/editarInformacionCurso/" . $idCurso);
            }
        } else {
            //no hay datos en post
            setSessionMessage("<h4 class='error'>Los datos enviados no son correctos</h4>");
            redirect("/");
        }
    } else {
        goToIndex();
    }
}

function comentarCurso() {
    require_once 'modulos/cursos/modelos/CursoModelo.php';
    require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
    $idCurso = $_GET['i'];
    $curso = getCurso($idCurso);
    $texto = removeBadHtmlTags($_POST['comentario']);

    $usuario = getUsuarioActual();
    if (!is_null($usuario) && strlen(trim($texto)) > 0) {
        if (esUsuarioUnAlumnoDelCurso($usuario->idUsuario, $curso->idCurso)) {
            require_once 'modulos/cursos/clases/Comentario.php';
            require_once 'modulos/cursos/modelos/ComentarioModelo.php';
            $comentario = new Comentario();
            $comentario->idCurso = $curso->idCurso;
            $comentario->idUsuario = $usuario->idUsuario;
            $comentario->texto = $texto;
            $idComentario = altaComentario($comentario);

            if ($idComentario >= 0) {
                $comentario->avatar = $usuario->avatar;
                $comentario->nombreUsuario = $usuario->nombreUsuario;
                echo '<li class="page1">';
                if ($comentario->idUsuario == $curso->idUsuario)
                    echo '<div class="comentarioContainer blueBox" style="width:97%;">';
                else
                    echo '<div class="comentarioContainer whiteBox" style="width:97%;">';
                echo '<div class="comentarioAvatar"><img src="' . $comentario->avatar . '"></div>';
                echo '<div class="comentarioUsuario"><a href="/usuario/' . $comentario->uniqueUrlUsuario . '&b=' . getRequestUri() . '">' . $comentario->nombreUsuario . '</a></div>';
                echo '<div class="comentarioFecha"> Hace unos segundos</div>';
                echo '<br><br><div class="comentario left">' . $comentario->texto . '</div>';
                echo '</div>';
                echo '</li>';
            } else {
                echo 'error';
            }
        }
    }
}

function preguntarCurso() {
    require_once 'modulos/cursos/modelos/CursoModelo.php';
    require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
    $idCurso = $_GET['i'];
    $curso = getCurso($idCurso);
    $texto = removeBadHtmlTags($_POST['pregunta']);

    $usuario = getUsuarioActual();
    if (!is_null($usuario) && strlen(trim($texto)) > 0) {
        if (esUsuarioUnAlumnoDelCurso($usuario->idUsuario, $curso->idCurso)) {
            require_once 'modulos/cursos/clases/Pregunta.php';
            require_once 'modulos/cursos/modelos/PreguntaModelo.php';
            $pregunta = new Pregunta();
            $pregunta->idCurso = $curso->idCurso;
            $pregunta->idUsuario = $usuario->idUsuario;
            $pregunta->pregunta = $texto;
            $idPregunta = altaPregunta($pregunta);
            if ($idPregunta >= 0) {
                $pregunta->avatar = $usuario->avatar;
                $pregunta->nombreUsuario = $usuario->nombreUsuario;
                echo '<li class="page1">';
                echo '<div class="preguntaContainer whiteBox" style="width:97%;">';
                echo '<div class="comentarioAvatar"><img src="' . $pregunta->avatar . '"></div>';
                echo '<div class="comentarioUsuario"><a href="/usuario/' . $pregunta->uniqueUrlUsuario . '&b=' . getRequestUri() . '">' . $pregunta->nombreUsuario . '</a></div>';
                echo '<div class="comentarioFecha"> Hace unos segundos</div>';
                echo '<br><div class="comentario">' . $pregunta->pregunta . '</div>';
                echo '</div>';
                echo '</li>';

                //enviar email de notificación al dueño del curso de la pregunta
                //require_once 'modulos/email/modelos/envioEmailModelo.php';
                //$duenioCurso = getUsuarioDeCurso($curso->idCurso);
                //if (!enviarMailPreguntaEnCurso($duenioCurso->email, $curso->titulo, 'www.unova.mx/curso/' . $curso->uniqueUrl, $pregunta->pregunta))
                //    echo 'ERROR AL ENVIAR EMAIL A ' . $duenioCurso->email;
                //Se quitó esta parte para que no se envíe un mail al profesor cada vez que alguien pregunta algo
                //ahora se envía un mail semanal con un resumen
            } else {
                echo 'error';
            }
        }
    }
}

function responderPreguntaCurso() {
    require_once 'modulos/cursos/modelos/CursoModelo.php';
    require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
    $idCurso = $_GET['i'];
    $idPregunta = $_GET['j'];

    $curso = getCurso($idCurso);
    $texto = removeBadHtmlTags($_POST['respuesta']);

    $usuario = getUsuarioActual();
    if (!is_null($usuario) && strlen(trim($texto)) > 0) {
        if ($curso->idUsuario == $usuario->idUsuario) {
            require_once 'modulos/cursos/clases/Pregunta.php';
            require_once 'modulos/cursos/modelos/PreguntaModelo.php';
            if (responderPregunta($idPregunta, $texto)) {
                require_once 'modulos/email/modelos/envioEmailModelo.php';
                require_once 'modulos/cursos/modelos/PreguntaModelo.php';
                $datos = getInfoParaMailRespuestaPregunta($idPregunta);
                enviarMailRespuestaPregunta($datos['email'], $curso->titulo, DOMINIO_PRIVADO . '/curso/' . $curso->uniqueUrl, $datos['pregunta'], $texto);
                echo '<br><div class="respuesta blueBox" style="width: 80%;">';
                echo '<div class="comentarioAvatar"><img src="' . $usuario->avatar . '"></div>';
                echo '<div class="comentarioUsuario"><a href="/usuario/' . $usuario->uniqueUrl . '&b=' . getRequestUri() . '">' . $usuario->nombreUsuario . '</a></div>';
                echo '<br><div class="comentario">' . $texto . '</div>';
                echo '</div>';
            } else {
                echo 'error';
            }
        }
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
            setSessionMessage("<h4 class='error'>No puedes modificar este curso.</h4>");
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
                    $file = "archivos/temporal/" . $_FILES["imagen"]["name"];

                    move_uploaded_file($_FILES["imagen"]["tmp_name"], $file);
                    $path = pathinfo($file);
                    $uniqueCode = getUniqueCode(5);
                    $destName = $uniqueCode . "_curso_" . $cursoParaModificar->idCurso . "." . $path['extension'];
                    $dest = "archivos/imagenCurso/" . $destName;

                    if (cropImage($file, $dest, $altoImagen, $anchoImagen)) {
                        //Se hizo el crop correctamente                    
                        //borramos la imagen temporal
                        unlink($file);
                        if (!strpos($cursoParaModificar->imagen, "Predefinida")) {
                            $count = 1;
                            $aux = str_replace("/archivos", "archivos", $cursoParaModificar->imagen, $count); //quitar la / del inicio
                            unlink($aux);
                            //echo 'se borro ' . $cursoParaModificar->imagen .'<br>';
                        } else {
                            //echo 'no se borro ' . $cursoParaModificar->imagen .'<br>';
                        }

                        $cursoParaModificar->imagen = "/" . $dest;
                        if (actualizaImagenCurso($cursoParaModificar)) {
                            require_once 'funcionesPHP/CargarInformacionSession.php';
                            cargarCursosSession();
                            setSessionMessage("<h4 class='success'>Cambiaste correctamente tu imagen</h4>");
                            redirect("/curso/" . $cursoParaModificar->uniqueUrl);
                        } else {
                            //error en bd
                            setSessionMessage("<h4 class='error'>Error bd</h4>");
                            redirect("/cursos/curso/cambiarImagen/" . $cursoParaModificar->idCurso);
                        }
                    } else {
                        //borramos la imagen temporal
                        unlink($file);
                        //No se pudo hacer el "crop" de la imagen
                        setSessionMessage("<h4 class='error'>Ocurrió un error al procesar tu imagen. Intenta de nuevo más tarde</h4>");
                        redirect("/cursos/curso/cambiarImagen/" . $cursoParaModificar->idCurso);
                    }
                } else {
                    //No es una imagen válida
                    setSessionMessage("<h4 class='error'>No es una imagen válida</h4>");
                    redirect("/cursos/curso/cambiarImagen/" . $cursoParaModificar->idCurso);
                }
            } else {
                setSessionMessage("<h4 class='error'>No puedes modificar este curso</h4>");
                goToIndex();
            }
        } else {
            setSessionMessage("<h4 class='error'>No es una imagen válida</h4>");
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
                    setSessionMessage("<h3 class='error'>Ocurrió un error al dar de alta el tema</h4>");
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

    require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
    if (esUsuarioUnAlumnoDelCurso($idUsuario, $idCurso)) {
        if (setRatingUsuario($idUsuario, $idCurso, $rating)) {
            echo "Tu calificación ha sido guardada. ¡Gracias!";
        } else {
            echo "Ocurrió un error al calificar el curso";
        }
    } else {
        echo "Ocurrió un error al calificar el curso";
    }
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
                $paginaCursos = 1;
                if (isset($_GET['pc']) && is_numeric($_GET['pc'])) {
                    $paginaCursos = $_GET['pc'];
                }
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
                    redirect("/cursos/curso/alumnos/" . $idCurso . "&pc=" . $paginaCursos . "&p=" . $maxPagina);
                } else {
                    require_once 'modulos/cursos/vistas/listaAlumnosDeCurso.php';
                }
            } else {
                setSessionMessage("<h4 class='error'>Ocurrió un error</h4>");
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
                        setSessionMessage("<h4 class='success'>Se eliminó con éxito el curso</h4>");
                    } else {
                        setSessionMessage("<h4 class='error'>Ocurrió un error al eliminar</h4>");
                    }
                } else {
                    setSessionMessage("<h4 class='error'>" . $res['error'] . "</h4>");
                }
            } else {
                setSessionMessage("<h4 class='error'>Ocurrió un error</h4>");
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
