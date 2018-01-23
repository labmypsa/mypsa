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
                       <!--  <div class="col-sm-3">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Generar hoja de trabajo</h3>
                                </div>
                                <div class="box-body">
                                    <div class="col-xs-6">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-xs-6">
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="col-sm-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Equipos por volumen</h3>
                                    <div class="pull-right box-tools">
                                        <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                                          <i class="fa fa-minus"></i></button>                                 
                                      </div>                                       
                                    </div>
                                <div class="box-body">
                                   <p>
                                      <label for="xlf" class="btn btn-primary btn-sm"><i class="fa fa-upload" aria-hidden="true"></i> &nbsp; Seleccionar excel</label>
                                       <input type="file" id="xlf" style="display: none;" />
                                       <button type="button" class="btn btn-success btn-sm"><i class="fa fa-cloud" aria-hidden="true"></i>&nbsp; Registrar</button>
                                   </p>                                 
                                   <p>
                                     <table class="table table-striped table-bordered table-hover" id="table-volumen">
                                         <thead>
                                             <tr>
                                                 <td>Id</td>
                                                 <td>Descripcion</td>
                                                 <td>Marca</td>
                                                 <td>Modelo</td>
                                                 <td>Serie</td>
                                                 <td>Empresa</td>
                                                 <td>Planta</td>
                                                 <td>id Planta</td>
                                                 <td>Vigencia</td>
                                                 <td>Acreditación</td>
                                                 <td>Técnico</td>
                                                 <td>id Técnico</td>
                                                 <td>Calibración</td>
                                                 <td>Prioridad</td>
                                                 <td>PO</td>
                                                 <td>Cantidad</td>
                                                 <td>Registrador por</td>
                                                 <td>Id usuario</td>
                                                 <td>Fecha</td>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             
                                         </tbody>
                                         <tfoot>
                                             <tr>
                                                 <td>Id</td>
                                                 <td>Descripcion</td>
                                                 <td>Marca</td>
                                                 <td>Modelo</td>
                                                 <td>Serie</td>
                                                 <td>Empresa</td>
                                                 <td>Planta</td>
                                                 <td>id Planta</td>
                                                 <td>Vigencia</td>
                                                 <td>Acreditación</td>
                                                 <td>Técnico</td>
                                                 <td>id Técnico</td>
                                                 <td>Calibración</td>
                                                 <td>Prioridad</td>
                                                 <td>PO</td>
                                                 <td>Cantidad</td>
                                                 <td>Registrador por</td>
                                                 <td>Id usuario</td>
                                                 <td>Fecha</td>
                                             </tr>
                                         </tfoot>
                                     </table>
                                   </p>
                                   <p>
                                     <button class="btn btn-primary btn-flat" style="display: none;" id="uploadData">Cargar datos en bitacora</button>
                                   </p>
                                   <p>
                                      <pre id="out" style="display: none;"></pre>
                                   </p>
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
        <script src="assets/plugins/js-xlsx/shim.js"></script>
        <script src="assets/plugins/js-xlsx/jszip.js"></script>
        <script src="assets/plugins/js-xlsx/xlsx.js"></script>
        <script src="assets/plugins/js-xlsx/ods.js"></script>
        <script src="assets/js/js-xlsx.js"></script>
    </body>
</html>