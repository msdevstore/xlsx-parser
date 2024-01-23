<!DOCTYPE html>
<html>
<head>
    <title>EXCEL PARSER</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
    <div class="control-panel">
<!--        <input type="file" id="input-excel">-->
    </div>
    <div class="table-container">
        <table id="example" class="display" style="width:100%"></table>
    </div>
</div>
</body>
<script>
    $(document).ready(function() {
        $('#input-excel').change(function(e){
            var reader = new FileReader();
            reader.readAsArrayBuffer(e.target.files[0]);
            reader.onload = function(e) {
                var data = new Uint8Array(reader.result);
                var wb = XLSX.read(data,{type:'array'});
                var sheet_name_list = wb.SheetNames;
                var dataj = XLSX.utils.sheet_to_json(wb.Sheets[sheet_name_list[0]], {raw: true, defval:null});
                var table = $('#example').DataTable({
                    data: dataj,
                    columns: Object.keys(dataj[0]).map(function(key) {
                        return { title: key, data: key };
                    }),
                    scrollX: true
                });
            }
        });

        var filePath = 'example.xlsx';

        // Load the XLSX file
        var req = new XMLHttpRequest();
        req.open('GET', filePath, true);
        req.responseType = 'arraybuffer';
        req.onload = function(e) {
            var data = new Uint8Array(req.response);
            var wb = XLSX.read(data, {type:'array'});
            var sheet_name_list = wb.SheetNames;
            var dataj = XLSX.utils.sheet_to_json(wb.Sheets[sheet_name_list[0]], {raw: true, defval:null});
            var table = $('#example').DataTable({
                data: dataj,
                columns: Object.keys(dataj[0]).map(function(key) {
                    return { title: key, data: key };
                }),
                scrollX: true
            });
        };
        req.send();
    });
</script>
</html>
