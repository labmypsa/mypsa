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
                    <h1><?php echo $this->title; ?><small><?php echo $this->subtitle; ?> Total de producción</small></h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-default">
                                <div class="box-header">
                                    <h3 class="box-title"> 
                                    <ol class="breadcrumb" style="background: white; padding-left:0px;">
                                        <i class="fa fa-th-list" ></i>
                                        <li class="active"> <?php echo '  '.strtoupper($_GET['var3']);?> </li>
                                        <li class="active"><?php echo strtoupper($_GET['var1']);?></li>
                                        <li ><?php echo strtoupper($_GET['var2']);?></li>
                                    </ol>
                                    </h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                     <table id="table_totalproduct" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>                                                
                                                <th>id</th>
                                                <th>Id equipo</th>
                                                <th>Descripción</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                                <th>activo</th>                                                
                                                <th>Cliente</th>
                                                <th>Tipo de calibración</th>
                                                <th>Factura</th>
                                                <th>Precio</th>
                                                <th>Precio Extra</th>
                                                <th>Moneda</th>
                                                <th>Fecha de calibración</th>
                                                <th>Días antes de Cal:</th>
                                                <th>Días despues de Cal:</th>
                                                <th>Total de días:</th>
                                                <th>id proceso</th>
                                                <th>Proceso</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>                                               
                                                <th>id</th>
                                                <th>Id equipo</th>
                                                <th>Descripción</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                                <th>activo</th>                                                
                                                <th>Cliente</th>
                                                <th>Tipo de calibración</th>
                                                <th>Factura</th>
                                                <th>Precio</th>
                                                <th>Precio Extra</th>
                                                <th>Moneda</th>
                                                <th>Fecha de calibración</th>
                                                <th>Días antes de:</th>
                                                <th>Días despues de:</th>
                                                <th>Total de días:</th>
                                                <th>id proceso</th>
                                                <th>Proceso</th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                <!-- /* Termina contenido*/-->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php importView('_static.footer'); ?>
        </div>
        <script>          
            var controller = '<?php echo 'total_product'.' '.$arreglo.' '; ?>';        
        </script>
        <?php importView('_static.scripts'); ?>
    </body>
</html>