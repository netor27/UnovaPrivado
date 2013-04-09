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
        <script src="/lib/js/jquery-1.9.1.min.js"></script>	        
        <script src="/lib/js/jquery-migrate-1.1.1.js"></script>	        
        <script src="/lib/bootstrap/js/bootstrap.min.js"></script>
        <script src="/lib/js/modernizr/modernizr-latest.js"></script>
        <script src="/lib/js/bootbox.min.js"></script>
        <script src="/js/funciones.js"></script>	
        <script>
            $( document ).ready(function() {
                if (Modernizr.localstorage) {
                    var valor = localStorage["unova.votacion.1"];
                    if(valor == null){
                        localStorage["unova.votacion.1"] = 1;
                        $("#mensajes").append("Se guardo el valor");
                    }else{
                        $("#mensajes").append("Valor = " + valor);
                    }
                } else {
                    $("#mensajes").append("No Localstorage");
                }
            });
        </script>
    </head>
    <body>
        <div id="mensajes">
        </div>
    </body>
</html>