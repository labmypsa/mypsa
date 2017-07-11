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
                                                ?></ul>
                                        </div>
                                    <?php } ?>
                                    <form method="POST" autocomplete="off"  action="?c=<?php echo $this->name; ?>&a=store" role="form">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="alias">Id de equipo</label>                                                    
                                                <input autofocus type="text" class="form-control" name="alias" id="alias" placeholder="Id de equipo" value="" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="serie">Número de serie</label>                                                    
                                                <input autofocus type="text" class="form-control" name="serie" id="serie" placeholder="Número de serie" value="" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="descripciones_id">Descripción</label>
                                                <select class="form-control select2Descripcion" name="descripciones_id" id="descripciones_id"  required="" style="width: 100%;">
                                                    <option value="">Seleccione una opción</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="marcas_id">Marca</label>
                                                <select class="form-control select2Marca" name="marcas_id" id="marcas_id" required="" style="width: 100%;">
                                                    <option value="">Seleccione una opción</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="modelos_id">Modelo</label>
                                                <select class="form-control select2Modelo" name="modelos_id" id="modelos_id" required="" style="width: 100%;">
                                                    <option value="">Seleccione una opción</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="comentarios">Comentarios</label>
                                                <input type="text" class="form-control" name="comentarios" id="comentarios" placeholder="Comentarios">
                                            </div>
                                        </div>
                                        <div class="box-footer"><button type="submit" class="btn btn-primary btn-flat">Guardar cambios</button></div>
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