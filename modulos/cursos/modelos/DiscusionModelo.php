<?php

require_once 'modulos/cursos/clases/Discusion.php';

function altaDiscusion($discusion) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT INTO discusion (idCurso, idUsuario, fecha, titulo, texto, puntuacion) 
                            VALUES (:idCurso, :idUsuario, NOW(), :titulo, :texto, 0)");
    $stmt->bindParam(":idCurso", $discusion->idCurso);
    $stmt->bindParam(":idUsuario", $discusion->idUsuario);
    $stmt->bindParam(":titulo", $discusion->titulo);
    $stmt->bindParam(":texto", $discusion->texto);
    $id = -1;
    if ($stmt->execute()) {
        $id = $conex->lastInsertId();
    } else {
        print_r($stmt->errorInfo());
    }
    return $id;
}

function bajaDiscusion($idDiscusion) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("DELETE FROM discusion WHERE idDiscusion = :id");
    $stmt->bindParam(':id', $idDiscusion);
    $stmt->execute();
    return $stmt->rowCount();
}

function getDiscusion($idDiscusion) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM discusion
                            WHERE idDiscusion = :id");
    $stmt->bindParam(':id', $idDiscusion);
    $stmt->execute();
    $discusion = NULL;
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $discusion = new Discusion();
        //idCurso, idUsuario, fecha, titulo, texto, puntuacion
        $discusion->idDiscusion = $row['idDiscusion'];
        $discusion->idCurso = $row['idCurso'];
        $discusion->idUsuario = $row['idUsuario'];
        $discusion->fecha = $row['fecha'];
        $discusion->titulo = $row['titulo'];
        $discusion->texto = $row['texto'];
        $discusion->puntuacion = $row['puntuacion'];
    }
    return $discusion;
}

function actualizarVotacionDeDiscusion($idDiscusion, $delta) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("UPDATE discusion
                            SET puntuacion = puntuacion + $delta
                            WHERE idDiscusion = :id");
    $stmt->bindParam(':id', $idDiscusion);
    return $stmt->execute();
}

function getPuntuacionDiscusion($idDiscusion) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT puntuacion 
                            FROM discusion
                            WHERE idDiscusion = :id");
    $stmt->bindParam(':id', $idDiscusion);
    $stmt->execute();
    $puntuacion = null;
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $puntuacion = $row['puntuacion'];
    }
    return $puntuacion;
}

function getDiscusiones($idCurso, $offset, $numRows) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT SQL_CALC_FOUND_ROWS d.idDiscusion, d.idCurso, d.idUsuario, 
                            d.fecha, d.titulo, d.puntuacion, u.avatar, u.nombreUsuario, u.uniqueUrl
                            FROM discusion d, usuario u                            
                            WHERE idCurso = :id AND d.idUsuario = u.idUsuario
                            ORDER BY d.fecha DESC
                            LIMIT $offset, $numRows");
    $stmt->bindParam(':id', $idCurso);
    $discusion = NULL;
    $discusiones = array();
    $i = 0;
    $n = -1;
    if ($stmt->execute()) {
        $rows = $stmt->fetchAll();
        $r = $conex->query("SELECT FOUND_ROWS() as numero")->fetch();
        $n = $r['numero'];
        foreach ($rows as $row) {
            $discusion = new Discusion();
            $discusion->idDiscusion = $row['idDiscusion'];
            $discusion->idCurso = $row['idCurso'];
            $discusion->idUsuario = $row['idUsuario'];
            $discusion->fecha = $row['fecha'];
            $discusion->titulo = $row['titulo'];
            $discusion->puntuacion = $row['puntuacion'];
            $discusion->usuarioAvatar = $row['avatar'];
            $discusion->usuarioNombre = $row['nombreUsuario'];
            $discusion->usuarioUrl = $row['uniqueUrl'];
            $discusiones[$i] = $discusion;
            $i++;
        }
    }
    $array = array(
        "n" => $n,
        "discusiones" => $discusiones
    );
    return $array;
}

function printDiscusion($discusion) {
    $fecha = transformaMysqlDateDDMMAAAAConHora($discusion->fecha);
    $badgeClass = "badge";
    if ($discusion->puntuacion < 0) {
        $badgeClass .= " badge-important";
    } else if ($discusion->puntuacion > 0) {
        $badgeClass .= " badge-success";
    }

    $votacionMas = "";
    $iconMas = "";
    $votacionMenos = "";
    $iconMenos = "";
    $votacion = getVotacionDiscurso($discusion->idDiscusion);
    if ($votacion == 1) {
        $votacionMas = "votado label label-success";
        $iconMas = "icon-white";
    }
    if ($votacion == -1) {
        $votacionMenos = "votado label label-important";
        $iconMenos = "icon-white";
    }
    
    echo "<div class='well-small ui-state-default ui-corner-all margin-top10' ><div class='row-fluid'>
            <div class='span12'>
                <div class='row-fluid'>
                    <div class='span1'>
                        <img class='img-polaroid ui-corner-all discusionAvatarUsuario' src='$discusion->usuarioAvatar'>
                    </div>
                    <div class='span9'>
                        <div class='row-fluid'>
                            <div class='span12'>
                                <span class='discusionNombreUsuario'>
                                    $discusion->usuarioNombre
                                </span>
                            </div>                            
                        </div>
                        <div class='row-fluid'>
                            <div class='span12'>
                                <span class='discusionTitulo discusion' discusion='$discusion->idDiscusion'>
                                    $discusion->titulo
                                </span>    
                            </div>                            
                        </div>
                    </div>
                    <div class='span2'>
                        <div class='row-fluid'>
                            <div class='span12'>
                                <span class='discusionTiempo'>
                                    $fecha
                                </span>
                            </div>
                        </div> 
                        <div class='row-fluid'>
                            <div class='span12'>
                                <span class='discusionTiempo'>
                                    Puntuación: <span class='badge $badgeClass' id='puntuacion_$discusion->idDiscusion'>$discusion->puntuacion</span>
                                </span>
                            </div>
                        </div>
                        <div class='row-fluid'>
                            <div class='span2'>
                                <span class='discusionVotacion discusionVotacionMas $votacionMas' discusion='$discusion->idDiscusion' id='votacionMas_$discusion->idDiscusion'>                                
                                    <i class='icon-thumbs-up $iconMas'></i>
                                </span>
                            </div>
                            <div class='span2'>
                                <span class='discusionVotacion discusionVotacionMenos $votacionMenos' discusion='$discusion->idDiscusion' id='votacionMenos_$discusion->idDiscusion'>
                                    <i class='icon-thumbs-down $iconMenos'></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div></div>";
}

function usuarioPuedeVotar($idDiscusion, $delta) {
    $resultado = -1;
    $arreglo = null;
    //Revisamos primero las cookies
    if (isset($_COOKIE['votacionesDiscusion'])) {
        $arreglo = unserialize($_COOKIE['votacionesDiscusion']);
    } else if (isset($_SESSION['votacionesDiscusion'])) {
        $arreglo = $_SESSION['votacionesDiscusion'];
    }
    if (isset($arreglo)) {
        //hay datos en session o cookies
        if (isset($arreglo[$idDiscusion])) {
            if ($arreglo[$idDiscusion] == $delta) {
                //ya hay datos y es el mismo voto, ya no votar
                $resultado = 0;
            } else {
                //cambio su voto, compensamos
                $resultado = 2;
            }
        } else {
            //no hay datos de esa discusion, puede votar
            $resultado = 1;
        }
    } else {
        //no hay datos guardados, puede votar
        $resultado = 1;
    }
    return $resultado;
}

function guardarVotacionDiscusionSesion($idDiscusion, $delta) {
    $arreglo = null;
    //Revisamos primero las cookies
    if (isset($_COOKIE['votacionesDiscusion'])) {
        $arreglo = unserialize($_COOKIE['votacionesDiscusion']);
    } else if (isset($_SESSION['votacionesDiscusion'])) {
        $arreglo = $_SESSION['votacionesDiscusion'];
    }
    if (!isset($arreglo)) {
        $arreglo = array();
    }
    $arreglo[$idDiscusion] = $delta;
    $_SESSION['votacionesDiscusion'] = $arreglo;
    $serialized = serialize($arreglo);
    $tiempo = 2592000; //tiempo que va a durar la cookie, alrededor de 30 días
    setcookie("votacionesDiscusion", $serialized, time() + $tiempo, '/');
}

function getVotacionDiscurso($idDiscusion) {
    $resultado = 0;
    $arreglo = null;
    //Revisamos primero las cookies
    if (isset($_COOKIE['votacionesDiscusion'])) {
        $arreglo = unserialize($_COOKIE['votacionesDiscusion']);
    } else if (isset($_SESSION['votacionesDiscusion'])) {
        $arreglo = $_SESSION['votacionesDiscusion'];
    }    
    if (isset($arreglo)) {
        //hay datos en session o cookies
        if (isset($arreglo[$idDiscusion])) {
            $resultado = $arreglo[$idDiscusion];
        } else {
            $resultado = 0;
        }
    } else {
        //no hay datos guardados
        $resultado = 0;
    }
    return $resultado;
}

?>