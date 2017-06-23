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
                    <?php  if(isset($str)){ ?>
                      <h1>Resultados encontrados <strong>'<?php echo $str; ?>'</strong></h1>
                    <?php } else { ?>
                      <h1>Ingresar un campo para buscar</h1>
                    <?php } ?>
                </section>
                <section class="content">
                    <div class="row">
                      <div class="col-md-3">

          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Filtrar resultados</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool">
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="#"><i class="fa fa-star-o"></i> Todo</a>
                </li>
                <li><a href="#"><i class="fa fa-user-o"></i> Usuarios
                  <span class="label label-primary pull-right"><?php
                  if(isset($data)){
                    echo (count($data['usuario'])); 
                  }
                  ?></span></a></li>
                <li><a href="#"><i class="fa fa-files-o"></i> Informes
                  <span class="label label-danger pull-right">0</span></a></li>
                </a></li>
                <li><a href="#"><i class="fa fa-file-text-o"></i> Empresas
                <span class="label label-danger pull-right">0</span></a></li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
                        <div class="col-xs-9">
                            <ul class="timeline">
                            <!-- Renderizar resultados de usuarios -->
                            <?php
                            if(isset($data)){
                              if(count($data['usuario'])>0){
                                for ($i=0; $i < count($data['usuario']); $i++) {
                                  echo '<li>';
                                  if($i==0){
                                    echo '<i class="fa fa-user bg-blue"></i>';
                                  } 
                                    ?>
                                    <div class="timeline-item">
                                        <span class="time bg-primary"><a style="color:#FFF;" href="?c=usuarios&a=edit&p=<?php echo $data['usuario'][$i]['id'] ?>">Editar</a></span>
                                        <h3 class="timeline-header"><a href="?c=usuarios&a=edit&p=<?php echo $data['usuario'][$i]['id'] ?>"><?php echo $data['usuario'][$i]['nombre'] .' '. $data['usuario'][$i]['apellido']; ?></a> - <?php echo $data['usuario'][$i]['empresa']; ?></h3>
                                        <div class="timeline-body">
                                          <a href="storage/avatares/<?php echo $data['usuario'][$i]['imagen'];  ?>" data-lightbox="perfil"><img src="storage/avatares/<?php echo $data['usuario'][$i]['imagen'];  ?>" width="100" height="100" alt="Imagen de perfil" class="img-circle margin pull-left"></a>
                                          <p>Correo: <strong><?php echo $data['usuario'][$i]['email']; ?></strong></p>
                                          <p>Telefono: <strong><?php echo $data['usuario'][$i]['telefono']; ?></strong></p>
                                          <p>Departamento: <strong><?php echo $data['usuario'][$i]['puesto']; ?></strong></p>
                                          <p>Ciudad: <strong><?php echo $data['usuario'][$i]['ciudad']; ?></strong></p>
                                        </div>
                                    </div>
                                </li>
                                    <?php
                                }
                              }
                            }
                            ?>

                            <?php
                            if(isset($data)){
                              if(count($data['informe'])>0){
                                for ($i=0; $i < count($data['informe']); $i++) {
                                  echo '<li>';
                                  if($i==0){
                                    echo '<i class="fa fa-files-o bg-green"></i>';
                                  } 
                                    ?>
                                    <div class="timeline-item">
                                        <span class="time bg-primary"><a style="color:#FFF;" href="?c=usuarios&a=edit&p=<?php echo $data['informe'][$i]['id'] ?>">Editar</a></span>
                                        <h3 class="timeline-header"><a href="?c=usuarios&a=edit&p=<?php echo $data['informe'][$i]['id'] ?>"><?php echo $data['informe'][$i]['id'] .' '. $data['informe'][$i]['planta']; ?></a> - <?php echo $data['informe'][$i]['descripcion']; ?></h3>
                                        <div class="timeline-body">
                                          <p>Nombre del cliente: <strong><?php echo $data['informe'][$i]['empresa'] . ' - '. $data['informe'][$i]['planta']; ?></strong></p>
                                          <p>Dirección: <strong><?php echo $data['informe'][$i]['direccion']; ?></strong></p>
                                          <p>Descripcion del instrumento: <strong><?php echo $data['informe'][$i]['descripcion'];  ?></strong></p>
                                          <p>Número de identificación: <strong><?php echo $data['informe'][$i]['alias']; ?></strong></p>
                                          <p>Marca: <strong><?php echo $data['informe'][$i]['marca']; ?></strong></p>
                                          <p>Modelo: <strong><?php echo $data['informe'][$i]['modelo']; ?></strong></p>
                                          <p>No. Serie: <strong><?php echo $data['informe'][$i]['serie']; ?></strong></p>
                                          <p>Capturado por: <strong><?php echo $data['informe'][$i]['captura_recepcion_por']; ?></strong></p>
                                        </div>
                                    </div>
                                </li>
                                    <?php
                                }
                              }
                            }
                            ?>
                            <!-- Renderizar resultados de usuarios -->
<!--                                 <li><i class="fa fa-files-o bg-green"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>
                                        <h3 class="timeline-header">
                                          Informe <a href="#">#24056</a> - Torque de presion diferencial - <small>Fluke - 609</small>
                                        </h3>
                                        <div class="timeline-body">
                                         <p>Empresa: <strong>Amphenol Optimize México S. A. de C. V</strong></p>
                                              <p>Tenico que calibro: <strong>Brayan Barrera</strong></p>
                                              <p>Tipo de calibracion: <strong>Externa</strong></p>
                                              <p><a class="btn btn-primary btn-xs btn-flat">Ver Informe</a><span class="pull-right badge bg-blue">Calibracion</span></p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>
                                        <h3 class="timeline-header">
                                          Informe <a href="#">#24056</a> - Torque de presion diferencial - <small>Fluke - 609</small>
                                        </h3>
                                        <div class="timeline-body">
                                         <p>Empresa: <strong>Amphenol Optimize México S. A. de C. V</strong></p>
                                              <p>Tenico que calibro: <strong>Brayan Barrera</strong></p>
                                              <p>Tipo de calibracion: <strong>Externa</strong></p>
                                              <p><a class="btn btn-primary btn-xs btn-flat">Ver Informe</a><span class="pull-right badge bg-blue">Finalizado</span></p>
                                        </div>
                                    </div>
                                </li> -->
                                
                                <li>
                                    <i class="fa fa-clock-o bg-gray"></i>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>
            </div>
            <?php importView('_static.footer'); ?>
        </div>
        <?php importView('_static.scripts'); ?>
    </body>
</html>