@extends('layouts.editor')
@section('title')
    Alamat Kantor
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Alamat Kantor</h1>
        
        <form action="" id="form_cari" method="post">
            @csrf
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Cari alamat kantor" name="cari" id="cari">
                <div class="input-group-append">
                    <button type="button" id="add_new" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Tambah Alamat</button>
                    <button class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm" type="button" id="btn-cari">Cari</button>
                </div>
            </div>
        </form>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Alamat Kantor</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="TalamatKantor" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Alamat</th>
                            <th>No. Telepon</th>
                            <th>Email</th>
                            <th>Link Maps</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Alamat Kantor Baru</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="addForm" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="alamat">Alamat <span class="text-danger">*</span></label>
                        <textarea id="alamat" name="alamat" class="form-control" rows="4" placeholder="Masukkan alamat lengkap kantor" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="no_telepon">No. Telepon <span class="text-danger">*</span></label>
                        <input type="text" id="no_telepon" name="no_telepon" class="form-control" placeholder="Masukkan nomor telepon" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email kantor" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="link_maps">Link Google Maps</label>
                        <input type="url" id="link_maps" name="link_maps" class="form-control" placeholder="Masukkan link Google Maps (opsional)">
                        <small class="form-text text-muted">Contoh: https://maps.google.com/...</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button type="button" id="proses_add" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Alamat Kantor</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="updateForm" method="post">
                @csrf
                <input type="hidden" id="id_update" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="alamat_update">Alamat <span class="text-danger">*</span></label>
                        <textarea id="alamat_update" name="alamat" class="form-control" rows="4" placeholder="Masukkan alamat lengkap kantor" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="no_telepon_update">No. Telepon <span class="text-danger">*</span></label>
                        <input type="text" id="no_telepon_update" name="no_telepon" class="form-control" placeholder="Masukkan nomor telepon" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email_update">Email <span class="text-danger">*</span></label>
                        <input type="email" id="email_update" name="email" class="form-control" placeholder="Masukkan email kantor" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="link_maps_update">Link Google Maps</label>
                        <input type="url" id="link_maps_update" name="link_maps" class="form-control" placeholder="Masukkan link Google Maps (opsional)">
                        <small class="form-text text-muted">Contoh: https://maps.google.com/...</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button type="button" id="proses_update" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('style')
@endsection

@section('script')
<script>
$(document).ready(function() {
    // Initialize DataTable
    var TalamatKantor = $('#TalamatKantor').DataTable({
        "responsive": true,
        'searching': false,
        "processing": true,
        "serverSide": true,
        "pagingType": "full_numbers",
        "paging": true,
        "ajax": {
            "url": "{{ route('editor.alamat-kantor.data') }}",
            "data": function(parm) {
                parm.search = function(){
                    return $('#cari').val();
                }
            },
        },
        "columns": [
            {
                "data": "alamat",
                "orderable": false,
                render: function(data, type, row) {
                    return data && data.length > 50 ? data.substr(0, 50) + '...' : data || '';
                }
            },
            {
                "data": "no_telepon",
                "orderable": false,
                render: function(data, type, row) {
                    return data || '';
                }
            },
            {
                "data": "email",
                "orderable": false,
                render: function(data, type, row) {
                    return data || '';
                }
            },
            {
                "data": "link_maps",
                "orderable": false,
                render: function(data, type, row) {
                    if (data) {
                        return '<a href="' + data + '" target="_blank" class="btn btn-sm btn-info">Lihat Maps</a>';
                    }
                    return '<span class="text-muted">Tidak ada</span>';
                }
            },
            {
                "data": "id",
                "orderable": false,
                render: function(data, type, row) {
                    var btn = '<div class="btn-group" role="group" aria-label="Actions">';
                    btn += '<button type="button" class="btn btn-sm btn-warning btnUpdate" title="Edit"><i class="fa fa-edit"></i></button>';
                    btn += '<button type="button" class="btn btn-sm btn-danger btnDelete" title="Delete"><i class="fa fa-trash"></i></button>';
                    btn += '</div>';
                    return btn;
                }
            }
        ]
    });

    function redraw() {
        TalamatKantor.draw();
    }

    // Add New Button
    $("#add_new").click(function() {
        $("#addForm")[0].reset();
        $("#addModal").modal("show");
    });

    // Add Form Submit
    $("#proses_add").click(function() {
        var postData = new FormData($("#addForm")[0]);
        
        $.ajax({
            url: "{{ route('editor.alamat-kantor.store') }}",
            data: postData,
            type: "POST",
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                if(typeof $('.loading-clock') !== 'undefined'){
                    $('.loading-clock').css('display','flex');
                }
            },
            success: function(data) {
                if (data.success == 1) {
                    $('#addForm')[0].reset();
                    $("#addModal").modal("hide");
                    if (typeof toastr_success === 'function') {
                        toastr_success(data.messages);
                    } else if (typeof toastr !== 'undefined') {
                        toastr.success(data.messages);
                    } else {
                        alert(data.messages);
                    }
                    redraw();
                } else {
                    if (typeof toastr_error === 'function') {
                        toastr_error(data.messages);
                    } else if (typeof toastr !== 'undefined') {
                        toastr.error(data.messages);
                    } else {
                        alert(data.messages);
                    }
                }
            },
            error: function(xhr, status, error) {
                console.log('Error:', xhr.responseText);
                if (typeof toastr_error === 'function') {
                    toastr_error('Terjadi kesalahan saat menyimpan data');
                } else if (typeof toastr !== 'undefined') {
                    toastr.error('Terjadi kesalahan saat menyimpan data');
                } else {
                    alert('Terjadi kesalahan saat menyimpan data');
                }
            },
            complete: function() {
                if(typeof $('.loading-clock') !== 'undefined'){
                    $('.loading-clock').css('display','none');
                }
            }
        });
    });

    // Search Button
    $("#btn-cari").click(function() {
        TalamatKantor.draw();
    });

    // Search on Enter
    $('#cari').keypress(function(e) {
        if (e.which == 13) {
            e.preventDefault();
            $('#btn-cari').click();
        }
    });

    // Update Button
    $("#TalamatKantor tbody").on('click', '.btnUpdate', function() {
        let data = TalamatKantor.row($(this).parents('tr')).data();
        let idData = data.id;
        
        $.ajax({
            url: "{{ route('editor.alamat-kantor.detail') }}",
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}",
                'id': idData
            },
            dataType: "JSON",
            cache: false,
            beforeSend: function(){
                if(typeof $('.loading-clock') !== 'undefined'){
                    $('.loading-clock').css('display','flex');
                }
            },
            success: function(data) {
                if (data.success == 1) {
                    var alamatData = data.data;
                    $("#id_update").val(alamatData.id);
                    $("#alamat_update").val(alamatData.alamat);
                    $("#no_telepon_update").val(alamatData.no_telepon);
                    $("#email_update").val(alamatData.email);
                    $("#link_maps_update").val(alamatData.link_maps);
                    $("#updateModal").modal("show");
                } else {
                    if (typeof toastr_error === 'function') {
                        toastr_error(data.messages);
                    } else if (typeof toastr !== 'undefined') {
                        toastr.error(data.messages);
                    } else {
                        alert(data.messages);
                    }
                }
            },
            error: function(xhr, status, error) {
                if (typeof toastr_error === 'function') {
                    toastr_error('Terjadi kesalahan saat mengambil data');
                } else if (typeof toastr !== 'undefined') {
                    toastr.error('Terjadi kesalahan saat mengambil data');
                } else {
                    alert('Terjadi kesalahan saat mengambil data');
                }
            },
            complete: function(){
                if(typeof $('.loading-clock') !== 'undefined'){
                    $('.loading-clock').css('display','none');
                }
            }
        });
    });

    // Update Form Submit
    $("#proses_update").click(function() {
        var postData = new FormData($("#updateForm")[0]);
        
        $.ajax({
            url: "{{ route('editor.alamat-kantor.update') }}",
            data: postData,
            type: "POST",
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                if(typeof $('.loading-clock') !== 'undefined'){
                    $('.loading-clock').css('display','flex');
                }
            },
            success: function(data) {
                if (data.success == 1) {
                    $('#updateForm')[0].reset();
                    $("#updateModal").modal("hide");
                    if (typeof toastr_success === 'function') {
                        toastr_success(data.messages);
                    } else if (typeof toastr !== 'undefined') {
                        toastr.success(data.messages);
                    } else {
                        alert(data.messages);
                    }
                    redraw();
                } else {
                    if (typeof toastr_error === 'function') {
                        toastr_error(data.messages);
                    } else if (typeof toastr !== 'undefined') {
                        toastr.error(data.messages);
                    } else {
                        alert(data.messages);
                    }
                }
            },
            error: function(xhr, status, error) {
                console.log('Error:', xhr.responseText);
                if (typeof toastr_error === 'function') {
                    toastr_error('Terjadi kesalahan saat mengupdate data');
                } else if (typeof toastr !== 'undefined') {
                    toastr.error('Terjadi kesalahan saat mengupdate data');
                } else {
                    alert('Terjadi kesalahan saat mengupdate data');
                }
            },
            complete: function(){
                if(typeof $('.loading-clock') !== 'undefined'){
                    $('.loading-clock').css('display','none');
                }
            }
        });
    });

    // Delete Button
    $("#TalamatKantor tbody").on('click', '.btnDelete', function() {
        let data = TalamatKantor.row($(this).parents('tr')).data();
        let idData = data.id;
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data alamat kantor akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('editor.alamat-kantor.delete') }}",
                    type: "DELETE",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': idData
                    },
                    dataType: "JSON",
                    cache: false,
                    beforeSend: function(){
                        if(typeof $('.loading-clock') !== 'undefined'){
                            $('.loading-clock').css('display','flex');
                        }
                    },
                    success: function(data) {
                        if (data.success == 1) {
                            if (typeof toastr_success === 'function') {
                                toastr_success(data.messages);
                            } else if (typeof toastr !== 'undefined') {
                                toastr.success(data.messages);
                            } else {
                                alert(data.messages);
                            }
                            redraw();
                        } else {
                            if (typeof toastr_error === 'function') {
                                toastr_error(data.messages);
                            } else if (typeof toastr !== 'undefined') {
                                toastr.error(data.messages);
                            } else {
                                alert(data.messages);
                            }
                        }
                    },
                    complete: function(){
                        if(typeof $('.loading-clock') !== 'undefined'){
                            $('.loading-clock').css('display','none');
                        }
                    },
                    error: function() {
                        if (typeof toastr_error === 'function') {
                            toastr_error('Terjadi kesalahan saat menghapus data');
                        } else if (typeof toastr !== 'undefined') {
                            toastr.error('Terjadi kesalahan saat menghapus data');
                        } else {
                            alert('Terjadi kesalahan saat menghapus data');
                        }
                        if(typeof $('.loading-clock') !== 'undefined'){
                            $('.loading-clock').css('display','none');
                        }
                    }
                });
            }
        });
    });

    // Reset forms when modals are closed
    $('#addModal').on('hidden.bs.modal', function() {
        $('#addForm')[0].reset();
    });

    $('#updateModal').on('hidden.bs.modal', function() {
        $('#updateForm')[0].reset();
    });
});

// Add toastr functions if not already defined
function toastr_success(message) {
    if (typeof toastr !== 'undefined') {
        toastr.success(message);
    } else {
        alert(message);
    }
}

function toastr_error(message) {
    if (typeof toastr !== 'undefined') {
        toastr.error(message);
    } else {
        alert(message);
    }
}
</script>
@endsection