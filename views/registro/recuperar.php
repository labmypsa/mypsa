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

                <h1 style="text-align: center;margin-bottom: 20px;">Recuperar Contraseña</h1>
                <p class="login-box-msg">Ingrese la dirección de correo electrónico asociado con su cuenta de MyPSA.</p>
                <form class="form-horizontal" action="?c=registro&a=resetpass" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Correo</label>

                  <div class="col-sm-10">
                    <input autofocus type="email" name="email" class="form-control"  placeholder="Correo">
                  </div>
                </div>                            
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a type="button"  href="index.php" class="btn btn-default">Cancelar</a>
                <button type="submit" class="btn btn-info pull-right">Recuperar</button>
              </div>
              <!-- /.box-footer -->
            </form>
            </div>
        </div>
        <?php importView('_static/scripts'); ?>
    </body>
</html>