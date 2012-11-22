<!DOCTYPE html>
<html lang="es" xml:lang="es">
    <head>
        <meta name="google" value="notranslate">
        <meta charset="utf-8" />
        <title>
            <?php
            if (isset($tituloPagina))
                echo $tituloPagina . " en Unova";
            else
                echo "Unova";
            ?>
        </title>
        <link REL="SHORTCUT ICON" HREF="/layout/faviconUnova.ico">
        
        <link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
<!--        <link rel="stylesheet" href="/lib/bootstrap/css/bootstrap-responsive.min.css">-->
        <link rel="stylesheet" href="/layout/css/noticeBoxes.css" />
        <link rel="stylesheet" href="/layout/css/MainStyle.css" />        
        
        <script src="/lib/js/jquery-1.8.2.min.js"></script>	
        
        <script src="/lib/bootstrap/js/bootstrap.min.js"></script>
        <script src="/lib/bootstrap/js/bootbox.min.js"></script>
        <script src="/js/funciones.js"></script>	
        <script src="/js/DocumentReady.js"></script>