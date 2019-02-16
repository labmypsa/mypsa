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
                    <h1><?php echo $this->title; ?><small><?php echo $this->subtitle.' '. $this->sucursal; ?></small></h1>
              </section>
              <section class="content">
                  <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-default">
                                <div class="box-header">
                                    <h3 class="box-title">Proceso De <?php echo $this->title; ?></h3>
                                    <hr>
                                   <div class="progress progress-striped active">                              
                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 25%"> 25%                  
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
                              <div class="box-header">
                                <h3 class="box-title"> Datos de <?php echo $this->title; ?></h3>
                                <div class="box-tools pull-right">
                                  <label>Número de informe : </label>
                                    <?php echo '<input type="hidden" name="id" id="id" value="'.$data['get'][0]['id'] .'">'; ?>
                                    <?php echo '<input type="hidden" name="proceso" id="proceso" value="'.$data['get'][0]['proceso'] .'">'; ?> 
                                    <label data-toggle="tooltip" id="proceso" name="proceso" class="badge bg-green"><?php echo $data['get'][0]['id']; ?></label>
                                </div>
                              </div>
                              <div class="box-body"> 
                                <div class="box-body form-horizontal">
                                      <div class="form-group">
                                        <label class="col-sm-3 control-label">Estado :</label>
                                        <div class="col-sm-9"> 
                                          <label class="checkbox">
                                          <?php                                          
                                          if ($data['get'][0]['calibrado'] === '0') {
                                           echo '<input type="checkbox" class="minimal-red" name="calibrado" value="0" checked>&nbsp; No se calibró';
                                          }
                                          else{echo '<input type="checkbox" class="minimal-red" name="calibrado" value="0">&nbsp; No se calibró';}
                                          ?>                                              
                                          </label>                                           
                                        </div>                                        
                                      </div>
                                      <div class="form-group">
                                        <label class="col-sm-3 control-label">Calibrado por :</label>
                                        <div class="col-sm-9">                                                                                        
                                          <select id="usuarios_calibracion_id" class="form-control select2" style="width: 100%;" name="usuarios_calibracion_id">
                                            <option value="">Seleccione una opción</option> 
                                            <?php
                                            foreach ($data['tecnico'] as $tecnico) {
                                              if($tecnico['roles_id']== '10003' || $tecnico['roles_id']== '10002' || $tecnico['roles_id']== '10004'){
                                                if ($data['get'][0]['usuarios_calibracion_id'] === $tecnico['id']) {
                                                  echo '<option value="'.$tecnico['id'].'" selected="selected">'.$tecnico['nombre'].' '.$tecnico['apellido'].'</option>';
                                                }
                                                else{
                                                 if ($tecnico['plantas_id'] != '758' and Session::get('plantas_id')!= '758') {
                                                           echo '<option value="'.$tecnico['id'].'">'.$tecnico['nombre'].' '.$tecnico['apellido'].'</option>';
                                                          }  
                                                          else if($tecnico['plantas_id'] == '758' and Session::get('plantas_id')== '758'){
                                                              echo '<option value="'.$tecnico['id'].'">'.$tecnico['nombre'].' '.$tecnico['apellido'].'</option>';
                                                          }
                                                }
                                              }
                                            }
                                           ?> 
                                          </select>                                           
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="col-sm-3 control-label">informe hecho por : </label>
                                        <div class="col-sm-9">                                                                                        
                                          <select id="usuarios_informe_id" class="form-control select2" style="width: 100%;" name="usuarios_informe_id">
                                            <option value="">Seleccione una opción</option> 
                                            <?php
                                            foreach ($data['tecnico'] as $tecnico) {
                                              if($tecnico['roles_id']== '10003' || $tecnico['roles_id']== '10002' || $tecnico['roles_id']== '10004'){
                                                  if (strlen($data['get'][0]['usuarios_informe_id']) > 0 and $data['get'][0]['usuarios_informe_id'] === $tecnico['id']) {echo '<option value="'.$tecnico['id'].'" selected="selected">'.$tecnico['nombre'].' '.$tecnico['apellido'].'</option>';
                                                      }
                                                  else if ($data['get'][0]['usuarios_calibracion_id'] === $tecnico['id']) {
                                                   echo '<option value="'.$tecnico['id'].'" selected="selected">'.$tecnico['nombre'].' '.$tecnico['apellido'].'</option>';
                                                  }
                                                  else{
                                                    if ($tecnico['plantas_id'] != '758' and Session::get('plantas_id')!= '758') {
                                                           echo '<option value="'.$tecnico['id'].'">'.$tecnico['nombre'].' '.$tecnico['apellido'].'</option>';
                                                          }  
                                                          else if($tecnico['plantas_id'] == '758' and Session::get('plantas_id')== '758'){
                                                              echo '<option value="'.$tecnico['id'].'">'.$tecnico['nombre'].' '.$tecnico['apellido'].'</option>';
                                                          }
                                                  }
                                              }
                                            }                                              
                                           ?> 
                                          </select>                                           
                                        </div>
                                      </div>                                      
                                      <div class="form-group">
                                        <label class="col-sm-3 control-label">Fecha de cal :</label>
                                        <div class="col-sm-9"> 
                                        <?php 
                                        if (strlen($data['get'][0]['fecha_calibracion']) > 0) {
                                         echo '<input type="text" name="fecha_calibracion" id="fecha_calibracion" class="form-control pull-right datepicker_aux" value="'.$data['get'][0]['fecha_calibracion'].'">';
                                        }
                                        else{echo '<input type="text" name="fecha_calibracion" id="fecha_calibracion" class="form-control pull-right datepicker">';}                                        
                                        ?>
                                        </div>                                        
                                      </div>
                                      <div class="form-group">
                                        <label class="col-sm-3 control-label">Acreditación : </label>
                                        <div class="col-sm-9">                                                                                        
                                          <select name="acreditaciones_id" id="acreditaciones_id" class="form-control select2" style="width: 100%;">
                                               <option value="">Seleccione una opción</option> 
                                               <?php
                                                foreach ($data['acreditacion'] as $acreditacion) {
                                                  if ($data['get'][0]['acreditaciones_id'] === $acreditacion['id']) {
                                                    echo '<option value="'. $acreditacion['id'] .'" selected="selected">'.$acreditacion['nombre'].'</option>';
                                                  }
                                                  else{echo '<option value="'. $acreditacion['id'] .'">'.$acreditacion['nombre'].'</option>'; }
                                                }
                                               ?>                                           
                                          </select>                                              
                                        </div>
                                      </div>
                                      <!-- <div class="form-group">
                                          <label class="col-sm-3 control-label">Vigencia:</label>
                                          <div class="col-sm-9">
                                          <?php 
                                          // if (strlen($data['get'][0]['periodo_calibracion']) > 0 ) {
                                          //   echo '<input type="number" class="form-control" name="periodo_calibracion" id="periodo_calibracion" placeholder="0" min="0" value="'.$data['get'][0]['periodo_calibracion'] .'">';
                                          // }
                                          // else{ echo '<input type="number" class="form-control" name="periodo_calibracion" id="periodo_calibracion" placeholder="0" min="0">';}
                                          ?>
                                          </div>
                                      </div> -->
                                      <div class="form-group">
                                        <label class="col-sm-3 control-label">Vigencia (Mes/Día):</label>
                                        <div class="col-sm-9">
                                          <div class="input-group input">
                                            <!-- /btn-group -->
                                            <?php 
                                              if (strlen($data['get'][0]['periodo_calibracion']) > 0 ) {
                                                echo '<input type="number" class="form-control" name="periodo_calibracion" id="periodo_calibracion" placeholder="0" min="0" value="'.$data['get'][0]['periodo_calibracion'] .'">';
                                              }
                                              else{ echo '<input type="number" class="form-control" name="periodo_calibracion" id="periodo_calibracion" placeholder="0" min="0">';}
                                            ?>

                                            <div class="input-group-btn">
                                              <?php 
                                                echo  $data['periodo'];                                       
                                                echo '<select name="periodo_id" id="periodo_id" class="form-control" style="width:100px">';
                                                for ($i=0; $i < sizeof($data['periodo']); $i++) {
                                                  $value=$data['periodo'][$i]['id'];
                                                  if ($value === $data['get'][0]['periodo_id']) {
                                                      echo '<option value="'. $data['periodo'][$i]['id'] .'" selected>'. $data['periodo'][$i]['nombre'] .'</option>';
                                                  }
                                                  else{
                                                    echo '<option value="'. $data['periodo'][$i]['id'] .'">'. $data['periodo'][$i]['nombre'] .'</option>';
                                                  }  
                                                }                                              
                                                echo '</select>';
                                              ?>
                                            </div>                                         
                                          </div>
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
                                          if ($data['get'][0]['proceso'] != 1) {
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
                        <div class="box box-default">                                 
                              <div class="box-header">
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
        </div>
        <script>
            var controller = "<?php echo $this->name; ?>";   
        </script>
        <?php importView('_static.scripts'); ?>
    </body>
</html>