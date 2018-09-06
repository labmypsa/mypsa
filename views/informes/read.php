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
                    <h1><?php echo $this->title; ?><small><?php echo $this->subtitle.' '. $this->sucursal; ?> </small></h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-default">
                                <div class="box-header">
                                    <h3 class="box-title">Bitácora completa</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <!-- /* Agregar contenido */-->
                                    <table id="table_informes" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%"> 
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>Id equipo</th>
                                                <th>Descripción</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                                <th>Cliente</th>
                                                <th>Planta</th>
                                                <th>Dirección</th>
                                                <th>Tipo/calibración</th>
                                                <th># Hoja de Entrada</th>
                                                <th>Recibido por</th>
                                                <th>Fecha de entrada</th>
                                                <th>Calibración actual</th>
                                                <th>Vigencia</th>
                                                <th>Calibración siguiente</th>
                                                <th>Calibrado por</th>
                                                <th>Informe hecho por</th>
                                                <th>Acreditación</th>
                                                <th># Hoja de salida</th>
                                                <th>Entregado por</th>
                                                <th>Fecha de salida</th>
                                                <th># P.O</th>
                                                <th>Aparatos en P.O</th>
                                                <th># Factura</th>
                                                <th>Precio</th>
                                                <th>Extra</th>
                                                <th>Moneda</th>
                                                <th>Comentarios</th>
                                                <th>Estado</th>
                                                <th>Proceso</th>                                                
                                                <th>%</th>    
                                                <th class="text-center">&nbsp;Ver&nbsp;</th>
                                                <th>Acción</th>
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
                                            <th>Cliente</th>
                                            <th>planta</th>
                                            <th>Dirección</th>
                                            <th>Tipo/calibración</th>
                                            <th># Hoja de Entrada</th>
                                            <th>Recibido por</th>
                                            <th>Fecha de entrada</th>
                                            <th>Calibración actual</th>
                                            <th>Vigencia</th>
                                            <th>Calibración siguiente</th>
                                            <th>Calibrado por</th>
                                            <th>Informe hecho por</th>
                                            <th>Acreditación</th>
                                            <th># Hoja de salida</th>
                                            <th>Entregado por</th>
                                            <th>Fecha de salida</th>
                                            <th># P.O</th>
                                            <th>Aparatos en P.O</th>
                                            <th># Factura</th>
                                            <th>Precio</th>
                                            <th>Extra</th>
                                            <th>Moneda</th>
                                            <th>Comentarios</th>
                                            <th>Estado</th>
                                            <th>Proceso</th>                                                
                                            <th>%</th> 
                                            <th class="text-center">&nbsp;Ver&nbsp;</th>
                                            <th >Acción</th> 
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
        var controller = "<?php echo $this->name.' '.$this->ext.' '.'4 '.$usuario.' '.$rol.''; ?>";        
        </script>
        <?php importView('_static.scripts'); ?>
        <script type="text/javascript">
       $(window).load(function() {
            new $.fn.dataTable.FixedColumns( table_informes ,{
                leftColumns:1,
                rightColumns:2
            });
        });
        </script> 
    </body>
</html>