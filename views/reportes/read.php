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
                     <form method="POST" novalidate="" autocomplete="off"  action="?c=<?php echo $this->name; ?>" role="form" enctype="multipart/form-data">
                        <div class="col-lg-12">
                            <div class="box box-default">
                                <div class="box-header">                                    
                                  <h3 class="box-title"><i class="fa fa-filter" aria-hidden="true"></i>&nbsp; Filtros de busqueda </h3>
                                    <div class="box-tools">                                        
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
                                                  <input type="text" class="form-control" id="daterange-text" name="daterange">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Sucursal:</label>
                                                  <select id="nombre_suc" class="form-control select2" style="width: 100%;" name="nombre_suc">
                                                      <option value="">Seleccione una opción</option> 
                                                        <?php
                                                          foreach ($data['sucursal'] as $sucursal) {
                                                          // Al cambiar de sucursal deben cambiar los tecnicos.
                                                            echo '<option value="'.$sucursal['nombre'].'">'.$sucursal['nombre'].'</option>';
                                                          }
                                                        ?> 
                                                    </select> 
                                            </div> 
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Técnico:</label>
                                                  <select id="usuarios_calibracion_id" class="form-control select2" style="width: 100%;" name="usuarios_calibracion_id">
                                                      <option value="">Seleccione una opción</option> 
                                                      <option value="0">Todos</option> 
                                                  </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Tipo de calibraciones:</label>
                                                  <select id="calibraciones_id" class="form-control select2" style="width: 100%;" name="calibraciones_id">
                                                      <option value="">Seleccione una opción</option> 
                                                      <option value="0">Todos</option>
                                                      <?php
                                                        foreach ($data['tipocalibracion'] as $tipocalibracion) {
                                                         echo '<option value="'.$tipocalibracion['id'].'">'.$tipocalibracion['nombre'].'</option>'; 
                                                        }
                                                      ?> 
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
                        <div class="col-lg-12">
                            <div class="box box-default">
                                <div class="box-header">
                                  <h3 class="box-title"> <i class="fa fa-bars" aria-hidden="true"></i>&nbsp; Reporte general </h3>
                                    <div class="box-tools">                                        
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                          <!-- small box -->
                                          <div class="small-box bg-aqua">
                                            <div class="inner">
                                              <h3><?php  echo (isset($pesos_t)) ? $pesos_t : 0 ; ?></h3>

                                              <p>Total</p>
                                            </div>
                                            <div class="icon">
                                              <i class="ion-social-usd"></i>
                                            </div>
                                            <label class="small-box-footer">
                                              <i class="fa fa-usd" aria-hidden="true"></i> Pesos 
                                            </label>
                                          </div>
                                        </div>
                                        <!-- ./col -->
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                          <!-- small box -->
                                          <div class="small-box bg-green">
                                            <div class="inner">
                                              <h3><?php  echo (isset($dolares_t)) ? $dolares_t : 0 ; ?></h3>

                                              <p>Total</p>
                                            </div>
                                            <div class="icon">
                                              <i class="ion-social-usd-outline"></i>
                                            </div>
                                            <label class="small-box-footer">
                                              <i class="fa fa-usd" aria-hidden="true"></i> Dolares 
                                            </label>
                                          </div>
                                        </div>
                                        <!-- ./col -->
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                          <!-- small box -->
                                          <div class="small-box bg-yellow">
                                            <div class="inner">
                                              <h3><?php  echo (isset($equipos_t)) ? $equipos_t : 0 ; ?></h3>

                                              <p>Total</p>
                                            </div>
                                            <div class="icon">
                                              <i class="ion-filing"></i>
                                            </div>
                                            <label class="small-box-footer">
                                             <i class="fa fa-hashtag" aria-hidden="true"></i> Equipos 
                                            </label>
                                          </div>
                                        </div>                                    
                                        <!-- ./col --> 
                                    </div>                                   
                                      <!-- /.row -->
                                    <div class="row">
                                        <div class="col-md-12">
                                          <div class="box box-solid">
                                            <div class="box-header with-border">                                             
                                            </div>
                                            <!-- /.box-header -->
                                            <div class="box-body">
                                              <div class="box-group" id="accordion">
                                                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                                                <div class="panel box box-primary">
                                                  <div class="box-header with-border">
                                                    <h4 class="box-title">
                                                      <a data-toggle="collapse" data-parent="#accordion" href="#collapse-1">
                                                        General
                                                      </a>
                                                    </h4>
                                                  </div>
                                                  <div id="collapse-1" class="panel-collapse collapse in">
                                                    <div class="box-body">
                                                        <table id="" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>                                                
                                                                    <th>#</th>
                                                                    <th>Técnico</th>
                                                                    <th > # Cantidad de equipos</th>
                                                                    <th >Total en pesos</th>
                                                                    <th >Total en dolares</th> 
                                                                </tr>
                                                            </thead>
                                                            <tbody>                       
                                                              <?php 
                                                                if (isset($table_t)){
                                                                  for ($i=0; $i < sizeof($table_t); $i++) {
                                                                     echo "<tr>"; 
                                                                     echo "<td>". $y= $i+1 ."</td>"; 
                                                                     echo "<td><button class='btn btn-block btn-social btn-github' onclick='ajax_tecnico(". $table_t[$i]["id_tecnico"].")'> <i class='fa fa-th-list' aria-hidden='true'></i> ". $table_t[$i]["tecnico"]."</button></td>";
                                                                     echo "<td>".$table_t[$i]["total_equipos"] ."</td>";
                                                                     echo "<td>$".$table_t[$i]["total_pesos"] ."</td>";
                                                                     echo "<td>$".$table_t[$i]["total_dolares"] ."</td>";
                                                                     echo "</tr>"; 
                                                                  }
                                                                  if(sizeof($table_t)== 0){echo "<td>No se encontraron registros...<td>" ;}
                                                                } 
                                                                 else{
                                                                 echo "<td>No hay registros...</td>" ;
                                                                 }
                                                              ?>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>                                               
                                                                    <th>#</th>
                                                                    <th>Técnico</th>
                                                                    <th > # Cantidad de equipos</th>
                                                                    <th >Total en pesos</th>
                                                                    <th >Total en dolares</th> 
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="panel box box-success">
                                                  <div class="box-header with-border">
                                                    <h4 class="box-title">
                                                      <a data-toggle='collapse' data-parent='#accordion' href='#collapse-2'><i class="fa fa-area-chart" aria-hidden="true"></i> Total de equipos</a> 
                                                    </h4>
                                                  </div>
                                                  <div id="collapse-2" class="panel-collapse collapse">
                                                    <div class="box-body">
                                                    <button id="save-lineChart" class="btn bg-navy margin pull-left"> <i class="fa fa-download" aria-hidden="true"></i> Descargar </button>   
                                                       <div class="chart">                                                       
                                                        <canvas id="lineChart" style="height:250px"></canvas>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="panel box box-success">
                                                  <div class="box-header with-border">
                                                    <h4 class="box-title">
                                                      <a data-toggle='collapse' data-parent='#accordion' href='#collap-3'><i class="fa fa-bar-chart" aria-hidden="true"></i> Total de Pesos/Dolares  </i></a> 
                                                    </h4>
                                                  </div>
                                                  <div id="collap-3" class="panel-collapse collapse">
                                                    <div class="box-body"> 
                                                    <button id="save-barChart" class="btn bg-navy margin pull-left"> <i class="fa fa-download" aria-hidden="true"></i> Descargar </button> 
                                                      </div> 
                                                      <div class="chart">                                                        
                                                        <canvas id="barChart" style="height:250px"></canvas> 
                                                      </div>
                                                  </div>
                                                </div>                                               
                                              </div>
                                            </div>
                                            <!-- /.box-body -->
                                          </div>
                                          <!-- /.box -->
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
           function ajax_tecnico($val){
             var parametro= {
                'var1': $val,
                'var2': "<?php echo $this->get_url($data); ?>"
             };
             $.ajax({
              data:parametro,
              url: "?c=reportes&a=ajax_puente",
              type: 'post',
              success : function(response){
                  //onsole.log(response);
                  var url='?c=reportes&a=tecnico&p='+response;
                  window.open(url, '_blank');
                  return false;
                }
             });          
           }
          
            $("#save-lineChart").click(function() {
              $("#lineChart").get(0).toBlob(function(blob) {
                saveAs(blob, "chart_lineChart.png");
              });
            });

            $("#save-barChart").click(function() {
              $("#barChart").get(0).toBlob(function(blob) {
                saveAs(blob, "chart_barChart.png");
              });
            });
            var ctx = document.getElementById("lineChart").getContext("2d");       
            var myLineChart = new Chart(ctx, {
                type: 'line',
                data: {               
                    labels: <?php echo json_encode ($array_Ttec); ?>,
                    datasets: [
                      {
                          label: "# Equiposs",
                          fill: true,
                          fillColor: "#79D1CF",
                          strokeColor: "#79D1CF",
                          lineTension: 0.1,
                          backgroundColor: "rgba(40,225,108,0.4)",
                          borderColor: "rgba(40,225,108,1)",
                          borderCapStyle: 'butt',
                          borderDash: [],
                          borderDashOffset: 0.0,
                          borderJoinStyle: 'miter',
                          pointBorderColor: "rgba(40,225,108,1)",
                          pointBackgroundColor: "#fff",
                          pointBorderWidth: 1,
                          pointHoverRadius: 5,
                          pointHoverBackgroundColor: "rgba(40,225,108,1)",
                          pointHoverBorderColor: "rgba(220,220,220,1)",
                          pointHoverBorderWidth: 2,
                          pointRadius: 5,
                          pointHitRadius: 10,
                          data: <?php echo json_encode ($array_Teq); ?>,
                          spanGaps: false,
                      }
                  ]
                },
                options: {
                  scales: {
                      xAxes: [{
                          display: true
                      }]
                  }
                }
            });      

            var ctx2 = document.getElementById("barChart");
            var myChart = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels:<?php echo json_encode ($array_Ttec); ?>,
                    datasets: [{
                        label: 'Total en pesos',
                        data: <?php echo json_encode ($array_Tps); ?>,
                        backgroundColor: [ 
                            'rgba(74,236,25, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(153, 103, 245, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(44,133,17,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(153, 103, 245, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    },
                    {
                        label: 'Total en dolares',
                        data: <?php echo json_encode ($array_Tdl); ?>,                   
                        backgroundColor: [
                            'rgba(13,154,8, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(153, 112, 225, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(7,66,5,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(153, 112, 225, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });              
        </script>        
    </body>
          
</html>