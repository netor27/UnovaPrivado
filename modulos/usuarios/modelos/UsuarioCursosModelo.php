<?php

require_once 'modulos/usuarios/clases/Usuario.php';

function getCursosInscrito($idUsuario, $offset, $numRows) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT u.idUsuario, c.imagen, c.idCurso, c.titulo, 
                                c.uniqueUrl, uc.fechaInscripcion,
                                count(distinct cl.idClase) as numClases, 
                                count(distinct tc.idClase) as numTomadas
                            FROM curso c
                            INNER JOIN usuario u ON c.idUsuario = u.idUsuario
                            LEFT OUTER JOIN tema t ON c.idCurso = t.idCurso
                            LEFT OUTER JOIN clase cl ON t.idTema = cl.idTema
                            LEFT OUTER JOIN usuariocurso uc ON c.idCurso = uc.idCurso
                            LEFT OUTER JOIN tomoclase tc ON cl.idClase = tc.idClase AND tc.idUsuario = :idUsuario
                            WHERE c.idCurso IN (
                                select idCurso
                                from usuariocurso
                                where idUsuario = :idUsuario
                            )
                            GROUP BY c.idCurso
                            ORDER BY c.titulo ASC
                            LIMIT $offset, $numRows");
    $stmt->bindParam(':idUsuario', $idUsuario);

    if (!$stmt->execute())
        print_r($stmt->errorInfo());

    $rows = $stmt->fetchAll();

    $cursos = null;
    $curso = null;
    $i = 0;
    foreach ($rows as $row) {
        $curso = new Curso();
        $curso->idCurso = $row['idCurso'];
        $curso->idUsuario = $row['idUsuario'];
        $curso->imagen = $row['imagen'];
        $curso->titulo = $row['titulo'];
        $curso->fechaInscripcion = $row['fechaInscripcion'];
        $curso->numeroDeClases = $row['numClases'];
        $curso->uniqueUrl = $row['uniqueUrl'];
        $curso->numeroDeTomadas = $row['numTomadas'];
        $cursos[$i] = $curso;
        $i++;
    }
    return $cursos;
}

function getCursosInstructor($idUsuario, $offset, $numRows) {
    require_once 'bd/conex.php';
    global $conex;

    $stmt = $conex->prepare("SELECT c.idCurso, c.titulo, c.uniqueUrl, c.imagen, c.fechaPublicacion
                                 FROM curso c
                                 WHERE c.idUsuario = :idUsuario 
                                 ORDER BY c.titulo ASC
                                 LIMIT $offset, $numRows");
    $stmt->bindParam(':idUsuario', $idUsuario);

    if ($stmt->execute()) {
        $cursos = null;
        $curso = null;
        $rows = $stmt->fetchAll();
        $i = 0;
        foreach ($rows as $row) {
            $curso = new Curso();
            $curso->idCurso = $row['idCurso'];
            $curso->titulo = $row['titulo'];
            $curso->imagen = $row['imagen'];
            $curso->uniqueUrl = $row['uniqueUrl'];
            $cursos[$i] = $curso;
            $i++;
        }
        return $cursos;
    } else {
        return null;
    }
}

function getCursosInscritoDetalles($idUsuario, $orderBy, $orderAscDesc, $offset, $numRows) {
    require_once 'bd/conex.php';
    global $conex;
    $auxOrder = "";
    if ($orderBy == "fechaInscripcion")
        $auxOrder = " uc.fechaInscripcion " . $orderAscDesc . " ";
    else if ($orderBy == "titulo")
        $auxOrder = " c.titulo " . $orderAscDesc . " ";

    $stmt = $conex->prepare("SELECT SQL_CALC_FOUND_ROWS u.idUsuario, u.nombreUsuario, 
                                u.uniqueUrl as uniqueUrlUsuario, c.imagen, c.descripcionCorta,  
                                c.idCurso, c.titulo, c.uniqueUrl, uc.fechaInscripcion, 
                                count(distinct uc.idUsuario) as numAlumnos, count(distinct cl.idClase) as numClases, 
                                count(distinct tc.idClase) as numTomadas
                            FROM curso c
                            INNER JOIN usuario u ON c.idUsuario = u.idUsuario
                            LEFT OUTER JOIN tema t ON c.idCurso = t.idCurso
                            LEFT OUTER JOIN clase cl ON t.idTema = cl.idTema
                            LEFT OUTER JOIN usuariocurso uc ON c.idCurso = uc.idCurso
                            LEFT OUTER JOIN tomoclase tc ON cl.idClase = tc.idClase AND tc.idUsuario = :idUsuario
                            WHERE c.idCurso IN (
                                select idCurso
                                from usuariocurso
                                where idUsuario = :idUsuario
                            )
                            GROUP BY c.idCurso
                            ORDER BY $auxOrder 
                            LIMIT $offset, $numRows");
    $stmt->bindParam(':idUsuario', $idUsuario);

    if (!$stmt->execute())
        print_r($stmt->errorInfo());

    $rows = $stmt->fetchAll();

    $r = $conex->query("SELECT FOUND_ROWS() as numero")->fetch();
    $n = $r['numero'];

    $cursos = null;
    $curso = null;
    $i = 0;
    foreach ($rows as $row) {
        $curso = new Curso();
        $curso->idCurso = $row['idCurso'];
        $curso->idUsuario = $row['idUsuario'];
        $curso->nombreUsuario = $row['nombreUsuario'];
        $curso->imagen = $row['imagen'];
        $curso->titulo = $row['titulo'];
        $curso->fechaInscripcion = $row['fechaInscripcion'];
        $curso->numeroDeAlumnos = $row['numAlumnos'];
        $curso->numeroDeClases = $row['numClases'];
        $curso->descripcionCorta = $row['descripcionCorta'];
        $curso->uniqueUrl = $row['uniqueUrl'];
        $curso->uniqueUrlUsuario = $row['uniqueUrlUsuario'];
        $curso->numeroDeTomadas = $row['numTomadas'];
        $cursos[$i] = $curso;
        $i++;
    }
    $array = array(
        "n" => $n,
        "cursos" => $cursos
    );
    return $array;
}

function getCursosInstructorDetalles($idUsuario, $orderBy, $orderAscDesc, $offset, $numRows) {
    require_once 'bd/conex.php';
    global $conex;
    $auxOrder = "";
    if ($orderBy == "fechaCreacion")
        $auxOrder = " c.fechaCreacion " . $orderAscDesc . " ";
    else if ($orderBy == "titulo")
        $auxOrder = " c.titulo " . $orderAscDesc . " ";

    $stmt = $conex->prepare("SELECT SQL_CALC_FOUND_ROWS u.idUsuario, u.nombreUsuario, u.uniqueUrl as uniqueUrlUsuario, c.idCurso, c.descripcionCorta, c.titulo, c.uniqueUrl, c.publicado, c.imagen, c.fechaCreacion, count(distinct uc.idUsuario) as numAlumnos, count(distinct cl.idClase) as numClases
                            FROM curso c
                            INNER JOIN usuario u ON c.idUsuario = u.idUsuario
                            LEFT OUTER JOIN tema t ON c.idCurso = t.idCurso
                            LEFT OUTER JOIN clase cl ON t.idTema = cl.idTema
                            LEFT OUTER JOIN usuariocurso uc ON c.idCurso = uc.idCurso
                            WHERE u.idUsuario = :idUsuario
                            GROUP BY c.idCurso
                            ORDER BY $auxOrder
                            LIMIT $offset, $numRows");
    $stmt->bindParam(':idUsuario', $idUsuario);

    if (!$stmt->execute())
        print_r($stmt->errorInfo());

    $rows = $stmt->fetchAll();

    $r = $conex->query("SELECT FOUND_ROWS() as numero")->fetch();
    $n = $r['numero'];

    $cursos = null;
    $curso = null;
    $i = 0;
    foreach ($rows as $row) {
        $curso = new Curso();
        $curso->idCurso = $row['idCurso'];
        $curso->titulo = $row['titulo'];
        $curso->publicado = $row['publicado'];
        $curso->imagen = $row['imagen'];
        $curso->fechaCreacion = $row['fechaCreacion'];
        $curso->numeroDeAlumnos = $row['numAlumnos'];
        $curso->numeroDeClases = $row['numClases'];
        $curso->descripcionCorta = $row['descripcionCorta'];
        $curso->uniqueUrl = $row['uniqueUrl'];
        $curso->idUsuario = $row['idUsuario'];
        $curso->nombreUsuario = $row['nombreUsuario'];
        $curso->uniqueUrlUsuario = $row['uniqueUrlUsuario'];
        $cursos[$i] = $curso;
        $i++;
    }
    $array = array(
        "n" => $n,
        "cursos" => $cursos
    );
    return $array;
}

function getCursosInstructorDetallesPublicados($idUsuario, $orderBy, $orderAscDesc) {
    require_once 'bd/conex.php';
    global $conex;
    $auxOrder = "";
    if ($orderBy == "fechaCreacion")
        $auxOrder = " c.fechaCreacion " . $orderAscDesc . " ";
    else if ($orderBy == "titulo")
        $auxOrder = " c.titulo " . $orderAscDesc . " ";

    $stmt = $conex->prepare("Select c.idCurso, c.descripcionCorta, c.titulo, c.uniqueUrl, c.publicado, c.imagen, c.fechaCreacion, count(distinct uc.idUsuario) as numAlumnos, count(distinct cl.idClase) as numClases
                            From curso c
                            INNER JOIN usuario u ON c.idUsuario = u.idUsuario
                            LEFT OUTER JOIN tema t ON c.idCurso = t.idCurso
                            LEFT OUTER JOIN clase cl ON t.idTema = cl.idTema
                            LEFT OUTER JOIN usuariocurso uc ON c.idCurso = uc.idCurso
                            where u.idUsuario = :idUsuario and c.publicado = 1
                            group by c.idCurso
                            order by $auxOrder");
    $stmt->bindParam(':idUsuario', $idUsuario);

    if ($stmt->execute()) {
        $cursos = null;
        $curso = null;
        $rows = $stmt->fetchAll();
        $i = 0;
        foreach ($rows as $row) {
            $curso = new Curso();
            $curso->idCurso = $row['idCurso'];
            $curso->titulo = $row['titulo'];
            $curso->publicado = $row['publicado'];
            $curso->imagen = $row['imagen'];
            $curso->fechaCreacion = $row['fechaCreacion'];
            $curso->numeroDeAlumnos = $row['numAlumnos'];
            $curso->numeroDeClases = $row['numClases'];
            $curso->descripcionCorta = $row['descripcionCorta'];
            $curso->uniqueUrl = $row['uniqueUrl'];
            $cursos[$i] = $curso;
            $i++;
        }
        return $cursos;
    } else {
        return null;
    }
}

function esUsuarioUnAlumnoDelCurso($idUsuario, $idCurso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT idUsuario 
                             FROM usuariocurso
                             WHERE idUsuario = :idUsuario AND idCurso = :idCurso");
    $stmt->bindParam(':idUsuario', $idUsuario);
    $stmt->bindParam(':idCurso', $idCurso);


    $stmt->execute();
    $rows = $stmt->fetchAll();
    if (sizeof($rows) > 0)
        return true;
    else
        return false;
}

function getNumeroCursosCreados($idUsuario) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT COUNT(*) as cuenta 
                             FROM curso
                             WHERE idUsuario = :idUsuario");
    $stmt->bindParam(':idUsuario', $idUsuario);

    $n = 0;
    if ($stmt->execute()) {
        $row = $stmt->fetch();
        $n = $row['cuenta'];
    }
    return $n;
}

function getNumeroCursosTomados($idUsuario) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT COUNT(*) as cuenta 
                             FROM usuariocurso
                             WHERE idUsuario = :idUsuario");
    $stmt->bindParam(':idUsuario', $idUsuario);

    $n = 0;
    if ($stmt->execute()) {
        $row = $stmt->fetch();
        $n = $row['cuenta'];
    }
    return $n;
}

function inscribirUsuarioCurso($idUsuario, $idCurso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("INSERT INTO usuariocurso (idUsuario, idCurso, fechaInscripcion)
                            VALUES(:idUsuario, :idCurso, NOW()) ");
    $stmt->bindParam(':idUsuario', $idUsuario);
    $stmt->bindParam(':idCurso', $idCurso);

    return $stmt->execute();
}

function eliminarInscripcionUsuarioCurso($idUsuario, $idCurso) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("DELETE FROM usuariocurso
                            WHERE idUsuario = :idUsuario
                            AND idCurso = :idCurso");
    $stmt->bindParam("idUsuario", $idUsuario);
    $stmt->bindParam("idCurso", $idCurso);
    if ($stmt->execute()) {
        return true;
    } else {
        print_r($stmt->errorInfo());
        return false;
    }
}

function getRatingUsuario($idUsuario, $idCurso) {
    require_once 'bd/conex.php';
    global $conex;

    $stmt = $conex->prepare("SELECT rating
                             FROM puntuacion
                             WHERE idUsuario = :idUsuario AND idCurso = :idCurso");
    $stmt->bindParam(':idUsuario', $idUsuario);
    $stmt->bindParam(':idCurso', $idCurso);
    $n = 0;
    if ($stmt->execute()) {
        $row = $stmt->fetch();
        $n = $row['rating'];
    }
    return $n;
}

function setRatingUsuario($idUsuario, $idCurso, $rating) {
    require_once 'bd/conex.php';
    global $conex;

    //tratamos de insertar en la tabla puntuación
    beginTransaction();
    $stmt = $conex->prepare("INSERT into puntuacion
                            (idUsuario, idCurso, rating)
                            VALUES(:idUsuario, :idCurso, :rating)");
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':idUsuario', $idUsuario);
    $stmt->bindParam(':idCurso', $idCurso);

    if (!$stmt->execute()) {
        //si NO se pudo ejecutar es que ya había una tupla con esos ids, actualizamos el rating
        $stmt = $conex->prepare("UPDATE puntuacion 
                            SET rating = :rating
                            WHERE idUsuario = :idUsuario AND idCurso = :idCurso");
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->bindParam(':idCurso', $idCurso);

        $stmt->execute();
    }

    //Ahora, hacemos el update de la variable rating de la tabla curso
    $stmt = $conex->prepare("SELECT count(rating) as cuenta, sum(rating) as suma
                            FROM puntuacion
                            WHERE idCurso = :idCurso");
    $stmt->bindParam(':idCurso', $idCurso);
    $stmt->execute();

    $row = $stmt->fetch();
    $n = $row['cuenta'];
    $sum = $row['suma'];
    $prom = $sum / $n;

    $stmt = $conex->prepare("UPDATE curso 
                            SET rating = :rating
                            WHERE idCurso = :idCurso");
    $stmt->bindParam(':rating', $prom);
    $stmt->bindParam(':idCurso', $idCurso);

    if ($stmt->execute()) {
        commitTransaction();
        return true;
    } else {
        rollBackTransaction();
        return false;
    }
}

function getNumeroDeNuevosAlumnos($idUsuario, $dias) {
    require_once 'bd/conex.php';
    global $conex;
    $stmt = $conex->prepare("SELECT COUNT(uc.idUsuario) AS cuenta
                             FROM usuario u, curso c, usuariocurso uc
                             WHERE u.idUsuario = c.idUsuario AND c.idCurso = uc.idCurso
                             AND u.idUsuario = :idUsuario
                             AND fechaInscripcion >= DATE_SUB(NOW(), INTERVAL $dias DAY)");
    $stmt->bindParam(':idUsuario', $idUsuario);
    $cuenta = 0;
    if ($stmt->execute()) {
        $row = $stmt->fetch();
        $cuenta = $row['cuenta'];
    }
    return $cuenta;
}

?>
