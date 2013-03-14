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

?>