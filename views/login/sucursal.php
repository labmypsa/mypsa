<!DOCTYPE html>
<html>
    <head>
        <?php importView('_static.head'); ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php importView('_static/header'); ?>
            <?php importView('_static/sidebar'); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>Selección <small>de sucursal</small></h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-md-4">
                          <!-- Widget: user widget style 1 -->
                          <div class="box box-widget widget-user">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-aqua-active">
                              <h3 class="widget-user-username">Sucursal</h3>
                              <h5 class="widget-user-desc">Nogales</h5>
                            </div>
                            <div class="box-footer">
                                <div class="row">
                                    <div class="col-sm-4 border-right">
                                      <div class="description-block">
                                        <h5 class="description-header"><?php echo $data['result'][0][0]['count']; ?></h5>
                                        <span class="description-text">Eq. Calibración</span>
                                      </div>
                                      <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 border-right">
                                      <div class="description-block">
                                        <h5 class="description-header"><?php echo $data['result'][0][1]['count']; ?></h5>
                                        <span class="description-text">Eq. Salida</span>
                                      </div>
                                      <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4">
                                      <div class="description-block">
                                        <h5 class="description-header"><?php echo $data['result'][0][2]['count']; ?></h5>
                                        <span class="description-text">Eq. Facturación</span>
                                      </div>
                                      <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                </div>                                                                                 
                              <!-- /.row -->                             
                            </div>                            
                            <ul class="nav nav-stacked">                               
                                <li>                                    
                                    <input type="button" class="btn bg-aqua-active btn-block btn-sm"  value="Más información" id="nogales">
                                </li>            
                            </ul>                            
                          </div>
                          <!-- /.widget-user -->
                        </div> 
                        <!-- /.col -->
                        <div class="col-md-4">
                          <!-- Widget: user widget style 1 -->
                          <div class="box box-widget widget-user">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-green">
                              <h3 class="widget-user-username">Sucursal</h3>
                              <h5 class="widget-user-desc">Hermosillo</h5>
                            </div>                            
                            <div class="box-footer">
                                <div class="row">
                                    <div class="col-sm-4 border-right">
                                      <div class="description-block">
                                        <h5 class="description-header"><?php echo $data['result'][1][0]['count']; ?></h5>
                                        <span class="description-text">Eq. Calibración</span>
                                      </div>
                                      <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 border-right">
                                      <div class="description-block">
                                        <h5 class="description-header"><?php echo $data['result'][1][1]['count']; ?></h5>
                                        <span class="description-text">Eq. Salida</span>
                                      </div>
                                      <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4">
                                      <div class="description-block">
                                        <h5 class="description-header"><?php echo $data['result'][1][2]['count']; ?></h5>
                                        <span class="description-text">Eq. Facturación</span>
                                      </div>
                                      <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                </div>                                                                                 
                              <!-- /.row -->
                            </div>
                          <ul class="nav nav-stacked">
                                <li>                                    
                                    <input type="button" class="btn bg-green btn-block btn-sm"  value="Más información" id="hermosillo">
                                </li>            
                            </ul>
                          </div>
                          <!-- /.widget-user -->    
                        </div>      
                        <!-- /.col -->
                        <div class="col-md-4">
                          <!-- Widget: user widget style 1 -->
                          <div class="box box-widget widget-user">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-black">
                              <h3 class="widget-user-username">Sucursal</h3>
                              <h5 class="widget-user-desc">Guaymas</h5>
                            </div>                    
                            <div class="box-footer">
                                <div class="row">
                                    <div class="col-sm-4 border-right">
                                      <div class="description-block">
                                        <h5 class="description-header"><?php echo $data['result'][2][0]['count']; ?></h5>
                                        <span class="description-text">Eq. Calibración</span>
                                      </div>
                                      <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 border-right">
                                      <div class="description-block">
                                        <h5 class="description-header"><?php echo $data['result'][2][1]['count']; ?></h5>
                                        <span class="description-text">Eq. Salida</span>
                                      </div>
                                      <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4">
                                      <div class="description-block">
                                        <h5 class="description-header"><?php echo $data['result'][2][2]['count']; ?></h5>
                                        <span class="description-text">Eq. Facturación</span>
                                      </div>
                                      <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                </div>                                                                                 
                              <!-- /.row -->
                            </div>
                            <ul class="nav nav-stacked">
                                <li>                                    
                                    <input type="button" class="btn bg-black btn-block btn-sm"  value="Más información" id="guaymas">
                                </li>            
                            </ul> 
                          </div>
                          <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->
                    </div> 
                </section>
            </div>                   
            <?php importView('_static/footer'); ?>
        </div>
        <?php importView('_static/scripts'); ?>
        <script type="text/javascript">
          $(document).ready(function() { 
              $(document).on('click', 'input[type="button"]', function(event) {
                let var1 = this.id;
                var parametro= {
                'var1': var1
                };               
               //console.log(parametro['var1']);
              $.ajax({
              data:parametro,
              url: "?c=login&a=edit_sucursal",
              type: 'post',
              success : function(response){
                  //console.log(response); 
                  var url='?c=informes&a=proceso';
                  window.open(url);               
                  return false;
                }
              });                  
              });
          });          
        </script>
    </body>
</html>