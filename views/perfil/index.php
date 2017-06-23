<!DOCTYPE html>
<html>
    <head>
        <?php importView('_static.head'); ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php importView('_static/header'); ?>
            <?php importView('_static/sidebar'); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>Perfil de usuario</h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="box box-primary">
                                <div class="box-body box-profile">
                                    <img class="profile-user-img img-responsive img-circle" src="storage/avatares/<?php echo session::get('imagen'); ?>" alt="User profile picture">

                                    <h3 class="profile-username text-center"><?php echo ucfirst(session::get('nombre')) . ' ' . ucfirst(session::get('apellido')); ?></h3>

                                    <p class="text-muted text-center"><?php echo ucfirst(session::get('empresa')); ?></p>

                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b>Empresa</b> <a class="pull-right"><?php echo ucwords(session::get('empresa')); ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Planta</b> <a class="pull-right"><?php echo ucwords(session::get('planta')); ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>RFC</b> <a class="pull-right"><?php echo ucfirst(session::get('rfc')); ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Direccion</b> <a class="pull-right"><?php echo ucwords(session::get('direccion')); ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Codigo Postal</b> <a class="pull-right"><?php echo ucfirst(session::get('cp')); ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Ciudad</b> <a class="pull-right"><?php echo ucfirst(session::get('ciudad')); ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Estado</b> <a class="pull-right"><?php echo ucfirst(session::get('estado')); ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Puesto</b> <a class="pull-right"><?php echo ucwords(session::get('puesto')); ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Tipo de usuario</b> <a class="pull-right"><?php echo ucfirst(session::get('rol')); ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Telefono</b> <a class="pull-right"><?php echo (session::get('telefono')); ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Correo electronico</b> <a class="pull-right"><?php echo (session::get('email')); ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Id de usuario</b> <a class="pull-right">#<?php echo (session::get('id')); ?></a>
                                        </li>
                                    </ul>

                                    <a href="?c=perfil&a=password" class="btn btn-primary btn-block btn-flat hidden-print">Restablecer contraseña</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 hidden-print">
                        <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-black" style="background: url('assets/images/3.jpg') center center;">
              <h3 class="widget-user-username"><?php echo session::get('nombre') . ' ' . session::get('apellido'); ?></h3>
              <h5 class="widget-user-desc"><?php echo session::get('empresa'); ?></h5>
            </div>
            <div class="widget-user-image">
              <img class="img-circle" style="height: 90px;" src="storage/avatares/<?php echo session::get('imagen'); ?>" alt="User Avatar">
            </div>
            <div class="box-footer">
              
              <!-- /.row -->
            </div>
          </div>    
                            <div class="box box-primary">
                                <div class="box-header  with-border">
                                    <h3 class="box-title">Editar perfil de usuario</h3>
                                </div>
                                <div class="box-body">
                                    <?php if ($error = Flash::hasError()) { ?>
                                        <div class="alert alert-warning alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <h4><i class="icon fa fa-warning"></i> <?php echo $error['title']; ?> #<?php echo $error['id']; ?> </h4>
                                            <ul><?php
                                                foreach ($error['data'] as $err) {
                                                    echo '<li>' . $err['msg'] . '</li>';
                                                }
                                                ?></ul>
                                        </div>
                                    <?php } ?>
                                    <form method="POST" autocomplete="off"  action="?c=perfil&a=update" role="form">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="nombre">Nombre</label>
                                                <input  type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo ucfirst($data['usuario'][0]['nombre']); ?>" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="apellido">Apellido</label>
                                                <input  type="text" class="form-control" name="apellido" id="apellido" placeholder="Apellido" value="<?php echo ucfirst($data['usuario'][0]['apellido']); ?>" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="puesto">Puesto</label>
                                                <input  type="text" class="form-control" name="puesto" id="puesto" placeholder="Puesto" value="<?php echo ucwords($data['usuario'][0]['puesto']); ?>" >
                                            </div>
                                            <div class="form-group">
                                                <label for="telefono">Telefono</label>
                                                <input  type="tel" minlength="5" class="form-control" name="telefono" id="telefono" placeholder="Telefono" value="<?php echo $data['usuario'][0]['telefono']; ?>">
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                        <?php
                                            if(Session::has('rol',['Administrador'])){
                                                echo '<button type="submit" class="btn btn-primary btn-flat">Guardar cambios</button>';
                                            }
                                        ?>
                                            <button type="button" class="btn btn-default btn-flat" onclick="window.print();">Imprimir perfil</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 hidden-print">
                            <div class="box box-primary" style="overflow:hidden;">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Imagen de perfil</h3>
                                </div>
                                <div class="box-body" >
                                    <img id="img_avatar" alt="Avatar" src="storage/avatares/<?php echo session::get('imagen'); ?>" style="width: 100%;" class="img-responsive"></div>
                                <form method="POST" autocomplete="off"  action="?c=perfil&a=update_avatar" role="form"  enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class="btn btn-default btn-file btn-flat col-sm-10" style="width: 100%;">Seleccionar imagen
                                                <input type="file" required="" name="avatar" id="avatar" style="display: none;">
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <a href="#" class="btn btn-default btn-flat btn-xs" style="width: 100%; margin-top: 7px;" data-toggle="modal" data-target="#myModal">Eliminar Imagen</a>
                                        </div>
                                    </div>
                                    <div class="box-footer"><button type="submit" style="width: 100%;" class="btn btn-primary btn-flat">Actualizar imagen de perfil</button></div>
                                </form>
                            </div>
                        </div>

                    </div>
        </section>
    </div>
    <?php importView('_static/footer'); ?>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Eliminar imagen de perfil</h4>
      </div>
      <div class="modal-body">
        Esta seguro que desea eliminar su imagen de perfil
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Salir</button>
        <a href="?c=perfil&a=reset_avatar" class="btn btn-danger btn-flat">Eliminar</a>
      </div>
    </div>
  </div>
</div>

<?php importView('_static/scripts'); ?>
</body>
</html>