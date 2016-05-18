<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">IEvent</a>
    </div>
    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-messages">
                <li><a href="perfil.php"><i class="fa fa-user fa-fw"></i>Perfil</a></li>
                <li class="divider"></li>
                <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i>Logout</a></li>
            </ul>
        </li>
    </ul>
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">      
                <li>
                    <a href="#"><i class="fa  fa-envelope fa-fw"></i> Eventos<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="miseventos.php">Mis eventos</a></li>
                        <li><a href="proximoseventos.php">Proximos eventos</a></li>
                        <li><a href="crearevento.php">Crear evento</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-comments  fa-fw"></i> Grupos<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="misgrupos.php">Mis grupos</a></li>
                        <li><a href="creargrupo.php">Crear grupo</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-users fa-fw"></i> Contactos<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="miscontactos.php">Mis contactos</a></li>
                        <li><a href="addcontacto.php">Añadir contacto</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-user fa-fw"></i> Usuario<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                       
                        <li><a href="perfil.php">Ver perfil</a></li>
                        <li><a href="dropuser.php">Eliminar cuenta</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>