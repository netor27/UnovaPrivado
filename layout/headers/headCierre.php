</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">                
                <a class="brand" href="/" style="padding: 0px;"><img src="/layout/imagenes/Unova_Logo_135x47.png"></a>
                <?php
                $usuarioHead = getUsuarioActual();
                if (isset($usuarioHead)) {
                    ?>
                    <button type="button" class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-right">
                            <li>
                                <a href="/">Inicio</a> 
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Mis Cursos
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php
                                    if (tipoUsuario() != "usuario") {
                                        ?>
                                        <li><a href="/usuarios/cursos/instructor">Cursos que imparto</a></li>
                                        <?php
                                    }
                                    ?>
                                    <li><a href="/usuarios/cursos/inscrito">Cursos a los que estoy inscrito</a></li>
                                </ul>                                
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php
                                    echo substr($usuarioHead->nombreUsuario, 0, 30);
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

    <?php
    $sessionMessage = getSessionMessage();
    if (!is_null($sessionMessage)) {
        ?>
        <div class="container">
            <div id="sessionMessage" class="centerText" >
                <?php echo $sessionMessage; ?>
            </div>
        </div>

        <?php
    }
    ?>
    <div class="container" style="padding-bottom: 175px;">