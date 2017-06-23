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
                                    <h3 class="box-title">Eliminación de <?php echo $this->name; ?></h3>
                                </div>
                                <!-- /.box-header -->
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
                                    <form method="POST" autocomplete="off"  action="?c=<?php echo $this->name; ?>&a=destroy" role="form">
                                        <input type="hidden" name="id" value="<?php echo $data['acreditacion'][0]['id']; ?>">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="id">Número de identificación</label>
                                                <input type="text" class="form-control" id="id" name="id" placeholder="id" disabled="" value="<?php echo $data['acreditacion'][0]['id']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="idsucursal">Sucursal</label>
                                                <select autofocus="" class="form-control" name="idsucursal" disabled>
                                                    <option value="">Seleccione una sucursal...</option>
                                                    <?php
                                                    foreach ($data['sucursal'] as $sucursal) {
                                                        if ($sucursal['id'] == $data['acreditacion'][0]['sucursales_id']) {
                                                            echo '<option value="' . $sucursal['id'] . '" selected>' . $sucursal['nombre'] . '</option>';
                                                        } else {
                                                            echo '<option value="' . $sucursal['id'] . '">' . $sucursal['nombre'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="nombre">Descripcion</label>                                                             
                                                <input type="text" name="nombre" class="form-control" id="nombre"  disabled="" placeholder="Descripcion" value="<?php echo $data['acreditacion'][0]['nombre']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="activo">Vigencia</label>
                                                <select autofocus="" disabled="" id="activo" class="form-control select2" style="width: 100%;" name="activo" required="">
                                                    <option value="">Seleccione una opcion</option>
                                                    <?php
                                                    if ($data['acreditacion'][0]['activo'] == '0') {
                                                        echo '<option value="1">Habilitado</option>';
                                                        echo '<option value="0" selected>No habilitado</option>';
                                                    } else if ($data['acreditacion'][0]['activo'] == '1') {
                                                        echo '<option value="1" selected>Habilitado</option>';
                                                        echo '<option value="0" >No habilitado</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-danger btn-flat">Elminar registro</button>
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