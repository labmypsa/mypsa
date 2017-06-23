    var X = XLSX;
    var output = "";
    var datos;
    var hoja;
    var XW = {
        msg: 'xlsx',
        rABS: 'assets/plugins/js-xlsx/xlsxworker2.js',
        norABS: 'assets/plugins/js-xlsx/xlsxworker1.js'
    };
    function loadData(output){
        datos = JSON.parse(output);
        var hojas = Object.keys(datos);
        if(hojas.length == 1){
            $('#libros').css('display','none');
            renderTable(hojas[0]);
        } else{
            $('#selectLibros').empty();
            $('#selectLibros').append('<option value="">Seleccione un libro</option>');
            $('#libros').css('display','block');
            $('#uploadData').css('display','none');
            $.each(hojas, function (i, item) {
                $('#selectLibros').append($('<option>', { 
                    value: item,
                    text : item 
                }));
             });
        }
    }
    $('#selectLibros').on('change',function(){
        var sheet = $(this).val();
        if(sheet!=''){
            renderTable(sheet);
        }
    });
    function renderTable(sheet){
        var sheet = datos[sheet];
        // Este codigo es apra llenar los campos inexistentes del JSON a strins vacios
        var titulos = [];
        for (var i = 0; i < sheet.length; i++) {
            if(Object.keys(sheet[i]).length > titulos.length)
                titulos = Object.keys(sheet[i]);
        }
        // console.log(titulos);
        for (var i = 0; i < sheet.length; i++) {
            for (var j = 0; j < titulos.length; j++) {
                var dato = sheet[i][titulos[j]];
                if(dato == null){
                    sheet[i][titulos[j]] = 'N/A';
                }
            }
        }
        // Termina bloque opcional

        $("#table-volumen tbody").empty();
        $.each(sheet, function(i, item) {
            var row = $("<tr />");
            $("#table-volumen").append(row);
            row.append($("<td>" + item.id + "</td>"));
            row.append($("<td>" + item.descriopcion + "</td>"));
            row.append($("<td>" + item.marca + "</td>"));
            row.append($("<td>" + item.modelo + "</td>"));
            row.append($("<td>" + item.serie + "</td>"));
            row.append($("<td>" + item.informe + "</td>"));
            row.append($("<td>" + item.tecnico + "</td>"));
            row.append($("<td><span class='label label-success'><i class='fa fa-ban' aria-hidden='true'></i></span></td>"));
        });
        // Pintar de rojo las celdas que esten vacias
        $("#table-volumen tbody td").each(function(index, el) {
            if(el.textContent == 'N/A'){
                $(el).addClass('bg-gray disabled color-palette');
            }
        });
        $('#uploadData').css('display','block');
    }

    var wtf_mode = false;

    function ab2str(data) {
        var o = "",
            l = 0,
            w = 10240;
        for (; l < data.byteLength / w; ++l) o += String.fromCharCode.apply(null, new Uint16Array(data.slice(l * w, l * w + w)));
        o += String.fromCharCode.apply(null, new Uint16Array(data.slice(l * w)));
        return o;
    }

    function s2ab(s) {
        var b = new ArrayBuffer(s.length * 2),
            v = new Uint16Array(b);
        for (var i = 0; i != s.length; ++i) v[i] = s.charCodeAt(i);
        return [v, b];
    }

    function xw_xfer(data, cb) {
        var worker = new Worker(rABS ? XW.rABS : XW.norABS);
        worker.onmessage = function(e) {
            switch (e.data.t) {
                case 'ready':
                    break;
                case 'e':
                    console.error(e.data.d);
                    break;
                default:
                    xx = ab2str(e.data).replace(/\n/g, "\\n").replace(/\r/g, "\\r");
                    cb(JSON.parse(xx));
                    break;
            }
        };
        if (rABS) {
            var val = s2ab(data);
            worker.postMessage(val[1], [val[1]]);
        } else {
            worker.postMessage(data, [data]);
        }
    }

    function xw(data, cb) {
        xw_xfer(data, cb);
    }

    function to_json(workbook) {
        var result = {};
        workbook.SheetNames.forEach(function(sheetName) {
            var roa = X.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
            if (roa.length > 0) {
                result[sheetName] = roa;
            }
        });
        return result;
    }

    function process_wb(wb) {
        output = JSON.stringify(to_json(wb), 2, 2);
        loadData(output);
        if (out.innerText === undefined) out.textContent = output;
        else out.innerText = output;
    }
    var xlf = document.getElementById('xlf');

    function handleFile(e) {
        rABS = true
        use_worker = true;
        var files = e.target.files;
        var f = files[0]; {
            var reader = new FileReader();
            var name = f.name;
            reader.onload = function(e) {
                var data = e.target.result;
                if (use_worker) {
                    xw(data, process_wb);
                }
            };
            reader.readAsBinaryString(f);
            
        }
    }
    if (xlf.addEventListener) {
        xlf.addEventListener('change', handleFile, false);
    }