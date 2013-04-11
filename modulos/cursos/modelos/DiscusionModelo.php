<?php

require_once 'modulos/cursos/clases/Discusion.php';

function altaDiscusion($discusion) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT INTO discusion (idCurso, idUsuario, fecha, titulo, texto, puntuacionMas, puntuacionMenos) 
                            VALUES (:idCurso, :idUsuario, NOW(), :titulo, :texto, 0, 0)");
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
        $discusion->puntuacionMas = $row['puntuacionMas'];
        $discusion->puntuacionMenos = $row['puntuacionMenos'];
    }
    return $discusion;
}

function actualizarVotacionDeDiscusion($idDiscusion, $delta) {
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
        $stmt = $conex->prepare("UPDATE discusion
                            SET $setStatement 
                            WHERE idDiscusion = :id");
        $stmt->bindParam(':id', $idDiscusion);
        return $stmt->execute();
    } else {
        return false;
    }
}

function getPuntuacionDiscusion($idDiscusion) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT puntuacionMas, puntuacionMenos
                            FROM discusion
                            WHERE idDiscusion = :id");
    $stmt->bindParam(':id', $idDiscusion);
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

function getDiscusiones($idCurso, $offset, $numRows, $ordenarPor, $ascendente) {
    require_once 'bd/conex.php';
    global $conex;
    /*
      SELECT SQL_CALC_FOUND_ROWS d.idDiscusion, d.idCurso, d.idUsuario, d.fecha, d.titulo, u.avatar, u.nombreUsuario, u.uniqueUrl, (d.puntuacionMas - d.puntuacionMenos) as puntuacion,
      ((d.puntuacionMas + 1.9208) / (d.puntuacionMas + d.puntuacionMenos) - 1.96 * SQRT((puntuacionMas * d.puntuacionMenos) / (puntuacionMas + d.puntuacionMenos) + 0.9604) /(puntuacionMas + d.puntuacionMenos)) / (1 + 3.8416 / (puntuacionMas + d.puntuacionMenos)) AS orden
      FROM discusion d, usuario u
      WHERE idCurso = 47 AND d.idUsuario = u.idUsuario
      ORDER BY orden DESC, fecha DESC
     */
    $select = "SELECT SQL_CALC_FOUND_ROWS d.idDiscusion, d.idCurso, d.idUsuario, 
        d.fecha, d.titulo, u.avatar, u.nombreUsuario, u.uniqueUrl, 
        d.puntuacionMas, d.puntuacionMenos";
    $orden = "";
    switch ($ordenarPor) {
        case 'puntuacion':
            $select .= ", ((d.puntuacionMas + 1.9208) / (d.puntuacionMas + d.puntuacionMenos) - 1.96 * SQRT((puntuacionMas * d.puntuacionMenos) / (puntuacionMas + d.puntuacionMenos) + 0.9604) /(puntuacionMas + d.puntuacionMenos)) / (1 + 3.8416 / (puntuacionMas + d.puntuacionMenos)) AS orden ";
            $orden = "orden ";
            break;
        case 'fecha':
            $orden = "d.fecha ";
            break;
        case 'alfabetico':
            $orden = "d.titulo";
            break;
    }
    if ($ascendente == 0) {
        $orden .= " DESC";
    } else {
        $orden .= " ASC";
    }
    $stmt = $conex->prepare("$select 
                            FROM discusion d, usuario u                            
                            WHERE idCurso = :id AND d.idUsuario = u.idUsuario
                            ORDER BY $orden 
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
            $discusion->puntuacionMas = $row['puntuacionMas'];
            $discusion->puntuacionMenos = $row['puntuacionMenos'];
            $discusion->usuarioAvatar = $row['avatar'];
            $discusion->usuarioNombre = $row['nombreUsuario'];
            $discusion->usuarioUrl = $row['uniqueUrl'];
            $discusiones[$i] = $discusion;
            $i++;
        }
    } else {
        echo $stmt->queryString . "<br>";
        print_r($stmt->errorInfo());
    }
    $array = array(
        "n" => $n,
        "discusiones" => $discusiones
    );
    return $array;
}

function printDiscusion($discusion,$cursoUrl) {
    $fecha = transformaMysqlDateDDMMAAAAConHora($discusion->fecha);
    $votosTotales = $discusion->puntuacionMas + $discusion->puntuacionMenos;
    if ($discusion->puntuacionMas > 0) {
        if ($discusion->puntuacionMenos > 0) {
            $porcentajePositivo = round($discusion->puntuacionMas / $votosTotales * 100);
            $porcentajeNegativo = 100 - $porcentajePositivo;
        } else {
            $porcentajePositivo = 100;
            $porcentajeNegativo = 0;
        }
    } else {
        if ($discusion->puntuacionMenos > 0) {
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
        $botonBorrar = "<a class='btnBorrarDiscusion' href='#' discusion='$discusion->idDiscusion'><i class='icon-remove'></i></a>";
    }
    echo "<div class='well-small ui-state-default ui-corner-all margin-top10' ><div class='row-fluid'>
            <div class='span12'>
                <div class='row-fluid'>
                    <div class='span1'>
                        <img class='hidden-phone img-polaroid ui-corner-all discusionAvatarUsuario' src='$discusion->usuarioAvatar'>
                        <img class='visible-phone img-polaroid ui-corner-all discusionAvatarUsuario imageSmallPhone' src='$discusion->usuarioAvatar'>
                    </div>
                    <div class='span8'>
                        <div class='row-fluid'>
                            <div class='span12'>
                                <span class='discusionNombreUsuario'>
                                    $discusion->usuarioNombre
                                </span>
                            </div>                            
                        </div>
                        <div class='row-fluid'>
                            <div class='span12'>
                            <a href='/curso/$cursoUrl/temaDiscusion/$discusion->idDiscusion'>
                                <span class='discusionTitulo discusion' discusion='$discusion->idDiscusion'>
                                    $discusion->titulo
                                </span>    
                                </a>
                            </div>                            
                        </div>
                    </div>
                    <div class='span3'>
                        <div class='row-fluid centerText'>
                            <div class='span11'>
                                <span class='discusionTiempo'>
                                    $fecha
                                </span>
                            </div>
                            <div class='span1'>
                                $botonBorrar
                            </div>
                        </div> 
                        <div class='row-fluid'>
                            <div class='span4 offset4'>
                                <span class='discusionVotacion discusionVotacionMas' discusion='$discusion->idDiscusion' id='votacionMas_$discusion->idDiscusion'>                                
                                    <i class='icon-thumbs-up'></i> <span>$discusion->puntuacionMas</span>
                                </span>
                            </div>
                            <div class='span4'>
                                <span class='discusionVotacion discusionVotacionMenos' discusion='$discusion->idDiscusion' id='votacionMenos_$discusion->idDiscusion'>
                                    <i class='icon-thumbs-down'></i> <span>$discusion->puntuacionMenos</span>
                                </span>
                            </div>
                        </div>
                        <div class='row-fluid' style='min-height:3px;'>
                            <div class='span10 offset2' style='min-height:3px;'>
                                <div class='progress' style='height:3px;margin-bottom:0px;'>
                                    <div class='bar bar-success' style='width: $porcentajePositivo%;' id='porcentajePositivo_$discusion->idDiscusion'></div>
                                    <div class='bar bar-danger' style='width: $porcentajeNegativo%;' id='porcentajeNegativo_$discusion->idDiscusion'></div>
                                </div>                                
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div></div>";
}

?>