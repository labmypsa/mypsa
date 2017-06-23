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
                    <h1><?php echo $this->title; ?><small><?php echo $this->subtitle; ?></small></h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header  with-border">
                                    <h3 class="box-title">Reestablecer contraseña de <?php echo $this->name; ?></h3>
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
                                    <form method="POST" autocomplete="off"  action="?c=<?php echo $this->name; ?>&a=update_password" role="form" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $data['usuario'][0]['id']; ?>">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="id"># de identificación</label>
                                                <input disabled="" type="text" class="form-control" id="id" placeholder="Nombre" value="<?php echo $data['usuario'][0]['id']; ?>" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Correo electronico</label>
                                                <input disabled="" type="email" class="form-control" id="email" placeholder="Nombre de usuario" value="<?php echo $data['usuario'][0]['email']; ?>" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Contraseña</label>
                                                <input  type="password" minlength="3" class="form-control" name="password" id="password" placeholder="Contraseña" value="" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="confirm_password">Confirmar contraseña</label>
                                                <input  type="password" minlength="3" class="form-control" id="confirm_password" placeholder="Confirmar contraseña" value="" required="" oninput="checkPasswords(this)">
                                            </div>
                                        </div>
                                        <div class="box-footer"><button type="submit" class="btn btn-warning btn-flat">Reestablecer contraseña</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php importView('_static/footer'); ?>
        </div>
        <?php importView('_static/scripts'); ?>
    </body>
</html>