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
                    <h1><?php echo $this->title; ?><small>Equipos vencidos</small></h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-default">
                                <div class="box-header">
                                    <h3 class="box-title">Informes </h3>                                                                    
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                <!-- /* Agregar contenido */-->
                                    <table id="table_clientes" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
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
                                                <th>Dirección</th>
                                                <th>Acreditación</th> 
                                                <th>Calibración actual</th>
                                                <th>Vigencia</th>
                                                <th>Calibración siguiente</th>                                            
                                                <th>Comentarios</th>
                                                <th>Estado</th>
                                                <th>proceso</th>                                                
                                                <th>ver</th>                                               
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
                                                <th>Dirección</th>
                                                <th>Acreditación</th> 
                                                <th>Calibración actual</th>
                                                <th>Vigencia</th>
                                                <th>Calibración siguiente</th>                                               
                                                <th>Comentarios</th>
                                                <th>Estado</th>
                                                <th>proceso</th>                                                
                                                <th>ver</th> 
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
            var controller = "<?php echo $this->name.' '.$this->ext.' vencidos '.$usuario.' '; ?>";
        </script>
        <?php importView('_static.scripts'); ?>
                                        <script type="text/javascript">
       $(window).load(function() {
            new $.fn.dataTable.FixedColumns( table_clientes ,{
                leftColumns:1,
                rightColumns:1
            });
        });
        </script> 
    </body>
</html>