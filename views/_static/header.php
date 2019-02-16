<header class="main-header">
    <a href="index.php" class="logo">
        <span class="logo-mini"><?php echo APP_TITLE_SIDEBAR_SMALL; ?></span>
        <span class="logo-lg"><?php echo APP_TITLE_SIDEBAR; ?></span>
    </a>
    <nav class="navbar navbar-static-top " role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">            

            <?php if(Session::has('rol',['Técnicos'])){ ?>
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o"></i>
                        <span class="label label-danger" id="notification_number"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header" id="notification_header">No hay equipos a calibrar asignados</li>
                        <li>
                            <ul class="menu" id="notification_menu">
                            
                            </ul>
                        </li>
                        <li class="footer"><a href="?c=informes&a=calibrar">Ver equipos a calibrar</a></li>
                    </ul>
                </li>
            <?php } ?>
   
            <!-- \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\  -->
            <!--                                                   -->
            <!--          Notificaciones para administradores      -->            
            <!--  Nueva cuenta solicitando acceso a mypsa online   -->
            <!--                                                   -->
            <!-- \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ -->

            <?php if(Session::has('rol',['Administrador','Ingenieros'])){ ?>
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-users text-white"></i>
                      <span class="label label-warning" id="notification_number_2"></span>
                    </a>
                    <ul class="dropdown-menu">
                      <li class="header" id="notification_header_2">No hay usuarios pendientes</li>
                      <li>                        
                        <ul class="menu" id="notification_menu_2">
                           
                        </ul>
                      </li>
                      <li class="footer"><a href="?c=usuarios&a=alta">Ver lista completa</a></li>
                    </ul>
                </li>
            <?php } ?>   
            <!-- \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\  -->
            <!--                                                   -->
            <!--             Notificaciones para PO                -->            
            <!--                                                   -->
            <!-- \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ -->               

            <!-- \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\  -->
            <!--                                                   -->
            <!--                  Menu de perfil                   -->           
            <!--                                                   -->
            <!-- \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="storage/avatares/<?php echo session::get('imagen'); ?>" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?php echo ucfirst(session::get('nombre')) . ' ' . ucfirst(session::get('apellido')); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">

                            <img src="storage/avatares/<?php echo session::get('imagen'); ?>" class="img-circle" alt="User Image">
                            <p><?php echo ucfirst(session::get('nombre')) . ' ' . ucfirst(session::get('apellido')); ?><small><?php echo ucwords(session::get('empresa')); ?></small></p>
                        </li>
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <?php echo ucwords(session::get('puesto')); ?>
                                </div>
                            </div>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="?c=perfil" title="Acceder al perfil de usuario" class="btn btn-default btn-flat">Perfil</a>
                            </div>
                            <div class="pull-left">
                                <a href="?c=usuarios&a=refresh" title="Actualizar" class="btn btn-default btn-flat"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                            </div>

                            <div class="pull-right">
                                <a href="?c=login&a=logout" title="Salir del sistema" class="btn btn-default btn-flat">Cerrar Sesión</a>
                            </div>
                            <div class="pull-right">
                                <a href="?c=login&a=lock" title="Bloquear sistema" class="btn btn-default btn-flat"><i class="fa fa-lock" aria-hidden="true"></i></a>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</header>