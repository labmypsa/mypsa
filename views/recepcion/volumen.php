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
                        <form method="post" enctype="multipart/form-data">                        
                            <div class="col-lg-12 col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Equipos por volumen</h3>
                                        <div class="pull-right box-tools">
                                            <button type="button" class="btn btn-primary btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                                          <i class="fa fa-minus"></i></button> 
                                        </div>
                                    </div>
                                    <div class="box-body table-responsive">                                   
                                        <p>
                                            <div class="form-group">
                                                <label for="exampleInputFile">Lista de equipo</label>
                                                <input type="file" id="file" name="file" class="form-control-file" aria-describedby="fileHelp" accept=".csv">
                                            </div>
                                        </p>
                                        <p>                                        
                                            <button type="button" id="cargarfile" name="cargarfile" class="btn btn-primary btn-flat">Subir Archivo</button>
                                        </p>
                                        <hr>                                                                        
                                            <table id="tabla_volumen" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <td>Id</td>
                                                        <td>Descripcion</td>
                                                        <td>Marca</td>
                                                        <td>Modelo</td>
                                                        <td>Serie</td>
                                                        <td>Empresa</td>
                                                        <td>Planta</td>
                                                        <!-- <td>id Planta</td> -->
                                                        <td>Vigencia</td>
                                                        <td>Acreditación</td>
                                                        <td>Técnico</td>
                                                        <!-- <td>id Técnico</td> -->
                                                        <td>Calibración</td>
                                                        <td>Prioridad</td>
                                                        <td>PO</td>
                                                        <td>Cantidad</td>
                                                        <td>Registrador por</td>
                                                        <td>Usuario</td>
                                                        <td>Fecha</td>
                                                    </tr>
                                                </thead>                                            
                                                <tfoot>
                                                    <tr>
                                                        <td>Id</td>
                                                        <td>Descripcion</td>
                                                        <td>Marca</td>
                                                        <td>Modelo</td>
                                                        <td>Serie</td>
                                                        <td>Empresa</td>
                                                        <td>Planta</td>
                                                        <!-- <td>id Planta</td> -->
                                                        <td>Vigencia</td>
                                                        <td>Acreditación</td>
                                                        <td>Técnico</td>
                                                        <!-- <td>id Técnico</td> -->
                                                        <td>Calibración</td>
                                                        <td>Prioridad</td>
                                                        <td>PO</td>
                                                        <td>Cantidad</td>
                                                        <td>Registrador por</td>
                                                        <td>Usuario</td>
                                                        <td>Fecha</td>
                                                    </tr>
                                                </tfoot>
                                            </table>                                      
                                    </div>                                
                                    <div class="box-footer">
                                        <input type="submit" name="enviar" class="btn btn-primary btn-flat pull-right"  style="" value="Cargar datos a bitacora">
                                    </div>
                                </div>
                            </div>  
                        </form>                       
                </div>
                </section>
            </div>
            <?php importView('_static.footer'); ?>
        </div>
        <script>
            var controller = "<?php echo $this->name; ?>";
        </script>        
        <?php importView('_static.scripts'); ?>
        <script type="text/javascript">
             $(document).ready(function() {

               $('#tabla_volumen tfoot th').each( function () {
                    var title = $(this).text();
                    $(this).html('<input type="text" style="width:100%;font-weight: 400;font-size: 13px;padding: 3px 2px;" placeholder=" '+title+'" />' );
                } );

                var _table= $('#tabla_volumen').DataTable({ 
                    dom: '<"pull-left"l>fr<"dt-buttons"B>tip',
                    buttons: [],
                    columns: [
                        { data: '0' },
                        { data: '1' },
                        { data: '2' },
                        { data: '3' },
                        { data: '4' },
                        { data: '5' },
                        { data: '6' },
                        { data: '7' },
                        { data: '8' },
                        { data: '9' },
                        { data: '10' },
                        { data: '11' },
                        { data: '12' },
                        { data: '13' },
                        { data: '14' },                              
                        { data: '15' },
                        { data: '16' } 
                    ]
                     
                });

                _table.columns().every( function () {
                    var that = this;
                    $( 'input', this.footer() ).on( 'keyup change', function () {
                        if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                        }
                    });
                });

                $("#cargarfile").click( function(){
                    var file= $('#file').prop('files')[0];                    
                    var frmData= new FormData();
                    frmData.append("csvfile",file);
                    //console.log(frmData);
                    $.ajax({                   
                        url: '?c=recepcion&a=ajax_cargarcsv',                        
                        data:frmData,
                        processData:false,
                        contentType: false,
                        type:'POST',
                        success:function(data) {
                            var datos = data;
                            //console.log(datos);
                            var obj= JSON.parse(datos);                                                  
                            _table.clear();
                            _table.rows.add(obj).draw();                      
                        },
                        error: function (response) {
                            console.log(response);   
                        }
                    });
                });
                
              });

        </script>
        <!-- <script src="assets/plugins/js-xlsx/shim.js"></script>
        <script src="assets/plugins/js-xlsx/jszip.js"></script>
        <script src="assets/plugins/js-xlsx/xlsx.js"></script>
        <script src="assets/plugins/js-xlsx/ods.js"></script>
        <script src="assets/js/js-xlsx.js"></script> -->
    </body>
</html>