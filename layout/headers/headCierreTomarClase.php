</head>
<body style="z-index: -100;min-height: 0%;">
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <button type="button" class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="brand" href="/" style="padding: 0px; padding-right: 40px;"><img src="/layout/imagenes/Unova_Logo_135x47.png"></a>
                <?php
                $usuarioHead = getUsuarioActual();
                if (isset($usuarioHead)) {
                    ?>
                    <div class="nav-collapse collapse">
                        <ul class="nav ">
                            <li class="dropdown ">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    Menú del curso
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="/curso/<?php echo $curso->uniqueUrl; ?>"><i class="icon-arrow-up"></i> Regresar al curso</a></li>
                                    <li class="divider"></li>
                                    <?php
                                    if ($clases['anterior'] >= 0)
                                        echo '<li><a href="/curso/' . $curso->uniqueUrl . '/' . $clases['anterior'] . '"><i class="icon-fast-backward "></i> Clase anterior</a></li>';
                                    if ($clases['siguiente'] >= 0) {
                                        echo '<li><a href="/curso/' . $curso->uniqueUrl . '/' . $clases['siguiente'] . '"><i class="icon-fast-forward"></i> Siguiente clase</a></li>';
                                    } else {
                                        echo '<li><p style="padding:5px;">Ya no hay más clases.</p></li>';
                                    }
                                    ?>                                                             
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav pull-right">                            
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Mis Cursos
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="/usuarios/cursos/inscrito">Cursos a los que estoy inscrito</a></li>
                                    <li><a href="/usuarios/cursos/instructor">Cursos que imparto</a></li>
                                </ul>                                
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php
                                    echo $usuarioHead->nombreUsuario;
                                    ?> <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="/usuario/<?php echo $usuarioHead->uniqueUrl; ?>">Mi perfil</a></li>
                                    <li class="divider"></li>                                
                                    <li><a href="/login/login/logout">Cerrar sesión</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>    