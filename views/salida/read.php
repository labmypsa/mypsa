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
                    <div class="row">
                      <!-- ******** ////////////////////////////////////////////////////////////////// ******** -->
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <form method="POST" novalidate="" autocomplete="off"  action="?c=<?php echo $this->name; ?>&a=store" role="form" enctype="multipart/form-data">
                          <div class="col-lg-12">
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
                                                if($data['get'][0]['po_id'] == 'pendiente'){
                                                echo '<div class="alert alert-warning  alert-dismissible">';
                                                echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                                                echo '<h4><i class="icon fa fa-warning"></i> Alerta!</h4>'; 
                                                echo 'Existe P.O pendiente no se podra avanzar al proceso de factura.</div>';
                                                }
                                              ?>                                       
                                            </div>
                                      </div>
                                      <div class="form-group" id="alerta_hojasalida">
                                        <label class="col-sm-3 control-label"># Hoja de salida :</label>
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
                        </form>
                        <?php
 
                          if(Session::has('rol',['Administrador','Almacén'])){
                          echo"<div class='col-lg-12'>
                                <div class='box box-default'>
                                  <div class='box-header with-border'>
                                    <h3 class='box-title'>Datos de PO</h3>
                                  </div>
                                  <div class='box-body form-horizontal'>";         
                                      if($countpototal > $cantidadpo){
                          echo "<div class='alert alert-danger  alert-dismissible'>
                                      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                                      <h4><i class='icon fa fa-ban'></i> Alerta!</h4>
                                      <p align='center'> La cantidad del PO registrado es diferente.
                                      Según los registros da un total de : <font size='5'><strong>". $countpototal . "</strong> </font>equipos, favor de verificar y corregir.</p></div>";
                                      }        
                          echo     "<div class='table-responsive'>
                                      <table class='table table-bordered'>
                                        <tbody>
                                          <tr>
                                            <th style='width: 20%; text-align: center;'><span data-toggle='tooltip' title='' data-original-title='Orden de compra.'>PO</th>
                                            <th style='width: 20%; text-align: center;'><span data-toggle='tooltip' title='' data-original-title='Total de equipos que corresponden al PO.'> Total </span></th>
                                            <th style='width: 20%; text-align: center;'><span data-toggle='tooltip' title='' data-original-title='Total de equipos que ya se ecuentran facturados.'> Facturados </span></th>
                                            <th style='width: 20%; text-align: center;'><span data-toggle='tooltip' title='' data-original-title='Son los equipos restantes por facturar, se calcula del total de equipos, menos los equipos ya facturados.'> No Facturados </span></th>
                                            <th style='width: 20%; text-align: center;'><span data-toggle='tooltip' title='' data-original-title='Son equipos que ya fueron calibrados, por lo tanto están disponibles para enviar a facturar.'> Pendientes </span></th>
                                          </tr>
                                          <tr>
                                            <td align='center'><span class='badge bg-green'>". $idpo ."</span></td>
                                            <td align='center'><span class='badge bg-green'>". $cantidadpo ."</span></td>
                                            <td align='center'>";                  
                                            $porcentaje = round(($totalfact * 100)/ $cantidadpo);
                                            $pendientes=$cantidadpo-$totalfact;
                          echo              "<div class='progress progress-striped active'><div class='progress-bar progress-bar-primary role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width:". $porcentaje ."%; color:#000000'>". $totalfact ."</div></div>
                                        </td>
                                            <td align='center'><span class='badge bg-red'>". $pendientes ."</span></td>
                                            <td align='center'>";
                                              if($idpo == "pendiente" || $idpo == "n/a" || $idpo == "no existe" || $idpo == "sin orden"){
                                                echo "<a  data-toggle='collapse' aria-expanded='true' class='btn btn-app'><span class='badge bg-purple'>".$countpolisto."</span><i class='fa fa-list'></i>Lista no disponible</a>";
                                              } else {
                                                echo "<a id='buscar_equiPO' data-toggle='collapse' data-parent='#accordion' href='#collapseOne' aria-expanded='true' class='btn btn-app'><span class='badge bg-purple'>".$countpolisto."</span><i class='fa fa-list'></i> Ver lista</a>";
                                              }                                                  
                          echo             "</td>
                                           </tr>                                     
                                         </tbody>
                                       </table>
                                     </div>
                                     <div class='panel box box-primary'>
                                       <div class='box-header with-border'>
                                         <h4 class='box-title'>
                                             <a data-toggle='collapse' data-parent='#accordion' href='#collapseOne' aria-expanded='true' class=''>Lista de equipos</a>
                                         </h4>
                                       </div>
                                       <div id='collapseOne' class='panel-collapse collapse' aria-expanded='true' style=''>
                                         <form role='form' id='frm-example'  method='POST' enctype='multipart/form-data'>
                                           <div class='box-body'>
                                               <div class='table-responsive no-padding'>
                                                 <table id='example' class='table table-bordered' cellspacing='0' width='100%'>
                                                   <thead>
                                                     <tr>                                     
                                                       <th><input name='select_all' value='1' type='checkbox'></th>
                                                       <th>Informe</th>
                                                       <th>Descripción</th>
                                                       <th>Descripción</th>
                                                       <th>Descripción</th>
                                                      <th>Marca</th>
                                                      <th>Modelo</th>
                                                      <th>Serie</th>
                                                    </tr>
                                                  </thead>
                                                  <tfoot>
                                                    <tr>                             
                                                      <th></th>
                                                      <th>Informe</th>
                                                      <th>Id equipo</th>
                                                      <th>Descripción</th>
                                                      <th>Marca</th>
                                                      <th>Modelo</th>
                                                      <th>Serie</th>
                                                    </tr>
                                                  </tfoot>
                                                </table>
                                              </div>                                      
                                              <br>
                                              <label style='padding-bottom: 5px;'' ><input type='checkbox' class='minimal-red' id='check_urgente' name='check_urgente' value='1'>&nbsp; Factura Urgente</label> 
                                              <br>                                               
                                              <label style='margin-bottom: 15px;'>Comentarios: </label>
                                              <textarea id='nota' class='form-control' rows='4' name='nota' placeholder='Comentarios ...'></textarea>                                        
                                              <label style='padding-top: 10px;'' for='exampleInputFile'>PO.</label>
                                              <input class='btn btn-block btn-default btn-sm' type='file' name='filepo' id='filepo'>                                                                
                                              <label for='exampleInputFile'>Cot.</label>
                                              <input class='btn btn-block btn-default btn-sm' type='file' name='filecot' id='filecot'>                                                          
                                              <label for='exampleInputFile'>Pago.</label>
                                              <input class='btn btn-block btn-default btn-sm' type='file' name='filepago' id='filepago'>
                                              <p>Informe(s) enviado(s)</p>
                                              <pre id='example-console-rows'></pre>
                                              <button class='btn btn-info pull-right'>Enviar</button>
                                            </div>                                          
                                            <div class='box-footer'>                                            
                                              <p id='alerta_send'></p>
                                            </div>
                                        </form>
                                      </div>
                                    </div>                
                                  </div>                                    
                              </div>
                           </div>";
                          }
                        ?>           
                        <!-- <div class="col-lg-12">
                            <div class="box box-default">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Datos de PO</h3>                                    
                                </div> 
                                <div class="box-body form-horizontal">
                                  <?php
                                    if($countpototal > $cantidadpo){
                                    echo '<div class="alert alert-danger  alert-dismissible">';
                                    echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                                    echo '<h4><i class="icon fa fa-ban"></i> Alerta!</h4>'; 
                                    echo '<p align="center"> La cantidad del PO registrado es diferente. ';
                                    echo 'Según los registros da un total de : <font size="5"><strong>'. $countpototal . '</strong> </font> equipos, favor de verificar y corregir.</p></div>';
                                    }
                                  ?> 
                                  <div class="table-responsive">
                                    <table class="table table-bordered">
                                      <tbody>
                                        <tr>
                                          <th style="width: 20%; text-align: center;"><span data-toggle="tooltip" title="" data-original-title="Orden de compra.">PO</th>
                                          <th style="width: 20%; text-align: center;"><span data-toggle="tooltip" title="" data-original-title="Total de equipos que corresponden al PO."> Total </span></th>
                                          <th style="width: 20%; text-align: center;"><span data-toggle="tooltip" title="" data-original-title="Total de equipos que ya se ecuentran facturados."> Facturados </span></th>
                                          <th style="width: 20%; text-align: center;"><span data-toggle="tooltip" title="" data-original-title="Son los equipos restantes por facturar, se calcula del total de equipos, menos los equipos ya facturados."> No Facturados </span></th>
                                          <th style="width: 20%; text-align: center;"><span data-toggle="tooltip" title="" data-original-title="Son equipos que ya fueron calibrados, por lo tanto están disponibles para enviar a facturar."> Pendientes </span></th>
                                        </tr>
                                        <tr>
                                          <td align="center"><span class="badge bg-green"> <?php echo $idpo; ?></span></td>
                                          <td align="center"><span class="badge bg-green"> <?php echo $cantidadpo; ?></span></td>
                                          <td align="center">
                                            <?php 
                                             $porcentaje = round(($totalfact * 100)/ $cantidadpo);
                                              echo "<div class='progress progress-striped active'><div class='progress-bar progress-bar-primary' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width:". $porcentaje ."%; color:#000000'>". $totalfact ."</div></div>";
                                            ?>
                                          </td>                                                                          
                                          <td align="center"><span class="badge bg-red"> <?php echo $cantidadpo-$totalfact; ?></span></td>
                                          <td align="center">
                                            <?php   if($idpo == "pendiente" || $idpo == "n/a" || $idpo == "no existe" || $idpo == "sin orden"){
                                            echo "<a  data-toggle=\"collapse\" aria-expanded=\"true\" class=\"btn btn-app\"><span class=\"badge bg-purple\">".$countpolisto."</span><i class=\"fa fa-list\"></i>Lista no disponible</a>"; 
                                              } else {
                                                echo "<a id=\"buscar_equiPO\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseOne\" aria-expanded=\"true\" class=\"btn btn-app\"><span class=\"badge bg-purple\">".$countpolisto."</span><i class=\"fa fa-list\"></i> Ver lista</a>";
                                              }?>                                                  
                                          </td>
                                        </tr>                                      
                                      </tbody>
                                    </table>
                                  </div>
                                  <div class="panel box box-primary">
                                    <div class="box-header with-border">
                                      <h4 class="box-title">
                                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" class="">
                                            Lista de equipos
                                          </a>                  
                                      </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse" aria-expanded="true" style="">
                                      <form role="form" id="frm-example"  method="POST" enctype="multipart/form-data">
                                        <div class="box-body">
                                            <div class="table-responsive no-padding">
                                              <table id="example" class="table table-bordered " cellspacing="0" width="100%">
                                                <thead>
                                                  <tr>                                      
                                                    <th><input name="select_all" value="1" type="checkbox"></th>
                                                    <th>Informe</th>
                                                    <th>Id equipo</th>
                                                    <th>Descripción</th>
                                                    <th>Marca</th>
                                                    <th>Modelo</th>
                                                    <th>Serie</th>
                                                  </tr>
                                                </thead>
                                                <tfoot>
                                                  <tr>                                
                                                    <th></th>
                                                    <th>Informe</th>
                                                    <th>Id equipo</th>
                                                    <th>Descripción</th>
                                                    <th>Marca</th>
                                                    <th>Modelo</th>
                                                    <th>Serie</th>
                                                  </tr>
                                                </tfoot>
                                              </table>
                                            </div>                                            
                                            <br>
                                            <label style="padding-bottom: 5px;" ><input type="checkbox" class="minimal-red" id="check_urgente" name="check_urgente" value="1">&nbsp; Factura Urgente</label> 
                                            <br>                                               
                                            <label style="margin-bottom: 15px;">Comentarios: </label>
                                            <textarea id="nota" class="form-control" rows="4" name="nota" placeholder="Comentarios ..."></textarea>                                         
                                            <label style="padding-top: 10px;" for="exampleInputFile">PO.</label>
                                            <input class="btn btn-block btn-default btn-sm" type="file" name="filepo" id="filepo">                                                                
                                            <label for="exampleInputFile">Cot.</label>
                                            <input class="btn btn-block btn-default btn-sm" type="file" name="filecot" id="filecot">                                                          
                                            <label for="exampleInputFile">Pago.</label>
                                            <input class="btn btn-block btn-default btn-sm" type="file" name="filepago" id="filepago">                               
                                            <p>Informe(s) enviado(s)</p>
                                            <pre id="example-console-rows"></pre>
                                            <button class="btn btn-info pull-right">Enviar</button>
                                          </div>                                          
                                          <div class="box-footer">                                            
                                            <p id="alerta_send"></p>
                                          </div>
                                      </form>
                                    </div>
                                  </div>                
                                </div>                                     
                            </div>
                        </div> -->  
                      </div>
                      <!-- ******** ////////////////////////////////////////////////////////////////// ******** -->
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="col-lg-12">
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
                        <div class="col-lg-12">
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
                    </div> 

                </section>                
            </div>                                                       
            <?php importView('_static.footer'); ?> 
        </div>       
        <script>
            var controller = "<?php echo $this->name; ?>";           
        </script>
        <?php importView('_static.scripts'); ?>      
       <script>  
      /* ***************Inicio********************/
        $(document).ready(function() {    
          /* **************inicio table configuracion************/
          var table= $('#example').DataTable({
            'columnDefs': [
              {
                'targets': 0,                
                'checkboxes': {
                  'selectRow': true
                }
              }
            ],
            'select': {
              'style': 'multi'
            },      
            'order': [1, 'asc'],
            'columns': [
              { 'data': 'id' },
              { 'data': 'pivote' },
              { 'data': 'alias' },
              { 'data': 'descripcion'},
              { 'data': 'marca' },
              { 'data': 'modelo' },
              { 'data': 'serie' }
            ],
          });
          /* **************fin table configuracion************/
/* //////////////////////////////////////////////////////////////////////////// */
            
            // Handle form submission event
        $('#frm-example').on('submit', function(e){
          var form = this;
          var rows_selected = table.column(0).checkboxes.selected();
          var comentarios= document.getElementById("nota").value;         

          //console.log(comentarios);
          // Iterate over all selected checkboxes
          $.each(rows_selected, function(index, rowId){
             // Create a hidden element
              $(form).append(
                 $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', 'id[]')
                    .val(rowId)
              );
          });
          // FOR DEMONSTRATION ONLY
          // The code below is not needed in production          
          // Output form data to a console     
          $('#example-console-rows').text(rows_selected.join());
          
          // Output form data to a console     
          //$('#example-console-form').text($(form).serialize());           
          // Remove added elements
          $('input[name="id\[\]"]', form).remove();           
          // Prevent actual form submission      
          e.preventDefault();
          var parametro = new FormData();

          parametro.append("data",rows_selected.join());
          parametro.append("comentarios",comentarios);
          parametro.append("po", <?php echo "'".$idpo."'"; ?>);
          parametro.append("cliente", <?php echo "'". $cliente ."'"; ?>);
          parametro.append("contacto" , <?php echo "'".$data['cliente'][0]['contacto'] .",". $data['cliente'][0]['email'] . "'"; ?>);
          parametro.append("filepo", $('input[name=filepo]')[0].files[0]);
          parametro.append("filecot", $('input[name=filecot]')[0].files[0]);
          parametro.append("filepago", $('input[name=filepago]')[0].files[0]);
          parametro.append("check_urgente", $("input[name=check_urgente]").is(":checked") ? 1:0);

          // for( var value of parametro.values()){
          //   console.log(value);
          // }                  

          $.ajax({
              url: '?c=salida&a=_sendemail',
              data: parametro,
              processData: false,
              contentType: false,
              type: 'POST',
              dataType:'json',
              success: function(response){
                var datos = response;
                //console.log(datos);
                $("[name='alertas']").remove();                  
                //load json data from server and output message    
                if(datos != "error"){ //load json data from server and output message                                                       
                  $("#alerta_send").before("<div  class='form-group' name='alertas'><div class='col-lg-12 col-md-6 col-sm-12 col-xs-12'><div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4><i class='icon fa fa-check'></i> Alerta!</h4> Envio de Correo Exitoso.</div></div></div>");
                }else{                            
                  $("#alerta_send").before("<div class='form-group' name='alertas'><div class='col-lg-12 col-md-6 col-sm-12 col-xs-12'><div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4><i class='icon fa fa-ban'></i> Alerta!</h4> Hubo un problema al enviar el correo, favor de verificar los datos e interlo una vez mas.</div></div></div>");
                }                
              }
            });          

        });
/* ////////////////////////////////////////////////////////////////////////////////////////////  */            
            $("#buscar_equiPO").click ( function (){
              var parametro= {
                "po":<?php echo "'".$idpo."'"; ?>,
              }; 
              //console.log(parametro['po']);              
                $.ajax({
                  type: 'post',
                  url: "?c=salida&a=ajax_load_listequiPO",                        
                  data: parametro
                }).done(function(data) {
                  var datos = data;
                  //console.log(datos); 
                  var obj= JSON.parse(datos);
                  table.clear();
                  table.rows.add(obj).draw();
                }).fail(function(data) {}).always( function(data) {
                  //console.log(data);
                });                        
            });
/* ///////////////////////////////////////////////////////////////////////////////////////////*/                 
        });
      /* ***************Fin********************/
        </script>
    </body>
</html>