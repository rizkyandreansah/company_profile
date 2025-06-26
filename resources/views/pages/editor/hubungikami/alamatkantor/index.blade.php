@extends('layouts.editor')
@section('title')
    Alamat Kantor
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Alamat Kantor</h1>
        
        <form action="" id="form_cari" method="post">
            @csrf
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Cari alamat, telepon, email, atau link maps" name="cari" id="cari">
                <div class="input-group-append">
                    <button type="button" id="add_new" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Add</button>
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
<form id="addForm" method="post">
    @csrf
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add new Alamat Kantor</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Alamat</label>
                        <textarea id="alamat" name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">No. Telepon</label>
                                <input type="text" id="no_telepon" name="no_telepon" class="form-control" placeholder="Contoh: 021-1234567">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Contoh: info@perusahaan.com">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Link Google Maps</label>
                        <textarea id="link_maps" name="link_maps" class="form-control" rows="2" placeholder="Masukkan link Google Maps (untuk menampilkan maps)"></textarea>
                        <small class="form-text text-muted">Contoh: https://goo.gl/maps/... atau embed link dari Google Maps</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="button" id="proses_add" class="btn btn-primary">Save</button>
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
                    <h5 class="modal-title">Update Alamat Kantor</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Alamat</label>
                        <input type="hidden" id="id_update" name="id" class="form-control">
                        <textarea id="alamat_update" name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">No. Telepon</label>
                                <input type="text" id="no_telepon_update" name="no_telepon" class="form-control" placeholder="Contoh: 021-1234567">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" id="email_update" name="email" class="form-control" placeholder="Contoh: info@perusahaan.com">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Link Google Maps</label>
                        <textarea id="link_maps_update" name="link_maps" class="form-control" rows="2" placeholder="Masukkan link Google Maps (opsional)"></textarea>
                        <small class="form-text text-muted">Contoh: https://goo.gl/maps/... atau embed link dari Google Maps</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="button" id="proses_update" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('script')
<script>
    $('document').ready(function(e){
        var TalamatKantor = $('#TalamatKantor').DataTable({
            "responsive": true,
            'searching': false,
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "paging":true,
            "ajax":{
                "url":"{{ route('editor.alamat-kantor.data') }}",
                "data":function(parm){
                    parm.search = function(){
                        return $('#cari').val()
                    }
                },
            },
            "columns":[
                {
                    "data": "alamat","orderable":false,
                    render: function(data, type, row) {
                        return data.length > 50 ? data.substring(0, 50) + '...' : data;
                    }
                },
                {"data": "no_telepon","orderable":false},
                {"data": "email","orderable":false},
                {
                    "data": "link_maps","orderable":false,
                    render: function(data, type, row) {
                        if (data && data.trim() !== '') {
                            return '<a href="' + data + '" target="_blank" class="btn btn-sm btn-info">View Map</a>';
                        } else {
                            return '<span class="text-muted">-</span>';
                        }
                    }
                },
                {
                    "data": "id","orderable":false,render: function ( data, type, row ){
                        var idData = row.id;
                        let btn ='<div class="btn-group" role="group" aria-label="Basic example">';
                        btn += '<button type="button" class="btn btn-warning btnUpdate">Update</button>';
                        btn += '<button type="button" class="btn btn-danger btnDelete">Delete</button>';
                        btn += '</div>';
                        return btn;
                    }
                },
            ]
        });
        
        function redraw(){
            TalamatKantor.draw();
        }
        
        $("#add_new").click(function(){
            $("#addModal").modal("show");
        });
        
        $("#proses_add").click(function(){
            var postData = new FormData($("#addForm")[0]);
            $.ajax({
                url:"{{ URL::route('editor.alamat-kantor.store') }}",
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
                        // Reset form
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
            });
        });
        
        $("#btn-cari").click(function(){
            let search = $("#cari").val();
            TalamatKantor.draw();
        });
        
        $("#TalamatKantor tbody").on('click','.btnUpdate',function(){
            let data = TalamatKantor.row( $(this).parents('tr') ).data();
            let idData = data.id;
            $.ajax({
                url:"{{ URL::route('editor.alamat-kantor.detail') }}",
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
                        let id = data.data.id;
                        let alamat = data.data.alamat;
                        let no_telepon = data.data.no_telepon;
                        let email = data.data.email;
                        let link_maps = data.data.link_maps;
                        
                        $("#id_update").val(id);
                        $("#alamat_update").val(alamat);
                        $("#no_telepon_update").val(no_telepon);
                        $("#email_update").val(email);
                        $("#link_maps_update").val(link_maps);
                        
                        $("#updateModal").modal("show");
                    } else{
                        toastr_error(data.messages);
                    }
                },
                complete: function(){
                    $('.loading-clock').css('display','none');
                },
            })
        });
        
        $("#proses_update").click(function(){
            var postData = new FormData($("#updateForm")[0]);
            $.ajax({
                url:"{{ URL::route('editor.alamat-kantor.update') }}",
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
        
        $("#TalamatKantor tbody").on('click','.btnDelete',function(){
            let data = TalamatKantor.row( $(this).parents('tr') ).data();
            let idData = data.id;
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{ URL::route('editor.alamat-kantor.delete') }}",
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
                            } else{
                                toastr_error(data.messages);
                            }
                        },
                        complete: function(){
                            $('.loading-clock').css('display','none');
                        },
                    }); 
                }
            });
        });
        
        function toastr_success(msg){
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: msg
            });
        }
        
        function toastr_error(msg){
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                title: msg
            });
        }
    });
</script>
@endsection