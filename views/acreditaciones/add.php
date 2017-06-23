<!DOCTYPE html>
<html>
    <head>
        <?php importView('_static.head'); ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini fixed">
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
                                    <h3 class="box-title">Agregar listados de <?php echo $this->name; ?></h3>
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
                                                ?>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                    <form method="POST" autocomplete="off" action="?c=<?php echo $this->name; ?>&a=store" role="form">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="sucursal">Sucursal</label>
                                                <select autofocus="" id="sucursal" class="form-control select2" style="width: 100%;" name="sucursales_id" required="">
                                                    <option value="">Seleccione una sucursal</option>
                                                    <?php
                                                    foreach ($data['sucursal'] as $sucursal) {
                                                        echo '<option value="' . $sucursal['id'] . '">' . $sucursal['nombre'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="nombre">Descripcion</label>
                                                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Descripcion" value="" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="activo">Activo</label>
                                                <select autofocus="" id="activo" class="form-control" name="activo" required="">
                                                    <option value="">Seleccione una opcion</option>
                                                    <option value="1">Habilitado</option>
                                                    <option value="0">No habilitado</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-primary btn-flat">Guardar cambios</button>
                                        </div>
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