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
                <h1 style="text-align: center;margin-bottom: 20px;">Cuenta creada!</h1>
                <p class="login-box-msg">Tu cuenta ha sido creada correctamente. Se envio un correo con tu información de acceso para ingresar al portal.</p>
                <p class="login-box-msg">Es necesario que tu cuenta sea verificada para poder ingresar al sistema. Este proceso puede demorar de 24-48 horas, una vez autorizada la cuenta se enviará un correo electrónico como notificación.</p>
                <a href="index.php" class="text-center" style="text-align: center;display: block;">Iniciar Sesion</a>
            </div>
        </div>
        <?php importView('_static/scripts'); ?>
    </body>
</html>