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
                     <form method="POST" novalidate="" autocomplete="off"  action="?c=<?php echo $this->name; ?>&a=cliente" role="form" enctype="multipart/form-data">
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
                                                        // foreach ($data['tipocalibracion'] as $tipocalibracion) {
                                                        //  echo '<option value="'.$tipocalibracion['id'].'">'.$tipocalibracion['nombre'].'</option>'; 
                                                        // }
                                                      ?> 
                                                  </select> 
                                            </div>  
                                             <div class="form-group">
                                                <label>Tipo de busqueda:</label>
                                                  	<select id="tipo_busqueda" class="form-control select2" style="width: 100%;" name="tipo_busqueda">
                                                      <option value="">Seleccione una opción</option> 
                                                      <option value="0">Global</option>
                                                      <option value="1">Equipos a vencer</option>
                                                      <option value="2">Equipos vencidos</option> 
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
                                                        <table id="table_reportcliente" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>                                                
                                                                    <th>#</th>                                                                    
					                                                <th>Id equipo</th>
					                                                <th>Descripción</th>
					                                                <th>Marca</th>
					                                                <th>Modelo</th>
					                                                <th>Serie</th>
					                                                <th>Cliente</th>
					                                                <th>Calibración actual</th>
					                                                <th>Vigencia</th>
					                                                <th>Calibración siguiente</th>
					                                                <th># Factura</th>
					                                                <th>Precio</th>
					                                                <th>Extra</th>
					                                                <th>Moneda</th>
					                                                <th>Comentarios</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>                       
                                                             
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>                                               
                                                                    <th>#</th>                                                                    
					                                                <th>Id equipo</th>
					                                                <th>Descripción</th>
					                                                <th>Marca</th>
					                                                <th>Modelo</th>
					                                                <th>Serie</th>
					                                                <th>Cliente</th>
					                                                <th>Calibración actual</th>
					                                                <th>Vigencia</th>
					                                                <th>Calibración siguiente</th>
					                                                <th># Factura</th>
					                                                <th>Precio</th>
					                                                <th>Extra</th>
					                                                <th>Moneda</th>
					                                                <th>Comentarios</th> 
                                                                </tr>
                                                            </tfoot>
                                                        </table>
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
    </body>
          
</html>