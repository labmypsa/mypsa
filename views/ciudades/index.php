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
                    <h1><?php echo $this->title; ?><small><?php echo $this->subtitle; ?></small></h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Listado de <?php echo $this->name; ?></h3>
                                    <a href="?c=<?php echo $this->name; ?>&a=add" class="btn btn-primary btn-md pull-right btn-flat">Agregar nuevo</a>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
<table cellpadding="3" cellspacing="0" border="0" style="width: 67%; margin: 0 auto 2em auto;">
        <thead>
            <tr>
                <th>Target</th>
                <th>Search text</th>
                <th>Treat as regex</th>
                <th>Use smart search</th>
            </tr>
        </thead>
        <tbody>
            <tr id="filter_global">
                <td>Global search</td>
                <td align="center">
                    <input type="text" class="global_filter" id="global_filter">
                </td>
                <td align="center">
                    <input type="checkbox" class="global_filter" id="global_regex">
                </td>
                <td align="center">
                    <input type="checkbox" class="global_filter" id="global_smart" checked="checked">
                </td>
            </tr>
            <tr id="filter_col1" data-column="0">
                <td>Column - Name</td>
                <td align="center">
                    <input type="text" class="column_filter" id="col0_filter">
                </td>
                <td align="center">
                    <input type="checkbox" class="column_filter" id="col0_regex">
                </td>
                <td align="center">
                    <input type="checkbox" class="column_filter" id="col0_smart" checked="checked">
                </td>
            </tr>
            <tr id="filter_col2" data-column="1">
                <td>Column - Position</td>
                <td align="center">
                    <input type="text" class="column_filter" id="col1_filter">
                </td>
                <td align="center">
                    <input type="checkbox" class="column_filter" id="col1_regex">
                </td>
                <td align="center">
                    <input type="checkbox" class="column_filter" id="col1_smart" checked="checked">
                </td>
            </tr>
            <tr id="filter_col3" data-column="2">
                <td>Column - Office</td>
                <td align="center">
                    <input type="text" class="column_filter" id="col2_filter">
                </td>
                <td align="center">
                    <input type="checkbox" class="column_filter" id="col2_regex">
                </td>
                <td align="center">
                    <input type="checkbox" class="column_filter" id="col2_smart" checked="checked">
                </td>
            </tr>
            <tr id="filter_col4" data-column="3">
                <td>Column - Age</td>
                <td align="center">
                    <input type="text" class="column_filter" id="col3_filter">
                </td>
                <td align="center">
                    <input type="checkbox" class="column_filter" id="col3_regex">
                </td>
                <td align="center">
                    <input type="checkbox" class="column_filter" id="col3_smart" checked="checked">
                </td>
            </tr>
            <tr id="filter_col5" data-column="4">
                <td>Column - Start date</td>
                <td align="center">
                    <input type="text" class="column_filter" id="col4_filter">
                </td>
                <td align="center">
                    <input type="checkbox" class="column_filter" id="col4_regex">
                </td>
                <td align="center">
                    <input type="checkbox" class="column_filter" id="col4_smart" checked="checked">
                </td>
            </tr>
            <tr id="filter_col6" data-column="5">
                <td>Column - Salary</td>
                <td align="center">
                    <input type="text" class="column_filter" id="col5_filter">
                </td>
                <td align="center">
                    <input type="checkbox" class="column_filter" id="col5_regex">
                </td>
                <td align="center">
                    <input type="checkbox" class="column_filter" id="col5_smart" checked="checked">
                </td>
            </tr>
        </tbody>
    </table>
   
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
    function filterGlobal() {
        $('#example').DataTable().search(
            $('#global_filter').val(),
            $('#global_regex').prop('checked'),
            $('#global_smart').prop('checked')
        ).draw();
    }

    function filterColumn(i) {
        $('#example').DataTable().column(i).search(
            $('#col' + i + '_filter').val(),
            $('#col' + i + '_regex').prop('checked'),
            $('#col' + i + '_smart').prop('checked')
        ).draw();
    }

    $(document).ready(function() {
        $('#example').DataTable();

        $('input.global_filter').on('keyup click', function() {
            filterGlobal();
        });

        $('input.column_filter').on('keyup click', function() {
            filterColumn($(this).parents('tr').attr('data-column'));
        });
    });
    </script>
    </body>
</html>