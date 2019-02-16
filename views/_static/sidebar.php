<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <a href="storage/avatares/<?php echo session::get('imagen');  ?>" data-lightbox="perfil">
                    <img  id="avatar" src="storage/avatares/<?php echo session::get('imagen'); ?>" class="img-circle" alt="User Image">
                </a>
            </div>
            <div class="pull-left info">
                <p><?php echo ucfirst(session::get('nombre')) . ' ' .ucfirst(session::get('apellido')) ; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> En línea</a>
            </div>
        </div>
        <!-- <div class="sidebar-form">                             -->
            <!-- <div class="input-group"> -->
                <!-- <input type="text" id="search" class="form-control" placeholder="Buscar..." required="" min="3"> -->                
                <!-- <span class="input-group-btn">
                    <a href="#" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></a>
                </span> -->
            <!-- </div> -->
        <!-- </div> -->
        <ul class="sidebar-menu">
            <li class="header">MENÚ DE NAVEGACIÓN</li>
            <li class="active treeview">
                <a href='?c=reportes&a=pulso'>
                   <i class="fa fa-dashboard"></i> <span>Pulso MyPSA</span>                    
                </a>                
            </li>
            <li class='treeview'>
                <?php
                    if(Session::has('rol',['Administrador','Ingenieros','Almacén','Técnicos','Calidad'])){ 
                echo "
                <a href='#'>
                    <i class='fa fa-table'></i> <span>Bitacora</span><span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>
                </a>";
                }?>
                <ul class='treeview-menu'>
                 <?php
                    if(Session::has('rol',['Administrador','Ingenieros','Almacén','Técnicos','Calidad'])){
                        if(Session::has('rol',['Técnicos','Ingenieros'])){
                            echo "         
                                <li><a href='?c=informes'><i class='fa fa-circle-o'></i>Bitacora completa</a></li>                 
                                <li><a href='?c=recepcion'><i class='fa fa-circle-o'></i>Registrar equipo</a></li>
                                <li><a href='?c=informes&a=proceso'><i class='fa fa-circle-o'></i>Equipos en proceso</a></li>
                                <li><a href='?c=informes&a=calibrar'><i class='fa fa-circle-o'></i>Equipos a calibrar</a></li>
                           ";
                        }                        
                        if(Session::has('rol',['Administrador'])){
                            echo " <li><a href='?c=login&a=sucursal'><i class='fa fa-circle-o'></i>Sucursal</a></li> ";
                        } 
                        if(Session::has('rol',['Administrador','Almacén','Calidad'])){
                            echo "         
                                <li><a href='?c=informes'><i class='fa fa-circle-o'></i>Bitacora completa</a></li>                 
                                <li><a href='?c=recepcion'><i class='fa fa-circle-o'></i>Registrar equipo</a></li>
                                <li><a href='?c=informes&a=proceso'><i class='fa fa-circle-o'></i>Equipos en proceso</a></li>
                                <li><a href='?c=informes&a=calibrar'><i class='fa fa-circle-o'></i>Equipos a calibrar</a></li>
                           ";
                        }                                        
                    }
                ?>             
                </ul>
            </li>
            <?php
                if(Session::has('rol',['Administrador','Ingenieros','Almacén','Servicios','Calidad'])){
                        echo "<li class='treeview'>
                        <a href='#''>
                            <i class='fa fa-files-o'></i> <span>Informes</span><span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>
                        </a>";
                        echo "<ul class='treeview-menu'>";
                        if(Session::get('plantas_id')=='126'){
                            echo '<li><a href="?c=clienteinformes&a=continental"><i class="fa fa-circle-o"></i>Historial informes</a></li>';
                        }   
                        else{echo '<li><a href="?c=clienteinformes"><i class="fa fa-circle-o"></i>Historial informes</a></li>';} 
                        if(Session::get('plantas_id')=='758' && Session::has('rol',['Administrador'])){
                        echo '<li><a href="?c=clienteinformes&a=continental"><i class="fa fa-circle-o"></i>Historial informes conti</a></li>'; 
                        }
                         echo '<li><a href="?c=clienteinformes&a=recalibrar"><i class="fa fa-circle-o"></i>Equipos a vencer</a></li>';
                          echo '<li><a href="?c=clienteinformes&a=vencidos"><i class="fa fa-circle-o"></i>Equipos vencidos</a></li>';
                           //echo '<li><a href="#"><i class="fa fa-circle-o"></i>Cartas de trazabilidad</a></li>';
                           echo '</ul> </li>';
                    }
                ?>              
             <!-- Módulos de reportes  --> 
             <?php
                if(Session::has('rol',['Administrador','Ingenieros','Calidad']) || Session::has('email',['drodriguez@mypsa.com.mx'])){             
                    echo "<li class='treeview'>
                        <a href='#'>
                            <i class='fa fa-pie-chart'></i> <span>Reportes</span><span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>
                        </a>
                        <ul class='treeview-menu'>                
                            <li><a href='?c=reportes'><i class='fa fa-circle-o'></i>Técnicos</a></li>               
                            <li><a href='?c=reportes&a=cliente'><i class='fa fa-circle-o'></i>
                            Clientes</a></li>
                            <li><a href='?c=reportes&a=productividad'><i class='fa fa-circle-o'></i>
                            Productividad</a></li>                  
                        </ul>
                        </li>";
                }
            ?>
            <!-- Módulos de administración  -->
            <?php
                if(Session::has('rol',['Administrador','Ingenieros','Almacén','Técnicos','Calidad'])){          
                    echo "<li class='header'>ADMINISTRACIÓN</li>";
                     //adminsitración de equipos
                    echo "<li class='treeview'>
                        <a href='#'>
                            <i class='fa fa-wrench'></i> <span>Administración de equipos</span><span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>
                        </a>
                        <ul class='treeview-menu'>
                            <li><a href='?c=equipos'><i class='fa fa-database'></i> Equipos</a></li>
                            <li><a href='?c=equipos_descripciones'><i class='fa fa-font'></i> Descripcion de equipos</a></li>
                            <li><a href='?c=equipos_marcas'><i class='fa fa-tags'></i>Marcas de equipos</a></li>
                            <li><a href='?c=equipos_modelos'><i class='fa fa-list'></i>Modelos de equipos</a></li>
                        </ul>
                    </li>";
                    //adminsitración de clientes
                    echo "<li class='treeview'>
                        <a href='#'>
                            <i class='fa fa-address-card' aria-hidden='true'></i> <span>Administración de clientes</span><span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>
                        </a>
                        <ul class='treeview-menu'>
                            <li><a href='?c=empresas'><i class='fa fa-building'></i>Empresas</a></li>
                            <li><a href='?c=plantas'><i class='fa fa-industry'></i>Planta/Sucursal</a></li>
                        </ul>
                    </li>";
                    //adminsitración de modulos
                    echo "<li class='treeview'>
                        <a href='#'>
                            <i class='fa fa-th'></i> <span>Módulos</span><span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>
                        </a>
                        <ul class='treeview-menu'>
                            <li><a href='?c=paises'><i class='fa fa-globe'></i>Paises</a></li>
                            <li><a href='?c=estados'><i class='fa fa-globe'></i>Estados</a></li>
                            <li><a href='?c=ciudades'><i class='fa fa-globe'></i>Ciudades</a></li>
                            <li><a href='?c=calibraciones'><i class='fa fa-cog'></i>Tipo de calibración</a></li>
                            <li><a href='?c=sucursales'><i class='fa fa-suitcase'></i>Sucursales</a></li>
                            <li><a href='?c=acreditaciones'><i class='fa fa-certificate'></i>Acreditaciones</a></li>
                        </ul>
                    </li>";                            
                    //adminsitración de usuarios
                    if(Session::has('rol',['Administrador','Ingenieros','Calidad'])){
                        echo "<li class='treeview'>
                            <a href='#'>
                                <i class='fa fa-user'></i> <span>Cuentas de usuarios</span><span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>
                            </a>
                            <ul class='treeview-menu'>
                                <li><a href='?c=usuarios'><i class='fa fa-users'></i>Usuarios</a></li>
                                <li><a href='?c=roles'><i class='fa fa-cogs'></i>Roles de usuarios</a></li>
                                <li><a href='?c=usuarios&a=alta'><i class='fa fa-users'></i>Alta de Usuarios</a></li>
                            </ul>
                        </li>";
                    }           
                    //adminsitración del LOG                    
                    if(Session::has('rol',['Administrador'])){
                        echo  "<li class='treeview'>
                            <a href='#'>
                                <i class='fa fa-cog'></i> <span>Administración</span><span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>
                            </a>
                            <ul class='treeview-menu'>
                                <li><a href='?c=logs'><i class='fa fa-cog'></i>Logs</a></li>
                            </ul>
                        </li>";
                    }
                }
            ?>
        </ul>
    </section>
</aside>