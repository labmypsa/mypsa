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
                                    <form method="POST" autocomplete="off" action="?c=<?php echo $this->name; ?>&a=destroy" role="form">
                                        <input type="hidden" name="id" value="<?php echo $data['tipocalibracion'][0]['id']; ?>">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="id">Número de identificación</label>
                                                <input type="text" class="form-control" id="id" name="id" placeholder="Número de identificación" disabled="" value="<?php echo $data['tipocalibracion'][0]['id']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="desctc">Nombre</label>
                                                <input disabled="" type="text" autofocus required="" class="form-control" id="desctc" name="desctc" placeholder="nombre" value="<?php echo $data['tipocalibracion'][0]['desctc']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="idpais">Sucursal</label>
                                                <select disabled="" autofocus="" id="idpais" class="form-control select2" style="width: 100%;" name="idsucursal" required="">
                                                    <option value="">Seleccione una opción</option>
                                                    <?php
                                                    foreach ($data['sucursal'] as $sucursal) {
                                                        if ($sucursal['id'] == $data['tipocalibracion'][0]['idsucursal']) {
                                                            echo '<option value="' . $sucursal['id'] . '" selected>' . $sucursal['descs'] . '</option>';
                                                        } else {
                                                            echo '<option value="' . $sucursal['id'] . '">' . $sucursal['descs'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="box-footer"><button type="submit" class="btn btn-danger">Elminar registro</button></div>
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