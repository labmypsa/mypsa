<!DOCTYPE html>
<html>
    <head>
        <?php importView('_static.head'); ?> 
    </head>
    <body class="hold-transition skin-blue sidebar-mini"  onLoad="ultimo_numero_salida()">
        <div class="wrapper">
            <?php importView('_static.header'); ?>
            <?php importView('_static.sidebar'); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1><?php echo $this->title; ?><small><?php echo $this->subtitle; ?></small></h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-default">
                                <div class="box-header">
                                    <h3 class="box-title">Proceso De <?php echo $this->title; ?></h3>
                                    <hr>
                                   <div class="progress progress-striped active">                              
                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%"> 50%                  
                                    </div>                                     
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">                                
                                </div>                            
                             </div>                                                
                        </div>
                    </div>
                    <?php if ($error = Flash::hasError()) { ?>
                      <div class="alert alert-warning alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <h4><i class="icon fa fa-warning"></i> <?php echo $error['title']; ?> #<?php echo $error['id']; ?> </h4>
                          <ul><?php
                              foreach ($error['data'] as $err) {
                                  echo '<li>' . $err['msg'] . '</li>';
                              }
                              ?></ul>
                      </div>
                    <?php } ?>
                    <form method="POST" novalidate="" autocomplete="off"  action="?c=<?php echo $this->name; ?>&a=store" role="form" enctype="multipart/form-data">                                     
                      <div class="row">                   
                        <div class="col-lg-6">
                            <div class="box box-default">                                 
                                <div class="box-header with-border">
                                    <h3 class="box-title">Datos de <?php echo $this->title; ?></h3>
                                    <div class="box-tools pull-right">
                                      <label>Número de informe : </label>
                                          <?php echo '<input type="hidden" name="id" id="id" value="'.$data['get'][0]['id'] .'">'; ?>
                                          <?php echo '<input type="hidden" name="proceso" id="proceso" value="'.$data['get'][0]['proceso'] .'">'; ?> 
                                      <label data-toggle="tooltip" id="proceso" name="proceso" class="badge bg-green"><?php echo $data['get'][0]['id']; ?></label>
                                      <label>Último número de salida: </label>
                                          <span data-toggle="tooltip" id="ultimo_hojasalida" title="Último número de salida" class="badge bg-yellow"></span> 
                                    </div>
                                </div> 
                                <div class="box-body"> 
                                  <div class="box-body form-horizontal">
                                    <div class="form-group">
                                          <label class="col-sm-3 control-label"></label>
                                          <div class="col-sm-9">                                                                                        
                                            <?php
                                              if($data['get'][0]['po_id']== 'pendiente'){
                                              echo '<div class="alert alert-warning  alert-dismissible">';
                                              echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                                              echo '<h4><i class="icon fa fa-warning"></i> Alerta!</h4>'; 
                                              echo 'Existe P.O pendiente no se podra avanzar al proceso de factura.</div>';              
                                              }
                                            ?>                                       
                                          </div>
                                    </div>
                                    <div class="form-group" id="alerta_hojasalida"><label class="col-sm-3 control-label"># Hoja de salida :</label>
                                          <div class="col-sm-9">
                                            <div class="input-group">
                                              <?php 
                                                  if (is_null($data['get'][0]['numero_hoja_salida']) === false) {
                                                    echo ' <input type="text" name="hojas_salida_id" id="hojas_salida_id" class="form-control" minlength="4" maxlength="7"  placeholder="# hoja de salida" value="'. $data['get'][0]['numero_hoja_salida'] .'" required>';
                                                  }
                                                  else{echo ' <input type="text" name="hojas_salida_id" id="hojas_salida_id" class="form-control" minlength="4" maxlength="7" placeholder="# hoja de salida" required>';}
                                              ?>
                                                <span class="input-group-btn">
                                                    <button type="button" name="buscar" id="buscar_hoja_salida" class="btn btn-flat"> <i class="fa fa-magic"></i>&nbsp; Buscar </button> 
                                                </span> 
                                            </div>
                                          </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-sm-3 control-label">Registrado por : </label>
                                      <div class="col-sm-9">                                                                                        
                                        <select id="usuario_hoja_salida" class="form-control select2" style="width: 100%;" name="usuario_hoja_salida" required>
                                          <option value="">Seleccione una opción</option> 
                                          <?php                                           
                                          foreach ($data['registradopor'] as $registradopor) {
                                            if ($data['get'][0]['usuario_hoja_salida'] === $registradopor['id']) {
                                              echo '<option value="'.$registradopor['id'].'" selected="selected">'.$registradopor['nombre'].' '.$registradopor['apellido'].'</option>';
                                            }
                                            else{ echo '<option value="'.$registradopor['id'].'">'.$registradopor['nombre'].' '.$registradopor['apellido'].'</option>'; }  
                                            }                                       
                                          ?> 
                                        </select>                                           
                                      </div>
                                    </div>                                      
                                    <div class="form-group">
                                      <label class="col-sm-3 control-label">Fecha de salida :</label>
                                      <div class="col-sm-9"> 
                                      <?php
                                        if (is_null($data['get'][0]['fecha']) === false) {
                                         echo '<input type="text" name="fecha" id="fecha" class="form-control pull-right datepicker_aux" value="'. $data['get'][0]['fecha'] .'" required>';
                                        }
                                        else{echo ' <input type="text" name="fecha" id="fecha" class="form-control pull-right datepicker" required>';}
                                      ?>
                                      </div>                                        
                                    </div>
                                    <!-- El check de entregado sera true si el campo fecha_entrega esta lleno -->
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                        <label class="checkbox">
                                          <?php                                              
                                          if (is_null($data['get'][0]['fecha_entrega']) === true) {
                                           echo '<input type="checkbox" class="minimal" name="fecha_entrega" value="1">&nbsp; Equipo entregado';
                                          }
                                          else{echo '<input type="checkbox" class="minimal" name="fecha_entrega" value="1" checked>&nbsp; Equipo entregado';}
                                          ?>                                              
                                          </label>
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                      <label for="inputcomentario" class="col-sm-3 control-label">Comentarios :</label>
                                      <div class="col-sm-9">
                                        <?php 
                                        if (strlen($data['get'][0]['comentarios'])> 0){
                                            echo '<textarea class="form-control" rows="4" name="comentarios" placeholder="Comentarios ...">'.$data['get'][0]['comentarios'].'</textarea>';
                                          }
                                        else {echo '<textarea class="form-control" rows="4" name="comentarios" placeholder="Comentarios ..." ></textarea>';}
                                      ?> 
                                      </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-3"> </div>
                                        <div class="col-sm-9"> 
                                          <?php
                                          if ($data['get'][0]['proceso'] != 2) {
                                            echo '<button type="submit" class="btn btn-info btn-block pull-right">Actualizar</button>';
                                          }
                                            else{echo '<button type="submit" class="btn btn-info btn-block pull-right">Guardar</button>';}
                                          ?>                                            
                                        </div>
                                    </div>
                                  </div>                                     
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6"> 
                          <div class="box box-default"> <div class="box-header">
                                  <h3 class="box-title"> Datos del equipo</h3>
                                </div>
                                <div class="box-body"> 
                                  <div class="box-body form-horizontal">
                                        <div class="form-group">
                                          <label class="col-sm-3 control-label">Id:</label>
                                          <div class="col-sm-9">
                                          <input type="text" class="form-control" disabled="" value="<?php echo $data['equipo'][0]['alias']; ?>">
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="col-sm-3 control-label">Marca:</label>
                                          <div class="col-sm-9">
                                          <input type="text" class="form-control" disabled="" value="<?php echo $data['equipo'][0]['marca']; ?>">
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="col-sm-3 control-label">Modelo:</label>
                                          <div class="col-sm-9">
                                          <input type="text" class="form-control" disabled="" value="<?php echo $data['equipo'][0]['modelo']; ?>">
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="col-sm-3 control-label">Descripción:</label>
                                          <div class="col-sm-9">
                                          <input type="text" class="form-control" disabled="" value="<?php echo $data['equipo'][0]['descripcion']; ?>">
                                          </div>
                                        </div>
                                  </div>
                                </div>
                          </div>
                        </div>
                        <div class="col-lg-6">
                        <div class="box box-default">                                 
                              <div class="box-header">
                                <h3 class="box-title"> Datos del cliente</h3>
                              </div>
                              <div class="box-body"> 
                                <div class="box-body form-horizontal">
                                      <div class="form-group">
                                        <label class="col-sm-3 control-label">Empresa :</label>
                                        <div class="col-sm-9">
                                        <input type="text" class="form-control" disabled="" value="<?php echo $data['cliente'][0]['cliente']; ?>">
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="col-sm-3 control-label">Dirección:</label>
                                        <div class="col-sm-9">
                                        <input type="text" class="form-control" disabled="" value="<?php echo $data['cliente'][0]['direccion']; ?>">
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="col-sm-3 control-label">Télefono:</label>
                                        <div class="col-sm-9">
                                        <input type="text" class="form-control" disabled="" value="<?php echo $data['cliente'][0]['telefono']; ?>">
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="col-sm-3 control-label">Email:</label>
                                        <div class="col-sm-9">
                                        <input type="text" class="form-control" disabled="" value="<?php echo $data['cliente'][0]['email']; ?>">
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="col-sm-3 control-label">Contacto:</label>
                                        <div class="col-sm-9">
                                        <input type="text" class="form-control" disabled="" value="<?php echo $data['cliente'][0]['contacto']; ?>">
                                        </div>
                                      </div>
                                </div>
                              </div>
                        </div>
                    </div> 
                      </div>      
                    </form> 
                </section>
            </div>                                               
        </div>
            <?php importView('_static.footer'); ?>        
        <script>
            var controller = "<?php echo $this->name; ?>";           
        </script>
        <?php importView('_static.scripts'); ?>
    </body>
</html>