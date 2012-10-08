</head>

<body>
    <script>
        var layout = "<?php echo getTipoLayout(); ?>";
    </script>
    <div id="e_bar">
        <div id="top-bar">
            <a href="/" class="logo left" id="logo"> <img src="/layout/imagenes/Unova_Logo_135x47.png"></a>
            <?php
            switch (tipoUsuario()) {
                case 'usuario':
                    require_once 'modulos/principal/vistas/topBarUsuario.php';
                    break;
                case 'administradorPrivado':
                    require_once 'modulos/principal/vistas/topBarAdministradorPrivado.php';
                    break;
                case 'profesor':
                    require_once 'modulos/principal/vistas/topBarProfesor.php';
                    break;
                case 'administrador':
                    require_once 'modulos/principal/vistas/topBarUsuario.php';
                    break;
            }
            ?>
        </div>
    </div>
    <div id="e_site">    
        <div id="modalDialog"></div>
        <?php
        $sessionMessage = getSessionMessage();
        if (!is_null($sessionMessage)) {
            echo '<div id="sessionMessage" class="centerText" >';
            echo $sessionMessage;
            echo '</div>';
        }
        ?>