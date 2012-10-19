</head>

<body>
    <script>
        var layout = "<?php echo getTipoLayout(); ?>";
    </script>
    <div id="e_bar">
        <div id="top-bar">
            <a href="/" class="logo left" id="logo"> <img src="/layout/imagenes/Unova_Logo_135x47.png"></a>
            <div style="margin-left: 20px;">
                <div  class="element left ease3" style="width:190px;">
                    <?php
                    if (getTipoLayout() == "desktop") {
                        ?>
                        <a class="link" > 
                            <div id="menuClasesLink">
                                <span class="left">
                                    Clases de este curso 
                                </span>
                                <div id="flechaClases" class="flechaAbajo left"></div>
                            </div>
                        </a>
                        <div id="flechitaClases"></div>
                        <div id="clases_menu">                            
                            <?php
                            if (isset($temas) && isset($clases)) {
                                foreach ($temas as $tema) {
                                    echo '<div class="clasesMenuHeader">';
                                    echo $tema->nombre;
                                    echo '</div>';
                                    foreach ($clases as $claseF) {
                                        if ($tema->idTema == $claseF->idTema) {

                                            echo '<a href="/curso/' . $curso->uniqueUrl . '/' . $claseF->idClase . '">';
                                            if ($claseF->idClase == $clase->idClase)
                                                echo '<div class="clasesMenuElement clasesMenuElementActual">';
                                            else
                                                echo '<div class="clasesMenuElement">';

                                            switch ($claseF->idTipoClase) {
                                                case 0:
                                                    echo '<img src="/layout/imagenes/video.png">';
                                                    break;
                                                case 1:
                                                    echo '<img src="/layout/imagenes/document.png">';
                                                    break;
                                                case 2:
                                                    echo '<img src="/layout/imagenes/presentation.png">';
                                                    break;
                                                default:
                                                    echo '<img src="/layout/imagenes/document.png">';
                                                    break;
                                            }
                                            echo '<span class="left">' . $claseF->titulo . '</span>';
                                            if ($claseF->idTipoClase == 0) {
                                                echo '<br><span class="left">' . $claseF->duracion . '</span>';
                                            }

                                            echo ' </div>';
                                            echo '</a>';
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                        <?php
                    } else {
                        //si no es desktop no mostramos la lista de cursos
                        ?>
                        <a class="link" href="/curso/<?php echo $curso->uniqueUrl; ?>"> 
                            <div id="menuClasesLink">
                                <span class="left">
                                    Clases de este curso 
                                </span>
                            </div>
                        </a>
                        <?php
                    }
                    ?>
                </div>
                <div  class="element left ease3">
                    <?php
                    if ($idSiguienteClase > 0) {
                        ?>
                        <a href="/curso/<?php echo $curso->uniqueUrl . "/" . $idSiguienteClase; ?>" class="link" id="menuSiguienteClase" > 
                            Siguiente Clase 
                            <img src="/layout/imagenes/siguiente.png">
                        </a>
                        <?php
                    }
                    ?>
                </div>
            </div>
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