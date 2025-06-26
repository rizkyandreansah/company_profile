@extends('layouts.editor')
@section('title')
    Keunggulan Kami
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Keunggulan Kami</h1>
        
        <form action="" id="form_cari" method="post">
            @csrf
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Cari keunggulan" name="cari" id="cari">
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
            <h6 class="m-0 font-weight-bold text-primary">Data Keunggulan Kami</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="TkeunggulanKami" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Gambar Ikon</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Urutan</th>
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
<form id="addForm" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Keunggulan Kami</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <div class="form-group">
                        <label for="">Gambar Ikon</label>
                        <input type="file" id="gambar_ikon" name="gambar_ikon" class="form-control-file" accept="image/*">
                        <small class="form-text text-muted">Format: JPG, PNG, GIF, SVG. Maksimal 2MB.</small>
                        <div id="preview_add" class="mt-2" style="display: none;">
                            <img id="img_preview_add" src="" alt="Preview" style="max-width: 150px; max-height: 150px; object-fit: cover;" class="rounded border">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Judul <span class="text-danger">*</span></label>
                        <input type="text" id="judul" name="judul" class="form-control" placeholder="Masukkan judul keunggulan" maxlength="255">
                    </div>
                    <div class="form-group">
                        <label for="">Deskripsi <span class="text-danger">*</span></label>
                        <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4" placeholder="Masukkan deskripsi keunggulan"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Urutan</label>
                        <input type="number" id="urutan" name="urutan" class="form-control" placeholder="Urutan tampil (opsional)" min="0" value="0">
                        <small class="form-text text-muted">Semakin kecil angka, semakin atas posisinya</small>
                    </div>
                    <div class="form-group">
                        <label for="">Status <span class="text-danger">*</span></label>
                        <select id="is_active" name="is_active" class="form-control">
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
<form id="updateForm" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Keunggulan Kami</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <input type="hidden" id="id_update" name="id" class="form-control">
                    <div class="form-group">
                        <label for="">Gambar Ikon</label>
                        <input type="file" id="gambar_ikon_update" name="gambar_ikon" class="form-control-file" accept="image/*">
                        <small class="form-text text-muted">Format: JPG, PNG, GIF, SVG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</small>
                        <div id="current_image" class="mt-2">
                            <label class="text-muted">Gambar Saat Ini:</label>
                            <div id="current_img_container"></div>
                        </div>
                        <div id="preview_update" class="mt-2" style="display: none;">
                            <label class="text-muted">Preview Gambar Baru:</label>
                            <img id="img_preview_update" src="" alt="Preview" style="max-width: 150px; max-height: 150px; object-fit: cover;" class="rounded border">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Judul <span class="text-danger">*</span></label>
                        <input type="text" id="judul_update" name="judul" class="form-control" placeholder="Masukkan judul keunggulan" maxlength="255">
                    </div>
                    <div class="form-group">
                        <label for="">Deskripsi <span class="text-danger">*</span></label>
                        <textarea id="deskripsi_update" name="deskripsi" class="form-control" rows="4" placeholder="Masukkan deskripsi keunggulan"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Urutan</label>
                        <input type="number" id="urutan_update" name="urutan" class="form-control" placeholder="Urutan tampil (opsional)" min="0">
                        <small class="form-text text-muted">Semakin kecil angka, semakin atas posisinya</small>
                    </div>
                    <div class="form-group">
                        <label for="">Status <span class="text-danger">*</span></label>
                        <select id="is_active_update" name="is_active" class="form-control">
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
                <p>Apakah Anda yakin ingin menghapus data keunggulan ini?</p>
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
    // Toastr functions (assuming these are defined globally)
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

    // Preview image function
    function previewImage(input, previewContainer, imgElement) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(imgElement).attr('src', e.target.result);
                $(previewContainer).show();
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            $(previewContainer).hide();
        }
    }
    
    $(document).ready(function(e){
        var deleteId = null; // Store ID for deletion
        
        var TkeunggulanKami = $('#TkeunggulanKami').DataTable({
            "responsive": true,
            'searching': false,
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "paging":true,
            "ajax":{
                "url":"{{ route('editor.keunggulan-kami.data') }}",
                "data":function(parm){
                    parm.search = function(){
                        return $('#cari').val()
                    }
                },
            },
            "columns":[
                {
                    "data": "gambar_ikon","orderable":false
                },
                {
                    "data": "judul","orderable":false,
                    render: function(data, type, row) {
                        return data.length > 50 ? data.substr(0, 50) + '...' : data;
                    }
                },
                {
                    "data": "deskripsi","orderable":false,
                    render: function(data, type, row) {
                        // Strip HTML tags and limit length
                        var plainText = data.replace(/<[^>]*>/g, '');
                        return plainText.length > 100 ? plainText.substr(0, 100) + '...' : plainText;
                    }
                },
                {
                    "data": "urutan","orderable":false
                },
                {
                    "data": "is_active","orderable":false
                },
                {
                    "data": "action","orderable":false
                },
            ]
        });
        
        function redraw(){
            TkeunggulanKami.draw();
        }
        
        // Image preview for add form
        $('#gambar_ikon').change(function() {
            previewImage(this, '#preview_add', '#img_preview_add');
        });
        
        // Image preview for update form
        $('#gambar_ikon_update').change(function() {
            previewImage(this, '#preview_update', '#img_preview_update');
        });
        
        $("#add_new").click(function(){
            // Reset form
            $('#addForm')[0].reset();
            $('#preview_add').hide();
            $("#addModal").modal("show");
        });
        
        $("#proses_add").click(function(){
            var formData = new FormData($('#addForm')[0]);
            
            $.ajax({
                url:"{{ route('editor.keunggulan-kami.store') }}",
                data: formData,
                type:"POST",
                processData: false,
                contentType: false,
                beforeSend: function(){
                    $('.loading-clock').css('display','flex');
                },
                success:function(data){
                    if(data.success == 1){
                        $('#addForm')[0].reset();
                        $('#preview_add').hide();
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
            var id = $(this).data('id');
            
            $.ajax({
                url: "{{ route('editor.keunggulan-kami.detail') }}",
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
                        $('#judul_update').val(data.judul);
                        $('#deskripsi_update').val(data.deskripsi);
                        $('#urutan_update').val(data.urutan);
                        $('#is_active_update').val(data.is_active);
                        
                        // Show current image
                        if (data.gambar_ikon) {
                            $('#current_img_container').html('<img src="/storage/' + data.gambar_ikon + '" alt="Current Image" style="max-width: 150px; max-height: 150px; object-fit: cover;" class="rounded border">');
                        } else {
                            $('#current_img_container').html('<div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="width: 150px; height: 150px;"><i class="fas fa-image text-white"></i><br><small class="text-white">Tidak ada gambar</small></div>');
                        }
                        
                        $('#preview_update').hide();
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
                url:"{{ route('editor.keunggulan-kami.update') }}",
                data: formData,
                type:"POST",
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
            deleteId = $(this).data('id');
            $('#deleteModal').modal('show');
        });
        
        $("#confirm_delete").click(function(){
            if(deleteId !== null){
                $.ajax({
                    url: "{{ route('editor.keunggulan-kami.delete') }}",
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
        
        // Reset forms when modals are hidden
        $('#addModal').on('hidden.bs.modal', function () {
            $('#addForm')[0].reset();
            $('#preview_add').hide();
        });
        
        $('#updateModal').on('hidden.bs.modal', function () {
            $('#updateForm')[0].reset();
            $('#preview_update').hide();
            $('#current_img_container').empty();
        });
    });
</script>
@endsection