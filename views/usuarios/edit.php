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
                    <h1><?php echo $this->title; ?><small><?php echo $this->subtitle; ?></small></h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header  with-border">
                                    <h3 class="box-title">Editar <?php echo $this->name; ?></h3>
                                </div>
                                <div class="box-body">
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
                                    <form method="POST" autocomplete="off" action="?c=<?php echo $this->name; ?>&a=update" role="form"  enctype="multipart/form-data">
                                        <input type="hidden" name="activo" value="1">
                                        <input type="hidden" name="imagen" value="<?php echo $data['usuario'][0]['imagen']; ?>">
                                        <input type="hidden" name="id" value="<?php echo $data['usuario'][0]['id']; ?>">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="id"># de identificación</label>                                                    
                                                <input disabled="" type="text" class="form-control" name="id" id="nombre" placeholder="id" value="<?php echo $data['usuario'][0]['id']; ?>" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="nombre">Nombre</label>                                                    
                                                <input autofocus type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo ucwords($data['usuario'][0]['nombre']); ?>" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="apellido">Apellido</label>                                                    
                                                <input autofocus type="text" class="form-control" name="apellido" id="apellido" placeholder="Apellido" value="<?php echo ucwords($data['usuario'][0]['apellido']); ?>" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="puesto">Puesto</label>                                                    
                                                <input autofocus type="text" class="form-control" name="puesto" id="puesto" placeholder="Puesto" value="<?php echo ucwords($data['usuario'][0]['puesto']); ?>" >
                                            </div>
                                            <div class="form-group">
                                                <label for="telefono">Telefono</label>                                                    
                                                <input autofocus type="tel" minlength="5" class="form-control" name="telefono" id="telefono" placeholder="Telefono" value="<?php echo $data['usuario'][0]['telefono']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Correo</label>                                                    
                                                <input autofocus type="email" class="form-control" name="email" id="email" placeholder="Correo electronico" value="<?php echo $data['usuario'][0]['email']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="empresa_ajax">Empresa</label>
                                                <select autofocus="" id="empresa_ajax" class="form-control select2" style="width: 100%;" required="">
                                                    <option value="">Seleccione una opción</option>
                                                    <?php
                                                    foreach ($data['empresa'] as $empresa) {
                                                        if($empresas_id == $empresa['id']){
                                                            echo '<option selected value="' . $empresa['id'] . '">' . ucwords($empresa['nombre']) . '</option>';
                                                        } else{
                                                            echo '<option value="' . $empresa['id'] . '">' . ucwords($empresa['nombre']) . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="idplanta_ajax">Planta</label>
                                                <select autofocus="" id="idplanta_ajax" class="form-control select2" style="width: 100%;" name="plantas_id" required="">
                                                    <option value="">Seleccione una opción</option>
                                                    <?php
                                                    foreach($data['planta'] as $planta){
                                                        if($data['usuario'][0]['plantas_id'] == $planta['id'] ){
                                                            echo '<option selected value="' . $planta['id'] . '">' . ucwords($planta['nombre']) . '</option>';
                                                        } else{
                                                            echo '<option  value="' . $planta['id'] . '">' . ucwords($planta['nombre']) . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label for="roles_id">Tipo de usuario</label>
                                                <select autofocus="" id="roles_id" class="form-control select2" style="width: 100%;" name="roles_id" required="">
                                                    <option value="">Seleccione una opción</option>
                                                    <?php
                                                    foreach ($data['rol'] as $rol) {
                                                        if ($rol['id'] != '10000') {
                                                            if($data['usuario'][0]['roles_id'] == $rol['id']){
                                                                echo '<option selected value="' . $rol['id'] . '">' . ucwords($rol['nombre']) . '</option>';
                                                            } else{
                                                                echo '<option value="' . $rol['id'] . '">' . ucwords($rol['nombre']) . '</option>';
                                                            }
                                                        }
                                                        elseif (Session::get("rol") == "Administrador") {
                                                            if($data['usuario'][0]['roles_id'] == $rol['id']){
                                                                echo '<option selected value="' . $rol['id'] . '">' . ucwords($rol['nombre']) . '</option>';
                                                            } else{
                                                                echo '<option value="' . $rol['id'] . '">' . ucwords($rol['nombre']) . '</option>';
                                                            }
                                                        }

                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <?php if (isset($_GET['alta'])){
                                                echo "<div class='form-group'>
                                                <label>
                                                  <input type='radio' name='check_email' class='flat-red' checked>
                                                  &nbsp;Enviar correo de confirmación
                                                </label>
                                            </div>"; 
                                                }                                                 
                                            ?>                                            
                                          <div class="form-group">
                                             <label for="avatar">Imagen de perfil</label>
                                             <input type="file" id="avatar" accept="image/jpeg, image/jpg, image/png" name="avatar"/>
                                          </div>
                                        </div>
                                        <div class="box-footer"><button type="submit" class="btn btn-primary btn-flat">Guardar cambios</button> </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php importView('_static/footer'); ?>
        </div>
        <?php importView('_static/scripts'); ?>
    </body>
</html>