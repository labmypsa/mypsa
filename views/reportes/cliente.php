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
                                                  <select id="cliente_id" class="form-control select2" style="width: 100%;" name="cliente_id">
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
                        <div class="col-lg-12">
                            <div class="box box-default">
                                <div class="box-header">
                                  <h3 class="box-title"> <i class="fa fa-bars" aria-hidden="true"></i>&nbsp; Reporte</h3>
                                    <div class="box-tools">                                        
                                    </div>
                                </div>                                 
                                <div class="box-body">
                                <div class="box-body table-responsive">                                   
                                  <table id="table_reportesc" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%"> 
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
                                                <th>Proceso</th>       
                                            </tr>
                                        </tfoot>
                                    </table>                                                                 
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
          $(document).ready(function() {

         $('#table_reportesc tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" style="width:100%;font-weight: 400;font-size: 13px;padding: 3px 2px;" placeholder=" '+title+'" />' );
        } );
            var _table= $('#table_reportesc').DataTable({             
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
                  'tipo_busqueda': $("#tipo_busqueda").val()
                };
                if (validar_select(parametro)) {                                                      
                    $.ajax({
                      type: 'post',
                      url: "?c=reportes&a=ajax_load_clientes",                        
                      data: parametro
                    }).done(function(data) {
                      var datos = data;
                      //console.log(datos);
                      if(datos!= "false"){
                        var obj= JSON.parse(datos); 
                        _table.clear();
                        _table.rows.add(obj).draw();
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

          });        
</script>
    </body>
          
</html>