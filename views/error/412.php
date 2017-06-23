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
                    <h1>Error de página 412</h1>
                </section>
                <section class="content">

                    <div class="error-page">
                        <h2 class="headline text-red">412</h2>

                        <div class="error-content">
                            <h3><i class="fa fa-warning text-red"></i> Documento no encontrado.</h3>
                            <p>Porfavor</p> 
                            <p><b>Intente más tarde. </b>El sistema está actualizando su información... </p>
            				<p><b>Gracias por su confianza</b></p>
                        </div>
                    </div>
                    <!-- /.error-page -->
                </section>
            </div>
            <?php importView('_static/footer'); ?>
        </div>
        <?php importView('_static/scripts'); ?>
    </body>
</html>