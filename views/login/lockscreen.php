<!DOCTYPE html>
<html>
    <head>
        <?php importView('_static.head'); ?>
    </head>
    <body class="hold-transition lockscreen">
        <div class="lockscreen-wrapper">
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
            <div class="lockscreen-logo">
                <a href="index.php"><?php echo APP_NAME; ?></a>
            </div>
            <div class="lockscreen-name"><?php echo session::get('nombre') . ' ' . session::get('apellido'); ?></div>
            <div class="lockscreen-item">
                <div class="lockscreen-image">
                    <img src="storage/avatares/<?php echo session::get('imagen'); ?>" alt="User Image">
                </div>
                <form method="POST" action="?c=login&a=unlock" class="lockscreen-credentials">
                    <div class="input-group">
                        <input type="password" autofocus="" class="form-control" name="password" placeholder="Contraseña">
                        <div class="input-group-btn">
                            <button type="button" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="help-block text-center">Introduce tu contraseña para ingresar al sistema</div>
            <div class="text-center">
                <a href="?c=login&a=logout">O inicie sesión como un usuario diferente</a>
            </div>
            <div class="lockscreen-footer text-center">
                
            </div>
        </div>        
        <?php importView('_static/scripts'); ?>
    </body>
</html>