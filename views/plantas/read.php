<!DOCTYPE html>
<html>
    <head>
        <?php importView('_static.head'); ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php importView('_static.header'); ?>
            <?php importView('_static.sidebar'); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1><?php echo $this->title; ?><small><?php echo $this->subtitle; ?></small></h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Listado de <?php echo $this->name; ?></h3>
                                    <a href="?c=<?php echo $this->name; ?>&a=add" class="btn btn-primary btn-md pull-right btn-flat">Agregar nuevo</a>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">

                                    <table id="table"  class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Empresa</th>
                                                <th>Planta</th>
                                                <th>Direccion</th>
                                                <th>C.P.</th>
                                                <th>Ciudad</th>
                                                <th>Estado</th>
                                                <th>RFC</th>
                                                <th>Razon Social</th>
                                                <th>Comentarios</th>
                                                <th>Mypsa Sucursal</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Empresa</th>
                                                <th>Planta</th>
                                                <th>Direccion</th>
                                                <th>C.P.</th>
                                                <th>Ciudad</th>
                                                <th>Estado</th>
                                                <th>RFC</th>
                                                <th>Razon Social</th>
                                                <th>Comentarios</th>
                                                <th>Mypsa Sucursal</th>
                                                <th>Acción</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php importView('_static.footer'); ?>
        </div>
        <script>
            var controller = "<?php echo $this->name; ?>";
        </script>
        <?php importView('_static.scripts'); ?>
    </body>
</html>