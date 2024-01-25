<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>David Project</title>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" type="text/css" href="./assets/custom.css">
    </head>
    <body>
        <div class="container">
            <div class="control-panel">
                <h1>Search Knifes</h1>
                <form>
                    <div class="row mt-3">
                        <div class="form-group col-3">
                            <label for="shape" class="form-label">Shape:</label>
                            <select class="form-control" id="shape" name="shape">
                                <option>All</option>
                                <option>Rectangle</option>
                                <option>Ellipse</option>
                                <option>Circle</option>
                                <option>Special</option>
                            </select>
                        </div>
                        <div class="form-group col-3">
                            <label for="across" class="form-label">Size Across:</label>
                            <input type="number" class="form-control" id="across" placeholder="Enter size across" name="across">
                        </div>
                        <div class="form-group col-3">
                            <label for="shape" class="form-label">Size Around:</label>
                            <input type="number" class="form-control" id="around" placeholder="Enter size around" name="around">
                        </div>
                        <div class="form-group col-3">
                            <label for="shape" class="form-label">Tolerance:</label>
                            <input type="number" class="form-control" id="tolerance" placeholder="Enter tolerance" name="tolerance">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col-4">
                            <label for="number" class="form-label">Number:</label>
                            <input type="number" class="form-control" id="number" placeholder="Enter number" name="number">
                        </div>
                        <div class="form-group col-4">
                            <label for="shape" class="form-label">Cut Type:</label>
                            <select class="form-control" id="cut-type" name="cut-type">
                                <option>All</option>
                                <option>To Liner</option>
                            </select>
                        </div>
                        <div class="form-group col-4">
                            <label for="shape" class="form-label">Perforation:</label>
                            <select class="form-control" id="perforation" name="perforation">
                                <option>All</option>
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-4 justify-content-end">
                        <div class="form-group col-2">
                            <button type="button" class="btn btn-primary w-100" id="search-btn">Search</button>
                        </div>
                    </div>
                </form>
                <!--        <input type="file" id="input-excel">-->
            </div>
            <div class="table-container">
                <table id="example" class="display" style="width:100%"></table>
            </div>
        </div>
    </body>
    <script>
        $(document).ready(function() {
            let filePath = 'example.xlsx';

            // Load the XLSX file
            let req = new XMLHttpRequest();
            req.open('GET', filePath, true);
            req.responseType = 'arraybuffer';

            let table, dataj;

            req.onload = function(e) {
                let data = new Uint8Array(req.response);
                let wb = XLSX.read(data, {type:'array'});
                let sheet_name_list = wb.SheetNames;
                dataj = XLSX.utils.sheet_to_json(wb.Sheets[sheet_name_list[0]], {raw: true, defval:null});

                let newData = dataj.map(obj => {
                    let tempObj = {};
                    Object.keys(obj).map(key => {
                        if(key.indexOf('__EMPTY') < 0) tempObj[key] = obj[key] !== null ? obj[key].toString() : null; // convert Number to String to apply filter (Number wasn't filtered by)
                    });
                    return tempObj;
                })

                table = $('#example').DataTable({
                    data: newData,
                    columns: Object.keys(newData[0]).map(function(key) {
                        return { title: key, data: key };
                    }),
                    scrollX: true, // overflow-x
                    sDom: 'lrtip' // remove default "Search" button
                });
            };
            req.send();

            $('#search-btn').click(function () {
                const shape = $('#shape').val();
                const across = $('#across').val();
                const around = $('#around').val();
                const tolerance = $('#tolerance').val();
                const cutType = $('#cut-type').val();
                const perforation = $('#perforation').val();

                if (shape !== 'All') table.column(5).search(shape).draw();
                else table.column(5).search('').draw(); // select All (cancel filter)

                if (tolerance !== '' && across !== '') {
                    DataTable.ext.search.push(acrossRangeFilter);
                } else {
                    DataTable.ext.search.splice(DataTable.ext.search.indexOf(acrossRangeFilter, 1)); // remove Search Extension when it is not necessary
                    if (across !== '') table.column(10).search("^" + across + "$", true, false, true).draw(); // filter column by exact match, ex: '150' is not filtered by '50'
                    else table.column(10).search('').draw();
                }

                if (tolerance !== '' && around !== '') {
                    DataTable.ext.search.push(aroundRangeFilter);
                } else {
                    DataTable.ext.search.splice(DataTable.ext.search.indexOf(aroundRangeFilter, 1)); // remove Search Extension when it is not necessary
                    if (around !== '') table.column(10).search("^" + around + "$", true, false, true).draw(); // filter column by exact match, ex: '150' is not filtered by '50'
                    else table.column(10).search('').draw();
                }

                if (cutType !== 'All') table.column(7).search(cutType).draw(); else table.column(7).search('').draw();
                if (perforation !== 'All') table.column(19).search(perforation).draw(); else table.column(19).search('').draw();
            })

            const acrossRangeFilter = (settings, data, dataIndex) => {
                const across = $('#across').val();
                const tolerance = $('#tolerance').val();

                let min = parseInt(across) - parseInt(tolerance);
                let max = parseInt(across) + parseInt(tolerance);

                let field = parseFloat(data[10]) || 0;

                return (isNaN(min) && isNaN(max)) ||
                    (isNaN(min) && field <= max) ||
                    (min <= field && isNaN(max)) ||
                    (min <= field && field <= max);
            }

            const aroundRangeFilter = (settings, data, dataIndex) => {
                const around = $('#around').val();
                const tolerance = $('#tolerance').val();

                let min = parseInt(around) - parseInt(tolerance);
                let max = parseInt(around) + parseInt(tolerance);

                let field = parseFloat(data[11]) || 0;

                return (isNaN(min) && isNaN(max)) ||
                    (isNaN(min) && field <= max) ||
                    (min <= field && isNaN(max)) ||
                    (min <= field && field <= max);
            }
        });
    </script>
</html>
