<h1 class="h3 mb-4 text-gray-800">Dataset</h1>

<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="py-3 d-flex flex-row align-items-center justify-content-between">
                    <h4 class="card-title">List Dataset</h4>
                    <div data-toggle="modal" data-target="#myModal" onclick="ClearScreen();">
                        <button class="btn btn-outline-info btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataset" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Gambar</th>
                                <th>Judul</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle" aria-hidden="true">Fill Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form method="POST" action="#">
                <div class="modal-body">
                    <div id="error_add"></div>
                    <input type="text" id="Id" class="form-control" hidden>

                    <div class="row ">
                        <div class="form-group col-lg-8">
                            <label class="placeholder">Judul</label>
                            <input type="text" class="form-control" id="judul" required="" placeholder="Input judul">
                        </div>
                        <div class="form-group col-lg-4">
                            <label class="placeholder">Gambar</label>
                            <input type="file" class="form-control" id="gambar" name="gambar">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label class="placeholder">Pengarang</label>
                            <input type="text" class="form-control" id="pengarang" required="" placeholder="Input pengarang">
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="placeholder">Penerbit</label>
                            <input type="text" class="form-control" id="penerbit" required="" placeholder="Input penerbit">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="button" id="add" class="btn btn-outline-success" value="Save" data-dismiss="modal" onclick="Save();">
                    <input type="button" id="upd" class="btn btn-outline-warning" value="Update" data-dismiss="modal" onclick="Upd();">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fas fa-times"></i>Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var table = null;
    var arrData = [];

    $(document).ready(function(){
        table = $('#dataset').DataTable({
            "processing": true,
            "responsive": true,
            "pagination": true,
            "stateSave": true,
            "ajax": {
                type: "POST",
                url: "bukuProses.php",
                dataType: "json",
                data: {
                    "sent": "all"
                },
                dataSrc: ""
            },
            "columns": [
                {
                    'render': function (data, type, row, meta) {
                        // console.log(meta.row);
                        return meta.row + 1;
                    }
                },
                {
                    "data": "gambar",
                    'render': function (jsonData) {
                        if (jsonData != null) {
                            return '<img src="images/uploads/'+ jsonData +'" alt="myPic" width="60%">';
                        }
                        return '<img src="images/default.png" alt="myPic" width="60%">';
                    }
                },
                { 'data': 'judul' },
                { 'data': 'pengarang' },
                { 'data': 'penerbit' },
                {
                    "sortable": false,
                    "render": function (data, type, row, meta) {
                        // console.log(meta.row);
                        $('[data-toggle="tooltip"]').tooltip();
                        return '<div class="form-button-action">'
                            + '<button class="btn btn-outline-warning btn-sm btn-circle" data-placement="left" data-toggle="tooltip" data-animation="false" title="Edit" onclick="return GetById(' + meta.row + ')" ><i class="fas fa-lg fa-edit"></i></button>'
                            + '&nbsp;'
                            + '<button class="btn btn-outline-danger btn-sm btn-circle" data-placement="right" data-toggle="tooltip" data-animation="false" title="Delete" onclick="return Del(' + meta.row + ')" ><i class="fas fa-lg fa-trash-alt"></i></button>'
                            + '</div>'
                    }
                }
            ],
        });
    });

    function ClearScreen() {
        $('#Id').val('');
        $('#judul').val('');
        $('#pengarang').val('');
        $('#penerbit').val('');
        $('#gambar').val('');
        $('#upd').hide();
        $('#add').show();
    }


    function GetById(number) {
        // debugger;
        var getid = table.row(number).data().id_buku;
        console.log(getid);
        $.ajax({
            url: "bukuProses.php",
            type: 'POST',
            dataType: "JSON",
            data: { 
                sent: "id",
                id: getid,
            }
        }).then((res) => {
            // debugger;
            // var data = JSON.parse(res);
            console.log(res);
            var resData = res.data;
            $('#Id').val(resData.id_buku);
            $('#judul').val(resData.judul);
            $('#pengarang').val(resData.pengarang);
            $('#penerbit').val(resData.penerbit);
            // $('#gambar').val(resData.gambar);
            $('#add').hide();
            $('#upd').show();
            $('#myModal').modal('show');
        });
    }

    function Save() {
        // debugger;
        var formData = new FormData();
        formData.append('sent', 'add');
        formData.append('judul', $('#judul').val());
        formData.append('pengarang', $('#pengarang').val());
        formData.append('penerbit', $('#penerbit').val());
        if ($('#gambar').val() != "") {
            formData.append('gambar', $('#gambar')[0].files[0]);
        }
        $.ajax({
            url: "bukuProses.php",
            type: 'POST',
            dataType: "JSON",
            enctype: 'multipart/form-data',
            cache: false,
            processData: false,
            contentType: false,
            data: formData
        }).then((result) => {
            // debugger;
            if (result.statusCode == true) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Data inserted Successfully',
                    showConfirmButton: false,
                    timer: 1500,
                })
                table.ajax.reload(null, false);
            } else {
                Swal.fire('Error', 'Failed to Input', 'error');
                ClearScreen();
            }
        })
    }

    function Upd() {
        // debugger;
        var formData = new FormData();
        formData.append('sent', 'upd');
        formData.append('Id', $('#Id').val());
        formData.append('judul', $('#judul').val());
        formData.append('pengarang', $('#pengarang').val());
        formData.append('penerbit', $('#penerbit').val());
        if ($('#gambar').val() != "") {
            formData.append('gambar', $('#gambar')[0].files[0]);
        }
        $.ajax({
            cache: false,
            url: "bukuProses.php",
            type: 'POST',
            dataType: "JSON",
            enctype: 'multipart/form-data',
            cache: false,
            processData: false,
            contentType: false,
            data: formData
        }).then((result) => {
            // debugger;
            if (result.statusCode == true) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: result.msg,
                    showConfirmButton: false,
                    timer: 1500,
                });
                table.ajax.reload(null, false);
            } else {
                Swal.fire('Error', result.msg, 'error');
                ClearScreen();
            }
        })
    }

    function Del(number) {
        // debugger;
        var getid = table.row(number).data().id_buku;
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
        }).then((resultSwal) => {
            if (resultSwal.value) {
                // debugger;
                var Data = new Object();
                Data.sent = 'del';
                Data.id = getid;
                $.ajax({
                    type: 'POST',
                    url: "bukuProses.php",
                    cache: false,
                    dataType: "JSON",
                    data: Data,
                }).then((result) => {
                    // debugger;
                    console.log(result);
                    if (result.statusCode == true) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Delete Successfully',
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        table.ajax.reload(null, false);
                    } else {
                        Swal.fire('Error', 'Failed to Delete', 'error');
                        ClearScreen();
                    }
                });
            };
        });
    }
</script>