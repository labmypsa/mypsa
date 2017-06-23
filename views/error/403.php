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
                    <h1>Error de página 403</h1>
                </section>
                <section class="content">

                    <div class="error-page">
                        <h2 class="headline text-yellow">403</h2>

                        <div class="error-content">
                            <h3><i class="fa fa-warning text-yellow"></i> Sitio no autorizado</h3>
                            <p>Al parecer tu cuenta no cuenta los privilegios para acceder a esta sección. Favor ponerse en contacto con el administrador del sistema.</p>
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