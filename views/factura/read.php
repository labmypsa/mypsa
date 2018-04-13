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
                                    <div class="progress-bar progress-bar-default" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 75%"> 75%                  
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
                                 <div class="box-header ">
                                    <h3 class="box-title">Datos de <?php echo $this->title; ?></h3>
                                    <div class="box-tools pull-right">
                                      <label>Número de informe : </label>
                                      <?php echo '<input type="hidden" name="id" id="id" value="'.$data['get'][0]['id'] .'">'; ?>
                                      <?php echo '<input type="hidden" name="proceso" id="proceso" value="'.$data['get'][0]['proceso'] .'">'; ?> 
                                      <label data-toggle="tooltip" id="proceso" name="proceso" class="badge bg-green"><?php echo $data['get'][0]['id']; ?></label>&nbsp; <button onclick="opciones_factura('registrar')" class="btn btn-success btn-xs pull-right" id="btn_registrar_factura">Registrar</button>
                                      <button onclick="opciones_factura('no_registrar')" class="btn btn-danger btn-xs pull-right" id="btn_noregistrar_factura">No registrar</button>                                    
                                    </div>                                
                                  </div> 
                                  <div class="box-body">
                                    <div class="box-body form-horizontal">
                                        <div class="form-group">
                                          <label  class="col-sm-3 control-label"># Factura :</label>
                                          <div class="col-sm-9">
                                          <?php   
                                              if(is_null($data['get'][0]['factura']) === false){
                                                echo '<input type="text" class="form-control" name="factura" id="factura" value="'. strtoupper($data['get'][0]['factura']).'">';
                                              }
                                              else{ echo '<input type="text" class="form-control"  placeholder="X123" name="factura" id="factura" >';}
    
                                            ?>
                                          </div>
                                        </div>     
                                        <div class="form-group">
                                          <label class="col-sm-3 control-label">Precio : $</label>
                                          <div class="col-sm-9">
                                            <?php
                                              if(is_null($data['get'][0]['precio']) === false){
                                                echo '<input type="number" class="form-control"  placeholder="0" name="precio" id="precio" value="'.$data['get'][0]['precio'].'" required min="0">';
                                              }
                                                else{echo '<input type="number" class="form-control"  placeholder="0" name="precio" id="precio" required min="0" value="0">';}
                                            ?>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label  class="col-sm-3 control-label">Precio extra : $</label>
                                          <div class="col-sm-9">
                                            <?php
                                              if(is_null($data['get'][0]['precio_extra'])=== false){
                                                echo '<input type="number" class="form-control"  placeholder="0" name="precio_extra" id="precio_extra" value="'.$data['get'][0]['precio_extra'].'" required min="0">';
                                              }
                                                else{ echo '<input type="number" class="form-control"  placeholder="0" name="precio_extra" id="precio_extra" required min="0" value="0">'; }
                                            ?>
                                          </div>
                                        </div> 
                                        <div class="form-group">
                                          <label class="col-sm-3 control-label">Moneda : </label>
                                          <div class="col-sm-9">                                                                                        
                                              <select class="form-control select2" style="width: 100%;" name="monedas_id" id="monedas_id" required>
                                                <?php
                                                  if(is_null($data['get'][0]['monedas_id'])=== false){
                                                    if(intval($data['get'][0]['monedas_id']) === 1){
                                                      echo '<option selected="selected" value="1">Pesos</option>';
                                                      echo '<option value="2">Dolares</option>';
                                                    }
                                                    else{
                                                      echo '<option value="1">Pesos</option>';
                                                      echo '<option selected="selected" value="2">Dolares</option>';}
                                                  }
                                                    else{
                                                      echo '<option selected="selected" value="1">Pesos</option>';
                                                      echo '<option value="2">Dolares</option>';
                                                    }
                                                ?>

                                              </select>                                           
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
                                                if ($data['get'][0]['proceso'] != 3) {
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