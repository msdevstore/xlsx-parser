<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

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
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                        Create Database
                    </button>
                </div>
                <form>
                    @csrf
                    <div class="row mt-3">
                        <div class="form-group col-3">
                            <label for="shape" class="form-label">Shape:</label>
                            <select class="form-control" id="s-shape" name="shape">
                                <option>All</option>
                                <option>Rectangle</option>
                                <option>Ellipse</option>
                                <option>Circle</option>
                                <option>Special</option>
                            </select>
                        </div>
                        <div class="form-group col-3">
                            <label for="across" class="form-label">Size Across:</label>
                            <input type="number" class="form-control" id="s-across" placeholder="Enter size across" name="across">
                        </div>
                        <div class="form-group col-3">
                            <label for="shape" class="form-label">Size Around:</label>
                            <input type="number" class="form-control" id="s-around" placeholder="Enter size around" name="around">
                        </div>
                        <div class="form-group col-3">
                            <label for="shape" class="form-label">Tolerance:</label>
                            <input type="number" class="form-control" id="s-tolerance" placeholder="Enter tolerance" name="tolerance">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col-4">
                            <label for="number" class="form-label">Number:</label>
                            <input type="number" class="form-control" id="s-number" placeholder="Enter number" name="number">
                        </div>
                        <div class="form-group col-4">
                            <label for="shape" class="form-label">Cut Type:</label>
                            <select class="form-control" id="s-cut-type" name="cut-type">
                                <option>All</option>
                                <option>To Liner</option>
                            </select>
                        </div>
                        <div class="form-group col-4">
                            <label for="shape" class="form-label">Perforation:</label>
                            <select class="form-control" id="s-perforation" name="perforation">
                                <option>All</option>
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-4 justify-content-between">
                        <div class="form-group col-2">
                            <button type="button" class="btn btn-primary w-100" id="add-btn">Add New</button>
                        </div>
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
            <div class="d-flex justify-content-end my-5">
{{--                <button type="button" class="btn btn-primary" id="export-btn">--}}
{{--                    Export Excel--}}
{{--                </button>--}}
                <a href="{{ URL::to('export') }}" class="btn btn-primary">Export Excel</a>
            </div>
        </div>
        <!-- The Modal -->
        <div class="modal" id="myModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Select XLSX File</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <div class="form-group">
                                <input class="form-control" type="file" id="input-excel">
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success mr-3" id="upload-btn">Upload</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- The Modal -->
        <div class="modal" id="editModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Knife Information</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Service IDs</span>
                                    <input type="text" class="form-control" id="serviceIds">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Pitch</span>
                                    <input type="text" class="form-control" id="pitch">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Type</span>
                                    <input type="text" class="form-control" id="type">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Gear</span>
                                    <input type="text" class="form-control" id="gear">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Shape</span>
                                    <select class="form-control" id="shape">
                                        <option>Rectangle</option>
                                        <option>Ellipse</option>
                                        <option>Circle</option>
                                        <option>Special</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Blade Type</span>
                                    <input type="text" class="form-control" id="bladeType">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Cut Type</span>
                                    <select class="form-control" id="cutType">
                                        <option>To Liner</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Cut Position</span>
                                    <input type="text" class="form-control" id="cutPosition">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Corner Radius</span>
                                    <input type="text" class="form-control" id="cornerRadius">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Size Across</span>
                                    <input type="text" class="form-control" id="sizeAcross">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Size Around</span>
                                    <input type="text" class="form-control" id="sizeAround">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">No Across</span>
                                    <input type="text" class="form-control" id="noAcross">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">No Around</span>
                                    <input type="text" class="form-control" id="noAround">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Gap Across</span>
                                    <input type="text" class="form-control" id="gapAcross">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Gap Around</span>
                                    <input type="text" class="form-control" id="gapAround">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Center-to-Center Across</span>
                                    <input type="text" class="form-control" id="centerToCenterAcross">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Center-to-Center Around</span>
                                    <input type="text" class="form-control" id="centerToCenterAround">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Liner</span>
                                    <input type="text" class="form-control" id="liner">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Perforation</span>
                                    <select class="form-control" id="perforation">
                                        <option>Yes</option>
                                        <option>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Location</span>
                                    <input type="text" class="form-control" id="location">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Supplier ID</span>
                                    <input type="text" class="form-control" id="supplierId">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Notes</span>
                                    <input type="text" class="form-control" id="notes">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Size Width</span>
                                    <input type="text" class="form-control" id="sizeWidth">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Repeat Length</span>
                                    <input type="text" class="form-control" id="repeatLength">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">No of Knife</span>
                                    <input type="text" class="form-control" id="noOfKnife">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Status</span>
                                    <input type="text" class="form-control" id="status">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger mr-5" id="delete-btn">Delete</button>
                        <button type="button" class="btn btn-primary mr-3" id="confirm-btn">Confirm</button>
                        <button type="button" class="btn btn-info" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
    </body>
    <script>
        $(document).ready(function() {
            // let filePath = 'example.xlsx';

            // Load the XLSX file
            // let req = new XMLHttpRequest();
            // req.open('GET', filePath, true);
            // req.responseType = 'arraybuffer';

            // req.onload = function(e) {
            //     let data = new Uint8Array(req.response);
            //     let wb = XLSX.read(data, {type:'array'});
            //     let sheet_name_list = wb.SheetNames;
            //     let dataj = XLSX.utils.sheet_to_json(wb.Sheets[sheet_name_list[0]], {raw: true, defval:null});
            //
            //     let newData = dataj.map(obj => {
            //         let tempObj = {};
            //         Object.keys(obj).map(key => {
            //             if(key.indexOf('__EMPTY') < 0) tempObj[key] = obj[key] !== null ? obj[key].toString() : null; // convert Number to String to apply filter (Number wasn't filtered by)
            //         });
            //         return tempObj;
            //     })
            //
            //     let table = $('#example').DataTable({
            //         data: newData,
            //         columns: Object.keys(newData[0]).map(function(key) {
            //             return { title: key, data: key };
            //         }),
            //         scrollX: true, // overflow-x
            //         sDom: 'lrtip' // remove default "Search" button
            //     });
            // };
            // req.send();

            const knives = {{Js::from($knives)}};

            let table = $('#example').DataTable({
                data: knives,
                columns: Object.keys(knives[0]).map(function(key) {
                    return { title: key, data: key };
                }),
                scrollX: true, // overflow-x
                sDom: 'lrtip' // remove default "Search" button
            });

            $('#search-btn').click(function () {
                const shape = $('#s-shape').val();
                const across = $('#s-across').val();
                const around = $('#s-around').val();
                const tolerance = $('#s-tolerance').val();
                const cutType = $('#s-cut-type').val();
                const perforation = $('#s-perforation').val();

                if (shape !== 'All') table.column(5).search(shape).draw();
                else table.column(5).search('').draw(); // select All (cancel filter)

                if (tolerance.length > 0) {
                    if (across.length > 0) DataTable.ext.search.push(acrossRangeFilter);
                    if (around.length > 0) DataTable.ext.search.push(aroundRangeFilter);
                } else {
                    DataTable.ext.search.splice(DataTable.ext.search.indexOf(aroundRangeFilter, 1)); // remove Search Extension when it is not necessary
                    DataTable.ext.search.splice(DataTable.ext.search.indexOf(acrossRangeFilter, 1)); // remove Search Extension when it is not necessary
                    if (across.length > 0) table.column(10).search("^" + across + "$", true, false, true).draw(); // filter column by exact match, ex: '150' is not filtered by '50'
                    else table.column(10).search('').draw();
                    if (around.length > 0) table.column(11).search("^" + around + "$", true, false, true).draw(); // filter column by exact match, ex: '150' is not filtered by '50'
                    else table.column(11).search('').draw();
                }

                if (cutType !== 'All') table.column(7).search(cutType).draw(); else table.column(7).search('').draw();
                if (perforation !== 'All') table.column(19).search(perforation).draw(); else table.column(19).search('').draw();
            })

            let globalId = 0;

            table.on('click', 'tbody tr', function (e) {
                const id = $(e.currentTarget).children().first().html();
                globalId = id;
                $.ajax({
                    url: '/getId/' + id,
                    type: 'GET',
                    success: function(res) {
                        console.log(res);
                        $('#serviceIds').val(res['Service IDs']);
                        $('#pitch').val(res['Pitch']);
                        $('#type').val(res['Type']);
                        $('#gear').val(res['Gear']);
                        $('#shape').val(res['Shape']).change();
                        $('#bladeType').val(res['Blade Type']);
                        $('#cutType').val(res['Cut Type']);
                        $('#cutPosition').val(res['Cut Position']);
                        $('#cornerRadius').val(res['Corner Radius']);
                        $('#sizeAcross').val(res['Size Across']);
                        $('#sizeAround').val(res['Size Around']);
                        $('#noAcross').val(res['No Across']);
                        $('#noAround').val(res['No Around']);
                        $('#gapAcross').val(res['Gap Across']);
                        $('#gapAround').val(res['Gap Around']);
                        $('#centerToCenterAcross').val(res['Center-to-Center Across']);
                        $('#centerToCenterAround').val(res['Center-to-Center Around']);
                        $('#liner').val(res['Liner']);
                        $('#perforation').val(res['Perforation']).change();
                        $('#location').val(res['Location']);
                        $('#supplierId').val(res['Supplier ID']);
                        $('#notes').val(res['Notes']);
                        $('#sizeWidth').val(res['Size Width']);
                        $('#repeatLength').val(res['Repeat Length']);
                        $('#noOfKnife').val(res['No of Knife']);
                        $('#status').val(res['Status']);
                        $('#editModal').modal('show');
                    },
                    error: function(err) {
                        console.log(err);
                        alert("Failed!")
                    }
                })
            });

            $('#add-btn').click(function() {
                globalId = 0;
                $('#serviceIds').val('');
                $('#pitch').val('');
                $('#type').val('');
                $('#gear').val('');
                $('#shape').prop('selectedIndex',0);
                $('#bladeType').val('');
                $('#cutType').val('');
                $('#cutPosition').val('');
                $('#cornerRadius').val('');
                $('#sizeAcross').val('');
                $('#sizeAround').val('');
                $('#noAcross').val('');
                $('#noAround').val('');
                $('#gapAcross').val('');
                $('#gapAround').val('');
                $('#centerToCenterAcross').val('');
                $('#centerToCenterAround').val('');
                $('#liner').val('');
                $('#perforation').prop('selectedIndex',0);
                $('#location').val('');
                $('#supplierId').val('');
                $('#notes').val('');
                $('#sizeWidth').val('');
                $('#repeatLength').val('');
                $('#noOfKnife').val('');
                $('#status').val('');
                $('#editModal').modal('show');
            })

            $('#confirm-btn').click(function() {
                const serviceIds = $('#serviceIds').val();
                const pitch = $('#pitch').val();
                const type = $('#type').val();
                const gear = $('#gear').val();
                const shape = $('#shape').val();
                const bladeType = $('#bladeType').val();
                const cutType = $('#cutType').val();
                const cutPosition = $('#cutPosition').val();
                const cornerRadius = $('#cornerRadius').val();
                const sizeAcross = $('#sizeAcross').val();
                const sizeAround = $('#sizeAround').val();
                const noAcross = $('#noAcross').val();
                const noAround = $('#noAround').val();
                const gapAcross = $('#gapAcross').val();
                const gapAround = $('#gapAround').val();
                const centerToCenterAcross = $('#centerToCenterAcross').val();
                const centerToCenterAround = $('#centerToCenterAround').val();
                const liner = $('#liner').val();
                const perforation = $('#perforation').val();
                const location = $('#location').val();
                const supplierId = $('#supplierId').val();
                const notes = $('#notes').val();
                const sizeWidth = $('#sizeWidth').val();
                const repeatLength = $('#repeatLength').val();
                const noOfKnife = $('#noOfKnife').val();
                const status = $('#status').val();
                $.ajax({
                    url: '/upsert',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id : globalId,
                        serviceIds : serviceIds,
                        pitch : pitch,
                        type : type,
                        gear : gear,
                        shape : shape,
                        bladeType : bladeType,
                        cutType : cutType,
                        cutPosition : cutPosition,
                        cornerRadius : cornerRadius,
                        sizeAcross : sizeAcross,
                        sizeAround : sizeAround,
                        noAcross : noAcross,
                        noAround : noAround,
                        gapAcross : gapAcross,
                        gapAround : gapAround,
                        centerToCenterAcross : centerToCenterAcross,
                        centerToCenterAround : centerToCenterAround,
                        liner : liner,
                        perforation : perforation,
                        location : location,
                        supplierId : supplierId,
                        notes : notes,
                        sizeWidth : sizeWidth,
                        repeatLength : repeatLength,
                        noOfKnife : noOfKnife,
                        status : status
                    },
                    success: function(res) {
                        console.log(res);
                        if (res === '1') {
                            alert('Success!');
                            // $('#editModal').modal('hide');
                            window.location.reload();
                        } else {
                            alert('Something went wrong!');
                        }
                    },
                    error: function(err) {
                        console.log(err);
                        alert("Failed!");
                    }
                })
            })

            $('#export-btn').click(function() {
                $.ajax({
                    url: '/export',
                    type: 'GET',
                    success: function(res) {
                        console.log(res);
                        if (res === '1') alert("Success!");
                        else alert("Something went wrong!");
                    },
                    error: function(err) {
                        console.log(err);
                        alert("Failed!");
                    }
                })
            })

            $('#delete-btn').click(function() {
                $.ajax({
                    url: '/delete/' + globalId,
                    type: 'GET',
                    success: function(res) {
                        console.log(res);
                        if (res === '1') {
                            alert("Success!");
                            window.location.reload();
                        }
                        else alert("Something went wrong!");
                    },
                    error: function(err) {
                        console.log(err);
                        alert("Failed!");
                    }
                })
            })

            $('#upload-btn').click(function() {
                if (!$('#input-excel').val()) alert("You didn't select xlsx file!");
                else {
                    let reader = new FileReader();
                    reader.readAsArrayBuffer($('#input-excel')[0].files[0]);
                    reader.onload = function(e) {
                        let data = new Uint8Array(reader.result);
                        let wb = XLSX.read(data,{type:'array'});
                        let sheet_name_list = wb.SheetNames;
                        let dataj = XLSX.utils.sheet_to_json(wb.Sheets[sheet_name_list[0]], {raw: true, defval:null});
                        let newData = dataj.map(obj => {
                            let tempObj = {};
                            Object.keys(obj).map(key => {
                                if(key.indexOf('__EMPTY') < 0 && key !== 'ID') tempObj[key] = obj[key];
                            });
                            return tempObj;
                        })
                        console.log(newData)
                        $.ajax({
                            url: '/upload',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                content: JSON.stringify(newData)
                            },
                            success: function (res) {
                                console.log(res);
                                if (res === '1') alert ("Database created successfully!");
                                else alert ("Something went wrong!");
                            },
                            error: function (err) {
                                console.log(err);
                                alert ("Failed!");
                            }
                        })
                        // var table = $('#example').DataTable({
                        //     data: dataj,
                        //     columns: Object.keys(dataj[0]).map(function(key) {
                        //         return { title: key, data: key };
                        //     }),
                        //     scrollX: true
                        // });
                    }
                }
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
