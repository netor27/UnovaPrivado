<!DOCTYPE html>
<html lang="es" xml:lang="es">
    <head>
        <meta name="google" value="notranslate">
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?php
            if (isset($tituloPagina))
                echo $tituloPagina . " en Unova";
            else
                echo "Unova";
            ?>
        </title>
        <link REL="SHORTCUT ICON" HREF="/layout/faviconUnova.ico">        
        <link rel="stylesheet" href="/layout/css/MainStyle.css" />
        <link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/lib/bootstrap/css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="/layout/css/cus-icons.css" />
        <script>
            var layout = "<?php echo getTipoLayout(); ?>";
        </script>
        <script src="/lib/js/jquery-1.9.1.min.js"></script>	        
        <script src="/lib/js/jquery-migrate-1.1.1.js"></script>	        
        <script src="/lib/bootstrap/js/bootstrap.min.js"></script>
        <script src="/lib/js/bootbox.min.js"></script>
        <script src="/js/funciones.js"></script>	