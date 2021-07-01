
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

    <div class="navbar-header">
        <a class="navbar-brand" href="<?php echo $this->webApp()->getSite();?>">
            <?php echo $this->webApp()->getConfig('TITULO');?>
        </a>
    </div>

    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>

    <!-- Top Navigation: Right Menu -->
    <ul class="nav navbar-right navbar-top-links">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <?php echo $this->webApp()->getUsuario();?> <b class="caret"></b>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="usuario/miperfil"><i class="fa fa-user fa-fw"></i> Mi perfil</a></li>
                <li class="divider"></li>
                <li><a href="site/logout"><i class="fa fa-sign-out fa-fw"></i> Cerrar sesión</a></li>
            </ul>
        </li>
    </ul>

    <!-- Sidebar -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">

            <ul class="nav" id="side-menu">

                <li>
                    <a href="visualizador"><i class="fa fa-users fa-map"></i> <span>Visualizador</span></a>
                </li>

                <li>
                    <a href="registros"><i class="fa fa-users fa-archive"></i> <span>Registros</span></a>
                </li>

                <li>
                    <a href="usuario"><i class="fa fa-users fa-fw"></i> <span>Usuarios</span></a>
                </li>

                <li>
                    <a href="#" id="contract"></a>
                </li>

            </ul>

            <div class="theme-selector">
                <div class="btn-group">
                    <a href="usuario/theme?id=<?php echo oxusmedia\webApp\webApp::THEME_LIGHT;?>" id="theme-light" class="btn btn-xs light<?php echo $this->webApp()->getTheme() == oxusmedia\webApp\webApp::THEME_LIGHT ? ' active' : '';?>" title="Cambiar a tema Claro"><i class="fa fa-sun-o"></i></a>
                    <a href="usuario/theme?id=<?php echo oxusmedia\webApp\webApp::THEME_DARKLY;?>" id="theme-dark" class="btn btn-xs dark<?php echo $this->webApp()->getTheme() == oxusmedia\webApp\webApp::THEME_DARKLY ? ' active' : '';?>" title="Cambiar a tema Oscuro"><i class="fa fa-moon-o"></i></a>
                </div>
            </div>

        </div>
    </div>

</nav>
