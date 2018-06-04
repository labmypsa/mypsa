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
                    <h1><?php echo $this->title; ?><small><?php echo $this->subtitle; ?> Clientes</small></h1>
                </section>
                <section class="content">
                    <div class="row">
                     <form novalidate="" autocomplete="off" role="form" enctype="multipart/form-data">
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
                                                  <input type="text" class="form-control" id="daterange-text" name="daterange">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Sucursal:</label> 
                                                <select id="nombre_suc" class="form-control select2" style="width: 100%;" name="nombre_suc">
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
                                                      <option value="">Seleccione una opción</option> 
                                                      <option value="0">Todos</option>
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
                                                      <option value="0">Equipos calibrados</option>
                                                      <option value="1">Equipos a vencer</option>
                                                      <option value="2">Equipos vencidos</option> 
                                                   	</select>
                                            </div>
                                        </div>
                                    </div>                                                                       
                                </div> 
                                <div class="box-footer">                                   
                                  <button type="button" name="buscar_rc" id="buscar_rc" class="btn btn-info pull-right"><i class="fa fa-search" aria-hidden="true"></i> &nbsp;Buscar</button>
                                </div> 
                               
                              </div>                              
                        </div>
                      </form>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="box box-primary">
                          <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-area-chart" aria-hidden="true"></i>&nbsp; Metricas</h3>
                            <div class="box-tools pull-right">
                              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                              </button>                                              
                            </div>
                          </div>
                          <!-- /.box-header -->
                          <div class="box-body">
                            <div class="row">
                              <div class="col-md-12">
                                <h4 class="text-center" id="_rfechas" > </h4>
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
                              <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="description-block border-right">
                                  <!-- <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span> -->
                                  <h5 class="description-header" id="_tequipos"></h5>
                                  <span class="description-text">TOTAL DE EQUIPOS</span>
                                </div>
                                <!-- /.description-block -->
                              </div>
                              <!-- /.col -->
                              <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="description-block border-right">
                                  <!-- <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span> -->
                                  <h5 class="description-header" id="_tpesos"></h5>
                                  <span class="description-text">TOTAL EN PESOS</span>
                                </div>
                                <!-- /.description-block -->
                              </div>
                              <!-- /.col -->
                              <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="description-block border-right">
                                  <!-- <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span> -->
                                  <h5 class="description-header" id="_tdlls"></h5>
                                  <span class="description-text">TOTAL EN DOLARES</span>
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
                              <div class="box box-success">
                                  <div class="box-header with-border">
                                    <h3 class="box-title"> <i class="fa fa-bars" aria-hidden="true"></i>&nbsp; Reporte</h3>
                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>                                                    
                                        </div>
                                    </div>                                 
                                  <div class="box-body table-responsive">                                 
                                    <table id="table_will" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%"> 
                                      <thead>
                                        <tr>
                                          <th>id</th>
                                          <th>Id equipo</th>
                                          <th>Descripción</th>
                                          <th>Marca</th>
                                          <th>Modelo</th>
                                          <th>Serie</th>
                                          <th>Cliente (Sucursal/Departamento)</th>
                                          <th>Fecha de calibración</th>
                                          <th>Vigencia</th>
                                          <th>Fecha de vencimiento</th>
                                          <th>Precio</th>
                                          <th>Precio extra</th>
                                          <th>Moneda</th>
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
                                          <th>Cliente (Sucursal/Departamento)</th>
                                          <th>Fecha de calibración</th>
                                          <th>Vigencia</th>
                                          <th>Fecha de vencimiento</th>
                                          <th>Precio</th>
                                          <th>Precio extra</th>
                                          <th>Moneda</th>
                                          <th>Proceso</th>       
                                        </tr>
                                      </tfoot>
                                    </table> 
                                  </div>
                                  <div class="box-footer">
                                    
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
          $(document).ready(function() { 
            var _tequipos= $('#_tequipos');                      
            var _tpesos= $('#_tpesos');                      
            var _tdlls= $('#_tdlls'); 
            var _rfechas= $('#_rfechas'); 
              _tequipos.text('0');
              _tpesos.text('$ 0');
              _tdlls.text('$ 0');
              _rfechas.text('Rango de fechas:');

           $('#table_will tfoot th').each( function () {
              var title = $(this).text();
              $(this).html( '<input type="text" style="width:100%;font-weight: 400;font-size: 13px;padding: 3px 2px;" placeholder=" '+title+'" />' );
            } );

            var _table= $('#table_will').DataTable({ 
              dom: '<"pull-left"l>fr<"dt-buttons"B>tip',
              buttons: [
                   {
                      extend: 'excel',
                      text: 'Excel',
                      exportOptions: {
                          columns: [':not(:last-child)' ]
                      }
                  }                
              ],                  
              columns: [
                          { data: 'id' },
                          { data: 'equipo_id' },
                          { data: 'descripcion'},
                          { data: 'marca' },
                          { data: 'modelo' },
                          { data: 'serie' },
                          { data: 'cliente' },
                          { data: 'fecha_calibracion' },
                          { data: 'periodo_calibracion' },
                          { data: 'fecha_vencimiento' },
                          { data: 'precio' },
                          { data: 'precio_extra' },
                          { data: 'moneda' },
                          { data: 'proceso' } 
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
                  
                      
            $("#buscar_rc").click ( function(){
              var parametro= {
                  'daterange': $('#daterange-text').val(),
                  'nombre_suc': $("#nombre_suc").val(),
                  'cliente_id': $("#cliente_id").val(),
                  'tipo_busqueda': $("#tipo_busqueda").val(),
                  'multiple_select':$("#multiple_select").val()
                };    

                console.log(parametro);            
                if (validar_select(parametro)) {                                                      
                    $.ajax({
                      type: 'post',
                      url: "?c=reportes&a=ajax_load_clientes",                        
                      data: parametro
                    }).done(function(data) {
                      var datos = data;
                      console.log(datos);
                      if(datos!= "false"){
                        var obj= JSON.parse(datos);                        
                        //console.log(obj[1]); 
                        totales_p_d(obj); //Funcion de totales_Pesos_dolares
                        _table.clear();
                        _table.rows.add(obj).draw();
                        //Morris Charts
                        $.ajax({url: "?c=reportes&a=test", success: function(result){
                          //showgraph();
                          console.log(result);
                        }});                         
                       _rfechas.text('Rango de fechas: ' + parametro['daterange']);
                      } else{
                        alert("Las fechas son más pequeñas que la fecha actual. Por favor verificar.");
                      }
                    }).fail(function(data) {}).always( function(data) {
                      //console.log(data);
                    });                     
                  }
                  else{
                    alert("Alguna opción no esta seleccionado.Por favor verificar.");                  
                  }                    
                });

               function validar_select(parametro)
              {    
               var result= true;
                 if (parametro['nombre_suc']=='' || parametro['cliente_id']=='' || parametro['tipo_busqueda']=='') {
                    result= false;
                 }                
                return result;
              }                            

            function showgraph(){            
            }

            function totales_p_d(obj){
              _tequipos.text('0');
              _tpesos.text('$ 0');
              _tdlls.text('$ 0');
              var sumap=0;
              var sumad=0;
              var equipost= obj.length;
              for (var i = 0 ; i < obj.length; i++) { 
                if(obj[i].moneda=="PESOS"){
                     sumap += parseFloat(obj[i].precio) + parseFloat(obj[i].precio_extra);
                  }
                  else if(obj[i].moneda=="DLLS"){
                    sumad += parseFloat(obj[i].precio) + parseFloat(obj[i].precio_extra);
                  }
              }
              _tequipos.text(equipost);
              _tpesos.text('$ '+ sumap.toFixed(2));
              _tdlls.text('$ '+ sumad.toFixed(2));
            }

          });
        </script>
        <script>
          var ctx = document.getElementById("areaChart").getContext('2d');
          var myChart = new Chart(ctx, {
             type: 'line',
              data: {
                  labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                  datasets: [{
                      label: '# of Votes',
                      data: [12, 19, 3, 5, 2, 3],
                      backgroundColor: [
                        'rgba(255, 99, 132, 0.2)'
                      ],
                      borderWidth: 1
                  }]
              },
              options: {
                  scales: {
                      yAxes: [{
                          stacked: true
                      }]
                  }
              }
          });
        </script>
   
    </body>
          
</html>