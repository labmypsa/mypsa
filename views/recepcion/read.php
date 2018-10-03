<!DOCTYPE html>
<html>
    <head>
        <?php importView('_static.head'); ?>
        <style type="text/css">                        
        </style>   
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
       <!--  <body class="hold-transition skin-blue sidebar-mini"> -->
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
                                   <div class="progress progress-striped active">  <!-- [{0-0%,recepción},{1-25%,calibracion},{2-50%,salida},{3-75%,factura},{4-100%,bitacora}]-->                           
                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 1%">                  
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
                    <!-- Consulta del id del equipo/ generar número de informe-->                    
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="box box-default">
                              <div class="box-header">                                    
                                  <h3 class="box-title"> Buscar equipo </h3>
                                    <div class="box-tools">                                        
                                    </div>
                              </div>
                              <div class="box-body form-horizontal">
                                <div class="form-group" id="alerta_idequipo">
                                  <label for="idequipo" class="col-sm-3 control-label">Equipo :</label>
                                  <div class="col-sm-9">                                       
                                    <div class="input-group">                                  
                                        <input type="text" id="idequipo" class="form-control" placeholder="id" required="" autofocus="">
                                        <div class="input-group-btn">
                                        <button type="button" class="btn btn-default" id="buscar_idequipo"> <i class="fa fa-search"></i> &nbsp; Buscar</button>
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                          </button>
                                          <ul class="dropdown-menu" role="menu">
                                            <li class="divider"></li>
                                          <li><a href="?c=recepcion&a=volumen" target="_blank"> <i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp; Equipos por volumen</a></li>  <li class="divider"></li>
                                            <li><a href="?c=equipos&a=add" target="_blank"><i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp; Agregar equipo</a></li> 
                                            <li class="divider"></li>
                                          </ul>                  
                                        </div>             
                                    </div>                                                                 
                                  </div> 
                                </div> 
                              </div>
                              <div id="overlay">
                                     <i id="refresh" ></i> 
                              </div> 
                            </div>                       
                        </div>
                        <div class="col-lg-6">
                            <div class="box box-default">                                 
                                <div class="box-header with-border">
                                    <h3 class="box-title">Informe</h3>
                                    <div class="box-tools pull-right">
                                      <label>Último informe : </label>
                                        <span data-toggle="tooltip" title="Último informe" id="ultimo_informe" class="badge bg-yellow"></span> 
                                        &nbsp;
                                        <button class="btn btn-box-tool" id="refresh_informe"><i class="fa fa-refresh"></i></button>
                                        <?php echo '<input type="hidden" name="proceso" id="proceso" value="'.$data['get'][0]['proceso'] .'">'; ?> 
                                    </div>
                                </div>                                 
                                <div class="box-body form-horizontal"> 
                                  <div class="form-group" id="alerta_informe">
                                    <label for="numero_informe" class="col-sm-3 control-label">Informe :</label>
                                    <div class="col-sm-9">    
                                      <div class="input-group">
                                      <?php
                                          if (strlen($data['get'][0]['id']) > 0) {
                                          echo '<input type="text" name="id" id="numero_informe" class="form-control"  placeholder="#000" readonly value="'.$data['get'][0]['id'].'">';
                                          echo '<span class="input-group-btn">';
                                          echo '<button type="button" name="generar_informe" id="btn_generar_informe" class="btn btn-flat" disabled> <i class="fa fa-magic"></i>&nbsp; Generar informe </button> </span>';                                          
                                          }
                                          else{
                                          echo '<input type="text" name="id" id="numero_informe" class="form-control"  placeholder="#000" readonly>';
                                          echo '<span class="input-group-btn">';
                                          echo '<button type="button" id="btn_generar_informe" class="btn btn-flat" onclick="generar_informe()"> <i class="fa fa-magic"></i>&nbsp; Generar informe </button></span>';
                                          }
                                      ?>
                                      </div>
                                    </div>
                                  </div>
                                    <br>
                                </div>  
                            </div>
                        </div>
                    </div> 
                  <!-- Muesrta el historial de informes que ha tenido el equipo escaneado-->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-default">
                                  <div class="box-header">                                    
                                    <h3 class="box-title"> Historial </h3>                                    
                                  </div>
                                  <div class="box-body table-responsive" style="overflow-y: scroll; height: 200px">
                                    <table id="historial_informes" class="table table-bordered table-striped table-hover" role="grid">
                                    <thead>
                                        <tr role="row">
                                          <th>ok</th>
                                          <th># Informe</th>
                                          <th>id equipo</th>
                                          <th>Descripción</th>
                                          <th>Marca</th>
                                          <th>Modelo</th>
                                          <th>Serie</th>                                          
                                          <th>Empresa</th>                                         
                                          <th>Planta</th>
                                          <th>Vigencia</th>
                                          <th>Acreditación</th>
                                          <th>Proceso</th> 
                                        </tr>
                                        </thead>
                                         <tbody>
                                        </tbody>
                                    </table>    
                                  </div> 
                            </div>                             
                        </div>                      
                    </div>  
                     <!-- Muestra y seleccionar equipo y la empresa-->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="box box-default">                            
                                  <div class="box-header">                                    
                                  <h3 class="box-title"> Equipo </h3>
                                    <div class="box-tools">                                       
                                    </div>
                                  </div>                                  
                                  <div class="box-body table-responsive" style="overflow-y: scroll; height: 130px"> 
                                  <table id="table_equipo"  class="table table-bordered table-striped table-hover dataTable" >
                                    <thead>
                                            <tr>
                                            <th>*</th>
                                            <th>Id</th>
                                            <th>Descripción</th>
                                            <th>Marca</th>
                                            <th>Modelo</th>
                                            <th>Serie</th>
                                            <th>Editar</th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                         <?php 

                                         if(strlen($data['get'][0]['idequipo'])> 0){
                                          echo '<tr>';  
                                          echo '<td ><label> <input type="radio" name="equipos_id" value="'.$data['get'][0]['idequipo'] .'" checked></label></td>'; 
                                          echo '<td >'.$data['get'][0]['equipos_id'] .'</td>';
                                          echo '<td >'.$data['get'][0]['descripcion'] .'</td>';
                                          echo '<td >'.$data['get'][0]['marca'] .'</td>';
                                          echo '<td >'.$data['get'][0]['modelo'] .'</td>';
                                          echo '<td >'.$data['get'][0]['serie'] .'</td>';                                               
                                          echo '<td > <a class="btn btn-block btn-warning btn-sm" target="_blank" href="?c=equipos&a=edit&p='.$data['get'][0]['idequipo'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>';
                                          echo '</tr>';
                                          }
                                         ?>
                                        </tbody>
                                    </table>
                                  </div>                             
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="box box-default">
                                  <div class="box-header">
                                  <h3 class="box-title">Cliente</h3>
                                   <div class="box-tools ">                                       
                                    </div>
                                  </div>
                                  <div class="box-body form-horizontal">                                
                                    <div class="form-group">
                                      <label for="empresa_ajax_r" class="col-sm-3 control-label">Empresa :</label>
                                      <div class="col-sm-9"> 
                                            <select id="empresa_ajax_r" class="form-control select2" style="width: 100%;" required="">
                                              <option value="">Seleccione una empresa</option>
                                                <?php
                                                    foreach ($data['empresa'] as $empresa) {
                                                      if ($data['get'][0]['empresas_id'] === $empresa['id']) {
                                                        echo '<option value="'. $empresa['id'] .'" selected="selected">'.$empresa['nombre'].'</option>'; 
                                                      }else{echo '<option value="'. $empresa['id'] .'">'.$empresa['nombre'].'</option>';}
                                                    }
                                                ?>
                                            </select>                                                                             
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label for="idplanta_ajax_r" class="col-sm-3 control-label">Planta / Sucursal :</label>
                                      <div class="col-sm-9"> 
                                        <select id="idplanta_ajax_r" class="form-control select2" style="width: 100%;" name="plantas_id" required="">
                                              <option value="">Seleccione una opción</option>
                                      <?php 
                                      if (strlen($data['get'][0]['empresas_id'])> 0) {
                                          foreach ($data['planta'] as $planta) {
                                            if ($data['get'][0]['plantas_id'] === $planta['id']) {
                                              echo '<option value="'. $planta['id'] .'" selected="selected">'.$planta['nombre'].'</option>'; 
                                            }else{echo '<option value="'. $planta['id'] .'">'.$planta['nombre'].'</option>';}
                                          }
                                      }
                                      ?>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                            </div>  
                         </div>
                    </div>  
                     <div class="row">
                        <div class="col-lg-6">
                            <div class="box box-default">
                                  <div class="box-header">                                    
                                  <h3 class="box-title"> Datos del equipo para calibración </h3>
                                    <div class="box-tools">                                        
                                    </div>
                                  </div>
                                  <div class="box-body">                                                                                                         
                                    <div class="box-body form-horizontal">
                                        <div class="form-group">
                                          <label for="periodo_calibracion" class="col-sm-3 control-label">Vigencia (Meses):</label>
                                          <div class="col-sm-9">
                                          <?php 
                                          if (strlen($data['get'][0]['periodo_calibracion']) > 0) {
                                            echo '<input type="number" class="form-control" name="periodo_calibracion" id="periodo_calibracion" min="0" placeholder="0" value="'.$data['get'][0]['periodo_calibracion'].'" required="">';
                                          }
                                          else{
                                            echo '<input type="number" class="form-control" name="periodo_calibracion" id="periodo_calibracion" min="0" placeholder="0" required="" value="12">';
                                          }
                                          ?>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="acreditaciones_id" class="col-sm-3 control-label">Acreditación :</label> 
                                          <div class="col-sm-9">
                                                <select name="acreditaciones_id" id="acreditaciones_id" class="form-control select2" style="width: 100%;" required="">
                                                 <option value="">Seleccione una opción</option> 
                                                 <?php
                                                 $encontro = false;
                                                 foreach ($data['acreditacion'] as $acreditacion) {
                                                  if ($data['get'][0]['acreditaciones_id'] === $acreditacion['id']) {
                                                    $encontro = true;
                                                  }
                                                 }
                                                 if ($encontro){
                                                   foreach ($data['acreditacion'] as $acreditacion) {
                                                    if ($data['get'][0]['acreditaciones_id'] === $acreditacion['id']) {
                                                      echo '<option value="'. $acreditacion['id'] .'" selected="selected">'.$acreditacion['nombre'].'</option>';
                                                    }
                                                    else{
                                                      echo '<option value="'. $acreditacion['id'] .'">'.$acreditacion['nombre'].'</option>'; }
                                                    }
                                                 } else{
                                                   foreach ($data['acreditacion'] as $acreditacion) {
                                                      if (14 == $acreditacion['id'] and Session::get('plantas_id')== '758') {
                                                        echo '<option value="'. $acreditacion['id'] .'" selected="selected">'.$acreditacion['nombre'].'</option>';
                                                      }
                                                      else if(1 == $acreditacion['id']){
                                                         echo '<option value="'. $acreditacion['id'] .'" selected="selected">'.$acreditacion['nombre'].'</option>'; 
                                                       }                                                   
                                                        else{
                                                          echo '<option value="'. $acreditacion['id'] .'">'.$acreditacion['nombre'].'</option>';
                                                        }
                                                    }
                                                  }
                                                  ?>                                           
                                                </select>                                           
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="usuarios_calibracion_id" class="col-sm-3 control-label">Técnico a calibrar :</label>
                                          <div class="col-sm-9"> 
                                            <select id="usuarios_calibracion_id" class="form-control select2" style="width: 100%;" name="usuarios_calibracion_id" required="">
                                                  <option value="">Seleccione una opción</option> 
                                                  <?php

                                                  foreach ($data['tecnico'] as $tecnico) {
                                                      if($tecnico['roles_id']== '10003' || $tecnico['roles_id']== '10002' || $tecnico['roles_id']== '10004'){
                                                        if ($data['get'][0]['usuarios_calibracion_id'] === $tecnico['id']) {
                                                          echo '<option value="'.$tecnico['id'].'" selected="selected">'.$tecnico['nombre'].' '.$tecnico['apellido'].'</option>';
                                                        }
                                                        else{
                                                          if ($tecnico['plantas_id'] != '758' and Session::get('plantas_id') != '758') {
                                                           echo '<option value="'.$tecnico['id'].'">'.$tecnico['nombre'].' '.$tecnico['apellido'].'</option>';
                                                          }  
                                                          else if($tecnico['plantas_id'] == '758' and Session::get('plantas_id') == '758'){
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
                                          <label for="calibraciones_id" class="col-sm-3 control-label">Tipo de calibración :</label>
                                          <div class="col-sm-9"> 
                                                <select id="calibraciones_id" class="form-control select2" style="width: 100%;" name="calibraciones_id" required="">
                                                  <option value="">Seleccione una opción</option> 
                                                  <?php
                                                  foreach ($data['tipocalibracion'] as $tipocalibracion) {
                                                    if ($data['get'][0]['calibraciones_id'] === $tipocalibracion['id']) {
                                                      echo '<option value="'.$tipocalibracion['id'].'" selected="selected">'.$tipocalibracion['nombre'].'</option>';
                                                    }
                                                    else{ echo '<option value="'.$tipocalibracion['id'].'">'.$tipocalibracion['nombre'].'</option>'; }
                                                  }
                                                 ?> 
                                                </select>                                           
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="inputcomentario" class="col-sm-3 control-label">Prioridad :</label>
                                          <div class="col-sm-9">
                                           
                                              <?php  
                                                if ($data['get'][0]['prioridad'] === '1') {
                                                  echo '<label style="padding-left: 10%"> <input type="radio" name="prioridad" class="flat-red" value="0">&nbsp;Normal </label>';
                                                  echo '<label style="padding-left: 25%"> <input type="radio" name="prioridad" class="flat-red" value="1" checked>&nbsp;Express </label>';
                                                }
                                                else{
                                                  echo '<label style="padding-left: 10%"> <input type="radio" name="prioridad" class="flat-red" value="0" checked>&nbsp;Normal </label>';
                                                  echo '<label style="padding-left: 25%"> <input type="radio" name="prioridad" class="flat-red" value="1">&nbsp;Express </label>';
                                                }
                                               ?>
                                          </div>
                                        </div> 
                                        <div class="form-group">
                                          <label for="inputcomentario" class="col-sm-3 control-label">Comentarios :</label>
                                          <div class="col-sm-9">
                                          <?php 
                                          if (strlen($data['get'][0]['comentarios'])> 0){
                                              echo '<textarea id="comentario" class="form-control" rows="4" name="comentarios" placeholder="Comentarios ...">'.$data['get'][0]['comentarios'].'</textarea>';
                                            }
                                            else {echo '<textarea id="comentario" class="form-control" rows="4" name="comentarios" placeholder="Comentarios ..." ></textarea>';}
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
                                  <h3 class="box-title">Datos de P.O</h3>
                                   <div class="box-tools">
                                        <button onclick="opciones_po('registrar')" class="btn btn-success btn-xs pull-right" id="btn_registrar_po">Registrar</button> 
                                        <button onclick="opciones_po('pendiente')" class="btn btn-warning btn-xs pull-right" id="btn_pendiente_po">Pendiente</button> 
                                        <button onclick="opciones_po('no_registrar')" class="btn btn-danger btn-xs pull-right" id="btn_noregistrar_po">No registrar</button>                                        
                                    </div>
                                  </div>
                                  <div class="box-body form-horizontal">                                 
                                    <div class="form-group" id="alerta_po">
                                      <label  class="col-sm-3 control-label">P.O :</label>
                                      <div class="col-sm-9">
                                        <div class="input-group">                                        
                                        <input type="text" class="form-control" id="po_id" name="po_id" required="" placeholder="123" value="<?php echo isset($data['get'][0]['po_id']) ? $data['get'][0]['po_id'] : ''; ?>">
                                          <span class="input-group-btn">
                                           <button type="button"  id="buscar_po" class="btn btn-flat" > <i class="fa fa-magic"></i>&nbsp; Buscar </button>
                                          </span>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label for="cantidad" class="col-sm-3 control-label">Equipos en P.O :</label>
                                      <div class="col-sm-9">      
                                        <input type="number" class="form-control" id="cantidad" name="cantidad" min="0" placeholder="0" value="<?php echo isset($data['get'][0]['cantidad']) ? $data['get'][0]['cantidad'] : ''; ?>">
                                      </div>
                                    </div>                                    
                                    <div class="form-group">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9">
                                    <button type="button" class="btn btn-box-tool" id="factura_previa"><i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp; Agregar factura previa</button>                                     
                                     <!-- id del campo = numero_informe -->
                                    </div>
                                    </div>
                                  </div>                                  
                            </div>  
                            <div class="box box-default">
                                  <div class="box-header">
                                  <h3 class="box-title">Hoja de entrada</h3>
                                   <div class="box-tools">
                                        <button onclick="opciones_hoja_entrada('registrar')" class="btn btn-success btn-xs pull-right" id="btn_registrar_hojae">Registrar</button> 
                                        <button onclick="opciones_hoja_entrada('no_registrar')" class="btn btn-danger btn-xs pull-right" id="btn_noregistrar_hojae">No registrar</button>
                                    </div>
                                  </div>
                                  <div class="box-body form-horizontal">                                 
                                    <div class="form-group" id="alerta_hojaentrada">
                                      <label class="col-sm-3 control-label"># Hoja de entrada:</label>
                                      <div class="col-sm-9">
                                       <div class="input-group">
                                          <input type="text" class="form-control" id="num_hojaent" name="hojas_entrada_id" required="" minlength="4" maxlength="7" placeholder="0000-17" value="<?php echo isset($data['get'][0]['hojas_entrada_id']) ? $data['get'][0]['hojas_entrada_id'] : ''; ?>">
                                          <span class="input-group-btn">
                                            <button type="button" id="buscar_hoja_entrada" class="btn btn-flat"> <i class="fa fa-magic"></i>&nbsp; Buscar </button> 
                                            </span> 
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label for="usuarios_id" class="col-sm-3 control-label">Registrado por:</label>
                                      <div class="col-sm-9">                                                                                        
                                        <select  class="form-control select2" style="width: 100%;" name="usuarios_id" id="usuarios_id" required="">
                                          <option value="">Seleccione una opción</option> 
                                          <?php
                                          //var_dump($data['get'][0]['usuarios_id']);                                                                        
                                          foreach ($data['registradopor'] as $registradopor) {
                                            if ($data['get'][0]['usuarios_id'] === $registradopor['id']) {
                                              echo '<option value="'.$registradopor['id'].'" selected="selected">'.$registradopor['nombre'].' '.$registradopor['apellido'].'</option>';
                                                    }
                                              else{ echo '<option value="'.$registradopor['id'].'">'.$registradopor['nombre'].' '.$registradopor['apellido'].'</option>'; }  
                                          }                                       
                                         ?> 
                                        </select>                                          
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label for="fecha" class="col-sm-3 control-label">Fecha :</label>
                                      <div class="col-sm-9">
                                      <?php                                                                                    
                                        if (strlen($data['get'][0]['fecha']) > 0) {
                                         echo '<input type="text" name="fecha" id="fecha" class="form-control pull-right datepicker_aux" value="'.$data['get'][0]['fecha'].'" required="">';
                                        }
                                        else{echo '<input type="text" name="fecha" id="fecha" class="form-control pull-right datepicker" required="">';} ?>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                     <div class="col-sm-3"></div>
                                     <div class="col-sm-9">
                                      <button type="button" class="btn btn-box-tool pull-right" onclick="downloadCSV({ filename: 'formato.csv' });"><i class="fa fa-download" aria-hidden="true"></i> &nbsp; Descargar formato *.csv</button>                                     
                                     <!-- id del campo = numero_informe -->
                                     </div>
                                     </div>
                                  </div>   
                                  <div class="box-footer">
                                    <?php
                                      if ($data['get'][0]['proceso'] != 0) {
                                        echo '<button type="submit" class="btn btn-info btn-block pull-right">Actualizar</button>';
                                      }
                                      else{echo '<button type="submit" class="btn btn-info btn-block pull-right">Registrar</button>';}
                                    ?>                                     
                                  </div>                               
                            </div>  
                         </div>
                    </div> 
                    </form>                   
                </section>
            </div>                                                      
            <?php importView('_static.footer'); ?>
        </div>    
        <script>
            var controller = "<?php echo $this->name; ?>";   
        </script>
        <script type="text/javascript">                      
            function downloadCSV(args){   
              var data, filename, link;

              var empresa = document.getElementById("empresa_ajax_r");
              var planta = document.getElementById("idplanta_ajax_r");
              var acreditacion = document.getElementById("acreditaciones_id");
              var tecnico = document.getElementById("usuarios_calibracion_id");
              var calibracion = document.getElementById("calibraciones_id");
              var usuario = document.getElementById("usuarios_id");
              //planta_id: $('#idplanta_ajax_r').val(),
              //usuarios_calibracion_id: $('#usuarios_calibracion_id').val(),
              //usuarios_id: $('#usuarios_id').val(),
              var datos= [{                
                    id: "",
                    descripcion: "",
                    marca: "",
                    modelo: "",
                    serie: "",
                    empresa:  empresa.options[empresa.selectedIndex].text,                  
                    planta:  planta.options[planta.selectedIndex].text,                   
                    periodo_calibracion: $('#periodo_calibracion').val(),
                    acreditacion:  acreditacion.options[acreditacion.selectedIndex].text,                    
                    tecnico:  tecnico.options[tecnico.selectedIndex].text,
                   
                    calibracion:  calibracion.options[calibracion.selectedIndex].text,                   
                    prioridad: $("input:radio[name=prioridad]:checked").val(),                   
                    po_id: $('#po_id').val(),
                    cantidad: $('#cantidad').val(),
                    num_hojaent: $('#num_hojaent').val(),
                    usuario:  usuario.options[usuario.selectedIndex].text,
                    
                    fecha: $('#fecha').val()                  
                  }];          

              var csv = convertArrayOfObjectsToCSV({
                  data: datos
              });
              if (csv == null) return;

              filename = args.filename || 'export.csv';

              if (!csv.match(/^data:text\/csv/i)) {
                  csv = csv;
              }
              data = encodeURI(csv);

              link = document.createElement('a');
              link.setAttribute('href','data:text/csv;charset=utf-8,%EF%BB%BF' + data);
              link.setAttribute('download', filename);
              link.click();
                               
            }

            function convertArrayOfObjectsToCSV(args) {
              var result, ctr, keys, columnDelimiter, lineDelimiter, data;

              data = args.data || null;
              if (data == null || !data.length) {
                  return null;
              }

              columnDelimiter = args.columnDelimiter || ',';
              lineDelimiter = args.lineDelimiter || '\n';

              keys = Object.keys(data[0]);

              result = '';
              result += keys.join(columnDelimiter);
              result += lineDelimiter;

              data.forEach(function(item) {
                  ctr = 0;
                  keys.forEach(function(key) {
                      if (ctr > 0) result += columnDelimiter;

                      result += item[key];
                      ctr++;
                  });
                  result += lineDelimiter;
              });

              return result;
            }
        </script>
        <?php importView('_static.scripts'); ?>
    </body>
</html>