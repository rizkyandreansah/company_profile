@extends('layouts.editor')
@section('title')
    Berita / News
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Berita</h1>
        
        <form action="" id="form_cari" method="post">
            @csrf
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Cari judul berita" name="cari" id="cari">
                <div class="input-group-append">
                    <button type="button" id="add_new" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Tambah Berita</button>
                  <button class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm" type="button" id="btn-cari">Cari</button>
                </div>
              </div>
        </form>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Berita</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="Tnews" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Isi Berita</th>
                            <th>Tanggal Publish</th>
                            <th>Status</th>
                            <th>Gambar</th>
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
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Berita Baru</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="">Judul Berita <span class="text-danger">*</span></label>
                                <input type="text" id="judul" name="judul" class="form-control" placeholder="Masukkan judul berita">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Tanggal Publish <span class="text-danger">*</span></label>
                                <input type="date" id="tanggal_publish" name="tanggal_publish" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Isi Berita <span class="text-danger">*</span></label>
                        <div style="height: 350px; overflow-y: auto; border: 1px solid #ddd; border-radius: 4px;">
                            <textarea id="isiberita" name="isiberita" class="form-control summernote" placeholder="Isi berita lengkap"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="">Gambar Berita <span class="text-danger">*</span></label>
                                <input type="file" id="file" name="file" class="form-control" onchange="ViewImage(this);" accept="image/*">
                                <small class="form-text text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB</small>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Status <span class="text-danger">*</span></label>
                                <select id="is_active" name="is_active" class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="imagev" class="my-2"></div>
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
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Berita</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="">Judul Berita <span class="text-danger">*</span></label>
                                <input type="hidden" id="id_update" name="id" class="form-control">
                                <input type="text" id="judul_update" name="judul" class="form-control" placeholder="Masukkan judul berita">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Tanggal Publish <span class="text-danger">*</span></label>
                                <input type="date" id="tanggal_publish_update" name="tanggal_publish" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Isi Berita <span class="text-danger">*</span></label>
                        <div style="height: 350px; overflow-y: auto; border: 1px solid #ddd; border-radius: 4px;">
                            <textarea id="isiberita_update" name="isiberita" class="form-control summernote" placeholder="Isi berita lengkap"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="">Gambar Berita</label>
                                <input type="file" id="file_update" name="file" class="form-control" onchange="ViewImageUp(this);" accept="image/*">
                                <small class="form-text text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar</small>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Status <span class="text-danger">*</span></label>
                                <select id="is_active_update" name="is_active" class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="imagev_update" class="my-2"></div>
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
        height: 300px !important;
        overflow-y: auto !important;
    }
    
    .note-toolbar {
        border-bottom: 1px solid #ddd !important;
        background-color: #f8f9fa !important;
        padding: 5px !important;
    }
    
    .note-editable {
        padding: 10px !important;
        min-height: 280px !important;
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
    function ViewImage(input) {
        let imagev = $('#imagev');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
            imagev.empty().append('<img id="imgv" class="img-fluid rounded" src="#" style="max-height: 300px;">');
            $('#imgv').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function ViewImageUp(input) {
        let imagev = $('#imagev_update');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
            imagev.empty().append('<img id="imgv_up" class="img-fluid rounded" src="#" style="max-height: 300px;">');
            $('#imgv_up').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    // Initialize Summernote
    function initSummernote() {
        $('.summernote').summernote({
            height: 280,
            minHeight: 280,
            maxHeight: 280,
            focus: false,
            lang: 'id-ID',
            placeholder: 'Tulis isi berita di sini...',
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
    
    $('document').ready(function(e){
        // Initialize Summernote on page load
        initSummernote();
        
        var Tnews = $('#Tnews').DataTable({
            "responsive": true,
            'searching': false,
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "paging":true,
            "ajax":{
                "url":"{{ route('editor.news.data') }}",
                "data":function(parm){
                    parm.search = function(){
                        return $('#cari').val()
                    }
                },
            },
            "columns":[
                {
                    "data": "judul","orderable":false,
                    render: function(data, type, row) {
                        return data.length > 50 ? data.substr(0, 50) + '...' : data;
                    }
                },
                {
                    "data": "isiberita","orderable":false,
                    render: function(data, type, row) {
                        // Strip HTML tags and limit text
                        var text = data.replace(/<[^>]*>/g, '');
                        return text.length > 100 ? text.substr(0, 100) + '...' : text;
                    }
                },
                {
                    "data": "tanggal_publish","orderable":false,
                    render: function(data, type, row) {
                        return new Date(data).toLocaleDateString('id-ID');
                    }
                },
                {
                    "data": "is_active","orderable":false,
                    render: function(data, type, row) {
                        return data == 1 ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-secondary">Tidak Aktif</span>';
                    }
                },
                {
                    "data": "image","orderable":false,render:function(data,type,row){
                        let img_path = row.image;
                        let img_view = '<img src="{{ asset("storage") }}/'+img_path+'" class="rounded" width="80" style="object-fit: cover; height: 60px;">';
                        return img_view;
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
            Tnews.draw();
        }
        
        $("#add_new").click(function(){
            // Set default date to today
            $('#tanggal_publish').val(new Date().toISOString().split('T')[0]);
            // Reset summernote content
            $('#isiberita').summernote('reset');
            $("#addModal").modal("show");
        });
        
        $("#proses_add").click(function(){
            // Get summernote content
            var isiberita = $('#isiberita').summernote('code');
            
            var postData = new FormData($("#addForm")[0]);
            // Make sure to set the summernote content
            postData.set('isiberita', isiberita);
            
            $.ajax({
                url:"{{ URL::route('editor.news.store') }}",
                data:postData,
                type:"POST",
                dataType:"JSON",
                cache:false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('.loading-clock').css('display','flex');
                },
                success:function(data){
                    if(data.success == 1){
                        $('#addForm')[0].reset();
                        $('#isiberita').summernote('reset');
                        $('#imagev').empty();
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
            });
        });
        
        $("#btn-cari").click(function(){
            let search = $("#cari").val();
            Tnews.draw();
        });
        
        $("#Tnews tbody").on('click','.btnUpdate',function(){
            let data = Tnews.row( $(this).parents('tr') ).data();
            let idData = data.id;
            $.ajax({
                url:"{{ URL::route('editor.news.detail') }}",
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id': idData
                },
                dataType: "JSON",
                cache: false,
                beforeSend: function(){
                    $('.loading-clock').css('display','flex');
                },
                success: function(data) {
                    if(data.success == 1){
                        let newsData = data.data;
                        $("#updateForm #imagev_update").empty().append('<img id="img_current" class="img-fluid rounded" src="{{ asset("storage") }}/'+newsData.image+'" style="max-height: 300px;">');
                        $("#updateForm #id_update").val(newsData.id);
                        $("#updateForm #judul_update").val(newsData.judul);
                        $("#updateForm #isiberita_update").summernote('code', newsData.isiberita);
                        $("#updateForm #tanggal_publish_update").val(newsData.tanggal_publish);
                        $("#updateForm #is_active_update").val(newsData.is_active);
                        $("#updateModal").modal("show");
                    } else {
                        toastr_error(data.messages);
                    }
                },
                complete: function(){
                    $('.loading-clock').css('display','none');
                },
            });
        });
        
        $("#proses_update").click(function(){
            // Get summernote content
            var isiberitaUpdate = $('#isiberita_update').summernote('code');
            
            var postData = new FormData($("#updateForm")[0]);
            // Make sure to set the summernote content
            postData.set('isiberita', isiberitaUpdate);
            
            $.ajax({
                url:"{{ URL::route('editor.news.update') }}",
                data:postData,
                type:"POST",
                dataType:"JSON",
                cache:false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('.loading-clock').css('display','flex');
                },
                success:function(data){
                    if(data.success == 1){
                        $('#updateForm')[0].reset();
                        $('#isiberita_update').summernote('reset');
                        $('#imagev_update').empty();
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
            });
        });
        
        $("#Tnews tbody").on('click','.btnDelete',function(){
            let data = Tnews.row( $(this).parents('tr') ).data();
            let idData = data.id;
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data berita akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{ URL::route('editor.news.delete') }}",
                        type: "DELETE",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'id': idData
                        },
                        dataType: "JSON",
                        cache: false,
                        beforeSend: function(){
                            $('.loading-clock').css('display','flex');
                        },
                        success: function(data) {
                            if(data.success == 1){
                                toastr_success(data.messages);
                                redraw();
                            } else {
                                toastr_error(data.messages);
                            }
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
        
        // Search on Enter key
        $("#cari").keypress(function(e) {
            if(e.which == 13) {
                $("#btn-cari").click();
                e.preventDefault();
            }
        });
        
        // Handle modal close events to prevent summernote issues
        $('#addModal').on('hidden.bs.modal', function () {
            $('#isiberita').summernote('reset');
        });
        
        $('#updateModal').on('hidden.bs.modal', function () {
            $('#isiberita_update').summernote('reset');
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