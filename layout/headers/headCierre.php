</head>
<body>
    <script>
        var layout = "<?php echo getTipoLayout(); ?>";
    </script>
    <div id="e_bar">
        <div class="container" id="top-bar">
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
        <?php
        $sessionMessage = getSessionMessage();
        if (!is_null($sessionMessage)) {
            ?>
            <div id="sessionMessage" class="centerText" >
                <?php echo $sessionMessage; ?>
            </div>
            <?php
        }
        ?>
        <div class="container">
            <div class="row-fluid"><h1></h1></div>
