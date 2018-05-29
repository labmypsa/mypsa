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
                        <div class="box box-success">
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
                                <h4 class="text-center" id='_rfechas'>Rango de fechas: </h4>
                                <!-- <h2 class="text-center"></h2> -->
                                   
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
                                    <div class="box box-info collapsed-box">
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
                        <div class="box box-success">
                          <div class="box-header with-border">
                            <h3 class="box-title"> <i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp; Reporte</h3>
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
                                <?php echo "<canvas id=\"chartjs-". $sucursal ."\" class=\"chartjs\" width=\"538\" height=\"269\" style=\"display: block; width: 538px; height: 269px;\"></canvas>"; ?>     
                                </div>                         
                              <?php } ?>                                                        
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
              _tregistrados.text('0');
              _tcalibrados.text('0');
              _tentregados.text('0');
              _tfacturados.text('0');                                    
              $("#nombre_suc").val();
              $("#cliente_id").val();
              $("#tipo_busqueda").val();
  

            // $("#buscar_rp").click(function(){ //reporte productividad= rp
            //   var parametro= {
            //       'daterange': $('#daterange-text-p').val(),
            //       'nombre_suc': $("#nombre_suc").val(),
            //       'cliente_id': $("#cliente_id").val(),
            //       'tipo_busqueda': $("#tipo_busqueda").val()                  
            //     };    
            //     //console.log(parametro);  
            //     /*Empieza ajax*/
            //     $.ajax({
            //           type: 'post',
            //           url: "?c=reportes&a=ajax_load_productividad",                        
            //           data: parametro
            //         }).done(function(data) {
            //           var datos = data;
            //           console.log(datos);                      
            //         }).fail(function(data) {}).always( function(data) {
            //           //console.log(data);
            //         });                                                                                     
            //     /*end ajax*/
            // });
               <?php 
                  // $hola="hola";
                  // echo "label:'".."'";                 
                foreach ($table_data as $sucursal => $sucursal_anios) {
                   echo 'var data'.$sucursal.'= [';
                  foreach ($sucursal_anios as $anio => $mes) {
                    // Año
                    echo '{';
                    echo "label:'". $anio ."',";
                    echo 'data:[';
                    foreach ($mes as $key => $value) {
                      //MES 
                      echo $sucursal_anios[$anio][$key].',';
                    }
                    // echo ''.rand(20, 244).','.rand(20, 244).',80,'.rand(20, 244).',56,'.rand(20, 244).',40,'.rand(20, 244).',56,'.rand(20, 244).',45,'.rand(20, 244).',';
                    echo '],';
                    echo "fill:false,borderColor:'rgb(".rand(0, 255).",".rand(50, 255).",".rand(100, 255).")',lineTension:0.1";
                    echo '},';
                  }
                  echo '];';
                  echo "\n";
                  echo 'var datatotal'.$sucursal.'={labels:[\'January\',\'February\',\'March\',\'April\',\'May\',\'June\',\'July\',\'August\',\'September\',\'October\',\'November\',\'December\'],datasets:data'.$sucursal.'};';
                  echo "\n";
                  echo "var myChart =  new Chart(document.getElementById('chartjs-".$sucursal."'),{type:'line',data: datatotal".$sucursal.' });';
                }

                ?>                                      

    //   document.getElementById("chartjs-0").onclick = function(evt){
    //   var activePoints = myChart.getElementsAtEvent(evt);
    //   //var activeDataSet = myChart.getDatasetAtEvent(evt);
    //   console.log(activePoints);
    //   var firstPoint = activePoints[0];
    //   var label = myChart.data.labels[firstPoint._index];
    //   var value = myChart.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];
    //   if (firstPoint !== undefined)
    //     alert(label + ": " + value);
    // };
          });
        </script>        
    </body>
          
</html>