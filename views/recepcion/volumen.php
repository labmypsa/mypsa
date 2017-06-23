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
                        <div class="col-sm-3">
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
                        </div>
                        <div class="col-sm-9">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Equipos por volumen</h3>                                          
                                </div>
                                <div class="box-body">
                                   <p>
                                      <label for="xlf" class="btn btn-primary btn-flat">Seleccionar excel</label>
                                       <input type="file" id="xlf" style="display: none;" />
                                   </p>
                                   <div class="row">
                                     <div class="col-md-3">
                                       <p id="libros" style="display: none;">
                                         <label for="libro">Seleccione un libro</label>
                                         <select class="form-control" id="selectLibros">
                                           <option value="">Seleccione un libro</option>
                                         </select>
                                       </p>
                                     </div>
                                   </div>
                                   <p>
                                     <table class="table table-striped table-bordered table-hover" id="table-volumen">
                                         <thead>
                                             <tr>
                                                 <td>Id</td>
                                                 <td>Descripcion</td>
                                                 <td>Marca</td>
                                                 <td>Modelo</td>
                                                 <td>Serie</td>
                                                 <td>No. Informe</td>
                                                 <td>Tecnico</td>
                                                 <td>Estado</td>
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
                                                 <td>No. Informe</td>
                                                 <td>Tecnico</td>
                                                 <td>Estado</td>
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