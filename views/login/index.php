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
                <p class="login-box-msg">Inicia sesion para acceder al sistema</p>

                <form action="?c=login&a=login" method="post">
                    <div class="form-group has-feedback">
                        <input autofocus="" type="email" class="form-control" autocomplete="on" name="email" placeholder="Correo electronico" required="">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Contraseña" name="password" required="" minlength="3">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <label>
                                <input type="checkbox" value="1" name="remember"> Recordarme
                            </label>
                        </div>
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat" style="margin: 15px 0;">Iniciar sesión</button>
                        </div>
                    </div>
                </form>
                <a href="?c=registro&a=recuperar">Olvide mi contraseña</a><br>
                <a href="?c=registro" class="text-center">Registrar nueva cuenta</a>
            </div>
        </div>
        <?php importView('_static/scripts'); ?>
    </body>
</html>