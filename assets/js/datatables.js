$(document).ready(function () {
    if (typeof controller != 'undefined') {                   
        var _arrayCtrl=controller.split(" "); 

            $('#table tfoot th').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" style="width:100%;font-weight: 400;font-size: 13px;padding: 3px 2px;" placeholder=" '+title+'" />' );
            } );

        var table = $('#table').DataTable({
            "ajax": "assets/php/server_processing.php?controller=" + controller,            
            "processing": true,
            "serverSide": true,
            "dataType": "jsonp",
            "lengthMenu": [[15, 20, 50, -1], [15, 20, 50, "All"]],
            "autoWidth": true,           
            "scrollX": true,
            dom: '<"pull-left"l>fr<"dt-buttons"B>tip',
            buttons: [
             {               
                extend: 'excel',
                text: 'Excel',
                exportOptions: {
                    columns: [':not(:last-child)' ]
                },
            },            
            {
                extend: 'pdfHtml5',
                text: 'PDF',
                exportOptions: {
                    columns: [':not(:last-child)' ]
                },
                title: 'Reporte de '+controller,
                download: 'open',
                header: true,
                footer: true,
                filename: '*',
                pageSize: 'LETTER',
                orientation: 'landscape',
                customize: function (doc) {
                    console.log(doc);
                    doc['footer']=(function(page, pages) {
                        return {
                            columns: [
                                'Metrología y Pruebas S.A. de C.V.',
                                {
                                    alignment: 'right',
                                    text: [
                                        { text: page.toString()},
                                        ' de ',
                                        { text: pages.toString()}
                                    ]
                                }
                            ],
                        margin: [40, 0]
                        }
                    });
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    doc.content.splice( 2, 0, {
                        margin: [ 0, 25, 0, 12 ],
                        alignment: 'center',
                        fontSize: 8,
                        style: 'header',
                        text: 'Este reporte fue generado de forma automática mediante el sistema de aplicación de Metrología y Pruebas. Cualquier duda o pregunta contactar al equipo de soporte'
                    });
                    doc.content.splice( 3, 0, {
                        margin: [ 0, 5, 0, 12 ],
                        alignment: 'center',
                        image: 'data:image/jpeg;base64,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'
                    });
                    doc.defaultStyle.fontSize = 8;

                    doc.styles.tableHeader.fillColor = '#1e78ad';
                    doc.styles.tableHeader.alignment = 'left';
                    doc.styles.tableHeader.fontSize = 8;
                    
                    doc.styles.tableFooter.fillColor = '#1e78ad'; 
                    doc.styles.tableHeader.alignment = 'left';
                    doc.styles.tableFooter.fontSize = 8;

                    doc.styles.tableHeader.margin   = [10,5,0,5]
                    doc.styles.tableFooter.margin   = [10,5,0,5]
                    doc.styles.tableBodyEven.margin = [10,4,0,4];
                    doc.styles.tableBodyOdd.margin  = [10,4,0,4];
                }}
            ],
            fixedColumns: {
                leftColumns: 2
            },
            "columnDefs": [
                { "width": "90px", "targets": -1 },
                {
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<a href='#' data-type='edit' class='btn btn-xs btn-primary btn-flat'>Editar</a> <a href='#' data-type='delete' class='btn btn-xs btn-danger btn-flat'>Eliminar</a>"
                }],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros de _START_ a _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });

        table.columns().every( function () {
                    var that = this;
             
                    $( 'input', this.footer() ).on( 'keyup change', function () {
                        if ( that.search() !== this.value ) {
                            that
                                .search( this.value )
                                .draw();
                        }
                    } );
                } );


        $('#table tbody').on('click', 'a', function () {
            var data = table.row($(this).parents('tr')).data();
            if ($(this).data("type") == "edit") {
                window.location.replace("?c=" + controller + "&a=edit&p=" + data[0]);
            } else {
                window.location.replace("?c=" + controller + "&a=delete&p=" + data[0]);
            }
        });

         $('#table_informes tfoot th').each( function () {
            var title = $(this).text();
            $(this).append( '<input type="text" style="width:100%;font-weight: 400;font-size: 13px;padding: 3px 2px;" placeholder=" '+title+'" />' );
        } );

        var table_informes = $('#table_informes').DataTable({
            "ajax": "assets/php/server_processing.php?controller=" + controller,
            "deferRender": true,
            "processing": true,
            "serverSide": true,
            "dataType": "jsonp",
            "lengthMenu": [[15, 20, 50, -1], [15, 20, 50, "All"]],
            "autoWidth": true,
            "scrollX": true,           
            dom: '<"pull-left"l>fr<"dt-buttons"B>Ztip',            
            buttons: [
                 {
                    extend: 'excel',
                    text: 'Excel',
                    exportOptions: {
                        columns: [':not(:last-child)' ]
                    },
                },
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    exportOptions: {
                        columns: [':not(:last-child)' ]
                    },
                    title: 'Reporte de '+controller,
                    download: 'open',
                    header: true,
                    footer: true,
                    filename: '*',
                    pageSize: 'LETTER',
                    customize: function (doc) {
                        console.log(doc);
                        doc['footer']=(function(page, pages) {
                            return {
                                columns: [
                                    'Metrología y Pruebas S.A. de C.V.',
                                    {
                                        alignment: 'right',
                                        text: [
                                            { text: page.toString()},
                                            ' de ',
                                            { text: pages.toString()}
                                        ]
                                    }
                                ],
                            margin: [40, 0]
                            }
                        });
                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        doc.content.splice( 2, 0, {
                            margin: [ 0, 25, 0, 12 ],
                            alignment: 'center',
                            fontSize: 9,
                            style: 'header',
                            text: 'Este reporte fue generado de forma automática mediante el sistema de aplicación de Metrología y Pruebas. Cualquier duda o pregunta contactar al equipo de soporte'
                        });
                        doc.content.splice( 3, 0, {
                            margin: [ 0, 5, 0, 12 ],
                            alignment: 'center',
                            image: 'data:image/jpeg;base64,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'
                        });
                        doc.defaultStyle.fontSize = 10;

                        doc.styles.tableHeader.fillColor = '#1e78ad';
                        doc.styles.tableHeader.alignment = 'left';
                        
                        doc.styles.tableFooter.fillColor = '#1e78ad'; 
                        doc.styles.tableHeader.alignment = 'left';

                        doc.styles.tableHeader.margin   = [10,5,0,5]
                        doc.styles.tableFooter.margin   = [10,5,0,5]
                        doc.styles.tableBodyEven.margin = [10,4,0,4];
                        doc.styles.tableBodyOdd.margin  = [10,4,0,4];
                    }}
            ],            
            "columnDefs": [
                { "targets":[7], "visible":true}, 
                {
                    //"width": "150px",
                   "targets": 7,
                   "render": function(data,type, row){
                    var planta=row[7];
                    if(planta== "planta1" || planta== "planta 1" || planta== "Planta1" || planta== "Planta 1"){
                        planta="";
                    }
                     return planta;                                                             
                    }
                },
                {"targets":[29,30,31], "visible":false},                            
                {   
                    "targets": -2,                                 
                    "render": function(data,type, row){
                        //console.log(data +' ('+ row[29]+')');                                                        
                        if(row[29] == 1){
                            return "<a href='?c=informes&a=verinforme&p="+row[0]+"' target='_blank'  class='btn btn-social-icon badge bg-green' data-original-title='ver informe'><i class='fa fa-file-pdf-o'></i></a>";
                        }
                        else{
                          return "<a href='#'  class='btn btn-social-icon badge bg-green disabled' data-original-title='ver informe'><i class='fa fa-file-pdf-o'></i></a>";  
                        }                        
                    },
                    "orderable" : false,
                    "searchable": false,
                },
                { "width": "70px", "targets": [-1,-2] },
                {
                    "targets": -1, //
                    "render": function(data,type, row){
                     var proceso=parseInt(row[31]);   
                    var enable=[
                    ["","disabled","disabled","disabled"],
                    ["","disabled","disabled","disabled"],
                    ["","","disabled","disabled"],
                    ["","","","disabled"],
                    ["","","",""]
                    ];
                    var menu="<a href='?c=recepcion&a=index&p="+row[0]+"' target='_black' id='btn_recepcion'  class='btn btn-social-icon badge bg-red"+ enable[proceso][0] +"' data-original-title='Recepción'><i class='fa fa-sign-in'></i></a>"+                              
                    "<a href='?c=calibracion&a=index&p="+row[0]+"'  target='_black' id='btn_calibracion'  class='btn btn-social-icon badge bg-yellow "+ enable[proceso][1] +"' data-original-title='Calibración'><i class='fa fa-sliders'></i></a>";                                

                    if(_arrayCtrl[4] == '00' || _arrayCtrl[4] == '02'|| _arrayCtrl[4] == '04'|| _arrayCtrl[4] == '06'){
                    menu +="<a href='?c=salida&a=index&p="+row[0]+"' target='_black' id='btn_salida' class='btn btn-social-icon badge bg-blue "+ enable[proceso][2] +"' data-original-title='Salida'><i class='fa fa-sign-out'></i></a>"+
                    "<a href='?c=factura&a=index&p="+row[0]+"' target='_black' id='btn_factura' class='btn btn-social-icon badge bg-navy "+ enable[proceso][3] +"' data-original-title='Facturación'><i class='fa fa-file-archive-o'></i></a>";   
                    }
                    else
                    {
                    menu +="<a href='#' id='btn_salida' class='btn btn-social-icon badge bg-blue "+ enable[proceso][2] +"' data-original-title='Salida'><i class='fa fa-sign-out'></i></a>"+
                    "<a href='#' id='btn_factura' class='btn btn-social-icon badge bg-navy "+ enable[proceso][3] +"' data-original-title='Facturación'><i class='fa fa-file-archive-o'></i></a>";   
                    }
                        return  menu;                     
                    },
                "orderable" : false,
                "searchable": false,
                }],
            // "language": { "url": "assets/json/datatables.spanish.json" }
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros de _START_ a _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        }); 


        table_informes.columns().every( function () {
            var that = this;
            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                    }
                });
            });


         $('#table_proceso tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" style="width:100%;font-weight: 400;font-size: 13px;padding: 3px 2px;" placeholder=" '+title+'" />' );
        } );

        var table_proceso = $('#table_proceso').DataTable({
            "ajax": "assets/php/server_processing.php?controller=" + controller,
            "deferRender": true,
            "processing": true,
            "serverSide": true,
            "dataType": "jsonp",
            "lengthMenu": [[15, 20, 50, -1], [15, 20, 50, "All"]],
            "autoWidth": true,
            "scrollX": true,
            "responsive": true,            
            dom: '<"pull-left"l>fr<"dt-buttons"B>tip',
            buttons: [
                 {
                    extend: 'excel',
                    text: 'Excel',
                    exportOptions: {
                        columns: [':not(:last-child)' ]
                    },                    
                }
            ], 
            //fixedColumns: true,           
            "rowCallback": function( row, data, index ) {                      
                var prioridad = parseInt(data[32]),
                    entregado= (data[33]),
                    proceso= parseInt(data[31]),                 
                  $node = this.api().row(row).nodes().to$();
                  if (proceso < 3 && prioridad == 1 ) {
                     $node.addClass('bg-red')
                  }                      
                  if (proceso > 2 && entregado == null ) {
                     $node.addClass('bg-light-blue')
                  }
              },
            "columnDefs": [              
                { "targets":[7], "visible":true}, 
                {
                    //"width": "150px",
                   "targets": 7,
                   "render": function(data,type, row){
                    var planta=row[7];
                    if(planta== "planta1" || planta== "planta 1" || planta== "Planta1" || planta== "Planta 1"){
                        planta="";
                    }
                     return planta;                     
                    }
                },  
                {"targets":[24,25,26,27,29], "visible":false},
                {                 
                 "targets": 31, //Proceso
                 "render": function(data,type, row){                     
                    var color=['danger','warning','info','primary'];
                    var text_color=['#5F5F5F','#FFFFFF','#FFFFFF','#FFFFFF'];                                       
                    var menu="<div class='progress progress-striped active'>"+
                    "<div class='progress-bar progress-bar-"+ color[row[31]]+"' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width:"+(parseInt(row[31])*100)/4+"%; color:"+ text_color[row[31]]+"'> "+(parseInt(row[31])*100)/4+"% </div>"+                    
                    "</div>";                   
                    return  menu;
                }
                },                           
                { "width": "60px", "targets": [-1,-2] },
                {
                    "targets": -1, //
                    "render": function(data,type, row){
                    var proceso=parseInt(row[31]);                      
                    var enable=[
                    ["","disabled","disabled","disabled"],
                    ["","","disabled","disabled"],
                    ["","","","disabled"],
                    ["","","",""],                    
                    ];
                    var disabledf="";
                    if(row[22]=='pendiente'){disabledf=enable[2][3];} 
                    else {disabledf=enable[proceso][3];}
                    //opciones del menu que siempre estaran habilitados
                    var menu="<a href='?c=recepcion&a=index&p="+row[0]+"' target='_blank' id='btn_recepcion'  class='btn btn-social-icon badge bg-red"+ enable[proceso][0] +"' data-original-title='Recepción'><i class='fa fa-sign-in'></i></a>"+                              
                    "<a href='?c=calibracion&a=index&p="+row[0]+"'  target='_blank' id='btn_calibracion'  class='btn btn-social-icon badge bg-yellow "+ enable[proceso][1] +"' data-original-title='Calibración'><i class='fa fa-sliders'></i></a>";

                    if(_arrayCtrl[4] == '00' || _arrayCtrl[4] == '02'|| _arrayCtrl[4] == '04'|| _arrayCtrl[4] == '06'){
                    menu +="<a href='?c=salida&a=index&p="+row[0]+"'  target='_blank' id='btn_salida'  class='btn btn-social-icon badge bg-blue "+ enable[proceso][2] +"' data-original-title='Salida'><i class='fa fa-sign-out'></i></a>"+
                    "<a href='?c=factura&a=index&p="+row[0]+"' target='_blank' id='btn_factura'  class='btn btn-social-icon badge bg-navy "+ disabledf  +"' data-original-title='Facturación'><i class='fa fa-file-archive-o'></i></a>";                
                    } 
                    else{
                    menu +="<a href='#' id='btn_salida' class='btn btn-social-icon badge bg-blue "+ enable[proceso][2] +"' data-original-title='Salida'><i class='fa fa-sign-out'></i></a>"+
                    "<a href='#' id='btn_factura'  class='btn btn-social-icon badge bg-navy "+ disabledf  +"' data-original-title='Facturación'><i class='fa fa-file-archive-o'></i></a>";                
                    }                        
                    return  menu;
                }} 

                ],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros de _START_ a _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        }); 
        
      
        table_proceso.columns().every( function () {
            var that = this;
            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                    }
                });
            });

         $('#table_calibrar tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" style="width:100%;font-weight: 400;font-size: 13px;padding: 3px 2px;" placeholder=" '+title+'" />' );
        } );

        var table_calibrar = $('#table_calibrar').DataTable({
            "ajax": "assets/php/server_processing.php?controller=" + controller,
            "deferRender": true,
            "processing": true,
            "serverSide": true,
            "dataType": "jsonp",
            "lengthMenu": [[15, 20, 50, -1], [15, 20, 50, "All"]],
            "autoWidth": true,
            "scrollX": true,           
            dom: '<"pull-left"l>fr<"dt-buttons"B>tip',
            buttons: [
                 {
                    extend: 'excel',
                    text: 'Excel',
                    exportOptions: {
                        columns: [':not(:last-child)' ]
                    },
                }                
            ],            
            "rowCallback": function( row, data, index ) {                
                var prioridad = parseInt(data[32]),                 
                  $node = this.api().row(row).nodes().to$();
                  if (prioridad == 1 ) {
                     $node.addClass('bg-red')
                  }
              },
            "columnDefs": [
                { "targets":[7], "visible":true}, 
                {
                   //"width": "150px",
                   "targets": 7,
                   "render": function(data,type, row){
                    var planta=row[7];
                    if(planta== "planta1" || planta== "planta 1" || planta== "Planta1" || planta== "Planta 1"){
                        planta="";
                    }
                     return planta;                                                             
                    }
                },  
                {"targets":[13,15,17,19,20,21,22,23,24,25,26,27,28], "visible":false},
                {                 
                 "targets": -2,
                 "render": function(data,type, row){                     
                    var color=['danger','warning','info','primary'];
                    var menu="<div class='progress progress-striped active'>"+
                    "<div class='progress-bar progress-bar-"+ color[row[31]]+"' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width:"+(parseInt(row[31])*100)/4+"%'> "+(parseInt(row[31])*100)/4+"% </div>"+
                    "</div>";
                    return  menu;
                }
                },                            
                { "width": "60px", "targets": -1 },
                {
                    "targets": -1,
                    "render": function(data,type, row){                    
                    var menu= "<a href='?c=calibracion&a=index&p="+row[0]+"'  target='_black' id='btn_calibracion' class='btn btn-social-icon badge bg-yellow ' data-original-title='Calibración'><i class='fa fa-sliders'></i></a>";
                    return  menu;
                    },                   
                "orderable" : false,
                "searchable": false,
                }],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros de _START_ a _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });   

        table_calibrar.columns().every( function () {
            var that = this;
            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                    }
                });
            }); 

        var table_clientes = $('#table_clientes').DataTable({
            "ajax": "assets/php/server_processing.php?controller=" + controller,            
            "processing": true,
            "serverSide": true,
            "dataType": "jsonp",
            "lengthMenu": [[15, 20, 50, -1], [15, 20, 50, "All"]],
            "autoWidth": true,
            "scrollX": true,           
            dom: '<"pull-left"l>fr<"dt-buttons"B>tip',
            buttons: [
                 {
                    extend: 'excel',
                    text: 'Excel',
                    exportOptions: {
                        columns: [':not(:last-child)' ]
                    },
                }                
            ],
            fixedColumns: true,            
            "columnDefs": [
                {"targets":[6,14,15], "visible":false},               
                {   
                    "targets": -1,                                 
                    "render": function(data,type, row){                        
                        if(row[14] == 1){
                            return "<a href='?c=informes&a=verinforme&p="+row[0]+"' target='_blank' class='btn btn-social-icon badge bg-green' data-original-title='ver informe'><i class='fa fa-file-pdf-o'></i></a>";
                        }
                        else{
                            return "<a href='#'  class='btn btn-social-icon badge bg-green disabled' data-original-title='ver informe'><i class='fa fa-file-pdf-o'></i></a>";  
                        }                        
                    },
                    "orderable" : false,
                    "searchable": false,
                },
            ],
            "language": { "url": "assets/json/datatables.spanish.json" }
        });    

        var table_clientesconti = $('#table_clientesconti').DataTable({
            "ajax": "assets/php/server_processing.php?controller=" + controller,
            "processing": true,
            "serverSide": true,
            "dataType": "jsonp",
            "lengthMenu": [[15, 20, 50, -1], [15, 20, 50, "All"]],
            "autoWidth": true,
            "scrollX": true,           
            dom: '<"pull-left"l>fr<"dt-buttons"B>tip',
            buttons: [
                 {
                    extend: 'excel',
                    text: 'Excel',
                    exportOptions: {
                        columns: [':not(:last-child)' ]
                    },
                }                
            ],                    
            "columnDefs": [
                //{"targets":[6,14,15], "visible":false},               
                //{"targets":[15], "visible":false},
                {   
                    "targets": -1,                                 
                    "render": function(data,type, row){
                        if(row[14] == 1){
                            return "<a href='?c=informes&a=verinforme&p="+row[0]+"' target='_blank'  class='btn btn-social-icon badge bg-green' data-original-title='ver informe'><i class='fa fa-file-pdf-o'></i></a>";
                        }
                        else{
                            return "<a href='#'  class='btn btn-social-icon badge bg-green disabled' data-original-title='ver informe'><i class='fa fa-file-pdf-o'></i></a>";  
                        }                        
                    },
                    "orderable" : false,
                    "searchable": false,
                },
            ],
            "language": { "url": "assets/json/datatables.spanish.json" }
        }); 

        var table_reportec = $('#table_reportec').DataTable({
            "ajax": "assets/php/server_processing.php?controller=" + controller,
            "processing": true,
            "serverSide": true,
            "dataType": "jsonp",
            "lengthMenu": [[15, 20, ,50, 100, -1], [15, 20, 50, 100, "All"]],
            "autoWidth": true,
            "scrollX": true,            
            dom: '<"pull-left"l>fr<"dt-buttons"B>tip',
            buttons: [
                {
                    extend: 'excel',
                    text: 'Excel',
                    exportOptions: {
                        columns: [':not(:last-child)' ]
                    },
                }
            ],
            fixedColumns: true,
            "rowCallback": function( row, data, index ) {                      
                var activo = parseInt(data[6]), 
                $node = this.api().row(row).nodes().to$();
                if (activo = 0) {
                     $node.addClass('bg-red')
                }                                        
              },
            "columnDefs": [                
                { "targets":[6], "visible":false},
                {                                                   
                    "render": function(data,type, row){ 
                        var suma= row[13] + row[14];
                         return suma; 
                        },
                        "targets": -2                                    
                },
                {                                                   
                    "render": function(data,type, row){ 
                        var proceso= ["","","Calibrado","Entregado","Terminado"];

                         return proceso[row[15]]; 
                        },
                        "targets": -1                                    
                }
            ],                      
            "language": { "url": "assets/json/datatables.spanish.json" }
        });

        var table_totalproduct = $('#table_totalproduct').DataTable({
            "ajax": "assets/php/server_processing.php?controller=" + controller,
            "processing": true,
            "serverSide": true,
            "dataType": "jsonp",
            "lengthMenu": [[15, 20, 50, 100, -1], [15, 20, 50, 100, "All"]],
            "autoWidth": true,
            "scrollX": true,            
            dom: '<"pull-left"l>fr<"dt-buttons"B>tip',           
            buttons: [ {
                    extend: 'excel',
                    text: 'Excel',
                    exportOptions: {
                        columns: [':not(:last-child)' ]
                    },                    
                } ],
            fixedColumns: true,
            "rowCallback": function( row, data, index ) {                      
                var activo = parseInt(data[6]), 
                $node = this.api().row(row).nodes().to$();
                if (activo = 0) {
                     $node.addClass('bg-red')
                }                                        
              },
            "columnDefs": [                
                { "targets":[6,17], "visible":false},
                {                                                   
                    "render": function(data,type, row){ 
                        var suma= row[14] + row[15];
                         return suma; 
                        },
                        "targets": -3                                    
                },                
            ],                      
            "language": { "url": "assets/json/datatables.spanish.json" }
        });
    
    }        
});

