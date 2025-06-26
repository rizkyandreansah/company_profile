@extends('layouts.editor')
@section('title')
    Profile Perusahaan
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Profile Perusahaan</h1>
        
        <form action="" id="form_cari" method="post">
            @csrf
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Cari profil perusahaan" name="cari" id="cari">
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
            <h6 class="m-0 font-weight-bold text-primary">Data Profile Perusahaan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="TprofilePerusahaan" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Isi Singkat Profil</th>
                            <th>Visi</th>
                            <th>Misi</th>
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
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Profile Perusahaan</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <div class="form-group">
                        <label for="">Isi Singkat Profil <span class="text-danger">*</span></label>
                        <textarea id="isi_singkat_profil" name="isi_singkat_profil" class="form-control" rows="3" placeholder="Ketik Disini(maksimal 100 karakter)"></textarea>
                        <small class="form-text text-muted">Maksimal 100 karakter</small>
                    </div>
                    <div class="form-group">
                        <label for="">Isi Lengkap Profil <span class="text-danger">*</span></label>
                        <div style="height: 250px; overflow-y: auto; border: 1px solid #ddd; border-radius: 4px;">
                            <textarea id="isi_lengkap_profil" name="isi_lengkap_profil" class="form-control summernote" placeholder="Profil perusahaan lengkap"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Visi <span class="text-danger">*</span></label>
                        <div style="height: 250px; overflow-y: auto; border: 1px solid #ddd; border-radius: 4px;">
                            <textarea id="visi" name="visi" class="form-control summernote" placeholder="Visi perusahaan"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Misi <span class="text-danger">*</span></label>
                        <div style="height: 250px; overflow-y: auto; border: 1px solid #ddd; border-radius: 4px;">
                            <textarea id="misi" name="misi" class="form-control summernote" placeholder="Misi perusahaan"></textarea>
                        </div>
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
<form id="updateForm" method="post">
    @csrf
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Profile Perusahaan</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <input type="hidden" id="id_update" name="id" class="form-control">
                    <div class="form-group">
                        <label for="">Isi Singkat Profil <span class="text-danger">*</span></label>
                        <textarea id="isi_singkat_profil_update" name="isi_singkat_profil" class="form-control" rows="3" placeholder="Ringkasan profil perusahaan (maksimal 100 karakter)"></textarea>
                        <small class="form-text text-muted">Maksimal 100 karakter</small>
                    </div>
                    <div class="form-group">
                        <label for="">Isi Lengkap Profil <span class="text-danger">*</span></label>
                        <div style="height: 250px; overflow-y: auto; border: 1px solid #ddd; border-radius: 4px;">
                            <textarea id="isi_lengkap_profil_update" name="isi_lengkap_profil" class="form-control summernote" placeholder="Profil perusahaan lengkap"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Visi <span class="text-danger">*</span></label>
                        <div style="height: 250px; overflow-y: auto; border: 1px solid #ddd; border-radius: 4px;">
                            <textarea id="visi_update" name="visi" class="form-control summernote" placeholder="Visi perusahaan"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Misi <span class="text-danger">*</span></label>
                        <div style="height: 250px; overflow-y: auto; border: 1px solid #ddd; border-radius: 4px;">
                            <textarea id="misi_update" name="misi" class="form-control summernote" placeholder="Misi perusahaan"></textarea>
                        </div>
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
                <p>Apakah Anda yakin ingin menghapus data profile perusahaan ini?</p>
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

@section('style')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<style>
    /* Custom Summernote Styles */
    .note-editor {
        border: none !important;
        box-shadow: none !important;
    }
    
    .note-editor .note-editing-area {
        height: 200px !important;
        overflow-y: auto !important;
    }
    
    .note-toolbar {
        border-bottom: 1px solid #ddd !important;
        background-color: #f8f9fa !important;
        padding: 5px !important;
    }
    
    .note-editable {
        padding: 10px !important;
        min-height: 180px !important;
    }
    
    /* Hide default textarea border when summernote is active */
    .summernote + .note-editor {
        border: none !important;
    }
    
    /* Modal body scrolling */
    .modal-body {
        padding-right: 15px !important;
    }
    
    /* Prevent modal content overflow */
    .modal-xl .modal-content {
        max-height: 90vh;
        overflow: hidden;
    }
</style>
@endsection

@section('script')
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<!-- Summernote Language Pack (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-id-ID.min.js"></script>

<script>
    // Initialize Summernote
    function initSummernote() {
        $('.summernote').summernote({
            height: 180,
            minHeight: 180,
            maxHeight: 180,
            focus: false,
            lang: 'id-ID',
            placeholder: 'Tulis konten di sini...',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview']]
            ],
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica Neue', 'Helvetica', 'Impact', 'Lucida Grande', 'Tahoma', 'Times New Roman', 'Verdana'],
            fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '36', '48'],
            callbacks: {
                onInit: function() {
                    console.log('Summernote is initialized');
                    // Hide the original textarea
                    $(this).hide();
                },
                onPaste: function (e) {
                    var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                    e.preventDefault();
                    setTimeout(function () {
                        document.execCommand('insertText', false, bufferText);
                    }, 10);
                }
            }
        });
    }
    
    // Destroy Summernote
    function destroySummernote() {
        $('.summernote').summernote('destroy');
    }
    
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
    
    $(document).ready(function(e){
        // Initialize Summernote on page load
        initSummernote();
        
        var deleteId = null; // Store ID for deletion
        
        var TprofilePerusahaan = $('#TprofilePerusahaan').DataTable({
            "responsive": true,
            'searching': false,
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "paging":true,
            "ajax":{
                "url":"{{ route('editor.profile-perusahaan.data') }}",
                "data":function(parm){
                    parm.search = function(){
                        return $('#cari').val()
                    }
                },
            },
            "columns":[
                {
                    "data": "isi_singkat_profil","orderable":false,
                    render: function(data, type, row) {
                        return data.length > 100 ? data.substr(0, 100) + '...' : data;
                    }
                },
                {
                    "data": "visi","orderable":false,
                    render: function(data, type, row) {
                        // Strip HTML tags and limit length
                        var plainText = data.replace(/<[^>]*>/g, '');
                        return plainText.length > 80 ? plainText.substr(0, 80) + '...' : plainText;
                    }
                },
                {
                    "data": "misi","orderable":false,
                    render: function(data, type, row) {
                        // Strip HTML tags and limit length
                        var plainText = data.replace(/<[^>]*>/g, '');
                        return plainText.length > 80 ? plainText.substr(0, 80) + '...' : plainText;
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
            TprofilePerusahaan.draw();
        }
        
        $("#add_new").click(function(){
            // Reset form
            $('#addForm')[0].reset();
            // Reset summernote content
            $('#isi_lengkap_profil').summernote('reset');
            $('#visi').summernote('reset');
            $('#misi').summernote('reset');
            $("#addModal").modal("show");
        });
        
        $("#proses_add").click(function(){
            // Get summernote content
            var isiLengkapProfil = $('#isi_lengkap_profil').summernote('code');
            var visi = $('#visi').summernote('code');
            var misi = $('#misi').summernote('code');
            
            var postData = $("#addForm").serialize();
            // Add summernote content to formData
            postData += '&isi_lengkap_profil=' + encodeURIComponent(isiLengkapProfil);
            postData += '&visi=' + encodeURIComponent(visi);
            postData += '&misi=' + encodeURIComponent(misi);
            
            $.ajax({
                url:"{{ route('editor.profile-perusahaan.store') }}",
                data:postData,
                type:"POST",
                dataType:"JSON",
                beforeSend: function(){
                    $('.loading-clock').css('display','flex');
                },
                success:function(data){
                    if(data.success == 1){
                        $('#addForm')[0].reset();
                        $('#isi_lengkap_profil').summernote('reset');
                        $('#visi').summernote('reset');
                        $('#misi').summernote('reset');
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
            var table = $('#TprofilePerusahaan').DataTable();
            var data = table.row(row).data();
            var id = data.id;
            
            $.ajax({
                url: "{{ route('editor.profile-perusahaan.detail') }}",
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
                        $('#isi_singkat_profil_update').val(data.isi_singkat_profil);
                        $('#isi_lengkap_profil_update').summernote('code', data.isi_lengkap_profil);
                        $('#visi_update').summernote('code', data.visi);
                        $('#misi_update').summernote('code', data.misi);
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
            // Get summernote content
            var isiLengkapProfil = $('#isi_lengkap_profil_update').summernote('code');
            var visi = $('#visi_update').summernote('code');
            var misi = $('#misi_update').summernote('code');
            
            var postData = $("#updateForm").serialize();
            // Add summernote content to formData
            postData += '&isi_lengkap_profil=' + encodeURIComponent(isiLengkapProfil);
            postData += '&visi=' + encodeURIComponent(visi);
            postData += '&misi=' + encodeURIComponent(misi);
            
            $.ajax({
                url:"{{ route('editor.profile-perusahaan.update') }}",
                data:postData,
                type:"POST",
                dataType:"JSON",
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
            var table = $('#TprofilePerusahaan').DataTable();
            var data = table.row(row).data();
            deleteId = data.id;
            $('#deleteModal').modal('show');
        });
        
        $("#confirm_delete").click(function(){
            if(deleteId !== null){
                $.ajax({
                    url: "{{ route('editor.profile-perusahaan.delete') }}",
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
        
        // Reset summernote when modals are hidden
        $('#addModal').on('hidden.bs.modal', function () {
            $('#isi_lengkap_profil').summernote('reset');
            $('#visi').summernote('reset');
            $('#misi').summernote('reset');
        });
        
        $('#updateModal').on('hidden.bs.modal', function () {
            $('#isi_lengkap_profil_update').summernote('reset');
            $('#visi_update').summernote('reset');
            $('#misi_update').summernote('reset');
        });
    });
</script>
@endsection