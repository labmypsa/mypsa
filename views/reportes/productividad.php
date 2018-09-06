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
                                                          foreach ($_data['sucursal'] as $sucursal) {
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
                                                        foreach ($_data['planta'] as $clientes) {
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
                                                      <option value="0"> Productividad por cliente</option>
                                                      <option value="1"> Productividad por sucursal</option>
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
                              <h4 class="box-title" align="center">&nbsp; Rango de fechas <?php echo ": ".$data['fecha_home']." - ". $data['fecha_end']; ?> </h4>
                               

                                <?php  foreach ( $table_totales as $sucursal => $procesos) { ?>
                                <?php $size= 12 / sizeof($table_totales);?>
                                <div <?php echo "class='col-lg-". $size ."'" ?> >
                                  <h4 class="box-title"><?php  echo ($data['tipo_busqueda']== 0) ? $cliente : strtoupper($sucursal); ; ?></h4> 
                                  <table class="table table-condensed">
                                    <tbody>
                                      <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Procesos</th>
                                        <th>Porcentaje</th>
                                        <th style="width: 40px">Cantidad</th>
                                      </tr>
                                      <?php $ids=0; foreach ( $procesos as $key => $value) { ?>
                                      <tr>                                        
                                        <td><?php echo $ids= $ids +1;
                                          if ($ids < 4) { $entero= $procesos['Alta']; } 
                                          else if ($ids == 4) { $entero= $procesos['Solo_clientes'];}
                                          else if ($ids == 5) { $entero= $procesos['Solo_clientes'];}
                                          else if ($ids == 6) { $entero= $procesos['Alta']; }
                                          ?>.
                                        </td>
                                        <td><?php echo $key; ?></td>
                                        <td>
                                          <?php $bar= array('','danger','warning','info','primary','success','black');
                                          $bg= array('','red','yellow','aqua','blue','green','black'); $x= round(($value*100)/$entero); ?>
                                          <div class="progress progress active">
                                             <?php echo "<div class=\"progress-bar progress-bar-".$bar[$ids]." progress-bar-striped\" style=\"width:".$x."%\">".$x."%</div>";?>
                                          </div>
                                        </td>
                                        <td><?php echo "<span class=\"badge bg-".$bg[$ids]."\"> ".$value."</span>"; ?> </td>
                                      </tr>
                                      <?php  # Cierra if
                                         
                                      } ?>                                
                                    </tbody>
                                    <tfoot>
                                      <tr>
                                        <td colspan="3" align="center"><?php echo "<a href='?c=reportes&a=total_product&var0=total&var1=".$data['fecha_home']."&var2=".$data['fecha_end']."&var3=". strtolower($data['nombre_suc'][0]) ."&var4=".$data['cliente_id']."' target='_blank'> Más información <i class='fa fa-arrow-circle-right'></i></a>"; ?> </td>                                       
                                      </tr>
                                    </tfoot>
                                  </table>                                  
                                </div>                         
                              <?php } ?>
                                                                         
                            </div>
                            <!-- /.row -->
                          </div>
                          <!-- ./box-body -->
                          <div class="box-footer">
                            <div class="row">
                              <div class="col-lg-12">                                                
                              <h4 class="box-title"> <i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp; Métricas  </h4>                              
                              <?php foreach ($table_totales as $sucursal => $procesos) {  ?>
                                <?php $size= 12 / sizeof($table_data);?>
                                <div <?php echo "class='col-lg-". $size ." border-right'" ?> >
                                  <h4 class="box-title"><?php  echo ($data['tipo_busqueda']== 0) ? $cliente : strtoupper($sucursal); ; ?></h4> 
                                  <?php echo '<button  id="savepieChart-'.strtolower($sucursal).'" class="btn bg-navy margin pull-left"> <i class="fa fa-download" aria-hidden="true"></i> Descargar </button>'; ?>
                                <?php echo "<canvas id=\"pieChart-".strtolower($sucursal)."\" class=\"chartjs\" width=\"538\" height=\"269\" style=\"display: block; width: 538px; height: 269px;\"></canvas>"; ?>     
                                </div>                         
                              <?php } ?>                      
                            </div>
                            </div>
                        </div>
                          <!-- /.box-footer -->
                        </div>
                        <!-- /.box -->
                      </div>
                    </div>
                    <!-- /.col -->   
                    <div class="row">
                      <div class="col-lg-12 col-md-12">
                        <div class="box box-info">
                          <div class="box-header with-border">
                            <h3 class="box-title"> <i class="fa fa-list" aria-hidden="true"></i>&nbsp; Reporte de equipos calibrados</h3>
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
                                    <div class="box box-default collapsed-box">
                                        <div class="box-header with-border">
                                          <h3 class="box-title"><?php  echo ($data['tipo_busqueda']== 0) ? $cliente : strtoupper($sucursal); ; ?></h3>
                                          <div class="box-tools pull-right">
                                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                          </button>
                                          </div>
                                          <!-- /.box-tools -->
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">                                 
                                          <table  class="table table-condensed" role="grid" cellspacing="0" width="50%">
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
                                                  <td><?php if ($sucursal_anios[$anio][$key] == 0) { echo $sucursal_anios[$anio][$key];} else{ ?>
                                                    <?php echo "<a href='?c=reportes&a=total_product&var0=compara&var1=".$anio."&var2=".$key."&var3=". strtolower($data['nombre_suc'][0]) ."&var4=".$data['cliente_id']."' target='_blank'>" ?><span class="badge bg-green"><?php echo $sucursal_anios[$anio][$key]; } ?></span></a></td>
                                                <?php } ?>
                                              </tr>                                      
                                            <?php } ?>
                                            </tbody>
                                            <tfoot>
                                              <tr>
                                                <th>Total: </th>
                                                <?php foreach ($sucursal_anios as $anio => $mes) {  $suma=0; ?> 
                                                  <?php foreach ($mes as $key => $value) { ?><!-- Meses (12)--> 
                                                    <?php $suma=$suma+$sucursal_anios[$anio][$key]; ?>
                                                  <?php } ?>
                                                  <th><?php echo $suma; ?></th>
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
                            <div class="row">
                              <div class="col-lg-12">                                                
                              <h4 class="box-title"> <i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp; Métricas</h4>
                                <?php foreach ( $table_data as $sucursal => $sucursal_anios) {  ?>
                                  <?php $size= 12 / sizeof($table_data);?>
                                  <div <?php echo "class='col-lg-". $size ." border-right'" ?> >
                                    <h3 class="box-title"><?php  echo ($data['tipo_busqueda']== 0) ? $cliente : strtoupper($sucursal); ; ?></h3>
                                    <?php echo '<button  id="savechartjs-'.strtolower($sucursal).'" class="btn bg-navy margin pull-left"> <i class="fa fa-download" aria-hidden="true"></i> Descargar </button>'; ?>
                                  <?php echo "<canvas id=\"chartjs-". strtolower($sucursal) ."\" class=\"chartjs\" width=\"538\" height=\"269\" style=\"display: block; width: 538px; height: 269px;\"></canvas>"; ?>     
                                  </div>                         
                                <?php } ?>
                              </div>                                                      
                            </div>                                     
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
            '1 año': [moment().subtract(1, 'years').startOf('month'), moment().endOf('month')]            
          },
          startDate: moment().startOf('month'),
          endDate: moment().endOf('month')
            },
            function (start, end) {
          $('#daterange-text-p span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            }
        );      

          $(document).ready(function() {                       
                <?php
                  foreach ($table_data as $sucursal => $sucursal_anios) {
                     echo 'var data'.strtolower($sucursal).'= [';
                    foreach ($sucursal_anios as $anio => $mes) {
                      // Año
                      echo '{';
                      echo "label:'". $anio ."',";
                      echo 'data:[';
                      foreach ($mes as $key => $value) {
                        //MES 
                        echo $sucursal_anios[$anio][$key].',';
                      }                    
                      echo '],';
                      echo "fill:false,borderColor:'rgb(".rand(0, 255).",".rand(50, 255).",".rand(100, 255).")',lineTension:0.1";
                      echo '},';
                    }
                    echo '];';
                    echo "\n";
                    echo 'var datatotal'.strtolower($sucursal).'={labels:[\'Enero\',\'Febrero\',\'Marzo\',\'Abril\',\'Mayo\',\'Junio\',\'Julio\',\'Agosto\',\'Septiembre\',\'Octubre\',\'Noviembre\',\'Diciembre\'], datasets: data'.strtolower($sucursal).'};';
                    echo "\n";                    
                    echo "var ctx = document.getElementById('chartjs-".strtolower($sucursal)."').getContext('2d'); \n";
                    //echo "new Chart(document.getElementById('chartjs-".strtolower($sucursal)."'),{type:'line',data: datatotal".strtolower($sucursal).' });';

                    echo  "new Chart(ctx,{ type:'line',data: datatotal".strtolower($sucursal).", \n";
                    echo    "});\n";
                     

                  }
                ?>
                <?php
                  $bg= array("rgb(229,40,0)","rgb(243,150,8)","rgb(8,205,243)","rgb(0,120,255)","rgb(54,177,50)");
                  foreach ($table_totales as $sucursal => $procesos) {
                    echo "new Chart(document.getElementById('pieChart-".strtolower($sucursal)."'),{'type':'doughnut','data':{'labels':[";
                    foreach ( $procesos as $key => $value){ // $key = procesos =>  labels  |  $values = valores=> data
                      if ($key != 'Solo_clientes'){
                         echo "'".$key."',";
                      }                     
                    }
                    echo "],";
                    echo "'datasets':[{'label':'".strtolower($sucursal)."',";
                    echo "'data':[";
                    foreach ( $procesos as $key => $value){ // $key = procesos =>  labels  |  $values = valores=> data
                      if ($key != 'Solo_clientes'){
                       echo "'".$value."',";
                      }                      
                    }
                    echo "],";
                    echo "'backgroundColor': [";
                    for ($i=0; $i < count($bg) ; $i++) { 
                      echo "'".$bg[$i]."',";
                    }
                    echo "]}";
                    echo "]}";
                    echo "});";
                  }
                ?>

              
                <?php  
                foreach ($table_data as $sucursal => $sucursal_anios) { 
                echo '$(\'#savepieChart-'.strtolower($sucursal).'\').click(function() { $(\'#pieChart-'. strtolower($sucursal).'\').get(0).toBlob(function(blob) {
                  saveAs(blob, \'MetricaSucursal-'.strtolower($sucursal).'.png\');
                }); });';
                echo '$(\'#savechartjs-'.strtolower($sucursal).'\').click(function() { $(\'#chartjs-'. strtolower($sucursal).'\').get(0).toBlob(function(blob) {
                  saveAs(blob, \'MetricaMensual-'.strtolower($sucursal).'.png\');
                }); });';
                }
                ?>                            
              

          });      
        </script>        
    </body>
          
</html>