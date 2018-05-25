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
                    <h1><?php echo $this->title; ?><small><?php echo $this->subtitle; ?> Productividad</small></h1>
                </section>
                <section class="content">
                    <div class="row">
                     <form method="POST" novalidate="" autocomplete="off"  action="?c=reportes&a=productividad" role="form" enctype="multipart/form-data">
                        <div class="col-lg-12">
                            <div class="box">
                                <div class="box-header with-border">
                                  <h3 class="box-title"><i class="fa fa-filter" aria-hidden="true"></i>&nbsp; Filtros de busqueda </h3>
                                  <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>                                              
                                  </div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                         <!-- Date and time range -->
                                            <div class="form-group">
                                              <label>Rango de fechas:</label>
                                                <div class="input-group">
                                                  <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                  </div>
                                                  <input type="text" class="form-control" id="daterange-text-p" name="daterange">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Sucursal:</label>                                                
                                                  <select id="nombre_suc" name="nombre_suc[]" class="form-control select2" multiple="multiple" data-placeholder="Seleccione una opción" style="width: 100%;">
                                                      <option value="">Seleccione una opción</option> 
                                                        <?php
                                                          foreach ($data['sucursal'] as $sucursal) {
                                                          $sucursaltemp =strtolower($sucursal['nombre']);
                                                            if($sucursaltemp=='nogales' || $sucursaltemp=='hermosillo' || $sucursaltemp=='guaymas' ){echo '<option value="'.$sucursal['nombre'].'">'.$sucursal['nombre'].'</option>';} 
                                                           }
                                                        ?> 
                                                    </select> 
                                            </div> 
                                        </div>
                                        <div class="col-lg-6">                                            
                                            <div class="form-group">
                                                <label>Cliente:</label>                                                 
                                                    <select id="cliente_id" class="form-control select2" data-placeholder="Seleccione una opción" style="width: 100%;" name="cliente_id">
                                                      <option value="0">Seleccione una opción</option>
                                                      <?php
                                                        foreach ($data['planta'] as $clientes) {
                                                          if(trim(strtolower($clientes['nombre'])) == 'planta1')
                                                          {
                                                            $_cliente= $clientes['empresa'];
                                                          }
                                                          else{
                                                            $_cliente= $clientes['empresa'].' ('. $clientes['nombre'].')';
                                                          } 
                                                          echo '<option value="'.$clientes['id'].'">'. $_cliente
                                                         .'</option>'; 
                                                        }
                                                      ?> 
                                                  </select> 
                                            </div>  
                                             <div class="form-group">
                                                <label>Tipo de busqueda:</label>
                                                  	<select id="tipo_busqueda" class="form-control select2" style="width: 100%;" name="tipo_busqueda">
                                                      <option value="">Seleccione una opción</option> 
                                                      <option value="0">Comparación por empresa</option>
                                                      <option value="1">Comparación de sucursales</option>
                                                   	</select>
                                            </div>
                                        </div>
                                    </div>                                                                       
                                </div> 
                                <div class="box-footer">                                   
                                  <button type="submit" name="submit" class="btn btn-info pull-right"><i class="fa fa-search" aria-hidden="true"></i> &nbsp;Buscar</button>
                                </div> 
                            </div>                              
                        </div>
                      </form>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="box box-primary">
                          <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-bars" aria-hidden="true"></i>&nbsp; TOTAL DE EQUIPOS</h3>
                            <div class="box-tools pull-right">
                              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                              </button>                                              
                            </div>
                          </div>
                          <!-- /.box-header -->
                          <div class="box-body">
                            <div class="row">
                              <div class="col-md-12">
                                <h4 class="text-center" id="_rfechas" >Rango de fechas:</h4>
                              <!--    <div class="chart">
                                  <canvas id="areaChart" style="height:250px"></canvas>
                                </div> -->
                              </div>
                              <!-- /.col -->  
                            </div>
                            <!-- /.row -->
                          </div>
                          <!-- ./box-body -->
                          <div class="box-footer">
                            <div class="row">
                              <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="description-block border-right">
                                  <!-- <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span> -->
                                  <h5 class="description-header" id="_tregistrados"></h5>
                                  <span class="description-text">REGISTRADOS</span>
                                </div>
                                <!-- /.description-block -->
                              </div>
                              <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="description-block border-right">
                                  <!-- <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span> -->
                                  <h5 class="description-header" id="_tcalibrados"></h5>
                                  <span class="description-text">CALIBRADOS</span>
                                </div>
                                <!-- /.description-block -->
                              </div>
                              <!-- /.col -->
                              <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="description-block border-right">
                                  <!-- <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span> -->
                                  <h5 class="description-header" id="_tentregados"></h5>
                                  <span class="description-text">ENTREGADOS</span>
                                </div>
                                <!-- /.description-block -->
                              </div>
                              <!-- /.col -->
                              <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="description-block border-right">
                                  <!-- <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span> -->
                                  <h5 class="description-header" id="_tfacturados"></h5>
                                  <span class="description-text">FACTURADOS</span>
                                </div>
                                <!-- /.description-block -->
                              </div>                              
                            </div>
                            <!-- /.row -->
                          </div>
                          <!-- /.box-footer -->
                        </div>
                        <!-- /.box -->
                      </div>
                    </div>
                    <!-- /.col -->   
                    <div class="row">
                      <div class="col-lg-12 col-md-12">
                        <div class="box box-widget">
                          <div class="box-header with-border">
                            <h3 class="box-title"> <i class="fa fa-list" aria-hidden="true"></i>&nbsp; Reporte</h3>
                              <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>                                                    
                                </div>
                          </div>                                 
                          <div class="box-body"> <!-- table-responsive -->
                            <div class="row">                                                        
                                <?php foreach ( $table_data as $sucursal => $sucursal_anios) {  ?>
                                  <?php $size= 12 / sizeof($table_data);?>
                                  <div <?php echo "class='col-lg-". $size ."'" ?> >
                                    <div class="box box-primary collapsed-box">
                                        <div class="box-header with-border">
                                          <h3 class="box-title"><?php echo strtoupper($sucursal); ?></h3>
                                          <div class="box-tools pull-right">
                                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                          </button>
                                          </div>
                                          <!-- /.box-tools -->
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">                                 
                                          <table  class="table table-bordered table-striped table-hover" role="grid" cellspacing="0" width="50%">
                                            <thead>
                                              <tr>
                                                <th>Mes(s) / Año(s)</th>
                                                <?php foreach ( $sucursal_anios as $anio => $mes) { ?>                
                                                <th><?php echo $anio; ?></th>
                                                <?php } ?>
                                              </tr>
                                            </thead>
                                            <tbody>                                      
                                            <?php foreach ($mes as $key => $value) { ?><!-- Meses (12)-->
                                            <tr>
                                                <td><?php echo strtoupper($key); ?></td>
                                                <?php foreach ($sucursal_anios as $anio => $mes) { ?> <!-- años -->
                                                  <td><?php echo $sucursal_anios[$anio][$key]; ?></td>
                                                <?php } ?>
                                              </tr>                                      
                                            <?php } ?>
                                            </tbody>
                                            <tfoot>
                                              <tr>
                                                <th>Mes(s) / Año(s)</th>
                                                <?php foreach ( $sucursal_anios as $anio => $mes) { ?>                
                                                <th><?php echo $anio; ?></th>
                                                <?php } ?>
                                              </tr>
                                            </tfoot>
                                          </table>
                                        </div>
                                      <!-- /.box-body -->
                                    </div>
                                  </div>   
                                <?php } ?>
                            </div>
                          </div>                                                        
                          <div class="box-footer">                                    
                          </div>                                
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-12 col-md-12">
                        <div class="box box-info">
                          <div class="box-header with-border">
                            <h3 class="box-title"> <i class="fa fa-list" aria-hidden="true"></i>&nbsp; Reporte</h3>
                              <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>                                                    
                                </div>
                          </div>                                 
                          <div class="box-body"> <!-- table-responsive -->
                            <div class="row">
                              <div class="col-md-6">                                
                                <table id="table_will3" class="table table-bordered table-striped table-hover" cellspacing="0" width="50%">
                                  <thead>
                                    <tr>
                                      <th>Mes(s) / Año(s)</th>
                                      <th>2015</th>
                                      <th>2016</th>
                                      <th>2017</th>
                                      <th>2018</th>
                                    </tr>
                                  </thead>
                                  <tfoot>
                                    <tr>
                                      <th>Mes(s) / Año(s)</th>
                                      <th>2015</th>
                                      <th>2016</th>
                                      <th>2017</th>
                                      <th>2018</th>
                                    </tr>
                                  </tfoot>
                                </table>  
                              </div>
                              <div class="col-md-6">
                                <table id="table_will4" class="table table-bordered table-striped table-hover" cellspacing="0" width="50%"> 
                                  <thead>
                                    <tr>
                                      <th>Mes(s) / Año(s)</th>
                                      <th>2015</th>
                                      <th>2016</th>
                                      <th>2017</th>
                                      <th>2018</th>
                                    </tr>
                                  </thead>
                                  <tfoot>
                                    <tr>
                                      <th>Mes(s) / Año(s)</th>
                                      <th>2015</th>
                                      <th>2016</th>
                                      <th>2017</th>
                                      <th>2018</th>
                                    </tr>
                                  </tfoot>
                                </table> 
                              </div>
                            </div>
                          </div>                                                        
                          <div class="box-footer">                                    
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
        <script type="text/javascript">

          /* Datarange libreria alternativa*/
        $('#daterange-text-p').daterangepicker(
            {
          ranges: {                                        
            'Este mes': [moment().startOf('month'), moment().endOf('month')],
            'Mes anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            '3 Meses': [moment().subtract(3, 'month').startOf('month'), moment().endOf('month')],
            '6 Meses': [moment().subtract(6, 'month').startOf('month'), moment().endOf('month')],
            '1 año': [moment().subtract(1, 'years').add(1, 'day'), moment()]            
          },
          startDate: moment().startOf('month'),
          endDate: moment().endOf('month')
            },
            function (start, end) {
          $('#daterange-text-p span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            }
        );

          $(document).ready(function() { 
            var _tregistrados= $('#_tregistrados');                      
            var _tcalibrados= $('#_tcalibrados');                      
            var _tentregados= $('#_tentregados'); 
             var _tfacturados= $('#_tfacturados'); 
            var _rfechas= $('#_rfechas'); 
              _tregistrados.text('0');
              _tcalibrados.text('0');
              _tentregados.text('0');
              _tfacturados.text('0');
              _rfechas.text('Rango de fechas:');

           // $('#table_will tfoot th').each( function () {
           //    var title = $(this).text();
           //    $(this).html( '<input type="text" style="width:100%;font-weight: 400;font-size: 13px;padding: 3px 2px;" placeholder=" '+title+'" />' );
           //  } );

           //  var _table= $('#table_will').DataTable({ 
           //    dom: '<"pull-left"l>fr<"dt-buttons"B>tip',
           //    buttons: [
           //         {
           //            extend: 'excel',
           //            text: 'Excel',
           //            exportOptions: {
           //                columns: [':not(:last-child)' ]
           //            }
           //        }                
           //    ],                  
           //    columns: [
           //                { data: 'data.mes' },
           //                { data: 'data.total' },                         
           //              ]             
           //      });

           //  _table.columns().every( function () {
           //  var that = this;
           //  $( 'input', this.footer() ).on( 'keyup change', function () {
           //      if ( that.search() !== this.value ) {
           //          that
           //              .search( this.value )
           //              .draw();
           //          }
           //      });
           //  });        
                  
                       

            $("#buscar_rp").click(function(){ //reporte productividad= rp
              var parametro= {
                  'daterange': $('#daterange-text-p').val(),
                  'nombre_suc': $("#nombre_suc").val(),
                  'cliente_id': $("#cliente_id").val(),
                  'tipo_busqueda': $("#tipo_busqueda").val()                  
                };    
                //console.log(parametro);  
                /*Empieza ajax*/
                $.ajax({
                      type: 'post',
                      url: "?c=reportes&a=ajax_load_productividad",                        
                      data: parametro
                    }).done(function(data) {
                      var datos = data;
                      console.log(datos);                      
                    }).fail(function(data) {}).always( function(data) {
                      //console.log(data);
                    });                                                                                     
                /*end ajax*/
            });

               function validar_select(parametro)
              {    
               var result= true;
                 if (parametro['nombre_suc']=='' || parametro['tipo_busqueda']=='') {
                    result= false;
                 }                
                return result;
              }                            

            function showgraph(){            
            }

            // function totales_p_d(obj){
            //   _tequipos.text('0');
            //   _tpesos.text('$ 0');
            //   _tdlls.text('$ 0');
            //   var sumap=0;
            //   var sumad=0;
            //   var equipost= obj.length;
            //   for (var i = 0 ; i < obj.length; i++) { 
            //     if(obj[i].moneda=="PESOS"){
            //          sumap += parseFloat(obj[i].precio) + parseFloat(obj[i].precio_extra);
            //       }
            //       else if(obj[i].moneda=="DLLS"){
            //         sumad += parseFloat(obj[i].precio) + parseFloat(obj[i].precio_extra);
            //       }
            //   }
            //   _tequipos.text(equipost);
            //   _tpesos.text('$ '+ sumap.toFixed(2));
            //   _tdlls.text('$ '+ sumad.toFixed(2));
            // }

          });
        </script>
        <script>
          // var ctx = document.getElementById("areaChart").getContext('2d');
          // var myChart = new Chart(ctx, {
          //    type: 'line',
          //     data: {
          //         labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
          //         datasets: [{
          //             label: '# of Votes',
          //             data: [12, 19, 3, 5, 2, 3],
          //             backgroundColor: [
          //               'rgba(255, 99, 132, 0.2)'
          //             ],
          //             borderWidth: 1
          //         }]
          //     },
          //     options: {
          //         scales: {
          //             yAxes: [{
          //                 stacked: true
          //             }]
          //         }
          //     }
          // });
        </script>   
    </body>
          
</html>