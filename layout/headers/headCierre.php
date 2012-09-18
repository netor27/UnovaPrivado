</head>

<body>
    <script>
        var layout = "<?php echo getTipoLayout(); ?>";
    </script>
    <div id="e_bar">
        <div id="top-bar">
            <a href="/" class="logo left" id="logo"> <img src="/layout/imagenes/Unova_Logo_135x47.png"></a>
                      
            <?php
            $usuarioHead = getUsuarioActual();
            if (isset($usuarioHead)) {
                ?>
                <div class="element right ease3">
                    <a  class="link" >
                        <div id="menuPerfilLink">
                            <span class="left">
                                <?php echo substr($usuarioHead->nombreUsuario, 0, 14); ?>
                            </span>
                            <div id="flechaPerfil" class="flechaAbajo left"></div>
                        </div>
                    </a>
                    <div id="perfil_menu"> 
                        <div id="flechitaPerfil"></div>
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
                </div>
                <div class="element right ease3">
                    <a  class="link" >
                        <div id="menuCursosLink">
                            <span class="left">Mis cursos</span>  
                            <div id="flechaCursos" class="flechaAbajo left"></div>
                        </div>
                    </a>         
                    <div id="cursos_menu">
                        <div id="flechitaCursos"></div>
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
            if (tipoUsuario() == 'administradorPrivado') {
                ?>
                <div class="element right ease3">
                    <a class="link" href="/cursos/curso/crearCurso" >Crear un curso</a>
                </div>
                <?php
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