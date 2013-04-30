<?php

//Al borrar una clase debemos de borrar tambien el/los archivo(s) 
//que esten almacenados en el S3
function borrarClase() {
    if (validarUsuarioLoggeadoParaSubmits()) {
        if (isset($_GET['i']) && isset($_GET['j'])) {
            $idCurso = $_GET['i'];
            $idClase = $_GET['j'];
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            require_once 'modulos/cursos/modelos/ClaseModelo.php';
            if (getUsuarioActual()->idUsuario == getIdUsuarioDeCurso($idCurso) && clasePerteneceACurso($idCurso, $idClase)) {
                $clase = getClase($idClase);
                if ($clase->transformado == 1) {
                    if (bajaClase($idClase) <= 0) {
                        //Error al dar de baja la clase
                        echo "<div><h4 class='black'> Ocurrió un error al borrar la clase. Intenta de nuevo más tarde.</h4></div>";
                    } else {
                        //Si fue satisfactorio, borramos el archivo
                        require_once 'modulos/aws/modelos/s3Modelo.php';
                        deleteFileFromS3ByUrl($clase->archivo);
                        if ($clase->idTipoClase == 0 || $clase->idTipoClase == 4) {
                            //si es video o audio borramos el archivo2
                            deleteFileFromS3ByUrl($clase->archivo2);
                        }
                        echo "success";
                    }
                } else {
                    echo "<div><h4 class='black'> Debes esperar a que termine la transformación para poder borrar esta clase.</h4></div>";
                }
            } else {
                //Error, el usuario no es dueño de este curso, no puede borrar
                echo "<div><h4 class='black'>Error. No puedes modificar este curso</h4></div>";
            }
        } else {
            //Error, no hay get['i']
            echo "<div><h4 class='black'>Error. I</h4></div>";
        }
    } else {
        echo "<div><h4 class='black'>Error. U</h4></div>";
//Error, no hay usuario loggeado para ejecutar acción Ajax, no hacer nada
    }
}

function editarClase() {
    if (validarUsuarioLoggeado()) {
        if (isset($_GET['i']) && isset($_GET['j'])) {
            $idCurso = $_GET['i'];
            $idClase = $_GET['j'];
            require_once 'modulos/cursos/modelos/ClaseModelo.php';
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            if (getUsuarioActual()->idUsuario == getIdUsuarioDeCurso($idCurso) && clasePerteneceACurso($idCurso, $idClase)) {
                $clase = getClase($idClase);
                $curso = getCurso($idCurso);
                require_once 'modulos/cursos/vistas/editarClase.php';
            } else {
                setSessionMessage('No puedes modificar esta clase', " ¡Espera! ", "error");
                redirect("/");
            }
        } else {
            setSessionMessage('Los datos enviados no son correctos', " ¡Error! ", "error");
            redirect("/");
        }
    }
}

function editarClaseSubmit() {
    if (validarUsuarioLoggeadoParaSubmits()) {
        if (isset($_POST['titulo']) && isset($_POST['descripcion']) &&
                isset($_POST['idCurso']) && isset($_POST['idClase'])) {

            require_once 'modulos/cursos/modelos/CursoModelo.php';
            require_once 'modulos/cursos/modelos/ClaseModelo.php';

            $idCurso = removeBadHtmlTags($_POST['idCurso']);
            $curso = getCurso($idCurso);
            $idClase = removeBadHtmlTags($_POST['idClase']);

            if (getUsuarioActual()->idUsuario == getIdUsuarioDeCurso($idCurso) && clasePerteneceACurso($idCurso, $idClase)) {

                $titulo = removeBadHtmlTags(trim($_POST['titulo']));
                $descripcion = removeBadHtmlTags(trim($_POST['descripcion']));

                if (strlen($titulo) >= 5 && strlen($titulo) <= 100) {
                    require_once 'modulos/cursos/clases/Clase.php';
                    require_once 'modulos/cursos/modelos/ClaseModelo.php';

                    $clase = new Clase();
                    $clase->descripcion = $descripcion;
                    $clase->titulo = $titulo;
                    $clase->idClase = $idClase;

                    if (actualizaInformacionClase($clase)) {
                        setSessionMessage("Se modificó correctamente la clase", " ¡Bien! ", "success");
                        redirect("/curso/" . $curso->uniqueUrl);
                    } else {
                        //Error al insertar                    
                        setSessionMessage('Ocurrió un error al editar la clase. Intenta de nuevo más tarde', " ¡Error! ", "error");
                        redirect("/clases/clase/editarClase/" . $idCurso . "/" . $idClase);
                    }
                } else {
                    setSessionMessage('Los valores que introduciste no son válidos', " ¡Error! ", "error");
                    redirect("/clases/clase/editarClase/" . $idCurso . "/" . $idClase);
                }
            } else {
                setSessionMessage('No puedes modificar esta clase', " ¡Error! ", "error");
                redirect("/");
            }
        } else {
            setSessionMessage('Los valores que introduciste no son válidos', " ¡Error! ", "error");
            redirect("/clases/clase/editarClase/" . $idCurso . "/" . $idClase);
        }
    } else {
        goToIndex();
    }
}

function tomarClase() {
    $cursoUrl = $_GET['curso'];
    $idClase = $_GET['clase'];
    require_once 'modulos/cursos/clases/Clase.php';
    require_once 'modulos/cursos/modelos/ClaseModelo.php';
    require_once 'modulos/cursos/modelos/CursoModelo.php';
    require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';

    $curso = getCursoFromUniqueUrl($cursoUrl);
    $usuario = getUsuarioActual();
    $tipoUsuario = tipoUsuario();
    //Validar que la clase pertenezca al curso
    if (clasePerteneceACurso($curso->idCurso, $idClase)) {
        //Validar que el usuario este suscrito al curso
        if (esUsuarioUnAlumnoDelCurso($usuario->idUsuario, $curso->idCurso) ||
                $curso->idUsuario == $usuario->idUsuario ||
                $tipoUsuario == "administrador" ||
                $tipoUsuario == "administradorPrivado") {
            $clase = getClase($idClase);
            if ($tipoUsuario != "administrador") {
                //si no es un administrador, contar las views
                sumarVistaClase($idClase);
                sumarTotalView($curso->idCurso);
                registrarClaseTomada($usuario->idUsuario, $idClase);
            }
            $clases = obtenerClaseSiguienteYanterior($curso->idCurso, $idClase);
            $usoEnDisco = 0;
            switch ($clase->idTipoClase) {
                case 0:
                    if ($clase->transformado == 1) {
                        //dividimos el uso de disco entre dos, porque en la base de datos
                        //esta almacenado en uso de disco la suma del archivo mp4 y el ogv.
                        //No siempre el peso de los 2 es igual, pero es lo más cercano sin 
                        //necesitar otra columna en la bd ni tener que identificar que navegador es.
                        $usoEnDisco = $clase->usoDeDisco / 2;
                        //aquí aumentamos el ancho de banda utilizado
                        require_once('modulos/principal/modelos/variablesDeProductoModelo.php');
                        if (deltaVariableDeProducto("usoActualAnchoDeBanda", $usoEnDisco)) {
                            require_once 'modulos/cursos/vistas/tomarClaseVideo.php';
                        } else {
                            setSessionMessage("Ocurrió un error al cargar el video.", " ¡Error! ", "error");
                            redirect('/curso/' . $curso->uniqueUrl);
                        }
                    } else {
                        setSessionMessage("Este archivo de video aún se está transformando. Espera unos minutos", " ¡Espera! ", "error");
                        redirect('/curso/' . $curso->uniqueUrl);
                    }
                    break;
                case 1:
                case 2:
                    $usoEnDisco = $clase->usoDeDisco;
                    //aquí aumentamos el ancho de banda utilizado
                    require_once('modulos/principal/modelos/variablesDeProductoModelo.php');
                    if (deltaVariableDeProducto("usoActualAnchoDeBanda", $usoEnDisco)) {
                        require_once 'modulos/cursos/vistas/tomarClase.php';
                    } else {
                        setSessionMessage("Ocurrió un error al cargar el archivo.", " ¡Error! ", "error");
                        redirect('/curso/' . $curso->uniqueUrl);
                    }
                    break;
                case 3:
                    require_once 'modulos/cursos/vistas/tomarClaseTarjetas.php';
                    break;
                case 4:
                    if ($clase->transformado == 1) {
                        //dividimos el uso de disco entre dos, porque en la base de datos
                        //esta almacenado en uso de disco la suma del archivo mp4 y el ogv.
                        //No siempre el peso de los 2 es igual, pero es lo más cercano sin 
                        //necesitar otra columna en la bd ni tener que identificar que navegador es.
                        $usoEnDisco = $clase->usoDeDisco / 2;
                        //aquí aumentamos el ancho de banda utilizado
                        require_once('modulos/principal/modelos/variablesDeProductoModelo.php');
                        if (deltaVariableDeProducto("usoActualAnchoDeBanda", $usoEnDisco)) {
                            require_once 'modulos/cursos/vistas/tomarClaseAudio.php';
                        } else {
                            setSessionMessage("Ocurrió un error al cargar el audio.", " ¡Espera! ", "error");
                            redirect('/curso/' . $curso->uniqueUrl);
                        }
                    } else {
                        setSessionMessage("Este archivo de audio aún se está transformando. Espera unos minutos", " ¡Espera! ", "error");
                        redirect('/curso/' . $curso->uniqueUrl);
                    }
                    break;
            }
        } else {
            setSessionMessage("No puedes tomar esa clase, no tienens suscripción en ese curso", " ¡Error! ", "error");
            redirect("/");
        }
    } else {
        setSessionMessage("Ocurrió un error al mostrar el curso. Intenta de nuevo más tarde", " ¡Error! ", "error");
        redirect("/");
    }
}

function editor() {
    if (validarUsuarioLoggeado()) {
        if (isset($_GET['i']) && isset($_GET['j'])) {
            $idCurso = $_GET['i'];
            $idClase = $_GET['j'];
            $usuario = getUsuarioActual();
            require_once 'modulos/cursos/modelos/ClaseModelo.php';
            require_once 'modulos/cursos/modelos/CursoModelo.php';
            if ($usuario->idUsuario == getIdUsuarioDeCurso($idCurso) && clasePerteneceACurso($idCurso, $idClase)) {
                $clase = getClase($idClase);
                $curso = getCurso($idCurso);
                $tipoLayout = getTipoLayout();
                //Solo usar el editor en tables y desktops. Telefonos no!!
                if ($tipoLayout == "desktop" || $tipoLayout == "tablet") {
                    if ($clase->transformado == 1) {
                        if ($clase->idTipoClase == 0 || $clase->idTipoClase == 4) {
                            $usoEnDisco = $clase->usoDeDisco / 2;
                            //aquí aumentamos el ancho de banda utilizado
                            require_once('modulos/principal/modelos/variablesDeProductoModelo.php');
                            if (deltaVariableDeProducto("usoActualAnchoDeBanda", $usoEnDisco)) {
                                //obtenemos las formas predefinidas
                                require_once 'modulos/editorPopcorn/modelos/formasPredefinidasModelo.php';
                                $formasPredefinidas = getFormasPredefinidas();
                                require_once 'modulos/editorPopcorn/vistas/editorPopcorn.php';
                            } else {
                                setSessionMessage("Ocurrió un error al cargar el video.", " ¡Error! ", "error");
                                redirect('/curso/' . $curso->uniqueUrl);
                            }
                        } else {
                            setSessionMessage("No se puede editar este tipo de clase.", " ¡Error! ", "error");
                            redirect('/curso/' . $curso->uniqueUrl);
                        }
                    } else {
                        setSessionMessage("No se puede editar hasta que se termine de transformar.", " ¡Espera un poco! ", "error");
                        redirect('/curso/' . $curso->uniqueUrl);
                    }
                } else {
                    setSessionMessage("El editor no esta disponible en teléfonos móviles", " ¡Espera un poco! ", "error");
                    redirect('/curso/' . $curso->uniqueUrl);
                }
            } else {
                setSessionMessage('No puedes modificar esta clase', " ¡Error! ", "error");
                redirect("/");
            }
        } else {
            setSessionMessage('Los datos enviados no son correctos', " ¡Error! ", "error");
            redirect("/");
        }
    }
}

function guardarEdicionVideo() {
    $res = array();
    $resultado = "";
    $mensaje = "";
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
                $auxPostArray = array();
                //Cargamos los datos de video
                if (isset($_POST['videoData']))
                    $auxPostArray['videoData'] = $_POST['videoData'];
                //Cargamos los textos
                if (isset($_POST['textos']))
                    $auxPostArray['textos'] = $_POST['textos'];
                //Cargamos las imagenes
                if (isset($_POST['imagenes']))
                    $auxPostArray['imagenes'] = $_POST['imagenes'];
                //Cargamos los videos
                if (isset($_POST['videos']))
                    $auxPostArray['videos'] = $_POST['videos'];
                //Cargamos los links
                if (isset($_POST['links']))
                    $auxPostArray['links'] = $_POST['links'];
                //Cargamos las preguntas
                if (isset($_POST['preguntas'])) {
                    $auxPostArray['preguntas'] = $_POST['preguntas'];
                    //validamos que las preguntas que ya no se usen, se borren de la bd
                    require_once 'modulos/cursos/modelos/ControlModelo.php';
                    require_once 'modulos/cursos/modelos/ControlPreguntaModelo.php';
                    $control = getControlDeClase($idClase);
                    $preguntasEnBD = getIdsPreguntasDeControl($control->idControl);
                    //Cargamos los ids de las preguntas en un arreglo, para poder checarlo y borrar las que 
                    //ya no se usen
                    $idPreguntasNuevas = array();
                    foreach ($_POST['preguntas'] as $pregunta) {
                        array_push($idPreguntasNuevas, $pregunta['idPregunta']);
                    }
                    foreach ($preguntasEnBD as $pregunta) {
                        //checamos que esta pregunta este en uso
                        if (!in_array($pregunta, $idPreguntasNuevas)) {
                            //Si no esta en el arreglo, la debemos de borrar
                            bajaControlPregunta($pregunta);
                        }
                    }
                }
                $json = json_encode($auxPostArray);
                $json = str_replace("'", "", $json);
                //revisamos que los archivos que se subieron para esta clase aún se utilizen
                require_once 'modulos/editorPopcorn/modelos/archivosExtraModelo.php';
                $archivosExtra = getArchivosExtraDeClase($idClase);
                if (isset($archivosExtra)) {
                    foreach ($archivosExtra as $archivo) {
                        $auxName = substr(strrchr($archivo->link, "/"), 1);
                        if (strpos($json, $auxName) !== false) {
                            //echo 'El archivo ' . $archivo->link . ' todavía se usa<br>';
                            //No hacemos nada, el archivo esta en uso
                        } else {
                            //echo 'El archivo ' . $archivo->link . ' YA NO SE USA!<br>';
                            //El archivo ya no se usa, lo borramos del s3
                            require_once 'modulos/aws/modelos/s3Modelo.php';
                            //echo 'se va a borrar el id = ' . $archivo->idArchivoExtra . ' link= ' . $archivo->link;
                            if (deleteFileFromS3ByUrl($archivo->link)) {
                                //Se borro el archivo del s3, lo borramos de la bd
                                //echo 'se borro del s3 ';
                                if (borrarArchivoExtra($archivo->idArchivoExtra)) {
                                    //echo 'se borro de la bd';
                                }
                            }
                        }
                    }
                }
                if (actualizaCodigoClase($idClase, $json)) {
                    $resultado = "ok";
                    $mensaje = "Los cambios han sido guardados correctamente";
                } else {
                    $resultado = "error";
                    $mensaje = "Error al modificar la BD.";
                }
            } else {
                $resultado = "error";
                $mensaje = "No puedes modificar esta clase";
                echo json_encode($res);
            }
        } else {
            $resultado = "error";
            $mensaje = "Los datos recibidos son incorrectos";
            echo json_encode($res);
        }
    } else {
        $resultado = "error";
        $mensaje = "No hay usuario loggeado";
    }

    $res = array(
        "resultado" => $resultado,
        "mensaje" => $mensaje);
    echo json_encode($res);
}

//Funciones para la funcionalidad de la caja

function agregarTarjetas() {
    if (tipoUsuario() == "administrador") {
        require_once 'modulos/cursos/vistas/agregarTarjetas.php';
    } else {
        goToIndex();
    }
}

function agregarTarjetasSubmit() {
    //recibe un csv con el formato:
    // ladoA, ladoB, tiempo
    $idCaja = $_POST['idCaja'];

    if (tipoUsuario() == "administrador") {
        //Por ahora solo agregar este tipo de contenido si es un administrador
        if (isset($_FILES['archivoCsv'])) {
            //Validar que haya un archivo csv
            $archivoCsv = $_FILES["archivoCsv"]["tmp_name"];
            require_once 'modulos/cursos/modelos/CajaModelo.php';
            $res = agregarTarjetasDesdeCSV($idCaja, $archivoCsv);
            if ($res['resultado'] == 1) {
                //todo bien
                echo 'Se insertaron ' . $res['insertados'] . ' filas.';
            } else {
                //Ocurrió un error al importar las tarjetas
                foreach ($res['errores'] as $error) {
                    echo $error . '<br>';
                }
            }
        } else {
            //No hay archivo
            echo 'No hay archivo';
        }
    } else {
        goToIndex();
    }
}

function actualizarDatosDespuesDeTransformacion() {
    /*
     * Esta funcion recibe del transformador los siguientes datos en el post 
     * -bucket
     * -idClase
     * -key1
     * -key2
     * -duracion
     * -size (El tamaño de los 2 archivos sumados)
     */
    require_once 'modulos/aws/modelos/s3Modelo.php';
    $prefijoLink = getPrefijoLink();
    $archivo = $prefijoLink . $_POST['bucket'] . "/" . $_POST['key1'];
    $archivo2 = $prefijoLink . $_POST['bucket'] . "/" . $_POST['key2'];
    require_once 'modulos/cursos/modelos/ClaseModelo.php';
    if (actualizaArchivosDespuesTransformacion($_POST['idClase'], $archivo, $archivo2, $_POST['size'], $_POST['duracion'])) {
        require_once 'modulos/cursos/modelos/ClaseModelo.php';
        require_once 'modulos/cursos/modelos/CursoModelo.php';
        $clase = getClase($_POST['idClase']);
        $curso = getCursoPerteneciente($_POST['idClase']);
        $usuario = getUsuarioDeCurso($curso->idCurso);
        require_once 'modulos/email/modelos/envioEmailModelo.php';
        $url = getDomainName() . "/" . $curso->uniqueUrl;
        enviarMailTransformacionVideoCompleta("neto.r27@gmail.com", $curso->titulo, $clase->titulo, $url, $clase->idTipoClase);
        echo 'todo sereno';
    } else {
        echo 'error';
    }
}

?>