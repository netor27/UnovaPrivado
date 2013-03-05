<?php

require_once 'modulos/aws/modelos/sesModelo.php';
require_once 'modulos/email/modelos/defineEmailVariables.php';

function enviarMailBienvenida($email, $nombreUsuario, $urlConfirmacion) {
    $text = 'Bienvenido a Unova,\n' . utf8_encode($nombreUsuario) . '\n
        Haz quedado registrado satisfactoriamente en Unova,\n 
        por favor confirma tu cuenta siguiendo este enlace:\n\n
        ' . $urlConfirmacion;
    $html = HEADER . '
        <h1 style="font-size:18px">Bienvenido a Unova, ' . utf8_encode($nombreUsuario) . '</h1>
            <table bgcolor="#ffffff" width="100%" cellpadding="0" cellspacing="0" style="padding:15px 0 15px 0">
                <tbody>
                    <tr valign="top">
                        <td style="font-size:13px;margin: 10px; padding: 10px;">
                            <p style="padding:10px;margin:0">Haz quedado registrado satisfactoriamente en Unova, por favor confirma tu cuenta siguiendo este enlace:</p>
                            <p style="padding:10px;margin:0">
                               <a href="' . $urlConfirmacion . '">' . $urlConfirmacion . '</a>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>' . FOOTER;
    $to[] = $email;
    return sendMailSES($text, $html, "Te damos la bienvenida a Unova", EMAIL_FROM, $to);
}

function enviarMailConfirmacion($email, $urlConfirmacion) {
    $text = 'Confirmaci&oacute;n de cuenta,\n\n
        Para confirmar tu cuenta sigue este enlace:\n\n
        ' . $urlConfirmacion . '\n\n
        Gracias, equipo Unova.';
    $html = HEADER . '
        <h1 style="font-size:18px">Confirmaci&oacute;n de cuenta</h1>
        <table bgcolor="#ffffff" width="100%" cellpadding="0" cellspacing="0" style="padding:15px 0 15px 0">
                <tbody>
                    <tr valign="top">
                        <td style="font-size:13px;margin: 10px; padding: 10px;">
                            <p style="padding:10px;margin:0">Para confirmar tu cuenta sigue este enlace:</p>
                            <p style="padding:10px;margin:0"><a href="' . $urlConfirmacion . '">' . $urlConfirmacion . '</a></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        ' . FOOTER;
    $to[] = $email;
    return sendMailSES($text, $html, "Confirmacion de cuenta", EMAIL_FROM, $to);
}

function enviarMailOlvidePassword($email, $urlReestablecer) {
    $text = 'Reestablecer contrase&ntilde;a,\n\n
        Para reestablecer tu contrase&ntilde;a sigue este enlace:\n\n
        ' . $urlReestablecer . '\n\n
        Gracias, equipo Unova.';
    $html = HEADER . '
        <h1 style="font-size:18px">Reestablecer contrase&ntilde;a</h1>
        <table bgcolor="#ffffff" width="100%" cellpadding="0" cellspacing="0" style="padding:15px 0 15px 0">
                <tbody>
                    <tr valign="top">
                        <td style="font-size:13px;margin: 10px; padding: 10px;">
                            <p style="padding:10px;margin:0">Para reestablecer tu contrase&ntilde;a sigue este enlace:</p>
                            <p style="padding:10px;margin:0"><a href="' . $urlReestablecer . '">' . $urlReestablecer . '</a></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        ' . FOOTER;
    $to[] = $email;
    return sendMailSES($text, $html, utf8_encode("Reestablecer contraseña"), EMAIL_FROM, $to);
}

function enviarMailSuscripcionUsuario($email, $urlReestablecer) {
    $text = 'Bienvenido a Unova,\n\n
        Para poder utilizar esta plataforma de educaci&oacute;n en l&iacute;nea s&oacute;lo 
        tienes que ingresar al siguiente enlace.\n\n        
        ' . $urlReestablecer . '\n\n
        Gracias, equipo Unova.';
    $html = HEADER . '
        <h1 style="font-size:18px">Bienvenido a Unova</h1>
        <table bgcolor="#ffffff" width="100%" cellpadding="0" cellspacing="0" style="padding:15px 0 15px 0">
                <tbody>
                    <tr valign="top">
                        <td style="font-size:13px;margin: 10px; padding: 10px;">
                            <p style="padding:10px;margin:0">Para poder utilizar esta plataforma de 
                            educaci&oacute;n en l&iacute;nea s&oacute;lo tienes que ingresar al siguiente enlace:</p>
                            <p style="padding:10px;margin:0"><a href="' . $urlReestablecer . '">' . $urlReestablecer . '</a></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        ' . FOOTER;
    $to[] = $email;
    return sendMailSES($text, $html, utf8_encode("Bienvenido a Unova"), EMAIL_FROM, $to);
}

function enviarMailTransformacionVideoCompleta($email, $tituloCurso, $tituloClase, $urlCurso, $idTipoClase) {
    $txtTipo = "";
    switch ($idTipoClase) {
        case 0://video
            $txtTipo = "video";
            break;
        case 4://audio
            $txtTipo = "audio";
            break;
    }

    $text = 'Transformaci&oacute;n de ' . $txtTipo . ' completa,\n\n
        El ' . $txtTipo . ' de tu clase "' . utf8_encode($tituloClase) . '" perteneciente a tu curso "' . utf8_encode($tituloCurso) . '"\n
        ha sido transformado satisfactoriamente.\n
        Ya esta disponible en l&iacute;nea en la p&aacute;gina de tu curso:\n
        ' . $urlCurso . '\n\n
        Gracias, equipo Unova.';
    $html = HEADER . '
        <h1 style="font-size:18px">Transformaci&oacute;n de ' . $txtTipo . ' completa</h1>
        <table bgcolor="#ffffff" width="100%" cellpadding="0" cellspacing="0" style="padding:15px 0 15px 0">
                <tbody>
                    <tr valign="top">
                        <td style="font-size:13px;margin: 10px; padding: 10px;">
                            <p style="padding:10px;margin:0">El ' . $txtTipo . ' de tu clase "' . utf8_encode($tituloClase) . '" perteneciente a tu curso "' . utf8_encode($tituloCurso) . '" ha sido transformado satisfactoriamente.</p>
                            <p style="padding:10px;margin:0">Ya esta disponible en l&iacute;nea en la p&aacute;gina de tu curso:</p>
                            <p style="padding:10px;margin:0"><a href="' . $urlCurso . '">' . $urlCurso . '</a></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        ' . FOOTER;
    $to[] = $email;
    return sendMailSES($text, $html, utf8_encode("Transformación de " . $txtTipo . " completa"), EMAIL_FROM, $to);
}

function enviarMailSuscripcionCurso($email, $tituloCurso, $imagenCurso, $urlCurso) {
    $text = 'Haz quedado inscrito al curso "' . utf8_encode($tituloCurso) . '",\n\n
        Recuerda que es importante comentar y calificar los cursos para mejorar su calidad.\n\n
        Tambi&eacute;n puedes hacer preguntas directamente al profesor.\n\n
        Esto lo puedes hacer en el siguiente enlace:\n\n' . $urlCurso . '\n\n
        Gracias, equipo Unova.';
    $html = HEADER . '
        <h1 style="font-size:18px">Haz quedado inscrito al curso "' . utf8_encode($tituloCurso) . '"</h1>
        <table bgcolor="#ffffff" width="100%" cellpadding="0" cellspacing="0" style="padding:15px 0 15px 0">
                <tbody>
                    <tr valign="top">
                        <td valign="top" style="width:110px;text-align:center">
                            <a href="' . $urlCurso . '" alt="' . $urlCurso . '">
                                <img width="80" height="80" border="0" title="Unova" alt="Unova" src="' . $imagenCurso . '"/>
                            </a>
                        </td>
                        <td style="font-size:13px;margin: 10px; padding: 10px;">
                            <p style="padding:10px;margin:0">Recuerda que es importante comentar y calificar los cursos para mejorar su calidad.</p>
                            <p style="padding:10px;margin:0">Tambi&eacute;n puedes hacer preguntas directamente al profesor.</p>
                            <p style="padding:10px;margin:0">Esto lo puedes hacer en el siguiente enlace:</p>
                            <p style="padding:10px;margin:0"><a href="' . $urlCurso . '">' . $urlCurso . '</a></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        ' . FOOTER;
    $to[] = $email;
    return sendMailSES($text, $html, utf8_encode("Inscripción a curso"), EMAIL_FROM, $to);
}

function enviarMailRespuestaPregunta($email, $tituloCurso, $urlCurso, $pregunta, $respuesta) {
    $text = 'Tu pregunta ha sido respondida: \n\n
        ' . utf8_encode($pregunta) . '\n\n
        Respuesta:\n\n
        ' . utf8_encode($respuesta) . '\n\n\n\n
        Equipo Unova.';
    $html = HEADER . '
        <h1  style="font-size:18px">Tu pregunta en el curso "' . utf8_encode($tituloCurso) . '" ha sido respondida </h1>
        <table bgcolor="#ffffff" width="100%" cellpadding="0" cellspacing="0" style="padding:15px 0 15px 0">
                <tbody>
                    <tr valign="top">
                        <td style="font-size:13px;margin: 10px; padding: 10px;">
                            <p style="font-size:17px; color:darkred;padding:10px;margin:0">' . utf8_encode($pregunta) . '</p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td style="font-size:13px;margin: 10px; padding: 10px;">
                            <p style="padding:10px;margin:0">Respuesta:</p>
                            <p style="font-size:17px; color:darkgreen; padding:10px;margin:0">' . utf8_encode($respuesta) . '</p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td style="font-size:13px;margin: 10px; padding: 10px;">
                            <p style="padding:10px;margin:0">Para ver el curso sigue este enlace:</p>
                            <p style="padding:10px;margin:0"><a href="' . $urlCurso . '">' . $urlCurso . '</a></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        ' . FOOTER;
    $to[] = $email;
    return sendMailSES($text, $html, "Tu pregunta ha sido respondida", EMAIL_FROM, $to);
}

function enviarMailResumenSemanal($email, $nombreUsuario, $numAlumnos, $numPreguntas) {
    $text = $nombreUsuario . ', este es tu resument semanal en Unova: \n\n
        Tienes ' . $numAlumnos . ' nuevos.\n\n
        Te quedan ' . $numPreguntas . ' sin responder.\n\n\n
        Equipo Unova.
        ';
    $html = HEADER . '
        <h1 style="font-size:18px">' . utf8_encode($nombreUsuario) . ', este es tu resumen semanal en Unova</h1>
        <table bgcolor="#ffffff" width="100%" cellpadding="0" cellspacing="0" style="padding:15px 0 15px 0">
            <tbody>                                            
                <tr valign="top" style="text-align: center;">
                    <td style="font-size:18px;margin: 10px; padding: 10px; width: 50%;">
                        <p style=""> 
                            Alumnos nuevos 
                        </p>
                        <span style="padding:5px;margin:0;font-size:24px;color:darkgreen;">' . $numAlumnos . '</span>
                        <p><a href="http://www.unova.co/usuarios/cursos/instructor">Ir a mis cursos</a></p>
                    </td>
                    <td style="font-size:18px;margin: 10px; padding: 10px; width: 50%;">
                        <p style=""> 
                            Preguntas sin responder
                        </p>
                        <span style="padding:5px;margin:0;font-size:24px;color:darkred;">' . $numPreguntas . '</span>
                        <p><a href="http://www.unova.co/usuarios/cursos/responderPreguntas">Responder las preguntas</a></p>
                    </td>
                </tr>
            </tbody>
        </table>
        ' . FOOTER;
    $to[] = $email;
    return sendMailSES($text, $html, "Tu resumen semanal en Unova", EMAIL_FROM, $to);
}

?>