</head>

<body>

    <div id="e_bar">
        <div id="top-bar">
            <a href="/" class="logo left" id="logo"> <img src="/layout/imagenes/Unova_Logo_135x47.png"></a>
                     
            <?php
            require_once 'funcionesPHP/funcionesGenerales.php';
            require_once 'modulos/usuarios/clases/Usuario.php';

            if (tipoUsuario() == 'visitante') {
                ?>
                
                <?php
            } else {
                $usuarioHead = getUsuarioActual();
                if (isset($usuarioHead)) {
                    ?>
                    <a href="#" class="element right ease3" id="menuPerfilLink"><?php echo substr($usuarioHead->nombreUsuario, 0, 14); ?><img src="/layout/imagenes/down.png"></a>                
                    <a href="#" class="element right ease3" id="menuCursosLink">Mis cursos  <img src="/layout/imagenes/down.png"></a>                
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <?php
    $tipoU = tipoUsuario();
    if ($tipoU != 'visitante') {
        ?>
        <div class="dropdownContainer">
            <div id="perfil_menu">   
                <a href="/usuario/<?php echo $usuarioHead->uniqueUrl; ?>">
                    <div id="perfil_image">
                        <img src="<?php echo $usuarioHead->avatar; ?>">
                        <span><?php echo substr($usuarioHead->nombreUsuario, 0, 14); ?></span>
                        <br><br>
                        <span style="font-size: smaller">Editar perfil</span>
                    </div>
                </a>
                <div id="perfil_links">
                    <a href="/login/login/logout"><span>Cerrar Sesión</span></a><br>
                </div>

            </div>
            <div id="cursos_menu">
                <?php
                if($tipoU != 'usuario'){
                ?>
                <div class="cursosMenuHeader">
                    Cursos de los que soy instructor
                </div>                
                <?php
                if (isset($_SESSION['cursosPropios'])) {
                    $cursosSession = $_SESSION['cursosPropios'];
                    foreach ($cursosSession as $cursoSess) {
                        ?>
                        <a href="/curso/<?php echo $cursoSess->uniqueUrl; ?>">
                            <div class="cursoMenuElement">
                                <img src="<?php echo $cursoSess->imagen; ?>"/><?php echo $cursoSess->titulo; ?>
                                <div class=""><h6>Editar</h6></div>
                            </div>
                        </a>
                        <?php
                    }
                } else {
                    ?>                
                    <div class="cursoMenuElement">
                        <h3>No has creado ningún curso</h3>
                    </div>
                <?php } ?>
                <a href="/usuarios/cursos/instructor">
                    <div class="cusosMenuVerMas">
                        Ver todos >>
                    </div>
                </a>
                <?php } ?>
                <div class="cursosMenuHeader">
                    Cursos que estoy tomando
                </div>                
                <?php
                if (isset($_SESSION['cursos'])) {
                    $cursosSession = $_SESSION['cursos'];
                    foreach ($cursosSession as $cursoSess) {
                        ?>
                        <a href="/curso/<?php echo $cursoSess->uniqueUrl; ?>">
                            <div class="cursoMenuElement">
                                <img src="<?php echo $cursoSess->imagen; ?>"/><?php echo $cursoSess->titulo; ?>
                            </div>
                        </a>
                        <?php
                    }
                } else {
                    ?>                
                    <div class="cursoMenuElement">
                        <h3>No te has inscrito a ningún curso</h3>
                    </div>
                <?php } ?>
                <a href="/usuarios/cursos/inscrito">
                    <div class="cusosMenuVerMas">
                        Ver todos >>
                    </div>
                </a>
            </div>
        </div>

        <?php
    }
    ?>
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