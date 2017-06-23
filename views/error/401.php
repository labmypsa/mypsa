<!DOCTYPE html>
<html>
    <head>
        <?php importView('_static.head'); ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php importView('_static/header'); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>Error de página 401</h1>
                </section>
                <section class="content">

                    <div class="error-page">
                        <h2 class="headline text-yellow">401</h2>

                        <div class="error-content">
                            <h3><i class="fa fa-warning text-yellow"></i> Usuario inhabilitado</h3>
                            <p>Al parecer tu cuenta se encuentra temporalmente deshabilitada. Favor de contactar al equipo de soporte para resolver este problema</p>
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