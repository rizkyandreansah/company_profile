@extends('layouts.editor')
@section('title')
    Manajemen Footer
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Footer</h1>
        
        <form action="" id="form_cari" method="post">
            @csrf
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Cari footer" name="cari" id="cari">
                <div class="input-group-append">
                    <button type="button" id="add_new" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Tambah Data</button>
                  <button class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm" type="button" id="btn-cari">Cari</button>
                </div>
              </div>
        </form>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Footer</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="Tfooter" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Profil Singkat</th>
                            <th>Alamat Kantor</th>
                            <th>Status</th>
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
<form id="addForm" method="post">
    @csrf
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Footer</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <div class="form-group">
                        <label for="">Profil Singkat <span class="text-danger">*</span></label>
                        <textarea id="profil_singkat" name="profil_singkat" class="form-control" rows="4" placeholder="Profil singkat perusahaan" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat Kantor <span class="text-danger">*</span></label>
                        <textarea id="alamat_kantor" name="alamat_kantor" class="form-control" rows="3" placeholder="Alamat lengkap kantor" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Status <span class="text-danger">*</span></label>
                        <select id="is_active" name="is_active" class="form-control" required>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button type="button" id="proses_add" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Update Modal -->
<form id="updateForm" method="post">
    @csrf
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Data Footer</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <input type="hidden" id="id_update" name="id" class="form-control">
                    <div class="form-group">
                        <label for="">Profil Singkat <span class="text-danger">*</span></label>
                        <textarea id="profil_singkat_update" name="profil_singkat" class="form-control" rows="4" placeholder="Profil singkat perusahaan" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat Kantor <span class="text-danger">*</span></label>
                        <textarea id="alamat_kantor_update" name="alamat_kantor" class="form-control" rows="3" placeholder="Alamat lengkap kantor" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Status <span class="text-danger">*</span></label>
                        <select id="is_active_update" name="is_active" class="form-control" required>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button type="button" id="proses_update" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data footer ini?</p>
                <p class="text-danger">Data yang dihapus tidak dapat dikembalikan!</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <button class="btn btn-danger" type="button" id="confirm_delete">Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-clock" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div class="spinner-border text-light" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
@endsection

@section('script')
<script>
    // Toastr functions
    function toastr_success(message) {
        if (typeof toastr !== 'undefined') {
            toastr.success(message);
        } else {
            alert('Success: ' + message);
        }
    }
    
    function toastr_error(message) {
        if (typeof toastr !== 'undefined') {
            toastr.error(message);
        } else {
            alert('Error: ' + message);
        }
    }
    
    $(document).ready(function(e){
        var deleteId = null; // Store ID for deletion
        
        var Tfooter = $('#Tfooter').DataTable({
            "responsive": true,
            'searching': false,
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "paging":true,
            "ajax":{
                "url":"{{ route('editor.footer.data') }}",
                "data":function(parm){
                    parm.search = function(){
                        return $('#cari').val()
                    }
                },
            },
            "columns":[
                {
                    "data": "profil_singkat","orderable":false,
                    render: function(data, type, row) {
                        return data.length > 80 ? data.substr(0, 80) + '...' : data;
                    }
                },
                {
                    "data": "alamat_kantor","orderable":false,
                    render: function(data, type, row) {
                        return data.length > 60 ? data.substr(0, 60) + '...' : data;
                    }
                },
                {
                    "data": "is_active","orderable":false,
                    render: function(data, type, row) {
                        return data == 1 ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-secondary">Tidak Aktif</span>';
                    }
                },
                {
                    "data": "id","orderable":false,render: function ( data, type, row ){
                        var idData = row.id;
                        let btn ='<div class="btn-group" role="group" aria-label="Actions">';
                        btn += '<button type="button" class="btn btn-sm btn-warning btnUpdate" title="Edit"><i class="fa fa-edit"></i></button>';
                        btn += '<button type="button" class="btn btn-sm btn-danger btnDelete" title="Delete"><i class="fa fa-trash"></i></button>';
                        btn += '</div>';
                        return btn;
                    }
                },
            ]
        });
        
        function redraw(){
            Tfooter.draw();
        }
        
        $("#add_new").click(function(){
            // Reset form
            $('#addForm')[0].reset();
            $("#addModal").modal("show");
        });
        
        $("#proses_add").click(function(){
            var formData = new FormData($('#addForm')[0]);
            
            $.ajax({
                url:"{{ route('editor.footer.store') }}",
                data: formData,
                type:"POST",
                dataType:"JSON",
                processData: false,
                contentType: false,
                beforeSend: function(){
                    $('.loading-clock').css('display','flex');
                },
                success:function(data){
                    if(data.success == 1){
                        $('#addForm')[0].reset();
                        $("#addModal").modal("hide");
                        toastr_success(data.messages);
                        redraw();
                    }else{
                        toastr_error(data.messages);
                    }
                },
                complete: function(){
                    $('.loading-clock').css('display','none');
                },
                error: function(xhr, status, error) {
                    toastr_error('Terjadi kesalahan pada server');
                    $('.loading-clock').css('display','none');
                }
            });
        });
        
        // Search functionality
        $("#btn-cari").click(function(){
            redraw();
        });
        
        $("#cari").keypress(function(event){
            if(event.which == 13){
                redraw();
            }
        });
        
        // Update functionality
        $(document).on('click', '.btnUpdate', function(){
            var row = $(this).closest('tr');
            var table = $('#Tfooter').DataTable();
            var data = table.row(row).data();
            var id = data.id;
            
            $.ajax({
                url: "{{ route('editor.footer.detail') }}",
                type: "GET",
                data: {id: id},
                dataType: "JSON",
                beforeSend: function(){
                    $('.loading-clock').css('display','flex');
                },
                success: function(response){
                    if(response.success == 1){
                        var data = response.data;
                        $('#id_update').val(data.id);
                        $('#profil_singkat_update').val(data.profil_singkat);
                        $('#alamat_kantor_update').val(data.alamat_kantor);
                        $('#is_active_update').val(data.is_active);
                        
                        $('#updateModal').modal('show');
                    } else {
                        toastr_error(response.messages);
                    }
                },
                complete: function(){
                    $('.loading-clock').css('display','none');
                },
                error: function(){
                    toastr_error('Terjadi kesalahan saat mengambil data');
                    $('.loading-clock').css('display','none');
                }
            });
        });
        
        $("#proses_update").click(function(){
            var formData = new FormData($('#updateForm')[0]);
            
            $.ajax({
                url:"{{ route('editor.footer.update') }}",
                data: formData,
                type:"POST",
                dataType:"JSON",
                processData: false,
                contentType: false,
                beforeSend: function(){
                    $('.loading-clock').css('display','flex');
                },
                success:function(data){
                    if(data.success == 1){
                        $("#updateModal").modal("hide");
                        toastr_success(data.messages);
                        redraw();
                    }else{
                        toastr_error(data.messages);
                    }
                },
                complete: function(){
                    $('.loading-clock').css('display','none');
                },
                error: function(xhr, status, error) {
                    toastr_error('Terjadi kesalahan pada server');
                    $('.loading-clock').css('display','none');
                }
            });
        });
        
        // Delete functionality
        $(document).on('click', '.btnDelete', function(){
            var row = $(this).closest('tr');
            var table = $('#Tfooter').DataTable();
            var data = table.row(row).data();
            deleteId = data.id;
            $('#deleteModal').modal('show');
        });
        
        $("#confirm_delete").click(function(){
            if(deleteId !== null){
                $.ajax({
                    url: "{{ route('editor.footer.delete') }}",
                    type: "DELETE",
                    data: {
                        id: deleteId,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "JSON",
                    beforeSend: function(){
                        $('.loading-clock').css('display','flex');
                    },
                    success: function(response){
                        if(response.success == 1){
                            $('#deleteModal').modal('hide');
                            toastr_success(response.messages);
                            redraw();
                        } else {
                            toastr_error(response.messages);
                        }
                        deleteId = null;
                    },
                    complete: function(){
                        $('.loading-clock').css('display','none');
                    },
                    error: function(){
                        toastr_error('Terjadi kesalahan saat menghapus data');
                        $('.loading-clock').css('display','none');
                    }
                });
            }
        });
    });
</script>
@endsection