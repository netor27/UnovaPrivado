<?php

require_once 'modulos/cursos/clases/Comentario.php';

function altaComentario($comentario) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT INTO comentario (idDiscusion, idUsuario, fecha, texto, puntuacionMas, puntuacionMenos) 
                            VALUES (:idDiscusion, :idUsuario, NOW(), :texto, 0, 0)");
    $stmt->bindParam(":idDiscusion", $comentario->idDiscusion);
    $stmt->bindParam(":idUsuario", $comentario->idUsuario);
    $stmt->bindParam(":texto", $comentario->texto);
    $id = -1;
    if ($stmt->execute()) {
        $id = $conex->lastInsertId();
    } else {
        print_r($stmt->errorInfo());
    }
    return $id;
}

function bajaComentario($idComentario) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("DELETE FROM comentario WHERE idComentario = :id");
    $stmt->bindParam(':id', $idComentario);
    $stmt->execute();
    return $stmt->rowCount();
}

function getComentario($idComentario) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT c.idComentario, c.idDiscusion, c.idUsuario, 
                            c.fecha, c.texto, u.avatar, u.nombreUsuario, u.uniqueUrl, 
                            c.puntuacionMas, c.puntuacionMenos
                            FROM comentario c, usuario u                            
                            WHERE idComentario = :id AND c.idUsuario = u.idUsuario");
    $stmt->bindParam(':id', $idComentario);
    if (!$stmt->execute()) {
        echo $stmt->queryString . "<br>";
        print_r($stmt->errorInfo());
    }
    $comentario = NULL;
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $comentario = new Comentario();
        //idCurso, idUsuario, fecha, titulo, texto, puntuacion
        $comentario->idComentario = $row['idComentario'];
        $comentario->idDiscusion = $row['idDiscusion'];
        $comentario->idUsuario = $row['idUsuario'];
        $comentario->fecha = $row['fecha'];
        $comentario->texto = $row['texto'];
        $comentario->puntuacionMas = $row['puntuacionMas'];
        $comentario->puntuacionMenos = $row['puntuacionMenos'];
        $comentario->usuarioAvatar = $row['avatar'];
        $comentario->usuarioNombre = $row['nombreUsuario'];
        $comentario->usuarioUrl = $row['uniqueUrl'];
    }
    return $comentario;
}

function actualizarVotacionDeComentario($idComentario, $delta) {
    if ($delta != 0) {
        //solo hacemos operaciones si el delta es diferente de cero
        require_once 'bd/conex.php';
        global $conex;
        $setStatement = "";
        //El delta solo tiene 4 valores posibles (-2,-1,1,2), lo validamos
        if ($delta > 2)
            $delta = 2;
        if ($delta < -2)
            $delta = -2;

        if ($delta > 0) {
            //si es positivo, sumamos en puntuacionMas
            $setStatement = " puntuacionMas = puntuacionMas + 1";
            if ($delta == 2) {
                //si es 2, significa que hay que compensar el voto anterior negativo
                //restamos en puntuacionMenos
                $setStatement .= ", puntuacionMenos = puntuacionMenos - 1";
            }
        } else {
            //si no, es negativo. Sumamos en puntuacionMenos
            $setStatement = " puntuacionMenos = puntuacionMenos + 1";
            if ($delta == -2) {
                //si es -2, significa que hay que compensar el voto anterior positivo
                //restamos en puntuacionMenos
                $setStatement .= ", puntuacionMas = puntuacionMas - 1";
            }
        }
        $stmt = $conex->prepare("UPDATE comentario
                            SET $setStatement 
                            WHERE idComentario = :id");
        $stmt->bindParam(':id', $idComentario);
        return $stmt->execute();
    } else {
        return false;
    }
}

function getPuntuacionComentario($idComentario) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT puntuacionMas, puntuacionMenos
                            FROM comentario
                            WHERE idComentario = :id");
    $stmt->bindParam(':id', $idComentario);
    $stmt->execute();
    $puntuacion = null;
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $puntuacion = array(
            "puntuacionMas" => $row['puntuacionMas'],
            "puntuacionMenos" => $row['puntuacionMenos']
        );
    }
    return $puntuacion;
}

function getComentarios($idDiscusion, $offset, $numRows, $ordenarPor, $ascendente) {
    require_once 'bd/conex.php';
    global $conex;

    $select = "SELECT SQL_CALC_FOUND_ROWS c.idComentario, c.idDiscusion, c.idUsuario, 
        c.fecha, c.texto, u.avatar, u.nombreUsuario, u.uniqueUrl, 
        c.puntuacionMas, c.puntuacionMenos";
    $orden = "";
    switch ($ordenarPor) {
        case 'puntuacion':
            $select .= ", ((c.puntuacionMas + 1.9208) / (c.puntuacionMas + c.puntuacionMenos) - 1.96 * SQRT((c.puntuacionMas * c.puntuacionMenos) / (c.puntuacionMas + c.puntuacionMenos) + 0.9604) /(c.puntuacionMas + c.puntuacionMenos)) / (1 + 3.8416 / (c.puntuacionMas + c.puntuacionMenos)) AS orden ";
            $orden = "orden ";
            break;
        case 'fecha':
            $orden = "c.fecha ";
            break;
        case 'alfabetico':
            $orden = "c.texto";
            break;
    }
    if ($ascendente == 0) {
        $orden .= " DESC";
    } else {
        $orden .= " ASC";
    }
    $stmt = $conex->prepare("$select 
                            FROM comentario c, usuario u                            
                            WHERE idDiscusion = :id AND c.idUsuario = u.idUsuario
                            ORDER BY $orden 
                            LIMIT $offset, $numRows");
    $stmt->bindParam(':id', $idDiscusion);
    $comentario = NULL;
    $comentarios = array();
    $i = 0;
    $n = -1;

    if ($stmt->execute()) {
        $rows = $stmt->fetchAll();
        $r = $conex->query("SELECT FOUND_ROWS() as numero")->fetch();
        $n = $r['numero'];
        foreach ($rows as $row) {
            $comentario = new Comentario();
            $comentario->idComentario = $row['idComentario'];
            $comentario->idDiscusion = $row['idDiscusion'];
            $comentario->idUsuario = $row['idUsuario'];
            $comentario->fecha = $row['fecha'];
            $comentario->texto = $row['texto'];
            $comentario->puntuacionMas = $row['puntuacionMas'];
            $comentario->puntuacionMenos = $row['puntuacionMenos'];
            $comentario->usuarioAvatar = $row['avatar'];
            $comentario->usuarioNombre = $row['nombreUsuario'];
            $comentario->usuarioUrl = $row['uniqueUrl'];
            $comentarios[$i] = $comentario;
            $i++;
        }
    } else {
        echo $stmt->queryString . "<br>";
        print_r($stmt->errorInfo());
    }
    $array = array(
        "n" => $n,
        "comentarios" => $comentarios
    );
    return $array;
}

function printComentario($comentario) {
    $fecha = transformaMysqlDateDDMMAAAAConHora($comentario->fecha);
    $votosTotales = $comentario->puntuacionMas + $comentario->puntuacionMenos;
    if ($comentario->puntuacionMas > 0) {
        if ($comentario->puntuacionMenos > 0) {
            $porcentajePositivo = round($comentario->puntuacionMas / $votosTotales * 100);
            $porcentajeNegativo = 100 - $porcentajePositivo;
        } else {
            $porcentajePositivo = 100;
            $porcentajeNegativo = 0;
        }
    } else {
        if ($comentario->puntuacionMenos > 0) {
            $porcentajePositivo = 0;
            $porcentajeNegativo = 100;
        } else {
            $porcentajePositivo = 0;
            $porcentajeNegativo = 0;
        }
    }
    //Permitir borrar la entrada si el usuario es administrador, profesor
    $botonBorrar = "";
    if (tipoUsuario() != 'usuario') {
        $botonBorrar = "<a class='btnBorrarComentario' href='#' comentario='$comentario->idComentario'><i class='icon-remove'></i></a>";
    }
    echo "<div class='well-small ui-state-default ui-corner-all margin-top10' >
    <div class='row-fluid'>
        <div class='span12'>
            <div class='row-fluid'>
                <div class='span1'>
                    <a href='/usuario/$comentario->usuarioUrl'>
                        <img class='hidden-phone img-polaroid ui-corner-all comentarioAvatarUsuario' src='$comentario->usuarioAvatar'>
                        <img class='visible-phone img-polaroid ui-corner-all comentarioAvatarUsuario imageSmallPhone' src='$comentario->usuarioAvatar'>
                    </a>
                </div>
                <div class='span8'>
                    <p>
                        <a href='/usuario/$comentario->usuarioUrl'>
                            <span class='comentarioNombreUsuario'>
                                $comentario->usuarioNombre
                            </span>
                        </a>
                    </p>
                    <p>
                        <span class='comentarioTiempo'>
                            $fecha
                        </span>
                    </p>
                </div>
                <div class='span3'>
                    <div class='row-fluid centerText'>
                        <div class='span1 offset11'>
                            $botonBorrar
                        </div>
                    </div> 
                    <div class='row-fluid'>
                        <div class='span4 offset4'>
                            <span class='comentarioVotacion comentarioVotacionMas' comentario='$comentario->idComentario' id='votacionMas_$comentario->idComentario'>                                
                                <i class='icon-thumbs-up'></i> <span>$comentario->puntuacionMas</span>
                            </span>
                        </div>
                        <div class='span4'>
                            <span class='comentarioVotacion comentarioVotacionMenos' comentario='$comentario->idComentario' id='votacionMenos_$comentario->idComentario'>
                                <i class='icon-thumbs-down'></i> <span>$comentario->puntuacionMenos</span>
                            </span>
                        </div>
                    </div>
                    <div class='row-fluid' style='min-height:3px;'>
                        <div class='span10 offset2' style='min-height:3px;'>
                            <div class='progress' style='height:3px;margin-bottom:0px;'>
                                <div class='bar bar-success' style='width: $porcentajePositivo%;' id='porcentajePositivo_$comentario->idComentario'></div>
                                <div class='bar bar-danger' style='width: $porcentajeNegativo%;' id='porcentajeNegativo_$comentario->idComentario'></div>
                            </div>                                
                        </div>
                    </div>                        
                </div>
            </div>
            <br>
            <div class='row-fluid'>
                <div class='span12 '>
                    <span class='comentario' comentario='$comentario->idComentario'>
                        $comentario->texto
                    </span>
                </div>                            
            </div>
        </div>
    </div>
</div>";
}
?>