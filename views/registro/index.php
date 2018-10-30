<!DOCTYPE html>
<html>
    <head>
        <?php importView('_static.head'); ?>
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <?php echo(APP_NAME); ?>
            </div>
            <div class="login-box-body">
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
                <p class="login-box-msg">Registro de nuevo usuario</p>

                <form action="?c=registro&a=store" method="post">
                    <div class="form-group has-feedback">
                        <input autofocus="" type="email" class="form-control" autocomplete="on" name="email" placeholder="Correo electronico" required="">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <hr>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Contraseña" id="password" name="password" required="" minlength="5">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input  type="password" minlength="3" class="form-control" id="confirm_password" placeholder="Confirmar contraseña" value="" required="" oninput="checkPasswords(this)">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <hr>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Nombre" name="nombre" required="">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Apellido" name="apellido" required="">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="telefono" id="phone" placeholder="Telefono" required="" min="7">
                        <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
                    </div>
                    <hr>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Empresa" name="empresa" required="">
                        <span class="form-control-feedback"><i class="fa fa-building"></i></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Sucursal" name="sucursal" required="">
                        <span class="form-control-feedback"><i class="fa fa-building"></i></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-danger btn-block btn-flat" style="margin: 15px 0;">Registrar</button>
                        </div>
                    </div>
                </form>
                <a href="?c=registro&a=recuperar">Olvide mi contraseña</a><br>
                <a href="index.php" class="text-center">Iniciar Sesion</a>
            </div>
        </div>
        <?php importView('_static/scripts'); ?>
    </body>
</html>